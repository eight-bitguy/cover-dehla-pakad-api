<?php

namespace App\Services;

class Service
{
    protected $errors = [];

    public function getErrors(): array
    {
        return $this->errors;
    }
}
