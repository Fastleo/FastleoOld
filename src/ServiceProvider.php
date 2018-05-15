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
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make('Camanru\Fastleo\ConfigController');
        $this->app->make('Camanru\Fastleo\InfoController');
        $this->app->make('Camanru\Fastleo\LoginController');
        $this->app->make('Camanru\Fastleo\PagesController');
        $this->app->make('Camanru\Fastleo\UsersController');
    }
}
