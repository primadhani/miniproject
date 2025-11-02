<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Token extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_token',
        'nama_token',
        'tanggal_kadaluarsa',
        'jumlah_redeem',
    ];

    /**
     * Relasi Many-to-Many ke LearningPath (Jalur Pembelajaran yang diakses token ini).
     */
    public function learningPaths(): BelongsToMany
    {
        return $this->belongsToMany(
            LearningPath::class,
            'token_learning_path', // Nama pivot table
            'token_id',            // Foreign key model ini di pivot table
            'learning_path_id'     // Foreign key target model di pivot table
        );
    }

    /**
     * Relasi Many-to-Many ke User (User yang sudah me-redeem token ini).
     */
    public function usersRedeemed(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'user_redeemed_tokens', // Nama pivot table
            'token_id',             // Foreign key model ini di pivot table
            'user_id'               // Foreign key target model di pivot table
        )->withPivot('tanggal_redeem'); // Memuat kolom redeem date
    }
}