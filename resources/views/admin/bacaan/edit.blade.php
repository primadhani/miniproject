<x-app-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Edit Bacaan: ') . $bacaan->judul_bacaan }}</h2>
        <div class="text-sm mt-1">
            <a href="{{ route('admin.materi.index') }}" class="text-indigo-600 hover:text-indigo-900">{{ __('Manajemen Materi') }}</a>
            / <a href="{{ route('admin.materi.modul.index', $modul->materi->id_materi) }}" class="text-indigo-600 hover:text-indigo-900">Modul {{ $modul->materi->nama_materi }}</a>
            / <a href="{{ route('admin.modul.bacaan.index', $modul->id_modul) }}" class="text-indigo-600 hover:text-indigo-900">Bacaan</a> / Edit
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('admin.modul.bacaan.update', [$modul->id_modul, $bacaan->id_bacaan]) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <x-input-label for="judul_bacaan" :value="__('Judul Bacaan')" />
                            <x-text-input id="judul_bacaan" name="judul_bacaan" type="text" class="mt-1 block w-full" :value="old('judul_bacaan', $bacaan->judul_bacaan)" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('judul_bacaan')" />
                        </div>
                        <div class="mb-6">
                            <x-input-label for="isi_bacaan" :value="__('Isi Bacaan (Gunakan tag HTML jika perlu)')" />
                            <textarea id="isi_bacaan" name="isi_bacaan" rows="10" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">{{ old('isi_bacaan', $bacaan->isi_bacaan) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('isi_bacaan')" />
                        </div>
                        <div class="mb-6">
                            <x-input-label for="urutan" :value="__('Urutan Bacaan')" />
                            <x-text-input id="urutan" name="urutan" type="number" class="mt-1 block w-full" :value="old('urutan', $bacaan->urutan)" min="1" required />
                            <p class="mt-1 text-sm text-gray-500">Angka urutan menentukan posisi bacaan ini di dalam modul.</p>
                            <x-input-error class="mt-2" :messages="$errors->get('urutan')" />
                        </div>
                        <div class="flex items-center justify-end">
                            <a href="{{ route('admin.modul.bacaan.index', $modul->id_modul) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 mr-2">{{ __('Batal') }}</a>
                            <x-primary-button>{{ __('Update Bacaan') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-admin-layout>