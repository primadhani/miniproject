<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Akademi') }}
        </h2>
    </x-slot> --}}

    {{-- KONTEN UTAMA DENGAN SIDEBAR --}}
    {{-- Inisialisasi Alpine.js state untuk sidebar --}}
    <div class="flex min-h-screen bg-gray-100" x-data="{ sidebarOpen: true }">

        {{-- 1. SIDEBAR (Width Toggled) --}}
        @include('user.academy.sidebar')

        {{-- 2. MAIN CONTENT --}}
        <main class="flex-1 p-4 sm:p-6 lg:p-8">
            <div class="max-w-full"> {{-- *** PERBAIKAN: mx-auto DIHAPUS agar konten melebar penuh *** --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        
                        @forelse ($learningPaths as $learningPath)
                            {{-- Header Learning Path --}}
                            <div class="mb-6">
                                <i class="ph ph-graduation-cap"></i>
                                <div class="flex items-center mb-3">
                                    <h3 class="text-2xl font-bold text-gray-800">{{ $learningPath->nama_path }}</h3>
                                </div>
                                
                                <p class="text-sm text-gray-600 flex items-center mb-4">
                                    <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    @if (isset($learningPath->deadline_token))
                                        Batas akhir belajar: 
                                        <span class="font-semibold text-red-600 ml-1">{{ \Carbon\Carbon::parse($learningPath->deadline_token)->format('d F Y') }}</span>
                                    @else
                                        Deadline belajar untuk seluruh kelas bisa dilihat pada: 
                                        <a href="#" class="text-blue-600 hover:underline ml-1">Timeline Program</a>.
                                    @endif
                                </p>
                            </div>

                            {{-- Daftar Materi dengan Style Minimal --}}
                            @if ($learningPath->materis->count())
                                <div class="space-y-4">
                                    @foreach ($learningPath->materis->sortBy('pivot.urutan') as $materi)
                                        <div class="flex items-start py-4 border-b border-gray-200 hover:bg-gray-50 transition duration-150">
                                            {{-- Checkmark icon (hijau) --}}
                                            <svg class="w-6 h-6 text-green-500 mr-4 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                            
                                            {{-- Konten Materi --}}
                                            <div class="flex-1">
                                                {{-- BARIS INI DIUBAH: Menggunakan nama rute baru 'user.koridor.materi.show' --}}
                                                <a href="{{ route('user.koridor.index', $materi->id_materi) }}" class="text-base text-gray-800 hover:text-blue-600 transition duration-150">
                                                    {{ $materi->nama_materi }}
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500 italic">Belum ada materi ditambahkan ke Learning Path ini.</p>
                            @endif
                            
                        @empty
                            <p class="text-gray-500">Belum ada Learning Path yang tersedia.</p>
                        @endforelse

                    </div>
                </div>
            </div>
        </main>
        {{-- END MAIN CONTENT --}}

    </div>
    {{-- END KONTEN UTAMA DENGAN SIDEBAR --}}
    
</x-app-layout>