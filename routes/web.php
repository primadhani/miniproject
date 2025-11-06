<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\ModulController;
use App\Http\Controllers\BacaanController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\RedeemController;
use App\Http\Controllers\AcademyController;
use App\Http\Controllers\LearningPathController;
use App\Http\Controllers\AdminDashboardController;

Route::view('/', 'welcome');

// Rute Otentikasi Dasar
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware('auth')->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');

    // --- Rute User ---
    
    // Grouping rute Akademi (halaman utama dan Learning Path Show)
    Route::prefix('academy')->group(function () {
        
        // 1. Halaman Index Akademi (View: resources/views/user/academy/progres-belajar/index.blade.php)
        Route::get('/', [AcademyController::class, 'index'])
            ->name('user.academy'); 

        // 2. Learning Path Show untuk User (View: resources/views/user/learning-path/show.blade.php - dianggap di luar folder progres-belajar)
        // Rute lengkap: /academy/learning-path/{learning_path}
        Route::get('/learning-path/{learning_path}', [LearningPathController::class, 'show'])
            ->name('user.learning-path.show');
    });

    // Rute Koridor dan Materi (menggunakan URL /koridor dan /materi)
    
    // PERUBAHAN 2: Rute KORIDOR (Halaman Perantara - View: resources/views/user/academy/progres-belajar/koridor.blade.php)
    Route::get('/koridor/{materi}', [LearningPathController::class, 'koridorIndex'])
        ->name('user.koridor.index');

    // PERUBAHAN 1: Rute DETAIL MATERI (View: resources/views/user/academy/progres-belajar/show.blade.php)
    Route::get('/materi/{materi}', [LearningPathController::class, 'showMateri'])
     ->name('user.materi.show');

    // PERUBAHAN 3: Rute untuk API Penandaan Bacaan Selesai (dipanggil via AJAX)
    Route::post('/progress/complete/{bacaan}', [LearningPathController::class, 'markBacaanComplete'])
        ->name('user.bacaan.complete');

    Route::view('/langganan', 'user.academy.langganan.index')
            ->name('user.academy.langganan');

    Route::get('/runtutan-belajar', [AcademyController::class, 'runtutanBelajar'])
            ->name('user.academy.runtutan-belajar');

    // Event (Tempat Redeem)
    Route::get('/event', [RedeemController::class, 'eventIndex'])
        ->name('user.event');

    // Redeem Token
    Route::post('/redeem-token', [RedeemController::class, 'redeemToken'])
        ->name('redeem.token');
    
    // Challenge
    Route::view('/challenge', 'user.challenge')
        ->name('user.challenge');

    // Job
    Route::view('/job', 'user.job')
        ->name('user.job');
});

// Admin routes
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('users');
    
    // Rute untuk menampilkan form edit
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::resource('learning-path', App\Http\Controllers\LearningPathController::class)->names('learning-path');

    // Rute untuk menambahkan Materi ke Learning Path tertentu
    Route::post('learning-path/{learning_path}/add-materi', [App\Http\Controllers\LearningPathController::class, 'addMateri'])->name('learning-path.addMateri');
    Route::delete('learning-path/{learning_path}/remove-materi/{materi}', [App\Http\Controllers\LearningPathController::class, 'removeMateri'])->name('learning-path.removeMateri');
    Route::put('learning-path/{learning_path}/update-order', [App\Http\Controllers\LearningPathController::class, 'updateOrder'])->name('learning-path.updateOrder');

    
    Route::resource('materi', MateriController::class)->names('materi'); // <-- GANTI DENGAN INI

    Route::resource('materi.modul', ModulController::class)
        ->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])
        ->names('materi.modul');

    // CRUD Bacaan (Nested di bawah Modul)
    // Rute: admin/modul/{modul}/bacaan/* -> nama rute: admin.modul.bacaan.*
    Route::resource('modul.bacaan', BacaanController::class)
        ->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])
        ->names('modul.bacaan');

    Route::resource('tokens', TokenController::class)->except(['show']);

    Route::get('/profile', function () {
    return view('admin.profile.index'); 
})->name('profile.index');
});

require __DIR__.'/auth.php';