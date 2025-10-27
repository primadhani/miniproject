<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('admin.dashboard') }}" wire:navigate class="flex items-center">
                        <span class="ml-2 text-sm font-semibold text-gray-700">Admin Panel</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <!-- Dashboard Link -->
                    <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" wire:navigate>
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    <!-- Users Management Link -->
                    <x-nav-link :href="route('admin.users')" :active="request()->routeIs('admin.users*')" wire:navigate>
                        {{ __('Users') }}
                    </x-nav-link>

                    <!-- Academy Management Link -->
                    <x-nav-link :href="route('admin.academy')" :active="request()->routeIs('admin.academy*')" wire:navigate>
                        {{ __('Academy') }}
                    </x-nav-link>

                    <!-- Challenge Management Link -->
                    <x-nav-link :href="route('admin.challenge')" :active="request()->routeIs('admin.challenge*')" wire:navigate>
                        {{ __('Challenge') }}
                    </x-nav-link>

                    <!-- Event Management Link -->
                    <x-nav-link :href="route('admin.event')" :active="request()->routeIs('admin.event*')" wire:navigate>
                        {{ __('Event') }}
                    </x-nav-link>

                    <!-- Job Management Link -->
                    <x-nav-link :href="route('admin.job')" :active="request()->routeIs('admin.job*')" wire:navigate>
                        {{ __('Job') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center text-sm border-transparent rounded-full focus:outline-none transition duration-150 ease-in-out">
                            <img class="h-6 w-6 rounded-full object-cover" src="{{ asset('user.png') }}" alt="Admin Icon" />
                            <span class="ml-2 text-xs text-gray-600 hidden lg:block">Admin</span>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile')" wire:navigate>
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <div class="border-t border-gray-100"></div>

                        <!-- Authentication -->
                        <button wire:click="logout" class="w-full text-start">
                            <x-dropdown-link>
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </button>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <!-- Dashboard Link -->
            <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" wire:navigate>
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            
            <!-- Users Link -->
            <x-responsive-nav-link :href="route('admin.users')" :active="request()->routeIs('admin.users*')" wire:navigate>
                {{ __('Users') }}
            </x-responsive-nav-link>

            <!-- Academy Link -->
            <x-responsive-nav-link :href="route('admin.academy')" :active="request()->routeIs('admin.academy*')" wire:navigate>
                {{ __('Academy') }}
            </x-responsive-nav-link>

            <!-- Challenge Link -->
            <x-responsive-nav-link :href="route('admin.challenge')" :active="request()->routeIs('admin.challenge*')" wire:navigate>
                {{ __('Challenge') }}
            </x-responsive-nav-link>

            <!-- Event Link -->
            <x-responsive-nav-link :href="route('admin.event')" :active="request()->routeIs('admin.event*')" wire:navigate>
                {{ __('Event') }}
            </x-responsive-nav-link>

            <!-- Job Link -->
            <x-responsive-nav-link :href="route('admin.job')" :active="request()->routeIs('admin.job*')" wire:navigate>
                {{ __('Job') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800" x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>
                <div class="font-medium text-sm text-gray-500">{{ auth()->user()->email }}</div>
                <div class="text-xs text-blue-600 mt-1">Administrator</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile')" wire:navigate>
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <button wire:click="logout" class="w-full text-start">
                    <x-responsive-nav-link>
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </button>
            </div>
        </div>
    </div>
</nav>