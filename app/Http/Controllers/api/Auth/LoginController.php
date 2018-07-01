<?php

namespace App\Http\Controllers\api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\JWTAuth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $auth;

    public function __construct(JWTAuth $auth)
    {
        $this->auth = $auth;
    }

    public function login(Request $request)
    {
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return response()->json([
                'success' => false,
                'errors' => [
                    'Je probeert dat te snel'
                ]
            ], 403);
        }

//        $login_type = filter_var($request->input('username'), FILTER_VALIDATE_EMAIL )
//            ? 'email'
//            : 'username';
//
//        $request->merge([
//            $login_type => $request->input('username')
//        ]);
        $login_type = filter_var($request->input('email'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        try {
            if (!$token = $this->auth->attempt($request->only($login_type, 'password'))) {
                return response()->json([
                    'success' => false,
                    'errors' => [
                        'username' => [
                            'Ongeldige gebruikersnaam of wachtwoord'
                        ]
                    ]
                ], 422);
            }
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'username' => [
                    'Ongeldige gebruikersnaam of wachtwoord'
                ]
            ], 422);
        }

        return response()->json([
            'success' => true,
            'data' => $request->user()->toArray(),
            'meta' => [
                'token' => $token
            ]
        ]);
//        if (Auth::attempt($request->only($login_type, 'password'))) {
//            $user = $request->user();
//            if (!$user->api_token) {
//                $user->api_token = str_random(60);
//                $user->save();
//            }
//
//            return response()->json([
//                'success' => true,
//                'errors' => [],
//                'data' => $user->toArray()
//            ]);
//        } else {
//            $this->incrementLoginAttempts($request);
//
//            return response()->json([
//                'success' => false,
//                'errors' => [
//                    'Ongeldige gebruikersnaam of wachtwoord'
//                ]
//            ], 401);
//        }
    }
}