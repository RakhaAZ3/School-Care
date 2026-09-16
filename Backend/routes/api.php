<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KategoriSaranaController;
use App\Http\Controllers\RuanganController;
use Illuminate\Support\Facades\Route;

// ==== Route Publik (tidak perlu login) ====
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// ==== Route yang wajib login (pakai token Sanctum) ====
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // CRUD Kategori Sarana
    Route::apiResource('kategori', KategoriSaranaController::class);

    // CRUD Ruangan
    // GET    /api/ruangan        -> index
    // POST   /api/ruangan        -> store
    // GET    /api/ruangan/{id}   -> show
    // PUT    /api/ruangan/{id}   -> update
    // DELETE /api/ruangan/{id}   -> destroy
    Route::apiResource('ruangan', RuanganController::class);
});