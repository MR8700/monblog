<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminBlogController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminTagController;
use App\Http\Controllers\AdminMediaController;
use App\Http\Controllers\OrderController;
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
Route::get('/blog/category/{category:slug}', [BlogController::class, 'category'])->name('blog.category');
Route::get('/blog/tag/{tag:slug}', [BlogController::class, 'tag'])->name('blog.tag');
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

// Pages Légales
Route::view('/confidentialite', 'public.privacy')->name('privacy');
Route::view('/conditions', 'public.terms')->name('terms');

// Commandes (e-commerce)
Route::post('/orders', [OrderController::class, 'store'])->middleware('throttle:10,1')->name('orders.store');
Route::get('/orders/{order}/payment/select', [OrderController::class, 'selectPaymentMethod'])->name('orders.payment.select');
Route::post('/orders/{order}/payment/initiate', [OrderController::class, 'initiatePayment'])->name('orders.payment.initiate');
Route::get('/orders/{order}/payment/visa', [OrderController::class, 'showVisaForm'])->name('orders.payment.visa');
Route::post('/orders/{order}/payment/process', [OrderController::class, 'processPayment'])->name('orders.payment.process');
Route::get('/orders/{order}/confirmation', [OrderController::class, 'confirmation'])->name('orders.confirmation');
Route::get('/orders/{order}/download/{product}', [OrderController::class, 'download'])->middleware('signed')->name('orders.download');


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


