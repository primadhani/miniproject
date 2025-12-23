<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LearningPath; 
use App\Models\Token; 
use App\Models\Materi; 
use App\Models\Bacaan; 
use Illuminate\Support\Facades\DB; 

class AcademyController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        
        // 1. Ambil semua Token yang sudah di-redeem oleh user saat ini
        $redeemedTokens = Token::whereHas('usersRedeemed', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        // 2. Eager load Learning Paths yang terkait dengan token-token ini
        ->with(['learningPaths' => function ($query) {
            // Eager load materis di dalam Learning Path
            $query->with('materis');
        }])
        // Select hanya kolom yang diperlukan dari Token
        ->select('id', 'tanggal_kadaluarsa')
        ->get();

        // 3. Kumpulkan Learning Paths dan tentukan deadline terdekat (jika ada)
        $learningPathsWithDeadline = collect([]);
        foreach ($redeemedTokens as $token) {
            foreach ($token->learningPaths as $learningPath) {
                // Ambil tanggal kadaluarsa token
                $deadline = $token->tanggal_kadaluarsa;
                
                // Cek apakah Learning Path sudah ditambahkan sebelumnya
                if (!$learningPathsWithDeadline->has($learningPath->id)) {
                    // Inisialisasi properti custom 'deadline_token'
                    $learningPath->deadline_token = $deadline;
                    $learningPathsWithDeadline->put($learningPath->id, $learningPath);
                } else {
                    // Jika Learning Path sudah ada, bandingkan deadline yang baru dengan yang sudah ada.
                    // Prioritaskan deadline yang lebih awal/terdekat.
                    $existingDeadline = $learningPathsWithDeadline[$learningPath->id]->deadline_token;

                    if ($deadline) {
                        // Jika deadline baru lebih awal dari yang sudah ada, gunakan deadline baru
                        if (!$existingDeadline || strtotime($deadline) < strtotime($existingDeadline)) {
                            $learningPathsWithDeadline[$learningPath->id]->deadline_token = $deadline;
                        }
                    }
                }
            }
        }
        
        // Konversi kembali menjadi koleksi terindeks array
        $learningPaths = $learningPathsWithDeadline->values();

        return view('user.progres-belajar.index', compact('learningPaths'));
    }
    
    /**
     * Menampilkan daftar Learning Path dan persentase penyelesaiannya,
     * serta rekomendasi LP yang relevan.
     */
    public function runtutanBelajar() 
    {
        $userId = Auth::id();
        
        // --- LOGIKA 1: Ambil Progress Learning Path User ---
        
        // 1. Ambil semua Learning Paths yang dimiliki user
        $enrolledLearningPaths = LearningPath::whereHas('tokens.usersRedeemed', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->with(['materis' => function ($query) {
            // Eager load materi -> modul -> bacaan (Menggunakan nama relasi 'bacaan' singular)
            $query->with(['moduls.bacaan']); 
        }])
        ->get();

        // 2. Ambil semua ID Bacaan yang sudah diselesaikan oleh user
        $completedBacaanIds = DB::table('user_bacaan')
            ->where('user_id', $userId)
            ->pluck('bacaan_id')
            ->toArray();
        
        // 3. Hitung persentase untuk setiap Materi dan Learning Path
        $completedMateriIds = collect(); // Koleksi untuk menyimpan ID Materi yang 100%
        $enrolledLearningPaths->each(function ($learningPath) use ($completedBacaanIds, &$completedMateriIds) {
            $pathMateriPercentages = [];
            
            $learningPath->materis->each(function ($materi) use ($completedBacaanIds, &$pathMateriPercentages, &$completedMateriIds) {
                $totalBacaan = 0;
                $completedBacaan = 0;

                // Hitung total dan completed Bacaan di setiap Modul Materi
                $materi->moduls->each(function ($modul) use ($completedBacaanIds, &$totalBacaan, &$completedBacaan) {
                    // Perbaikan: MENGGUNAKAN 'bacaan' (singular)
                    $totalBacaan += $modul->bacaan->count(); 
                    $completedBacaan += $modul->bacaan->filter(function ($bacaan) use ($completedBacaanIds) {
                        return in_array($bacaan->id_bacaan, $completedBacaanIds); // PK Bacaan adalah id_bacaan
                    })->count();
                });
                
                // Hitung persentase Materi
                $percentage = ($totalBacaan > 0) 
                    ? round(($completedBacaan / $totalBacaan) * 100) 
                    : 0;
                
                $materi->percentage = $percentage;
                $materi->total_bacaan = $totalBacaan;
                
                // Kumpulkan Materi yang 100% selesai (dan punya konten)
                if ($percentage == 100 && $totalBacaan > 0) {
                    $completedMateriIds->push($materi->id_materi);
                }
                
                // LOGIKA FIX PERSENTASE LP: Hanya Materi yang punya konten (totalBacaan > 0) yang dihitung rata-ratanya
                if ($totalBacaan > 0) {
                    $pathMateriPercentages[] = $percentage;
                }
            });

            // Hitung persentase Learning Path (rata-rata persentase Materi yang punya konten)
            $pathPercentage = (count($pathMateriPercentages) > 0)
                ? round(array_sum($pathMateriPercentages) / count($pathMateriPercentages))
                : 0;
            
            $learningPath->percentage = $pathPercentage;
        });

        // --- LOGIKA 2: Rekomendasi Learning Path yang Sesuai ---

        // 1. Ambil ID Learning Path yang sudah diikuti user
        $enrolledPathIds = $enrolledLearningPaths->pluck('id')->toArray();

        // 2. Ambil ID Materi yang 100% selesai (sudah di-filter unik)
        $uniqueCompletedMateriIds = $completedMateriIds->unique()->toArray();

        $recommendedLearningPaths = collect();

        if (!empty($uniqueCompletedMateriIds)) {
            // Cari Learning Path yang BELUM diikuti user DAN memiliki Materi yang sudah diselesaikan user
            $recommendedLearningPaths = LearningPath::whereNotIn('id', $enrolledPathIds)
                ->whereHas('materis', function ($query) use ($uniqueCompletedMateriIds) {
                    // Memastikan LP memiliki minimal 1 materi yang sudah diselesaikan user
                    $query->whereIn('id_materi', $uniqueCompletedMateriIds);
                })
                // Eager load materis di LP rekomendasi
                ->with('materis') 
                ->limit(1) // PERUBAHAN: Batasi hanya 1 LP rekomendasi
                ->get();

            // Tambahkan flag pada Materi yang "Sesuai" (common) di LP rekomendasi
            $recommendedLearningPaths->each(function ($path) use ($uniqueCompletedMateriIds) {
                $path->materis->each(function ($materi) use ($uniqueCompletedMateriIds) {
                    $materi->is_common = in_array($materi->id_materi, $uniqueCompletedMateriIds);
                });
            });
        }
        
        return view('user.runtutan-belajar.index', [
            'learningPaths' => $enrolledLearningPaths,
            'recommendedLearningPaths' => $recommendedLearningPaths,
        ]);
    }
}