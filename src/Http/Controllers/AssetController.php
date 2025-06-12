<?php

namespace ahmedWeb\LivePlatformManager\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use ahmedWeb\LivePlatformManager\Enums\PlatformTypeEnum;

class AssetController extends Controller
{
    public function serve($path)
    {
        $basePath = base_path('packages/ahmedWeb/LivePlatformManager/src/Public');
        $fullPath = realpath($basePath . '/' . $path);

        if (!$fullPath || !Str::startsWith($fullPath, realpath($basePath)) || !File::exists($fullPath)) {
            abort(404);
        }

        // Force MIME type based on file extension
        $extension = pathinfo($fullPath, PATHINFO_EXTENSION);
        $mimeTypes = [
            'css'  => 'text/css',
            'js'   => 'application/javascript',
            'svg'  => 'image/svg+xml',
            'jpg'  => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png'  => 'image/png',
            'gif'  => 'image/gif',
            'woff' => 'font/woff',
            'woff2' => 'font/woff2',
            'ttf'  => 'font/ttf',
            'eot'  => 'application/vnd.ms-fontobject',
            'otf'  => 'font/otf',
            'json' => 'application/json',
            'map'  => 'application/json',
        ];

        $mimeType = $mimeTypes[$extension] ?? 'application/octet-stream';
        $content = File::get($fullPath);

        return response($content, 200)->header('Content-Type', $mimeType);
    }

    public function loadIntegrationForm($type)
    {
        if (!in_array($type, ['1', '2', '3'])) {
            abort(404);
        }
        $view = PlatformTypeEnum::from($type)->view();
        return view("liveplatform::dashboard.component.$view");
    }
}
