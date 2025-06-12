<?php


namespace ahmedWeb\LivePlatformManager\Services;

use Exception;
use ahmedWeb\LivePlatformManager\Response\DataStatus;
use ahmedWeb\LivePlatformManager\Models\Session\Session;
use ahmedWeb\LivePlatformManager\Response\DataFailed;
use ahmedWeb\LivePlatformManager\Response\DataSuccess;

class SessionService
{
    public function store_session(array $data): DataStatus
    {
        try {
            $session_data['platform_id'] = $data['platform_id'];
            $session_data['live_account_id'] = $data['live_account_id'];
            $session_data['platform_related_data'] = $data['platform_related_data'];
            $session_data['platform_session_id'] = $data['platform_session_id'];
            $session_data['start_time'] = $data['start_time'];
            $session_data['end_time'] = $data['end_time'];
            $session_data['start_date'] = $data['start_date'];
            $session_data['end_date'] = $data['end_date'];
            $session_data['duration'] = $data['duration'] ?? 0;
            $session = Session::create($session_data);
            return new DataSuccess(
                status: true,
                data: $session,
                message: 'Session created successfully'
            );
        } catch (Exception $e) {
            return new DataFailed(
                status: false,
                message: $e->getMessage()
            );
        }
    }
}
