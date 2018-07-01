<?php

namespace App\Http\Middleware;

use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class JWTAuthNotLoggedInMiddleware extends \Tymon\JWTAuth\Http\Middleware\Authenticate
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
        $token = $this->auth->setRequest($request)->getToken();
        try {
            $this->auth->authenticate($token);
        } catch (TokenExpiredException $e) {
            //
        } catch (JWTException $e) {
            //
        }

        return $next($request);
    }
}

