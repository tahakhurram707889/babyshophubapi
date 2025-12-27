<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with(['user', 'product'])
            ->latest()
            ->paginate(15);
            
        $totalReviews = Review::count();
        $averageRating = Review::avg('rating') ?? 0;
        
        // Rating distribution
        $ratingDistribution = Review::selectRaw('
            rating,
            COUNT(*) as count,
            ROUND(COUNT(*) * 100.0 / (SELECT COUNT(*) FROM product_reviews), 2) as percentage
        ')
        ->groupBy('rating')
        ->orderBy('rating', 'desc')
        ->get();
        
        // Recent reviews
        $recentReviews = Review::with('user')
            ->latest()
            ->take(5)
            ->get();
        
        return view('admin.reviews.index', compact(
            'reviews', 
            'totalReviews', 
            'averageRating', 
            'ratingDistribution',
            'recentReviews'
        ));
    }
    
    public function show($id)
    {
        $review = Review::with(['user', 'product.category'])
            ->findOrFail($id);
            
        $userReviewsCount = $review->user->reviews()->count();
        $productReviewsCount = $review->product->reviews()->count();
        $productAverageRating = $review->product->reviews()->avg('rating') ?? 0;
        
        return view('admin.reviews.show', compact(
            'review', 
            'userReviewsCount', 
            'productReviewsCount', 
            'productAverageRating'
        ));
    }
    
    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();
        
        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review deleted successfully.');
    }
}