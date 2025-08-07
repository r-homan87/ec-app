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

Route::get('/dashboard', fn() => view('dashboard'))
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    // ========================
    // マイページ
    // ========================
    Route::get('/mypage', [MypageController::class, 'index'])->name('mypage.index');

    // ========================
    // 配送先
    // ========================
    Route::get('/shipping_addresses', [ShippingAddressController::class, 'index'])->name('shipping_addresses.index');
    Route::get('/shipping_addresses/{id}/edit', [ShippingAddressController::class, 'edit'])->name('shipping_addresses.edit');
    Route::put('/shipping_addresses/{id}', [ShippingAddressController::class, 'update'])->name('shipping_addresses.update');
    Route::delete('/shipping_addresses/{id}', [ShippingAddressController::class, 'destroy'])->name('shipping_addresses.destroy');

    // ========================
    // 管理画面（admin prefix）
    // ========================
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', UserController::class);
        Route::get('/users/{user}/orders', [AdminOrderController::class, 'index'])->name('users.orders.index');
        Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
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
    // 商品
    // ========================
    Route::resource('products', ProductController::class);

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
// 公開ページ
// ========================
Route::get('/about', fn() => view('about'))->name('about');

// 認証関連（Laravel Breeze等）
require __DIR__ . '/auth.php';
