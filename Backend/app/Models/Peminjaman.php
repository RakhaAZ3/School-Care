<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';

    protected $fillable = [
        'sarana_id',
        'peminjam_id',
        'disetujui_oleh',
        'jumlah_pinjam',
        'tanggal_pinjam',
        'tanggal_kembali_rencana',
        'tanggal_kembali_aktual',
        'status',
        'keperluan',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_pinjam' => 'date',
            'tanggal_kembali_rencana' => 'date',
            'tanggal_kembali_aktual' => 'date',
            'jumlah_pinjam' => 'integer',
        ];
    }

    /**
     * Relasi: Peminjaman ini untuk satu Sarana
     */
    public function sarana(): BelongsTo
    {
        return $this->belongsTo(Sarana::class, 'sarana_id');
    }

    /**
     * Relasi: Peminjaman dilakukan oleh satu User (peminjam)
     */
    public function peminjam(): BelongsTo
    {
        return $this->belongsTo(User::class, 'peminjam_id');
    }

    /**
     * Relasi: Peminjaman disetujui oleh satu User (petugas/admin)
     */
    public function penyetuju(): BelongsTo
    {
        return $this->belongsTo(User::class, 'disetujui_oleh');
    }
}