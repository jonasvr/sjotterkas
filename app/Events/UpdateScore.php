<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UpdateScore extends Event implements ShouldBroadcast
{
    use SerializesModels;
    public $points_left;
    public $points_right;


    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($points_right,$points_left)
    {
        $this->points_left = $points_left;
        $this->points_right = $points_right;
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
