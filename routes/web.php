<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

// Rute Otentikasi Dasar
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// --- RUTE PENGGUNA BIASA (USER ROUTES) ---
Route::middleware(['auth', 'verified'])->group(function () {
    // Academy
    Route::view('academy', 'user.academy')
        ->name('academy');

    // Challenge
    Route::view('challenge', 'user.challenge')
        ->name('challenge');

    // Event
    Route::view('event', 'user.event')
        ->name('event');

    // Job
    Route::view('job', 'user.job')
        ->name('job');
});

// Admin routes
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    
    Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('users');
    
    // Rute untuk menampilkan form edit
    Route::get('/users/{user}/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
    
    // Rute untuk memproses update data
    Route::put('/users/{user}', [App\Http\Controllers\UserController::class, 'update'])->name('users.update');
    
    // Rute untuk menghapus data
    Route::delete('/users/{user}', [App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');
    
    Route::get('/learning-path', function () {
        return view('admin.learning-path');
    })->name('learning-path');

    Route::get('/materi', function () {
        return view('admin.materi');
    })->name('materi');

});

require __DIR__.'/auth.php';