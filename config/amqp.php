<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Define which configuration should be used
    |--------------------------------------------------------------------------
    */

    'use' => 'production',

    /*
    |--------------------------------------------------------------------------
    | AMQP properties separated by key
    |--------------------------------------------------------------------------
    */

    'properties' => [

        'production' => [
            'test_env'             => env('SOUKTEL_TEST'),
            'test_static'          => 'SOUKTEL_TEST',
            'test_config'           => config('souktel-message-broker.settings.souktel_test'),


            'host'                 => config('souktel-message-broker.settings.host'),
            'port'                 => config('souktel-message-broker.settings.port'), // 5672
            'username'             => config('souktel-message-broker.settings.username'), //env('RABBITMQ_USERNAME'),
            'password'             => config('souktel-message-broker.settings.password'), //env('RABBITMQ_PASSWORD'),
            'vhost'                => config('souktel-message-broker.settings.vhost'), //env('RABBITMQ_VHOST'),
            'connect_options'      => config('souktel-message-broker.settings.connect_options', []),
            'ssl_options'          => config('souktel-message-broker.settings.ssl_options', []),
            'exchange'             => 'amq.direct',
            'exchange_type'        => 'direct',
            'exchange_passive'     => config('souktel-message-broker.settings.exchange_passive', false),
            'exchange_durable'     => config('souktel-message-broker.settings.exchange_durable', true),
            'exchange_auto_delete' => config('souktel-message-broker.settings.exchange_auto_delete', false),
            'exchange_internal'    => config('souktel-message-broker.settings.exchange_internal', false),
            'exchange_nowait'      => config('souktel-message-broker.settings.exchange_nowait', false),
            'exchange_properties'  => config('souktel-message-broker.settings.exchange_properties', []),
            'queue_force_declare'  => config('souktel-message-broker.settings.queue_force_declare', false),
            'queue_passive'        => config('souktel-message-broker.settings.queue_passive', false),
            'queue_durable'        => config('souktel-message-broker.settings.queue_durable', true),
            'queue_exclusive'      => config('souktel-message-broker.settings.queue_exclusive', false),
            'queue_auto_delete'    => config('souktel-message-broker.settings.queue_auto_delete', false),
            'queue_nowait'         => config('souktel-message-broker.settings.queue_nowait', false),
            'queue_properties'     => ['x-ha-policy' => ['S', 'all']],
            'consumer_tag'         => '',
            'consumer_no_local'    => config('souktel-message-broker.settings.consumer_no_local', false),
            'consumer_no_ack'      => config('souktel-message-broker.settings.consumer_no_ack', false),
            'consumer_exclusive'   => config('souktel-message-broker.settings.consumer_exclusive', false),
            'consumer_nowait'      => config('souktel-message-broker.settings.consumer_nowait', false),
            'timeout'              => config('souktel-message-broker.settings.timeout', 0),
            'persistent'           => config('souktel-message-broker.settings.persistent', false),
            'qos'                  => config('souktel-message-broker.settings.qos', false),
            'qos_prefetch_size'    => config('souktel-message-broker.settings.qos_prefetch_size', 0),
            'qos_prefetch_count'   => config('souktel-message-broker.settings.connect_options', 1),
            'qos_a_global'         => config('souktel-message-broker.settings.qos_prefetch_count', false),
        ],

    ],

];
