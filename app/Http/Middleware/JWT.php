<?php

namespace App\Http\Middleware;

use App\Http\ResponseErrors;
use Closure;
use Illuminate\Http\Request;
use Exception;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JWT extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            if (!$user) {
                throw new Exception('User Not Found');
            }
        } catch (Exception $e) {
            if ($e instanceof TokenInvalidException) {
                return response()->json([
                        'code' => 401,
                        'status_code' => 401,
                        'errors' => [ResponseErrors::INVALID_TOKEN]
                    ]
                );
            } else if ($e instanceof TokenExpiredException) {
                return response()->json([
                        'code' => 401,
                        'status_code' => 401,
                        'errors' => [ResponseErrors::TOKEN_EXPIRED]
                    ]
                );
            } else {
                if ($e->getMessage() === 'User Not Found') {
                    return response()->json([
                            'code' => 401,
                            'status_code' => 401,
                            'errors' => [ResponseErrors::USER_NOT_FOUND]
                        ]
                    );
                }
                return response()->json([
                        'code' => 401,
                        'status_code' => 401,
                        'errors' => [ResponseErrors::TOKEN_NOT_FOUND]
                    ]
                );
            }
        }
        return $next($request);
    }
}
