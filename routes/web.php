<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\CartController;

// Rute untuk halaman utama
Route::get('/', [PageController::class, 'home'])->name('home');

// Rute untuk menampilkan halaman daftar produk (halaman awal)
Route::get('/games/{game:slug}', [GameController::class, 'show'])->name('games.show');

// Rute BARU untuk mengambil data produk yang difilter (API)
Route::get('/api/games/{game:slug}/filter', [GameController::class, 'filterProducts'])->name('games.filter.api');

// RUTE BARU: Halaman Detail Produk
Route::get('/games/{game:slug}/{product:slug}', [GameController::class, 'showProduct'])->name('products.show');

// RUTE BARU: Grup untuk Keranjang Belanja
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add/{product}', [CartController::class, 'add'])->name('add');
    Route::post('/buy-now/{product}', [CartController::class, 'buyNow'])->name('buyNow');
    Route::delete('/remove/{product}', [CartController::class, 'remove'])->name('remove');
    Route::post('/process-checkout', [CartController::class, 'processCheckout'])->name('processCheckout');
    Route::post('/verify-voucher', [CartController::class, 'verifyVoucher'])->name('verifyVoucher'); // Rute baru untuk verifikasi voucher
    Route::post('/reset-voucher', [CartController::class, 'resetVoucher'])->name('resetVoucher'); // Rute baru untuk reset voucher
});