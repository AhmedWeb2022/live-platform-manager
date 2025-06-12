<?php

namespace ahmedWeb\LivePlatformManager\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use ahmedWeb\LivePlatformManager\Http\Requests\Live\CreateLiveRequest;
use ahmedWeb\LivePlatformManager\Http\Requests\Live\DeleteLiveRequest;
use ahmedWeb\LivePlatformManager\Http\Requests\Live\FetchLiveRequest;
use ahmedWeb\LivePlatformManager\Http\Requests\Live\FetchZoomConfigRequest;
use ahmedWeb\LivePlatformManager\Http\Requests\Live\JoinLiveRequest;
use ahmedWeb\LivePlatformManager\Response\DataSuccess;
use ahmedWeb\LivePlatformManager\Services\LiveIntegerationService;

/**
 * Class LiveIntegerationController
 *
 * Handles live session-related operations such as creating and joining sessions, and fetching configuration settings.
 */
class LiveIntegerationController extends Controller
{
    /**
     * @var LiveIntegerationService $live_integeration_service
     * The service responsible for interacting with the live session platform.
     */
    protected $live_integeration_service;

    /**
     * Constructor.
     *
     * @param LiveIntegerationService $live_integeration_service The service dependency for live session integration.
     */
    public function __construct(LiveIntegerationService $live_integeration_service)
    {
        $this->live_integeration_service = $live_integeration_service;
    }


    public function fetch_live_accounts(Request $request)
    {
        return $this->live_integeration_service->fetch_live_accounts($request->all())->response();
    }


    public function fetch_live(FetchLiveRequest $request)
    {
        return $this->live_integeration_service->fetch_live($request->all(), $request->platform_type)->response();
    }
    public function fetch_live_dev(FetchLiveRequest $request)
    {
        return $this->live_integeration_service->fetch_live_dev($request->all(), $request->platform_type)->response();
    }
    /**
     * Create a new live session.
     *
     * @param CreateLiveRequest $request The incoming request containing live session details.
     * @return \Illuminate\Http\JsonResponse The JSON response with the status and message of the operation.
     *
     * @description Sends a request to the live integration service to create a live session using the provided data.
     * If successful, it returns a JSON response with a success status and message. Otherwise, it returns an error status and message.
     */
    public function create_live(CreateLiveRequest $request)
    {
        return $this->live_integeration_service->create_live($request->all(), $request->platform_type)->response();
    }

    public function delete_live(DeleteLiveRequest $request)
    {
        return $this->live_integeration_service->delete_live($request->all(), $request->platform_type)->response();
    }
    /**
     * Join an existing live session.
     *
     * @param JoinLiveRequest $request The incoming request containing session join details.
     * @return \Illuminate\Http\RedirectResponse Redirects the user to the live session URL or back with an error message.
     *
     * @description Sends a request to the live integration service to join a specific live session.
     * If the operation is successful, the user is redirected to the live session's URL. Otherwise, they are redirected back with an error message.
     */
    public function join_live(JoinLiveRequest $request)
    {
        $response = $this->live_integeration_service->join_live($request->all(), $request->platform_type);

        if ($response instanceof DataSuccess) {
            return redirect()->away($response->getData());
        }

        return redirect()->back()->with(['error' => $response->getMessage()]);
    }

    /**
     * Fetch Zoom configuration settings.
     *
     * @param Request $request The incoming request containing configuration fetch details.
     * @return mixed The response from the live integration service with Zoom configuration details.
     *
     * @description Retrieves Zoom configuration details from the live integration service based on the provided data.
     */
    public function fetch_zoom_config(FetchZoomConfigRequest $request)
    {
        return $this->live_integeration_service->fetch_zoom_config($request->all())->response();
    }

    public function end_meeting(Request $request)
    {
        return $this->live_integeration_service->end_meeting($request->all(), $request->platform_type)->response();
    }
}
