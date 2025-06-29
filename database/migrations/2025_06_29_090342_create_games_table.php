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
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama game, contoh: "Mobile Legends"
            $table->string('slug')->unique(); // Untuk URL, contoh: "mobile-legends"
            $table->string('thumbnail_url'); // URL untuk gambar/thumbnail game
            $table->text('description')->nullable(); // Deskripsi singkat game
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
