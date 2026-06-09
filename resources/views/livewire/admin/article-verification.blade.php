<div class="space-y-8 dark:text-zinc-100">
    <!-- Header Section -->
    <div class="bg-white dark:bg-zinc-900 p-6 rounded-2xl border border-zinc-200/60 dark:border-zinc-800/60 shadow-xs">
        <h2 class="text-2xl font-bold text-zinc-900 dark:text-zinc-50">Verifikasi Artikel</h2>
        <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1">Tinjau artikel yang menunggu persetujuan sebelum diterbitkan ke publik.</p>
    </div>

    @if (session()->has('message'))
        <div class="flex items-center gap-3 bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-200 dark:border-emerald-800/50 text-emerald-800 dark:text-emerald-400 p-4 rounded-xl text-sm font-medium">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span>{{ session('message') }}</span>
        </div>
    @endif

    <!-- Search input -->
    <div class="flex items-center justify-end">
        <div class="relative w-full sm:max-w-xs">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-zinc-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <input type="text" 
                   wire:model.live="search" 
                   placeholder="Cari artikel pending..." 
                   class="w-full pl-9 pr-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition">
        </div>
    </div>

    <!-- Table List -->
    <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200/60 dark:border-zinc-800/60 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-zinc-50 dark:bg-zinc-900/50 border-b border-zinc-100 dark:border-zinc-800/60">
                        <th class="p-4 text-xs font-bold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Judul</th>
                        <th class="p-4 text-xs font-bold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Penulis</th>
                        <th class="p-4 text-xs font-bold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Kategori</th>
                        <th class="p-4 text-xs font-bold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Tanggal Kirim</th>
                        <th class="p-4 text-xs font-bold uppercase tracking-wider text-zinc-500 dark:text-zinc-400 text-right">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800/60">
                    @forelse($pendingArticles as $article)
                        <tr class="hover:bg-zinc-50/50 dark:hover:bg-zinc-800/20 transition-colors">
                            <td class="p-4 font-bold text-zinc-900 dark:text-zinc-100 text-sm">
                                {{ $article->title }}
                            </td>
                            <td class="p-4 text-sm text-zinc-600 dark:text-zinc-300">
                                {{ $article->user->name }}
                            </td>
                            <td class="p-4">
                                <span class="inline-block px-2.5 py-1 bg-indigo-50 dark:bg-indigo-950/40 text-indigo-700 dark:text-indigo-400 text-xs font-semibold rounded-full">
                                    {{ $article->category->name }}
                                </span>
                            </td>
                            <td class="p-4 text-sm text-zinc-550 dark:text-zinc-400">
                                {{ $article->updated_at->format('d M Y H:i') }}
                            </td>
                            <td class="p-4 text-right">
                                <button wire:click="review({{ $article->id }})" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-xs transition cursor-pointer">
                                    Tinjau
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-12 text-center text-zinc-500 dark:text-zinc-400 text-sm">
                                Tidak ada artikel yang menunggu verifikasi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div>
        {{ $pendingArticles->links() }}
    </div>

    <!-- Review Modal Overlay -->
    @if($showReviewModal && $selectedArticle)
        <div class="fixed inset-0 bg-zinc-950/60 backdrop-blur-xs flex items-center justify-center p-4 z-50 animate-fade-in">
            <div class="bg-white dark:bg-zinc-900 w-full max-w-3xl rounded-2xl border border-zinc-200/60 dark:border-zinc-800/60 shadow-2xl max-h-[90vh] overflow-y-auto flex flex-col">
                <!-- Modal Header -->
                <div class="px-6 py-4 border-b border-zinc-100 dark:border-zinc-800/60 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-zinc-900 dark:text-zinc-50">Tinjau Artikel</h3>
                    <button wire:click="$set('showReviewModal', false)" class="p-1 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <!-- Modal Body (Preview) -->
                <div class="p-6 overflow-y-auto space-y-6 flex-grow">
                    @if($selectedArticle->thumbnail)
                        <div class="aspect-video w-full rounded-xl overflow-hidden bg-zinc-100 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-850">
                            <img src="{{ Str::startsWith($selectedArticle->thumbnail, ['http://', 'https://']) ? $selectedArticle->thumbnail : Storage::url($selectedArticle->thumbnail) }}" class="w-full h-full object-cover">
                        </div>
                    @endif
                    <div>
                        <span class="inline-block bg-indigo-100 dark:bg-indigo-900/40 text-indigo-700 dark:text-indigo-400 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider mb-2">
                            {{ $selectedArticle->category->name }}
                        </span>
                        <h1 class="text-2xl sm:text-4xl font-extrabold text-zinc-900 dark:text-zinc-50 leading-tight">
                            {{ $selectedArticle->title }}
                        </h1>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-2">
                            Ditulis oleh <strong class="text-zinc-700 dark:text-zinc-300 font-semibold">{{ $selectedArticle->user->name }}</strong>
                        </p>
                    </div>

                    <div class="prose dark:prose-invert max-w-none text-zinc-700 dark:text-zinc-300 leading-relaxed text-base border-t border-zinc-100 dark:border-zinc-800/60 pt-6">
                        {!! nl2br(e($selectedArticle->content)) !!}
                    </div>
                </div>

                <!-- Modal Footer Actions -->
                <div class="px-6 py-4 border-t border-zinc-100 dark:border-zinc-800/60 bg-zinc-50/50 dark:bg-zinc-900/50 flex flex-col sm:flex-row items-center justify-between gap-3 rounded-b-2xl">
                    <button wire:click="$set('showReviewModal', false)" class="w-full sm:w-auto px-4 py-2 rounded-xl border border-zinc-200 dark:border-zinc-800 text-zinc-700 dark:text-zinc-300 font-semibold text-sm hover:bg-zinc-100 dark:hover:bg-zinc-800 transition cursor-pointer">
                        Tutup
                    </button>
                    <div class="w-full sm:w-auto flex flex-col sm:flex-row gap-3">
                        <button wire:click="reject({{ $selectedArticle->id }})" class="w-full sm:w-auto px-4 py-2 rounded-xl bg-rose-50 dark:bg-rose-950/20 text-rose-600 dark:text-rose-400 border border-rose-200 dark:border-rose-800/45 hover:bg-rose-100/50 dark:hover:bg-rose-950/40 font-semibold text-sm transition cursor-pointer">
                            Tolak (Revisi)
                        </button>
                        <button wire:click="approve({{ $selectedArticle->id }})" class="w-full sm:w-auto px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm shadow-md shadow-emerald-600/10 transition cursor-pointer">
                            Setujui & Terbitkan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
