<x-app-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Learning Path') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="w-full px-4 sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert"><span class="block sm:inline">{{ session('success') }}</span></div>
            @endif

            <div class="mb-6 flex justify-between items-center">
                <a href="{{ route('admin.learning-path.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Buat Learning Path Baru') }}
                </a>
            </div>

            <div class="shadow overflow-hidden border-b border-gray-200 rounded-lg">
                <table class="min-w-full divide-y divide-gray-200 w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-12">ID</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[200px]">Nama Learning Path</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi Singkat</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Materi</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($learningPaths as $path)
                            <tr class="cursor-pointer hover:bg-gray-50" 
                                onclick="window.location='{{ route('admin.learning-path.show', $path->id) }}'">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $path->id }}
                                </td>
                                
                                <td class="px-6 py-4 whitespace-normal text-sm text-gray-800 break-words font-medium">
                                    {{ $path->nama_path }}
                                </td>
                                
                                <td class="px-6 py-4 whitespace-normal text-sm text-gray-700 break-words max-w-sm">
                                    {{ \Illuminate\Support\Str::limit($path->deskripsi, 100, '...') }}
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        {{ $path->materis_count }} Materi
                                    </span>
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center" onclick="event.stopPropagation()">
                                    <a href="{{ route('admin.learning-path.edit', $path->id) }}" class="text-indigo-600 hover:text-indigo-900 font-medium mr-3">
                                        Edit
                                    </a>
                                    
                                    <form action="{{ route('admin.learning-path.destroy', $path->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus Learning Path: {{ $path->nama_path }}?');">
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
                                <td colspan="5" class="px-6 py-6 text-center text-sm text-gray-500 italic">
                                    Tidak ada data Learning Path yang ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $learningPaths->links() }}
            </div>

        </div>
    </div>
</x-app-admin-layout>