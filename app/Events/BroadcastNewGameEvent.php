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
        return [
            'stake' => $this->game->stake,
            'oldStake' => [],
            'score' => $this->game->score,
            'dehlaOnStake' => $this->game->dehla_on_stake,
            'trump' => $this->game->trump,
            'trumpFromNextIteration' => $this->game->trump_from_next_iteration,
            'trumpDecidedBy' => $this->game->trump_decided_by,
            'claimingBy' => $this->game->claming_by,
            'nextChance' => $this->game->getNextChancePosition()
        ];
    }
}
