<div class="space-y-8 dark:text-zinc-100">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white dark:bg-zinc-900 p-6 rounded-2xl border border-zinc-200/60 dark:border-zinc-800/60 shadow-xs">
        <div>
            <h2 class="text-2xl font-bold text-zinc-900 dark:text-zinc-50">Manajemen Artikel Saya</h2>
            <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1">Tulis, kelola, dan terbitkan artikel Anda di sini.</p>
        </div>
        <button wire:click="create" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm shadow-md shadow-indigo-600/10 hover:shadow-lg transition-all duration-200 cursor-pointer">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
            Tulis Artikel Baru
        </button>
    </div>

    @if (session()->has('message'))
        <div class="flex items-center gap-3 bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-200 dark:border-emerald-800/50 text-emerald-800 dark:text-emerald-400 p-4 rounded-xl text-sm font-medium">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span>{{ session('message') }}</span>
        </div>
    @endif

    <!-- Search & Filters -->
    <div class="flex flex-col sm:flex-row gap-4 items-center justify-between">
        <div class="relative w-full sm:max-w-xs">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-zinc-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <input type="text" 
                   wire:model.live="search" 
                   placeholder="Cari artikel..." 
                   class="w-full pl-9 pr-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition">
        </div>
    </div>

    <!-- Articles Table -->
    <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200/60 dark:border-zinc-800/60 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-zinc-50 dark:bg-zinc-900/50 border-b border-zinc-100 dark:border-zinc-800/60">
                        <th class="p-4 text-xs font-bold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Judul</th>
                        <th class="p-4 text-xs font-bold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Kategori</th>
                        <th class="p-4 text-xs font-bold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Status</th>
                        <th class="p-4 text-xs font-bold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Tanggal</th>
                        <th class="p-4 text-xs font-bold uppercase tracking-wider text-zinc-500 dark:text-zinc-400 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800/60">
                    @forelse($articles as $article)
                        <tr class="hover:bg-zinc-50/50 dark:hover:bg-zinc-800/20 transition-colors">
                            <td class="p-4">
                                <div class="font-bold text-zinc-900 dark:text-zinc-100 text-sm sm:text-base">{{ $article->title }}</div>
                                <div class="text-xs text-zinc-400 dark:text-zinc-500 font-mono mt-0.5 truncate max-w-xs">{{ $article->slug }}</div>
                            </td>
                            <td class="p-4 text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                {{ $article->category->name }}
                            </td>
                            <td class="p-4">
                                @if($article->status === 'published')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 dark:bg-emerald-900/40 text-emerald-800 dark:text-emerald-400">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Diterbitkan
                                    </span>
                                @elseif($article->status === 'pending')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 dark:bg-amber-900/40 text-amber-800 dark:text-amber-400">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                        Pending
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-zinc-100 dark:bg-zinc-800 text-zinc-800 dark:text-zinc-400">
                                        <span class="w-1.5 h-1.5 rounded-full bg-zinc-400"></span>
                                        Draft
                                    </span>
                                @endif
                            </td>
                            <td class="p-4 text-sm text-zinc-500 dark:text-zinc-400">
                                {{ $article->created_at->format('d M Y') }}
                            </td>
                            <td class="p-4 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <button wire:click="edit({{ $article->id }})" class="p-2 text-zinc-500 hover:text-indigo-600 dark:text-zinc-400 dark:hover:text-indigo-400 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg transition-colors cursor-pointer" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </button>
                                    @if($article->status === 'draft')
                                        <button wire:click="submitForReview({{ $article->id }})" class="p-2 text-emerald-600 hover:text-emerald-700 hover:bg-emerald-50 dark:hover:bg-emerald-950/20 rounded-lg transition-colors cursor-pointer" title="Kirim untuk Ditinjau">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                        </button>
                                    @endif
                                    <button onclick="confirm('Hapus artikel ini?') || event.stopImmediatePropagation()" 
                                            wire:click="delete({{ $article->id }})" class="p-2 text-rose-600 hover:text-rose-700 hover:bg-rose-50 dark:hover:bg-rose-950/20 rounded-lg transition-colors cursor-pointer" title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-12 text-center text-zinc-500 dark:text-zinc-400 text-sm">
                                <svg class="mx-auto h-10 w-10 text-zinc-300 dark:text-zinc-700 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Belum ada artikel yang Anda tulis.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div>
        {{ $articles->links() }}
    </div>

    <!-- Create/Edit Modal Overlay -->
    @if($showCreateModal)
        <div class="fixed inset-0 bg-zinc-950/60 backdrop-blur-xs flex items-center justify-center p-4 z-50 animate-fade-in">
            <div class="bg-white dark:bg-zinc-900 w-full max-w-2xl rounded-2xl border border-zinc-200/60 dark:border-zinc-800/60 shadow-2xl max-h-[90vh] overflow-y-auto flex flex-col">
                <!-- Modal Header -->
                <div class="px-6 py-4 border-b border-zinc-100 dark:border-zinc-800/60 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-zinc-900 dark:text-zinc-50">
                        {{ $isEditing ? 'Edit Artikel' : 'Tulis Artikel Baru' }}
                    </h3>
                    <button wire:click="$set('showCreateModal', false)" class="p-1 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <form wire:submit.prevent="{{ $isEditing ? 'update' : 'store' }}">
                    <div class="p-6 space-y-5">
                        <div class="space-y-1.5">
                            <label class="text-sm font-semibold text-zinc-700 dark:text-zinc-300">Judul Artikel</label>
                            <input type="text" wire:model.live="title" placeholder="Masukkan judul yang menarik..." class="w-full px-4 py-2.5 bg-zinc-50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition">
                            @error('title') <span class="text-xs font-medium text-rose-600">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label class="text-sm font-semibold text-zinc-700 dark:text-zinc-300">Kategori</label>
                                <select wire:model="categoryId" class="w-full px-4 py-2.5 bg-zinc-50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition">
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('categoryId') <span class="text-xs font-medium text-rose-600">{{ $message }}</span> @enderror
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-sm font-semibold text-zinc-700 dark:text-zinc-300">Thumbnail Artikel</label>
                                <input type="file" wire:model="thumbnail" class="w-full text-sm text-zinc-500 dark:text-zinc-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 dark:file:bg-indigo-950/50 dark:file:text-indigo-400 hover:file:bg-indigo-100 transition">
                                @if ($thumbnail)
                                    <div class="mt-3 relative inline-block rounded-xl overflow-hidden border border-zinc-200 dark:border-zinc-850">
                                        <img src="{{ $thumbnail->temporaryUrl() }}" class="w-24 h-24 object-cover">
                                    </div>
                                @endif
                                @error('thumbnail') <span class="text-xs font-medium text-rose-600">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-sm font-semibold text-zinc-700 dark:text-zinc-300">Ringkasan (Excerpt)</label>
                            <textarea wire:model="excerpt" rows="2" placeholder="Ringkasan singkat artikel..." class="w-full px-4 py-2.5 bg-zinc-50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition"></textarea>
                            @error('excerpt') <span class="text-xs font-medium text-rose-600">{{ $message }}</span> @enderror
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-sm font-semibold text-zinc-700 dark:text-zinc-300">Konten Artikel</label>
                            <textarea wire:model="content" rows="10" placeholder="Tulis isi artikel di sini..." class="w-full px-4 py-2.5 bg-zinc-50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 rounded-xl text-sm font-mono focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition"></textarea>
                            @error('content') <span class="text-xs font-medium text-rose-600">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="px-6 py-4 border-t border-zinc-100 dark:border-zinc-800/60 bg-zinc-50/50 dark:bg-zinc-900/50 flex items-center justify-end gap-3 rounded-b-2xl">
                        <button type="button" wire:click="$set('showCreateModal', false)" class="px-4 py-2 rounded-xl border border-zinc-200 dark:border-zinc-800 text-zinc-700 dark:text-zinc-300 font-semibold text-sm hover:bg-zinc-100 dark:hover:bg-zinc-800 transition cursor-pointer">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm shadow-md shadow-indigo-600/10 transition cursor-pointer">
                            {{ $isEditing ? 'Update Artikel' : 'Simpan Draft' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
