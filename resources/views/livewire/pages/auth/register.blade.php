<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <h3 class="text-lg font-display font-bold mb-6 text-gray-900">Daftar</h3>

    <form wire:submit="register" class="auth-form-v3" autocomplete="off">

        <div class="mb-3">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
            <input
                wire:model="name"
                id="name"
                class="block w-full dcd-default-form font-medium text-sm"
                type="text"
                name="name"
                placeholder="Nama Lengkap"
                required
                autofocus
                autocomplete="name"
            />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
            <small class="form-text text-gray-500 text-xs mt-1">Masukkan nama asli Anda, nama akan digunakan pada data sertifikat</small>
        </div>

        <div class="mb-3">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input
                wire:model="email"
                id="email"
                class="block w-full dcd-default-form font-medium text-sm"
                type="email"
                name="email"
                placeholder="Alamat Email"
                required
                autocomplete="username"
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
            <small class="form-text text-gray-500 text-xs mt-1">Gunakan alamat email aktif Anda</small>
        </div>

        <div class="mb-3">
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <div class="relative">
                <input
                    wire:model="password"
                    id="password"
                    class="block w-full dcd-default-form font-medium text-sm"
                    type="password"
                    name="password"
                    placeholder="Masukkan password baru"
                    required
                    autocomplete="new-password"
                />
            </div>
            <small class="form-text text-gray-500 text-xs mt-1">Gunakan minimal 8 karakter dengan kombinasi huruf dan angka</small>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
            <div class="relative">
                <input
                    wire:model="password_confirmation"
                    id="password_confirmation"
                    class="block w-full dcd-default-form font-medium text-sm"
                    type="password"
                    name="password_confirmation"
                    placeholder="Konfirmasi password baru"
                    required
                    autocomplete="new-password"
                />
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="mb-3">
            <button type="submit" class="dcd-btn dcd-btn-primary w-full py-2 font-medium rounded-md font-display text-sm">
                Daftar
            </button>
        </div>

        <div class="text-center mt-3">
            <span class="text-sm">Sudah punya akun?</span>
            <a class="dcd-link font-medium text-sm" href="{{ route('login') }}" wire:navigate>
                Masuk sekarang
            </a>
        </div>

        <hr class="mt-4 mb-3 border-gray-200">

        <div class="text-center text-xs text-gray-500">
            <small>
                Dengan melakukan pendaftaran, Anda setuju dengan <a href="https://www.dicoding.com/termsofuse" class="dcd-link">syarat &amp; ketentuan Dicoding</a>.
            </small>

            <div class="mt-2">
                This site is protected by reCAPTCHA and the Google
                <a href="https://policies.google.com/privacy" class="dcd-link">Privacy Policy</a> and
                <a href="https://policies.google.com/terms" class="dcd-link">Terms of Service</a> apply.
            </div>
        </div>
    </form>
</div>