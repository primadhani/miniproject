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
        Schema::create('materis', function (Blueprint $table) {
            $table->id('id_materi'); // Sama dengan $table->bigIncrements('id_materi');
            $table->string('nama_materi');
            $table->text('deskripsi')->nullable();
            $table->timestamps(); // kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materis');
    }
};
