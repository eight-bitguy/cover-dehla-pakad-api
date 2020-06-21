<?php

namespace App\Services;

use App\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserService extends Service
{
    /**
     * @param array $userAttributes
     * @return User|null
     */
    public function register(array $userAttributes): ?User
    {
        $user = User::make(
            [
                'name' => $userAttributes['name'],
                'email' => $userAttributes['email'],
                'password' => $userAttributes['password']
            ]
        );
        if (!$user->save()) {
            $this->errors[] = $user->errors;
            return null;
        }
        $token = JWTAuth::fromUser($user);
        $user->token = $token;
        return $user;
    }

}
