<x-app-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Token Akses') }}
        </h2>
        <div class="text-sm mt-1">
            Token
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

            {{-- INI ADALAH TOMBOL UNTUK MEMBUAT TOKEN BARU --}}
            <div class="mb-6 flex justify-end">
                <a href="{{ route('admin.tokens.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Buat Token Baru') }}
                </a>
            </div>
            {{-- AKHIR TOMBOL --}}


            <div class="shadow overflow-hidden border-b border-gray-200 rounded-lg">
                <table class="min-w-full divide-y divide-gray-200 w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kode Token
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nama Token
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Akses Learning Path
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kuota (Redeemed/Max)
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kadaluarsa
                            </th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-32">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($tokens as $token)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-extrabold text-red-600">
                                    {{ $token->kode_token }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $token->nama_token }}
                                </td>
                                <td class="px-6 py-4 whitespace-normal text-sm text-gray-700 max-w-xs">
                                    @foreach ($token->learningPaths as $lp)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mr-1 mb-1">
                                            {{ $lp->nama_path }}
                                        </span>
                                    @endforeach
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $token->usersRedeemed()->count() }} / {{ $token->jumlah_redeem > 0 ? $token->jumlah_redeem : '∞' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $token->tanggal_kadaluarsa ? \Carbon\Carbon::parse($token->tanggal_kadaluarsa)->format('d M Y') : 'Tidak Terbatas' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                                    {{-- Anda bisa menambahkan tombol Edit/Hapus di sini jika fungsionalitasnya ditambahkan di TokenController --}}
                                    <a href="#" class="text-indigo-600 hover:text-indigo-900 font-medium opacity-50 cursor-not-allowed">Edit</a>
                                    <form action="#" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus Token ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 font-medium opacity-50 cursor-not-allowed">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-6 text-center text-sm text-gray-500 italic">
                                    Tidak ada token yang ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-admin-layout>
