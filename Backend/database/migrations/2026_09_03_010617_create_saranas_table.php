<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sarana', function (Blueprint $table) {
            $table->id();
            $table->string('kode_sarana')->unique();     // inventaris/QR code
            $table->string('nama_sarana');
            $table->foreignId('kategori_id')->constrained('kategori_sarana')->cascadeOnDelete();
            $table->foreignId('ruangan_id')->nullable()->constrained('ruangan')->nullOnDelete();
            $table->integer('jumlah')->default(1);
            $table->enum('kondisi', ['baik', 'rusak_ringan', 'rusak_berat'])->default('baik');
            $table->enum('status', ['tersedia', 'dipinjam', 'dalam_perbaikan', 'tidak_aktif'])->default('tersedia');
            $table->year('tahun_pengadaan')->nullable();
            $table->string('sumber_dana')->nullable();   // APBN, APBD, Komite, dst
            $table->decimal('harga', 15, 2)->nullable();
            $table->string('foto')->nullable();           // path file
            $table->text('keterangan')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sarana');
    }
};