<?php

namespace ahmedWeb\LivePlatformManager\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use ahmedWeb\LivePlatformManager\Http\Requests\Dashbaord\Auth\LoginRequest;
use ahmedWeb\LivePlatformManager\Response\DataSuccess;
use ahmedWeb\LivePlatformManager\Services\Dashbaord\Auth\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    protected AuthService $auth_service;

    public function __construct(AuthService $auth_service)
    {
        $this->auth_service = $auth_service;
    }
    public function index()
    {
        return view('liveplatform::dashboard.auth.login');
    }

    public function login(LoginRequest $request)
    {
        // dd($request->all());

        $response = $this->auth_service->login($request);

        if ($response instanceof DataSuccess) {
            return redirect()->route('admin.index');
        }
        return redirect()->back()->with(['error' => $response->getMessage()]);
    }

    public function logout()
    {
        $response = $this->auth_service->logout();

        if ($response instanceof DataSuccess) {
            return redirect()->route('login');
        }
        return redirect()->back()->with(['error' => $response->getMessage()]);
    }
}
