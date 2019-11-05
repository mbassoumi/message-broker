<?php

namespace Souktel\MessageBroker;

use Souktel\MessageBroker\Classes\EventManager;

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
        $this->app->singelton('EventManager', function () {
            return new EventManager;
        });

        $this->mergeConfigFrom(
            __DIR__ . '/config/souktel-message-broker.php', 'souktel-message-broker'
        );

    }
}
