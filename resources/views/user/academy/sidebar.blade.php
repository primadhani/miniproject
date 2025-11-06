{{-- 1. SIDEBAR (Width Toggled) --}}
{{-- Catatan: Variabel Alpine 'sidebarOpen' diasumsikan didefinisikan di elemen induk (index.blade.php) --}}
<div 
    class="bg-white border-r border-gray-200 shadow-xl p-6 transition-all duration-300 ease-in-out flex flex-col justify-start" 
    :class="sidebarOpen ? 'w-64' : 'w-16'"
>
    
    {{-- Header Sidebar dengan Tombol Toggle --}}
    <div class="flex items-center mb-6 border-b pb-2" :class="sidebarOpen ? 'justify-between' : 'justify-center'">
        
        {{-- Judul hanya tampil saat terbuka --}}
        <h3 
            class="text-lg font-bold text-gray-800 truncate"
            :class="!sidebarOpen && 'hidden'"
        >
            Navigasi Utama
        </h3>
        
        {{-- Tombol Toggle --}}
        <button 
            @click="sidebarOpen = !sidebarOpen" 
            class="p-1 rounded-full text-gray-500 hover:text-gray-700 hover:bg-gray-100 focus:outline-none flex-shrink-0"
            title="Toggle Sidebar"
        >
            {{-- Ikon 'Tutup' (ph-caret-left) - Tampil saat sidebar terbuka --}}
            <i 
                class="ph ph-caret-left text-2xl transition-opacity duration-300"
                x-show="sidebarOpen"
            ></i>
            
            {{-- Ikon 'Buka' (ph-caret-right) - Tampil saat sidebar tertutup (layar kecil) --}}
            <i 
                class="ph ph-caret-right text-2xl transition-opacity duration-300"
                x-show="!sidebarOpen"
            ></i>
        </button>
    </div>
    
    {{-- Navigasi Links --}}
    <nav class="space-y-1"> 
        
        @php
            $navItems = [
                // PERHATIAN: Saya menambahkan 'baseRoute' untuk mencocokkan rute utama
                ['text' => 'Progres Belajar', 'baseRoute' => 'user.academy', 'route' => route('user.academy'), 'icon' => '<i class="ph ph-book-bookmark"></i>'],
                ['text' => 'Runtutan Belajar', 'baseRoute' => 'user.academy.runtutan-belajar', 'route' => route('user.academy.runtutan-belajar'), 'icon' => '<i class="ph ph-path"></i>'],
                ['text' => 'Langganan', 'baseRoute' => 'user.academy.langganan', 'route' => route('user.academy.langganan'), 'icon' => '<i class="ph ph-archive"></i>']
            ];
        @endphp

        @foreach ($navItems as $item)
            @php
                // Logika $isActive DISAMAKAN: Hanya aktif jika berada persis di rute utamanya
                // request()->routeIs('nama.rute') akan mengembalikan true jika rute saat ini cocok persis
                $isActive = request()->routeIs($item['baseRoute']); 
            @endphp
            <a 
                href="{{ $item['route'] }}" 
                class="flex items-center p-2 text-sm font-semibold rounded-lg transition duration-150 my-1" 
                :class="[
                    !sidebarOpen && 'justify-center',
                    // PERUBAHAN #1: Status Aktif (bg-gray-200, Teks tetap text-gray-700/800)
                    '{{ $isActive 
                        ? 'bg-gray-200 text-gray-800 hover:bg-gray-200' 
                        : 'text-gray-700 hover:bg-gray-100 hover:text-gray-800' }}'
                ]"
                title="{{ $item['text'] }}"
            >
                {{-- Icon --}}
                <span 
                    class="w-6 h-6 flex items-center justify-center flex-shrink-0 text-xl" 
                    :class="[sidebarOpen && 'mr-3', $isActive ? 'text-gray-800' : 'text-gray-500']"
                >
                    {!! $item['icon'] !!}
                </span>
                
                {{-- Teks (disembunyikan saat tertutup) --}}
                <span :class="!sidebarOpen && 'hidden'">
                    {{ $item['text'] }}
                </span>
            </a>
        @endforeach

    </nav>
</div>