<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Materi') }}: {{ $materi->nama_materi }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex bg-white shadow-xl sm:rounded-lg min-h-[70vh]">
                
                {{-- Kiri: Navigasi Modul dan Bacaan --}}
                <div class="w-1/4 border-r border-gray-200 p-6 bg-gray-50 overflow-y-auto">
                    <h3 class="text-lg font-bold mb-4 text-indigo-700 border-b pb-2">Daftar Modul</h3>
                    
                    @forelse ($materi->moduls as $modul)
                        <div class="mb-3">
                            {{-- Gunakan $modul->bacaan (singular) --}}
                            {{-- Membuka modul yang berisi bacaan pertama secara default --}}
                            <details class="group" @if($firstBacaan && $modul->bacaan->contains('id_bacaan', $firstBacaan->id_bacaan)) open @endif>
                                <summary class="flex justify-between items-center cursor-pointer list-none py-2 px-3 bg-indigo-100 text-indigo-800 font-semibold rounded-md hover:bg-indigo-200 transition duration-150">
                                    <span>{{ $modul->nama_modul }}</span>
                                    <svg class="w-4 h-4 transition duration-300 transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </summary>
                                
                                {{-- Dropdown: Daftar Bacaan --}}
                                <ul class="mt-2 space-y-1 pl-3 border-l border-indigo-300">
                                    {{-- Gunakan $modul->bacaan (singular) --}}
                                    @forelse ($modul->bacaan as $bacaan) 
                                        <li class="py-1">
                                            <a href="#" 
                                               data-bacaan-id="{{ $bacaan->id_bacaan }}"
                                               data-bacaan-judul="{{ $bacaan->judul_bacaan }}"
                                               {{-- Konten di-encode agar aman saat ditransfer melalui atribut data-* --}}
                                               data-bacaan-konten="{{ json_encode($bacaan->isi_bacaan) }}" 
                                               class="bacaan-link block text-sm text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 p-1 rounded transition duration-100"
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

                {{-- Kanan: Konten Bacaan Utama --}}
                <div class="w-3/4 p-8 overflow-y-auto">
                    <div id="bacaan-container">
                        @if ($firstBacaan)
                            <h1 id="bacaan-judul" class="text-3xl font-extrabold mb-6 text-gray-900">{{ $firstBacaan->judul_bacaan }}</h1>
                            <div id="bacaan-konten" class="prose max-w-none text-gray-700">
                                {{-- Konten default pertama kali dimuat --}}
                                {!! nl2br(e($firstBacaan->isi_bacaan)) !!}
                            </div>
                        @else
                            <p class="text-gray-500 italic">Pilih modul dan bacaan dari panel di samping untuk memulai.</p>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const links = document.querySelectorAll('.bacaan-link');
            const bacaanContainer = document.getElementById('bacaan-container');
            const bacaanJudulElement = document.getElementById('bacaan-judul');
            const bacaanKontenElement = document.getElementById('bacaan-konten');

            // Fungsi untuk menandai link aktif
            function setActiveLink(activeId) {
                links.forEach(l => {
                    l.classList.remove('font-bold', 'bg-indigo-50', 'text-indigo-700');
                });
                const activeLink = document.querySelector(`.bacaan-link[data-bacaan-id="${activeId}"]`);
                if (activeLink) {
                    activeLink.classList.add('font-bold', 'bg-indigo-50', 'text-indigo-700');
                    
                    const parentDetails = activeLink.closest('details');
                    if(parentDetails) {
                        parentDetails.open = true;
                    }
                }
            }

            // Inisialisasi: Tandai bacaan pertama yang dimuat
            const initialId = {{ $firstBacaan->id_bacaan ?? 'null' }}; 
            if (initialId) {
                setActiveLink(initialId);
            }
            
            links.forEach(link => {
                link.addEventListener('click', function (e) {
                    e.preventDefault();
                    
                    const id = this.getAttribute('data-bacaan-id');
                    const judul = this.getAttribute('data-bacaan-judul');
                    
                    const kontenString = this.getAttribute('data-bacaan-konten');
                    let konten = null;

                    // Perbaikan utama: Penanganan JSON.parse yang aman dan pemeriksaan nilai
                    try {
                        // Coba parse string JSON. Jika isinya valid (mis. '"Isi Konten"'), maka akan dikembalikan 'Isi Konten'
                        if (kontenString) {
                            konten = JSON.parse(kontenString); 
                        }
                    } catch (error) {
                        // Fallback: Jika gagal parse, gunakan string mentahnya
                        konten = kontenString; 
                    }

                    setActiveLink(id);
                    
                    // 1. Ganti Judul
                    bacaanJudulElement.innerText = judul;
                    
                    // 2. Ganti Konten (dengan penanganan null/undefined)
                    if (konten) {
                        // Pastikan 'konten' adalah string sebelum memanggil .replace()
                        const finalKonten = String(konten);
                        
                        // Ganti newline dengan <br> untuk menampilkan konten dengan format yang benar
                        bacaanKontenElement.innerHTML = finalKonten.replace(/\n/g, '<br>');
                    } else {
                         bacaanKontenElement.innerHTML = '<p class="text-gray-500 italic">Konten bacaan ini kosong atau tidak dapat dimuat.</p>';
                    }

                    // Gulir ke atas
                    bacaanContainer.scrollTop = 0;
                });
            });
        });
    </script>
    @endpush
</x-app-layout>