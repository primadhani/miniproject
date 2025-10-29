<x-app-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen User') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="w-full px-4 sm:px-6 lg:px-8">

            {{-- Pesan Status --}}
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            {{-- Formulir Pencarian --}}
            <div class="mb-4">
                <form method="GET" action="{{ route('admin.users') }}">
                    <div class="flex items-center space-x-2">
                        {{-- Input Pencarian --}}
                        <input type="text" name="search" placeholder="Cari Nama, Email, atau Role..." 
                               value="{{ $searchQuery ?? '' }}"
                               class="block w-full sm:w-80 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        
                        {{-- Tombol Cari --}}
                        <x-primary-button type="submit">
                            {{ __('Cari') }}
                        </x-primary-button>
                        
                        {{-- Tombol Reset --}}
                        @if ($searchQuery)
                            <a href="{{ route('admin.users') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Reset
                            </a>
                        @endif
                        
                        {{-- Simpan parameter sorting yang ada --}}
                        <input type="hidden" name="sort" value="{{ $sortColumn }}">
                        <input type="hidden" name="direction" value="{{ $sortDirection }}">
                    </div>
                </form>
            </div>


            <div class="shadow overflow-hidden border-b border-gray-200 rounded-lg">
                <table class="min-w-full divide-y divide-gray-200 w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            {{-- Helper untuk membuat link sorting --}}
                            @php
                                // Note: Carbon diakses secara global, asumsikan sudah tersedia.
                                $getSortLink = function ($column, $currentSort, $currentDirection, $search) {
                                    $direction = $currentSort === $column && $currentDirection === 'asc' ? 'desc' : 'asc';
                                    return route('admin.users', ['sort' => $column, 'direction' => $direction, 'search' => $search]);
                                };
                                
                                $getArrow = function ($column, $currentSort, $currentDirection) {
                                    if ($currentSort === $column) {
                                        return $currentDirection === 'asc' ? ' &uarr;' : ' &darr;'; 
                                    }
                                    return '';
                                };
                            @endphp

                            {{-- Kolom ID (Sortable) --}}
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-12 cursor-pointer hover:bg-gray-100"
                                onclick="window.location='{{ $getSortLink('id', $sortColumn, $sortDirection, $searchQuery) }}'">
                                ID {!! $getArrow('id', $sortColumn, $sortDirection) !!}
                            </th>
                            
                            {{-- Kolom Nama (Sortable) --}}
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[180px] cursor-pointer hover:bg-gray-100"
                                onclick="window.location='{{ $getSortLink('name', $sortColumn, $sortDirection, $searchQuery) }}'">
                                Nama {!! $getArrow('name', $sortColumn, $sortDirection) !!}
                            </th>
                            
                            {{-- Kolom Email (Sortable) --}}
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[220px] cursor-pointer hover:bg-gray-100"
                                onclick="window.location='{{ $getSortLink('email', $sortColumn, $sortDirection, $searchQuery) }}'">
                                Email {!! $getArrow('email', $sortColumn, $sortDirection) !!}
                            </th>
                            
                            {{-- Kolom Role (Sortable) --}}
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24 cursor-pointer hover:bg-gray-100"
                                onclick="window.location='{{ $getSortLink('role', $sortColumn, $sortDirection, $searchQuery) }}'">
                                Role {!! $getArrow('role', $sortColumn, $sortDirection) !!}
                            </th>
                            
                            {{-- KOLOM BARU: TANGGAL DIBUAT (Sortable) --}}
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-32 cursor-pointer hover:bg-gray-100"
                                onclick="window.location='{{ $getSortLink('created_at', $sortColumn, $sortDirection, $searchQuery) }}'">
                                Dibuat {!! $getArrow('created_at', $sortColumn, $sortDirection) !!}
                            </th>

                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-32">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($users as $user)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $user->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-normal text-sm text-gray-800 break-words">
                                    {{ $user->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-normal text-sm text-gray-700 break-words">
                                    {{ $user->email }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $user->role == 'admin' ? 'bg-indigo-100 text-indigo-800' : 'bg-green-100 text-green-800' }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                {{-- CELL BARU: TANGGAL DIBUAT --}}
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y') }}
                                </td>
                                {{-- End of new cell --}}
                                
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                                    {{-- Tombol Edit --}}
                                    <a href="{{ route('admin.users.edit', $user) }}" class="text-indigo-600 hover:text-indigo-900 font-medium mr-3">
                                        Edit
                                    </a>
                                    
                                    {{-- Tombol Hapus (menggunakan form DELETE) --}}
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user: {{ $user->name }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 font-medium">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-6 text-center text-sm text-gray-500 italic">
                                    Tidak ada data user yang ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{-- Link Pagination --}}
            <div class="mt-4">
                {{ $users->links() }}
            </div>

        </div>
    </div>
</x-app-admin-layout>