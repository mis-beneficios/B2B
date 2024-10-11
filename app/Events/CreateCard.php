<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CreateCard
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $tarjeta;
    public $user;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($tarjeta, $user)
    {
        $this->tarjeta = $tarjeta;
        $this->user    = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    // public function broadcastOn()
    // {
    //     return new PrivateChannel('channel-name');
    // }
}
