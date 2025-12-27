<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewRequest;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // Get reviews for a specific product (PUBLIC)
    public function productReviews($product_id)
    {
        try {
            $reviews = Review::with(['user:id,name'])
                ->where('product_id', $product_id)
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($review) {
                    return [
                        'id' => $review->id,
                        'user_id' => $review->user_id,
                        'user_name' => $review->user->name ?? 'Anonymous',
                        'product_id' => $review->product_id,
                        'rating' => $review->rating,
                        'review' => $review->review,
                        'comment' => $review->review, // Backward compatibility
                        'created_at' => $review->created_at->toISOString(),
                        'updated_at' => $review->updated_at->toISOString(),
                    ];
                });

            $averageRating = Review::where('product_id', $product_id)->avg('rating');
            $totalReviews = Review::where('product_id', $product_id)->count();

            return response()->json([
                'status' => true,
                'average_rating' => round($averageRating, 1) ?? 0,
                'total_reviews' => $totalReviews,
                'reviews' => $reviews
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to load reviews: ' . $e->getMessage()
            ], 500);
        }
    }

    // Add new review (PROTECTED)
    public function store(ReviewRequest $request)
    {
        try {
            // Check for duplicate review
            $existingReview = Review::where('user_id', $request->user()->id)
                ->where('product_id', $request->product_id)
                ->first();
                
            if ($existingReview) {
                return response()->json([
                    'status' => false,
                    'message' => 'You have already reviewed this product. You can update your existing review.',
                    'existing_review_id' => $existingReview->id
                ], 409);
            }

            $review = Review::create([
                'user_id' => $request->user()->id,
                'product_id' => $request->product_id,
                'rating' => $request->rating,
                'review' => $request->review,
            ]);

            $review->load(['user:id,name']);

            return response()->json([
                'status' => true,
                'message' => 'Review added successfully',
                'review' => [
                    'id' => $review->id,
                    'user_id' => $review->user_id,
                    'user_name' => $review->user->name ?? 'Anonymous',
                    'product_id' => $review->product_id,
                    'rating' => $review->rating,
                    'review' => $review->review,
                    'comment' => $review->review,
                    'created_at' => $review->created_at->toISOString(),
                    'updated_at' => $review->updated_at->toISOString(),
                ]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to add review: ' . $e->getMessage()
            ], 500);
        }
    }

    // Get user's reviews (PROTECTED)
    public function userReviews(Request $request)
    {
        try {
            $user = $request->user();
            
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            $reviews = Review::with(['product:id,name'])
                ->where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($review) use ($user) {
                    return [
                        'id' => $review->id,
                        'user_id' => $review->user_id,
                        'user_name' => $user->name ?? 'You',
                        'product_id' => $review->product_id,
                        'product_name' => $review->product->name ?? 'Unknown Product',
                        'rating' => $review->rating,
                        'review' => $review->review,
                        'comment' => $review->review,
                        'created_at' => $review->created_at->toISOString(),
                        'updated_at' => $review->updated_at->toISOString(),
                    ];
                });

            return response()->json([
                'status' => true,
                'reviews' => $reviews
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to load user reviews: ' . $e->getMessage()
            ], 500);
        }
    }

    // Update review (PROTECTED)
    public function update(ReviewRequest $request, $id)
    {
        try {
            $review = Review::findOrFail($id);
            
            // Authorization check
            if ($review->user_id !== $request->user()->id) {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthorized to update this review'
                ], 403);
            }

            $review->update([
                'rating' => $request->rating,
                'review' => $request->review,
            ]);

            $review->load(['user:id,name']);

            return response()->json([
                'status' => true,
                'message' => 'Review updated successfully',
                'review' => [
                    'id' => $review->id,
                    'user_id' => $review->user_id,
                    'user_name' => $review->user->name ?? 'Anonymous',
                    'product_id' => $review->product_id,
                    'rating' => $review->rating,
                    'review' => $review->review,
                    'comment' => $review->review,
                    'created_at' => $review->created_at->toISOString(),
                    'updated_at' => $review->updated_at->toISOString(),
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to update review: ' . $e->getMessage()
            ], 500);
        }
    }

    // Delete review (PROTECTED)
    public function destroy(Request $request, $id)
    {
        try {
            $review = Review::findOrFail($id);
            
            // Authorization check
            if ($review->user_id !== $request->user()->id) {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthorized to delete this review'
                ], 403);
            }

            $review->delete();

            return response()->json([
                'status' => true,
                'message' => 'Review deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to delete review: ' . $e->getMessage()
            ], 500);
        }
    }

    // Get user's review for a specific product (PROTECTED)
    public function userProductReview(Request $request, $product_id)
    {
        try {
            $user = $request->user();
            
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            $review = Review::with(['user:id,name'])
                ->where('user_id', $user->id)
                ->where('product_id', $product_id)
                ->first();

            if (!$review) {
                return response()->json([
                    'status' => false,
                    'message' => 'No review found for this product',
                    'has_review' => false
                ], 404);
            }

            return response()->json([
                'status' => true,
                'has_review' => true,
                'review' => [
                    'id' => $review->id,
                    'user_id' => $review->user_id,
                    'user_name' => $review->user->name ?? 'You',
                    'product_id' => $review->product_id,
                    'rating' => $review->rating,
                    'review' => $review->review,
                    'comment' => $review->review,
                    'created_at' => $review->created_at->toISOString(),
                    'updated_at' => $review->updated_at->toISOString(),
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to load user review: ' . $e->getMessage()
            ], 500);
        }
    }
}