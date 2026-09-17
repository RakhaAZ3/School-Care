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
            $table->string('jenis_perawatan');
            $table->string('teknisi');
            $table->decimal('biaya', 15, 2)->nullable();
            $table->date('tanggal_pemeliharaan');
            $table->date('pemeriksaan_berikutnya')->nullable();
            $table->enum('status', ['Proses', 'Selesai'])->default('Selesai');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemeliharaan');
    }
};