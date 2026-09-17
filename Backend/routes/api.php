<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KategoriSaranaController;
use App\Http\Controllers\LaporanKerusakanController;
use App\Http\Controllers\PemeliharaanController;
use App\Http\Controllers\PengajuanBarangController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\SaranaController;
use Illuminate\Support\Facades\Route;

// ==== Route Publik (tidak perlu login) ====
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// ==== Route yang wajib login ====
Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // ---------------------------------------------------------
    // BOLEH DIAKSES SEMUA USER LOGIN (admin & pengguna)
    // ---------------------------------------------------------

    // Lihat data master (butuh dilihat pengguna untuk isi form pinjam/lapor)
    Route::get('/kategori', [KategoriSaranaController::class, 'index']);
    Route::get('/kategori/{kategori}', [KategoriSaranaController::class, 'show']);

    Route::get('/ruangan', [RuanganController::class, 'index']);
    Route::get('/ruangan/{ruangan}', [RuanganController::class, 'show']);

    Route::get('/sarana', [SaranaController::class, 'index']);
    Route::get('/sarana/{sarana}', [SaranaController::class, 'show']);

    // Laporan kerusakan: semua user boleh lihat & buat laporan
    Route::get('/laporan-kerusakan', [LaporanKerusakanController::class, 'index']);
    Route::get('/laporan-kerusakan/{id}', [LaporanKerusakanController::class, 'show']);
    Route::post('/laporan-kerusakan', [LaporanKerusakanController::class, 'store']);

    // Peminjaman: semua user boleh lihat & ajukan pinjam
    Route::get('/peminjaman', [PeminjamanController::class, 'index']);
    Route::get('/peminjaman/{id}', [PeminjamanController::class, 'show']);
    Route::post('/peminjaman', [PeminjamanController::class, 'store']);

    // Pengajuan barang: semua user boleh lihat & ajukan
    Route::get('/pengajuan-barang', [PengajuanBarangController::class, 'index']);
    Route::get('/pengajuan-barang/{id}', [PengajuanBarangController::class, 'show']);
    Route::post('/pengajuan-barang', [PengajuanBarangController::class, 'store']);


    // ---------------------------------------------------------
    // KHUSUS ADMIN
    // ---------------------------------------------------------
    Route::middleware('role:admin')->group(function () {

        // Kelola data master (create, update, delete)
        Route::post('/kategori', [KategoriSaranaController::class, 'store']);
        Route::put('/kategori/{kategori}', [KategoriSaranaController::class, 'update']);
        Route::delete('/kategori/{kategori}', [KategoriSaranaController::class, 'destroy']);

        Route::post('/ruangan', [RuanganController::class, 'store']);
        Route::put('/ruangan/{ruangan}', [RuanganController::class, 'update']);
        Route::delete('/ruangan/{ruangan}', [RuanganController::class, 'destroy']);

        Route::post('/sarana', [SaranaController::class, 'store']);
        Route::put('/sarana/{sarana}', [SaranaController::class, 'update']);
        Route::delete('/sarana/{sarana}', [SaranaController::class, 'destroy']);

        // Update & hapus laporan kerusakan, ubah status
        Route::put('/laporan-kerusakan/{id}', [LaporanKerusakanController::class, 'update']);
        Route::delete('/laporan-kerusakan/{id}', [LaporanKerusakanController::class, 'destroy']);
        Route::patch('/laporan-kerusakan/{id}/status', [LaporanKerusakanController::class, 'updateStatus']);

        // Approve/reject peminjaman, hapus data
        Route::delete('/peminjaman/{id}', [PeminjamanController::class, 'destroy']);
        Route::patch('/peminjaman/{id}/status', [PeminjamanController::class, 'updateStatus']);

        // Approve/reject pengajuan barang, hapus data
        Route::delete('/pengajuan-barang/{id}', [PengajuanBarangController::class, 'destroy']);
        Route::patch('/pengajuan-barang/{id}/status', [PengajuanBarangController::class, 'updateStatus']);

        // Pemeliharaan sepenuhnya urusan admin
        Route::apiResource('pemeliharaan', PemeliharaanController::class);
    });
});