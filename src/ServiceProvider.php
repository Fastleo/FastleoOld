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
        if ($this->app->runningInConsole()) {
            $this->commands([
                Fastleo::class
            ]);
        }

        include __DIR__ . '/routes/routes.php';
        $this->loadMigrationsFrom(__DIR__ . '/migrations');
        $this->loadViewsFrom(__DIR__ . '/views', 'fastleo');

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

    }
}
