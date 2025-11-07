<x-app-layout>
    {{-- HILANGKAN CONTAINER WRAPPER DI SEKITAR CONTENT UNTUK MEMENUHI LAYAR --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ruang Pembelajaran') }}
        </h2>
        <div class="text-sm mt-1">
            {{-- Perbaikan: Menggunakan 'gray' daripada 'grey' --}}
            <a href="{{ route('user.academy') }}" class="text-gray-600 hover:text-gray-900">{{ __('Akademi') }}</a>
            @if ($learningPath)
                / <a href="{{ route('user.learning-path.show', $learningPath->id) }}" class="text-gray-600 hover:text-indigo-900">{{ $learningPath->nama_path ?? 'Learning Path' }}</a>
            @endif
            / {{ $materi->nama_materi }}
        </div>
    </x-slot>

    {{-- HILANGKAN PADDING VERTIKAL DARI x-app-layout UNTUK MEMENUHI LAYAR --}}
    {{-- Kelas `py-12` dihapus di sini --}}
    <div> 
        {{-- CONTAINER UTAMA: HILANGKAN MAX-WIDTH DAN MX-AUTO --}}
        <div class="w-full">
            
            {{-- Menggunakan flex untuk layout dua kolom dan memberikan tinggi minimum --}}
            {{-- min-h-screen: Agar konten utama setidaknya setinggi layar, menghilangkan batasan 70vh --}}
            <div class="flex bg-white shadow-xl min-h-screen">
                
                {{-- Kiri: Navigasi Modul dan Bacaan (Lebar Diperkecil & DIBUAT STICKY) --}}
                <div class="w-full lg:w-1/5 {{-- LEBAR DIPERKECIL dari 1/4 menjadi 1/5 --}} 
                            border-r border-gray-200 
                            p-4 {{-- Padding diperkecil --}}
                            bg-gray-50 
                            
                            {{-- PENTING: Untuk membuat sticky, panggil kelas sticky dan atur top. --}}
                            sticky top-0 
                            {{-- Tinggi sidebar diatur agar tidak melebihi viewport (100vh) saat sticky --}}
                            h-screen overflow-y-auto custom-scrollbar"> 

                    <h3 class="text-lg font-bold mb-4 text-indigo-700 border-b pb-2">Daftar Modul</h3>
                    
                    {{-- Iterasi Modul --}}
                    @forelse ($materi->moduls as $modul) 
                        <div class="mb-3">
                            <details class="group" @if($loop->first) open @endif> 
                                <summary class="flex justify-between items-center cursor-pointer list-none py-2 px-3 bg-indigo-100 text-indigo-800 font-semibold rounded-md hover:bg-indigo-200 transition duration-150 text-sm"> {{-- Text size diperkecil --}}
                                    <span class="truncate">{{ $modul->judul_modul }}</span> {{-- Tambah truncate --}}
                                    <svg class="w-4 h-4 transition duration-300 transform group-open:rotate-180 flex-shrink-0 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </summary>
                                
                                {{-- Dropdown: Daftar Bacaan --}}
                                <ul class="mt-2 space-y-1 pl-3 border-l border-indigo-300">
                                    @forelse ($modul->bacaan as $bacaan) 
                                        <li class="py-1">
                                            <a href="#" 
                                                data-bacaan-id="{{ $bacaan->id_bacaan }}"
                                                data-bacaan-judul="{{ $bacaan->judul_bacaan }}"
                                                data-bacaan-konten="{{ json_encode($bacaan->isi_bacaan) }}" 
                                                class="bacaan-link block text-xs {{-- Text size diperkecil --}} text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 p-1 rounded transition duration-100
                                                    @if ($loop->parent->first && $loop->first) active-bacaan font-semibold bg-indigo-100 text-indigo-700 @endif"
                                            >
                                                {{ $bacaan->judul_bacaan }}
                                            </a>
                                        </li>
                                    @empty
                                        <li class="text-xs text-gray-500 italic py-1 px-1">Tidak ada bacaan.</li>
                                    @endforelse
                                </ul>
                            </details>
                        </div>
                    @empty
                        <p class="text-gray-500 italic">Materi ini belum memiliki modul.</p>
                    @endforelse
                </div>

                {{-- Kanan: Konten Bacaan Utama (Lebar 4/5) --}}
                <div class="w-full lg:w-4/5 flex flex-col"> {{-- Lebar diubah menjadi 4/5 --}}
                    
                    {{-- Area Konten yang BISA di-scroll (flex-grow akan mengambil sisa ruang) --}}
                    <div id="bacaan-container" class="flex-grow p-10 overflow-y-auto"> {{-- Padding diperbesar untuk konten --}}
                        <h1 id="bacaan-judul" class="text-4xl font-extrabold mb-6 text-gray-900 border-b pb-3">Pilih Bacaan di Samping</h1>
                        <div id="bacaan-konten" class="prose prose-indigo max-w-none text-gray-700 leading-relaxed"> {{-- Menambahkan `prose-indigo` --}}
                            <p class="text-gray-500 text-lg">Silakan klik salah satu judul bacaan dari daftar modul di panel sebelah kiri untuk memulai.</p>
                        </div>
                    </div>

                    {{-- Tombol Navigasi (Sticky di Bawah) --}}
                    <div class="mt-auto p-6 pt-4 border-t border-gray-200 flex justify-between bg-white sticky bottom-0">
                        {{-- Tombol Sebelumnya --}}
                        <x-secondary-button id="prev-bacaan" disabled>
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Sebelumnya
                        </x-secondary-button>

                        {{-- Tombol Selanjutnya --}}
                        <x-primary-button id="next-bacaan" disabled>
                            Selanjutnya
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </x-primary-button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Script JavaScript dipertahankan tanpa perubahan, karena logikanya sudah benar --}}
    <script>
        // [Kode JavaScript Anda yang sudah berfungsi dengan baik ada di sini]
        document.addEventListener('DOMContentLoaded', function () {
            const links = document.querySelectorAll('.bacaan-link');
            const bacaanJudulElement = document.getElementById('bacaan-judul');
            const bacaanKontenElement = document.getElementById('bacaan-konten');
            const bacaanContainer = document.getElementById('bacaan-container');
            const prevButton = document.getElementById('prev-bacaan');
            const nextButton = document.getElementById('next-bacaan');

            if (!bacaanJudulElement || !bacaanKontenElement || !prevButton || !nextButton) {
                console.error('Elemen konten atau tombol navigasi tidak ditemukan.');
                return;
            }

            // Ambil token CSRF untuk AJAX
            const csrfMeta = document.querySelector('meta[name="csrf-token"]');
            const csrfToken = csrfMeta ? csrfMeta.getAttribute('content') : '';


            // Kumpulkan semua data bacaan dalam array untuk navigasi sekuensial
            const allBacaan = Array.from(links).map((link, index) => ({
                index: index,
                element: link,
                id: link.getAttribute('data-bacaan-id'),
                judul: link.getAttribute('data-bacaan-judul'),
                kontenString: link.getAttribute('data-bacaan-konten'),
            }));
            
            let currentBacaanIndex = -1;

            /**
             * Mengatur class aktif pada link yang sedang dipilih
             */
            function setActiveLink(activeId) {
                links.forEach((link, index) => {
                    // Hapus semua class aktif sebelumnya
                    link.classList.remove('active-bacaan', 'font-semibold', 'bg-indigo-100', 'text-indigo-700');
                    link.classList.add('text-gray-700', 'hover:bg-indigo-50');
                    
                    // Tambahkan class aktif pada link yang sesuai
                    if (link.getAttribute('data-bacaan-id') === activeId) {
                        link.classList.add('active-bacaan', 'font-semibold', 'bg-indigo-100', 'text-indigo-700');
                        link.classList.remove('hover:bg-indigo-50');
                        currentBacaanIndex = index;
                        
                        // Buka elemen <details> parent agar modul terlihat
                        const parentDetails = link.closest('details');
                        if (parentDetails) {
                            parentDetails.open = true;
                        }
                    }
                });
                updateNavigationButtons();
            }
            
            /**
             * Mengupdate status tombol Sebelumnya/Selanjutnya
             */
            function updateNavigationButtons() {
                // Tombol Sebelumnya dinonaktifkan jika ini adalah bacaan pertama
                if (currentBacaanIndex <= 0) {
                    prevButton.setAttribute('disabled', 'disabled');
                    prevButton.classList.add('opacity-50', 'cursor-not-allowed');
                } else {
                    prevButton.removeAttribute('disabled');
                    prevButton.classList.remove('opacity-50', 'cursor-not-allowed');
                }

                // Tombol Selanjutnya dinonaktifkan jika ini adalah bacaan terakhir
                if (currentBacaanIndex === -1) { 
                nextButton.setAttribute('disabled', 'disabled');
                nextButton.classList.add('opacity-50', 'cursor-not-allowed');
                } else {
                    // Selalu aktifkan tombol 'Selanjutnya', bahkan di item terakhir, untuk memicu goToNext.
                    nextButton.removeAttribute('disabled');
                    nextButton.classList.remove('opacity-50', 'cursor-not-allowed');
                }
            }
            
            /**
             * Fungsi inti untuk menampilkan konten bacaan
             */
            function displayBacaan(bacaanData) {
                let konten = null;
                
                // 1. Ambil dan parse konten JSON
                try {
                    if (bacaanData.kontenString) {
                        konten = JSON.parse(bacaanData.kontenString); 
                    }
                } catch (error) {
                    konten = bacaanData.kontenString; 
                }

                setActiveLink(bacaanData.id);
                
                // 2. Tampilkan Judul
                bacaanJudulElement.innerText = bacaanData.judul;
                
                // 3. Tampilkan Konten (Pencegahan XSS dan format)
                if (konten) {
                    const finalKonten = String(konten);
                    
                    // Mengganti \n dengan <br> dan memastikan konten aman
                    const tempElement = document.createElement('div');
                    // Menggunakan textContent untuk menghindari injeksi HTML dari JSON.parse
                    tempElement.textContent = finalKonten; 
                    const safeKonten = tempElement.innerHTML.replace(/\n/g, '<br>');
                    
                    // Tampilkan konten yang sudah aman.
                    bacaanKontenElement.innerHTML = safeKonten;
                } else {
                     bacaanKontenElement.innerHTML = '<p class="text-gray-500 italic">Konten bacaan ini kosong atau tidak dapat dimuat.</p>';
                }

                // Gulir konten utama ke atas saat ganti bacaan
                if (bacaanContainer) {
                    bacaanContainer.scrollTop = 0;
                }
            }

            /**
             * FUNGSI BARU: Mark current bacaan as complete via AJAX
             */
            function markAsComplete(bacaanId) {
                if (!csrfToken) {
                    console.error('CSRF Token tidak ditemukan. Gagal mengirim permintaan progres.');
                    // Mengembalikan Promise yang ditolak jika token tidak ada
                    return Promise.reject(new Error('CSRF Token tidak ditemukan.')); 
                }
                const url = `{{ url('progress/complete') }}/${bacaanId}`;

                return fetch(url, { // <-- Pastikan fetch dikembalikan
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                })
                .then(response => {
                    if (!response.ok) {
                        // Melemparkan error jika status HTTP bukan 2xx
                        throw new Error(`Gagal menandai selesai. Status HTTP: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (!data.success) {
                        // Melemparkan error jika respons server menyatakan kegagalan
                        throw new Error(data.message || 'Gagal menandai selesai dari server.');
                    }
                    // Berhasil
                    return data;
                });
            }
            
            /**
             * Navigasi ke bacaan berikutnya (DIPERBARUI untuk progress)
             */
            function goToNext() {
                if (currentBacaanIndex > -1 && currentBacaanIndex < allBacaan.length) {
                    // Menonaktifkan tombol sementara untuk mencegah klik ganda saat proses AJAX
                    nextButton.setAttribute('disabled', 'disabled');
                    prevButton.setAttribute('disabled', 'disabled'); 

                    // 1. Ambil ID bacaan saat ini (yang akan diselesaikan)
                    const currentBacaanId = allBacaan[currentBacaanIndex].id;
                    const isLastBacaan = currentBacaanIndex === allBacaan.length - 1;

                    // 2. Panggil AJAX untuk menandai selesai dan tunggu hasilnya
                    markAsComplete(currentBacaanId)
                        .then(data => {
                            console.log('Mark complete success:', data);

                            // Setelah berhasil, lakukan navigasi/redirect
                            if (isLastBacaan) {
                                // REDIRECT KE KORIDOR
                                alert('Selamat! Anda telah menyelesaikan semua bacaan di Materi ini. Mengarahkan ke halaman Koridor.');
                                // Menggunakan nama rute user.koridor.index untuk kembali ke halaman koridor materi ini
                                window.location.href = `{{ route('user.koridor.index', $materi->id_materi) }}`;
                            } else {
                                // Pindah ke bacaan berikutnya
                                const nextIndex = currentBacaanIndex + 1;
                                displayBacaan(allBacaan[nextIndex]);
                            }
                        })
                        .catch(error => {
                            console.error('Mark complete error:', error);
                            alert('Gagal menandai bacaan selesai. Silakan coba lagi. Lihat konsol untuk detail error.');
                            // Aktifkan kembali tombol jika gagal
                            updateNavigationButtons(); 
                        });
                }
            }

            /**
             * Navigasi ke bacaan sebelumnya
             */
            function goToPrev() {
                if (currentBacaanIndex > 0) {
                    const prevIndex = currentBacaanIndex - 1;
                    displayBacaan(allBacaan[prevIndex]);
                }
            }

            // 4. Tambahkan Event Listener untuk menangani klik pada daftar link
            links.forEach(link => {
                link.addEventListener('click', function (e) {
                    e.preventDefault();
                    // Cari data bacaan yang sesuai berdasarkan ID
                    const clickedId = this.getAttribute('data-bacaan-id');
                    const bacaanData = allBacaan.find(b => b.id === clickedId);
                    if (bacaanData) {
                        displayBacaan(bacaanData);
                    }
                });
            });

            // 5. Tambahkan Event Listener untuk tombol navigasi
            prevButton.addEventListener('click', goToPrev);
            nextButton.addEventListener('click', goToNext);

            // 6. Inisialisasi: Tampilkan konten dari bacaan pertama saat halaman dimuat
            const initialLink = document.querySelector('.bacaan-link.active-bacaan');
            if (initialLink) {
                // Cari data bacaan yang sesuai berdasarkan ID link awal
                const initialId = initialLink.getAttribute('data-bacaan-id');
                const initialBacaanData = allBacaan.find(b => b.id === initialId);
                if (initialBacaanData) {
                    displayBacaan(initialBacaanData);
                }
            } else if (allBacaan.length > 0) {
                // Jika tidak ada yang ditandai aktif secara default, ambil elemen pertama
                displayBacaan(allBacaan[0]);
            }
        });
    </script>
</x-app-layout>