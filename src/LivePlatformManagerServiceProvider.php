<?php

namespace ahmedWeb\LivePlatformManager;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\ServiceProvider;
use ahmedWeb\LivePlatformManager\Database\Seeders\Platform\PlatformSeeder;
use ahmedWeb\LivePlatformManager\Database\Seeders\LiveAdmin\LiveAdminSeeder;
use ahmedWeb\LivePlatformManager\Database\Seeders\LiveAccount\LiveAccountSeeder;

class LivePlatformManagerServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // dd(glob(app_path(__DIR__ . '/Helpers')));
        foreach (glob(__DIR__ . '/Helpers/*.php') as $filename) {
            require_once $filename;
        }

        // Load migrations from your package
        $this->loadMigrationsFrom(__DIR__ . '/Database/migrations');
        // Hook into seeding process only when --seed is passed
        if ($this->app->runningInConsole() && $this->hasSeedOption()) {
            $this->app->afterResolving(DatabaseSeeder::class, function ($seeder) {
                $seeder->call([
                    PlatformSeeder::class,
                    LiveAccountSeeder::class,
                    LiveAdminSeeder::class,
                ]);
            });
        }

        $this->loadViewsFrom(__DIR__ . '/Views', 'liveplatform');

        // ✅ Add this line to load routes
        $this->loadRoutesFrom(__DIR__ . '/Routes/web.php');
        $this->loadRoutesFrom(__DIR__ . '/Routes/api.php');
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/Views' => resource_path('views/vendor/liveplatform'),
            ], 'liveplatform-views');
            // ✅ Publish public assets
            $this->publishes([
                __DIR__ . '/Public' => public_path('vendor/liveplatform'),
            ], 'liveplatform-assets');
        }
    }

    protected function hasSeedOption(): bool
    {
        $argv = $_SERVER['argv'] ?? [];
        return in_array('--seed', $argv) || in_array('--seeder', $argv);
    }
}
