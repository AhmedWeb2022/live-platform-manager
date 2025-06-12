<?php

namespace ahmedWeb\LivePlatformManager\Services;

use ahmedWeb\LivePlatformManager\Models\Session\Session;
use ahmedWeb\LivePlatformManager\Models\User;
use ahmedWeb\LivePlatformManager\Models\ZoomMeeting\ZoomMeeting;
use ahmedWeb\LivePlatformManager\Interfaces\LiveIntegerationInterface;
use ahmedWeb\LivePlatformManager\Response\DataStatus;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Exception;
use ahmedWeb\LivePlatformManager\Enums\PlatformTypeEnum;
use ahmedWeb\LivePlatformManager\Models\LiveAcount\LiveAccount;
use ahmedWeb\LivePlatformManager\Response\DataFailed;
use ahmedWeb\LivePlatformManager\Response\DataSuccess;
use Firebase\JWT\JWT;

class ZoomIntegerationService implements LiveIntegerationInterface
{
    // Protected variables to store API credentials and URLs
    protected $clientId;
    protected $clientSecret;
    protected $accountId;
    protected $tokenUrl;
    protected $CreateMeetingUrl;
    protected $DeleteMeetingUrl;
    protected $UpdateMeetingUrl;
    protected $SdkKey;
    protected $SdkSecret;
    protected $live_account;
    protected $headers;
    protected $credentials;
    protected $data;
    protected $token;

    /**
     * Constructor for the class.
     * Initializes Zoom API credentials from environment variables.
     */
    public function __construct(LiveAccount $liveAccount)
    {
        $this->live_account = $liveAccount;

        $this->clientId = getValueOrFail($liveAccount->client_id, 'client_id');
        $this->clientSecret = getValueOrFail($liveAccount->client_secret, 'client_secret');
        $this->accountId = getValueOrFail($liveAccount->account_id, 'account_id');
        $this->SdkKey = getValueOrFail($liveAccount->sdk_key, 'sdk_key');
        $this->SdkSecret = getValueOrFail($liveAccount->sdk_secret, 'sdk_secret');

        $this->tokenUrl = getConfigOrFail('services.zoom.TOKEN_URL');
        $this->CreateMeetingUrl = getConfigOrFail('services.zoom.CREATE_MEETING_URL');
        $this->DeleteMeetingUrl = getConfigOrFail('services.zoom.DELETE_MEETING_URL');
        $this->UpdateMeetingUrl = getConfigOrFail('services.zoom.UPDATE_MEETING_URL');
        $this->headers = getConfigOrFail('services.zoom.HEADERS');
        $this->data = getConfigOrFail('services.zoom.DATA');

        $this->credentials = base64_encode("{$this->clientId}:{$this->clientSecret}");
        $this->headers['Authorization'] = str_replace('{{credentials}}', $this->credentials, $this->headers['Authorization']);
        $this->data['account_id'] = str_replace('{{account_id}}', $this->accountId, $this->data['account_id']);

        $this->token = $this->get_token();
    }


    /**
     * Creates a Zoom meeting using the provided body data.
     *
     * @param array $body The body data for creating the meeting.
     * @return DataStatus Success or Failure response.
     */
    public function create_live($body): DataStatus
    {
        try {
            // Make the API request to create the meeting
            // dd($body , $this->CreateMeetingUrl , $this->token);
            $response = Http::withToken($this->token)->post($this->CreateMeetingUrl, $body);
            // dd($response->json());
            // Return a success response with the meeting data
            return new DataSuccess(
                data: $response->json(),
                status: true,
                message: 'Meeting created successfully'
            );
        } catch (Exception $e) {
            // Return a failure response with the error message
            return new DataFailed(
                status: false,
                message: $e->getMessage()
            );
        }
    }


