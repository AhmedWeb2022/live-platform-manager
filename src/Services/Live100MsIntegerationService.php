<?php

namespace ahmedWeb\LivePlatformManager\Services;

use ahmedWeb\LivePlatformManager\Models\Live100MSRoom;
use ahmedWeb\LivePlatformManager\Models\Session\Session;
use Exception;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Http;
use ahmedWeb\LivePlatformManager\Enums\PlatformTypeEnum;
use Monolog\DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use ahmedWeb\LivePlatformManager\Interfaces\LiveIntegerationInterface;
use ahmedWeb\LivePlatformManager\Models\Live100msMeeting\Live100msMeeting;
use ahmedWeb\LivePlatformManager\Models\LiveAcount\LiveAccount;
use ahmedWeb\LivePlatformManager\Response\DataFailed;
use ahmedWeb\LivePlatformManager\Response\DataStatus;
use ahmedWeb\LivePlatformManager\Response\DataSuccess;

/**
 * Class Live100MsIntegerationService
 *
 * Handles integration with the 100ms.live API, providing methods for room creation, token generation,
 * and retrieving room codes. It supports operations such as preparing and storing live session details.
 */
class Live100MsIntegerationService implements LiveIntegerationInterface
{
    /**
     * @var string $App_key Application key for 100ms API.
     */
    protected $App_key;

    /**
     * @var string $App_secret Application secret for 100ms API.
     */
    protected $App_secret;

    /**
     * @var object $live_account Live account details.
     */
    protected  $live_account;

    /**
     * @var string $create_meeting_url URL for creating a meeting.
     *
     */
    protected  $create_meeting_url;
    /**
     * @var string $create_code_url URL for creating a code.
     *
     */
    protected  $create_code_url;

    /**
     * @var string $token Token for authentication.
     *
     */
    protected  $token;
    /**
     * @var array $headers Headers for API requests.
     *
     */
    protected  $headers;


    /**
     * Constructor to initialize API credentials.
     */
    public function __construct(LiveAccount $live_account)
    {
        $this->live_account = $live_account;

        // Ensure required LiveAccount values are set
        $this->App_key = getValueOrFail($this->live_account->client_id, '100ms.client_id');
        $this->App_secret = getValueOrFail($this->live_account->client_secret, '100ms.client_secret');

        // Load and validate configuration values
        $this->create_meeting_url = getConfigOrFail('services.100ms.CREATE_MEETING_URL');
        $this->create_code_url = getConfigOrFail('services.100ms.CREATE_CODE_URL');
        $this->headers = getConfigOrFail('services.100ms.HEADERS');

        // Generate token and inject it into the Authorization header
        $this->token = $this->generate_token();
        $this->headers['Authorization'] = str_replace('{{token}}', $this->token, $this->headers['Authorization']);
    }


    /**
     * @description Create a new room on the 100ms.live platform.
     *
     * @param array $body Request body containing room details.
     * @return DataStatus Success or failure status with relevant data or error message.
     */
    public function create_live($body): DataStatus
    {
        try {
            // $token = $this->generate_token();

            // $headers = [
            //     'Authorization' => 'Bearer ' . $token,
            //     'Content-Type' => 'application/json',
            // ];
            // dd($body);
            $room_response = Http::withHeaders($this->headers)->post($this->create_meeting_url, $body)->json();
            // dd($room_response);
            $code_request = $this->get_room_code($room_response['id']);
            // dd($code_request);
            $response = array_merge($room_response, $code_request);
            // dd($response);
            return new DataSuccess(
                status: true,
                data: $response,
                message: 'Room created successfully'
            );
        } catch (Exception $e) {
            return new DataFailed(
                status: false,
                message: $e->getMessage()
            );
        }
    }

    /**
     * @description Prepare request body for room creation.
     *
     * @param array $data Room data such as name and description.
     * @return DataStatus Success or failure status with prepared body or error message.
     */
    public function prepare_body($data): DataStatus
    {
        try {
            $body = [
                "name" => $data['name'],
                "description" => $data['description'],
                "recording_info" => [
                    "enabled" => $data['recording'],
                ],
            ];

            return new DataSuccess(
                status: true,
                data: $body,
                message: 'Body created successfully'
            );
        } catch (Exception $e) {
            return new DataFailed(
                status: false,
                message: $e->getMessage()
            );
        }
    }

    /**
     * @description Store room details in the database.
     *
     * @param array $data Data containing session and room details.
     * @return DataStatus Success or failure status.
     */
    public function store_live($data): DataStatus
    {
        try {
            $attributes = [
                // 'group_id' => $data['session']->group->id,
                'session_id' => $data['session']->id,
            ];
            // dd($data['body']);
            Live100msMeeting::updateOrCreate($attributes, $data['body']);

            // $data['session']->update([
            //     'platform_type' => PlatformTypeEnum::LIVE100MS->value,
            // ]);

            return new DataSuccess(
                status: true,
                message: 'Meeting created successfully'
            );
        } catch (Exception $e) {
            return new DataFailed(
                status: false,
                message: $e->getMessage()
            );
        }
    }

    /**
     * @description Generate a join URL for a live session.
     *
     * @param array $data Data containing session and user details.
     * @return DataStatus Success or failure status with join URL or error message.
     */
    public function join_live($data): DataStatus
    {
        try {
            $liveUrl = sprintf(
                "https://live.success.sa/?roomId=%s&userName=%s&userId=%d&sessionId=%d&type=%s",
                urlencode($data['session']->live100MSRooms()->first()->guest_code),
                urlencode($data['user']->name),
                $data['user']->id,
                $data['session']->id,
                urlencode($data['data']['type'])
            );

            return new DataSuccess(
                status: true,
                data: $liveUrl,
                message: 'Join URL generated successfully'
            );
        } catch (Exception $e) {
            return new DataFailed(
                status: false,
                message: $e->getMessage()
            );
        }
    }

    /**
     * @description Generate a JWT token for authenticating with 100ms API.
     *
     * @return string Generated JWT token.
     */
    private function generate_token()
    {
        $issuedAt = new DateTimeImmutable('now');
        $expire = $issuedAt->modify('+24 hours')->getTimestamp();
        // dd($this->App_secret);

        $payload = [
            'access_key' => $this->App_key,
            'type' => 'management',
            'version' => 2,
            'jti' => Uuid::uuid4()->toString(),
            'iat' => $issuedAt->getTimestamp(),
            'nbf' => $issuedAt->getTimestamp(),
            'exp' => $expire,
        ];

        return JWT::encode($payload, $this->App_secret, 'HS256');
    }

    /**
     * @description Retrieve the room code for a specific room ID.
     *
     * @param string $room_id The ID of the room for which to retrieve the code.
     * @return array The response from the API, containing the room code details.
     */
    private function get_room_code($room_id)
    {
        // $token = $this->generate_token();

        // $headers = [
        //     'Authorization' => 'Bearer ' . $token,
        //     'Content-Type' => 'application/json',
        // ];

        $response = Http::withHeaders($this->headers)->post($this->create_code_url . $room_id);

        return $response->json();
    }
}
