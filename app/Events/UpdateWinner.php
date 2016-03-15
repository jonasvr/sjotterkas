<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UpdateWinner extends Event implements ShouldBroadcast
{
    use SerializesModels;
    public $winner;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($winner)
    {
        $this->winner=$winner;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['winner-channel'];
    }
}
