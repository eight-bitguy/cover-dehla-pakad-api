<?php

namespace App\Http\Transformers;

use App\Room;
use League\Fractal\TransformerAbstract;

/**
 * Class CardArrayTransformer.
 *
 * Transform multidimensional associative array of validation errors into string
 *
 * @package App\Http\Transformers
 */
class CardArrayTransformer extends TransformerAbstract
{
    /**
     * @param array $cardsArray
     * @return array
     */
    public function transform(array $cardsArray): array
    {
        return $cardsArray;
    }
}
