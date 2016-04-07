<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MessageSystem extends Event implements ShouldBroadcast
{
    use SerializesModels;
    public $class;
    public $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($class, $message)
    {
        $this->class = $class;
        $this->message = $message;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['message-channel'];
    }
}
