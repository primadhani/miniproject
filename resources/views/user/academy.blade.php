<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Akademi') }}
        </h2>
    </x-slot>

    {{-- KONTEN UTAMA DENGAN SIDEBAR --}}
    {{-- Inisialisasi Alpine.js state untuk sidebar --}}
    <div class="flex min-h-screen bg-gray-100" x-data="{ sidebarOpen: true }">

        {{-- 1. SIDEBAR (Width Toggled) --}}
        <div 
            class="bg-white border-r border-gray-200 shadow-xl p-6 transition-all duration-300 ease-in-out flex flex-col justify-start" 
            :class="sidebarOpen ? 'w-64' : 'w-16'"
        >
            
            {{-- Header Sidebar dengan Tombol Toggle --}}
            <div class="flex items-center mb-6 border-b pb-2" :class="sidebarOpen ? 'justify-between' : 'justify-center'">
                
                {{-- Judul hanya tampil saat terbuka --}}
                <h3 
                    class="text-lg font-bold text-gray-800 truncate"
                    :class="!sidebarOpen && 'hidden'"
                >
                    Navigasi Utama
                </h3>
                
                {{-- Tombol Toggle --}}
                <button 
                    @click="sidebarOpen = !sidebarOpen" 
                    class="p-1 rounded-full text-gray-500 hover:text-indigo-600 hover:bg-gray-100 focus:outline-none flex-shrink-0"
                    title="Toggle Sidebar"
                >
                    {{-- Icon Panah Kiri/Kanan (Animasi Rotasi) --}}
                    <svg 
                        class="w-6 h-6 transform transition-transform duration-300" 
                        :class="sidebarOpen ? 'rotate-0' : 'rotate-180'" 
                        fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8m-11 3h12a2 2 0 002-2V8a2 2 0 00-2-2H8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                </button>
            </div>
            
            {{-- Navigasi Links --}}
            <nav class="space-y-2">
                
                @php
                    $navItems = [
                        ['text' => 'Progres Belajar', 'route' => '#', 'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v14m-6 2l6-3m-6 0V5"></path></svg>'],
                        ['text' => 'Runtutan Belajar', 'route' => '#', 'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>'],
                        ['text' => 'Langganan', 'route' => '#', 'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2-1.343-2-3-2zM9 16h6m-6 0a2 2 0 00-2 2v2M7 16a2 2 0 00-2 2v2"></path></svg>']
                    ];
                @endphp

                @foreach ($navItems as $item)
                    <a 
                        href="{{ $item['route'] }}" 
                        class="flex items-center p-3 text-sm font-semibold text-gray-700 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 transition duration-150"
                        :class="!sidebarOpen && 'justify-center'"
                        title="{{ $item['text'] }}"
                    >
                        {{-- Icon --}}
                        <span class="w-6 h-6 flex-shrink-0" :class="sidebarOpen && 'mr-3'">
                            {!! $item['icon'] !!}
                        </span>
                        
                        {{-- Teks (disembunyikan saat tertutup) --}}
                        <span :class="!sidebarOpen && 'hidden'">
                            {{ $item['text'] }}
                        </span>
                    </a>
                @endforeach

            </nav>
        </div>

        {{-- 2. MAIN CONTENT --}}
        <main class="flex-1 p-4 sm:p-6 lg:p-8">
            <div class="max-w-full"> {{-- *** PERBAIKAN: mx-auto DIHAPUS agar konten melebar penuh *** --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        
                        @forelse ($learningPaths as $learningPath)
                            {{-- Header Learning Path --}}
                            <div class="mb-6">
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