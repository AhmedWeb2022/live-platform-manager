<?php

namespace ahmedWeb\LivePlatformManager\Services\Dashbaord\platform;

use ahmedWeb\LivePlatformManager\Models\Platform\Platform;
use ahmedWeb\LivePlatformManager\Response\DataFailed;
use ahmedWeb\LivePlatformManager\Response\DataStatus;
use ahmedWeb\LivePlatformManager\Response\DataSuccess;
use Exception;

class platformService
{
    public function create_content(): DataStatus
    {
        try {
            $content = [
                'title' => 'create platform',
                'route' => route('admin.platform.store'),
                'method' => 'POST',
                "back" => route('admin.platform'),
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
            $data['name'] = $request->name;
            $data['url'] = $request->url;
            $data['code'] = $request->code;

            $platform = Platform::create($data);

            return new DataSuccess(
                status: true,
                message: 'success',
                data: $platform
            );
        } catch (Exception $e) {
            return new DataFailed(
                status: false,
                message: $e->getMessage()
            );
        }
    }

    public function edit_content(Platform $platform): DataStatus
    {
        try {
            $content = [
                'title' => 'edit platform',
                'route' => route('admin.platform.update', $platform->id),
                'method' => 'POST',
                "back" => route('admin.platform'),
                'platform' => $platform
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

    public function update($request, Platform $platform): DataStatus
    {
        try {
            $data['name'] = $request->name;
            $data['url'] = $request->url;
            $data['code'] = $request->code;

            $platform->update($data);

            return new DataSuccess(
                status: true,
                message: 'success',
                data: $platform
            );
        } catch (Exception $e) {
            return new DataFailed(
                status: false,
                message: $e->getMessage()
            );
        }
    }

    public function destroy(Platform $platform): DataStatus
    {
        try {
            $platform->delete();
            return new DataSuccess(
                status: true,
                message: 'success',
                data: $platform
            );
        } catch (Exception $e) {
            return new DataFailed(
                status: false,
                message: $e->getMessage()
            );
        }
    }
}
