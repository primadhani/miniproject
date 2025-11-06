<x-app-layout>

    {{-- KONTEN UTAMA DENGAN SIDEBAR --}}
    <div class="flex min-h-screen bg-white" x-data="{ sidebarOpen: true }">

        {{-- 1. SIDEBAR --}}
        @include('user.academy.sidebar')

        {{-- 2. MAIN CONTENT --}}
        <main class="flex-1">
            {{-- Menggunakan padding vertikal yang lebih besar untuk memberi ruang di atas/bawah --}}
            <div class="container mx-auto px-4 py-16 sm:py-20">
                
                {{-- Judul Utama (Tetap terpusat) --}}
                <h1 class="text-4xl font-bold text-gray-700 mb-2 text-center">
                    Aktivasi Token
                </h1>
                
                {{-- Container Pembatas Lebar: Fokus di sini. Saya menggunakan max-w-2xl (768px) --}}
                <div class="max-w-2xl mx-auto text-center">
                    
                    {{-- Deskripsi --}}
                    {{-- text-gray-500 font-medium disesuaikan agar mirip referensi --}}
                    <p class="my-4 pb-2 font-medium text-gray-500">
                        Anda punya kode token dari pembelian di e-commerce atau program beasiswa? Silakan aktifkan token tersebut pada kolom di bawah ini untuk mulai belajar.
                    </p>

                    {{-- Form Aktivasi Token --}}
                    <form action="{{ route('redeem.token') }}" method="POST" class="mb-3">
                        @csrf
                        {{-- Flex container untuk input dan tombol --}}
                        <div class="mb-3 d-flex flex-col sm:flex-row gap-3">
                            <div class="flex-grow">
                                <label for="kode_token" class="sr-only">Token</label>
                                <input 
                                    type="text" 
                                    {{-- Gaya input disesuaikan untuk konsistensi --}}
                                    class="w-full px-3 py-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                    id="kode_token" 
                                    placeholder="Masukkan token" 
                                    name="kode_token"
                                    required
                                />
                                
                                {{-- Error message (rata kiri) --}}
                                @error('kode_token')
                                    <p class="mt-2 text-sm text-red-600 text-left">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            {{-- Tombol (diberi margin atas di mobile) --}}
                            <div class="mt-3 sm:mt-0">
                                <button 
                                    type="submit" 
                                    {{-- Tombol dibuat lebar penuh di mobile (w-full) dan auto di desktop (sm:w-auto) --}}
                                    class="class=inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                >
                                    Aktifkan token
                                </button>
                            </div>
                        </div>
                    </form>
                    
                    {{-- Info text (rata kiri) --}}
                    <p class="text-xs font-medium text-gray-500 text-left">
                        Kelas yang teraktivasi akan sesuai dengan token masing-masing (token beasiswa, voucher fisik kelas satuan dari e-commerce, voucher fisik langganan dari e-commerce, dsb)
                    </p>

                    {{-- Pesan Sukses/Error (rata kiri) --}}
                    @if (session('success'))
                        <div class="mt-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded text-left">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mt-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded text-left">
                            {{ session('error') }}
                        </div>
                    @endif
                    
                </div>
                
            </div>
        </main>

    </div>
</x-app-layout>