<?php

namespace ahmedWeb\LivePlatformManager\Services;

use ahmedWeb\LivePlatformManager\Models\Session\Session;
use Exception;
use ahmedWeb\LivePlatformManager\Enums\PlatformTypeEnum;
use ahmedWeb\LivePlatformManager\Http\Resources\Live\LiveResource;
use ahmedWeb\LivePlatformManager\Http\Resources\LiveAccount\LiveAccountResource;
use ahmedWeb\LivePlatformManager\Http\Resources\Session\SessionResource;
use ahmedWeb\LivePlatformManager\Models\LiveAcount\LiveAccount;
use ahmedWeb\LivePlatformManager\Models\Platform\Platform;
use ahmedWeb\LivePlatformManager\Services\Live100MsIntegerationService;
use ahmedWeb\LivePlatformManager\Services\ZoomIntegerationService;
use ahmedWeb\LivePlatformManager\Services\LiveLinkService;
use ahmedWeb\LivePlatformManager\Params\Live100MsIntegerationParam;
use ahmedWeb\LivePlatformManager\Params\LiveLinkParam;
use ahmedWeb\LivePlatformManager\Params\ZoomIntegerationParam;
use ahmedWeb\LivePlatformManager\Response\DataFailed;
use ahmedWeb\LivePlatformManager\Response\DataStatus;
use ahmedWeb\LivePlatformManager\Response\DataSuccess;

/**
 * Class LiveIntegerationService
 *
 * Handles integration with various live streaming platforms such as 100ms, Zoom, and LiveLink.
 * Provides methods to create live sessions, join live sessions, and fetch configuration for Zoom.
 */
class LiveIntegerationService
{
    /**
     * @var Live100MsIntegerationService $live100_ms_integeration_service Instance of the 100ms live integration service.
     */
    protected $live100_ms_integeration_service;

    /**
     * @var ZoomIntegerationService $zoom_integeration_service Instance of the Zoom live integration service.
     */
    protected $zoom_integeration_service;

    /**
     * @var LiveLinkService $live_link_service Instance of the LiveLink service.
     */
    protected $live_link_service;

    /**
     * @var SessionService $live_link_service Instance of the LiveLink service.
     */
    protected $session_service;

    /**
     * Constructor to initialize services for different platforms.
     *
     * @param Live100MsIntegerationService $live100_ms_integeration_service Instance of 100ms service.
     * @param ZoomIntegerationService $zoom_integeration_service Instance of Zoom service.
     * @param LiveLinkService $live_link_service Instance of LiveLink service.
     * @param SessionService $live_link_service Instance of LiveLink service.
     */
    public function __construct(SessionService $session_service)
    {
        $this->session_service = $session_service;
    }

    public function fetch_live_accounts($request): DataStatus
    {
        try {
            // $platform = Platform::where('code', $request['platform_code'])->first();
            // $live_accounts = $platform->live_accounts;
            $live_accounts = LiveAccount::all();

            return new DataSuccess(
                status: true,
                message: 'Live accounts fetched successfully',
                data: LiveAccountResource::collection($live_accounts)
            );
        } catch (Exception $e) {
            return new DataFailed(
                status: false,
                message: $e->getMessage()
            );
        }
    }

    public function fetch_live($request): DataStatus
    {
        try {
            // dd($request['session_id']);
            $platform = Platform::where('code', $request['platform_code'])->first();
            // dd()
            $session = Session::where('id', $request['session_id'])->where('platform_id', $platform->id)->first();

            // dd($session);
            $live = $request['platform_type'] == PlatformTypeEnum::LIVE100MS->value ? $session->live_100ms : $session->zoom_meeting;
            // dd($live);
            return new DataSuccess(
                status: true,
                message: 'Live sessions fetched successfully',
                data: new LiveResource($live, $request['platform_type'])
            );
        } catch (Exception $e) {
            return new DataFailed(
                status: false,
                message: $e->getMessage()
            );
        }
    }
    public function fetch_live_dev($request): DataStatus
    {
        try {
            // dd($request['session_id']);
            $platform = Platform::where('code', $request['platform_code'])->first();
            // dd()
            $session = Session::where('id', $request['session_id'])->where('platform_id', $platform->id)->first();

            // dd($session);
            $live = $request['platform_type'] == PlatformTypeEnum::LIVE100MS->value ? $session->live_100ms : $session->zoom_meeting;
            // dd($live);
            return new DataSuccess(
                status: true,
                message: 'Live sessions fetched successfully',
                data: new LiveResource($live, $request['platform_type'], true)
            );
        } catch (Exception $e) {
            return new DataFailed(
                status: false,
                message: $e->getMessage()
            );
        }
    }

