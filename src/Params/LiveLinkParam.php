<?php

namespace ahmedWeb\LivePlatformManager\Params;

use Exception;
use ahmedWeb\LivePlatformManager\Enums\PlatformTypeEnum;
use ahmedWeb\LivePlatformManager\Response\DataFailed;
use ahmedWeb\LivePlatformManager\Response\DataStatus;
use ahmedWeb\LivePlatformManager\Response\DataSuccess;

/**
 * Class LiveLinkParam
 *
 * Handles the preparation of parameters for live session links.
 */
class LiveLinkParam
{
    /**
     * Store live session parameters.
     *
     * @param array $data The data containing live session details.
     * @return DataStatus An instance of either DataSuccess or DataFailed, indicating the result of the operation.
     *
     * @description This method prepares the parameters required for storing a live session link.
     * If the operation is successful, it returns a `DataSuccess` object with the platform type and live link.
     * If an exception occurs, it returns a `DataFailed` object with the error message.
     */
    public function store_live_params($data): DataStatus
    {
        try {
            // Prepare the data with platform type and live link
            $data = [
                'platform_type' => PlatformTypeEnum::LiveLink->value,
                'live_link' => $data['data']['liveLink'],
            ];

            // Return a success response
            return new DataSuccess(
                status: true,
                data: $data,
                message: 'Meeting created successfully'
            );
        } catch (Exception $e) {
            // Return a failed response with the exception message
            return new DataFailed(
                status: false,
                message: $e->getMessage()
            );
        }
    }
}
