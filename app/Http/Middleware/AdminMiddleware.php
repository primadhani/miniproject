<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Pengecekan pertama: Apakah pengguna sudah login?
        if (!auth()->check()) {
            return redirect('login');
        }

        // Pengecekan kedua: Apakah role pengguna adalah 'admin'?
        if (auth()->user()->role !== 'admin') {
            // Jika bukan admin, redirect ke halaman lain (misal: home) atau tampilkan 403 Forbidden
            return redirect('/')->with('error', 'Akses ditolak. Anda bukan Admin.');
        }

        return $next($request);
    }
}
