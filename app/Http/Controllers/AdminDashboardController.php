<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\LearningPath;
use App\Models\Materi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil total statistik
        $totalUsers = User::count();
        $totalLearningPaths = LearningPath::count();
        // Karena di Materi.php primary key adalah 'id_materi', kita gunakan count() biasa
        $totalMateris = Materi::count();
        
        // 2. Data untuk statistik/grafik sederhana: User berdasarkan role
        $userCountsByRole = User::select('role', DB::raw('count(*) as count'))
            ->groupBy('role')
            ->pluck('count', 'role')
            ->toArray();

        return view('admin.dashboard', compact(
            'totalUsers', 
            'totalLearningPaths', 
            'totalMateris',
            'userCountsByRole'
        ));
    }
}