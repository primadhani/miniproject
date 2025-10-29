<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Menampilkan daftar semua user dengan fitur search, sorting, dan pagination.
     */
    public function index(Request $request)
    {
        // 1. Tentukan kolom dan arah default untuk sorting
        $sortColumn = $request->get('sort', 'id'); // Default sort: 'id'
        $sortDirection = $request->get('direction', 'asc'); // Default direction: 'asc'
        $searchQuery = $request->get('search'); // Ambil kata kunci pencarian

        // BARIS PENTING BERUBAH: Tambahkan 'created_at' ke kolom yang diizinkan!
        $allowedColumns = ['id', 'name', 'email', 'role', 'created_at']; 
        
        // Pastikan kolom yang diminta aman untuk sorting
        if (!in_array($sortColumn, $allowedColumns)) {
            $sortColumn = 'id';
        }
        $sortDirection = strtolower($sortDirection) === 'desc' ? 'desc' : 'asc';

        // Mulai query builder
        $usersQuery = User::query();

        // 2. Terapkan Pencarian (Search)
        if ($searchQuery) {
            $usersQuery->where(function ($query) use ($searchQuery) {
                $query->where('name', 'like', '%' . $searchQuery . '%')
                      ->orWhere('email', 'like', '%' . $searchQuery . '%')
                      ->orWhere('role', 'like', '%' . $searchQuery . '%');
            });
        }

        // 3. Terapkan Pengurutan (Sorting)
        $usersQuery->orderBy($sortColumn, $sortDirection);

        // 4. Terapkan Pagination (10 item per halaman)
        $users = $usersQuery->paginate(10)->withQueryString();

        // Mengirim data ke view, termasuk parameter sorting dan search saat ini
        return view('admin.users', compact('users', 'sortColumn', 'sortDirection', 'searchQuery'));
    }

    /**
     * Menampilkan form untuk mengedit user tertentu.
     */
    public function edit(User $user)
    {
        // Pastikan Anda sudah membuat file resources/views/admin/users-edit.blade.php
        return view('admin.users-edit', compact('user'));
    }

    /**
     * Memperbarui data user di database.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,user',
            'password' => 'nullable|min:6|confirmed', // 'confirmed' mencari field 'password_confirmation'
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.users')->with('success', 'Data user berhasil diperbarui.');
    }

    /**
     * Menghapus user dari database.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'User berhasil dihapus.');
    }
}