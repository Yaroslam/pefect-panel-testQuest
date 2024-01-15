<?php

use App\Http\Middleware\TokenAuth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware([TokenAuth::class])->group(function () {
    Route::any('/v1', [App\Http\Controllers\ExchangeController::class, 'index']);
});

Route::get('/v1/token', [\App\Http\Controllers\TokenController::class, 'index']);
