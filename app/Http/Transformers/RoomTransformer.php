<?php

namespace App\Http\Transformers;

use App\Room;
use League\Fractal\TransformerAbstract;

class RoomTransformer extends TransformerAbstract
{

    /**
     * @param Room $room
     * @return array
     */
    public function transform(Room $room): array
    {
        return [
            'status' => $room->status,
            'code' => $room->code
        ];
    }

}
