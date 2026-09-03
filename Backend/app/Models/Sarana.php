<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sarana extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'sarana';

    protected $fillable = [
        'kode_sarana',
        'nama_sarana',
        'kategori_id',
        'ruangan_id',
        'jumlah',
        'kondisi',
        'status',
        'tahun_pengadaan',
        'sumber_dana',
        'harga',
        'foto',
        'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'harga' => 'decimal:2',
            'tahun_pengadaan' => 'integer',
            'jumlah' => 'integer',
        ];
    }

    /**
     * Relasi: Sarana termasuk dalam satu Kategori
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriSarana::class, 'kategori_id');
    }

    /**
     * Relasi: Sarana berada di satu Ruangan
     */
    public function ruangan(): BelongsTo
    {
        return $this->belongsTo(Ruangan::class, 'ruangan_id');
    }

    /**
     * Relasi: Sarana punya banyak riwayat Peminjaman
     */
    public function peminjaman(): HasMany
    {
        return $this->hasMany(Peminjaman::class, 'sarana_id');
    }

    /**
     * Relasi: Sarana punya banyak riwayat Pemeliharaan
     */
    public function pemeliharaan(): HasMany
    {
        return $this->hasMany(Pemeliharaan::class, 'sarana_id');
    }

    /**
     * Relasi: Sarana punya banyak Laporan Kerusakan
     */
    public function laporanKerusakan(): HasMany
    {
        return $this->hasMany(LaporanKerusakan::class, 'sarana_id');
    }
}