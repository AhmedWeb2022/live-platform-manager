<?php

namespace ahmedWeb\LivePlatformManager\Params;

use Carbon\Carbon;
use Exception;
use ahmedWeb\LivePlatformManager\Response\DataFailed;
use ahmedWeb\LivePlatformManager\Response\DataStatus;
use ahmedWeb\LivePlatformManager\Response\DataSuccess;

/**
 * Class ZoomIntegerationParam
 *
 * Handles the preparation of parameters for Zoom integration, including creating and storing live session details.
 */
class ZoomIntegerationParam
{
    /**
     * Create live session parameters for Zoom.
     *
     * @param array $data The data containing session details.
     * @return DataStatus An instance of either DataSuccess or DataFailed, indicating the result of the operation.
     *
     * @description This method prepares the request body for creating a live session in Zoom.
     * If the operation is successful, it returns a `DataSuccess` object with the request body.
     * In case of an exception, it returns a `DataFailed` object with the error message.
     */
    public function create_live_param(array $data): DataStatus
    {
        try {
            // dd($data);
            $body = [
                'topic' => $data['name'],
                'start_time' => Carbon::parse($data['start_time'])->format('Y-m-d\TH:i:00\Z'),
                'agenda' => $data['description'],
                'duration' => $data['duration'],
            ];
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
            // dd($data);
            $params = [
                'platform_id' => $data['relations']['platform']?->id,
                'live_account_id' => $data['relations']['live_account']->id,
                'platform_related_data' => json_encode($data['session']['platform_session_related_data'], true),
                'platform_session_id' => $data['session']['id'],
                'start_time' => $data['session']['start_time'],
                'end_time' => $data['session']['end_time'],
                'start_date' => $data['session']['start_date'],
                'end_date' => $data['session']['end_date'],
                'duration' => $data['session']['duration'],
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

    /**
     * Store live session parameters for Zoom.
     *
     * @param array $data The data containing Zoom meeting details.
     * @return DataStatus An instance of either DataSuccess or DataFailed, indicating the result of the operation.
     *
     * @description This method processes and stores the parameters returned from a Zoom API response.
     * If the operation is successful, it returns a `DataSuccess` object with the processed data.
     * In case of an exception, it returns a `DataFailed` object with the error message.
     */
    public function store_live_params($data): DataStatus
    {
        try {
            // dd($data);
            $body = [
                'platform_id' => $data['session']->platform?->id,
                'live_account_id' => $data['session']->live_account->id,
                'session_id' => $data['session']->id,
                'uuid' => $data['body']['uuid'],
                'zoom_id' => $data['body']['id'],
                'host_id' => $data['body']['host_id'],
                'host_email' => $data['body']['host_email'],
                'topic' => $data['body']['topic'],
                'type' => $data['body']['type'],
                'status' => $data['body']['status'],
                'start_time' => Carbon::parse($data['body']['start_time'])->format('Y-m-d H:i:s'),
                'duration' => $data['body']['duration'],
                'timezone' => $data['body']['timezone'],
                'agenda' => $data['body']['agenda'],
                'start_url' => $data['body']['start_url'],
                'join_url' => $data['body']['join_url'],
                'password' => $data['body']['password'],
                'h323_password' => $data['body']['h323_password'],
                'pstn_password' => $data['body']['pstn_password'],
                'encrypted_password' => $data['body']['encrypted_password'],
            ];
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
}
