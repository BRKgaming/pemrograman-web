<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'type',
        'quantity',
        'price',
        'notes',
    ];

    /**
     * Get the product that owns the inventory transaction
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the user that owns the inventory transaction
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope for in transactions
     */
    public function scopeIn($query)
    {
        return $query->where('type', 'in');
    }

    /**
     * Scope for out transactions
     */
    public function scopeOut($query)
    {
        return $query->where('type', 'out');
    }
}
