<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengajuan_barang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pemohon_id')->constrained('users')->cascadeOnDelete();
            $table->string('nama_barang');
            $table->integer('jumlah')->default(1);
            $table->decimal('estimasi_biaya', 15, 2)->nullable();
            $table->text('alasan')->nullable();
            $table->enum('status', ['Menunggu', 'Disetujui', 'Ditolak'])->default('Menunggu');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan_barang');
    }
};