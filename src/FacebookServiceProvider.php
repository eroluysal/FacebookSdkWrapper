<?php

namespace QweB\Facebook;

use Illuminate\Support\ServiceProvider;

class FacebookServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/facebook.php' => config_path('facebook.php'),
        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bindShared('QweB\Facebook\Contracts\Factory', function ($app) {
            $config = array_values($app['config']['facebook.application']);

            list($appId, $secret, $scopes) = $config;

            return new Factory($appId, $secret, $scopes);
        });
    }
}
