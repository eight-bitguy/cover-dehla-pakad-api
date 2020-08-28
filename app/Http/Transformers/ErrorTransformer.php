<?php

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;

/**
 * Class ErrorTransformer.
 *
 * Transform multidimensional associative array of validation errors into string
 *
 * @package App\Http\Transformers
 */
class ErrorTransformer extends TransformerAbstract
{
    /**
     * Response http status code
     *
     * @var int
     */
    private $statusCode;

    /**
     * ErrorTransformer constructor.
     *
     * @param int $statusCode Http status code
     */
    public function __construct(int $statusCode)
    {
        $this->statusCode = $statusCode;
    }

    /**
     * Transform errors into string.
     *
     * @param string $errors Validation errors array
     *
     * @return array
     */
    public function transform(string $errors) : array
    {
        return [
            'code' => $this->statusCode,
            'status_code' => $this->statusCode,
            'errors' => $errors
        ];
    }

}
