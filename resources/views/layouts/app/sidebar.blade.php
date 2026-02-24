<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky collapsible="mobile" class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.header>
                <x-app-logo :sidebar="true" href="{{ auth()->check() ? route('dashboard') : route('home') }}" wire:navigate />
                <flux:sidebar.collapse class="lg:hidden" />
            </flux:sidebar.header>

            <flux:sidebar.nav>
                <flux:sidebar.group :heading="__('Utama')" class="grid">
                    <flux:sidebar.item icon="home" :href="route('home')" :current="request()->routeIs('home')" wire:navigate>
                        {{ __('Beranda') }}
                    </flux:sidebar.item>
                    
                    @auth
                        <flux:sidebar.item icon="squares-2x2" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                            {{ __('Dashboard') }}
                        </flux:sidebar.item>
                    @endauth
                </flux:sidebar.group>

                @auth
                    {{-- Admin Section --}}
                    @if(auth()->user()->isAdmin())
                        <flux:sidebar.group :heading="__('Manajemen Admin')" class="grid">
                            <flux:sidebar.item icon="check-circle" :href="route('admin.verify')" :current="request()->routeIs('admin.verify')" wire:navigate>
                                {{ __('Verifikasi Artikel') }}
                            </flux:sidebar.item>
                            <flux:sidebar.item icon="tag" :href="route('admin.categories.index')" :current="request()->routeIs('admin.categories.index')" wire:navigate>
                                {{ __('Kelola Kategori') }}
                            </flux:sidebar.item>
                            <flux:sidebar.item icon="users" :href="route('admin.users.index')" :current="request()->routeIs('admin.users.index')" wire:navigate>
                                {{ __('Kelola Pengguna') }}
                            </flux:sidebar.item>
                        </flux:sidebar.group>
                    @endif

                    {{-- Writer Section --}}
                    <flux:sidebar.group :heading="__('Konten Penulis')" class="grid">
                        <flux:sidebar.item icon="book-open" :href="route('writer.articles')" :current="request()->routeIs('writer.articles')" wire:navigate>
                            {{ __('Artikel Saya') }}
                        </flux:sidebar.item>
                    </flux:sidebar.group>
                @endauth
            </flux:sidebar.nav>

            <flux:spacer />

            {{-- Guest/Auth Footer --}}
            @guest
                <flux:sidebar.nav>
                    <flux:sidebar.item icon="arrow-right-end-on-rectangle" :href="route('login')" wire:navigate>
                        {{ __('Masuk') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="user-plus" :href="route('register')" wire:navigate>
                        {{ __('Daftar') }}
                    </flux:sidebar.item>
                </flux:sidebar.nav>
            @endguest

            @auth
                <x-desktop-user-menu class="hidden lg:block" :name="auth()->user()->name" />
            @endauth
        </flux:sidebar>


        {{-- Mobile Header --}}
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            @auth
                <flux:dropdown position="top" align="end">
                    <flux:profile
                        :initials="auth()->user()->initials()"
                        icon-trailing="chevron-down"
                    />

                    <flux:menu>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <flux:avatar
                                    :name="auth()->user()->name"
                                    :initials="auth()->user()->initials()"
                                />

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <flux:heading class="truncate">{{ auth()->user()->name }}</flux:heading>
                                    <flux:text class="truncate">{{ auth()->user()->email }}</flux:text>
                                </div>
                            </div>
                        </div>

                        <flux:menu.separator />

                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                            {{ __('Settings') }}
                        </flux:menu.item>

                        <flux:menu.separator />

                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <flux:menu.item
                                as="button"
                                type="submit"
                                icon="arrow-right-start-on-rectangle"
                                class="w-full cursor-pointer"
                            >
                                {{ __('Log Out') }}
                            </flux:menu.item>
                        </form>
                    </flux:menu>
                </flux:dropdown>
            @endauth

            @guest
                <flux:button :href="route('login')" variant="ghost" size="sm" wire:navigate>{{ __('Masuk') }}</flux:button>
            @endguest
        </flux:header>

        {{-- Main Content --}}
        {{ $slot }}

        @fluxScripts
    </body>
</html>