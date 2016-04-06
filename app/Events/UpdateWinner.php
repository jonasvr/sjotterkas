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

        $wins           = User::getMostWinsAttribute();
        $this->wins     = array_slice($wins, 0, 8, true);

        $kd             = User::getKDAttribute();
        $this->kds      = array_slice($kd, 0, 4, true);

        $this->matches  = Games::getMatchesAttribute();
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