    /**
     * @description Create a live session on a specific platform (100ms, Zoom, or LiveLink).
     *
     * @param array $data Contains session details such as session IDs.
     * @param string $type Type of platform for live session (100ms, Zoom, or LiveLink).
     * @return DataStatus Success or failure status with relevant data or error message.
     */
    public function create_live(array $data, $type): DataStatus
    {
        try {
            // dd($data , $type);
            // Retrieve sessions based on session IDs provided
            $session = $data['platform_session'];
            $store_response = (object)[];
            $platform = Platform::where('code', $data['platform_code'])->first();
            // dd($platform);
            // Iterate through each session and handle live session creation based on the platform type
            // foreach ($sessions as $session) {
            // dd($session);
            if ($type == PlatformTypeEnum::LIVE100MS->value) {
                $live_account = LiveAccount::where('id', $data['live_account_id'])->where('integeration_type', PlatformTypeEnum::LIVE100MS->value)->first();
                if (!$live_account) {
                    return new DataFailed(
                        status: false,
                        message: 'Live account not found'
                    );
                }
                // Handling 100ms live session creation
                $live100_ms_integeration_service = new Live100MsIntegerationService($live_account);
                $live100_ms_integeration_params = new Live100MsIntegerationParam();
                $params =  $live100_ms_integeration_params->create_live_param($session);
                $body = $live100_ms_integeration_service->prepare_body($params->getData());
                $create_response = $live100_ms_integeration_service->create_live($body->getData());
                // dd($create_response->getData());
                $session_params =  $live100_ms_integeration_params->store_session_params(['session' => $session, 'relations' => ['live_account' => $live_account, 'platform' => $platform]]);
                $session_data = $this->session_service->store_session($session_params->getData());
                // dd($session_data->getData());
                $store_params =  $live100_ms_integeration_params->store_live_params(['body' => $create_response->getData(), 'session' => $session_data->getData()]);
                // dd($store_params->getData());
                $store_response = $live100_ms_integeration_service->store_live(['body' => $store_params->getData(), 'session' => $session_data->getData()]);
                // dd($store_response);
            } elseif ($type == PlatformTypeEnum::ZOOM->value) {
                $live_account = LiveAccount::where('id', $data['live_account_id'])->where('integeration_type', PlatformTypeEnum::ZOOM->value)->first();
                if (!$live_account) {
                    return new DataFailed(
                        status: false,
                        message: 'Live account not found'
                    );
                }
                // dd($live_account);
                // Handling Zoom live session creation
                $zoom_integeration_service = new ZoomIntegerationService($live_account);
                // dd($zoom_integeration_service);
                $zoom_integeration_params = new ZoomIntegerationParam();
                $has_session = $zoom_integeration_service->checkIfHasSessionOnThisTime(['live_account' => $live_account, 'session' => $session]);
                if ($has_session->getStatus()) {
                    return new DataFailed(
                        data: $has_session->getData(),
                        status: false,
                        statusCode: 200,
                        message: $has_session->getMessage()
                    );
                }
                $params =  $zoom_integeration_params->create_live_param($session);
                // dd($params);
                $body = $zoom_integeration_service->prepare_body($params->getData());
                // dd($body->getData());
                $create_response = $zoom_integeration_service->create_live($body->getData());
                // dd($create_response);
                $session_params =  $zoom_integeration_params->store_session_params(['session' => $session, 'relations' => ['live_account' => $live_account, 'platform' => $platform]]);
                // dd($session_params->getData());
                $session_data = $this->session_service->store_session($session_params->getData());
                // dd($session_data);
                $store_params =  $zoom_integeration_params->store_live_params(['body' =>  $create_response->getData(), 'session' => $session_data->getData()]);
                // dd($store_params->getData());
                $store_response = $zoom_integeration_service->store_live(['body' => $store_params->getData(), 'session' => $session_data->getData()]);
            }
            // }

            return new DataSuccess(
                data: new SessionResource($session_data->getData()),
                status: true,
                message: $store_response->getMessage()
            );
        } catch (Exception $e) {
            return new DataFailed(
                status: false,
                message: $e->getMessage()
            );
        }
    }

