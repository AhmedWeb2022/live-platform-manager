<?php

namespace ahmedWeb\LivePlatformManager\Http\Controllers\Dashboard;

use ahmedWeb\LivePlatformManager\DataTables\PlatformDataTable;
use App\Http\Controllers\Controller;
use ahmedWeb\LivePlatformManager\Http\Requests\Dashbaord\Platform\StorePlatformRequest;
use ahmedWeb\LivePlatformManager\Http\Requests\Dashbaord\Platform\UpdatePlatformRequest;
use ahmedWeb\LivePlatformManager\Models\Platform\Platform;
use ahmedWeb\LivePlatformManager\Response\DataSuccess;
use ahmedWeb\LivePlatformManager\Services\Dashbaord\platform\platformService;
use Illuminate\Http\Request;

class PlatformController extends Controller
{
    protected platformService $platform_service;
    protected $view = 'liveplatform::dashboard.platform.';


    public function __construct(platformService $platform_service)
    {
        $this->platform_service = $platform_service;
    }


    public function index(PlatformDataTable $dataTable)
    {

        return $dataTable->render($this->view . 'index');
    }

    public function create()
    {
        $response = $this->platform_service->create_content();
        if ($response instanceof DataSuccess) {
            return view($this->view . 'create', $response->getData());
        }
        return redirect()->back()->with(['error' => $response->getMessage()]);
    }

    public function store(StorePlatformRequest $request)
    {
        $response = $this->platform_service->store($request);
        if ($response instanceof DataSuccess) {
            return redirect()->route('admin.platform')->with(['success' => $response->getMessage()]);
        }
        return redirect()->back()->with(['error' => $response->getMessage()]);
    }

    public function edit(Platform $platform)
    {
        $response = $this->platform_service->edit_content($platform);
        if ($response instanceof DataSuccess) {
            return view($this->view . 'edit', $response->getData());
        }
        return redirect()->back()->with(['error' => $response->getMessage()]);
    }

    public function update(UpdatePlatformRequest $request, Platform $platform)
    {
        $response = $this->platform_service->update($request, $platform);
        if ($response instanceof DataSuccess) {
            return redirect()->route('admin.platform')->with(['success' => $response->getMessage()]);
        }
        return redirect()->back()->with(['error' => $response->getMessage()]);
    }

    public function destroy(Platform $platform)
    {
        $response = $this->platform_service->destroy($platform);
        if ($response instanceof DataSuccess) {
            return response()->json(['status' => $response->getStatus(), 'message' => $response->getMessage()]);
        }
        return response()->json(['status' => $response->getStatus(), 'message' => $response->getMessage()]);
    }
}
