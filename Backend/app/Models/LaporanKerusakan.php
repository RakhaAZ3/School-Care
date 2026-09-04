<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LaporanKerusakan extends Model
{
    use HasFactory;

    protected $table = 'laporan_kerusakan';

    protected $fillable = [
        'sarana_id',
        'pelapor_id',
        'ditangani_oleh',
        'tanggal_lapor',
        'deskripsi_kerusakan',
        'tingkat_kerusakan',
        'status',
        'tindak_lanjut',
        'foto',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_lapor' => 'date',
        ];
    }

    /**
     * Relasi: Laporan ini untuk satu Sarana
     */
    public function sarana(): BelongsTo
    {
        return $this->belongsTo(Sarana::class, 'sarana_id');
    }

    /**
     * Relasi: Laporan dibuat oleh satu User (pelapor)
     */
    public function pelapor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pelapor_id');
    }

    /**
     * Relasi: Laporan ditangani oleh satu User (petugas/admin)
     */
    public function penanganan(): BelongsTo
    {
        return $this->belongsTo(User::class, 'ditangani_oleh');
    }
}