<?php


namespace Souktel\MessageBroker\Classes;


use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DatabaseLogging
{


    /** @var null|Logger $logger */
    protected $logger;

    public function __construct($logger = null)
    {
        $this->logger = $logger;
    }

    public function storeFailedConsumedEvents($queue, $routingKey, $payload, $message, $errorMessage)
    {
        $eventName = '';
        try {
            $eventName = $queue . ':' . $routingKey;
            optional($this->logger)->log("Event Name: $eventName. \n Event Body: $message->body. \n Error: {$errorMessage}", 'error');
            DB::table(config('souktel-message-broker.database.failed_messages'))->insert([
                'queue'         => $queue,
                'routing_key'   => $routingKey,
                'payload'       => $payload,
                'error_message' => $errorMessage,
                'failed_at'     => Carbon::now()
            ]);
        } catch (\Exception $exception) {
            optional($this->logger)->log("Failed to store failed event {$eventName} with error = {$errorMessage}, \n Error: {$exception->getMessage()}", 'error');
        }
    }

    public function storeSucceededConsumedEvents($queue, $routingKey, $payload)
    {
        try {
            DB::table(config('souktel-message-broker.database.succeeded_messages'))->insert([
                'queue'       => $queue,
                'routing_key' => $routingKey,
                'payload'     => $payload,
                'consumed_at' => Carbon::now()
            ]);
        } catch (\Exception $exception) {
            $eventName = $queue . ':' . $routingKey;
            optional($this->logger)->log("Failed to store succeed event {$eventName}, \n Error: {$exception->getMessage()}", 'error');
        }
    }

    public function storeSucceedPublishedEvents($roteKey, $message, $queue)
    {
        try {
            DB::table(config('souktel-message-broker.database.succeed_published_messages'))->insert([
                'queue'        => $queue,
                'routing_key'  => $roteKey,
                'payload'      => $message,
                'published_at' => Carbon::now()
            ]);
        } catch (\Exception $exception) {
            $eventName = $queue . ':' . $roteKey;
            optional($this->logger)->log("Failed to store published event {$eventName}, \n Error: {$exception->getMessage()}");
        }
    }

    public function storeFailedPublishedEvents($roteKey, $message, $queue, $errorMessage)
    {
        try {
            DB::table(config('souktel-message-broker.database.failed_published_messages'))->insert([
                'queue'        => $queue,
                'routing_key'  => $roteKey,
                'payload'      => $message,
                'failed_at' => Carbon::now()
            ]);
        } catch (\Exception $exception) {
            $eventName = $queue . ':' . $roteKey;
            optional($this->logger)->log("Failed to store published event {$eventName}, \n Error: {$exception->getMessage()}");
        }
    }
}