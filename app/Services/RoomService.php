<?php

namespace App\Services;

use App\Events\BroadcastNewGameEvent;
use App\Events\BroadcastNewPlayerJoinEvent;
use App\Events\BroadcastRoomStartEvent;
use App\Http\ResponseErrors;
use App\Room;
use App\User;
use Carbon\Carbon;

class RoomService extends Service
{

    public function __construct(GameService $gameService)
    {
        $this->gameService = $gameService;
    }

    /**
     * @param User $user
     * @return Room
     */
    public function createRoom(User $user): Room
    {
        $randomCode = mt_rand(100000, 999999);
        $room = Room::create([
            'code' => $randomCode,
            'status' => Room::ROOM_STATUS_JOINING
        ]);
        $room->users()->attach($user->id, ['position' => Room::POSITION_A1]);
        return $room;
    }

    /**
     * @param Room $room
     * @param User $user
     * @return bool
     */
    public function canJoinRoom(Room $room, User $user): bool
    {
        if ($room->isInactive()) {
            $this->errors[] = ResponseErrors::ROOM_IS_INACTIVE;
            return false;
        }

        if ($room->isUserPresentInTheRoom($user)) {
            return true;
        }

        if ($room->isFull()) {
            $this->errors[] = ResponseErrors::ROOM_IS_FULL;
            return false;
        }

        return true;
    }

    public function canStartRoom(Room $room, User $user): bool
    {
        if (!$room->isRoomAdmin($user)) {
            $this->errors[] = ResponseErrors::USER_IS_NOT_ROOM_ADMIN;
            return false;
        }

        if ($room->isInactive()) {
            $this->errors[] = ResponseErrors::ROOM_IS_INACTIVE;
            return false;
        }

        if (!$room->isFull()) {
            $this->errors[] = ResponseErrors::ROOM_IS_NOT_FULL;
            return false;
        }

        return true;
    }

    /**
     * @param Room $room
     * @param User $user
     * @return bool
     */
    public function joinRoom(Room $room, User $user): bool
    {
        if (!$room->isUserPresentInTheRoom($user)) {
            $emptyPosition = $room->getFirstEmptyPosition();
            $room->users()->attach($user->id, ['position' => $emptyPosition]);
        }

        broadcast(new BroadcastNewPlayerJoinEvent($room));

        if ($room->isActive()) {
            broadcast(new BroadcastNewGameEvent($room->game));
        }

        return true;
    }

    /**
     * @param Room $room
     * @return bool
     */
    public function startRoom(Room $room): bool
    {
        $room->status = Room::ROOM_STATUS_ACTIVE;
        $room->save();

        broadcast(new BroadcastRoomStartEvent($room));

        return true;
    }
}
