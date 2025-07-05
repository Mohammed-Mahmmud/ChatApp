<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Events\MessagePublicEvent;

class ChatChange extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:chat-change{--name=}{--value=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $message = $this->option('name');
        $value = $this->option('value');
        MessagePublicEvent::dispatch($message);
        MessagePublicEvent::dispatch($value);
    }
}
