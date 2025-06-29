<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'game_id',
        'name',
        'slug',
        'short_specs',
        'price',
        'thumbnail_url',
        'description',
        'is_available',
    ];
    
    /**
     * Mendefinisikan relasi bahwa satu Produk milik satu Game.
     */
    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}
