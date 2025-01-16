<?php

namespace Explorin\Tebot;

use Illuminate\Support\ServiceProvider;

class TebotServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('tebot', function () {
            return new Tebot();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/tebot.php' =>  config_path('tebot.php'),
        ], 'config');

        date_default_timezone_set(config('tebot.timezone', 'UTC'));
    }
}
