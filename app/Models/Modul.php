<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany; // <-- Pastikan ini di-import

class Modul extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_modul';

    protected $fillable = [
        'id_materi',
        'nama_modul',
        'urutan',
    ];

    /**
     * Relasi many-to-one ke Materi.
     */
    public function materi(): BelongsTo
    {
        return $this->belongsTo(Materi::class, 'id_materi', 'id_materi');
    }

    /**
     * Relasi One-to-Many ke Bacaan. (INI YANG HILANG/BELUM TERDEFINISI)
     */
    public function bacaan(): HasMany // <-- Pastikan method ini ada
    {
        // Modul memiliki banyak Bacaan
        return $this->hasMany(Bacaan::class, 'id_modul', 'id_modul');
    }
}