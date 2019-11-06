<?php


namespace Souktel\MessageBroker\Facades;


use Illuminate\Support\Facades\Facade;
use Souktel\MessageBroker\Testing\Fake\MessageBrokerFake;

/**
 * manage events through message broker [RabbitMQ]
 *
 * Class EventManager
 */
class MessageBroker extends Facade
{

    public static function fake()
    {
        static::swap($fake = new MessageBrokerFake(static::getFacadeApplication()));

        return $fake;
    }

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'MessageBroker';
    }


}
