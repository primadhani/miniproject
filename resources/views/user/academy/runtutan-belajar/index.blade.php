<x-app-layout>
    <div class="flex min-h-screen bg-gray-100" x-data="{ sidebarOpen: true }">
        @include('user.academy.sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                <h1 class="text-3xl font-bold text-gray-800 mb-6">Runtutan Belajar Saya</h1>

                {{-- Bagian Progress Learning Path --}}
                @forelse ($learningPaths as $path)
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-8">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                            <div class="flex justify-between items-center">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                    {{ $path->nama_path }}
                                </h3>
                                <span class="text-2xl font-bold text-indigo-600">
                                    {{ $path->percentage ?? 0 }}%
                                </span>
                            </div>
                            
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                                {{ $path->deskripsi }}
                            </p>

                            {{-- Progress Bar Learning Path --}}
                            <div class="mt-4">
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-indigo-600 h-2.5 rounded-full" 
                                        style="width: {{ $path->percentage ?? 0 }}%">
                                    </div>
                                </div>
                            </div>

                        </div>
                        
                        <div class="border-t border-gray-200">
                            <dl>
                                @forelse ($path->materis as $materi)
                                    <div class="{{ $loop->even ? 'bg-gray-50' : 'bg-white' }} px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm font-medium text-gray-700 sm:col-span-2">
                                            Materi: {{ $materi->nama_materi }}
                                            {{-- DEBUG INFO: Tampilkan total bacaan untuk verifikasi persentase --}}
                                            @if (isset($materi->total_bacaan))
                                                <span class="ml-2 text-xs text-indigo-400">
                                                    (Total Bacaan: {{ $materi->total_bacaan }})
                                                </span>
                                            @endif
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-1">
                                            <div class="flex items-center space-x-2">
                                                <div class="w-full bg-gray-200 rounded-full h-2">
                                                    <div class="bg-green-500 h-2 rounded-full" 
                                                        style="width: {{ $materi->percentage ?? 0 }}%">
                                                    </div>
                                                </div>
                                                <span class="text-xs font-semibold text-green-700 w-10 text-right">
                                                    {{ $materi->percentage ?? 0 }}%
                                                </span>
                                            </div>
                                        </dd>
                                    </div>
                                @empty
                                    <div class="px-4 py-5 bg-white sm:px-6 text-gray-500">
                                        Tidak ada materi yang terdaftar untuk Learning Path ini.
                                    </div>
                                @endforelse
                            </dl>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-10 bg-white rounded-lg shadow">
                        <p class="text-gray-500 text-lg">Anda belum terdaftar dalam Learning Path manapun.</p>
                        <p class="text-gray-400 mt-2">Silakan redeem token langganan Anda untuk mulai belajar.</p>
                    </div>
                @endforelse
            </main>
            
            {{-- Bagian Rekomendasi Learning Path BARU --}}
            <section class="p-6 bg-gray-100">
                <div class="bg-white shadow-lg sm:rounded-lg">
                    <div class="p-6">
                        <h2 class="text-2xl font-bold text-gray-800 mb-4 border-b pb-2">Rekomendasi Learning Path</h2>
                        
                        @if ($recommendedLearningPaths->isNotEmpty())
                            {{-- Karena hanya 1 LP yang diambil, kita bisa menggunakan $recommendedLearningPaths->first() --}}
                            @php $path = $recommendedLearningPaths->first(); @endphp
                            
                            <p class="text-sm text-gray-600 mb-4">Kami merekomendasikan **{{ $path->nama_path }}** karena terdapat Materi yang sudah Anda selesaikan di dalamnya:</p>
                            
                            <div class="space-y-6">
                                <div class="border border-indigo-200 rounded-lg p-4 bg-indigo-50">
                                    <h4 class="text-lg font-bold text-indigo-800 mb-2">
                                        {{ $path->nama_path }}
                                    </h4>
                                    {{-- Asumsi rute detail LP ada pada 'user.learning-path.show' --}}
                                    <a href="{{ route('user.learning-path.show', $path->id) }}" class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mb-3">
                                        Lihat Learning Path
                                    </a>
                                    <p class="text-sm text-gray-700 mb-3">{{ $path->deskripsi }}</p>

                                    <div class="space-y-2">
                                        <h5 class="text-sm font-semibold text-gray-600">Daftar Materi di LP Ini:</h5>
                                        @foreach ($path->materis as $materi)
                                            <div class="flex justify-between items-center p-2 rounded-md {{ $materi->is_common ? 'bg-green-100 border border-green-300' : 'bg-white border border-gray-200' }}">
                                                {{-- Asumsi rute detail materi ada pada 'user.materi.show' --}}
                                                <a href="{{ route('user.materi.show', $materi->id_materi) }}" class="text-sm font-medium {{ $materi->is_common ? 'text-green-700' : 'text-gray-800' }} hover:text-indigo-600">
                                                    {{ $materi->nama_materi }}
                                                </a>
                                                @if ($materi->is_common)
                                                    <span class="text-xs font-semibold text-white bg-green-500 px-2 py-0.5 rounded-full">Sesuai (Sudah Selesai)</span>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @else
                            <p class="text-gray-500">Tidak ada Learning Path lain yang memiliki Materi yang sudah Anda selesaikan. Selesaikan lebih banyak Materi untuk mendapatkan rekomendasi yang lebih spesifik!</p>
                        @endif
                    </div>
                </div>
            </section>
        </div>
    </div>    
</x-app-layout>