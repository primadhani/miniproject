<?php

namespace App\Http\Controllers;

use App\Models\Token;
use App\Models\LearningPath;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // Import Str facade untuk membuat string acak

class TokenController extends Controller
{
    /**
     * Tampilkan daftar semua token.
     */
    public function index()
    {
        // Memuat LearningPath yang terkait untuk ditampilkan di tabel
        $tokens = Token::with('learningPaths')->latest()->get();
        return view('admin.token.index', compact('tokens')); 
    }

    /**
     * Tampilkan form untuk membuat token baru.
     */
    public function create()
    {
        // Ambil semua LearningPath untuk opsi pilihan di form
        $learningPaths = LearningPath::all();
        return view('admin.token.create', compact('learningPaths'));
    }

    /**
     * Simpan token baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_token' => 'required|string|max:255',
            // Tanggal kadaluarsa harus setelah hari ini
            'tanggal_kadaluarsa' => 'nullable|date|after:today', 
            // Jumlah redeem minimal 0 (0 berarti tak terbatas)
            'jumlah_redeem' => 'required|integer|min:0', 
            // Harus memilih setidaknya satu Learning Path
            'learning_path_ids' => 'required|array',
            'learning_path_ids.*' => 'exists:learning_paths,id',
        ]);

        // 1. Generate kode token acak 6 karakter unik
        do {
            $kode_token = Str::upper(Str::random(6)); // Membuat 6 huruf/angka kapital acak
        } while (Token::where('kode_token', $kode_token)->exists());

        // 2. Buat record Token
        $token = Token::create([
            'kode_token' => $kode_token,
            'nama_token' => $request->nama_token,
            'tanggal_kadaluarsa' => $request->tanggal_kadaluarsa,
            'jumlah_redeem' => $request->jumlah_redeem,
        ]);

        // 3. Sinkronisasi Learning Path yang terkait (mengisi tabel pivot token_learning_path)
        $token->learningPaths()->sync($request->learning_path_ids);

        return redirect()->route('admin.tokens.index')->with('success', 'Token baru berhasil dibuat! Kode: ' . $kode_token);
    }
    
    // Metode edit, update, dan destroy (jika diperlukan di masa depan)
    // ...
}
