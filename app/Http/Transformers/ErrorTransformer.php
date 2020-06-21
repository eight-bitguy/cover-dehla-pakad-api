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
     * @param array $errors Validation errors array
     *
     * @return array
     */
    public function transform(array $errors) : array
    {
        $responseErrors = [];
        foreach ($errors as $error) {
            $responseErrors[] = is_array($error) ? $error[0] : $error;
        }

        return [
            'code' => $this->statusCode,
            'status_code' => $this->statusCode,
            'errors' => $responseErrors
        ];
    }

}
