<x-app-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Learning Path: ') . $learningPath->nama_path }}
        </h2>
        <div class="text-sm mt-1">
            <a href="{{ route('admin.learning-path.index') }}" class="text-indigo-600 hover:text-indigo-900">Learning Path</a>
            / {{ $learningPath->nama_path }}
        </div>
    </x-slot>

    <div class="py-6">
        <div class="w-full px-4 sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert"><span class="block sm:inline">{{ session('success') }}</span></div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert"><span class="block sm:inline">{{ session('error') }}</span></div>
            @endif

            <div class="bg-white p-6 shadow-sm sm:rounded-lg mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Deskripsi</h3>
                <p class="text-gray-600">{{ $learningPath->deskripsi }}</p>
                <a href="{{ route('admin.learning-path.edit', $learningPath->id) }}" class="mt-4 inline-block text-sm text-indigo-600 hover:text-indigo-900 font-medium">Edit Detail Path</a>
            </div>

            <div class="bg-white p-6 shadow-sm sm:rounded-lg mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Tambahkan Materi ke Path Ini</h3>
                
                <form method="POST" action="{{ route('admin.learning-path.addMateri', $learningPath->id) }}">
                    @csrf
                    <div class="flex items-center space-x-4">
                        <div class="flex-grow">
                            <x-input-label for="materi_id" :value="__('Pilih Materi')" />
                            <select id="materi_id" name="materi_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
                                @forelse ($availableMateris as $materi)
                                    <option value="{{ $materi->id_materi }}">{{ $materi->nama_materi }} (ID: {{ $materi->id_materi }})</option>
                                @empty
                                    <option disabled>Semua Materi sudah ditambahkan</option>
                                @endforelse
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('materi_id')" />
                        </div>
                        <div class="pt-6">
                             <x-primary-button :disabled="$availableMateris->isEmpty()">{{ __('Tambahkan') }}</x-primary-button>
                        </div>
                    </div>
                </form>
            </div>
            
            <h3 class="font-semibold text-xl text-gray-800 leading-tight mb-4">{{ __('Daftar Materi di Path Ini') }} ({{ $pathMateris->count() }} Materi)</h3>
            
            <div class="text-right mb-4">
                <x-secondary-button id="save-order-button" style="display: none;">
                    {{ __('Simpan Urutan Baru') }}
                </x-secondary-button>
            </div>
            
            <div class="shadow overflow-hidden border-b border-gray-200 rounded-lg">
                <table class="min-w-full divide-y divide-gray-200 w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-16 cursor-move">Urutan</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Materi</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi Singkat</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="sortable-list">
                        @forelse ($pathMateris as $materi)
                            <tr class="sortable-item" data-id="{{ $materi->id_materi }}">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-center drag-handle cursor-move">
                                    {{ $materi->pivot->urutan }}
                                </td>
                                <td class="px-6 py-4 whitespace-normal text-sm text-gray-800 break-words font-medium">
                                    <a href="{{ route('admin.materi.edit', $materi->id_materi) }}" class="text-indigo-600 hover:text-indigo-900 font-bold">
                                        {{ $materi->nama_materi }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 whitespace-normal text-sm text-gray-700 break-words max-w-lg">
                                    {{ \Illuminate\Support\Str::limit($materi->deskripsi, 100, '...') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                                    <form action="{{ route('admin.learning-path.removeMateri', [$learningPath->id, $materi->id_materi]) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus materi ini dari Learning Path?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 font-medium">
                                            Hapus dari Path
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-6 py-6 text-center text-sm text-gray-500 italic">Belum ada Materi di Learning Path ini.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
        </div>
    </div>
    
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sortableList = document.getElementById('sortable-list');
            const saveButton = document.getElementById('save-order-button');
            let orderChanged = false;

            if (typeof Sortable === 'undefined') {
                console.error('SortableJS library not loaded. Check app-admin.blade.php for the CDN link.');
                return; 
            }

            if (sortableList && sortableList.querySelector('.sortable-item')) {
                new Sortable(sortableList, {
                    animation: 150,
                    handle: '.drag-handle', 
                    onUpdate: function (evt) {
                        orderChanged = true;
                        saveButton.style.display = 'inline-block';
                        updateDisplayOrder();
                    }
                });
                
                const dragHandles = document.querySelectorAll('.drag-handle');
                dragHandles.forEach(handle => {
                    handle.style.cursor = 'move';
                });
            }

            function updateDisplayOrder() {
                const items = sortableList.querySelectorAll('.sortable-item');
                items.forEach((item, index) => {
                    item.querySelector('.drag-handle').textContent = index + 1; 
                });
            }

            saveButton.addEventListener('click', function() {
                if (!orderChanged) return;
                
                saveButton.disabled = true;
                saveButton.textContent = 'Menyimpan...';

                const items = sortableList.querySelectorAll('.sortable-item');
                const newOrder = [];
                
                items.forEach((item, index) => {
                    newOrder.push({
                        id: item.getAttribute('data-id'),
                        urutan: index + 1 
                    });
                });
                
                // --- PERBAIKAN KRITIS: Menambahkan header X-Requested-With ---
                fetch("{{ route('admin.learning-path.updateOrder', $learningPath->id) }}", {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        // HEADER INI PENTING UNTUK LARAVEL CSRF
                        'X-Requested-With': 'XMLHttpRequest', 
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ order: newOrder })
                })
                .then(response => {
                    // Penanganan Error Kritis: Mendeteksi jika respons adalah HTML (redirect/error)
                    const contentType = response.headers.get("content-type");
                    
                    if (!response.ok) {
                        if (contentType && contentType.indexOf("application/json") !== -1) {
                            return response.json(); 
                        } else {
                            // Respons adalah HTML (Inilah yang menyebabkan error Anda)
                            alert('⚠️ Sesi berakhir, server error, atau token tidak valid. Mohon refresh halaman.');
                            window.location.reload(); 
                            throw new Error('Server returned non-JSON response (likely HTML redirect).');
                        }
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        alert(data.success); 
                        window.location.reload(); 
                    } else {
                        throw new Error(data.error || 'Gagal memperbarui urutan.');
                    }
                })
                .catch(error => {
                    console.error('Fetch Error:', error);
                    let errorMessage = error.message || 'Terjadi kesalahan saat menyimpan urutan.';
                    alert('Error: ' + errorMessage);
                    
                    saveButton.disabled = false;
                    saveButton.textContent = 'Simpan Urutan Baru';
                });
            });

        });
    </script>
    @endpush
    
</x-app-admin-layout>