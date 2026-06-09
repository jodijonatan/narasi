<div class="space-y-8 dark:text-zinc-100">
    <!-- Header Section -->
    <div class="bg-white dark:bg-zinc-900 p-6 rounded-2xl border border-zinc-200/60 dark:border-zinc-800/60 shadow-xs">
        <h2 class="text-2xl font-bold text-zinc-900 dark:text-zinc-50">Manajemen Kategori</h2>
        <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1">Buat, kelola, dan atur kategori untuk mengelompokkan artikel.</p>
    </div>

    @if (session()->has('message'))
        <div class="flex items-center gap-3 bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-200 dark:border-emerald-800/50 text-emerald-800 dark:text-emerald-400 p-4 rounded-xl text-sm font-medium">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span>{{ session('message') }}</span>
        </div>
    @endif

    <!-- Two-column Editor & List Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Editor Form -->
        <div class="lg:col-span-1 bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200/60 dark:border-zinc-800/60 p-6 shadow-xs h-fit">
            <h3 class="text-lg font-bold text-zinc-900 dark:text-zinc-50 mb-4">
                {{ $isEditing ? 'Edit Kategori' : 'Tambah Kategori Baru' }}
            </h3>
            <form wire:submit.prevent="{{ $isEditing ? 'update' : 'store' }}" class="space-y-4">
                <div class="space-y-1.5">
                    <label class="text-sm font-semibold text-zinc-700 dark:text-zinc-300">Nama Kategori</label>
                    <input type="text" wire:model.live="name" placeholder="Contoh: Teknologi" class="w-full px-4 py-2.5 bg-zinc-50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition">
                    @error('name') <span class="text-xs font-medium text-rose-600">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-1.5">
                    <label class="text-sm font-semibold text-zinc-700 dark:text-zinc-300">Slug (Otomatis)</label>
                    <input type="text" wire:model="slug" readonly class="w-full px-4 py-2.5 bg-zinc-100 dark:bg-zinc-900 text-zinc-500 dark:text-zinc-400 border border-zinc-200 dark:border-zinc-800 rounded-xl text-sm focus:outline-hidden select-none">
                </div>

                <div class="space-y-1.5">
                    <label class="text-sm font-semibold text-zinc-700 dark:text-zinc-300">Deskripsi</label>
                    <textarea wire:model="description" rows="3" placeholder="Tulis deskripsi kategori..." class="w-full px-4 py-2.5 bg-zinc-50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition"></textarea>
                    @error('description') <span class="text-xs font-medium text-rose-600">{{ $message }}</span> @enderror
                </div>

                <div class="pt-2 flex gap-3">
                    <button type="submit" class="w-full px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm shadow-md shadow-indigo-600/10 transition cursor-pointer">
                        {{ $isEditing ? 'Update Kategori' : 'Simpan Kategori' }}
                    </button>
                    @if($isEditing)
                        <button type="button" wire:click="resetFields" class="px-4 py-2.5 rounded-xl border border-zinc-200 dark:border-zinc-800 text-zinc-700 dark:text-zinc-300 font-semibold text-sm hover:bg-zinc-100 dark:hover:bg-zinc-800 transition cursor-pointer">
                            Batal
                        </button>
                    @endif
                </div>
            </form>
        </div>

        <!-- List Table -->
        <div class="lg:col-span-2 space-y-4">
            <div class="flex items-center justify-end">
                <div class="relative w-full sm:max-w-xs">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-zinc-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" 
                           wire:model.live="search" 
                           placeholder="Cari kategori..." 
                           class="w-full pl-9 pr-4 py-2.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition">
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200/60 dark:border-zinc-800/60 shadow-xs overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-zinc-50 dark:bg-zinc-900/50 border-b border-zinc-100 dark:border-zinc-800/60">
                                <th class="p-4 text-xs font-bold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Nama</th>
                                <th class="p-4 text-xs font-bold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Slug</th>
                                <th class="p-4 text-xs font-bold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Deskripsi</th>
                                <th class="p-4 text-xs font-bold uppercase tracking-wider text-zinc-500 dark:text-zinc-400 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800/60">
                            @forelse($categories as $category)
                                <tr class="hover:bg-zinc-50/50 dark:hover:bg-zinc-800/20 transition-colors">
                                    <td class="p-4 font-bold text-zinc-900 dark:text-zinc-100 text-sm">
                                        {{ $category->name }}
                                    </td>
                                    <td class="p-4">
                                        <code class="text-xs px-2 py-1 bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 rounded-md font-mono">{{ $category->slug }}</code>
                                    </td>
                                    <td class="p-4 text-sm text-zinc-500 dark:text-zinc-400">
                                        {{ Str::limit($category->description, 50) }}
                                    </td>
                                    <td class="p-4 text-right">
                                        <div class="inline-flex items-center gap-2">
                                            <button wire:click="edit({{ $category->id }})" class="p-2 text-zinc-500 hover:text-indigo-600 dark:text-zinc-400 dark:hover:text-indigo-400 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg transition-colors cursor-pointer" title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </button>
                                            <button onclick="confirm('Yakin ingin menghapus?') || event.stopImmediatePropagation()" 
                                                    wire:click="delete({{ $category->id }})" class="p-2 text-rose-600 hover:text-rose-700 hover:bg-rose-50 dark:hover:bg-rose-950/20 rounded-lg transition-colors cursor-pointer" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-12 text-center text-zinc-500 dark:text-zinc-400 text-sm">
                                        Tidak ada kategori ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div>
                {{ $categories->links() }}
            </div>
        </div>
    </div>
</div>
