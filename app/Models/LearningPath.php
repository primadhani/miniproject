<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class LearningPath extends Model
{
    use HasFactory;
    
    // Asumsi primary key default adalah 'id'

    protected $fillable = [
        'nama_path',
        'deskripsi',
    ];

    /**
     * Relasi Many-to-Many ke Materi.
     */
    public function materis(): BelongsToMany
    {
        return $this->belongsToMany(
            Materi::class, 
            'learning_path_materi',
            'learning_path_id',
            'materi_id'
        )
        ->withPivot('urutan')
        ->orderBy('learning_path_materi.urutan', 'asc'); 
    }

    public function tokens(): BelongsToMany
    {
        return $this->belongsToMany(
            Token::class,
            'token_learning_path',
            'learning_path_id',
            'token_id'
        );
    }
}