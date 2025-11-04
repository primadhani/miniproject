<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LearningPath; 
use App\Models\Token; // Tambahkan import model Token

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

        return view('user.academy', compact('learningPaths'));
    }
}