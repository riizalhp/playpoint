<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_name',
        'contact_whatsapp',
        'contact_whatsapp_optional',
        'province',
        'city',
        'address',
        'postal_code',
        'email',
        'game_name',
        'account_details',
        'account_images',
        // PERUBAHAN: Ganti kolom harga
        'price_low',
        'price_high',
        'status',
        'admin_notes',
    ];

    /**
     * PERUBAHAN: Tambahkan casts untuk gambar
     */
    protected $casts = [
        'account_images' => 'array',
    ];
}
