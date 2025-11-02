<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AcademyController extends Controller
{
    public function index()
    {
        // Mendapatkan semua Learning Path yang diakses user melalui token
        $learningPaths = Auth::user()->learningPathsViaTokens();
        
        // Catatan: Jika Anda juga memiliki Learning Path yang diakses user 
        // dengan cara lain (misalnya beli), Anda harus menggabungkan koleksi tersebut di sini.

        return view('user.academy', compact('learningPaths'));
    }
}