<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Akademi (Learning Path Saya)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-xl font-bold mb-4">Learning Path yang Sudah Anda Akses</h3>

                    @forelse ($learningPaths as $path)
                        <div class="p-4 mb-4 border rounded-lg shadow-sm hover:bg-gray-50 transition duration-150">
                            <h4 class="text-lg font-semibold text-indigo-600">{{ $path->nama_path }}</h4>
                            <p class="text-sm text-gray-600 mt-1">{{ $path->deskripsi }}</p>
                            
                            {{-- Tautan untuk masuk ke Learning Path (SUDAH DIPERBAIKI) --}}
                            <a href="{{ route('user.learning-path.show', $path->id) }}" class="mt-3 inline-block text-sm font-medium text-blue-500 hover:text-blue-700">
                                Lihat Konten
                            </a>
                        </div>
                    @empty
                        <div class="p-4 bg-yellow-50 border-l-4 border-yellow-400 text-yellow-700">
                            <p>Anda belum memiliki akses ke Learning Path apa pun. Gunakan kode token di halaman Event untuk memulai!</p>
                        </div>
                    @endforelse

                </div>
            </div>
        </div>
    </div>
</x-app-layout>