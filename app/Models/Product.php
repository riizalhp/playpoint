<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_id',
        'name',
        'slug',
        'short_specs',
        'price',
        'original_price',
        'thumbnail_url',
        'gallery',
        'description',
        'is_available',
    ];
    
    protected $casts = [
        'gallery' => 'array',
    ];

    /**
     * Menggunakan 'slug' sebagai kunci rute, bukan 'id'.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}
