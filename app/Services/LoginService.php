<?php

namespace App\Services;

use App\Http\ResponseErrors;
use App\User;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginService extends Service
{

    /**
     * @param array $credentials
     * @return User|null
     */
    public function login(array $credentials): ?User
    {
        try {
            $token = JWTAuth::attempt($credentials);

            if (!$token) {
                $this->errors[] = ResponseErrors::INVALID_CREDENTIALS;
                return null;
            }
        } catch (JWTException $e) {
            $this->errors[] = ResponseErrors::COULD_NOT_CREATE_TOKEN;
            return null;
        }

        $user = User::whereEmail($credentials['email'])->first();
        $user->token = $token;
        return $user;
    }

}
