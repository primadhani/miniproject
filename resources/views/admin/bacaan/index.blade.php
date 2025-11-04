<x-app-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Bacaan untuk Modul: ') . $modul->nama_modul }}
        </h2>
        <div class="text-sm mt-1">
            <a href="{{ route('admin.materi.index') }}" class="text-indigo-600 hover:text-indigo-900">{{ __('Manajemen Materi') }}</a>
            / <a href="{{ route('admin.materi.modul.index', $modul->materi->id_materi) }}" class="text-indigo-600 hover:text-indigo-900">{{ $modul->materi->nama_materi }}</a>
            / Bacaan
        </div>
    </x-slot>

    <div class="py-6">
        <div class="w-full px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert"><span class="block sm:inline">{{ session('success') }}</span></div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert"><span class="block sm:inline">{{ session('error') }}</span></div>
            @endif

            <div class="mb-6 flex justify-between items-center">
                <a href="{{ route('admin.modul.bacaan.create', $modul->id_modul) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Tambah Bacaan Baru') }}
                </a>
            </div>

            <div class="shadow overflow-hidden border-b border-gray-200 rounded-lg">
                <table class="min-w-full divide-y divide-gray-200 w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-16">Urutan</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul Bacaan</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Isi Singkat</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($bacaans as $bacaan)
                            <tr class="cursor-pointer hover:bg-gray-50" 
                                onclick="window.location='{{ route('admin.modul.bacaan.edit', [$modul->id_modul, $bacaan->id_bacaan]) }}'">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-center">{{ $bacaan->urutan }}</td>
                                <td class="px-6 py-4 whitespace-normal text-sm text-gray-800 break-words font-medium">{{ $bacaan->judul_bacaan }}</td>
                                <td class="px-6 py-4 whitespace-normal text-sm text-gray-700 break-words max-w-lg">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($bacaan->isi_bacaan), 100, '...') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center" onclick="event.stopPropagation()">
                                    <a href="{{ route('admin.modul.bacaan.edit', [$modul->id_modul, $bacaan->id_bacaan]) }}" class="text-indigo-600 hover:text-indigo-900 font-medium mr-2">Edit</a>
                                    <form action="{{ route('admin.modul.bacaan.destroy', [$modul->id_modul, $bacaan->id_bacaan]) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus Bacaan: {{ $bacaan->judul_bacaan }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 font-medium">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-6 py-6 text-center text-sm text-gray-500 italic">Tidak ada bacaan yang ditemukan untuk modul ini.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $bacaans->links() }}</div>
        </div>
    </div>
</x-app-admin-layout>