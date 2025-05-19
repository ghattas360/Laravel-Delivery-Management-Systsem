<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ClientMessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $clientId;

    /**
     * Create a new event instance.
     */
    public function __construct($clientId, $message)
    {
        $this->clientId = $clientId;
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     * each client will have a private channel
     */
    public function broadcastOn()
    {
        return new PrivateChannel('chat-client.' . $this->clientId);
    }

    /**
     * Name of the event that will be broadcasted.
     */
    public function broadcastAs()
    {
        return 'client-message';
    }
}
