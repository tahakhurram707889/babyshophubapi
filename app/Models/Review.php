<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = 'product_reviews';
    
    protected $fillable = [
        'user_id',
        'product_id',
        'rating',
        'review', // Yeh change karein: 'comment' se 'review' mein
    ];

    // Accessor agar aapko 'comment' field access karna hai
    public function getCommentAttribute()
    {
        return $this->review;
    }

    // Mutator agar aap 'comment' field set karna chahte hain
    public function setCommentAttribute($value)
    {
        $this->attributes['review'] = $value;
    }

    // ⭐ Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}