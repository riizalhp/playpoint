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
        Schema::create('consignments', function (Blueprint $table) {
            $table->id();
            $table->string('game_name');
            $table->string('seller_name');
            $table->string('contact_whatsapp');
            $table->string('contact_whatsapp_optional')->nullable();
            $table->string('province');
            $table->string('city');
            $table->text('address');
            $table->string('postal_code');
            $table->string('email');
            $table->text('account_details');
            $table->json('account_images')->nullable();
            $table->unsignedBigInteger('price_low');
            $table->unsignedBigInteger('price_high');
            $table->string('status')->default('pending'); // pending, approved, rejected
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consignments');
    }
};
