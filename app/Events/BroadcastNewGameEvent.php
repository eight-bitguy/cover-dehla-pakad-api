<?php

namespace App\Events;

use App\Game;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class BroadcastNewGameEvent implements ShouldBroadcast
{
    use Dispatchable;

    private $oldGame;
    private $game;

    /**
     * Create a new event instance.
     *
     * @param Game $oldGame
     * @param Game $game
     */
    public function __construct(?Game $oldGame, Game $game)
    {
        $this->oldGame = $oldGame;
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
        return [
            'stake' => $this->game->stake,
            'oldStake' => $this->oldGame ? $this->oldGame->stake : [],
            'nextChance' => $this->game->getNextChancePosition()
        ];
    }
}
