<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'product_id',
        'product_variant_id',
        'quantity',
    ];

    protected $casts = [
        'quantity' => 'integer',
    ];

    // Relationships
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

    // Helper methods
    public function getSubtotalAttribute()
    {
        $price = $this->variant 
                 ? $this->variant->final_price 
                 : $this->product->price;
        
        return $this->quantity * $price;
    }

    public function getDisplayNameAttribute()
    {
        return $this->variant 
               ? $this->variant->display_name 
               : $this->product->name;
    }
}