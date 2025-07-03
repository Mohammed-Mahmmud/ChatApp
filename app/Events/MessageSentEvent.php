<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSentEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public $message, public $user)
    {
        $this->message = $message;
        $this->user = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */

    public function toArray()
    {
        return [
            'message' => $this->message,
            'user' => $this->user,
        ];
    }

    public function via(): array
    {
        return ['broadcast'];
    }

    public function broadcastOn(): array
    {
        return [new Channel('message-sent')];
    }
    // public function broadcastWith(){
    //     return [
    //         'message' => $this->message,
    //         'user' => $this->user,
    //     ];
    // }
    // public function broadcastAs(){
    //     return 'message-sent';
    // }
}
