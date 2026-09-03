<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ruangan extends Model
{
    use HasFactory;

    protected $table = 'ruangan';

    protected $fillable = [
        'nama_ruangan',
        'gedung',
        'lantai',
        'keterangan',
    ];

    /**
     * Relasi: satu Ruangan bisa menyimpan banyak Sarana
     */
    public function sarana(): HasMany
    {
        return $this->hasMany(Sarana::class, 'ruangan_id');
    }
}