<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Event & Redeem Token
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-xl font-bold mb-4">Gunakan Kode Akses Anda</h3>
                <p class="text-gray-600 mb-6">Masukkan 6-huruf kode token yang Anda miliki untuk mendapatkan akses ke Learning Path eksklusif.</p>

                <form action="{{ route('redeem.token') }}" method="POST" class="max-w-md">
                    @csrf
                    <div class="flex items-end space-x-4">
                        <div class="flex-grow">
                            <x-input-label for="kode_token" value="Kode Token" />
                            <x-text-input 
                                id="kode_token" 
                                name="kode_token" 
                                type="text" 
                                class="mt-1 block w-full uppercase text-center text-lg tracking-widest" 
                                placeholder="A1B2C3" 
                                maxlength="6"
                                required 
                                autofocus 
                            />
                            <x-input-error class="mt-2" :messages="$errors->get('kode_token')" />
                        </div>
                        <x-primary-button>
                            Redeem
                        </x-primary-button>
                    </div>
                </form>
            </div>
            
            @if (session('success'))
                <div class="mt-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative shadow-sm">
                    {{ session('success') }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>