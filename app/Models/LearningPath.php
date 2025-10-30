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
            'learning_path_materi', // Nama pivot table
            'learning_path_id',     // Foreign key model ini di pivot table
            'materi_id'             // Foreign key target model di pivot table
        )
        // Memuat kolom 'urutan' dari tabel pivot
        ->withPivot('urutan')
        // PERBAIKAN: Menggunakan nama tabel pivot yang sebenarnya ('learning_path_materi') 
        // saat mengurutkan agar query SQL mengenali kolom 'urutan'.
        ->orderBy('learning_path_materi.urutan', 'asc'); 
    }
}