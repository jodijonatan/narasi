<x-layouts::app :title="__('Manage Articles - Narasi Admin')">
    <div class="container mx-auto px-4 py-8">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Manage Articles</h1>
            <a href="{{ route('admin.articles.create') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                + New Article
            </a>
        </div>

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 p-4 bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white dark:bg-zinc-900 rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-zinc-800">
                    <tr>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Title</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Category</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Author</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Status</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Date</th>
                        <th
                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-zinc-900 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($articles as $article)
                        <tr>
                            <td class="px-6 py-4">
                                <a href="{{ route('articles.show', $article->slug) }}" target="_blank"
                                    class="text-blue-600 dark:text-blue-400 hover:underline font-medium">
                                    {{ $article->title }}
                                </a>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-gray-900 dark:text-gray-300">
                                    {{ $article->category->name ?? 'Uncategorized' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-gray-900 dark:text-gray-300">
                                    {{ $article->user->name }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if ($article->status === 'published')
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                        Published
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">
                                        Draft
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                                {{ $article->published_at ? $article->published_at->format('M d, Y') : $article->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end space-x-2">
                                    @if ($article->status === 'draft')
                                        <form action="{{ route('admin.articles.publish', $article->id) }}"
                                            method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300 text-sm">
                                                Publish
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.articles.draft', $article->id) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300 text-sm">
                                                Unpublish
                                            </button>
                                        </form>
                                    @endif

                                    <a href="{{ route('admin.articles.edit', $article->id) }}"
                                        class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this article?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                No articles found. <a href="{{ route('admin.articles.create') }}"
                                    class="text-blue-600 hover:underline">Create your first article</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $articles->links() }}
        </div>
    </div>
</x-layouts::app>
