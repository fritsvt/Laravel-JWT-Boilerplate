<?php

namespace App\Http\Controllers\api;

use App\Helpers\Obfuscate;
use Illuminate\Foundation\Inspiring;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return response()->json([
            "success" => true,
            "quote" => Inspiring::quote()
        ]);
    }

    public function test(Request $request)
    {
        return response(
            Obfuscate::obfuscate(json_encode([
                'wow' => true
            ]), 101)
        );
    }
}
