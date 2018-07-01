<?php

namespace App\Http\Controllers\api\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;

class UserInfoController extends Controller
{
    protected $auth;

    public function __construct(JWTAuth $auth)
    {
        $this->auth = $auth;
    }

    public function index(Request $request)
    {
        $user = $request->user();
        return response()->json([
            'success' => true,
            'errors' => [],
            'data' => $user->toArray()
        ], 200);
    }

    public function logout()
    {
        $this->auth->invalidate($this->auth->getToken());

        return response()->json([
            'success' => true
        ], 200);
    }
}