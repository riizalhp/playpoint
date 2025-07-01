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

        // Hapus data lama dari tabel
        DB::table('products')->delete();
        DB::table('games')->delete();
        DB::table('users')->delete(); // TAMBAHKAN: Hapus data users lama

        // Atur ulang auto-increment ID
        DB::statement('ALTER TABLE games AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE products AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE users AUTO_INCREMENT = 1'); // TAMBAHKAN: Reset auto-increment users

        // Panggil seeder
        $this->call([
            GameSeeder::class,
            ProductSeeder::class,
            UserSeeder::class, // TAMBAHKAN: Panggil UserSeeder
        ]);

        Schema::enableForeignKeyConstraints();
    }
}
