<?php

namespace Souktel\MessageBroker;

use Souktel\MessageBroker\Classes\MessageBroker;
use Illuminate\Support\ServiceProvider;


class SouktelMessageBrokerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/souktel-message-broker.php' => config_path('souktel-message-broker.php'),
        ], 'config');
    }

    public function register()
    {

        // binding Event Manager to service container
        $this->app->singelton('MessageBroker', function () {
            return new MessageBroker;
        });


        $this->mergeConfigFrom(
            __DIR__ . '/config/souktel-message-broker.php', 'souktel-message-broker'
        );

    }
}
