<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function redeemedTokens(): BelongsToMany
    {
        return $this->belongsToMany(
            Token::class,
            'user_redeemed_tokens',
            'user_id',
            'token_id'
        )->withPivot('tanggal_redeem');
    }

    public function learningPathsViaTokens()
    {
        // Mengambil semua LearningPath dari semua Token yang sudah di-redeem
        // dan mengembalikan koleksi LearningPath yang unik.
        return $this->redeemedTokens()->with('learningPaths')->get()
            ->pluck('learningPaths')
            ->flatten()
            ->unique('id');
    }
}
