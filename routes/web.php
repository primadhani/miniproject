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
use App\Http\Controllers\DashboardController;

// RUTE PUBLIK
Route::view('/', 'landingPage');

// RUTE PENGGUNA TEROTENTIKASI
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::view('/profile', 'profile')->name('profile');
    
    // Perubahan rute sesuai permintaan:
    // Academy menuju ke Progres Belajar (Menggunakan index AcademyController)
    Route::get('/proses-belajar', [AcademyController::class, 'index'])->name('user.proses-belajar');
    
    // Quiz diganti menjadi Runtutan Belajar
    Route::get('/runtutan-belajar', [AcademyController::class, 'runtutanBelajar'])->name('user.runtutan-belajar');
    
    // Event menuju ke Langganan
    Route::view('/langganan', 'user.langganan.index')->name('user.langganan');
    Route::post('/token/redeem', [RedeemController::class, 'redeemToken'])->name('redeem.token');

    // Rute Job tetap atau sesuaikan jika perlu
    Route::view('/job', 'user.job.index')->name('user.job');

    // Rute pendukung lainnya tetap ada di bawah prefix academy atau dipindah
    Route::prefix('academy')->group(function () {
        Route::get('/learning-path/{learning_path}', [LearningPathController::class, 'show'])->name('user.learning-path.show');
    });
    
    Route::get('/koridor/{materi}', [LearningPathController::class, 'koridorIndex'])->name('user.koridor.index');
    Route::get('/materi/{materi}', [LearningPathController::class, 'showMateri'])->name('user.materi.show');
    Route::post('/progress/complete/{bacaan}', [LearningPathController::class, 'markBacaanComplete'])->name('user.bacaan.complete');
});

// RUTE ADMIN
Route::middleware(['auth', 'verified', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
    
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    Route::controller(UserController::class)->group(function () {
        Route::get('/users', 'index')->name('users');
        Route::get('/users/{user}/edit', 'edit')->name('users.edit');
        Route::put('/users/{user}', 'update')->name('users.update');
        Route::delete('/users/{user}', 'destroy')->name('users.destroy');
    });

    Route::resource('learning-path', LearningPathController::class)->names('learning-path');
    
    Route::controller(LearningPathController::class)->group(function () {
        Route::post('learning-path/{learning_path}/add-materi', 'addMateri')->name('learning-path.addMateri');
        Route::delete('learning-path/{learning_path}/remove-materi/{materi}', 'removeMateri')->name('learning-path.removeMateri');
        Route::put('learning-path/{learning_path}/update-order', 'updateOrder')->name('learning-path.updateOrder');
    });
    
    Route::resource('materi', MateriController::class)->names('materi');

    Route::resource('materi.modul', ModulController::class)
        ->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])
        ->names('materi.modul');

    Route::resource('modul.bacaan', BacaanController::class)
        ->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])
        ->names('modul.bacaan');

    Route::resource('tokens', TokenController::class)->except(['show']);

    Route::view('/profile', 'admin.profile.index')->name('profile.index');
});

require __DIR__.'/auth.php';