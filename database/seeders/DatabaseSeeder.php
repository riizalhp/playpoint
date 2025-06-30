<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        // Hapus data lama dari tabel products dan games
        DB::table('products')->delete();
        DB::table('games')->delete();

        // Atur ulang auto-increment ID
        DB::statement('ALTER TABLE games AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE products AUTO_INCREMENT = 1');

        // Panggil seeder
        $this->call([
            GameSeeder::class,
            ProductSeeder::class, // Pastikan ini dipanggil
        ]);

        Schema::enableForeignKeyConstraints();
    }
}
