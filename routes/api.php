<?php

use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\PositionController;
use App\Http\Controllers\Api\v1\UserController;
use App\Http\Middleware\CheckTokenLastUsed;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('users', [UserController::class, 'store']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('token', [AuthController::class, 'getToken']);
        Route::get('positions', [PositionController::class, 'index']);
        Route::get('logout', [AuthController::class, 'logout']);
        Route::get('users', [UserController::class, 'index']);
    });

    Route::middleware(['auth:sanctum', CheckTokenLastUsed::class])->group(function () {
        Route::apiResource('users', UserController::class)->except(['index', 'store']);
    });
});
