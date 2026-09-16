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

    protected static function boot(): void
    {
        parent::boot();

        // Saat sarana baru dibuat -> tambah jumlah_item di kategorinya
        static::created(function (Sarana $sarana) {
            $sarana->kategori()->increment('jumlah_item');
        });

        // Saat sarana dihapus (soft delete) -> kurangi jumlah_item di kategorinya
        static::deleted(function (Sarana $sarana) {
            $sarana->kategori()->decrement('jumlah_item');
        });

        // Saat sarana di-restore dari soft delete -> tambah lagi jumlah_item-nya
        static::restored(function (Sarana $sarana) {
            $sarana->kategori()->increment('jumlah_item');
        });

        // Kalau kategori_id-nya diubah (pindah kategori) -> update kedua kategori terkait
        static::updated(function (Sarana $sarana) {
            if ($sarana->isDirty('kategori_id')) {
                $kategoriLama = $sarana->getOriginal('kategori_id');
                KategoriSarana::where('id', $kategoriLama)->decrement('jumlah_item');
                $sarana->kategori()->increment('jumlah_item');
            }
        });
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriSarana::class, 'kategori_id');
    }

    public function ruangan(): BelongsTo
    {
        return $this->belongsTo(Ruangan::class, 'ruangan_id');
    }

    public function peminjaman(): HasMany
    {
        return $this->hasMany(Peminjaman::class, 'sarana_id');
    }

    public function pemeliharaan(): HasMany
    {
        return $this->hasMany(Pemeliharaan::class, 'sarana_id');
    }

    public function laporanKerusakan(): HasMany
    {
        return $this->hasMany(LaporanKerusakan::class, 'sarana_id');
    }
}