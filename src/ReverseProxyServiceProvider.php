<?php

namespace ProbablyRational\ReverseProxy;

use Illuminate\Support\ServiceProvider;

class ReverseProxyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config.php', 'reverseproxy');
        $this->app->make('ProbablyRational\ReverseProxy\RouteController');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->publishes([
            __DIR__ . '/config.php' => config_path('reverseproxy'),
        ]);
    }
}
