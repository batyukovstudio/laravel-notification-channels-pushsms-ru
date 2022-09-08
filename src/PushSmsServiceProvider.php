<?php

namespace NotificationChannels\PushSMS;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use GuzzleHttp\Client as HttpClient;

class PushSmsServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(PushSmsApi::class, static function ($app) {
            $config = $app['config']['pushsms'];

            $client = new HttpClient([
                'timeout'         => $config['timeout'],
                'connect_timeout' => $config['connect_timeout'],
            ]);

            return new PushSmsApi($config, $client);
        });
    }

    /**
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__ . '/../Config/pushsms.php', 'pushsms');

        $this->publishes([
            __DIR__ . '/../Config/pushsms.php' => config_path('pushsms.php'),
        ], 'configs');

    }

    /**
     * @return array
     */
    public function provides(): array
    {
        return [
            PushSmsApi::class,
        ];
    }
}
