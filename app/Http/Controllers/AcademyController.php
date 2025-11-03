<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LearningPath; 

class AcademyController extends Controller
{
    public function index()
    {
        // Perbaikan: Gunakan nama relasi yang benar, yaitu 'materis'
        $learningPaths = LearningPath::with('materis')->get();
        
        return view('user.academy', compact('learningPaths'));
    }
}