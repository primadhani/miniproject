<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        // Cek role user setelah authenticate
        $user = Auth::user();

        if ($user->role === 'admin') {
            $this->redirectIntended(default: route('admin.dashboard', absolute: false), navigate: true);
        } else {
            $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
        }
    }
}; ?>

<div>
    <h3 class="text-4xl font-display font-bold mb-6 text-gray-900">Masuk</h3>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login" class="auth-form-v3" autocomplete="off">
        <div class="mb-4">
            <input
                wire:model="form.email"
                id="email"
                class="block w-full dcd-default-form font-medium"
                type="email"
                name="login_email"
                placeholder="Email"
                required
                autofocus
                autocomplete="email"
            />
            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
        </div>

        <div class="mb-4">
            <div class="relative">
                <input
                    wire:model="form.password"
                    id="login-password"
                    class="block w-full dcd-default-form font-medium"
                    type="password"
                    name="login_password"
                    placeholder="Password"
                    required
                    autocomplete="current-password"
                />
            </div>

            <div class="flex items-center justify-between mt-3">
                <div class="block">
                    <label for="remember_me" class="inline-flex items-center text-sm">
                        <input wire:model="form.remember" id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember_me">
                        <span class="ms-2 text-sm text-gray-600">Remember me</span>
                    </label>
                </div>

                {{-- @if (Route::has('password.request'))
                    <a class="text-sm font-medium dcd-link" href="{{ route('password.request') }}" wire:navigate>
                        Lupa Password?
                    </a>
                @endif --}}
            </div>

            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
        </div>

<div class="mb-4">
    <button type="submit" 
            class="dcd-btn dcd-btn-primary w-full py-2 font-medium rounded-md font-display" 
            style="background-color: #004eb1; border-color: #004eb1;">
        Masuk
    </button>
</div>

        <div class="text-center mt-3">
            Belum punya akun? Ayo
            <a class="font-medium text-sm" style="color: #004eb1;" href="{{ route('register') }}" wire:navigate>
                daftar
            </a>
        </div>

        <hr class="mt-4 mb-3 border-gray-200">

        {{-- <div class="text-center text-xs text-gray-500">
            <small>
                Dengan melakukan login, Anda setuju dengan <a href="https://www.dicoding.com/termsofuse" class="dcd-link">syarat &amp; ketentuan Dicoding</a>.
            </small>

            <div class="small mt-2">
                This site is protected by reCAPTCHA and the Google
                <a href="https://policies.google.com/privacy" class="dcd-link">Privacy Policy</a> and
                <a href="https://policies.google.com/terms" class="dcd-link">Terms of Service</a> apply.
            </div>
        </div> --}}
    </form>
</div>