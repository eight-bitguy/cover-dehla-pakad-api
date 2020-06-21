<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Room extends Model
{
    protected $fillable = [
        'code',
        'status'
    ];

    const ROOM_STATUS_JOINING = 'joining';
    const ROOM_STATUS_ACTIVE = 'active';
    const ROOM_STATUS_INACTIVE = 'inactive';

    const POSITION_A1 = 'a1';
    const POSITION_B1 = 'b1';
    const POSITION_A2 = 'a2';
    const POSITION_B2 = 'b2';

    const ALL_POSITIONS = [
        Room::POSITION_A1,
        Room::POSITION_B1,
        Room::POSITION_A2,
        Room::POSITION_B2,
    ];

    const MAXIMUM_USER_ALLOWED = 4;

    /**
     * @return BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'room_users')->withPivot('position');
    }

    /**
     * @return bool
     */
    public function isInactive()
    {
        return $this->status === self::ROOM_STATUS_INACTIVE;
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->status === self::ROOM_STATUS_ACTIVE;
    }

    /**
     * @return bool
     */
    public function isFull()
    {
        return $this->users()->count() === Room::MAXIMUM_USER_ALLOWED;
    }

    /**
     * @return mixed
     */
    public function getFirstEmptyPosition()
    {
        $occupiedPositions = $this->users->pluck('pivot.position')->toArray();
        return array_values(array_diff(Room::ALL_POSITIONS, $occupiedPositions))[0];
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function isUserPresentInTheRoom(User $user)
    {
        return $this->users->contains('id', $user->id);
    }

    /**
     * @param string $userId
     * @return mixed
     */
    public function getUserPositionInRoom(string $userId)
    {
        return $this->users->pluck('pivot.position', 'pivot.user_id')->toArray()[$userId];
    }

    /**
     * @param User $user
     * @return bool
     */
    public function isRoomAdmin(User $user)
    {
        $roomUser = $this->users->pluck('pivot.position', 'pivot.user_id')->toArray();
        return isset($roomUser[$user->id]) && $roomUser[$user->id] === self::POSITION_A1;
    }

    /**
     * @return HasOne
     */
    public function game()
    {
        return $this->hasOne(Game::class)->latest();
    }

    public function games()
    {
        return $this->hasMany(Game::class);
    }

    public function iterationMove()
    {
        return $this->games()->where('stake', [])->whereNull('played_by')->latest();
    }
}
