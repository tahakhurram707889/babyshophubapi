<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;
    
     protected $fillable = ['cart_id', 'product_id', 'quantity'];

    // Relation: CartItem belongs to Cart
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    // Relation: CartItem belongs to Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
