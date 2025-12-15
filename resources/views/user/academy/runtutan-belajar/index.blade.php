<x-app-layout>
    <div class="flex min-h-screen bg-gray-100" x-data="{ sidebarOpen: true }">

        {{-- SIDEBAR --}}
        @include('user.academy.sidebar')

        {{-- CONTENT --}}
        <div class="flex-1 flex flex-col overflow-hidden">

            {{-- MAIN --}}
            <main class="flex-1 overflow-y-auto p-6">
                {{-- LEARNING PATH LIST --}}
                @forelse ($learningPaths as $path)
                    <div class="mb-6 bg-white rounded-lg shadow-md p-6">

                        <h1>
                            <b>{{ $path->nama_path }}</b>
                        </h1>

                        <p class="text-gray-600 mb-4">
                            {{ $path->deskripsi }}
                        </p>

                        {{-- Progress Learning Path --}}
                        <div class="mb-6">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-medium text-gray-700">
                                    Progress Learning Path
                                </span>
                                <span class="text-sm font-semibold text-indigo-600">
                                    {{ $path->percentage ?? 0 }}%
                                </span>
                            </div>

                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-indigo-600 h-2.5 rounded-full"
                                     style="width: {{ $path->percentage ?? 0 }}%">
                                </div>
                            </div>
                        </div>

                        {{-- MATERI --}}
                        <div>

                            @forelse ($path->materis as $materi)
                                <div class="mb-4 p-4 bg-gray-50 rounded-lg border">

                                    <div class="flex justify-between items-center mb-2">
                                        <h4 class="font-medium text-gray-800">
                                            {{ $materi->nama_materi }}

                                            @if (isset($materi->total_bacaan))
                                                <span class="text-sm text-gray-500">
                                                    (Total Bacaan: {{ $materi->total_bacaan }})
                                                </span>
                                            @endif
                                        </h4>

                                        <span class="text-sm font-semibold text-green-700">
                                            {{ $materi->percentage ?? 0 }}%
                                        </span>
                                    </div>

                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-green-600 h-2 rounded-full"
                                             style="width: {{ $materi->percentage ?? 0 }}%">
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-6 text-gray-500">
                                    Tidak ada materi yang terdaftar untuk Learning Path ini.
                                </div>
                            @endforelse
                        </div>

                    </div>
                @empty
                    {{-- EMPTY STATE --}}
                    <div class="text-center py-12 bg-white rounded-lg shadow-md">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">
                            Belum Ada Learning Path
                        </h3>
                        <p class="text-gray-600 mb-2">
                            Anda belum terdaftar dalam Learning Path manapun.
                        </p>
                        <p class="text-gray-500">
                            Silakan redeem token langganan Anda untuk mulai belajar.
                        </p>
                    </div>
                @endforelse
            </main>

            {{-- ===================== --}}
            {{-- REKOMENDASI LP --}}
            {{-- ===================== --}}
            <section class="p-6 bg-gray-100 border-t">

                <div class="bg-white shadow-md rounded-lg p-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4 border-b pb-2">
                        Rekomendasi Learning Path
                    </h2>

                    @if ($recommendedLearningPaths->isNotEmpty())
                        @php $path = $recommendedLearningPaths->first(); @endphp

                        <p class="text-sm text-gray-600 mb-4">
                            Kami merekomendasikan
                            <span class="font-semibold text-indigo-600">
                                {{ $path->nama_path }}
                            </span>
                            karena terdapat materi yang sudah Anda selesaikan.
                        </p>

                        <div class="border border-indigo-200 rounded-lg p-4 bg-indigo-50">

                            <h4 class="text-lg font-bold text-indigo-800 mb-2">
                                {{ $path->nama_path }}
                            </h4>

                            <a href="{{ route('user.learning-path.show', $path->id) }}"
                               class="inline-block mb-3 px-3 py-1 text-xs font-semibold rounded-md
                                      text-white bg-indigo-600 hover:bg-indigo-700">
                                Lihat Learning Path
                            </a>

                            <p class="text-sm text-gray-700 mb-4">
                                {{ $path->deskripsi }}
                            </p>

                            <div class="space-y-2">
                                <h5 class="text-sm font-semibold text-gray-700">
                                    Daftar Materi:
                                </h5>

                                @foreach ($path->materis as $materi)
                                    <div
                                        class="flex justify-between items-center p-2 rounded-md border
                                            {{ $materi->is_common
                                                ? 'bg-green-100 border-green-300'
                                                : 'bg-white border-gray-200' }}">

                                        <a href="{{ route('user.materi.show', $materi->id_materi) }}"
                                           class="text-sm font-medium
                                                {{ $materi->is_common
                                                    ? 'text-green-700'
                                                    : 'text-gray-800' }}">
                                            {{ $materi->nama_materi }}
                                        </a>

                                        @if ($materi->is_common)
                                            <span class="text-xs font-semibold text-white
                                                         bg-green-500 px-2 py-0.5 rounded-full">
                                                Sudah Selesai
                                            </span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    @else
                        <p class="text-gray-500">
                            Tidak ada Learning Path lain yang relevan saat ini.
                        </p>
                    @endif
                </div>
            </section>

        </div>
    </div>
</x-app-layout>
