<?php

namespace App\Http\Transformers;

use App\Room;
use League\Fractal\TransformerAbstract;

class ScoreTransformer extends TransformerAbstract
{

    /**
     * @param Room $room
     * @return array
     */
    public function transform(Room $room): array
    {
        $game = $room->getLatestGame();
        return [
            'score' => $game->score,
            'dehlaScore' => $game->dehla_score
        ];
    }

}
