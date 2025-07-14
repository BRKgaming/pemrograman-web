<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
    
    /**
     * Get all products through the product_categories table (many-to-many)
     */
    public function allProducts()
    {
        return $this->belongsToMany(Product::class, 'product_categories')
                    ->withPivot('is_primary')
                    ->withTimestamps();
    }
}
