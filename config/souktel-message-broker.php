<?php


return [

    'database' => [
        'enable'                      => true,
        'succeeded_consumed_messages' => 'succeeded_consumed_messages',
        'failed_consumed_messages'    => 'failed_consumed_messages',
        'succeed_published_messages'  => 'succeed_published_messages',
        'failed_published_messages'   => 'failed_published_messages'
    ],

    'log' => [
        'enable'  => true,
        'channel' => 'stack',
    ],

    'settings' => [
        'host'            => env('RABBITMQ_HOST'),
        'port'            => 5672,
        'username'        => env('RABBITMQ_USERNAME'),
        'password'        => env('RABBITMQ_PASSWORD'),
        'vhost'           => env('RABBITMQ_VHOST'),
        'connect_options' => [],
        'ssl_options'     => [],


        'exchange'             => 'amq.topic',
        'exchange_type'        => 'topic',
        'exchange_passive'     => false,
        'exchange_durable'     => true,
        'exchange_auto_delete' => false,
        'exchange_internal'    => false,
        'exchange_nowait'      => false,
        'exchange_properties'  => [],

        'queue_force_declare' => false,
        'queue_passive'       => false,
        'queue_durable'       => true,
        'queue_exclusive'     => false,
        'queue_auto_delete'   => false,
        'queue_nowait'        => false,
        'queue_properties'    => ['x-ha-policy' => ['S', 'all']],

        'consumer_tag'       => '',
        'consumer_no_local'  => false,
        'consumer_no_ack'    => false,
        'consumer_exclusive' => false,
        'consumer_nowait'    => false,
        'timeout'            => 0,
        'persistent'         => false,

        'qos'                => false,
        'qos_prefetch_size'  => 0,
        'qos_prefetch_count' => 1,
        'qos_a_global'       => false,
    ]
];