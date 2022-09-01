<?php

namespace NotificationChannels\PushSMS;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class PushSmsServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function register(): void
    {
        $this->app->singleton(PushSmsApi::class, static function ($app) {
            return new PushSmsApi($app['config']['services.pushsms']);
        });
    }

    public function provides(): array
    {
        return [
            PushSmsApi::class,
        ];
    }
}
