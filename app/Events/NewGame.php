<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

use App\Games;
use App\User;

class NewGame extends Event implements ShouldBroadcast
{
    use SerializesModels;
    public $new;
    // public $wins;
    // public $kds;
    // public $matches;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($new)
    {
        $this->new      = $new;
        // $this->wins     = User::getMostWinsAttribute();
        // $this->kds      = User::getKDAttribute();
        // $this->matches  = Games::matches()->toArray();
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
