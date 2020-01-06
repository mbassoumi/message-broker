<?php


namespace Souktel\MessageBroker\Classes;


/**
 * manage events through message broker [RabbitMQ]
 *
 * Class EventManager
 * @package App\Events
 */
class MessageBroker
{

    /** @var DatabaseLogging|null $databaseLogging */
    protected $databaseLogging = null;

    protected $logger = null;

    public function __construct()
    {
        if (config('souktel-message-broker.log.enable')) {
            $this->logger = new Logger();
        }

        if (config('souktel-message-broker.database.enable')) {
            $this->databaseLogging = new DatabaseLogging($this->logger);
        }

    }


    /**
     * publish event to specific queue on RabbitMQ with specific route-key
     * routeKey present the name of fired event
     *
     * @param $routeKey
     * @param array|string $message
     * @param $queue
     */
    public function publish($routeKey, $message, $queue)
    {
        try {
            if (!is_string($message)) {
                $message = json_encode($message);
            }
            \Amqp::publish($routeKey, $message, ['queue' => $queue]);
            optional($this->databaseLogging)->storeSucceedPublishedEvents($routeKey, $message, $queue);
        } catch (\Exception $exception) {
            optional($this->databaseLogging)->storeFailedPublishedEvents($routeKey, $message, $queue, $exception);
        }
    }

    /**
     * consume messages from data collection queue on RabbitMQ or from specific queue
     *
     * @param $queue
     */
    public function consume($queue)
    {

        \Amqp::consume($queue, function ($message, $resolver) use ($queue) {
            $routingKey = '';
            $eventName = '';
            try {
                $routingKey = $message->delivery_info['routing_key'];
                $eventName = $queue . ':' . $routingKey;
                event($eventName, [json_decode($message->body, true)]);
                optional($this->databaseLogging)->storeSucceededConsumedEvents($queue, $routingKey, $message->body);
            } catch (\Exception $exception) {
                optional($this->databaseLogging)->storeFailedConsumedEvents($queue, $routingKey, $message->body, $message, $exception);
            }
            $resolver->acknowledge($message);
        }, [
            'persistent' => true
        ]);
    }


}
