<?php

namespace Bhhaskin\LaravelStatus;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class StatusServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/status.php', 'status');
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/status.php' => $this->configPath('status.php'),
            ], 'laravel-status-config');
        }

        $this->registerRoutes();
    }

    protected function registerRoutes(): void
    {
        if (! config('status.enabled', true)) {
            return;
        }

        Route::get(config('status.path', 'health'), [Controllers\StatusController::class, 'health'])
            ->middleware(config('status.middleware', []))
            ->name('status.health');
    }

    protected function configPath(string $path): string
    {
        if (function_exists('config_path')) {
            return config_path($path);
        }

        return $this->app->basePath('config/' . $path);
    }
}
