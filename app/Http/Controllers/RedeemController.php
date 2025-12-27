<?php

namespace App\Http\Controllers;

use App\Models\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RedeemController extends Controller
{
    /**
     * Menampilkan halaman event yang berisi form redeem token
     */
    public function eventIndex()
    {
        return view('user.event');
    }

    /**
     * Memproses redeem token yang dimasukkan oleh user
     */
    public function redeemToken(Request $request)
    {
        $request->validate([
            'kode_token' => 'required|string|size:6',
        ]);

        $user = Auth::user();
        $kode = Str::upper($request->kode_token);

        // 1. Cari Token yang valid dan belum kadaluarsa
        $token = Token::where('kode_token', $kode)
            ->where(function ($query) {
                $query->whereNull('tanggal_kadaluarsa')
                    ->orWhere('tanggal_kadaluarsa', '>', now());
            })
            ->first();

        if (!$token) {
            return back()->withErrors(['kode_token' => 'Kode token tidak valid atau sudah kadaluarsa.']);
        }

        // 2. Cek apakah user sudah pernah redeem
        if ($user->redeemedTokens()->where('token_id', $token->id)->exists()) {
            return back()->withErrors(['kode_token' => 'Anda sudah pernah me-redeem token ini.']);
        }

        // 3. Cek kuota redeem
        $currentRedeems = $token->usersRedeemed()->count();
        if ($token->jumlah_redeem > 0 && $currentRedeems >= $token->jumlah_redeem) {
            return back()->withErrors(['kode_token' => 'Kuota redeem untuk token ini sudah habis.']);
        }

        // 4. Lakukan proses redeem
        $user->redeemedTokens()->attach($token->id);

        return redirect()->route('user.proses-belajar')->with('success', 'Token berhasil di-redeem! Akses Learning Path baru sudah ditambahkan.');
    }
}