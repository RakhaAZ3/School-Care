<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pemeliharaan extends Model
{
    use HasFactory;

    protected $table = 'pemeliharaan';

    protected $fillable = [
        'sarana_id',
        'petugas_id',
        'tanggal_pemeliharaan',
        'jenis_pemeliharaan',
        'biaya',
        'status',
        'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_pemeliharaan' => 'date',
            'biaya' => 'decimal:2',
        ];
    }

    /**
     * Relasi: Pemeliharaan ini untuk satu Sarana
     */
    public function sarana(): BelongsTo
    {
        return $this->belongsTo(Sarana::class, 'sarana_id');
    }

    /**
     * Relasi: Pemeliharaan dikerjakan oleh satu User (petugas)
     */
    public function petugas(): BelongsTo
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }
}