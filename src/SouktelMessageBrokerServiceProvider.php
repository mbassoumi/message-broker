<?php

namespace Souktel\MessageBroker;

use Souktel\MessageBroker\Classes\MessageBroker;
use Illuminate\Support\ServiceProvider;
use Souktel\MessageBroker\Commands\MessageConsumer;
use Souktel\MessageBroker\Testing\Fake\MessageBrokerFake;


class SouktelMessageBrokerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/souktel-message-broker.php' => config_path('souktel-message-broker.php'),
        ], 'config');

        $this->publishes([
            __DIR__ . '/../database/migrations/create_succeeded_consumed_messages_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_' . config('souktel-message-broker.database.succeeded_consumed_messages') . '_table.php'),
            __DIR__ . '/../database/migrations/create_failed_consumed_messages_table.php.stub'    => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_' . config('souktel-message-broker.database.failed_consumed_messages') . '_table.php'),
            __DIR__ . '/../database/migrations/create_succeeded_published_messages_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_' . config('souktel-message-broker.database.succeed_published_messages') . '_table.php'),
            __DIR__ . '/../database/migrations/create_failed_published_messages_table.php.stub'    => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_' . config('souktel-message-broker.database.failed_published_messages') . '_table.php'),
        ], 'migrations');

    }

    public function register()
    {

        $this->app->register(\Bschmitt\Amqp\LumenServiceProvider::class);

        // binding Event Manager to service container
        $this->app->singleton('MessageBroker', function () {
            if (!config('souktel-message-broker.enable')) {
                return new MessageBrokerFake;
            }
            return new MessageBroker;
        });

        $this->mergeConfigFrom(
            __DIR__ . '/../config/souktel-message-broker.php', 'souktel-message-broker'
        );

        $this->mergeConfigFrom(
            __DIR__ . '/../config/amqp.php', 'amqp'
        );

        $this->app->bind('command.messages:consume', MessageConsumer::class);

        $this->commands([
            'command.messages:consume',
        ]);

    }
}