    public function delete_live(array $data, $type): DataStatus
    {
        try {
            $delete_response = (object)[];
            $platform = Platform::where('code', $data['platform_code'])->first();
            // Generate the appropriate live session join URL based on platform type
            if ($type == PlatformTypeEnum::LIVE100MS->value) {
                $live_account = LiveAccount::where('id', $data['live_account_id'])->where('integeration_type', PlatformTypeEnum::LIVE100MS->value)->first();
                $session = $live_account->sessions()->where('id', $data['session_id'])->first();
                if (!$session) {
                    return new DataFailed(
                        status: false,
                        message: 'Session not found'
                    );
                }
            } elseif ($type == PlatformTypeEnum::ZOOM->value) {
                $live_account = LiveAccount::where('id', $data['live_account_id'])->where('integeration_type', PlatformTypeEnum::ZOOM->value)->first();
                $session = $live_account->sessions()->where('id', $data['session_id'])->first();
                if (!$session) {
                    return new DataFailed(
                        status: false,
                        message: 'Session not found'
                    );
                }
                $meeting = $session->zoom_meeting;
                $zoom_integeration_service = new ZoomIntegerationService($live_account);
                $delete_response = $zoom_integeration_service->delete_live(['session' => $session, 'meeting' => $meeting]);
                $session->delete();
            }

            return new DataSuccess(
                status: true,
                message: $delete_response->getMessage()
            );
        } catch (Exception $e) {
            return new DataFailed(
                status: false,
                message: $e->getMessage()
            );
        }
    }

    /**
     * @description Generate a join URL for a live session on a specific platform.
     *
     * @param array $data Contains session and user details.
     * @param string $type Platform type (100ms, Zoom, or LiveLink).
     * @return DataStatus Success or failure status with the join URL or error message.
     */
    public function join_live(array $data, $type): DataStatus
    {
        try {
            // Retrieve session by session ID and user details
            $session = Session::find($data['session_id']);
            $user = auth()->guard('web')->user();
            $liveUrl = '';

            // Generate the appropriate live session join URL based on platform type
            if ($type == PlatformTypeEnum::LIVE100MS->value) {
                $liveUrl =  $this->live100_ms_integeration_service->join_live(['data' => $data, 'session' => $session, 'user' => $user]);
            } elseif ($type == PlatformTypeEnum::ZOOM->value) {
                $liveUrl =  $this->zoom_integeration_service->join_live(['data' => $data, 'session' => $session, 'user' => $user]);
            } elseif ($type == PlatformTypeEnum::LiveLink->value && $session->live_link != null) {
                $liveUrl =  $this->live_link_service->join_live(['session' => $session]);
            }

            return new DataSuccess(
                status: true,
                data: $liveUrl->getData(),
                message: $liveUrl->getMessage()
            );
        } catch (Exception $e) {
            return new DataFailed(
                status: false,
                message: $e->getMessage()
            );
        }
    }

    /**
     * @description Fetch Zoom configuration for a user in a session.
     *
     * @param array $data Contains role, session ID, and user ID.
     * @return DataStatus Success or failure status with Zoom configuration data or error message.
     */
    public function fetch_zoom_config(array $data): DataStatus
    {
        try {
            $platform = Platform::where('code', $data['platform_code'])->first();
            $live_account = LiveAccount::where('id', $data['live_account_id'])->where('integeration_type', PlatformTypeEnum::ZOOM->value)->first();
            $zoom_integeration_service = new ZoomIntegerationService($live_account);
            // dd($live_account);
            // Fetch Zoom configuration details based on user role, session, and user ID
            $config = $zoom_integeration_service->send_zoom_config($data);
            return new DataSuccess(
                status: true,
                data: $config->getData(),
                message: $config->getMessage()
            );
        } catch (Exception $e) {
            return new DataFailed(
                status: false,
                message: $e->getMessage()
            );
        }
    }


    public function end_meeting(array $data, $type): DataStatus
    {
        try {
            // dd($data);
            $platform = Platform::where('code', $data['platform_code'])->first();
            // Generate the appropriate live session join URL based on platform type
            if ($type == PlatformTypeEnum::LIVE100MS->value) {
            } elseif ($type == PlatformTypeEnum::ZOOM->value) {
                $live_account = LiveAccount::where('id', $data['live_account_id'])->where('integeration_type', PlatformTypeEnum::ZOOM->value)->first();
                // dd($live_account);
                $session = $live_account->sessions()->where('id', $data['session_id'])->first();
                // dd($session);
                $meeting = $session->zoom_meeting;
                // dd($meeting);
                $zoom_integeration_service = new ZoomIntegerationService($live_account);
                $delete_response = $zoom_integeration_service->end_meeting(['session' => $session, 'meeting' => $meeting]);
            }

            return new DataSuccess(
                status: true,
                message: $delete_response->getMessage()
            );
        } catch (Exception $e) {
            return new DataFailed(
                status: false,
                message: $e->getMessage()
            );
        }
    }
}
