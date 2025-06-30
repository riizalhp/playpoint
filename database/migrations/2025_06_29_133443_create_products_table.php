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
        $table->foreignId('game_id')->constrained()->onDelete('cascade');
        $table->string('name');
        $table->string('slug')->unique();
        $table->text('short_specs');
        $table->unsignedBigInteger('price'); // Harga jual
        $table->unsignedBigInteger('original_price')->nullable(); // Harga asli/coret (opsional)
        $table->string('thumbnail_url');
        $table->text('description');
        $table->boolean('is_available')->default(true);
        $table->timestamps();
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
