<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Koridor Pembelajaran') }}
        </h2>
        <div class="text-sm mt-1">
            <a href="{{ route('user.academy') }}" class="text-indigo-600 hover:text-indigo-900">{{ __('Akademi') }}</a>
            @if ($learningPath)
                / <a href="{{ route('user.learning-path.show', $learningPath->id) }}" class="text-indigo-600 hover:text-indigo-900">{{ $learningPath->nama_path ?? 'Learning Path' }}</a>
            @endif
            / {{ $materi->nama_materi }}
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
                
                <div class="text-center">
                    <svg class="w-16 h-16 text-indigo-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.247m0-13C13.168 5.477 14.754 5 16.5 5s3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18s-3.332.477-4.5 1.247"></path>
                    </svg>
                    
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Selamat Datang di Koridor Belajar</h1>
                    <h2 class="text-2xl font-semibold text-indigo-700 mb-4">{{ $materi->nama_materi }}</h2>

                    @if ($learningPath)
                        <p class="text-gray-600 mb-6">Materi ini adalah bagian dari Learning Path: **{{ $learningPath->nama_path ?? 'Tidak Diketahui' }}**.</p>
                    @endif

                    {{-- PROGRESS BAR BARU --}}
                    <h3 class="text-lg font-bold text-gray-800 mb-2">Progres Anda:</h3>
                    <div class="w-full bg-gray-200 rounded-full h-4 mb-4">
                        <div class="bg-green-600 h-4 rounded-full transition-all duration-500 ease-out" style="width: {{ $progressPercentage }}%"></div>
                    </div>
                    <p class="text-xl font-bold text-green-700 mb-8">{{ $progressPercentage }}% Selesai</p>
                    {{-- AKHIR PROGRESS BAR --}}

                    <div class="bg-indigo-50 p-6 rounded-lg mb-8">
                        <p class="text-lg font-medium text-gray-800">Siap untuk melanjutkan petualangan belajar Anda?</p>
                        <p class="text-sm text-gray-500 mt-2">Tekan tombol di bawah untuk masuk ke ruang modul dan bacaan.</p>
                    </div>

                    <a href="{{ route('user.materi.show', $materi->id_materi) }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-white text-base uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        @if ($progressPercentage > 0) Belajar Lagi @else Mulai Belajar @endif
                    </a>
                </div>

                <div class="mt-10 pt-6 border-t border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-700 mb-3">Apa yang akan Anda pelajari?</h3>
                    <p class="text-gray-600 italic">Deskripsi materi akan ditampilkan di sini (ambil dari model materi).</p>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>