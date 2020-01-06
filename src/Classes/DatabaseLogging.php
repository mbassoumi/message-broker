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

    public function storeFailedConsumedEvents($queue, $routingKey, $payload, $message, $exception)
    {
        $eventName = '';
        try {
            $eventName = $queue . ':' . $routingKey;
            optional($this->logger)->log("Event Name: $eventName. \n Event Body: $message->body. \n Error: {$exception->getMessage()}", 'error');
            DB::table(config('souktel-message-broker.database.failed_consumed_messages'))->insert([
                'queue'       => $queue,
                'routing_key' => $routingKey,
                'payload'     => $payload,
                'exception'   => $exception,
                'failed_at'   => Carbon::now()
            ]);
        } catch (\Exception $databaseException) {
            optional($this->logger)->log("Failed to store failed event {$eventName} with error = {$exception->getMessage()}, \n Error: {$databaseException->getMessage()}", 'error');
        }
    }

    public function storeSucceededConsumedEvents($queue, $routingKey, $payload)
    {
        try {
            DB::table(config('souktel-message-broker.database.succeeded_consumed_messages'))->insert([
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

    public function storeSucceedPublishedEvents($routeKey, $message, $queue)
    {
        try {
            DB::table(config('souktel-message-broker.database.succeeded_published_messages'))->insert([
                'queue'        => $queue,
                'routing_key'  => $routeKey,
                'payload'      => $message,
                'published_at' => Carbon::now()
            ]);
        } catch (\Exception $exception) {
            $eventName = $queue . ':' . $routeKey;
            optional($this->logger)->log("Failed to store published event {$eventName}, \n Error: {$exception->getMessage()}");
        }
    }

    public function storeFailedPublishedEvents($routeKey, $message, $queue, $exception)
    {
        try {
            DB::table(config('souktel-message-broker.database.failed_published_messages'))->insert([
                'queue'         => $queue,
                'routing_key'   => $routeKey,
                'payload'       => $message,
                'exception' => $exception,
                'failed_at'     => Carbon::now()
            ]);
        } catch (\Exception $databaseException) {
            $eventName = $queue . ':' . $routeKey;
            optional($this->logger)->log("Failed to store published event {$eventName}, \n Error: {$databaseException->getMessage()}");
        }
    }
}
