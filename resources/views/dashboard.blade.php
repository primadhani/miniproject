<x-app-layout>

    {{-- Menghapus 'min-h-screen' agar tinggi div background hanya menyesuaikan kontennya --}}
    {{-- w-full memastikan lebar penuh (rata kiri kanan) --}}
    <div class="w-full py-4 bg-cover bg-center" style="background-image: url('{{ asset('bg.jpg') }}');">        
        <div class="max-w-5xl mx-auto px-6">
            {{-- MENGGANTI 'mb-6' MENJADI 'mb-10' untuk jarak yang lebih besar --}}
            <div class="text-white text-right mb-10">
                <h1 class="text-2xl font-semibold mb-1">
                    {{-- Menggunakan nama user yang sedang login --}}
                    Selamat Datang <span class="font-bold">{{ Auth::user()->name }}!</span>
                </h1>
                <p class="text-blue-100">Semoga aktivitas belajarmu menyenangkan.</p>
            </div>

            {{-- Div ini sekarang memiliki jarak di atasnya yang lebih besar karena mb-10 di elemen sebelumnya --}}
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-gray-700 font-semibold text-lg mb-2">
                    Status Berlangganan
                </h3>
                <div class="border rounded-lg flex items-center justify-between p-4">
                    <p class="text-gray-600 text-right px-1 sm:text-left mb-3 sm:mb-0">
                        Pilih paket langganan dan mulailah perjalanan Anda menjadi developer profesional.
                    </p>
                    {{-- Memastikan tombol mengarah ke rute user.academy.langganan --}}
                    <a class="bg-gray-800 hover:bg-gray-900 text-white px-2 py-1 rounded-lg transition w-40 text-sm text-center">
                        Langganan
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Wrapper untuk konten grid agar berada di tengah --}}
    <div class="max-w-5xl mx-auto px-6 py-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 py-8"> 
                
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-gray-700 font-semibold text-lg mb-4">
                    Learning Path
                </h3>
                
                {{-- Mengganti Placeholder dengan perulangan data Learning Path yang sebenarnya --}}
                @forelse ($learningPaths as $lp)
                    <div class="border p-4 rounded-lg bg-gray-50 mb-4">
                        <p class="font-bold text-gray-800 mb-1">{{ $lp->nama_path }}</p>
                        <div class="w-full bg-gray-200 rounded-full h-2.5 mb-2">
                            <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $lp->progressPercentage }}%"></div>
                        </div>
                        <p class="text-sm text-gray-500">
                            Progres: {{ $lp->progressPercentage }}% ({{ $lp->materiWithProgress }} dari {{ $lp->totalMateri }} materi)
                        </p>
                        
                        {{-- Logika Lanjutkan Belajar (KOREKSI DI SINI) --}}
                        @if ($lp->nextMateri)
                            <a href="{{ route('user.materi.show', $lp->nextMateri->id_materi) }}" class="text-blue-500 hover:text-blue-700 text-sm mt-2 block">Lanjutkan Belajar: {{ $lp->nextMateri->nama_materi }}</a>
                        @else
                            {{-- Jika belum ada progress, arahkan ke halaman detail LP (id standar di LearningPath) --}}
                            <a href="{{ route('user.learning-path.show', $lp->id) }}" class="text-blue-500 hover:text-blue-700 text-sm mt-2 block">Mulai Belajar</a>
                        @endif
                    </div>
                @empty
                    <p class="text-sm text-gray-500 mt-4">Belum ada Learning Path yang diikuti. Kunjungi <a href="{{ route('user.academy') }}" class="text-blue-500 hover:text-blue-700 font-medium">Akademi</a>.</p>
                @endforelse
                
            </div>

            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-gray-700 font-semibold text-lg mb-4">
                    Aktivitas Belajar
                </h3>
                <ul class="space-y-3">
                    {{-- Mengganti Placeholder dengan perulangan data Materi yang sebenarnya --}}
                    @forelse ($recentMaterials as $material)
                        <li class="border-b pb-2">
                            <a href="{{ $material->bacaan_route_url }}" class="font-medium text-gray-800 hover:text-blue-600 block">{{ $material->materi_title }} (Modul: {{ $material->modul_title }})</a>
                            <p class="text-xs text-gray-500">Bacaan Terakhir: {{ $material->bacaan_title }}</p>
                            <p class="text-xs text-gray-500">Terakhir dibuka: {{ $material->last_accessed_at }}</p>
                        </li>
                    @empty
                        <li>
                            <p class="text-sm text-gray-500">Anda belum membuka materi apa pun. Kunjungi <a href="{{ route('user.academy') }}" class="text-blue-500 hover:text-blue-700 font-medium">Akademi</a> untuk memulai.</p>
                        </li>
                    @endforelse
                </ul>
            </div>

        </div>
    </div>
</x-app-layout>