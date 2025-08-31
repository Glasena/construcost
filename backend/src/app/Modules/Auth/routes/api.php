<?php

use Illuminate\Http\Request;
use App\Modules\Auth\Http\Controllers\AuthController;

// Rotas públicas (não precisam de token)
Route::post('/login', [AuthController::class, 'login']);

// Rotas protegidas (precisam de token)
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', [AuthController::class, 'logout']);

});