<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Materi extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika berbeda dari konvensi plural (materis)
    protected $table = 'materis';

    // Menentukan primary key karena mungkin bukan 'id' default
    protected $primaryKey = 'id_materi';

    // Kolom yang dapat diisi
    protected $fillable = [
        'nama_materi',
        'deskripsi',
    ];

    /**
     * Relasi One-to-Many ke Modul.
     */
    public function moduls(): HasMany
    {
        // Pastikan foreign key di Modul adalah id_materi
        return $this->hasMany(Modul::class, 'id_materi', 'id_materi');
    }
}