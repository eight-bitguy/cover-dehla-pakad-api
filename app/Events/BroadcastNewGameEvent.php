<?php

namespace App\Events;

use App\Game;
use App\Room;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class BroadcastNewGameEvent implements ShouldBroadcast
{
    use Dispatchable;

    /**
     * @var Game
     */
    private $oldGame;

    /**
     * @var Game
     */
    private $game;

    /**
     * @var Room
     */
    private $room;

    /**
     * Create a new event instance.
     *
     * @param Game $game
     */
    public function __construct(Game $game)
    {
        $this->game = $game;
        $this->oldGame = $game->getPreviousGame();
        $this->room = Room::find($game->room_id);
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
            'oldStakeFirstChance' => $this->oldGame ? $this->oldGame->getSimpleNextPosition() : '',
            'score' => $this->game->score,
            'dehlaScore' => $this->game->dehla_score,
            'trump' => $this->game->trump_decided_by ? $this->game->trump : null,
            'trumpHiddenBy' => $this->game->trump_hidden_by,
            'trumpDecidedBy' => $this->game->trump_decided_by,
            'nextChance' => $this->game->getNextChancePosition(),
            'roomStatus' => $this->room->status,
            'handDeck' => [
                'a1' => $this->game->a1,
                'a2' => $this->game->a2,
                'b1' => $this->game->b1,
                'b2' => $this->game->b2
            ]
        ];
    }
}
