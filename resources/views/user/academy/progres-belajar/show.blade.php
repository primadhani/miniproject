<x-app-layout>
    
        <x-slot name="header">
        <div class="bg-white shadow-sm py-4"> 
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Ruang Pembelajaran') }}
            </h2>
            <div class="text-sm mt-1">
                <a href="{{ route('user.academy') }}" class="text-grey-600 hover:text-grey-900">{{ __('Akademi') }}</a>
                @if ($learningPath)
                    / <a href="{{ route('user.academy', $learningPath->id) }}" class="text-grey-600 hover:text-indigo-900">{{ $learningPath->nama_path ?? 'Learning Path' }}</a>
                @endif
                / {{ $materi->nama_materi }}
            </div>
        </div>
    </x-slot>

    <div x-data="{ sidebarOpen: true }">
        <div class="mx-auto">
            
            <div class="flex bg-white shadow-xl sm:rounded-lg min-h-[70vh] border border-gray-200" style="height: calc(100vh - 40px);"> 
                
                <div class="
                        border-r border-gray-200 
                        p-4 
                        bg-gray-50 
                        flex-shrink-0
                        overflow-y-auto custom-scrollbar
                        transition-all duration-300 ease-in-out
                        "
                        :class="sidebarOpen ? 'w-64' : 'w-16'">

                    <div class="flex items-center mb-4 border-b pb-2" :class="sidebarOpen ? 'justify-between' : 'justify-center'">
                        <h3 class="text-lg font-bold text-indigo-700 truncate" :class="!sidebarOpen && 'hidden'">
                            Daftar Modul
                        </h3>
                        <button 
                            @click="sidebarOpen = !sidebarOpen" 
                            class="p-1 rounded-full text-indigo-500 hover:text-indigo-700 hover:bg-indigo-100 focus:outline-none flex-shrink-0"
                            title="Toggle Sidebar"
                            :class="!sidebarOpen && 'mx-auto'"
                        >
                            <svg class="w-5 h-5 transition duration-300" :class="sidebarOpen ? 'rotate-0' : 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        </button>
                    </div>

                    <div :class="!sidebarOpen && 'hidden'">
                    
                    @forelse ($materi->moduls->sortBy('urutan') as $modul) 
                        <div class="mb-3">
                            <details class="group" @if($loop->first) open @endif> 
                                <summary class="flex justify-between items-center cursor-pointer list-none py-2 px-3 bg-indigo-100 text-indigo-800 font-semibold rounded-md hover:bg-indigo-200 transition duration-150 text-sm">
                                    <span class="truncate">{{ $modul->nama_modul}}</span> 
                                    <svg class="w-4 h-4 transition duration-300 transform group-open:rotate-180 flex-shrink-0 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </summary>
                                
                                <ul class="mt-2 space-y-1 pl-3 border-l border-indigo-300">
                                    @forelse ($modul->bacaan->sortBy('urutan') as $bacaan) 
                                        <li class="py-1">
                                            <a href="#" 
                                                data-bacaan-id="{{ $bacaan->id_bacaan }}"
                                                data-bacaan-judul="{{ $bacaan->judul_bacaan }}"
                                                data-bacaan-konten="{{ json_encode($bacaan->isi_bacaan) }}" 
                                                class="bacaan-link block text-xs text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 p-1 rounded transition duration-100" {{-- MENGHILANGKAN KELAS AKTIF DEFAULT --}}
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
                </div>

                <div class="flex-1 flex flex-col py-4 px-2"> 
                    
                    <div id="bacaan-container" class="flex-grow p-8 overflow-y-auto custom-scrollbar">
                        <h1 id="bacaan-judul" class="text-3xl font-extrabold mb-6 text-gray-900">Pilih Bacaan di Samping</h1>
                        <div id="bacaan-konten" class="prose max-w-none text-gray-700">
                            <p class="text-gray-500">Silakan klik salah satu judul bacaan dari daftar modul di panel sebelah kiri untuk memulai.</p>
                        </div>
                    </div>

                    <div class="flex-shrink-0 p-8 pt-4 border-t border-gray-200 flex justify-between bg-white">
                        <x-secondary-button id="prev-bacaan" disabled>
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Sebelumnya
                        </x-secondary-button>

                        <x-primary-button id="next-bacaan" disabled>
                            Selanjutnya
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </x-primary-button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        // Gunakan ID Materi saat ini sebagai kunci penyimpanan
        const MATERI_KEY = `lastBacaanId_materi_{{ $materi->id_materi }}`;

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

            const csrfMeta = document.querySelector('meta[name="csrf-token"]');
            const csrfToken = csrfMeta ? csrfMeta.getAttribute('content') : '';


            const allBacaan = Array.from(links).map((link, index) => ({
                index: index,
                element: link,
                id: link.getAttribute('data-bacaan-id'),
                judul: link.getAttribute('data-bacaan-judul'),
                kontenString: link.getAttribute('data-bacaan-konten'),
            }));
            
            let currentBacaanIndex = -1;

            /**
             * Menyimpan ID bacaan yang terakhir dilihat ke Local Storage
             */
            function saveLastReadProgress(bacaanId) {
                try {
                    localStorage.setItem(MATERI_KEY, bacaanId);
                } catch (e) {
                    console.error('Gagal menyimpan progres ke Local Storage:', e);
                }
            }


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
            
            function updateNavigationButtons() {
                if (currentBacaanIndex <= 0) {
                    prevButton.setAttribute('disabled', 'disabled');
                    prevButton.classList.add('opacity-50', 'cursor-not-allowed');
                } else {
                    prevButton.removeAttribute('disabled');
                    prevButton.classList.remove('opacity-50', 'cursor-not-allowed');
                }

                if (currentBacaanIndex === -1) { 
                    nextButton.setAttribute('disabled', 'disabled');
                    nextButton.classList.add('opacity-50', 'cursor-not-allowed');
                } else {
                    nextButton.removeAttribute('disabled');
                    nextButton.classList.remove('opacity-50', 'cursor-not-allowed');
                }
            }
            
            function displayBacaan(bacaanData) {
                let konten = null;
                
                try {
                    if (bacaanData.kontenString) {
                        konten = JSON.parse(bacaanData.kontenString); 
                    }
                } catch (error) {
                    konten = bacaanData.kontenString; 
                }

                setActiveLink(bacaanData.id);
                
                // NEW: Simpan ID bacaan terakhir yang dilihat
                saveLastReadProgress(bacaanData.id);

                bacaanJudulElement.innerText = bacaanData.judul;
                
                if (konten) {
                    const finalKonten = String(konten);
                    
                    const tempElement = document.createElement('div');
                    tempElement.textContent = finalKonten; 
                    const safeKonten = tempElement.innerHTML.replace(/\n/g, '<br>');
                    
                    bacaanKontenElement.innerHTML = safeKonten;
                } else {
                     bacaanKontenElement.innerHTML = '<p class="text-gray-500 italic">Konten bacaan ini kosong atau tidak dapat dimuat.</p>';
                }

                if (bacaanContainer) {
                    bacaanContainer.scrollTop = 0;
                }
            }

            function markAsComplete(bacaanId) {
    if (!csrfToken) {
        console.error('CSRF Token tidak ditemukan. Gagal mengirim permintaan progres.');
        return Promise.reject(new Error('CSRF Token tidak ditemukan.')); 
    }
    const url = `{{ url('progress/complete') }}/${bacaanId}`;

    return fetch(url, { 
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`Gagal menandai selesai. Status HTTP: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (!data.success) {
            throw new Error(data.message || 'Gagal menandai selesai dari server.');
        }
        return data;
    });
}
            
            function goToNext() {
            if (currentBacaanIndex > -1 && currentBacaanIndex < allBacaan.length) { 
                nextButton.setAttribute('disabled', 'disabled');
                prevButton.setAttribute('disabled', 'disabled'); 

                const currentBacaanId = allBacaan[currentBacaanIndex].id;
                const isLastBacaan = currentBacaanIndex === allBacaan.length - 1;

                markAsComplete(currentBacaanId)
                    .then(data => {
                        console.log('Mark complete success:', data);

                        if (isLastBacaan) {
                            alert('Selamat! Anda telah menyelesaikan semua bacaan di Materi ini. Mengarahkan ke halaman Koridor.');
                            window.location.href = "{{ route('user.koridor.index', $materi->id_materi) }}";
                            // Opsional: Hapus kunci dari Local Storage setelah selesai penuh
                            localStorage.removeItem(MATERI_KEY);
                        } else {
                            const nextIndex = currentBacaanIndex + 1;
                            displayBacaan(allBacaan[nextIndex]);
                        }
                    })
                    .catch(error => {
                        console.error('Mark complete error:', error);
                        alert('Gagal menandai bacaan selesai. Silakan coba lagi. Lihat konsol untuk detail error.');
                        updateNavigationButtons(); 
                    });
            }
        }

            function goToPrev() {
                if (currentBacaanIndex > 0) {
                    const prevIndex = currentBacaanIndex - 1;
                    displayBacaan(allBacaan[prevIndex]);
                }
            }

            links.forEach(link => {
                link.addEventListener('click', function (e) {
                    e.preventDefault();
                    const clickedId = this.getAttribute('data-bacaan-id');
                    const bacaanData = allBacaan.find(b => b.id === clickedId);
                    if (bacaanData) {
                        displayBacaan(bacaanData);
                    }
                });
            });

            prevButton.addEventListener('click', goToPrev);
            nextButton.addEventListener('click', goToNext);

            
            // =================================================================
            // NEW INITIALIZATION LOGIC (Memuat dari Local Storage)
            // =================================================================
            const lastReadIdFromStorage = localStorage.getItem(MATERI_KEY);
            let initialBacaanData = null;

            if (lastReadIdFromStorage) {
                // Cari data bacaan yang cocok dengan ID yang tersimpan
                initialBacaanData = allBacaan.find(b => b.id === lastReadIdFromStorage);
            }

            if (initialBacaanData) {
                // Jika ID ditemukan (bacaan terakhir), tampilkan
                displayBacaan(initialBacaanData);
            } else if (allBacaan.length > 0) {
                // Fallback ke item pertama jika tidak ada yang tersimpan atau ID tidak valid
                displayBacaan(allBacaan[0]);
            }
            // =================================================================
        });
    </script>
</x-app-layout>