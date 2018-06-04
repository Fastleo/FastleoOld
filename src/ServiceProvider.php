<?php

namespace Camanru\Fastleo;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Console commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                FastleoCommand::class
            ]);
        }

        // Route
        include __DIR__ . '/routes/routes.php';

        // Migrations
        $this->loadMigrationsFrom(__DIR__ . '/migrations');

        // Views
        $this->loadViewsFrom(__DIR__ . '/views', 'fastleo');

        // Src
        $this->publishes([
            __DIR__ . '/resources' => resource_path('../public'),
        ], 'fastleo');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
