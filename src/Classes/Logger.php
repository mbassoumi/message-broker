<?php


namespace Souktel\MessageBroker\Classes;


use Illuminate\Support\Facades\Log;

class Logger
{

    public function log($message = '', $logType = 'info')
    {
        Log::channel(config('souktel-message-broker.log.channel'))->$logType($message);
    }
}