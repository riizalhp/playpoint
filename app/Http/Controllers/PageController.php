<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;

class PageController extends Controller
{
    /**
     * Menampilkan halaman utama (homepage) aplikasi.
     *
     * @return \Illuminate\View\View
     */
    public function home()
    {
        // Ambil semua data game dari database
        $games = Game::latest()->get(); 

        // Kirim data games ke view 'home'
        return view('home', [
            'games' => $games
        ]);
    }
}
