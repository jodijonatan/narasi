<x-layouts::app :title="__('Dashboard')">
    <div class="container mx-auto px-4 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Dashboard Penulis</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Selamat datang, {{ auth()->user()->name }}!</p>
        </div>

        <div class="grid gap-6 md:grid-cols-3 mb-8">
            <div class="bg-white dark:bg-zinc-900 rounded-lg shadow p-6">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Artikel Saya</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ auth()->user()->articles()->count() }}</p>
            </div>
            <div class="bg-white dark:bg-zinc-900 rounded-lg shadow p-6">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Diterbitkan</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ auth()->user()->articles()->where('status', 'published')->count() }}</p>
            </div>
            <div class="bg-white dark:bg-zinc-900 rounded-lg shadow p-6">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Menunggu Verifikasi</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ auth()->user()->articles()->where('status', 'pending')->count() }}</p>
            </div>
        </div>

        <div class="bg-white dark:bg-zinc-900 rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Aksi Cepat</h2>
            <div class="flex gap-4">
                <a href="{{ route('writer.articles') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Kelola & Tulis Artikel
                </a>
                <a href="{{ route('home') }}" class="px-4 py-2 bg-gray-200 dark:bg-zinc-800 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-zinc-700 transition">
                    Lihat Website
                </a>
            </div>
        </div>
    </div>
</x-layouts::app>
