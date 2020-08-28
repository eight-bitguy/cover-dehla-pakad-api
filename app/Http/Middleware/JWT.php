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
use Symfony\Component\HttpFoundation\Response;

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
                return response()->json(
                    ['errors' => ResponseErrors::INVALID_TOKEN],
                    Response::HTTP_UNAUTHORIZED
                );
            } else if ($e instanceof TokenExpiredException) {
                return response()->json(
                    ['errors' => ResponseErrors::TOKEN_EXPIRED],
                    Response::HTTP_UNAUTHORIZED
                );
            } else {
                if ($e->getMessage() === 'User Not Found') {
                    return response()->json(
                        ['errors' => ResponseErrors::USER_NOT_FOUND],
                        Response::HTTP_UNAUTHORIZED
                    );
                }
                return response()->json(
                    ['errors' => ResponseErrors::TOKEN_NOT_FOUND],
                    Response::HTTP_UNAUTHORIZED
                );
            }
        }
        return $next($request);
    }
}
