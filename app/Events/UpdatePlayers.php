<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UpdatePlayers extends Event implements ShouldBroadcast
{
    use SerializesModels;
    public $player1, $player2;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($player1,$player2)
    {
        $this->player1 = $player1;
        $this->player2 = $player2;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
      echo 'player';
        return ['player-channel'];
    }
}
