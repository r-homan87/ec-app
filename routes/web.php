<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\TopController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\ShippingAddressController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;

Route::get('/', [TopController::class, 'index'])->name('top');

// ========================
// 公開ページ
// ========================
Route::get('/about', fn() => view('about'))->name('about');

// ========================
// 商品一覧（公開用）
// ========================
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// ========================
// 認証必須ルート
// ========================
Route::middleware('auth')->group(function () {
    // ========================
    // マイページ
    // ========================
    Route::get('/mypage', [MypageController::class, 'index'])->name('mypage.index');

    // ========================
    // 配送先
    // ========================
    Route::get('/shipping_addresses', [ShippingAddressController::class, 'index'])->name('shipping_addresses.index');
    Route::post('/shipping_addresses', [ShippingAddressController::class, 'store'])->name('shipping_addresses.store');
    Route::get('/shipping_addresses/{id}/edit', [ShippingAddressController::class, 'edit'])->name('shipping_addresses.edit');
    Route::put('/shipping_addresses/{id}', [ShippingAddressController::class, 'update'])->name('shipping_addresses.update');
    Route::delete('/shipping_addresses/{id}', [ShippingAddressController::class, 'destroy'])->name('shipping_addresses.destroy');

    // ========================
    // 管理画面（admin prefix）
    // ========================
    Route::prefix('admin')
        ->name('admin.')
        ->middleware('admin')
        ->group(function () {
            Route::resource('users', UserController::class);
            Route::get('/users/{user}/orders', [AdminOrderController::class, 'index'])->name('users.orders.index');
            Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
            Route::patch('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
            Route::patch('/order-items/{orderItem}/status', [AdminOrderController::class, 'updateOrderItemStatus'])->name('orderItems.updateStatus');
        });

    // ========================
    // プロフィール
    // ========================
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    // ========================
    // 商品（認証必須の操作）
    // ========================
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    // ========================
    // カート
    // ========================
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/', [CartController::class, 'store'])->name('store');
        Route::patch('/{cartItem}', [CartController::class, 'update'])->name('update');
        Route::delete('/{cartItem}', [CartController::class, 'destroy'])->name('destroy');
    });

    // ========================
    // 注文
    // ========================
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::post('/', [OrderController::class, 'store'])->name('store');
        Route::get('/create', [OrderController::class, 'create'])->name('create');
        Route::post('/confirm', [OrderController::class, 'confirm'])->name('confirm');
        Route::get('/complete', [OrderController::class, 'complete'])->name('complete');
        Route::get('/{order}', [OrderController::class, 'show'])->name('show');
    });

    // ========================
    // ジャンル
    // ========================
    Route::resource('genres', GenreController::class);
});

// ========================
// 認証関連（Laravel Breeze等）
// ========================
require __DIR__ . '/auth.php';
