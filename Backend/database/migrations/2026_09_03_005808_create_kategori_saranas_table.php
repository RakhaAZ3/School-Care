<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kategori_sarana', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kategori');       // Elektronik, Furnitur, Alat Praktik, dst
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kategori_sarana');
    }
};