    public function delete_live($data): DataStatus
    {
        try {
            // dd($this->DeleteMeetingUrl);
            // dd($data);
            // Make the API request to delete the meeting
            $response = Http::withToken($this->token)
                ->delete("{$this->DeleteMeetingUrl}/{$data['meeting']->zoom_id}");

            if ($response->successful()) {
                // $data['session']->delete();
                return new DataSuccess(
                    status: true,
                    message: 'Meeting deleted successfully'
                );
            } else {
                return new DataFailed(
                    status: false,
                    message: $response->body()
                );
            }
            // Return a success response with the meeting data
            return new DataSuccess(
                data: $response->json(),
                status: true,
                message: 'Meeting deleted successfully'
            );
        } catch (Exception $e) {
            // Return a failure response with the error message
            return new DataFailed(
                status: false,
                message: $e->getMessage()
            );
        }
    }

    public function end_meeting($data): DataStatus
    {
        try {
            // dd($data['meeting']->zoom_id);
            $meeting_id = $data['meeting']->zoom_id;
            $end_meeting_url = str_replace('{{ meetingId }}', $meeting_id, $this->UpdateMeetingUrl);
            // dd($end_meeting_url);
            $data = [
                'action' => 'end'
            ];
            $response = Http::withToken($this->token)
                ->put($end_meeting_url, $data);

            if ($response->successful()) {
                // dd('done', $response->json());
                return new DataSuccess(
                    status: true,
                    message: 'Meeting ended successfully'
                );
            } else {
                // dd('error', $response->json());
                return new DataFailed(
                    status: false,
                    message: $response->body()
                );
            }
        } catch (Exception $e) {
            return new DataFailed(
                status: false,
                message: $e->getMessage()
            );
        }
    }

    /**
     * Stores or updates the Zoom meeting details in the database.
     *
     * @param array $data Data containing session information and body data.
     * @return DataStatus Success or Failure response.
     */
    public function store_live($data): DataStatus
    {
        try {
            // Prepare the attributes to find or create the Zoom meeting record
            $attributes = [
                'session_id' => $data['session']->id,
            ];
            // Store or update the Zoom meeting in the database
            $zoom = ZoomMeeting::UpdateOrCreate($attributes, $data['body']);

            // Update the session with the platform type
            // $data['session']->update([
            //     'platform_type' => PlatformTypeEnum::ZOOM->value,
            // ]);

            // Return a success response with the Zoom meeting data
            return new DataSuccess(
                data: $zoom,
                status: true,
                message: 'Meeting created successfully'
            );
        } catch (Exception $e) {
            // Return a failure response with the error message
            return new DataFailed(
                status: false,
                message: $e->getMessage()
            );
        }
    }

    /**
     * Prepares the body data required for creating a Zoom meeting.
     *
     * @param array $data Data containing meeting details.
     * @return DataStatus Success or Failure response with the body data.
     */
    public function prepare_body($data): DataStatus
    {
        // dd($data);
        try {
            // Prepare the body for the Zoom API request
            $body = [
                'topic' => $data['topic'],
                'type' => 2,  // Scheduled meeting
                'start_time' => $data['start_time'], // ISO 8601 format with 'Z' timezone
                'duration' => $data['duration'], // Duration in minutes
                'default_password' => false,
                'password' => 123123123, // Random 6-digit password
                'timezone' => 'Asia/Riyadha',
                'agenda' => $data['agenda'],
                'settings' => [
                    // Various settings for the Zoom meeting
                    'host_video' => true,
                    'participant_video' => true,
                    'join_before_host' => true,
                    'mute_upon_entry' => true,
                    'audio' => 'voip',
                    'auto_recording' => 'none',
                    'waiting_room' => false,
                ],
            ];
            // dd($body);

            // Return a success response with the body data
            return new DataSuccess(
                data: $body,
                status: true,
                message: 'body created successfully'
            );
        } catch (Exception $e) {
            // Return a failure response with the error message
            return new DataFailed(
                status: false,
                message: $e->getMessage()
            );
        }
    }

    /**
     * Generates the Zoom meeting join URL with signature.
     *
     * @param array $data Data containing session and user information.
     * @return DataStatus Success or Failure response with the generated URL.
     */
    public function join_live($data): DataStatus
    {
        try {
            // Generate the Zoom signature for joining the meeting
            $signature = $this->generateSignature($data['session']->zoom_meetings()->first()->zoom_id, $data['data']['role']);

            // Generate the live session URL
            $liveUrl = sprintf(
                "https://live.success.sa/?user=%d&sessionId=%d&userId=%s",
                urlencode($data['data']['role']),
                urlencode($data['session']->id),
                urlencode($data['user']->id)
            );

            // Return a success response with the live URL
            return new DataSuccess(
                status: true,
                data: $liveUrl,
                message: 'Room created successfully'
            );
        } catch (Exception $e) {
            // Return a failure response with the error message
            return new DataFailed(
                status: false,
                message: $e->getMessage()
            );
        }
    }

