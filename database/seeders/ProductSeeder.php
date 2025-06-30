<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Game;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $game = Game::where('slug', 'mobile-legends')->first();

        if ($game) {
            $products = [];
            $names = [
                'Akun Sultan Full Skin', 'Akun Mythic Glory Top Global', 'Akun Kolektor Terbatas', 'Akun WR Tinggi Siap Turnamen',
                'Akun Legend V Murah', 'Akun Full Emblem Max', 'Akun Spesial Skin KOF', 'Akun Monsep Jual Cepat',
                'Akun Pensiun Dini', 'Akun Hoki Hoki Club', 'Akun Joki Capek', 'Akun Bekas Pro Player',
                'Akun Iseng Berhadiah', 'Akun Harta Karun', 'Akun Spesial Fanny', 'Akun Khusus Chou',
                'Akun Paket Lengkap', 'Akun Starter Pack', 'Akun Harian Mantap', 'Akun Akhir Season',
            ];

            for ($i = 0; $i < 20; $i++) {
                $price = rand(100, 1000) * 1000;
                $products[] = [
                    'name' => $names[$i],
                    'slug' => Str::slug($names[$i] . '-' . uniqid()),
                    'price' => $price,
                    'original_price' => $price + (rand(50, 200) * 1000), // Harga coret selalu lebih tinggi
                    'short_specs' => 'WR ' . rand(50, 70) . '%, Skin ' . rand(100, 300) . ', Hero Lengkap',
                    'description' => 'Deskripsi lengkap untuk ' . $names[$i] . '. Akun dijamin aman, login via Moonton.',
                    'thumbnail_url' => 'https://placehold.co/600x400/'. substr(md5($names[$i]), 0, 6) .'/ffffff?text=' . urlencode(substr($names[$i], 0, 15)),
                    'gallery' => json_encode([
                        'https://placehold.co/800x600/'. substr(md5($names[$i].'1'), 0, 6) .'/ffffff?text=Gambar+1',
                        'https://placehold.co/800x600/'. substr(md5($names[$i].'2'), 0, 6) .'/ffffff?text=Gambar+2',
                    ]),
                    'game_id' => $game->id,
                ];
            }

            Product::insert($products);
        }
    }
}