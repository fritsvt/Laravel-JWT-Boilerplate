<?php

namespace App\Http\Middleware;

use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class JWTAuthMiddleware extends \Tymon\JWTAuth\Http\Middleware\Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        if (! $token = $this->auth->setRequest($request)->getToken()) {
            return response()->json([
                'success' => false,
                'message' => "token not provided"
            ], 400);
        }
        try {
            $user = $this->auth->authenticate($token);
        } catch (TokenExpiredException $e) {
//            return $this->respond('tymon.jwt.expired', 'token_expired', $e->getStatusCode(), [$e]);
            return response()->json([
                'success' => false,
                'message' => "token expired"
            ], 401);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => "token invalid"
            ], 401);
//            return $this->respond('tymon.jwt.invalid', 'token_invalid', $e->getStatusCode(), [$e]);
        }
        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => "user not found"
            ], 404);
//            return $this->respond('tymon.jwt.user_not_found', 'user_not_found', 404);
        }
//        $this->events->fire('tymon.jwt.valid', $user);
        return $next($request);
    }
}

