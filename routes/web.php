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
    
    // Academy
    Route::get('/academy', [AcademyController::class, 'index'])
        ->name('user.academy'); 

    // Learning Path Show untuk User (BARU)
    // Menggunakan LearningPathController@show (Jika Anda sudah memiliki metode ini)
    Route::get('/academy/learning-path/{learning_path}', [LearningPathController::class, 'show'])
        ->name('user.learning-path.show');

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
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    
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
});

require __DIR__.'/auth.php';