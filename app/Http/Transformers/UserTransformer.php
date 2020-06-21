<?php

namespace App\Http\Transformers;

use App\User;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    private $roomCode;

    /**
     * ItemTransformer constructor.
     * @param string $roomCode
     */
    public function __construct(string $roomCode = '')
    {
        $this->roomCode = $roomCode;
        $this->setAvailableIncludes(
            [
                'room_users'
            ]
        );
    }

    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'token' => $user->token,
        ];
    }

    public function includeRoomUsers(User $user): Item
    {
        if ($user->pivot) {
            $roomUser = $user->pivot->toArray();
            unset($roomUser['room_id']);
            $roomUser['roomCode'] = $this->roomCode;
            $roomUser['userId'] = $roomUser['user_id'];
            unset($roomUser['user_id']);
            return $this->item($roomUser, new RoomUserTransformer());
        }
    }

}
