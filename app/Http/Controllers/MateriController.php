<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use Illuminate\Http\Request;

class MateriController extends Controller
{
    /**
     * Menampilkan daftar semua Materi (READ: Index).
     * Menerima parameter sorting, searching, dan pagination.
     */
    public function index(Request $request)
    {
        $sortColumn = $request->get('sort', 'id_materi');
        $sortDirection = $request->get('direction', 'desc');
        $searchQuery = $request->get('search');

        $materisQuery = Materi::query();

        // Terapkan Pencarian
        if ($searchQuery) {
            $materisQuery->where(function ($query) use ($searchQuery) {
                $query->where('nama_materi', 'like', '%' . $searchQuery . '%')
                      ->orWhere('deskripsi', 'like', '%' . $searchQuery . '%');
            });
        }

        // Terapkan Pengurutan
        $materis = $materisQuery
            ->orderBy($sortColumn, $sortDirection)
            ->withCount('moduls') // Hitung jumlah modul untuk ditampilkan di view
            ->paginate(10)
            ->withQueryString();

        // UPDATE PATH VIEW: dari admin.materi menjadi admin.materi.index
        return view('admin.materi.index', compact('materis', 'sortColumn', 'sortDirection', 'searchQuery'));
    }

    /**
     * Menampilkan form untuk membuat resource baru (CREATE Form).
     */
    public function create()
    {
        // UPDATE PATH VIEW: dari admin.materi-create menjadi admin.materi.create
        return view('admin.materi.create');
    }

    /**
     * Menyimpan resource yang baru dibuat ke storage (CREATE: Store).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_materi' => 'required|string|max:255|unique:materis,nama_materi',
            'deskripsi' => 'nullable|string',
        ], [
            'nama_materi.unique' => 'Nama materi ini sudah ada.',
            'nama_materi.required' => 'Nama materi wajib diisi.',
        ]);

        Materi::create($validated);

        return redirect()->route('admin.materi.index')->with('success', 'Materi baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit resource yang ditentukan (UPDATE Form: Edit).
     */
    public function edit(Materi $materi)
    {
        // UPDATE PATH VIEW: dari admin.materi-edit menjadi admin.materi.edit
        return view('admin.materi.edit', compact('materi'));
    }

    /**
     * Memperbarui resource yang ditentukan di storage (UPDATE: Update).
     */
    public function update(Request $request, Materi $materi)
    {
        $validated = $request->validate([
            // Unique rule dikecualikan untuk materi yang sedang di-update
            'nama_materi' => 'required|string|max:255|unique:materis,nama_materi,' . $materi->id_materi . ',id_materi',
            'deskripsi' => 'nullable|string',
        ], [
            'nama_materi.unique' => 'Nama materi ini sudah ada.',
            'nama_materi.required' => 'Nama materi wajib diisi.',
        ]);

        $materi->update($validated);

        return redirect()->route('admin.materi.index')->with('success', 'Materi berhasil diperbarui.');
    }

    /**
     * Menghapus resource yang ditentukan dari storage (DELETE: Destroy).
     */
    public function destroy(Materi $materi)
    {
        try {
            // Asumsi relasi di database memiliki onDelete('cascade')
            $materi->delete();
            return redirect()->route('admin.materi.index')->with('success', 'Materi berhasil dihapus.');
        } catch (\Exception $e) {
            // Tangani error jika gagal menghapus (misalnya, ada relasi yang menghalangi)
            return redirect()->route('admin.materi.index')->with('error', 'Gagal menghapus materi. Mungkin ada data terkait yang belum dihapus.');
        }
    }

    /**
     * Metode show tidak diimplementasikan karena fokus pada CRUD list/form.
     */
    public function show(Materi $materi)
    {
        // Opsional: Redirect ke halaman edit atau buat halaman show tersendiri
        return redirect()->route('admin.materi.edit', $materi);
    }
}