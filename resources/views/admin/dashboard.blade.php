<x-app-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Bagian Statistik Utama (Cards) --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                {{-- Card Total User --}}
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 flex items-center justify-between border-l-4 border-indigo-500">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total User</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $totalUsers }}</p>
                    </div>
                    <img src="{{ asset('user2.png') }}" 
                        alt="Ikon Pengguna" 
                        class="h-10 w-10 text-indigo-500 opacity-50" 
                        style="width: 40px; height: 40px; opacity: 0.5;" />
                </div>

                {{-- Card Total Learning Path --}}
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 flex items-center justify-between border-l-4 border-green-500">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Learning Path</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $totalLearningPaths }}</p>
                    </div>
                    <img src="{{ asset('log.png') }}" 
                        alt="Jalur" 
                        class="h-10 w-10 text-indigo-500 opacity-50" 
                        style="width: 40px; height: 40px; opacity: 0.5;" />
                </div>

                {{-- Card Total Materi --}}
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 flex items-center justify-between border-l-4 border-red-500">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Materi</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $totalMateris }}</p>
                    </div>
                    <img src="{{ asset('book.png') }}" 
                        alt="Book" 
                        class="h-10 w-10 text-indigo-500 opacity-50" 
                        style="width: 40px; height: 40px; opacity: 0.5;" />
                </div>
            </div>

            {{-- Bagian Grafik Sederhana (Tampil Data Role) --}}
            <div class="mt-6 bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Statistik Pengguna Berdasarkan Role</h3>
                    <div class="flex flex-wrap gap-4">
                        @foreach ($userCountsByRole as $role => $count)
                            <div class="p-4 bg-gray-100 rounded-lg shadow-sm border border-gray-200">
                                <p class="text-sm font-medium text-gray-500">Role: <span class="font-semibold text-gray-700">{{ strtoupper($role) }}</span></p>
                                <p class="text-2xl font-bold text-gray-900">{{ $count }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-admin-layout>