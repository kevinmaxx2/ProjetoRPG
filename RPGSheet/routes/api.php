<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CharacterController;
use Laravel\Sanctum\Http\Controllers\CsrfCookieController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [UserController::class, 'store']);


Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::prefix('user')->group(function () {
        Route::get('/{id}', [UserController::class, 'show']);
        Route::put('/{id}', [UserController::class, 'update']);
        Route::delete('/{id}', [UserController::class, 'destroy']);
    });
    Route::prefix('characters')->group(function () {
        Route::get('/', [CharacterController::class, 'index']);
        Route::get('/', [CharacterController::class, 'store']);
        Route::post('/{uniqueId}', [CharacterController::class, 'show']);
        Route::put('/{uniqueId}', [CharacterController::class, 'update']);
        Route::delete('/{uniqueId}', [CharacterController::class, 'destroy']);
    });
});

Route::get('/sanctum/csrf-cookie', [CsrfCookieController::class, 'show']);