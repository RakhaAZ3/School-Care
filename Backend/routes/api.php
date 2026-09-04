<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KategoriSaranaController;
use Illuminate\Support\Facades\Route;

// ==== Route Publik (tidak perlu login) ====
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// ==== Route yang wajib login (pakai token Sanctum) ====
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // CRUD Kategori Sarana
    // GET    /api/kategori-sarana        -> index
    // POST   /api/kategori-sarana        -> store
    // GET    /api/kategori-sarana/{id}   -> show
    // PUT    /api/kategori-sarana/{id}   -> update
    // DELETE /api/kategori-sarana/{id}   -> destroy
    Route::apiResource('kategori-sarana', KategoriSaranaController::class);
});