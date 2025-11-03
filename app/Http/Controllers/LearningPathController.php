<?php

namespace App\Http\Controllers; 

use App\Models\LearningPath;
use App\Models\Materi;
use App\Models\Bacaan; // PENTING: Import model Bacaan
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller; 

class LearningPathController extends Controller
{
    // READ: Menampilkan daftar Learning Path (Admin)
    public function index()
    {
        $learningPaths = LearningPath::withCount('materis')->paginate(10);
        return view('admin.learning-path.index', compact('learningPaths'));
    }

    // CREATE: Menampilkan form (Admin)
    public function create()
    {
        return view('admin.learning-path.create');
    }

    // CREATE: Menyimpan data baru (Admin)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_path' => 'required|string|max:255|unique:learning_paths,nama_path',
            'deskripsi' => 'nullable|string',
        ]);

        LearningPath::create($validated);

        return redirect()->route('admin.learning-path.index')->with('success', 'Learning Path baru berhasil ditambahkan.');
    }

    // SHOW: Menampilkan detail Learning Path dan form untuk menambah Materi (Admin)
    public function show(LearningPath $learningPath)
    {
        // PENTING: Muat materi yang sudah terhubung dengan path ini, diurutkan berdasarkan urutan pivot
        $pathMateris = $learningPath->materis()->orderBy('urutan')->get(); 
        
        // Ambil semua materi yang BELUM terhubung dengan path ini (untuk opsi add)
        $existingMaterisIds = $pathMateris->pluck('id_materi')->toArray();
        $availableMateris = Materi::whereNotIn('id_materi', $existingMaterisIds)->get();

        return view('admin.learning-path.show', compact('learningPath', 'pathMateris', 'availableMateris'));
    }

    // UPDATE: Menampilkan form edit (Admin)
    public function edit(LearningPath $learningPath)
    {
        return view('admin.learning-path.edit', compact('learningPath'));
    }

    // UPDATE: Memperbarui data (Admin)
    public function update(Request $request, LearningPath $learningPath)
    {
        $validated = $request->validate([
            'nama_path' => 'required|string|max:255|unique:learning_paths,nama_path,' . $learningPath->id,
            'deskripsi' => 'nullable|string',
        ]);

        $learningPath->update($validated);

        return redirect()->route('admin.learning-path.index')->with('success', 'Learning Path berhasil diperbarui.');
    }

    // DELETE: Menghapus data (Admin)
    public function destroy(LearningPath $learningPath)
    {
        $learningPath->delete();
        return redirect()->route('admin.learning-path.index')->with('success', 'Learning Path berhasil dihapus.');
    }
    
    // --- FUNGSI KHUSUS UNTUK MENAMBAH DAN MENGHAPUS MATERI (Admin) ---

    // Menambahkan Materi ke Learning Path 
    public function addMateri(Request $request, LearningPath $learningPath)
    {
        $validated = $request->validate([
            'materi_id' => 'required|exists:materis,id_materi',
        ]);
        
        // Mendapatkan urutan terakhir dan menambahkannya dengan 1
        $maxUrutan = DB::table('learning_path_materi')
            ->where('learning_path_id', $learningPath->id)
            ->max('urutan');
            
        $nextUrutan = ($maxUrutan ?? 0) + 1;

        try {
            $learningPath->materis()->attach($validated['materi_id'], ['urutan' => $nextUrutan]);
            return back()->with('success', 'Materi berhasil ditambahkan ke Learning Path.');
        } catch (\Exception $e) {
            return back()->with('error', 'Materi sudah ada di Learning Path ini. Error: ' . $e->getMessage());
        }
    }

    // Menghapus Materi dari Learning Path 
    public function removeMateri(LearningPath $learningPath, Materi $materi)
    {
        $learningPath->materis()->detach($materi->id_materi);
        return back()->with('success', 'Materi berhasil dihapus dari Learning Path.');
    }

    // --- FUNGSI PENTING UNTUK MEMPERBARUI URUTAN MATERI (Admin) ---
    public function updateOrder(Request $request, LearningPath $learningPath)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*.id' => 'required|exists:materis,id_materi', 
            'order.*.urutan' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();
            foreach ($request->input('order') as $item) {
                $learningPath->materis()->updateExistingPivot($item['id'], [
                    'urutan' => $item['urutan'],
                ]);
            }

            DB::commit();
            return response()->json(['success' => 'Urutan materi berhasil diperbarui.'], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Gagal memperbarui urutan materi. Pesan: ' . $e->getMessage()], 500);
        }
    }

    // ⭐ FUNGSI BARU UNTUK TAMPILAN AKADEMI USER (DETAIL MATERI) ⭐
    public function showMateri(Materi $materi) 
    {
        // Muat Modul dan nested Bacaan (Eager Loading)
        $materi->load(['moduls' => function ($query) {
            // Asumsi Modul memiliki kolom 'urutan'
            $query->orderBy('urutan')->with(['bacaan' => function ($query) {
                // Asumsi Bacaan memiliki kolom 'urutan'
                $query->orderBy('urutan'); 
            }]);
        }]);

        $firstBacaan = null;
        
        // Cari Bacaan pertama dari Modul pertama yang memiliki bacaan
        if ($materi->moduls->isNotEmpty()) {
            foreach ($materi->moduls as $modul) {
                if ($modul->bacaan->isNotEmpty()) {
                    $firstBacaan = $modul->bacaan->first();
                    break;
                }
            }
        } 
        
        // Mengarahkan ke view user
        return view('user.learning-path.show', compact('materi', 'firstBacaan'));
    }
}