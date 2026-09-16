<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriSarana extends Model
{
    use HasFactory;

    protected $table = 'kategori_sarana';

    // "kode" dan "jumlah_item" sengaja TIDAK dimasukkan ke fillable,
    // karena keduanya diisi otomatis oleh sistem, bukan input user.
    protected $fillable = [
        'nama_kategori',
        'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'jumlah_item' => 'integer',
        ];
    }

    protected static function boot(): void
    {
        parent::boot();

        // Auto generate kode setiap kali kategori baru dibuat
        // Format: KTG-0001, KTG-0002, dst.
        static::creating(function (KategoriSarana $kategori) {
            $lastId = (self::max('id') ?? 0) + 1;
            $kategori->kode = 'KTG-' . str_pad($lastId, 4, '0', STR_PAD_LEFT);
        });
    }

    /**
     * Relasi: satu Kategori punya banyak Sarana
     */
    public function sarana(): HasMany
    {
        return $this->hasMany(Sarana::class, 'kategori_id');
    }
}