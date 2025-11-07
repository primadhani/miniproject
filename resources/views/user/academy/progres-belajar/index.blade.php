<x-app-layout>
    <div class="flex min-h-screen bg-gray-100" x-data="{ sidebarOpen: true }">

        {{-- 1. SIDEBAR (Width Toggled) --}}
        @include('user.academy.sidebar')

        {{-- 2. MAIN CONTENT --}}
        <main class="flex-1 p-4 sm:p-6 lg:p-8">
            {{-- PERUBAHAN UTAMA 1: Hapus wrapper card di sini, tambahkan class space-y-6 untuk memberi jarak antar card --}}
            <div class="max-w-full space-y-6"> 
                
                @forelse ($learningPaths as $learningPath)
                    {{-- PERUBAHAN UTAMA 2: Bungkus seluruh konten Learning Path di dalam card terpisah --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            
                            {{-- Header Learning Path --}}
                            <div class="mb-6">
                                <i class="ph ph-graduation-cap"></i>
                                <div class="flex items-center mb-3">
                                    <h3 class="text-2xl font-bold text-gray-800">{{ $learningPath->nama_path }}</h3>
                                </div>
                                
                                <p class="text-sm text-gray-600 flex items-center mb-4">
                                    <i class="ph ph-clock"></i>
                                    @if (isset($learningPath->deadline_token))
                                        Batas akhir belajar: 
                                        <span class="font-semibold text-grey-600 ml-1">{{ \Carbon\Carbon::parse($learningPath->deadline_token)->format('d F Y') }}</span>
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
            {{-- Mulai Anchor Tag di sini untuk membuat seluruh baris dapat diklik --}}
            <a href="{{ route('user.koridor.index', $materi->id_materi) }}" class="block">
                <div class="flex items-start py-4 border-b border-gray-200 hover:bg-gray-50 transition duration-150">
                    {{-- Checkmark icon (hijau) --}}
                    <svg class="w-6 h-6 text-green-500 mr-4 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>

                    {{-- Konten Materi --}}
                    <div class="flex-1">
                        {{-- Hapus Anchor Tag di sini, cukup teks saja --}}
                        <span class="text-base text-gray-800 hover:text-blue-600 transition duration-150">
                            {{ $materi->nama_materi }}
                        </span>
                    </div>
                </div>
            </a>
            {{-- Akhir Anchor Tag --}}
        @endforeach
        {{-- OPTIONAL: Tambahkan CSS untuk menghilangkan border bawah pada elemen terakhir jika diperlukan --}}
    </div>
@else
    <p class="text-gray-500 italic">Belum ada materi ditambahkan ke Learning Path ini.</p>
@endif
                            
                        </div>
                    </div>
                @empty
                    {{-- Pastikan pesan kosong juga ada di dalam card --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <p class="text-gray-500">Belum ada Learning Path yang tersedia.</p>
                        </div>
                    </div>
                @endforelse

            </div> {{-- Penutup <div class="max-w-full space-y-6"> --}}
        </main>
        {{-- END MAIN CONTENT --}}

    </div>
    {{-- END KONTEN UTAMA DENGAN SIDEBAR --}}
    
</x-app-layout>