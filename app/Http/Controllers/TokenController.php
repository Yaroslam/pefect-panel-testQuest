<?php

namespace App\Http\Controllers;

class TokenController extends Controller
{
    public function index()
    {
        return response()->json(['token' => env('API_TOKEN')]);
    }
}
