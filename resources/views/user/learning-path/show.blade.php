<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $learningPath->nama_path }}
        </h2>
        <div class="text-sm mt-1">
            <a href="{{ route('user.academy') }}" class="text-indigo-600 hover:text-indigo-900">Academy</a>
            / {{ $learningPath->nama_path }}
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    <div class="mb-8">
                        <h3 class="text-2xl font-bold text-gray-800">{{ $learningPath->nama_path }}</h3>
                        <p class="text-gray-600 mt-2">{{ $learningPath->deskripsi }}</p>
                        
                        {{-- Informasi durasi atau status (opsional) --}}
                        <div class="mt-4 text-sm text-gray-500">
                            Durasi Estimasi: **3 Jam** | Materi: **{{ $learningPath->materis->count() }}**
                        </div>
                    </div>
                    
                    <h4 class="text-xl font-semibold mb-4 border-b pb-2 text-gray-700">Daftar Materi dalam Learning Path</h4>

                    @forelse ($learningPath->materis as $materi)
                        <div class="flex items-center justify-between p-4 mb-3 bg-gray-50 border rounded-lg shadow-sm hover:shadow-md transition duration-150">
                            <div class="flex items-center">
                                {{-- Nomor Urut --}}
                                <div class="w-8 h-8 rounded-full bg-indigo-500 text-white flex items-center justify-center font-bold mr-4 shrink-0 text-sm">
                                    {{ $materi->pivot->urutan }}
                                </div>

                                <div>
                                    <p class="text-base font-medium text-gray-900">{{ $materi->nama_materi }}</p>
                                    <p class="text-sm text-gray-500">{{ $materi->tipe_materi }}</p>
                                </div>
                            </div>
                            
                            {{-- Tombol Akses/Mulai --}}
                            <a href="{{ route('user.materi.show', $materi->id) }}" 
                               class="text-sm font-semibold px-3 py-1 border rounded-full text-white bg-green-500 hover:bg-green-600 transition duration-150">
                                Mulai
                            </a>
                        </div>
                    @empty
                        <p class="text-gray-500 italic">Belum ada materi yang ditambahkan ke Learning Path ini.</p>
                    @endforelse

                </div>
            </div>
        </div>
    </div>
</x-app-layout>