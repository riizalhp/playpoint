<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game; // Jangan lupa import model Game

class GameController extends Controller
{
    /**
     * Menampilkan halaman daftar produk untuk sebuah game.
     */
    public function show(Game $game) // Menggunakan Route Model Binding
    {
        // Load produk yang berhubungan dengan game ini
        // Ini akan mengambil semua produk yang memiliki game_id yang sama.
        $game->load('products');

        // Mengirim data game (yang sudah berisi produk) ke view
        return view('games.show', [
            'game' => $game
        ]);
    }
}