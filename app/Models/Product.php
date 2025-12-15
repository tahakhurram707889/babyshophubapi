<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
   protected $fillable = [
    'name',
    'slug',
    'price',
    'description',
    'category_id',
    'stock',
    'image'
];

protected $appends = ['image_url'];

public function getImageUrlAttribute()
{
    return $this->image ? asset('storage/'.$this->image) : null;
}
public function category()
{
    return $this->belongsTo(Category::class);
}
// app/Models/Product.php
public function reviews()
{
    return $this->hasMany(Review::class);
}

public function orderItems()
{
    return $this->hasMany(OrderItem::class);
}

}
