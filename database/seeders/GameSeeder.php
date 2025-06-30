<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Game;


class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $games = [
            ['name' => 'Mobile Legends', 'slug' => 'mobile-legends', 'image' => 'mobile-legends.jpg'],
            ['name' => 'Free Fire', 'slug' => 'free-fire', 'image' => 'free-fire.jpg'],
            ['name' => 'Point Blank', 'slug' => 'point-blank', 'image' => 'point-blank.jpg'],
            ['name' => 'FC Mobile', 'slug' => 'fc-mobile', 'image' => 'ea-sports-fc-mobile.jpg'],
            ['name' => 'Honor of Kings', 'slug' => 'honor-of-kings', 'image' => 'honor-of-kings.jpg'],
            ['name' => 'Magic Chess GoGo', 'slug' => 'magic-chess-gogo', 'image' => 'mcgg.jpg'],
            ['name' => 'PUBG Mobile', 'slug' => 'pubg-mobile', 'image' => 'pubg.jpg'],
            ['name' => 'Roblox', 'slug' => 'roblox', 'image' => 'roblox.jpg'],
            ['name' => 'Zepeto', 'slug' => 'zepeto', 'image' => 'zepeto.jpg'],
            ['name' => 'Valorant', 'slug' => 'valorant', 'image' => 'valorant.jpg'],
            ['name' => '8-Ball Pool', 'slug' => '8-ball-pool', 'image' => '8-ball-pool.jpg'],
            ['name' => 'Grand Chase', 'slug' => 'grand-chase', 'image' => 'grand-chase.jpg'],
            ['name' => 'Clash Of Clans', 'slug' => 'clash-of-clans', 'image' => 'coc.jpg'],
            ['name' => 'Call Of Duty : Mobile', 'slug' => 'codm', 'image' => 'codm.jpg'],
            ['name' => 'Lainnya', 'slug' => 'lainnya', 'image' => 'play-point-logo.png'],
        ];

        foreach ($games as $game) {
            Game::create([
                'name' => $game['name'],
                'slug' => $game['slug'],
                'thumbnail_url' => 'images/games/' . $game['image'],
                'description' => 'Akun'
            ]);
        }
    }
}