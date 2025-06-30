<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'thumbnail_url',
        'description',
    ];

    /**
     * Mendefinisikan relasi bahwa satu Game memiliki banyak Product.
     * * <-- TAMBAHKAN FUNGSI INI
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}