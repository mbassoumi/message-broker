<?php

namespace Souktel\MessageBroker\Testing\Fake;

use Illuminate\Support\Facades\Mail;
use PHPUnit\Framework\Assert as PHPUnit;

/**
 * Class MessageBrokerFake
 *
 * @package Souktel\MessageBroker\Testing\Fake
 *
 */
class MessageBrokerFake
{
    protected $databaseLogging = null;

    protected $logger = null;

    protected static $message = [];

    public function __construct()
    {

    }


    /**
     * fake publish function
     *
     * @param $routeKey
     * @param array|string $message
     * @param $queue
     */
    public function publish($routeKey, $message, $queue)
    {

        static::$message = [
            'routeKey' => $routeKey,
            'message'  => $message,
            'queue'    => $queue,
        ];
    }

    /**
     * fake consume function
     *
     * @param $queue
     */
    public function consume()
    {
        $message = static::$message;
        static::$message = [];
        return $message;
    }

    public function assertPublished($callback)
    {
        $this->assertTrue($callback);
    }

    public function assertConsumed($callback)
    {
        $this->assertTrue($callback);
    }


    protected function assertTrue($callback)
    {
        PHPUnit::assertTrue($callback(static::$message),
            'condation return false');
    }

}
