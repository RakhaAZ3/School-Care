<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_kerusakan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sarana_id')->constrained('sarana')->cascadeOnDelete();
            $table->foreignId('pelapor_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('ditangani_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->date('tanggal_lapor');
            $table->text('deskripsi_kerusakan');
            $table->enum('tingkat_kerusakan', ['ringan', 'sedang', 'berat']);
            $table->enum('status', ['menunggu', 'diproses', 'selesai', 'ditolak'])->default('menunggu');
            $table->text('tindak_lanjut')->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_kerusakan');
    }
};