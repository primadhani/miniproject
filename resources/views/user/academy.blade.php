<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Akademi') }}
        </h2>
    </x-slot>

    {{-- KONTEN UTAMA DENGAN SIDEBAR --}}
    <div class="flex min-h-screen bg-gray-100">

        {{-- 1. SIDEBAR (Fixed Width) --}}
        <div class="w-64 bg-white border-r border-gray-200 shadow-xl p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-6 border-b pb-2">Navigasi Utama</h3>
            
            <nav class="space-y-2">
                
                {{-- Link Dashboard --}}
                <a href="#" class="flex items-center p-3 text-sm font-semibold text-gray-700 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 transition duration-150">
                    Progres Belajar
                </a>

                {{-- Link Akademi (Aktif) --}}
                <a href="#" class="flex items-center p-3 text-sm font-semibold text-gray-700 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 transition duration-150">
                    Runtutan Belajar
                </a>

                {{-- Link Profil --}}
                <a href="#" class="flex items-center p-3 text-sm font-semibold text-gray-700 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 transition duration-150">
                    Langganan
                </a>

            </nav>
        </div>

        {{-- 2. MAIN CONTENT --}}
        <main class="flex-1 p-4 sm:p-6 lg:p-8">
            <div class="max-w-full mx-auto">
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
                                    Deadline belajar untuk seluruh kelas bisa dilihat pada: 
                                    <a href="#" class="text-blue-600 hover:underline ml-1">Timeline Program</a>.
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
                                                <a href="{{ route('user.materi.show', $materi->id_materi) }}" class="text-base text-gray-800 hover:text-blue-600 transition duration-150">
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