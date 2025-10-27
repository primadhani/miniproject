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
        // ... di dalam method 'up()'
        Schema::create('moduls', function (Blueprint $table) {
            $table->id('id_modul');
            
            // Foreign Key ke tabel 'materis'
            $table->foreignId('id_materi')
                ->constrained('materis', 'id_materi') // Relasi ke tabel 'materis', kolom 'id_materi'
                ->onDelete('cascade'); // Opsional: Hapus modul jika materi induknya dihapus
                
            $table->string('nama_modul');
            $table->integer('urutan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('moduls');
    }
};