    /**
     * Fetches the Zoom API token using client credentials.
     *
     * @return string The access token for Zoom API requests.
     */
    private function get_token()
    {
        // Prepare the credentials for Zoom API authentication


        // Request data for the token
        // $data = [
        //     'grant_type' => 'account_credentials',
        //     'account_id' => $this->accountId,
        // ];

        try {
            // dd($this->headers);
            // Make the HTTP request to fetch the token
            $response = Http::withHeaders($this->headers)->asForm()->post($this->tokenUrl, $this->data);
            // dd($response->json());
            // Check if the response is successful and return the token
            if ($response->successful()) {
                return $response->json()['access_token'];
            } else {
                // Handle the error response
                return [
                    'error' => true,
                    'message' => $response->body(),
                ];
            }
        } catch (\Exception $e) {
            // Handle exceptions
            return [
                'error' => true,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Generates a JWT signature for Zoom meeting join.
     *
     * @param string $meeting_number The Zoom meeting ID.
     * @param int $role The user's role (host or participant).
     * @return string The generated JWT signature.
     */
    private function generateSignature($meeting_number, $role)
    {
        $iat = time(); // Issued at time
        $exp = $iat + 60 * 60 * 2; // Expiration time (2 hours)

        // Prepare the token payload
        $token_payload = [
            'appKey' => $this->SdkKey,
            'sdkKey' => $this->SdkKey,
            'mn' => $meeting_number,
            'role' => $role,
            'iat' => $iat,
            'exp' => $exp,
            'tokenExp' => $exp
        ];

        // Generate the JWT token using the secret key
        $jwt_token = JWT::encode($token_payload, $this->SdkSecret, 'HS256');
        return $jwt_token;
    }

    /**
     * Sends the Zoom meeting configuration details to the user.
     *
     * @param int $role The user's role (host or participant).
     * @param int $session_id The session ID.
     * @param int $user_id The user ID.
     * @return DataStatus Success or Failure response with Zoom config data.
     */
    public function send_zoom_config($data): DataStatus
    {
        try {
            // dd($data);
            // Find the session, Zoom meeting, and user details
            $session = Session::find($data['session_id']);
            $zoom_meeting = $session->zoom_meeting()->first();
            // dd($zoom_meeting);


            // Generate the Zoom signature
            $signature = $this->generateSignature($zoom_meeting->zoom_id, $data['role']);
            // dd($signature);
            // Prepare the response data
            $response = [
                'sdkKey' => $this->SdkKey,
                'signature' => $signature,
                'meeting_number' => $zoom_meeting->zoom_id,
                'password' => $zoom_meeting->password,
                // 'user_name' => $data['user']['name'],
            ];
            // dd($response);
            // Return a success response with the Zoom config data
            return new DataSuccess(
                data: $response,
                status: true,
                message: 'body created successfully'
            );
        } catch (Exception $e) {
            // Return a failure response with the error message
            return new DataFailed(
                status: false,
                message: $e->getMessage()
            );
        }
    }


    public function checkIfHasSessionOnThisTime($data): DataStatus
    {
        try {
            // dd($data['session']['start_time']);
            $exiseted_session = $data['live_account']->sessions()->where('start_time', '>=', $data['session']['start_time'])->where('end_time', '<=', $data['session']['end_time'])->where('start_date', '>=', $data['session']['start_date'])->where('end_date', '<=', $data['session']['end_date'])->first();
            if ($exiseted_session) {
                return new DataSuccess(
                    data: $data['session'],
                    status: true,
                    message: 'this account has session on this time and date try another account for this session'
                );
            }
            return new DataFailed(
                status: false,
                message: 'Session not exist'
            );
        } catch (Exception $e) {
            dd($e);
            return new DataFailed(
                status: false,
                message: $e->getMessage()
            );
        }
    }
}
