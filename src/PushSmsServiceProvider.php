<?php

namespace NotificationChannels\PushSMS;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use GuzzleHttp\Client as HttpClient;

class PushSmsServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function register(): void
    {
        $this->app->singleton(PushSmsApi::class, static function ($app) {
            $token = $app['config']['pushsms'];
            return new PushSmsApi($token);
        });
    }

    public function boot()
    {
        $this->mergeConfigFrom(__DIR__ . '/../Config/pushsms.php', 'pushsms');

        $this->publishes([
            __DIR__ . '/../Config/pushsms.php' => config_path('loggable.php'),
        ], 'configs');

    }

    public function provides(): array
    {
        return [
            PushSmsApi::class,
        ];
    }
}
