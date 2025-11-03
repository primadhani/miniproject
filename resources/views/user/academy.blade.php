<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Akademi') }}
        </h2>
    </x-slot>

    <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h3 class="text-2xl font-bold mb-6">Daftar Learning Path</h3>
                
                @forelse ($learningPaths as $learningPath)
                    <div class="mb-8 p-6 border border-gray-200 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                        {{-- Nama Learning Path (Menggunakan nama_path) --}}
                        <h4 class="text-xl font-extrabold mb-3 text-indigo-800">
                            {{-- Ganti rute jika Anda punya rute detail Learning Path --}}
                            <a href="#" class="hover:text-indigo-600">
                                {{ $learningPath->nama_path }}
                            </a>
                        </h4>
                        
                        <p class="text-sm text-gray-600 mb-4">{{ $learningPath->deskripsi }}</p>

                        {{-- Daftar Materi di dalam Learning Path (Menggunakan relasi 'materis') --}}
                        <p class="font-semibold text-base text-gray-700 mb-2 border-b pb-1">Daftar Materi:</p>
                        
                        @if ($learningPath->materis->count())
                            <ul class="list-none space-y-2">
                                @foreach ($learningPath->materis as $materi)
                                    <li class="flex items-center text-gray-800">
                                        <svg class="w-4 h-4 text-green-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                        {{-- Menampilkan nama_materi dan urutan dari pivot table --}}
                                        <span class="font-medium mr-2">({{ $materi->pivot->urutan }})</span> 
                                        <a href="{{ route('user.materi.show', $materi->id_materi) }}" class="hover:text-indigo-500">
                                            {{ $materi->nama_materi }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-500 italic ml-4">Belum ada materi ditambahkan ke Learning Path ini.</p>
                        @endif
                    </div>
                @empty
                    <p class="text-gray-500">Belum ada Learning Path yang tersedia.</p>
                @endforelse

            </div>
        </div>
    </div>
</div>
</x-app-layout>