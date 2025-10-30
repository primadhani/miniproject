<?php

use Illuminate\Database\Migrations\Migration; // <-- Baris ini yang hilang!
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // ... sisa kode migrasi Anda untuk pivot table
    public function up(): void
    {
        Schema::create('learning_path_materi', function (Blueprint $table) {
            $table->foreignId('learning_path_id')->constrained('learning_paths')->onDelete('cascade');
            $table->foreignId('materi_id')->constrained('materis', 'id_materi')->onDelete('cascade');
            
            $table->integer('urutan')->nullable();
            $table->primary(['learning_path_id', 'materi_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('learning_path_materi');
    }
};