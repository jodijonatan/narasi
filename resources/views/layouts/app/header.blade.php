<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:header container class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden mr-2" icon="bars-2" inset="left" />

            <x-app-logo href="{{ route('home') }}" wire:navigate />

            <flux:navbar class="-mb-px max-lg:hidden">
                <flux:navbar.item icon="home" :href="route('home')" :current="request()->routeIs('home')" wire:navigate>
                    {{ __('Beranda') }}
                </flux:navbar.item>
                @auth
                    <flux:navbar.item icon="layout-grid" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                        {{ __('Dashboard') }}
                    </flux:navbar.item>
                @endauth
            </flux:navbar>

            <flux:spacer />

            <flux:navbar class="me-1.5 space-x-0.5 rtl:space-x-reverse py-0!">
                @guest
                    <flux:navbar.item icon="log-in" :href="route('login')" wire:navigate>{{ __('Masuk') }}</flux:navbar.item>
                    <flux:navbar.item icon="user-plus" :href="route('register')" wire:navigate>{{ __('Daftar') }}</flux:navbar.item>
                @endguest
            </flux:navbar>

            @auth
                <x-desktop-user-menu />
            @endauth
        </flux:header>

        <!-- Mobile Sidebar Fallback -->
        <flux:sidebar collapsible="mobile" sticky class="lg:hidden border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.header>
                <x-app-logo :sidebar="true" href="{{ route('home') }}" wire:navigate />
                <flux:sidebar.collapse class="in-data-flux-sidebar-on-desktop:not-in-data-flux-sidebar-collapsed-desktop:-mr-2" />
            </flux:sidebar.header>

            <flux:sidebar.nav>
                <flux:sidebar.group :heading="__('Platform')">
                    <flux:sidebar.item icon="home" :href="route('home')" :current="request()->routeIs('home')" wire:navigate>
                        {{ __('Beranda')  }}
                    </flux:sidebar.item>
                    @auth
                        <flux:sidebar.item icon="layout-grid" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                            {{ __('Dashboard')  }}
                        </flux:sidebar.item>
                    @endauth
                </flux:sidebar.group>

                @auth
                    @if(auth()->user()->isAdmin())
                        <flux:sidebar.group :heading="__('Admin')">
                            <flux:sidebar.item icon="check-circle" :href="route('admin.verify')" wire:navigate>{{ __('Verifikasi') }}</flux:sidebar.item>
                            <flux:sidebar.item icon="tag" :href="route('admin.categories.index')" wire:navigate>{{ __('Kategori') }}</flux:sidebar.item>
                            <flux:sidebar.item icon="users" :href="route('admin.users.index')" wire:navigate>{{ __('Pengguna') }}</flux:sidebar.item>
                        </flux:sidebar.group>
                    @endif

                    <flux:sidebar.group :heading="__('Penulis')">
                        <flux:sidebar.item icon="book-open" :href="route('writer.articles')" wire:navigate>{{ __('Artikel Saya') }}</flux:sidebar.item>
                    </flux:sidebar.group>
                @endauth
            </flux:sidebar.nav>
        </flux:sidebar>

        {{ $slot }}

        @fluxScripts
    </body>
</html>
