<?php

namespace App\Services;

class Service
{
    protected $errors = [];

    public function getErrors(): string
    {
        return $this->errors[0];
    }
}
