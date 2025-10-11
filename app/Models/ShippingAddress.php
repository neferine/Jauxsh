<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'address_line1',
        'address_line2',
        'city',
        'postal_code',
        'country',
        'phone_number',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Helper method to get full address
    public function getFullAddressAttribute()
    {
        $address = $this->address_line1;
        
        if ($this->address_line2) {
            $address .= ', ' . $this->address_line2;
        }
        
        $address .= ', ' . $this->city . ', ' . $this->postal_code . ', ' . $this->country;
        
        return $address;
    }
}