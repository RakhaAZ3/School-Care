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
        'jenis_perawatan',
        'teknisi',
        'biaya',
        'tanggal_pemeliharaan',
        'pemeriksaan_berikutnya',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'biaya' => 'decimal:2',
            'tanggal_pemeliharaan' => 'date',
            'pemeriksaan_berikutnya' => 'date',
        ];
    }

    public function sarana(): BelongsTo
    {
        return $this->belongsTo(Sarana::class, 'sarana_id');
    }
}