<?php

namespace ahmedWeb\LivePlatformManager\Services;

use Exception;
use ahmedWeb\LivePlatformManager\Enums\PlatformTypeEnum;
use ahmedWeb\LivePlatformManager\Interfaces\LiveIntegerationInterface;
use ahmedWeb\LivePlatformManager\Response\DataFailed;
use ahmedWeb\LivePlatformManager\Response\DataStatus;
use ahmedWeb\LivePlatformManager\Response\DataSuccess;

/**
 * Class LiveLinkService
 *
 * Implements live integration for the LiveLink platform.
 * Provides methods for creating live sessions, storing live session data, and joining live sessions.
 */
class LiveLinkService implements LiveIntegerationInterface
{
    /**
     * @description Create a live session (Currently not implemented).
     *
     * @param array $data Data required to create a live session (to be implemented).
     */
    public function create_live(array $data)
    {
        // TODO: Implement create_live() method.
    }

    /**
     * @description Prepare the body of the request (Currently empty method).
     *
     * @param array $body Data to be included in the body of the request (empty implementation).
     */
    public function prepare_body(array $body) {}

    /**
     * @description Store live session data in the session.
     *
     * Updates the session with the platform type and live link.
     *
     * @param array $data Contains session data and live link information.
     * @return DataStatus Success or failure status with a message.
     */
    public function store_live($data): DataStatus
    {
        try {
            // Update the session with the live link and platform type
            $data['session']->update([
                'platform_type' =>  $data['data']['platform_type'],
                'live_link' => $data['data']['live_link']
            ]);

            // Return success status
            return new DataSuccess(
                status: true,
                message: 'Meeting created successfully'
            );
        } catch (Exception $e) {
            // Return failure status in case of an error
            return new DataFailed(
                status: false,
                message: $e->getMessage()
            );
        }
    }

    /**
     * @description Join a live session by retrieving the live link from the session.
     *
     * @param array $data Contains session information for joining the live session.
     * @return DataStatus Success or failure status with live link data or error message.
     */
    public function join_live(array $data): DataStatus
    {
        try {
            // Retrieve the live link from the session
            $live_link = $data['session']->live_link;

            // Return success status with the live link
            return new DataSuccess(
                status: true,
                data: $live_link,
                message: 'Room created successfully'
            );
        } catch (Exception $e) {
            // Return failure status in case of an error
            return new DataFailed(
                status: false,
                message: $e->getMessage()
            );
        }
    }
}
