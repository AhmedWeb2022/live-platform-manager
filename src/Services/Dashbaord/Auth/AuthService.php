<?php

namespace ahmedWeb\LivePlatformManager\Services\Dashbaord\Auth;

use ahmedWeb\LivePlatformManager\Models\LiveAdmin\LiveAdmin;
use ahmedWeb\LivePlatformManager\Models\User;
use ahmedWeb\LivePlatformManager\Response\DataFailed;
use ahmedWeb\LivePlatformManager\Response\DataStatus;
use ahmedWeb\LivePlatformManager\Response\DataSuccess;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function login($request): DataStatus
    {
        try {
            $user = LiveAdmin::where('email', $request->email)->first();
            // dd($user);
            if (!$user || !Hash::check($request->password, $user->password)) {
                return new DataFailed(
                    status: false,
                    message: 'Invalid email or password'
                );
            }

            Auth::login($user);

            return new DataSuccess(
                status: true,
                message: 'Login successful'
            );
        } catch (Exception $e) {
            return new DataFailed(
                status: false,
                message: $e->getMessage()
            );
        }
    }

    public function logout(): DataStatus
    {
        try {
            Auth::logout();
            return new DataSuccess(
                status: true,
                message: 'Logout successful'
            );
        } catch (Exception $e) {
            return new DataFailed(
                status: false,
                message: $e->getMessage()
            );
        }
    }
}
