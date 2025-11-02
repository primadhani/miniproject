<x-app-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Token Akses Baru') }}
        </h2>
        <div class="text-sm mt-1">
            <a href="{{ route('admin.tokens.index') }}" class="text-indigo-600 hover:text-indigo-900">Token</a>
            / Buat Baru
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <form method="POST" action="{{ route('admin.tokens.store') }}">
                        @csrf

                        <div class="mb-4">
                            <x-input-label for="nama_token" :value="__('Nama Token (Contoh: Promo Lebaran 2025)')" />
                            <x-text-input id="nama_token" name="nama_token" type="text" class="mt-1 block w-full" :value="old('nama_token')" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('nama_token')" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="tanggal_kadaluarsa" :value="__('Tanggal Kadaluarsa (Kosongkan jika tak terbatas)')" />
                            <x-text-input id="tanggal_kadaluarsa" name="tanggal_kadaluarsa" type="date" class="mt-1 block w-full" :value="old('tanggal_kadaluarsa')" />
                            <p class="mt-1 text-sm text-gray-500">Token akan aktif sampai tanggal ini.</p>
                            <x-input-error class="mt-2" :messages="$errors->get('tanggal_kadaluarsa')" />
                        </div>

                        <div class="mb-6">
                            <x-input-label for="jumlah_redeem" :value="__('Jumlah Maksimal Redeem')" />
                            <x-text-input id="jumlah_redeem" name="jumlah_redeem" type="number" class="mt-1 block w-full" :value="old('jumlah_redeem', 0)" min="0" required />
                            <p class="mt-1 text-sm text-gray-500">Masukkan 0 (nol) jika jumlah redeem tidak terbatas (unlimited).</p>
                            <x-input-error class="mt-2" :messages="$errors->get('jumlah_redeem')" />
                        </div>
                        
                        <div class="mb-6">
                            <x-input-label for="learning_path_ids" :value="__('Learning Path yang Dapat Diakses')" />
                            <p class="mb-2 text-sm text-gray-500">Pilih Learning Path yang akan dibuka saat token ini di-redeem.</p>
                            
                            <div class="space-y-2 max-h-60 overflow-y-auto p-4 border rounded-md">
                                @forelse ($learningPaths as $path)
                                    <label class="flex items-center">
                                        <input type="checkbox" name="learning_path_ids[]" value="{{ $path->id }}"
                                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                               @checked(in_array($path->id, old('learning_path_ids', [])))>
                                        <span class="ms-2 text-sm text-gray-700">{{ $path->nama_path }} (ID: {{ $path->id }})</span>
                                    </label>
                                @empty
                                    <p class="text-sm text-red-500">Tidak ada Learning Path ditemukan. Harap buat Learning Path terlebih dahulu.</p>
                                @endforelse
                            </div>
                            
                            <x-input-error class="mt-2" :messages="$errors->get('learning_path_ids')" />
                        </div>

                        <div class="flex items-center justify-end">
                            <a href="{{ route('admin.tokens.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 mr-2">
                                {{ __('Batal') }}
                            </a>
                            <x-primary-button>
                                {{ __('Simpan Token') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-admin-layout>
