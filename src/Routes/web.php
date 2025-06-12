<?php

use Illuminate\Support\Facades\Route;
use ahmedWeb\LivePlatformManager\Enums\PlatformTypeEnum;
use ahmedWeb\LivePlatformManager\Http\Controllers\AssetController;
use ahmedWeb\LivePlatformManager\Http\Controllers\Dashboard\AuthController;
use ahmedWeb\LivePlatformManager\Http\Controllers\Dashboard\HomeController;
use ahmedWeb\LivePlatformManager\Http\Controllers\Dashboard\SessionController;
use ahmedWeb\LivePlatformManager\Http\Controllers\Dashboard\PlatformController;
use ahmedWeb\LivePlatformManager\Http\Controllers\Dashboard\LiveAccountController;

Route::middleware(['web'])->group(function () {

    Route::get('liveplatform-assets/{path}', [AssetController::class, 'serve'])
        ->where('path', '.*')
        ->name('liveplatform.assets');
    Route::get('/load-integration-form/{type}',[AssetController::class,'loadIntegrationForm'])->name('liveplatform.loadIntegrationForm');
    Route::prefix('live-admin')->group(function () {
        Route::middleware('guest:web')->group(function () {
            Route::controller(AuthController::class)->group(function () {
                Route::get('/login', 'index')->name('login');
                Route::post('/login', 'login')->name('login.store');
            });
        });
    });
    Route::prefix('live-admin')->name('admin.')->middleware('auth:web')->group(function () {
        Route::controller(AuthController::class)->group(function () {
            Route::get('logout', 'logout')->name('logout');
        });
        Route::controller(HomeController::class)->group(function () {
            Route::get('/', 'index')->name('index'); // Use '/' instead of '' to ensure it works.
        });
        Route::controller(PlatformController::class)->group(function () {
            Route::get('platform', 'index')->name('platform');
            Route::get('platform/create', 'create')->name('platform.create');
            Route::post('platform/store', 'store')->name('platform.store');
            Route::get('platform/edit/{platform}', 'edit')->name('platform.edit');
            Route::post('platform/update/{platform}', 'update')->name('platform.update');
            Route::post('platform/destroy/{platform}', 'destroy')->name('platform.destroy');
        });

        Route::controller(LiveAccountController::class)->group(function () {
            Route::get('live_account', 'index')->name('live_account');
            Route::get('live_account/create', 'create')->name('live_account.create');
            Route::post('live_account/store', 'store')->name('live_account.store');
            Route::get('live_account/edit/{live_account}', 'edit')->name('live_account.edit');
            Route::post('live_account/update/{live_account}', 'update')->name('live_account.update');
            Route::post('live_account/destroy/{live_account}', 'destroy')->name('live_account.destroy');
        });

        Route::controller(SessionController::class)->group(function () {
            Route::get('session', 'index')->name('session');
            Route::get('session/create', 'create')->name('session.create');
            Route::post('session/store', 'store')->name('session.store');
            Route::get('session/edit/{session}', 'edit')->name('session.edit');
            Route::post('session/update/{session}', 'update')->name('session.update');
            Route::post('session/destroy/{session}', 'destroy')->name('session.destroy');
        });
    });
});
