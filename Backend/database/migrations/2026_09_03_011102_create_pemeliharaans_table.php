<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemeliharaan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sarana_id')->constrained('sarana')->cascadeOnDelete();
            $table->foreignId('petugas_id')->constrained('users')->cascadeOnDelete();
            $table->date('tanggal_pemeliharaan');
            $table->enum('jenis_pemeliharaan', ['rutin', 'perbaikan']);
            $table->decimal('biaya', 15, 2)->nullable();
            $table->enum('status', ['dijadwalkan', 'proses', 'selesai'])->default('dijadwalkan');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemeliharaan');
    }
};