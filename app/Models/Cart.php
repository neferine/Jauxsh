<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    // Helper method to get total
    public function getTotalAttribute()
    {
        return $this->cartItems->sum(function($item) {
            return $item->quantity * $item->product->price;
        });
    }

    // Helper method to get item count
    public function getItemCountAttribute()
    {
        return $this->cartItems->sum('quantity');
    }
}