<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use App\Models\Modul;
use Illuminate\Http\Request;

class ModulController extends Controller
{
    // Menampilkan daftar Modul untuk Materi tertentu (READ: Index)
    public function index(Materi $materi)
    {
        $moduls = $materi->moduls()->withCount('bacaan')->orderBy('urutan', 'asc')->paginate(10);
        return view('admin.modul.index', compact('materi', 'moduls'));
    }

    // Menampilkan form CREATE
    public function create(Materi $materi)
    {
        return view('admin.modul.create', compact('materi'));
    }

    // Menyimpan Modul baru (CREATE: Store)
    public function store(Request $request, Materi $materi)
    {
        $validated = $request->validate([
            'nama_modul' => 'required|string|max:255',
            'urutan' => 'required|integer|min:1',
        ]);

        $materi->moduls()->create($validated);

        return redirect()->route('admin.materi.modul.index', $materi->id_materi)->with('success', 'Modul baru berhasil ditambahkan.');
    }

    // Menampilkan form EDIT
    public function edit(Materi $materi, Modul $modul)
    {
        if ($modul->id_materi !== $materi->id_materi) {
            abort(404);
        }
        return view('admin.modul.edit', compact('materi', 'modul'));
    }

    // Memperbarui Modul (UPDATE)
    public function update(Request $request, Materi $materi, Modul $modul)
    {
        if ($modul->id_materi !== $materi->id_materi) {
             return redirect()->route('admin.materi.modul.index', $materi->id_materi)->with('error', 'Modul tidak ditemukan dalam Materi tersebut.');
        }

        $validated = $request->validate([
            'nama_modul' => 'required|string|max:255',
            'urutan' => 'required|integer|min:1',
        ]);

        $modul->update($validated);

        return redirect()->route('admin.materi.modul.index', $materi->id_materi)->with('success', 'Modul berhasil diperbarui.');
    }

    // Menghapus Modul (DELETE: Destroy)
    public function destroy(Materi $materi, Modul $modul)
    {
        if ($modul->id_materi !== $materi->id_materi) {
             return redirect()->route('admin.materi.modul.index', $materi->id_materi)->with('error', 'Modul tidak ditemukan dalam Materi tersebut.');
        }

        $modul->delete(); // Akan menghapus Bacaan terkait jika ada cascade di migrasi

        return redirect()->route('admin.materi.modul.index', $materi->id_materi)->with('success', 'Modul berhasil dihapus.');
    }
}