<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'category_id',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function collections()
    {
        return $this->belongsToMany(Collection::class, 'collection_product')
                    ->withPivot('sort_order')
                    ->withTimestamps();
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Accessors
    public function getPrimaryImageAttribute()
    {
        return $this->images->first();
    }

    public function getHasVariantsAttribute()
    {
        return $this->variants()->count() > 0;
    }

    public function getAvailableSizesAttribute()
    {
        return $this->variants()->whereNotNull('size')
                    ->where('stock', '>', 0)
                    ->pluck('size')
                    ->unique()
                    ->values();
    }

    public function getAvailableColorsAttribute()
    {
        return $this->variants()->whereNotNull('color')
                    ->where('stock', '>', 0)
                    ->select('color', 'color_hex')
                    ->distinct()
                    ->get();
    }

    // Check total stock (base + variants)
    public function getTotalStockAttribute()
    {
        if ($this->has_variants) {
            return $this->variants()->sum('stock');
        }
        return $this->stock;
    }
}