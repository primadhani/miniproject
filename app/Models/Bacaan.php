<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bacaan extends Model
{
    use HasFactory;

    protected $table = 'bacaan';
    protected $primaryKey = 'id_bacaan';

    protected $fillable = [
        'id_modul',
        'judul_bacaan',
        'isi_bacaan',
        'urutan',
    ];

    /**
     * Relasi many-to-one ke Modul.
     */
    public function modul(): BelongsTo
    {
        return $this->belongsTo(Modul::class, 'id_modul', 'id_modul');
    }
}