<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sortColumn = $request->get('sort', 'id');
        $sortDirection = $request->get('direction', 'desc');
        $searchQuery = $request->get('search');

        // PERUBAHAN: Menghapus filter 'role', sehingga menampilkan SEMUA user.
        $usersQuery = User::query();

        // Apply Search
        if ($searchQuery) {
            $usersQuery->where(function ($query) use ($searchQuery) {
                $query->where('name', 'like', '%' . $searchQuery . '%')
                      ->orWhere('email', 'like', '%' . $searchQuery . '%');
            });
        }

        // Apply Sorting
        $users = $usersQuery
            ->orderBy($sortColumn, $sortDirection)
            ->paginate(10)
            ->withQueryString();

        // UPDATE PATH VIEW: dari admin.users menjadi admin.user.index
        return view('admin.user.index', compact('users', 'sortColumn', 'sortDirection', 'searchQuery'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Karena view create tidak ada, alihkan kembali atau tampilkan error.
        // Jika Anda tidak menggunakan fitur ini, alihkan kembali ke index.
        return redirect()->route('admin.users.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => 'user', // Set default role to 'user'
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Not implemented or just redirects
        return redirect()->route('admin.users.edit', $id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        // Only allow editing of 'user' role accounts, not admin
        // PERUBAHAN: Anda MUNGKIN ingin mengizinkan edit akun admin, tetapi ini berbahaya.
        // Biarkan validasi tetap ada jika Anda hanya ingin mengedit user biasa.
        if ($user->role !== 'user') {
            abort(403, 'Unauthorized action.');
        }

        // UPDATE PATH VIEW: dari admin.users-edit menjadi admin.user.edit
        return view('admin.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // Only allow editing of 'user' role accounts, not admin
        if ($user->role !== 'user') {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            // Unique rule excluded for the current user being updated
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed', // Password is now optional for update
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = bcrypt($validated['password']);
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Only allow deleting of 'user' role accounts, not admin
        if ($user->role !== 'user') {
            abort(403, 'Unauthorized action.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }
}
