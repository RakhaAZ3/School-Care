<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PengajuanBarang extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_barang';

    protected $fillable = [
        'pemohon_id',
        'nama_barang',
        'jumlah',
        'estimasi_biaya',
        'alasan',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'jumlah' => 'integer',
            'estimasi_biaya' => 'decimal:2',
        ];
    }

    public function pemohon(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pemohon_id');
    }
}