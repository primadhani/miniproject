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
        Schema::create('tokens', function (Blueprint $table) {
            $table->id();
            // Kode unik 6 karakter (e.g., A1B2C3)
            $table->string('kode_token', 6)->unique(); 
            $table->string('nama_token');
            // Tanggal kadaluarsa, boleh null jika tidak ada batas waktu
            $table->timestamp('tanggal_kadaluarsa')->nullable(); 
            // Jumlah maksimal redeem, default 0 berarti tak terbatas
            $table->unsignedInteger('jumlah_redeem')->default(0); 
            $table->timestamps();
        });

        Schema::create('token_learning_path', function (Blueprint $table) {
            $table->foreignId('token_id')->constrained('tokens')->onDelete('cascade');
            $table->foreignId('learning_path_id')->constrained('learning_paths')->onDelete('cascade');
            $table->primary(['token_id', 'learning_path_id']);
        });

        // 3. Tabel Pivot: user_redeemed_tokens (Untuk tracking user yang sudah redeem)
        Schema::create('user_redeemed_tokens', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('token_id')->constrained('tokens')->onDelete('cascade');
            // Mencatat kapan user me-redeem token
            $table->timestamp('tanggal_redeem')->useCurrent();
            $table->primary(['user_id', 'token_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_redeemed_tokens');
        Schema::dropIfExists('token_learning_path');
        Schema::dropIfExists('tokens');
    }
};
