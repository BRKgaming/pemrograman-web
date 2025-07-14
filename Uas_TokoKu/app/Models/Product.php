<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'original_price',
        'image',
        'stock',
        'is_featured',
        'badge',
        'specifications'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'original_price' => 'decimal:2',
        'is_featured' => 'boolean'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    /**
     * Get all categories for this product (many-to-many)
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_categories')
                    ->withPivot('is_primary')
                    ->withTimestamps();
    }
    
    /**
     * Get additional categories (excluding the primary one)
     */
    public function additionalCategories()
    {
        return $this->categories()->wherePivot('is_primary', false)->get();
    }

    public function getDiscountPercentage()
    {
        if ($this->original_price) {
            return round((($this->original_price - $this->price) / $this->original_price) * 100);
        }
        return 0;
    }

    public function getFormattedPrice()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getFormattedOriginalPrice()
    {
        if ($this->original_price) {
            return 'Rp ' . number_format($this->original_price, 0, ',', '.');
        }
        return null;
    }

    /**
     * Get inventory transactions for this product
     */
    public function inventoryTransactions()
    {
        return $this->hasMany(InventoryTransaction::class);
    }

    /**
     * Get order items for this product
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get current stock from inventory transactions
     */
    public function getCurrentStock()
    {
        $stockIn = $this->inventoryTransactions()->where('type', 'in')->sum('quantity');
        $stockOut = $this->inventoryTransactions()->where('type', 'out')->sum('quantity');
        return $stockIn - $stockOut;
    }
    
    /**
     * Get wishlists for this product
     */
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }
    
    /**
     * Check if product is in user's wishlist
     */
    public function isInWishlist($userId)
    {
        return $this->wishlists()->where('user_id', $userId)->exists();
    }
}
