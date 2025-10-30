<?php

namespace App\Http\Controllers; 

use App\Models\LearningPath;
use App\Models\Materi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller; 

class LearningPathController extends Controller
{
    // READ: Menampilkan daftar Learning Path
    public function index()
    {
        $learningPaths = LearningPath::withCount('materis')->paginate(10);
        return view('admin.learning-path.index', compact('learningPaths'));
    }

    // CREATE: Menampilkan form
    public function create()
    {
        return view('admin.learning-path.create');
    }

    // CREATE: Menyimpan data baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_path' => 'required|string|max:255|unique:learning_paths,nama_path',
            'deskripsi' => 'nullable|string',
        ]);

        LearningPath::create($validated);

        return redirect()->route('admin.learning-path.index')->with('success', 'Learning Path baru berhasil ditambahkan.');
    }

    // SHOW: Menampilkan detail Learning Path dan form untuk menambah Materi
    public function show(LearningPath $learningPath)
    {
        // PENTING: Muat materi yang sudah terhubung dengan path ini, diurutkan berdasarkan urutan pivot
        $pathMateris = $learningPath->materis()->orderBy('urutan')->get(); 
        
        // Ambil semua materi yang BELUM terhubung dengan path ini (untuk opsi add)
        $existingMaterisIds = $pathMateris->pluck('id_materi')->toArray();
        $availableMateris = Materi::whereNotIn('id_materi', $existingMaterisIds)->get();

        return view('admin.learning-path.show', compact('learningPath', 'pathMateris', 'availableMateris'));
    }

    // UPDATE: Menampilkan form edit
    public function edit(LearningPath $learningPath)
    {
        return view('admin.learning-path.edit', compact('learningPath'));
    }

    // UPDATE: Memperbarui data
    public function update(Request $request, LearningPath $learningPath)
    {
        $validated = $request->validate([
            'nama_path' => 'required|string|max:255|unique:learning_paths,nama_path,' . $learningPath->id,
            'deskripsi' => 'nullable|string',
        ]);

        $learningPath->update($validated);

        return redirect()->route('admin.learning-path.index')->with('success', 'Learning Path berhasil diperbarui.');
    }

    // DELETE: Menghapus data
    public function destroy(LearningPath $learningPath)
    {
        $learningPath->delete();
        return redirect()->route('admin.learning-path.index')->with('success', 'Learning Path berhasil dihapus.');
    }
    
    // --- FUNGSI KHUSUS UNTUK MENAMBAH DAN MENGHAPUS MATERI ---

    // Menambahkan Materi ke Learning Path (Fungsi Khusus)
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
            // attach($materi_id, $pivot_data)
            $learningPath->materis()->attach($validated['materi_id'], ['urutan' => $nextUrutan]);
            return back()->with('success', 'Materi berhasil ditambahkan ke Learning Path.');
        } catch (\Exception $e) {
            // Jika materi sudah ada (primary key violation)
            return back()->with('error', 'Materi sudah ada di Learning Path ini. Error: ' . $e->getMessage());
        }
    }

    // Menghapus Materi dari Learning Path (Fungsi Khusus)
    public function removeMateri(LearningPath $learningPath, Materi $materi)
    {
        // detach() akan menerima primary key dari model yang terhubung (id_materi)
        $learningPath->materis()->detach($materi->id_materi);
        return back()->with('success', 'Materi berhasil dihapus dari Learning Path.');
    }

    // --- FUNGSI PENTING UNTUK MEMPERBARUI URUTAN MATERI ---
    public function updateOrder(Request $request, LearningPath $learningPath)
    {
        // 1. Validasi input: pastikan 'order' ada dan merupakan array
        $request->validate([
            'order' => 'required|array',
            'order.*.id' => 'required|exists:materis,id_materi', 
            'order.*.urutan' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            // 2. Iterasi melalui urutan yang diterima dari frontend
            foreach ($request->input('order') as $item) {
                // Update kolom 'urutan' di tabel pivot 'learning_path_materi'
                $learningPath->materis()->updateExistingPivot($item['id'], [
                    'urutan' => $item['urutan'],
                ]);
            }

            DB::commit();

            // 3. Respon sukses dalam format JSON
            return response()->json(['success' => 'Urutan materi berhasil diperbarui.'], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            // Respon error dalam format JSON
            return response()->json(['error' => 'Gagal memperbarui urutan materi. Pesan: ' . $e->getMessage()], 500);
        }
    }
} // TUTUP KELAS HANYA SATU KALI DI AKHIR FILE