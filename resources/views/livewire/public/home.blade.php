<div class="bg-white dark:bg-zinc-950 min-h-screen">
    @php
        // Fetch trending articles (latest published articles)
        $trendingArticles = \App\Models\Article::published()
            ->with(['user', 'category'])
            ->latest('published_at')
            ->take(5)
            ->get();
            
        // Get the first article from the paginated list as the featured article
        $featuredArticle = $articles->first();
        // The rest are the list of latest articles
        $latestArticles = $articles->skip(1);
    @endphp

    <!-- 1. Editorial Hero Section (Full-bleed edge-to-edge layout filling screen) -->
    @if($featuredArticle && $articles->currentPage() === 1 && !$search)
        <section class="relative overflow-hidden bg-zinc-950 text-white h-[calc(100vh-64px)] sm:h-[calc(100vh-80px)] flex items-end mb-16 group w-full">
            <!-- Background Image -->
            <div class="absolute inset-0 z-0">
                @if($featuredArticle->thumbnail)
                    <img src="{{ Str::startsWith($featuredArticle->thumbnail, ['http://', 'https://']) ? $featuredArticle->thumbnail : Storage::url($featuredArticle->thumbnail) }}" 
                         class="w-full h-full object-cover group-hover:scale-101 transition-transform duration-[8s] ease-out opacity-40" 
                         alt="{{ $featuredArticle->title }}">
                @endif
                <!-- Dark Gradient Overlay -->
                <div class="absolute inset-0 bg-gradient-to-t from-zinc-950 via-zinc-950/45 to-transparent"></div>
            </div>

            <!-- Content overlay (keeps aligned with the max-width grid content) -->
            <div class="relative z-10 w-full max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20 space-y-4">
                <a href="{{ route('home') }}?category={{ $featuredArticle->category->slug }}" class="inline-block text-xs font-bold uppercase tracking-widest text-blue-400" wire:navigate>
                    {{ $featuredArticle->category->name }}
                </a>

                <h1 class="text-3xl sm:text-6xl font-black tracking-tighter leading-tight hover:text-blue-300 transition-colors duration-150 max-w-4xl">
                    <a href="{{ route('articles.show', $featuredArticle->slug) }}" wire:navigate>{{ $featuredArticle->title }}</a>
                </h1>

                <p class="text-zinc-300 text-sm sm:text-base leading-relaxed line-clamp-3 font-medium max-w-2xl">
                    {{ $featuredArticle->excerpt ?: Str::limit(strip_tags($featuredArticle->content), 180) }}
                </p>

                <div class="flex items-center gap-2 pt-2 text-xs text-zinc-400 font-bold uppercase tracking-wider">
                    <span>Oleh {{ $featuredArticle->user->name }}</span>
                    <span>•</span>
                    <span>{{ $featuredArticle->published_at ? $featuredArticle->published_at->format('d M Y') : $featuredArticle->created_at->format('d M Y') }}</span>
                    <span>•</span>
                    <span>{{ ceil(str_word_count(strip_tags($featuredArticle->content)) / 200) }} mnt baca</span>
                </div>
            </div>
        </section>
    @endif

    <!-- 2. Centered Content Container for grid, trending list, newsletter -->
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-4">

        <!-- Medium-Style Trending Section -->
        <section class="border-b border-zinc-100 dark:border-zinc-900 pb-10 mb-12">
            <h2 class="text-xs font-bold uppercase tracking-widest text-zinc-400 mb-8 flex items-center gap-2">
                <svg class="w-4 h-4 text-[#111827]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                Terpopuler di Narasi
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8">
                @foreach($trendingArticles as $index => $tArticle)
                    <div class="flex gap-4 items-start group">
                        <span class="text-3xl font-black text-zinc-200 dark:text-zinc-800 tracking-tighter">
                            0{{ $index + 1 }}
                        </span>
                        <div class="space-y-1.5">
                            <div class="flex items-center gap-1.5 text-[10px] text-zinc-400 font-bold uppercase tracking-wider">
                                <span>{{ $tArticle->user->name }}</span>
                            </div>
                            <h4 class="text-sm font-bold text-zinc-900 dark:text-zinc-50 group-hover:text-zinc-655 transition-colors leading-snug line-clamp-3">
                                <a href="{{ route('articles.show', $tArticle->slug) }}" wire:navigate>{{ $tArticle->title }}</a>
                            </h4>
                            <div class="text-[10px] text-zinc-400">
                                <span>{{ $tArticle->published_at ? $tArticle->published_at->format('d M') : $tArticle->created_at->format('d M') }}</span>
                                <span class="mx-1">•</span>
                                <span>{{ ceil(str_word_count(strip_tags($tArticle->content)) / 200) }} mnt baca</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- Category Pill Subheader -->
        <div class="flex items-center gap-2 overflow-x-auto pb-4 mb-8 border-b border-zinc-100 dark:border-zinc-900 scrollbar-none">
            <button wire:click="$set('category', '')" 
                    class="shrink-0 px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider transition-all duration-150 {{ $category === '' ? 'bg-[#111827] text-white dark:bg-white dark:text-zinc-950' : 'bg-zinc-50 text-zinc-500 hover:bg-zinc-100 hover:text-[#111827] dark:bg-zinc-900 dark:text-zinc-400 dark:hover:bg-zinc-850' }}">
                Semua Cerita
            </button>
            @foreach($categories as $cat)
                <button wire:click="$set('category', '{{ $cat->slug }}')" 
                        class="shrink-0 px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider transition-all duration-150 {{ $category === $cat->slug ? 'bg-[#111827] text-white dark:bg-white dark:text-zinc-950' : 'bg-zinc-50 text-zinc-500 hover:bg-zinc-100 hover:text-[#111827] dark:bg-zinc-900 dark:text-zinc-400 dark:hover:bg-zinc-850' }}">
                    {{ $cat->name }}
                </button>
            @endforeach
        </div>

        <!-- Latest Articles (4-column Grid Layout, Borderless/Flat) -->
        <section class="space-y-8">
            <div class="flex items-center justify-between">
                <h2 class="text-xs font-bold uppercase tracking-widest text-zinc-400">Artikel Terbaru</h2>
                <!-- Minimal Search Box -->
                <div class="relative w-full max-w-xs">
                    <input type="text" 
                           wire:model.live.debounce.300ms="search" 
                           placeholder="Cari cerita..." 
                           class="w-full px-3 py-1.5 bg-zinc-50 dark:bg-zinc-900/60 border border-zinc-200/60 dark:border-zinc-800/65 rounded-sm text-xs focus:outline-hidden focus:border-[#111827] transition-all">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @php
                    $displayArticles = ($articles->currentPage() === 1 && !$search && $featuredArticle) ? $latestArticles : $articles;
                @endphp

                @forelse($displayArticles as $article)
                    <article class="group flex flex-col justify-between h-full space-y-4">
                        <div class="space-y-3">
                            <!-- 16:9 Thumbnail -->
                            <div class="relative overflow-hidden rounded-sm bg-zinc-50 dark:bg-zinc-900 aspect-video w-full">
                                <a href="{{ route('articles.show', $article->slug) }}" class="block w-full h-full" wire:navigate>
                                    @if($article->thumbnail)
                                        <img src="{{ Str::startsWith($article->thumbnail, ['http://', 'https://']) ? $article->thumbnail : Storage::url($article->thumbnail) }}" 
                                             class="w-full h-full object-cover group-hover:opacity-90 transition-opacity duration-300" 
                                             alt="{{ $article->title }}">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-zinc-300 dark:text-zinc-700">
                                            <svg class="w-8 h-8 stroke-current" fill="none" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </a>
                            </div>

                            <div class="space-y-1.5">
                                <a href="{{ route('home') }}?category={{ $article->category->slug }}" class="text-[10px] font-bold uppercase tracking-wider text-[#2563EB]" wire:navigate>
                                    {{ $article->category->name }}
                                </a>
                                <h3 class="text-base font-bold text-zinc-900 dark:text-zinc-50 group-hover:text-zinc-600 dark:group-hover:text-zinc-400 transition-colors duration-150 leading-snug line-clamp-2">
                                    <a href="{{ route('articles.show', $article->slug) }}" wire:navigate>{{ $article->title }}</a>
                                </h3>
                                <p class="text-zinc-500 dark:text-zinc-400 text-xs leading-relaxed line-clamp-2">
                                    {{ $article->excerpt ?: Str::limit(strip_tags($article->content), 100) }}
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 text-[10px] text-zinc-400 font-bold uppercase tracking-wider pt-2 border-t border-zinc-50 dark:border-zinc-900">
                            <span>{{ $article->user->name }}</span>
                            <span>•</span>
                            <span>{{ ceil(str_word_count(strip_tags($article->content)) / 200) }} mnt baca</span>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full py-16 text-center text-zinc-550 dark:text-zinc-450 text-sm">
                        Tidak ada artikel ditemukan.
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="pt-6">
                {{ $articles->links() }}
            </div>
        </section>
    </div>

    <!-- Newsletter Subscribe Section -->
    <section class="border-t border-zinc-100 dark:border-zinc-900 bg-zinc-50/50 dark:bg-zinc-950 py-16 mt-20">
        <div class="max-w-xl mx-auto px-6 text-center space-y-4">
            <h2 class="text-2xl font-black tracking-tight text-zinc-900 dark:text-zinc-50">Ikuti Narasi Setiap Minggu</h2>
            <p class="text-zinc-500 text-xs leading-relaxed">
                Kami merangkum pemikiran terbaik dan opini orisinal langsung ke inbox email Anda setiap hari Jumat. Tanpa spam, batalkan kapan saja.
            </p>
            <form onsubmit="event.preventDefault(); alert('Terima kasih telah berlangganan!');" class="flex gap-2 pt-2">
                <input type="email" placeholder="Alamat email Anda" required class="flex-grow bg-white dark:bg-zinc-900 border border-zinc-200/60 dark:border-zinc-800/60 rounded-xs px-3 py-2 text-xs focus:outline-hidden text-[#111827] placeholder-zinc-400">
                <button type="submit" class="bg-[#111827] hover:bg-[#374151] text-white font-bold text-xs px-4 py-2 rounded-xs transition">
                    Ikuti
                </button>
            </form>
        </div>
    </section>
</div>
