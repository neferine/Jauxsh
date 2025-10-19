<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_variant_id',
        'quantity',
        'price',
        'size',
        'color',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'price' => 'decimal:2',
    ];

    // Relationships
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

    // Helper method
    public function getSubtotalAttribute()
    {
        return $this->quantity * $this->price;
    }

    public function getDisplayNameAttribute()
    {
        $name = $this->product->name;
        if ($this->color) $name .= " - {$this->color}";
        if ($this->size) $name .= " - {$this->size}";
        return $name;
    }
}
