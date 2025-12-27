<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_amount',
        'status',
        'payment_status',
    ];

    // An order belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // An order has many order items
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

     public function getCustomerAddressAttribute()
    {
        if ($this->user && $this->user->address) {
            return $this->user->address;
        }
        return null;
    }
    
    // Get phone through user
    public function getCustomerPhoneAttribute()
    {
        if ($this->user && $this->user->address) {
            return $this->user->address->phone;
        }
        return null;
    }
}
