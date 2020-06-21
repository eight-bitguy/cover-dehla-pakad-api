<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function apiAs($user, $method, $uri, array $data = [], array $headers = [])
    {
        $headers = array_merge(['Authorization' => 'Bearer ' . JWTAuth::fromUser($user)], $headers);

        return $this->api($method, $uri, $data, $headers);
    }


    protected function api($method, $uri, array $data = [], array $headers = [])
    {
        return $this->json($method, $uri, $data, $headers);
    }
}
