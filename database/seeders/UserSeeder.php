<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Hapus user lama jika ada untuk menghindari duplikat email
        User::where('email', 'admin@gmail.com')->delete();

        // Buat user admin baru
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'), // Password di-hash untuk keamanan
        ]);
    }
}
