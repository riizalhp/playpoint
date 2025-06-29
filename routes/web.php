<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\GameController; // <-- Jangan lupa tambahkan ini

// Rute untuk halaman utama
Route::get('/', [PageController::class, 'home'])->name('home');

// Rute untuk menampilkan daftar produk berdasarkan game
// Ini adalah rute yang dicari oleh error Anda
Route::get('/games/{game:slug}', [GameController::class, 'show'])->name('games.show');