Route::prefix('admin')->middleware('auth.admin')->name('admin.')->group(function() {
    Route::resource('orders', OrderController::class)->except(['create', 'edit', 'store']);
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::resource('products', ProductController::class);
    Route::resource('posts', AdminBlogController::class);
    Route::post('posts/{post}/toggle-visibility', [AdminBlogController::class, 'toggleVisibility'])->name('posts.toggle-visibility');
    Route::resource('categories', AdminCategoryController::class)->except(['show']);
    Route::resource('tags', AdminTagController::class)->except(['show']);
    Route::delete('media/{media}', [AdminMediaController::class, 'destroy'])->name('media.destroy');
    Route::post('media/reorder', [AdminMediaController::class, 'reorder'])->name('media.reorder');
    Route::get('media/{media}/download', [AdminMediaController::class, 'download'])->name('media.download');
    Route::resource('portfolio', AdminPortfolioController::class)->except(['show']);
    // Messagerie & Chat
    Route::get('chat', [ChatController::class, 'adminIndex'])->name('chat.index');
    Route::get('chat/{room}', [ChatController::class, 'adminShow'])->name('chat.show');
    Route::get('messages', [\App\Http\Controllers\AdminContactController::class, 'index'])->name('messages.index');
    Route::get('messages/{message}', [\App\Http\Controllers\AdminContactController::class, 'show'])->name('messages.show');
    Route::put('messages/{message}/reply', [\App\Http\Controllers\AdminContactController::class, 'reply'])->name('messages.reply');
    Route::delete('messages/{message}', [\App\Http\Controllers\AdminContactController::class, 'destroy'])->name('messages.destroy');
    
    // Clients & Rapports
    Route::get('customers', [\App\Http\Controllers\AdminCustomerController::class, 'index'])->name('customers.index');
    Route::get('customers/{email}', [\App\Http\Controllers\AdminCustomerController::class, 'show'])->name('customers.show');
    Route::get('reports/sales', [\App\Http\Controllers\AdminReportController::class, 'soldProducts'])->name('reports.sales');
    Route::get('reports/sales/product/{product}', [\App\Http\Controllers\AdminReportController::class, 'productDetails'])->name('reports.sales.product');
    Route::get('reports/sales/post/{post}', [\App\Http\Controllers\AdminReportController::class, 'postDetails'])->name('reports.sales.post');

    // Paramètres du site
    Route::get('settings', [\App\Http\Controllers\AdminSettingsController::class, 'index'])->name('settings.index');
    Route::post('settings/visual', [\App\Http\Controllers\AdminSettingsController::class, 'updateVisual'])->name('settings.visual');
    Route::post('settings/email', [\App\Http\Controllers\AdminSettingsController::class, 'updateEmail'])->name('settings.email');
    Route::post('settings/backup', [\App\Http\Controllers\AdminSettingsController::class, 'backup'])->name('settings.backup');
    Route::post('settings/service-types', [\App\Http\Controllers\AdminSettingsController::class, 'storeServiceType'])->name('settings.service-types');
    Route::post('settings/service-types/{serviceType}/toggle', [\App\Http\Controllers\AdminSettingsController::class, 'toggleServiceType'])->name('settings.service-types.toggle');
    Route::delete('settings/service-types/{serviceType}', [\App\Http\Controllers\AdminSettingsController::class, 'destroyServiceType'])->name('settings.service-types.destroy');

    // Gestion des administrateurs (Super Admin seulement)
    Route::middleware('can:manage-admins')->group(function() {
        Route::get('admins', [\App\Http\Controllers\Admin\AdminManagementController::class, 'index'])->name('admins.index');
        Route::get('admins/create', [\App\Http\Controllers\Admin\AdminManagementController::class, 'create'])->name('admins.create');
        Route::post('admins', [\App\Http\Controllers\Admin\AdminManagementController::class, 'store'])->name('admins.store');
        Route::get('admins/{admin}/edit', [\App\Http\Controllers\Admin\AdminManagementController::class, 'edit'])->name('admins.edit');
        Route::put('admins/{admin}', [\App\Http\Controllers\Admin\AdminManagementController::class, 'update'])->name('admins.update');
        Route::post('admins/{admin}/toggle-suspension', [\App\Http\Controllers\Admin\AdminManagementController::class, 'toggleSuspension'])->name('admins.toggle-suspension');
        Route::delete('admins/{admin}', [\App\Http\Controllers\Admin\AdminManagementController::class, 'destroy'])->name('admins.destroy');
    });

    // Profil admin
    Route::get('profile', [AdminController::class, 'index'])->name('profile.index');
    Route::get('profile/edit', [AdminController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [AdminController::class, 'update'])->name('profile.update');

    // Gestion des demandes de services
    Route::get('services', [\App\Http\Controllers\AdminServiceRequestController::class, 'index'])->name('services.index');
    Route::post('services/types', [\App\Http\Controllers\AdminServiceRequestController::class, 'storeType'])->name('services.types.store');
    Route::post('services/types/{serviceType}/toggle', [\App\Http\Controllers\AdminServiceRequestController::class, 'toggleType'])->name('services.types.toggle');
    Route::delete('services/types/{serviceType}', [\App\Http\Controllers\AdminServiceRequestController::class, 'destroyType'])->name('services.types.destroy');
    Route::get('services/{serviceRequest}', [\App\Http\Controllers\AdminServiceRequestController::class, 'show'])->name('services.show');
    Route::put('services/{serviceRequest}/status', [\App\Http\Controllers\AdminServiceRequestController::class, 'updateStatus'])->name('services.update-status');
    Route::post('services/{serviceRequest}/log-interaction', [\App\Http\Controllers\AdminServiceRequestController::class, 'logInteraction'])->name('services.log-interaction');
    Route::post('services/{serviceRequest}/delivery', [\App\Http\Controllers\AdminServiceRequestController::class, 'createDelivery'])->name('services.create-delivery');
    Route::post('deliveries/{delivery}/regenerate-token', [\App\Http\Controllers\AdminServiceRequestController::class, 'regenerateDeliveryToken'])->name('deliveries.regenerate-token');
});

// Routes publiques pour les services
Route::get('/demande-service', [\App\Http\Controllers\ServiceRequestController::class, 'create'])->name('services.request');
Route::post('/demande-service', [\App\Http\Controllers\ServiceRequestController::class, 'store'])->name('services.request.store');

// Espace de livraison sécurisé
Route::get('/deliveries/gallery', [\App\Http\Controllers\DeliveryController::class, 'gallery'])->name('deliveries.gallery');
Route::get('/delivery/{token}', [\App\Http\Controllers\DeliveryController::class, 'show'])->name('deliveries.show');
Route::post('/delivery/{token}/comment', [\App\Http\Controllers\DeliveryController::class, 'storeComment'])->name('deliveries.comment');
Route::get('/delivery/{token}/download', [\App\Http\Controllers\DeliveryController::class, 'download'])->name('deliveries.download');
Route::get('/delivery/{token}/invoice', [\App\Http\Controllers\DeliveryController::class, 'invoice'])->name('deliveries.invoice');
Route::post('/delivery/{token}/pay', [\App\Http\Controllers\DeliveryController::class, 'processPayment'])->name('deliveries.pay');
Route::post('/delivery/{token}/react', [\App\Http\Controllers\DeliveryController::class, 'toggleReaction'])->name('deliveries.react');
