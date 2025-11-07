<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Materi; 
use App\Models\Modul; 
use App\Models\Bacaan; 

class DashboardController extends Controller
{
    /**
     * Tampilkan dashboard user dengan Learning Path dan Materi terakhir diakses.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        
        // 1. Ambil Learning Path yang dapat diakses melalui Token yang sudah di-redeem
        $learningPaths = $user->learningPathsViaTokens();

        // Hitung progress untuk setiap Learning Path
        $learningPathsWithProgress = $learningPaths->map(function ($lp) use ($user) {
            
            // Ambil semua Materi di LP ini
            $allMateri = $lp->materis()->get();
            $totalMateri = $allMateri->count();

            // Mendapatkan ID Bacaan yang sudah diselesaikan
            $completedBacaanIds = $user->completedBacaan()->pluck('bacaan_id');
            
            // Menggunakan nama relasi yang benar: 'moduls.bacaan'
            $materiIdsWithProgress = Materi::whereHas('moduls.bacaan', function ($query) use ($completedBacaanIds) {
                // Menggunakan primary key Bacaan yang benar: id_bacaan
                $query->whereIn('bacaan.id_bacaan', $completedBacaanIds);
            })->pluck('id_materi'); // Menggunakan primary key Materi yang benar: id_materi
            
            // Filter Materi yang memiliki progress, yang juga termasuk dalam LP ini
            $materiWithProgress = $allMateri->whereIn('id_materi', $materiIdsWithProgress)->count(); // Menggunakan id_materi

            // Hitung persentase progress
            $progressPercentage = $totalMateri > 0 ? round(($materiWithProgress / $totalMateri) * 100) : 0;

            // Cari materi yang terakhir diakses untuk link 'Lanjutkan Belajar'
            $lastCompletedBacaan = $user->completedBacaan()
                ->with(['modul.materi'])
                ->whereHas('modul.materi.learningPaths', function ($query) use ($lp) {
                    $query->where('learning_paths.id', $lp->id);
                })
                ->orderByDesc('user_bacaan.updated_at')
                ->first();

            $nextMateri = optional(optional($lastCompletedBacaan)->modul)->materi;

            $lp->progressPercentage = $progressPercentage;
            $lp->materiWithProgress = $materiWithProgress;
            $lp->totalMateri = $totalMateri;
            $lp->nextMateri = $nextMateri; 

            return $lp;
        });


        // 2. Ambil 4 Materi Terakhir Dibuka/Diakses
        $lastCompletedBacaan = $user->completedBacaan()
            ->with(['modul.materi'])
            ->orderByDesc('user_bacaan.updated_at')
            ->limit(10) 
            ->get()
            // Pastikan Materi-nya unik
            ->unique(function ($bacaan) {
                return optional(optional($bacaan->modul)->materi)->id_materi; // Menggunakan id_materi
            })
            ->take(4); 
            
        // Siapkan data untuk view
        $recentMaterials = $lastCompletedBacaan->map(function ($bacaan) {
            $materi = optional(optional($bacaan->modul)->materi);
            if ($materi) {
                $lastAccessedTime = $bacaan->pivot->updated_at;
                
                return (object) [
                    'materi_title' => $materi->nama_materi,
                    'modul_title' => optional($bacaan->modul)->nama_modul,
                    'bacaan_title' => $bacaan->judul_bacaan,
                    'last_accessed_at' => $lastAccessedTime->diffForHumans(), 
                    'bacaan_route_url' => route('user.koridor.index', $materi->id_materi), // Menggunakan id_materi
                ];
            }
            return null;
        })->filter()->values();

        return view('dashboard', [
            'learningPaths' => $learningPathsWithProgress,
            'recentMaterials' => $recentMaterials,
        ]);
    }
}