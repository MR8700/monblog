<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostApiController;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\PortfolioApiController;
use App\Http\Controllers\Api\OrderApiController;
use App\Http\Controllers\Api\ChatApiController;

/*
|--------------------------------------------------------------------------
| API Routes v1
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {
    // Public endpoints
    Route::get('/posts', [PostApiController::class, 'index']);
    Route::get('/posts/{post}', [PostApiController::class, 'show']);
    Route::get('/products', [ProductApiController::class, 'index']);
    Route::get('/products/{product}', [ProductApiController::class, 'show']);
    Route::get('/portfolio', [PortfolioApiController::class, 'index']);
    Route::post('/orders', [OrderApiController::class, 'store']);
    Route::get('/orders/{order}/confirmation', [OrderApiController::class, 'confirmation']);
    
    // Chat messages (public)
    Route::get('/chat/messages', [ChatApiController::class, 'index']);
    Route::post('/chat/messages', [ChatApiController::class, 'store'])->middleware('throttle:20,1');

    // LigdiCash Callback
    Route::post('/payments/ligdicash/callback', [App\Http\Controllers\LigdiCashController::class, 'callback'])->name('api.payments.ligdicash.callback');

    // Admin protected endpoints
    Route::middleware(['auth:sanctum', 'admin'])->group(function () {
        // Posts management
        Route::post('/posts', [PostApiController::class, 'store']);
        Route::put('/posts/{post}', [PostApiController::class, 'update']);
        Route::delete('/posts/{post}', [PostApiController::class, 'destroy']);

        // Products management
        Route::post('/products', [ProductApiController::class, 'store']);
        Route::put('/products/{product}', [ProductApiController::class, 'update']);
        Route::delete('/products/{product}', [ProductApiController::class, 'destroy']);

        // Portfolio management
        Route::post('/portfolio', [PortfolioApiController::class, 'store']);
        Route::put('/portfolio/{portfolio}', [PortfolioApiController::class, 'update']);
        Route::delete('/portfolio/{portfolio}', [PortfolioApiController::class, 'destroy']);

        // Orders management
        Route::get('/orders', [OrderApiController::class, 'index']);
        Route::get('/orders/{order}', [OrderApiController::class, 'show']);
        Route::put('/orders/{order}', [OrderApiController::class, 'update']);
        Route::delete('/orders/{order}', [OrderApiController::class, 'destroy']);
    });
});
