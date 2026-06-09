<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        @include('partials.head')
        <style>
            .reading-progress-bar {
                height: 3px;
                background: #111827;
                width: 0%;
                position: fixed;
                top: 0;
                left: 0;
                z-index: 100;
                transition: width 0.1s ease;
            }
            body {
                font-family: 'Instrument Sans', sans-serif;
            }
        </style>
    </head>
    <body class="min-h-screen bg-white text-[#111827] antialiased flex flex-col">
        <!-- Reading Progress Bar (visible on detail pages) -->
        <div id="readingProgress" class="reading-progress-bar"></div>

        <!-- Sticky Header (Transparent layout backdrop) -->
        <header class="sticky top-0 z-50 backdrop-blur-lg bg-white/80 border-b border-zinc-100 transition-all duration-300">
            <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16 sm:h-20">
                    <!-- Left: Brand Logo & Categories -->
                    <div class="flex items-center gap-10">
                        <a href="{{ route('home') }}" class="flex items-center gap-2 group" wire:navigate>
                            <span class="text-2xl font-black tracking-tighter text-[#111827] transition duration-200">
                                Narasi
                            </span>
                        </a>

                        @php
                            $navCategories = \App\Models\Category::withCount('publishedArticles')
                                ->orderBy('published_articles_count', 'desc')
                                ->take(5)
                                ->get();
                        @endphp
                        <nav class="hidden lg:flex items-center gap-8 text-xs font-bold uppercase tracking-wider text-zinc-500">
                            @foreach($navCategories as $cat)
                                <a href="{{ route('home') }}?category={{ $cat->slug }}" class="hover:text-[#111827] transition-colors duration-150" wire:navigate>
                                    {{ $cat->name }}
                                </a>
                            @endforeach
                        </nav>
                    </div>

                    <!-- Right: Search & Actions -->
                    <div class="flex items-center gap-6">
                        @guest
                            <div class="flex items-center gap-4">
                                <a href="{{ route('login') }}" class="text-xs font-bold uppercase tracking-wider text-zinc-500 hover:text-[#111827] transition-colors" wire:navigate>
                                    Masuk
                                </a>
                                <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-4 py-2 text-xs font-bold uppercase tracking-wider text-white bg-[#111827] hover:bg-[#374151] rounded-xs transition duration-150" wire:navigate>
                                    Daftar
                                </a>
                            </div>
                        @endguest

                        @auth
                            <div class="flex items-center gap-6">
                                <a href="{{ route('dashboard') }}" class="text-xs font-bold uppercase tracking-wider text-zinc-500 hover:text-[#111827] transition-colors" wire:navigate>
                                    Dashboard
                                </a>
                                <x-desktop-user-menu />
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="flex-grow">
            {{ $slot }}
        </main>

        <!-- Footer Section -->
        <footer class="bg-white text-zinc-500 border-t border-zinc-100 pt-16 pb-8">
            <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
                    <!-- Brand Column -->
                    <div class="space-y-4">
                        <span class="text-xl font-black tracking-tighter text-[#111827]">
                            Narasi
                        </span>
                        <p class="text-xs leading-relaxed text-zinc-400">
                            Platform jurnalisme modern tempat cerita, ide, dan wawasan segar mengalir tanpa batas untuk menginspirasi dunia.
                        </p>
                    </div>

                    <!-- Categories Column -->
                    <div>
                        <h4 class="text-xs font-bold text-[#111827] uppercase tracking-wider mb-4">Kategori Populer</h4>
                        <ul class="space-y-2.5 text-xs">
                            @foreach($navCategories as $cat)
                                <li>
                                    <a href="{{ route('home') }}?category={{ $cat->slug }}" class="hover:text-[#111827] transition" wire:navigate>
                                        {{ $cat->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Quick Links -->
                    <div>
                        <h4 class="text-xs font-bold text-[#111827] uppercase tracking-wider mb-4">Navigasi</h4>
                        <ul class="space-y-2.5 text-xs">
                            <li><a href="{{ route('home') }}" class="hover:text-[#111827] transition" wire:navigate>Beranda</a></li>
                            @guest
                                <li><a href="{{ route('login') }}" class="hover:text-[#111827] transition" wire:navigate>Masuk</a></li>
                                <li><a href="{{ route('register') }}" class="hover:text-[#111827] transition" wire:navigate>Daftar</a></li>
                            @endguest
                            @auth
                                <li><a href="{{ route('dashboard') }}" class="hover:text-[#111827] transition" wire:navigate>Dashboard Penulis</a></li>
                            @endauth
                        </ul>
                    </div>

                    <!-- Newsletter Info -->
                    <div class="space-y-4">
                        <h4 class="text-xs font-bold text-[#111827] uppercase tracking-wider">Newsletter Narasi</h4>
                        <p class="text-xs text-zinc-400">Dapatkan artikel pilihan langsung ke email Anda setiap minggu.</p>
                        <form onsubmit="event.preventDefault(); alert('Terima kasih telah berlangganan!');" class="flex gap-2">
                            <input type="email" placeholder="Alamat email Anda" required class="flex-grow bg-zinc-50 border border-zinc-200/60 rounded-xs px-3 py-2 text-xs focus:outline-hidden text-[#111827] placeholder-zinc-400">
                            <button type="submit" class="bg-[#111827] hover:bg-[#374151] text-white font-bold text-xs px-4 py-2 rounded-xs transition">
                                Ikuti
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Footer Bottom -->
                <div class="border-t border-zinc-100 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-zinc-400">
                    <p>© {{ date('Y') }} Narasi. Hak cipta dilindungi undang-undang.</p>
                    <div class="flex gap-6">
                        <a href="#" class="hover:text-[#111827] transition">Kebijakan Privasi</a>
                        <a href="#" class="hover:text-[#111827] transition">Syarat & Ketentuan</a>
                        <a href="#" class="hover:text-[#111827] transition">Kontak</a>
                    </div>
                </div>
            </div>
        </footer>

        @fluxScripts
        <!-- Reading Progress Script -->
        <script>
            window.addEventListener('scroll', () => {
                const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
                const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
                const scrolled = (winScroll / height) * 100;
                const progressBar = document.getElementById('readingProgress');
                if (progressBar) {
                    progressBar.style.width = scrolled + '%';
                }
            });
        </script>
    </body>
</html>
