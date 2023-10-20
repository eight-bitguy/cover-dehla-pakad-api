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
        'trump_hidden_by' => 'string',
        'stake_with_user' => 'array'
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
     * Get previous game
     * @return mixed
     */
    public function getPreviousGame()
    {
       return Game::where('room_id', $this->room_id)
           ->where('id', '<', $this->id)
           ->orderBy('id', 'desc')
           ->first();
    }

    public function getFullStake()
    {
        if (!$this->getPreviousGame()) {
            return $this->stake_with_user;
        }
        return $this->stake_with_user === [] ? 
            $this->getPreviousGame()->stake_with_user : $this->stake_with_user;
    }

}
