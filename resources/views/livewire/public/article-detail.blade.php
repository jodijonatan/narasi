<div class="bg-white dark:bg-zinc-950 min-h-screen py-10 dark:text-zinc-100">
    @php
        // Share links setup
        $currentUrl = urlencode(request()->url());
        $shareTitle = urlencode($article->title);

        // Fetch related articles (same category, excluding this one)
        $relatedArticles = \App\Models\Article::published()
            ->with(['user', 'category'])
            ->where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        // Fetch trending articles for sidebar
        $trendingArticles = \App\Models\Article::published()
            ->with(['user', 'category'])
            ->latest('published_at')
            ->take(5)
            ->get();

        // Fetch categories for sidebar
        $popularCategories = \App\Models\Category::withCount('publishedArticles')
            ->orderBy('published_articles_count', 'desc')
            ->take(5)
            ->get();
            
        $readTime = ceil(str_word_count(strip_tags($article->content)) / 200);
    @endphp

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Back Link Navigation -->
        <div class="mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-zinc-500 hover:text-blue-600 dark:text-zinc-400 dark:hover:text-blue-400 font-semibold text-sm transition-colors duration-200" wire:navigate>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Beranda
            </a>
        </div>

        <!-- Header Editorial Section -->
        <header class="max-w-3xl mx-auto text-center mb-12">
            <span class="inline-block bg-blue-50 dark:bg-blue-950/40 text-blue-600 dark:text-blue-400 text-xs font-bold px-4 py-1.5 rounded-full uppercase tracking-wider mb-6">
                {{ $article->category->name }}
            </span>
            <h1 class="text-3xl sm:text-5xl font-black text-zinc-900 dark:text-zinc-50 leading-tight tracking-tight mb-8">
                {{ $article->title }}
            </h1>
            
            <!-- Author Card Info & Date -->
            <div class="flex items-center justify-center gap-4 border-y border-zinc-200/50 dark:border-zinc-800/50 py-4 text-sm text-zinc-500 dark:text-zinc-400">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-full bg-linear-to-tr from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold text-xs shadow-md">
                        {{ substr($article->user->name, 0, 1) }}
                    </div>
                    <span>Oleh <strong class="text-zinc-850 dark:text-zinc-100 font-bold">{{ $article->user->name }}</strong></span>
                </div>
                <span class="text-zinc-300 dark:text-zinc-800">•</span>
                <span>{{ $article->published_at ? $article->published_at->format('d M Y') : $article->created_at->format('d M Y') }}</span>
                <span class="text-zinc-300 dark:text-zinc-800">•</span>
                <span class="bg-zinc-100 dark:bg-zinc-900 px-2 py-0.5 rounded-md text-xs font-medium">{{ $readTime }} mnt baca</span>
            </div>
        </header>

        <!-- Featured Banner Image -->
        @if($article->thumbnail)
            <div class="max-w-5xl mx-auto rounded-3xl overflow-hidden bg-zinc-100 dark:bg-zinc-900 aspect-video mb-16 border border-zinc-200/40 dark:border-zinc-800/40 shadow-xs">
                <img src="{{ Str::startsWith($article->thumbnail, ['http://', 'https://']) ? $article->thumbnail : Storage::url($article->thumbnail) }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
            </div>
        @endif

        <!-- Main Body Grid: Content & Sidebar -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-start">
            
            <!-- Floating Social Share Box (Hidden on Mobile) -->
            <div class="hidden lg:block lg:col-span-1 sticky top-36">
                <div class="flex flex-col items-center gap-4 text-zinc-400">
                    <span class="text-[10px] uppercase font-bold tracking-wider text-zinc-500">Bagikan</span>
                    <!-- Facebook -->
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ $currentUrl }}" target="_blank" class="w-10 h-10 rounded-full bg-white dark:bg-zinc-900 border border-zinc-200/60 dark:border-zinc-800/60 flex items-center justify-center hover:text-blue-600 hover:border-blue-600 transition" title="Facebook">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    <!-- Twitter / X -->
                    <a href="https://twitter.com/intent/tweet?url={{ $currentUrl }}&text={{ $shareTitle }}" target="_blank" class="w-10 h-10 rounded-full bg-white dark:bg-zinc-900 border border-zinc-200/60 dark:border-zinc-800/60 flex items-center justify-center hover:text-black dark:hover:text-white hover:border-black transition" title="Twitter / X">
                        <svg class="w-4.5 h-4.5 fill-current" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    </a>
                    <!-- WhatsApp -->
                    <a href="https://api.whatsapp.com/send?text={{ $shareTitle }}%20{{ $currentUrl }}" target="_blank" class="w-10 h-10 rounded-full bg-white dark:bg-zinc-900 border border-zinc-200/60 dark:border-zinc-800/60 flex items-center justify-center hover:text-emerald-500 hover:border-emerald-500 transition" title="WhatsApp">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M17.472 14.382c-.022-.015-.072-.04-.142-.075-.07-.035-.417-.206-.48-.228-.065-.022-.113-.033-.162.04-.047.07-.184.23-.226.276-.04.047-.08.052-.15.018-.07-.035-.3-.11-.57-.35-.213-.19-.358-.425-.4-.495-.04-.07-.003-.105.032-.14.03-.03.07-.08.105-.12.035-.04.047-.07.07-.114.023-.047.012-.087-.005-.122-.017-.035-.162-.39-.222-.534-.059-.142-.117-.122-.162-.124-.04-.002-.09-.002-.138-.002-.047 0-.127.018-.193.088-.066.07-.254.248-.254.606 0 .358.261.704.297.752.036.048.512.783 1.242 1.1 1.737.754 1.737.5 2.052.47.315-.03.682-.279.778-.548.096-.27.096-.5-.008-.548zm-4.79-11.75C6.732 2.632 2 7.37 2 13.23c0 1.87.48 3.7 1.4 5.3L2 22l3.6-1.12c1.53.84 3.27 1.28 5 1.28 5.93 0 10.74-4.8 10.74-10.73 0-2.87-1.12-5.57-3.15-7.6-2.03-2.03-4.73-3.15-7.6-3.15z"/></svg>
                    </a>
                </div>
            </div>

            <!-- Left: Main Article Content (Col 7) -->
            <main class="lg:col-span-7">
                <article class="prose prose-zinc dark:prose-invert max-w-none">
                    <div class="font-serif text-lg sm:text-xl text-zinc-800 dark:text-zinc-200 leading-relaxed space-y-8">
                        {!! nl2br(e($article->content)) !!}
                    </div>
                </article>

                <!-- Bottom Bio Card -->
                <div class="mt-16 pt-8 border-t border-zinc-200/50 dark:border-zinc-800/50">
                    <div class="flex items-center gap-4 bg-zinc-50 dark:bg-zinc-900/40 p-6 sm:p-8 rounded-3xl">
                        <div class="w-14 h-14 rounded-full bg-linear-to-tr from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold text-xl shadow-md">
                            {{ substr($article->user->name, 0, 1) }}
                        </div>
                        <div>
                            <h4 class="font-bold text-zinc-900 dark:text-zinc-50 text-base sm:text-lg">{{ $article->user->name }}</h4>
                            <p class="text-zinc-500 dark:text-zinc-400 text-xs sm:text-sm mt-0.5">Penulis Terverifikasi di Narasi. Membagikan cerita menarik dan pemikiran mendalam untuk Anda.</p>
                        </div>
                    </div>
                </div>
            </main>

            <!-- Right: Sidebar Widget (Col 4) -->
            <aside class="lg:col-span-4 space-y-12 lg:sticky lg:top-36">
                <!-- Popular Categories -->
                <div class="bg-zinc-50 dark:bg-zinc-900/40 p-6 rounded-3xl">
                    <h3 class="text-sm font-bold uppercase tracking-wider text-zinc-400 mb-4">Kategori Populer</h3>
                    <ul class="space-y-2.5">
                        @foreach($popularCategories as $cat)
                            <li>
                                <a href="{{ route('home') }}?category={{ $cat->slug }}" class="flex items-center justify-between text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:text-blue-650 transition" wire:navigate>
                                    <span>{{ $cat->name }}</span>
                                    <span class="text-xs text-zinc-400 bg-zinc-150 dark:bg-zinc-850 px-2 py-0.5 rounded-full">{{ $cat->published_articles_count }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Trending Posts -->
                <div>
                    <h3 class="text-sm font-bold uppercase tracking-wider text-zinc-400 mb-6">Artikel Populer</h3>
                    <div class="space-y-6">
                        @foreach($trendingArticles as $index => $tArticle)
                            <div class="flex gap-4 items-start group">
                                <span class="text-2xl font-black text-zinc-200 dark:text-zinc-800 group-hover:text-blue-600 transition-colors">
                                    0{{ $index + 1 }}
                                </span>
                                <div class="space-y-0.5">
                                    <h4 class="text-xs sm:text-sm font-bold text-zinc-900 dark:text-zinc-50 group-hover:text-blue-600 transition-colors leading-snug">
                                        <a href="{{ route('articles.show', $tArticle->slug) }}" wire:navigate>{{ $tArticle->title }}</a>
                                    </h4>
                                    <div class="flex items-center gap-2 text-[10px] text-zinc-450">
                                        <span class="font-semibold text-zinc-700 dark:text-zinc-300">{{ $tArticle->user->name }}</span>
                                        <span>•</span>
                                        <span>{{ ceil(str_word_count(strip_tags($tArticle->content)) / 200) }} mnt</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </aside>
        </div>

        <!-- 3. Bottom Related Articles Grid -->
        @if($relatedArticles->isNotEmpty())
            <section class="mt-24 pt-12 border-t border-zinc-200/60 dark:border-zinc-800/60">
                <h3 class="text-xl sm:text-2xl font-black text-zinc-900 dark:text-zinc-50 mb-8">Artikel Terkait</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($relatedArticles as $rArticle)
                        <article class="group bg-white dark:bg-zinc-900 border border-zinc-200/50 dark:border-zinc-800/50 rounded-2xl overflow-hidden shadow-xs hover:shadow-md transition duration-300 flex flex-col h-full">
                            <a href="{{ route('articles.show', $rArticle->slug) }}" class="block relative aspect-video overflow-hidden bg-zinc-100 dark:bg-zinc-850" wire:navigate>
                                @if($rArticle->thumbnail)
                                    <img src="{{ Str::startsWith($rArticle->thumbnail, ['http://', 'https://']) ? $rArticle->thumbnail : Storage::url($rArticle->thumbnail) }}" 
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" 
                                         alt="{{ $rArticle->title }}">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-zinc-350">
                                        <svg class="w-10 h-10 stroke-current" fill="none" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </a>

                            <div class="p-5 flex-grow flex flex-col justify-between">
                                <div class="space-y-2">
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-blue-650 dark:text-blue-400">
                                        {{ $rArticle->category->name }}
                                    </span>
                                    <h4 class="font-bold text-zinc-900 dark:text-zinc-50 group-hover:text-blue-650 transition-colors leading-snug line-clamp-2">
                                        <a href="{{ route('articles.show', $rArticle->slug) }}" wire:navigate>{{ $rArticle->title }}</a>
                                    </h4>
                                </div>
                                <div class="flex items-center gap-2 mt-4 text-[10px] text-zinc-500">
                                    <span>Oleh {{ $rArticle->user->name }}</span>
                                    <span>•</span>
                                    <span>{{ ceil(str_word_count(strip_tags($rArticle->content)) / 200) }} mnt</span>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif
    </div>
</div>
