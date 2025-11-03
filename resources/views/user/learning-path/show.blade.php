<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Materi') }}: {{ $materi->nama_materi }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Menggunakan flex untuk layout dua kolom dan memberikan tinggi minimum --}}
            <div class="flex bg-white shadow-xl sm:rounded-lg min-h-[70vh]">
                
                {{-- Kiri: Navigasi Modul dan Bacaan (Lebar 1/4) --}}
                <div class="w-1/4 border-r border-gray-200 p-6 bg-gray-50 overflow-y-auto">
                    <h3 class="text-lg font-bold mb-4 text-indigo-700 border-b pb-2">Daftar Modul</h3>
                    
                    {{-- Iterasi Modul (Menggunakan 'moduls' untuk mengatasi error relasi sebelumnya) --}}
                    @forelse ($materi->moduls as $modul) 
                        <div class="mb-3">
                            
                            {{-- Modul Header --}}
                            <details class="group" open> 
                                <summary class="flex justify-between items-center cursor-pointer list-none py-2 px-3 bg-indigo-100 text-indigo-800 font-semibold rounded-md hover:bg-indigo-200 transition duration-150">
                                    <span>{{ $modul->judul_modul }}</span>
                                    <svg class="w-4 h-4 transition duration-300 transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </summary>
                                
                                {{-- Dropdown: Daftar Bacaan --}}
                                <ul class="mt-2 space-y-1 pl-3 border-l border-indigo-300">
                                    @forelse ($modul->bacaan as $bacaan) 
                                        <li class="py-1">
                                            <a href="#" 
                                               data-bacaan-id="{{ $bacaan->id_bacaan }}"
                                               data-bacaan-judul="{{ $bacaan->judul_bacaan }}"
                                               {{-- Konten di-encode agar aman saat ditransfer melalui atribut data-* --}}
                                               data-bacaan-konten="{{ json_encode($bacaan->isi_bacaan) }}" 
                                               class="bacaan-link block text-sm text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 p-1 rounded transition duration-100
                                                    {{-- Tandai bacaan pertama di modul pertama sebagai aktif --}}
                                                    @if ($loop->parent->first && $loop->first) active-bacaan text-indigo-700 bg-indigo-100 font-semibold @endif"
                                            >
                                                {{ $bacaan->judul_bacaan }}
                                            </a>
                                        </li>
                                    @empty
                                        <li class="text-sm text-gray-500 italic">Tidak ada bacaan.</li>
                                    @endforelse
                                </ul>
                            </details>
                        </div>
                    @empty
                        <p class="text-gray-500 italic">Materi ini belum memiliki modul.</p>
                    @endforelse
                </div>

                {{-- Kanan: Konten Bacaan Utama (Lebar 3/4) --}}
                <div id="bacaan-container" class="w-3/4 p-8 overflow-y-auto">
                    <h1 id="bacaan-judul" class="text-3xl font-extrabold mb-6 text-gray-900">Pilih Bacaan di Samping</h1>
                    <div id="bacaan-konten" class="prose max-w-none text-gray-700">
                        <p class="text-gray-500">Silakan klik salah satu judul bacaan dari daftar modul di panel sebelah kiri untuk memulai.</p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Script JavaScript untuk Mengganti Konten Secara Dinamis --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const links = document.querySelectorAll('.bacaan-link');
            const bacaanJudulElement = document.getElementById('bacaan-judul');
            const bacaanKontenElement = document.getElementById('bacaan-konten');
            const bacaanContainer = document.getElementById('bacaan-container');

            if (!bacaanJudulElement || !bacaanKontenElement) {
                console.error('Elemen konten utama tidak ditemukan.');
                return;
            }

            /**
             * Mengatur class aktif pada link yang sedang dipilih
             */
            function setActiveLink(activeId) {
                links.forEach(link => {
                    // Hapus semua class aktif sebelumnya
                    link.classList.remove('active-bacaan', 'font-semibold', 'bg-indigo-50', 'text-indigo-700');
                    link.classList.add('text-gray-700');
                    
                    // Tambahkan class aktif pada link yang sesuai
                    if (link.getAttribute('data-bacaan-id') === activeId) {
                        link.classList.add('active-bacaan', 'font-semibold', 'bg-indigo-50', 'text-indigo-700');
                        // Buka elemen <details> parent agar modul terlihat
                        const parentDetails = link.closest('details');
                        if (parentDetails) {
                            parentDetails.open = true;
                        }
                    }
                });
            }
            
            /**
             * Mengambil data dari elemen link dan menampilkannya di panel konten
             */
            function displayBacaan(element) {
                const id = element.getAttribute('data-bacaan-id');
                const judul = element.getAttribute('data-bacaan-judul');
                const kontenString = element.getAttribute('data-bacaan-konten');
                let konten = null;

                // 1. Ambil dan parse konten JSON
                try {
                    if (kontenString) {
                        konten = JSON.parse(kontenString); 
                    }
                } catch (error) {
                    konten = kontenString; 
                }

                setActiveLink(id);
                
                // 2. Tampilkan Judul
                bacaanJudulElement.innerText = judul;
                
                // 3. Tampilkan Konten (Pencegahan XSS dan format)
                if (konten) {
                    const finalKonten = String(konten);
                    
                    // PERBAIKAN KEAMANAN: Escape HTML untuk Pencegahan XSS
                    const tempElement = document.createElement('div');
                    tempElement.textContent = finalKonten;
                    const safeKonten = tempElement.innerHTML; 
                    
                    // Tampilkan konten yang sudah aman, ganti newline dengan <br> agar paragraf terlihat
                    bacaanKontenElement.innerHTML = safeKonten.replace(/\n/g, '<br>');
                } else {
                     bacaanKontenElement.innerHTML = '<p class="text-gray-500 italic">Konten bacaan ini kosong atau tidak dapat dimuat.</p>';
                }

                // Gulir ke atas halaman konten
                if (bacaanContainer) {
                    bacaanContainer.scrollTop = 0;
                }
            }
            
            // 4. Tambahkan Event Listener untuk menangani klik
            links.forEach(link => {
                link.addEventListener('click', function (e) {
                    e.preventDefault();
                    displayBacaan(this);
                });
            });

            // 5. Inisialisasi: Tampilkan konten dari bacaan pertama saat halaman dimuat
            const initialLink = document.querySelector('.bacaan-link.active-bacaan');
            if (initialLink) {
                displayBacaan(initialLink);
            }
            // Tidak perlu else if (links.length > 0) karena logic inisialisasi sudah kuat
        });
    </script>
</x-app-layout>