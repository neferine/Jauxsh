<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// ============================================
// ProductVariant Model
// ============================================
class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'sku',
        'size',
        'color',
        'color_hex',
        'price_adjustment',
        'stock',
        'image_url',
    ];

    protected $casts = [
        'price_adjustment' => 'decimal:2',
        'stock' => 'integer',
    ];

    // Relationships
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Computed Properties
    public function getFinalPriceAttribute()
    {
        return $this->product->price + $this->price_adjustment;
    }

    public function getDisplayNameAttribute()
    {
        $parts = [$this->product->name];
        if ($this->color) $parts[] = $this->color;
        if ($this->size) $parts[] = $this->size;
        return implode(' - ', $parts);
    }

    public function getIsInStockAttribute()
    {
        return $this->stock > 0;
    }
}