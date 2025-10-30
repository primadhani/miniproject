<x-app-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Learning Path: ') . $learningPath->nama_path }}
        </h2>
        <div class="text-sm mt-1">
            <a href="{{ route('admin.learning-path.index') }}" class="text-indigo-600 hover:text-indigo-900">Learning Path</a>
            / Edit
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <form method="POST" action="{{ route('admin.learning-path.update', $learningPath->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <x-input-label for="nama_path" :value="__('Nama Learning Path')" />
                            <x-text-input id="nama_path" name="nama_path" type="text" class="mt-1 block w-full" :value="old('nama_path', $learningPath->nama_path)" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('nama_path')" />
                        </div>

                        <div class="mb-6">
                            <x-input-label for="deskripsi" :value="__('Deskripsi')" />
                            <textarea id="deskripsi" name="deskripsi" rows="4" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">{{ old('deskripsi', $learningPath->deskripsi) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('deskripsi')" />
                        </div>

                        <div class="flex items-center justify-end">
                            <a href="{{ route('admin.learning-path.show', $learningPath->id) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 mr-2">
                                {{ __('Batal') }}
                            </a>
                            <x-primary-button>
                                {{ __('Update Learning Path') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-admin-layout>