<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tabel Pivot untuk melacak Bacaan mana yang sudah diselesaikan oleh User
        Schema::create('user_bacaan', function (Blueprint $table) {
            // Foreign key ke tabel users
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // Foreign key ke tabel bacaan. Menggunakan 'id_bacaan' sebagai referensi.
            $table->foreignId('bacaan_id')
                  ->constrained('bacaan', 'id_bacaan')
                  ->onDelete('cascade');
                  
            // Primary Key komposit untuk memastikan setiap pasangan unik
            $table->primary(['user_id', 'bacaan_id']);
            
            // Opsional: Mencatat kapan item ini diselesaikan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_bacaan');
    }
};