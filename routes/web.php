<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', \App\Livewire\Public\Home::class)->name('home');
Route::get('/articles/{slug}', \App\Livewire\Public\ArticleDetail::class)->name('articles.show');

// Authenticated Routes
Route::middleware(['auth', 'verified'])->group(function () {
    // User/Writer Dashboard
    Route::get('dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Writer Article Management
    Route::get('my-articles', \App\Livewire\Writer\ArticleManager::class)->name('writer.articles');

    // Admin Routes (Admin only)
    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
        // Admin Dashboard
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        // Verification
        Route::get('/verify', \App\Livewire\Admin\ArticleVerification::class)->name('verify');

        // Categories Management
        Route::get('/categories', \App\Livewire\Admin\CategoryManager::class)->name('categories.index');

        // User Management
        Route::get('/users', \App\Livewire\Admin\UserManager::class)->name('users.index');
    });
});

require __DIR__ . '/settings.php';
