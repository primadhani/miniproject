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
    
    // Users Management
    Route::get('/users', function () {
        return view('admin.users');
    })->name('users');
    
    // Academy Management
    Route::get('/academy', function () {
        return view('admin.academy');
    })->name('academy');
    
    // Challenge Management
    Route::get('/challenge', function () {
        return view('admin.challenge');
    })->name('challenge');
    
    // Event Management
    Route::get('/event', function () {
        return view('admin.event');
    })->name('event');
    
    // Job Management
    Route::get('/job', function () {
        return view('admin.job');
    })->name('job');
});

require __DIR__.'/auth.php';