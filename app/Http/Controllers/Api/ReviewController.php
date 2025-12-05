<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewRequest;
use App\Models\Review;

class ReviewController extends Controller
{
    // ⭐ Add Review (using ReviewRequest)
    public function store(ReviewRequest $request)
    {
        $review = Review::create([
            'user_id'    => $request->user()->id,
            'product_id' => $request->product_id,
            'rating'     => $request->rating,
            'comment'    => $request->comment,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Review added successfully',
            'review' => $review
        ], 201);
    }

    // ⭐ Get Reviews for a Product
    public function productReviews($product_id)
    {
        $reviews = Review::with('user')
            ->where('product_id', $product_id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'reviews' => $reviews
        ]);
    }
}
