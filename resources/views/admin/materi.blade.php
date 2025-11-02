<x-app-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Materi') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="w-full px-4 sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert"><span class="block sm:inline">{{ session('error') }}</span></div>
            @endif

            <div class="mb-6 flex justify-between items-center">
                <a href="{{ route('admin.materi.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Tambah Materi Baru') }}
                </a>

                <form method="GET" action="{{ route('admin.materi.index') }}" class="w-full max-w-sm ml-4">
                    <div class="flex items-center space-x-2">
                        <input type="text" name="search" placeholder="Cari Nama atau Deskripsi Materi..." 
                               value="{{ $searchQuery ?? '' }}"
                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm">
                        
                        <x-primary-button type="submit">
                            {{ __('Cari') }}
                        </x-primary-button>
                        
                        @if ($searchQuery)
                            <a href="{{ route('admin.materi.index', ['sort' => $sortColumn, 'direction' => $sortDirection]) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Reset
                            </a>
                        @endif
                        
                        <input type="hidden" name="sort" value="{{ $sortColumn }}">
                        <input type="hidden" name="direction" value="{{ $sortDirection }}">
                    </div>
                </form>
            </div>


            <div class="shadow overflow-hidden border-b border-gray-200 rounded-lg">
                <table class="min-w-full divide-y divide-gray-200 w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            @php
                                $getSortLink = function ($column, $currentSort, $currentDirection, $search) {
                                    $direction = $currentSort === $column && $currentDirection === 'asc' ? 'desc' : 'asc';
                                    return route('admin.materi.index', ['sort' => $column, 'direction' => $direction, 'search' => $search]);
                                };
                                
                                $getArrow = function ($column, $currentSort, $currentDirection) {
                                    if ($currentSort === $column) {
                                        return $currentDirection === 'asc' ? ' &uarr;' : ' &darr;'; 
                                    }
                                    return '';
                                };
                            @endphp

                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-12 cursor-pointer hover:bg-gray-100"
                                onclick="window.location='{{ $getSortLink('id_materi', $sortColumn, $sortDirection, $searchQuery) }}'">
                                ID {!! $getArrow('id_materi', $sortColumn, $sortDirection) !!}
                            </th>
                            
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[200px] cursor-pointer hover:bg-gray-100"
                                onclick="window.location='{{ $getSortLink('nama_materi', $sortColumn, $sortDirection, $searchQuery) }}'">
                                Nama Materi {!! $getArrow('nama_materi', $sortColumn, $sortDirection) !!}
                            </th>
                            
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Deskripsi Singkat
                            </th>

                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-24">
                                Modul
                            </th>
                            
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
                        @forelse ($materis as $materi)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $materi->id_materi }}
                                </td>
                                
                                <td class="px-6 py-4 whitespace-normal text-sm text-gray-800 break-words font-medium">
                                    <a href="{{ route('admin.materi.modul.index', $materi->id_materi) }}" class="text-indigo-600 hover:text-indigo-900 font-bold">
                                        {{ $materi->nama_materi }}
                                    </a>
                                </td>
                                
                                <td class="px-6 py-4 whitespace-normal text-sm text-gray-700 break-words max-w-sm">
                                    {{ \Illuminate\Support\Str::limit($materi->deskripsi, 100, '...') }}
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <a href="{{ route('admin.materi.modul.index', $materi->id_materi) }}" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 hover:bg-blue-200">
                                        {{ $materi->moduls_count }}
                                    </a>
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($materi->created_at)->format('d/m/Y') }}
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                                    <a href="{{ route('admin.materi.edit', $materi->id_materi) }}" class="text-indigo-600 hover:text-indigo-900 font-medium mr-3">
                                        Edit
                                    </a>
                                    
                                    <form action="{{ route('admin.materi.destroy', $materi->id_materi) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus materi: {{ $materi->nama_materi }} dan semua modul/bacaan terkait?');">
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
                                    Tidak ada data materi yang ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $materis->links() }}
            </div>

        </div>
    </div>
</x-app-admin-layout>