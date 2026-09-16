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

    // "kode_sarana" sengaja TIDAK dimasukkan ke fillable,
    // karena diisi otomatis oleh sistem (lihat boot() di bawah).
    protected $fillable = [
        'nama_sarana',
        'kategori_id',
        'ruangan_id',
        'jumlah',
        'kondisi',
    ];

    protected function casts(): array
    {
        return [
            'jumlah' => 'integer',
        ];
    }

    protected static function boot(): void
    {
        parent::boot();

        // Auto generate kode_sarana setiap kali sarana baru dibuat
        // Format: SR-0001, SR-0002, dst.
        static::creating(function (Sarana $sarana) {
            $lastId = (self::withTrashed()->max('id') ?? 0) + 1;
            $sarana->kode_sarana = 'SR-' . str_pad($lastId, 4, '0', STR_PAD_LEFT);
        });

        static::created(function (Sarana $sarana) {
            $sarana->kategori()->increment('jumlah_item');
        });

        static::deleted(function (Sarana $sarana) {
            $sarana->kategori()->decrement('jumlah_item');
        });

        static::restored(function (Sarana $sarana) {
            $sarana->kategori()->increment('jumlah_item');
        });

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