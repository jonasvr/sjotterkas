<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UpdateScore extends Event implements ShouldBroadcast
{
    use SerializesModels;
    public $points_green;
    public $points_black;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($points_green,$points_black)
    {
        $this->points_black = $points_black;
        $this->points_green = $points_green;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
       return ['points-channel'];
    }
}
