<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewGame extends Event implements ShouldBroadcast
{
    use SerializesModels;
    public $new;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($new)
    {
        $this->new = $new;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['new-channel'];
    }
}
