<?php

namespace App\Http\Controllers;

use App\Models\Modul;
use App\Models\Bacaan;
use Illuminate\Http\Request;

class BacaanController extends Controller
{
    // Menampilkan daftar Bacaan untuk Modul tertentu (READ: Index)
    public function index(Modul $modul)
    {
        // Muat data materi untuk keperluan breadcrumb
        $modul->load('materi');

        $bacaans = $modul->bacaan()->orderBy('urutan', 'asc')->paginate(10);
        return view('admin.bacaan.index', compact('modul', 'bacaans'));
    }

    // Menampilkan form CREATE
    public function create(Modul $modul)
    {
        $modul->load('materi');
        return view('admin.bacaan.create', compact('modul'));
    }

    // Menyimpan Bacaan baru (CREATE: Store)
    public function store(Request $request, Modul $modul)
    {
        $validated = $request->validate([
            'judul_bacaan' => 'required|string|max:255',
            'isi_bacaan' => 'required|string',
            'urutan' => 'required|integer|min:1',
        ]);

        $modul->bacaan()->create($validated);

        return redirect()->route('admin.modul.bacaan.index', $modul->id_modul)->with('success', 'Bacaan baru berhasil ditambahkan.');
    }

    // Menampilkan form EDIT
    public function edit(Modul $modul, Bacaan $bacaan)
    {
        if ($bacaan->id_modul !== $modul->id_modul) {
            abort(404);
        }
        $modul->load('materi');
        return view('admin.bacaan.edit', compact('modul', 'bacaan'));
    }

    // Memperbarui Bacaan (UPDATE)
    public function update(Request $request, Modul $modul, Bacaan $bacaan)
    {
        if ($bacaan->id_modul !== $modul->id_modul) {
             return redirect()->route('admin.modul.bacaan.index', $modul->id_modul)->with('error', 'Bacaan tidak ditemukan dalam Modul tersebut.');
        }

        $validated = $request->validate([
            'judul_bacaan' => 'required|string|max:255',
            'isi_bacaan' => 'required|string',
            'urutan' => 'required|integer|min:1',
        ]);

        $bacaan->update($validated);

        return redirect()->route('admin.modul.bacaan.index', $modul->id_modul)->with('success', 'Bacaan berhasil diperbarui.');
    }

    // Menghapus Bacaan (DELETE: Destroy)
    public function destroy(Modul $modul, Bacaan $bacaan)
    {
        if ($bacaan->id_modul !== $modul->id_modul) {
             return redirect()->route('admin.modul.bacaan.index', $modul->id_modul)->with('error', 'Bacaan tidak ditemukan dalam Modul tersebut.');
        }
        
        $bacaan->delete();

        return redirect()->route('admin.modul.bacaan.index', $modul->id_modul)->with('success', 'Bacaan berhasil dihapus.');
    }
}