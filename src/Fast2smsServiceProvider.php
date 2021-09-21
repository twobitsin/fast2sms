<?php

namespace TwoBitsIn\Fast2sms;

use Illuminate\Support\ServiceProvider;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\Facades\Notification;
use GuzzleHttp\Client as HttpClient;
use TwoBitsIn\Fast2sms\Fast2smsClient;

class Fast2smsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {

    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->app->singleton(Fast2smsClient::class, static function ($app) {
            return new Fast2smsClient(new HttpClient());
        });

        Notification::resolved(function (ChannelManager $service) {
            $service->extend('fast2sms', function ($app) {
                return new Fast2smsChannel($app[Fast2smsClient::class]);
            });
        });
    }
}
