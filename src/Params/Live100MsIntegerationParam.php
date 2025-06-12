<?php

namespace ahmedWeb\LivePlatformManager\Params;

use Exception;
use ahmedWeb\LivePlatformManager\Response\DataFailed;
use ahmedWeb\LivePlatformManager\Response\DataStatus;
use ahmedWeb\LivePlatformManager\Response\DataSuccess;

/**
 * Class Live100MsIntegerationParam
 *
 * Handles parameter preparation for live session operations, including creating and storing live session data.
 */
class Live100MsIntegerationParam
{
    /**
     * @var string $title Title of the live session.
     * @var string $description Description of the live session.
     * @var bool $recording Indicates whether the session recording is enabled.
     * @var string $room_id The unique identifier for the room.
     * @var string $session_id The unique identifier for the session.
     * @var string $group_id The identifier for the group associated with the session.
     * @var string $region The geographical region of the live session.
     * @var string $name The name of the session or room.
     * @var bool $enabled Indicates whether the session is enabled.
     * @var bool $large_room Indicates whether the session uses a large room setup.
     * @var string $host_code The code for the session host.
     * @var string $guest_code The code for session guests.
     */
    protected $title;
    protected $description;
    protected $recording;
    protected $room_id;
    protected $session_id;
    protected $group_id;
    protected $region;
    protected $name;
    protected $enabled;
    protected $large_room;
    protected $host_code;
    protected $guest_code;

    /**
     * Prepare parameters for creating a live session.
     *
     * @param array $data The input data required to create a live session.
     * @return DataStatus Returns a success or failure response containing the prepared body or an error message.
     *
     * @description Constructs the body for creating a live session, including name, description, and recording status.
     */
    public function create_live_param(array $data): DataStatus
    {
        try {
            // dd($data);
            $body = [
                "name" => $data['name'],
                "description" => $data['description'],
                "recording" => false
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
     * Prepare parameters for storing live session data.
     *
     * @param array $data The input data required to store live session details.
     * @return DataStatus Returns a success or failure response containing the prepared body or an error message.
     *
     * @description Constructs the body for storing live session details, such as room ID, session ID, name, description,
     * recording settings, region, and host/guest codes.
     */
    public function store_live_params($data): DataStatus
    {
        try {
            // dd($data);
            $body['room_id'] = $data['body']['id'];
            $body['platform_id'] = $data['session']->platform->id;
            $body['live_account_id'] = $data['session']->live_account->id;
            $body['session_id'] = $data['session']->id;
            $body['name'] = $data['body']['name'];
            $body['description'] = $data['body']['description'];
            $body['enabled'] = $data['body']['enabled'];
            $body['recording'] = $data['body']['recording_info']['enabled'];
            $body['region'] = $data['body']['region'];
            $body['large_room'] = $data['body']['large_room'];

            // Assign host and guest codes based on role
            if ($data['body']['data'][0]['role'] == 'host') {
                $body['host_code'] = $data['body']['data'][0]['code'];
                $body['guest_code'] = $data['body']['data'][1]['code'];
            } else {
                $body['host_code'] = $data['body']['data'][1]['code'];
                $body['guest_code'] = $data['body']['data'][0]['code'];
            }
            // dd($body);
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

    public function store_session_params(array $data): DataStatus
    {
        try {
            // dd($data['session']['platform_session_related_data']);
            // $js = json_encode($data['session']['platform_session_related_data'], true);
            // dd($js);

            $params = [
                'platform_id' => $data['relations']['platform']->id,
                'live_account_id' => $data['relations']['live_account']->id,
                'platform_related_data' => json_encode($data['session']['platform_session_related_data'], true),
                'platform_session_id' => $data['session']['id'],
                'start_time' => $data['session']['start_time'],
                'end_time' => $data['session']['end_time'],
                'start_date' => $data['session']['start_date'],
                'end_date' => $data['session']['end_date'],
            ];
            // dd($params);

            return new DataSuccess(
                status: true,
                data: $params,
                message: 'Body created successfully'
            );
        } catch (Exception $e) {
            return new DataFailed(
                status: false,
                message: $e->getMessage()
            );
        }
    }
}
