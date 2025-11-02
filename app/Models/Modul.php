<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Modul extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_modul';

    protected $fillable = [
        'id_materi',
        'nama_modul',
        'urutan',
    ];


    public function materi(): BelongsTo
    {
        return $this->belongsTo(Materi::class, 'id_materi', 'id_materi');
    }


    public function bacaan(): HasMany
    {
        return $this->hasMany(Bacaan::class, 'id_modul', 'id_modul');
    }
}