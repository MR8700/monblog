<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminPostController;
use App\Http\Controllers\AdminPortfolioController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\PostReactionController;

/*
|--------------------------------------------------------------------------
| Routes publiques
|--------------------------------------------------------------------------
*/
// Page d'accueil publique simple
Route::get('/', [ProductController::class, 'publicHome'])->name('home');
Route::get('/produits', [ProductController::class, 'publicIndex'])->name('products.publicIndex');
Route::get('/produits/{product:slug}', [ProductController::class, 'publicShow'])->name('products.show');

// Blog
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{post:slug}', [BlogController::class, 'show'])->name('blog.show');
Route::post('/blog/{post:slug}/commentaires', [PostCommentController::class, 'store'])->middleware('throttle:30,1')->name('blog.comments.store');
Route::post('/blog/{post:slug}/reactions', [PostReactionController::class, 'toggle'])->middleware('throttle:60,1')->name('blog.reactions.toggle');

// Portfolio / CV
Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio.index');

// Chat public
Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
Route::post('/chat/messages', [ChatController::class, 'store'])->middleware('throttle:20,1')->name('chat.store');

// Page contact
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');


/*
|--------------------------------------------------------------------------
| Routes admin
|--------------------------------------------------------------------------
*/

// Login / Logout admin
// Login / Logout admin
Route::get('/admin/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->middleware('throttle:10,1')->name('admin.login.submit');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');


Route::prefix('admin')->middleware('auth:admin')->name('admin.')->group(function() {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::resource('products', ProductController::class);
    Route::resource('posts', AdminPostController::class)->except(['show']);
    Route::resource('portfolio', AdminPortfolioController::class)->except(['show']);
    // Profil admin
    Route::get('profile', [AdminController::class, 'index'])->name('profile.index');
    Route::get('profile/edit', [AdminController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [AdminController::class, 'update'])->name('profile.update');
});
