<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UpdatePlayers extends Event implements ShouldBroadcast
{
    use SerializesModels;
    public $player1, $player2;
    protected $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($card1,$card2, User $user)
    {
        $this->user = $user;
        $player1 = $user->where('card_id',$card1)->first();
        $player2 = $user->where('card_id',$card2)->first();

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
        return ['player-channel'];
    }
}
