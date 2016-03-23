<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewCard extends Event implements ShouldBroadcast
{
    use SerializesModels;
    public $card_id;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($card_id)
    {
        $this->card_id = $card_id;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['card-channel'];
    }
}
