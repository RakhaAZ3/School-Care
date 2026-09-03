<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SaranaController;
use Illuminate\Support\Facades\Route;

// ==== Route Publik (tidak perlu login) ====
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// ==== Route yang wajib login (pakai token Sanctum) ====
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // Minimal 1 CRUD: Sarana
    // GET    /api/sarana        -> index
    // POST   /api/sarana        -> store
    // GET    /api/sarana/{id}   -> show
    // PUT    /api/sarana/{id}   -> update
    // DELETE /api/sarana/{id}   -> destroy
    Route::apiResource('sarana', SaranaController::class);
});