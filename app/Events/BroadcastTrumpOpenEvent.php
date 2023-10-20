<?php

namespace App\Events;

use App\Game;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class BroadcastTrumpOpenEvent implements ShouldBroadcast
{
    use Dispatchable;

    /**
     * @var Game
     */
    private $game;
    /**
     * Create a new event instance.
     *
     * @param Game $game
     */
    public function __construct(Game $game)
    {
        $this->game = $game;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return PrivateChannel
     */
    public function broadcastOn()
    {
        $room = $this->game->room;
        return new PrivateChannel("App.room.{$room->code}");
    }

    public function broadcastWith()
    {
        return [];
    }
}
