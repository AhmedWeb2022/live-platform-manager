<?php

namespace ahmedWeb\LivePlatformManager\Http\Controllers\Dashboard;

use ahmedWeb\LivePlatformManager\DataTables\LiveAccountDataTable;
use App\Http\Controllers\Controller;
use ahmedWeb\LivePlatformManager\Http\Requests\Dashbaord\LiveAccount\StoreLiveAccountRequest;
use ahmedWeb\LivePlatformManager\Http\Requests\Dashbaord\LiveAccount\UpdateLiveAccountRequest;
use ahmedWeb\LivePlatformManager\Models\LiveAcount\LiveAccount;
use ahmedWeb\LivePlatformManager\Response\DataSuccess;
use ahmedWeb\LivePlatformManager\Services\Dashbaord\LiveAccount\LiveAccountService;
use Illuminate\Http\Request;

class LiveAccountController extends Controller
{
    protected LiveAccountService $live_account_service;
    protected $view = 'liveplatform::dashboard.live_account.';


    public function __construct(LiveAccountService $live_account_service)
    {
        $this->live_account_service = $live_account_service;
    }


    public function index(LiveAccountDataTable $dataTable)
    {

        return $dataTable->render($this->view . 'index');
    }

    public function create()
    {
        $response = $this->live_account_service->create_content();
        if ($response instanceof DataSuccess) {
            return view($this->view . 'create', $response->getData());
        }
        return redirect()->back()->with(['error' => $response->getMessage()]);
    }

    public function store(StoreLiveAccountRequest $request)
    {
        $response = $this->live_account_service->store($request);
        if ($response instanceof DataSuccess) {
            return redirect()->route('admin.live_account')->with(['success' => $response->getMessage()]);
        }
        return redirect()->back()->with(['error' => $response->getMessage()]);
    }


    public function edit(LiveAccount $live_account)
    {
        $response = $this->live_account_service->edit_content($live_account);
        if ($response instanceof DataSuccess) {
            return view($this->view . 'edit', $response->getData());
        }
        return redirect()->back()->with(['error' => $response->getMessage()]);
    }

    public function update(UpdateLiveAccountRequest $request, LiveAccount $live_account)
    {
        $response = $this->live_account_service->update($request, $live_account);
        if ($response instanceof DataSuccess) {
            return redirect()->route('admin.live_account')->with(['success' => $response->getMessage()]);
        }
        return redirect()->back()->with(['error' => $response->getMessage()]);
    }

    public function destroy(LiveAccount $live_account)
    {
        $response = $this->live_account_service->destroy($live_account);
        if ($response instanceof DataSuccess) {
            return response()->json(['status' => $response->getStatus(), 'message' => $response->getMessage()]);
        }
        return response()->json(['status' => $response->getStatus(), 'message' => $response->getMessage()]);
    }
}
