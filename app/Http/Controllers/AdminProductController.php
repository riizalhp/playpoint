<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminProductController extends Controller
{
    /**
     * Menampilkan halaman untuk memilih game dengan fitur pencarian.
     */
    public function index(Request $request)
    {
        $query = Game::query();

        // Logika untuk fitur pencarian
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Ambil data game, urutkan berdasarkan nama, dan kirim ke view
        $games = $query->orderBy('name')->get();
        
        return view('admin.products.index', compact('games'));
    }

    /**
     * Menampilkan daftar produk untuk game tertentu.
     */
    public function listByGame(Game $game)
    {
        $products = $game->products()->latest()->paginate(10);
        return view('admin.products.list', compact('game', 'products'));
    }

    /**
     * Menampilkan form untuk membuat produk baru untuk game tertentu.
     */
    public function create(Game $game)
    {
        return view('admin.products.create', compact('game'));
    }

    /**
     * Menyimpan produk baru ke database.
     */
    public function store(Request $request, Game $game)
    {
        $validated = $request->validate($this->validationRules());

        $product = new Product($validated);
        $product->game_id = $game->id; // Tetapkan game_id dari route
        $product->slug = Str::slug($validated['name'] . '-' . uniqid());
        $product->gallery = json_decode($validated['gallery'] ?? '[]', true) ?: [];
        $product->save();

        return redirect()->route('admin.products.listByGame', $game)->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit produk.
     */
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    /**
     * Memperbarui produk di database.
     */
    public function update(Request $request, Product $product)
    {
        $rules = $this->validationRules();
        unset($rules['game_id']);
        $validated = $request->validate($rules);
        
        $product->fill($validated);
        $product->gallery = json_decode($validated['gallery'] ?? '[]', true) ?: [];
        $product->save();

        return redirect()->route('admin.products.listByGame', $product->game)->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Menghapus produk dari database.
     */
    public function destroy(Product $product)
    {
        $game = $product->game;
        $product->delete();
        return redirect()->route('admin.products.listByGame', $game)->with('success', 'Produk berhasil dihapus.');
    }

    /**
     * Aturan validasi untuk form produk.
     */
    private function validationRules()
    {
        return [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0|gte:price',
            'short_specs' => 'required|string',
            'description' => 'required|string',
            'thumbnail_url' => 'required|url',
            'gallery' => 'nullable|json',
            'is_available' => 'sometimes|boolean',
        ];
    }
}
