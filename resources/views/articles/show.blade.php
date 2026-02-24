<x-layouts::app :title="__($article->title . ' - Narasi')">
    <div class="container mx-auto px-4 py-8">
        <article class="max-w-4xl mx-auto">
            <!-- Breadcrumb -->
            <nav class="mb-6 text-sm">
                <ol class="flex items-center space-x-2">
                    <li><a href="{{ route('home') }}" class="text-blue-600 dark:text-blue-400 hover:underline">Home</a>
                    </li>
                    <li class="text-gray-500 dark:text-gray-400">/</li>
                    @if ($article->category)
                        <li><a href="{{ route('home') }}"
                                class="text-blue-600 dark:text-blue-400 hover:underline">{{ $article->category->name }}</a>
                        </li>
                        <li class="text-gray-500 dark:text-gray-400">/</li>
                    @endif
                    <li class="text-gray-900 dark:text-white truncate">{{ $article->title }}</li>
                </ol>
            </nav>

            <!-- Article Header -->
            <header class="mb-8">
                @if ($article->category)
                    <span
                        class="inline-block bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 text-sm px-3 py-1 rounded-full mb-4">
                        {{ $article->category->name }}
                    </span>
                @endif

                <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    {{ $article->title }}
                </h1>

                @if ($article->excerpt)
                    <p class="text-xl text-gray-600 dark:text-gray-300 mb-4">
                        {{ $article->excerpt }}
                    </p>
                @endif

                <div class="flex items-center text-gray-500 dark:text-gray-400 text-sm">
                    <div class="flex items-center mr-4">
                        <div
                            class="w-10 h-10 rounded-full bg-gray-300 dark:bg-gray-700 flex items-center justify-center mr-2">
                            <span class="text-gray-600 dark:text-gray-300 font-medium">
                                {{ substr($article->user->name, 0, 1) }}
                            </span>
                        </div>
                        <span class="font-medium text-gray-900 dark:text-white">{{ $article->user->name }}</span>
                    </div>
                    <time datetime="{{ $article->published_at->toIso8601String() }}">
                        {{ $article->published_at->format('F d, Y') }}
                    </time>
                </div>
            </header>

            <!-- Article Content -->
            <div class="prose dark:prose-invert max-w-none">
                {!! nl2br(e($article->content)) !!}
            </div>

            <!-- Article Footer -->
            <footer class="mt-12 pt-8 border-t border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <a href="{{ route('home') }}"
                        class="inline-flex items-center text-blue-600 dark:text-blue-400 hover:underline">
                        ← Back to Articles
                    </a>

                    <div class="flex share-buttons space-x-4">
                        <span class="text-gray-500 dark:text-gray-400">Share:</span>
                        <a href="https://twitter.com/intent/tweet?text={{ urlencode($article->title) }}&url={{ urlencode(request()->fullUrl()) }}"
                            target="_blank" class="text-blue-400 hover:text-blue-600">
                            Twitter
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}"
                            target="_blank" class="text-blue-600 hover:text-blue-800">
                            Facebook
                        </a>
                    </div>
                </div>
            </footer>
        </article>
    </div>
</x-layouts::app>
