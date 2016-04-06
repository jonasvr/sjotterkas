<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

use App\Games;
use App\User;


class UpdateWinner extends Event implements ShouldBroadcast
{
    use SerializesModels;
    public $winner;
    public $wins;
    public $kds;
    public $matches;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($winner)
    {
        $this->winner   = $winner;
        $this->wins     = User::getMostWinsAttribute();
        $this->kds      = User::getKDAttribute();
        $this->matches  = Games::matches()->toArray();
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
