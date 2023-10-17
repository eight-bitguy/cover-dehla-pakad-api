<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Game extends Model
{
    protected $casts = [
        'a1' => 'array',
        'a2' => 'array',
        'b1' => 'array',
        'b2' => 'array',
        'score' => 'array',
        'dehla_score' => 'array',
        'stake' => 'array',
        'trump_hidden_by' => 'string'
    ];

    public function getUserPosition(User $user)
    {
        return $this->users()->where('id', $user->id)->first()['pivot']['position'];
    }

    public function users()
    {
        return $this->room->users;
    }

    /**
     * @return BelongsTo
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * @return string
     */
    public function getSimpleNextPosition(): string
    {
        $playedByIndex = array_search($this->played_by, Room::ALL_POSITIONS);
        $nextChance = ($playedByIndex + 1) % 4;
        return Room::ALL_POSITIONS[$nextChance];
    }

    /**
     * @return string
     */
    public function getNextChancePosition(): string
    {
        $numberOfCardsInStake = count($this->stake);

        if ($numberOfCardsInStake < 4 && !$this->played_by) {
            return $this->next_chance;
        }

        if ($numberOfCardsInStake < 4) {
            return $this->getSimpleNextPosition();
        }

        if (!$numberOfCardsInStake) {
            return $this->next_chance;
        }
        return '';
    }

    /**
     * Get previous game
     * @return mixed
     */
    public function getPreviousGame()
    {
       return Game::where('room_id', $this->room_id)
           ->where('id', '<', (+$this->id))
           ->orderBy('id', 'desc')
           ->first();
    }

}
