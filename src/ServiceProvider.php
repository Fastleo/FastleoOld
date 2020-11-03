<?php

namespace Camanru\Fastleo;

use Camanru\Fastleo\app\Console\FastleoAdmin;
use Camanru\Fastleo\app\Console\FastleoClear;
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
        // Route
        include __DIR__ . '/routes/web.php';

        // Console commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                FastleoAdmin::class,
                FastleoClear::class,
            ]);
        }

        // Composer
        $fastleo_composer = json_decode(file_get_contents(__DIR__ . '/../composer.json'));
        config()->set(['fastleo_composer' => $fastleo_composer]);

        // Migrations
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        // Views
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'fastleo');

        // Src
        $this->publishes([
            __DIR__ . '/resources/css' => resource_path('../public/css'),
            __DIR__ . '/resources/ico' => resource_path('../public/ico'),
            __DIR__ . '/resources/js' => resource_path('../public/js'),
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
