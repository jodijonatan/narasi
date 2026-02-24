<x-layouts::app :title="__('Articles - Narasi')">
    <div class="container mx-auto px-4 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Latest Articles</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Read the latest stories and insights from our authors.</p>
        </div>

        @if ($articles->isEmpty())
            <div class="text-center py-12">
                <p class="text-gray-500 dark:text-gray-400">No articles available yet.</p>
            </div>
        @else
            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($articles as $article)
                    <article
                        class="bg-white dark:bg-zinc-900 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                        @if ($article->category)
                            <div class="px-4 pt-4">
                                <span
                                    class="inline-block bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 text-xs px-2 py-1 rounded-full">
                                    {{ $article->category->name }}
                                </span>
                            </div>
                        @endif

                        <div class="p-4">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                                <a href="{{ route('articles.show', $article->slug) }}"
                                    class="hover:text-blue-600 dark:hover:text-blue-400">
                                    {{ $article->title }}
                                </a>
                            </h2>

                            @if ($article->excerpt)
                                <p class="text-gray-600 dark:text-gray-300 mb-4 line-clamp-3">
                                    {{ $article->excerpt }}
                                </p>
                            @endif

                            <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400">
                                <div class="flex items-center">
                                    <span class="font-medium">{{ $article->user->name }}</span>
                                </div>
                                <time datetime="{{ $article->published_at->toIso8601String() }}">
                                    {{ $article->published_at->format('M d, Y') }}
                                </time>
                            </div>
                        </div>

                        <div class="px-4 pb-4">
                            <a href="{{ route('articles.show', $article->slug) }}"
                                class="inline-block text-blue-600 dark:text-blue-400 hover:underline">
                                Read more →
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $articles->links() }}
            </div>
        @endif
    </div>
</x-layouts::app>
