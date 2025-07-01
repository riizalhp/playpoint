<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\ConsignmentController;

// --- Rute Publik ---
Route::get('/', [PageController::class, 'home'])->name('home');

// Rute untuk Titip Jual (Alur Baru)
Route::prefix('titip-jual')->name('consignment.')->group(function () {
    Route::get('/', [ConsignmentController::class, 'create'])->name('create'); // Halaman pilih game
    Route::get('/{game:slug}', [ConsignmentController::class, 'showConsignmentForm'])->name('showForm'); // Halaman form titip jual
    Route::post('/{game:slug}', [ConsignmentController::class, 'store'])->name('store'); // Proses simpan
});

// API untuk mendapatkan kota
Route::get('/api/cities', [ConsignmentController::class, 'getCities'])->name('api.cities');

Route::get('/games/{game:slug}', [GameController::class, 'show'])->name('games.show');
Route::get('/api/games/{game:slug}/filter', [GameController::class, 'filterProducts'])->name('games.filter.api');
Route::get('/games/{game:slug}/{product:slug}', [GameController::class, 'showProduct'])->name('products.show');

Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add/{product}', [CartController::class, 'add'])->name('add');
    Route::post('/buy-now/{product}', [CartController::class, 'buyNow'])->name('buyNow');
    Route::delete('/remove/{product}', [CartController::class, 'remove'])->name('remove');
    Route::post('/process-checkout', [CartController::class, 'processCheckout'])->name('processCheckout');
    Route::post('/verify-voucher', [CartController::class, 'verifyVoucher'])->name('verifyVoucher');
    Route::post('/reset-voucher', [CartController::class, 'resetVoucher'])->name('resetVoucher');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// --- Grup Rute Admin ---
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [AdminProductController::class, 'index'])->name('index');
        Route::get('/{game:slug}', [AdminProductController::class, 'listByGame'])->name('listByGame');
        Route::get('/{game:slug}/create', [AdminProductController::class, 'create'])->name('create');
        Route::post('/{game:slug}', [AdminProductController::class, 'store'])->name('store');
        Route::get('/edit/{product}', [AdminProductController::class, 'edit'])->name('edit');
        Route::put('/{product}', [AdminProductController::class, 'update'])->name('update');
        Route::delete('/{product}', [AdminProductController::class, 'destroy'])->name('destroy');
    });
});
