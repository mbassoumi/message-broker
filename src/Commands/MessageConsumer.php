<?php

namespace Souktel\MessageBroker\Commands;

use Illuminate\Console\Command;
use WebEd\Base\Support\EventManager;

class MessageConsumer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'messages:consume {queue}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Messages Consumer.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $queue = $this->argument('queue');

        $this->warn('Consuming  ' . $queue . '.');

        app('MessageBroker')->consume($queue);

    }
}
