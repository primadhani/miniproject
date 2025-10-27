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
        Schema::create('bacaan', function (Blueprint $table) {
            $table->id('id_bacaan');
            
            // Foreign Key ke tabel 'moduls'
            $table->foreignId('id_modul')
                ->constrained('moduls', 'id_modul')
                ->onDelete('cascade'); // Opsional: Hapus bacaan jika modul induknya dihapus
                
            $table->string('judul_bacaan');
            $table->longText('isi_bacaan');
            $table->integer('urutan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bacaan');
    }
};
