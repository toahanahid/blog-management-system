<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Livewire\Home;

// Public Blog Routes
Route::get('/', Home::class)->name('home');

Route::get('/blog', \App\Livewire\Blog\BlogList::class)->name('blog.index');
Route::get('/blog/{slug}', \App\Livewire\Blog\PostView::class)->name('blog.show');
Route::get('/category/{slug}', \App\Livewire\Blog\CategoryArchive::class)->name('blog.category');
Route::get('/tag/{slug}', \App\Livewire\Blog\TagArchive::class)->name('blog.tag');

// Auth Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', \App\Livewire\Admin\Dashboard::class)->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes (requires admin or editor role)
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/categories', \App\Livewire\Admin\CategoryManager::class)->name('categories');
    Route::get('/tags', \App\Livewire\Admin\TagManager::class)->name('tags');
    Route::get('/posts', \App\Livewire\Admin\PostManager::class)->name('posts');
    Route::get('/posts/create', function () {
        return view('admin.posts.create');
    })->name('posts.create');
    Route::get('/posts/edit/{id}', function ($id) {
        return view('admin.posts.edit', ['id' => $id]);
    })->name('posts.edit');
    Route::get('/media', \App\Livewire\Admin\MediaManager::class)->name('media');
    Route::get('/comments', \App\Livewire\Admin\CommentManager::class)->name('comments');
});

require __DIR__ . '/auth.php';
