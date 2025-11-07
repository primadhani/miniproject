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
                    <p class="text-gray-600 text-center sm:text-left mb-3 sm:mb-0">
                        Pilih paket langganan dan mulailah perjalanan Anda menjadi developer profesional.
                    </p>
                    {{-- Memastikan tombol mengarah ke rute user.academy.langganan --}}
                    <a href="{{ route('user.academy.langganan') }}"
                        class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded-lg transition">
                        Pilih paket langganan
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 pb-8"> 
                
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h3 class="text-gray-700 font-semibold text-lg mb-4">
                        Learning Path Anda
                    </h3>
                    {{-- Placeholder untuk Learning Path --}}
                    <div class="border p-4 rounded-lg bg-gray-50">
                        <p class="font-bold text-gray-800 mb-1">Menjadi Backend Developer Profesional</p>
                        <div class="w-full bg-gray-200 rounded-full h-2.5 mb-2">
                            <div class="bg-blue-600 h-2.5 rounded-full" style="width: 45%"></div>
                        </div>
                        <p class="text-sm text-gray-500">Progres: 45% (2 dari 5 materi)</p>
                        <a href="#" class="text-blue-500 hover:text-blue-700 text-sm mt-2 block">Lanjutkan Belajar</a>
                    </div>
                    {{-- Anda akan mengganti ini dengan loop data dari controller --}}
                    <p class="text-sm text-gray-500 mt-4">Belum ada Learning Path yang diikuti? Kunjungi <a href="{{ route('user.academy') }}" class="text-blue-500 hover:text-blue-700 font-medium">Akademi</a>.</p>
                </div>

                <div class="bg-white rounded-xl shadow-md p-6">
                    <h3 class="text-gray-700 font-semibold text-lg mb-4">
                        4 Materi Terakhir Dibuka
                    </h3>
                    <ul class="space-y-3">
                        {{-- Placeholder 4 Materi --}}
                        <li class="border-b pb-2">
                            <a href="#" class="font-medium text-gray-800 hover:text-blue-600 block">Dasar-Dasar PHP (Modul 3: Array)</a>
                            <p class="text-xs text-gray-500">Terakhir dibuka: 5 menit yang lalu</p>
                        </li>
                        <li class="border-b pb-2">
                            <a href="#" class="font-medium text-gray-800 hover:text-blue-600 block">Dasar-Dasar HTML (Modul 2: Struktur Teks)</a>
                            <p class="text-xs text-gray-500">Terakhir dibuka: 2 jam yang lalu</p>
                        </li>
                        <li class="border-b pb-2">
                            <a href="#" class="font-medium text-gray-800 hover:text-blue-600 block">Pengenalan Laravel (Modul 1: Instalasi)</a>
                            <p class="text-xs text-gray-500">Terakhir dibuka: Kemarin</p>
                        </li>
                        <li>
                            <a href="#" class="font-medium text-gray-800 hover:text-blue-600 block">Git dan GitHub Fundamental</a>
                            <p class="text-xs text-gray-500">Terakhir dibuka: 3 hari yang lalu</p>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
</x-app-layout>