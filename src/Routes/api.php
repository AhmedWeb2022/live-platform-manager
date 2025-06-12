<?php

use ahmedWeb\LivePlatformManager\Http\Controllers\LiveIntegerationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::controller(LiveIntegerationController::class)->group(function () {
    Route::post('fetch_live_accounts', 'fetch_live_accounts');
    Route::post('fetch-live', 'fetch_live');
    Route::post('fetch-live-dev', 'fetch_live_dev');
    Route::post('create-live', 'create_live');
    Route::post('delete_live', 'delete_live');
    Route::post('fetch_zoom_config', 'fetch_zoom_config');
    Route::post('end_meeting', 'end_meeting');
});
