<?php

namespace App\Http\Controllers;

use App\Models\Consignment;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ConsignmentController extends Controller
{
    /**
     * Menampilkan halaman untuk memilih game.
     */
    public function create()
    {
        $games = Game::orderBy('name')->get();
        return view('consignment.select-game', compact('games'));
    }

    /**
     * Menampilkan form titip jual setelah game dipilih.
     */
    public function showConsignmentForm(Game $game)
    {
        $jsonPath = storage_path('app/provinces.json');
        $provincesData = [];
        if (File::exists($jsonPath)) {
            $provincesData = json_decode(File::get($jsonPath), true);
        }
        $provinces = is_array($provincesData) ? array_column($provincesData, 'province') : [];
        return view('consignment.create', compact('game', 'provinces'));
    }

    /**
     * Menyimpan data dari form titip jual.
     */
    public function store(Request $request, Game $game)
    {
        // PERUBAHAN: Perbarui aturan validasi harga
        $validated = $request->validate([
            'seller_name' => 'required|string|max:255',
            'contact_whatsapp' => 'required|string|max:20',
            'contact_whatsapp_optional' => 'nullable|string|max:20',
            'province' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'address' => 'required|string',
            'postal_code' => 'required|string|max:10',
            'email' => 'required|email|max:255',
            'account_details' => 'required|string',
            'account_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price_low' => 'required|numeric|min:0',
            'price_high' => 'required|numeric|min:0|gte:price_low',
            'terms' => 'accepted',
        ]);

        $imagePaths = [];
        if ($request->hasFile('account_images')) {
            foreach ($request->file('account_images') as $image) {
                $path = $image->store('consignment_images', 'public');
                $imagePaths[] = $path;
            }
        }

        $consignment = new Consignment($validated);
        $consignment->game_name = $game->name;
        $consignment->account_images = $imagePaths;
        $consignment->save();

        return redirect()->route('consignment.showForm', $game)->with('success', 'Permintaan Anda telah terkirim! Admin akan segera menghubungi Anda.');
    }

    /**
     * API untuk mendapatkan kota berdasarkan provinsi.
     */
    public function getCities(Request $request)
    {
        $jsonPath = storage_path('app/provinces.json');
        $provincesData = [];
        if (File::exists($jsonPath)) {
            $provincesData = json_decode(File::get($jsonPath), true);
        }

        $selectedProvince = $request->input('province');
        $cities = [];

        if (is_array($provincesData)) {
            foreach ($provincesData as $data) {
                if (isset($data['province']) && $data['province'] === $selectedProvince) {
                    $cities = $data['cities'] ?? [];
                    break;
                }
            }
        }
        return response()->json($cities);
    }
}
