<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            // foreignId mengacu pada kolom 'id' di tabel 'games'
            // constrained() akan otomatis menggunakan konvensi Laravel
            // onDelete('cascade') berarti jika sebuah game dihapus, semua produknya juga akan terhapus.
            $table->foreignId('game_id')->constrained()->onDelete('cascade');
            $table->string('name'); // Nama produk, e.g., "Akun ML Sultan #567"
            $table->string('slug')->unique(); // Untuk URL yang bersih
            $table->text('short_specs'); // Spesifikasi singkat, e.g., "Mythic, 350 Skin, 115 Hero"
            $table->unsignedBigInteger('price'); // Harga dalam bentuk angka (integer)
            $table->unsignedBigInteger('original_price')->nullable();
            $table->string('thumbnail_url'); // URL gambar utama produk
            $table->text('description'); // Deskripsi lengkap produk
            $table->boolean('is_available')->default(true); // Status ketersediaan (true/false)
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
