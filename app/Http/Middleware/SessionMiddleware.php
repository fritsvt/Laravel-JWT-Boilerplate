<?php

namespace App\Http\Middleware;

use App\Helpers\Obfuscate;
use App\Models\Session;
use Closure;

class SessionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $valid = false;
        $session = Session::where('hash', $request->header('session'))->first();

        if ($session) {
            $valid = true;
            $session = $session->hash;
        }
        $session = [
          'valid' => $valid,
          'session' => $session
        ];

        $request->attributes->add(['session' => $session]);

        return $next($request);
    }
}
