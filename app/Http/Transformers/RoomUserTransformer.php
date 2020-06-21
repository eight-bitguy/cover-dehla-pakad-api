<?php

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;

class RoomUserTransformer extends TransformerAbstract
{

    /**
     * @param array $roomUser
     * @return array
     */
    public function transform(array $roomUser): array
    {
        return $roomUser;
    }

}
