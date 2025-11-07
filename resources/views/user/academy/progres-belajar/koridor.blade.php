<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Koridor Pembelajaran') }}
        </h2>
        <div class="text-sm mt-1">
            <a href="{{ route('user.academy') }}" class="text-grey-600 hover:text-grey-900">{{ __('Akademi') }}</a>
            @if ($learningPath)
                / <a href="{{ route('user.academy', $learningPath->id) }}" class="text-grey-600 hover:text-indigo-900">{{ $learningPath->nama_path ?? 'Learning Path' }}</a>
            @endif
            / {{ $materi->nama_materi }}
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl sm:rounded-lg p-8">
                
                <div class="text-center py-4">
                    <i class="ph ph-books" style="font-size: 4rem ;"></i>

                    
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Selamat Datang di Koridor Kelas</h1>
                    <h2 class="text-2xl font-semibold text-grey-700 mb-4">{{ $materi->nama_materi }}</h2>

                    {{-- PROGRESS BAR BARU --}}
                    <h3 class="text-lg font-bold text-gray-800 mb-2">Progres Anda:</h3>
                    <div class="w-full bg-gray-200 rounded-full h-4 mb-4">
                        <div class="bg-green-600 h-4 rounded-full transition-all duration-500 ease-out" style="width: {{ $progressPercentage }}%"></div>
                    </div>
                    <p class="text-xl font-bold text-green-700 mb-8 mb-6">{{ $progressPercentage }}% Selesai</p>
                    {{-- AKHIR PROGRESS BAR --}}

                    <div class="bg-indigo-50 p-6 rounded-lg mb-8">
                        <p class="text-lg font-medium text-gray-800">Siap untuk melanjutkan petualangan belajar Anda?</p>
                        <p class="text-sm text-gray-500 mt-2">Tekan tombol di bawah untuk masuk ke ruang modul dan bacaan.</p>
                    </div>

                    <br>

                    <a href="{{ route('user.materi.show', $materi->id_materi) }}" 
                        class="inline-flex items-center px-6 bg-grey-600 border rounded-md font-semibold text-grey text-base uppercase tracking-widest hover:bg-grey-500 active:bg-grey-700 focus:outline-none focus:ring-2 focus:ring-grey-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            @if ($progressPercentage > 0) Belajar Lagi @else Mulai Belajar @endif
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>