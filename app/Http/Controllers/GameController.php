<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Product;

class GameController extends Controller
{
    /**
     * Menampilkan halaman daftar produk.
     */
    public function show(Game $game, Request $request)
    {
        $products = $game->products()->latest()->paginate(12);

        return view('games.show', [
            'game' => $game,
            'products' => $products,
        ]);
    }

    /**
     * Menampilkan halaman detail produk.
     */
    public function showProduct(Game $game, Product $product)
    {
        // Ambil produk terkait dari game yang sama, kecuali produk saat ini
        $relatedProducts = Product::where('game_id', $game->id)
                                ->where('id', '!=', $product->id)
                                ->inRandomOrder() // Ambil secara acak
                                ->limit(4) // Batasi 4 produk terkait
                                ->get();

        return view('products.show', [
            'product' => $product,
            'game' => $game,
            'relatedProducts' => $relatedProducts, // Kirim produk terkait ke view
        ]);
    }

    /**
     * Metode API untuk filter.
     */
    public function filterProducts(Game $game, Request $request)
    {
        $query = $game->products();

        if ($request->filled('nama')) {
            $query->where('name', 'like', '%' . $request->nama . '%');
        }
        if ($request->filled('harga_min')) {
            $hargaMin = preg_replace('/[^0-9]/', '', $request->harga_min);
            if ($hargaMin > 0) {
                 $query->where('price', '>=', $hargaMin);
            }
        }
        if ($request->filled('harga_max')) {
            $hargaMax = preg_replace('/[^0-9]/', '', $request->harga_max);
            if ($hargaMax > 0) {
                $query->where('price', '<=', $hargaMax);
            }
        }
        
        $products = $query->latest()->paginate(12);
        return response()->json($products);
    }
}