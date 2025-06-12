<?php

namespace ahmedWeb\LivePlatformManager\Services\Dashbaord\LiveAccount;

use ahmedWeb\LivePlatformManager\Models\LiveAcount\LiveAccount;
use ahmedWeb\LivePlatformManager\Models\Platform\Platform;
use ahmedWeb\LivePlatformManager\Response\DataFailed;
use ahmedWeb\LivePlatformManager\Response\DataStatus;
use ahmedWeb\LivePlatformManager\Response\DataSuccess;
use Exception;

class LiveAccountService
{
    public function create_content(): DataStatus
    {
        try {
            $platforms = Platform::all();
            $content = [
                'title' => 'Create Live Account',
                'route' => route('admin.live_account.store'),
                'method' => 'POST',
                "back" => route('admin.live_account'),
                'platforms' => $platforms
            ];

            return new DataSuccess(
                status: true,
                message: 'success',
                data: $content
            );
        } catch (Exception $e) {
            return new DataFailed(
                status: false,
                message: $e->getMessage()
            );
        }
    }


    public function store($request): DataStatus
    {
        try {
            // $data['platform_id'] = $request->platform_id;
            $data['name'] = $request->name;
            $data['client_id'] = $request->client_id;
            $data['client_secret'] = $request->client_secret;
            $data['account_id'] = $request->account_id;
            $data['sdk_key'] = $request->sdk_key;
            $data['sdk_secret'] = $request->sdk_secret;
            $data['integeration_type'] = $request->integeration_type;
            $data['join_url'] = $request->join_url;

            $live_account = LiveAccount::create($data);

            return new DataSuccess(
                status: true,
                message: 'success',
                data: $live_account
            );
        } catch (Exception $e) {
            return new DataFailed(
                status: false,
                message: $e->getMessage()
            );
        }
    }

    public function edit_content(LiveAccount $live_account): DataStatus
    {
        try {
            $platforms = Platform::all();
            $content = [
                'title' => 'edit Live Account',
                'route' => route('admin.live_account.update', $live_account->id),
                'method' => 'POST',
                "back" => route('admin.live_account'),
                'live_account' => $live_account,
                'platforms' => $platforms
            ];

            return new DataSuccess(
                status: true,
                message: 'success',
                data: $content
            );
        } catch (Exception $e) {
            return new DataFailed(
                status: false,
                message: $e->getMessage()
            );
        }
    }

    public function update($request, LiveAccount $live_account): DataStatus
    {
        try {
            // $data['platform_id'] = $request->platform_id ?? $live_account->platform_id;
            $data['name'] = $request->name ?? $live_account->name;
            $data['client_id'] = $request->client_id ?? $live_account->client_id;
            $data['client_secret'] = $request->client_secret ?? $live_account->client_secret;
            $data['account_id'] = $request->account_id ?? $live_account->account_id;
            $data['sdk_key'] = $request->sdk_key ?? $live_account->sdk_key;
            $data['sdk_secret'] = $request->sdk_secret ?? $live_account->sdk_secret;
            $data['integeration_type'] = $request->integeration_type ?? $live_account->integeration_type;
            $data['join_url'] = $request->join_url ?? $live_account->join_url;

            $live_account->update($data);

            return new DataSuccess(
                status: true,
                message: 'success',
                data: $live_account
            );
        } catch (Exception $e) {
            return new DataFailed(
                status: false,
                message: $e->getMessage()
            );
        }
    }

    public function destroy(LiveAccount $live_account): DataStatus
    {
        try {
            $live_account->delete();
            return new DataSuccess(
                status: true,
                message: 'success',
                data: $live_account
            );
        } catch (Exception $e) {
            return new DataFailed(
                status: false,
                message: $e->getMessage()
            );
        }
    }
}
