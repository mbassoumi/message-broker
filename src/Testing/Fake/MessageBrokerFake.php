<?php

namespace Souktel\MessageBroker\Testing\Fake;

class MessageBrokerFake
{
    protected $databaseLogging = null;

    protected $logger = null;

    public function __construct()
    {

    }


    /**
     * fake publish function
     *
     * @param $roteKey
     * @param array|string $message
     * @param $queue
     */
    public function publish($roteKey, $message, $queue)
    {
        // do nothing
    }

    /**
     * fake consume function
     *
     * @param $queue
     */
    public function consume($queue)
    {
        // do nothing
    }

}
