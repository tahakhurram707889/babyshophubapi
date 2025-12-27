@extends('layouts.admin')

@section('title', 'Review Details')

@section('styles')
<style>
    .review-header {
        background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
        border-radius: 15px;
        padding: 25px;
        color: white;
        margin-bottom: 25px;
        position: relative;
        overflow: hidden;
    }

    .review-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.1);
    }

    .review-user-info {
        position: relative;
        z-index: 1;
    }

    .user-avatar-lg {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: rgba(255,255,255,0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        font-weight: 700;
        color: white;
        border: 4px solid rgba(255,255,255,0.3);
        margin-right: 20px;
        flex-shrink: 0;
    }

    .rating-badge {
        padding: 10px 20px;
        background: rgba(255,255,255,0.2);
        border-radius: 20px;
        font-size: 1.2rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        margin-top: 10px;
    }

    .review-content-card {
        background: white;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        margin-bottom: 25px;
        position: relative;
    }

    .review-content-card::before {
        content: '"';
        position: absolute;
        top: 20px;
        left: 20px;
        font-size: 6rem;
        color: rgba(251, 191, 36, 0.1);
        font-family: serif;
        line-height: 1;
    }

    .review-text {
        position: relative;
        z-index: 1;
        font-size: 1.1rem;
        line-height: 1.8;
        color: #4a5568;
        font-style: italic;
        padding: 20px 0;
    }

    .product-card {
        background: #fef3c7;
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
    }

    .product-image {
        width: 100px;
        height: 100px;
        border-radius: 10px;
        overflow: hidden;
        margin-right: 20px;
        flex-shrink: 0;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .product-image i {
        font-size: 2rem;
        color: #fbbf24;
    }

    .product-details {
        flex-grow: 1;
    }

    .product-name {
        font-size: 1.5rem;
        font-weight: 700;
        color: #92400e;
        margin-bottom: 5px;
    }

    .product-category {
        color: #b45309;
        margin-bottom: 10px;
    }

    .product-price {
        font-size: 1.3rem;
        font-weight: 700;
        color: #92400e;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
        margin-top: 20px;
    }

    .stat-box {
        text-align: center;
        padding: 15px;
        background: rgba(251, 191, 36, 0.1);
        border-radius: 10px;
        border: 1px solid rgba(251, 191, 36, 0.2);
    }

    .stat-value {
        font-size: 1.8rem;
        font-weight: 700;
        color: #92400e;
        margin-bottom: 5px;
    }

    .stat-label {
        font-size: 0.85rem;
        color: #b45309;
    }

    .user-stats-card {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        margin-bottom: 25px;
    }

    .review-meta {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        margin-bottom: 25px;
    }

    .meta-item {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid #e9ecef;
    }

    .meta-item:last-child {
        border-bottom: none;
    }

    .meta-label {
        color: #718096;
        font-weight: 500;
    }

    .meta-value {
        color: #2d3748;
        font-weight: 600;
    }

    .action-buttons {
        display: grid;
        gap: 10px;
        margin-top: 20px;
    }

    .action-btn {
        width: 100%;
    }

    .review-timeline {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    }

    .timeline-item {
        display: flex;
        align-items: flex-start;
        margin-bottom: 20px;
        position: relative;
        padding-left: 30px;
    }

    .timeline-item:last-child {
        margin-bottom: 0;
    }

    .timeline-icon {
        position: absolute;
        left: 0;
        top: 0;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: #fbbf24;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.8rem;
    }

    .timeline-content {
        flex-grow: 1;
    }

    .timeline-title {
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 5px;
    }

    .timeline-time {
        font-size: 0.85rem;
        color: #718096;
    }

    .rating-breakdown {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    }

    .rating-item {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }

    .rating-label {
        width: 120px;
        font-weight: 500;
        color: #2d3748;
    }

    .rating-bar {
        flex-grow: 1;
        height: 8px;
        background: #e9ecef;
        border-radius: 4px;
        overflow: hidden;
        margin: 0 15px;
    }

    .rating-fill {
        height: 100%;
        background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
        border-radius: 4px;
    }

    .rating-value {
        width: 60px;
        text-align: right;
        font-weight: 600;
        color: #4a5568;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    
    <!-- Back Button -->
    <div class="mb-4">
        <a href="{{ route('admin.reviews.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i> Back to Reviews
        </a>
    </div>

    <!-- Review Header -->
    <div class="review-header">
        <div class="d-flex align-items-center review-user-info">
            <div class="user-avatar-lg">
                {{ strtoupper(substr($review->user->name ?? 'U', 0, 1)) }}
            </div>
            <div>
                <h2 class="mb-1">{{ $review->user->name ?? 'Unknown User' }}</h2>
                <p class="mb-0 opacity-75">{{ $review->user->email ?? 'No email' }}</p>
                
                <div class="rating-badge">
                    <div class="rating-stars">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $review->rating)
                                <i class="bi bi-star-fill"></i>
                            @else
                                <i class="bi bi-star"></i>
                            @endif
                        @endfor
                    </div>
                    <span>{{ $review->rating }}/5 Rating</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Left Column - Review Content -->
        <div class="col-lg-8">
            <!-- Review Content -->
            <div class="review-content-card">
                <div class="review-text">
                    {{ $review->review ?? 'No review text provided.' }}
                </div>
            </div>

            <!-- Product Information -->
            @if($review->product)
            <div class="product-card">
                <div class="product-image">
                    @if($review->product->image)
                        <img src="{{ asset('storage/' . $review->product->image) }}" 
                             alt="{{ $review->product->name }}">
                    @else
                        <i class="bi bi-box"></i>
                    @endif
                </div>
                <div class="product-details">
                    <div class="product-name">{{ $review->product->name }}</div>
                    <div class="product-category">{{ $review->product->category->name ?? 'N/A' }}</div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="product-price">${{ number_format($review->product->price, 2) }}</div>
                        <div>
                            <span class="badge bg-{{ $review->product->stock > 10 ? 'success' : ($review->product->stock > 0 ? 'warning' : 'danger') }}">
                                {{ $review->product->stock }} in stock
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Review Stats -->
            <div class="stats-grid">
                <div class="stat-box">
                    <div class="stat-value">{{ $productReviewsCount }}</div>
                    <div class="stat-label">Total Reviews for Product</div>
                </div>
                <div class="stat-box">
                    <div class="stat-value">{{ number_format($productAverageRating, 1) }}/5</div>
                    <div class="stat-label">Product Average Rating</div>
                </div>
                <div class="stat-box">
                    <div class="stat-value">{{ $userReviewsCount }}</div>
                    <div class="stat-label">User's Total Reviews</div>
                </div>
                <div class="stat-box">
                    <div class="stat-value">
                        @php
                            $productAvg = $productAverageRating ?? 0;
                            $difference = $review->rating - $productAvg;
                        @endphp
                        {{ $difference >= 0 ? '+' : '' }}{{ number_format($difference, 1) }}
                    </div>
                    <div class="stat-label">vs Product Average</div>
                </div>
            </div>
            @endif

            <!-- Review Timeline -->
            <div class="review-timeline mt-4">
                <h5 class="mb-4">Review Timeline</h5>
                <div class="timeline-item">
                    <div class="timeline-icon">
                        <i class="bi bi-plus"></i>
                    </div>
                    <div class="timeline-content">
                        <div class="timeline-title">Review Submitted</div>
                        <div class="timeline-time">{{ $review->created_at->format('F d, Y • h:i A') }}</div>
                    </div>
                </div>
                
                <div class="timeline-item">
                    <div class="timeline-icon">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <div class="timeline-content">
                        <div class="timeline-title">Review Published</div>
                        <div class="timeline-time">{{ $review->created_at->format('F d, Y • h:i A') }}</div>
                    </div>
                </div>
                
                <div class="timeline-item">
                    <div class="timeline-icon">
                        <i class="bi bi-clock"></i>
                    </div>
                    <div class="timeline-content">
                        <div class="timeline-title">Last Updated</div>
                        <div class="timeline-time">{{ $review->updated_at->diffForHumans() }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Meta & Actions -->
        <div class="col-lg-4">
            <!-- Review Metadata -->
            <div class="review-meta">
                <h5 class="mb-4">Review Details</h5>
                <div class="meta-item">
                    <span class="meta-label">Review ID</span>
                    <span class="meta-value">#{{ $review->id }}</span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Status</span>
                    <span class="meta-value">
                        <span class="badge bg-success">Published</span>
                    </span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Product ID</span>
                    <span class="meta-value">#{{ $review->product_id }}</span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">User ID</span>
                    <span class="meta-value">#{{ $review->user_id }}</span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Submitted Date</span>
                    <span class="meta-value">{{ $review->created_at->format('M d, Y') }}</span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Submitted Time</span>
                    <span class="meta-value">{{ $review->created_at->format('h:i A') }}</span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Helpful Votes</span>
                    <span class="meta-value">24</span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Report Count</span>
                    <span class="meta-value">0</span>
                </div>
            </div>

            <!-- User Statistics -->
            @if($review->user)
            <div class="user-stats-card">
                <h5 class="mb-4">User Statistics</h5>
                <div class="stats-grid">
                    <div class="stat-box">
                        <div class="stat-value">{{ $userReviewsCount }}</div>
                        <div class="stat-label">Total Reviews</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-value">
                            @php
                                $userAvgRating = $review->user->reviews()->avg('rating') ?? 0;
                            @endphp
                            {{ number_format($userAvgRating, 1) }}
                        </div>
                        <div class="stat-label">Avg Rating</div>
                    </div>
                </div>

                <div class="mt-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Review Frequency</span>
                        <span class="fw-bold">
                            @if($userReviewsCount > 0)
                                {{ number_format(30 / $userReviewsCount, 1) }} days/review
                            @else
                                N/A
                            @endif
                        </span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-warning" 
                             style="width: {{ min($userReviewsCount * 20, 100) }}%">
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Rating Breakdown -->
            <div class="rating-breakdown">
                <h5 class="mb-4">Product Rating Breakdown</h5>
                @for($i = 5; $i >= 1; $i--)
                <div class="rating-item">
                    <div class="rating-label">
                        @for($j = 1; $j <= 5; $j++)
                            @if($j <= $i)
                                <i class="bi bi-star-fill text-warning"></i>
                            @else
                                <i class="bi bi-star text-muted"></i>
                            @endif
                        @endfor
                    </div>
                    <div class="rating-bar">
                        <div class="rating-fill" 
                             style="width: {{ $i == $review->rating ? '100' : '0' }}%">
                        </div>
                    </div>
                    <div class="rating-value">
                        @if($i == $review->rating)
                            This Review
                        @else
                            -
                        @endif
                    </div>
                </div>
                @endfor
            </div>

            <!-- Quick Actions -->
            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="mb-4">Review Actions</h5>
                    <div class="action-buttons">
                        @if($review->user)
                        <a href="{{ route('admin.users.show', $review->user_id) }}" 
                           class="btn btn-outline-primary action-btn">
                            <i class="bi bi-person me-2"></i> View User Profile
                        </a>
                        @endif
                        
                        @if($review->product)
                        <a href="{{ route('admin.products.edit', $review->product_id) }}" 
                           class="btn btn-outline-info action-btn">
                            <i class="bi bi-box me-2"></i> View Product
                        </a>
                        @endif
                        
                        <button class="btn btn-outline-success action-btn" onclick="approveReview()">
                            <i class="bi bi-check-circle me-2"></i> Approve Review
                        </button>
                        
                        <button class="btn btn-outline-warning action-btn" onclick="featureReview()">
                            <i class="bi bi-star me-2"></i> Feature Review
                        </button>
                        
                        <button class="btn btn-outline-danger action-btn" onclick="reportReview()">
                            <i class="bi bi-flag me-2"></i> Report as Spam
                        </button>
                        
                        <form action="{{ route('admin.reviews.destroy', $review->id) }}" 
                              method="POST" class="d-grid">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger action-btn" 
                                    onclick="return confirm('Delete this review? This action cannot be undone.')">
                                <i class="bi bi-trash me-2"></i> Delete Review
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Admin Response -->
            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="mb-4">Admin Response</h5>
                    <textarea class="form-control" rows="4" placeholder="Write a response to this review..."></textarea>
                    <button class="btn btn-sm btn-primary mt-3 w-100">Post Response</button>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
function approveReview() {
    if (confirm('Approve this review?')) {
        alert('Review approved!');
    }
}

function featureReview() {
    if (confirm('Feature this review on the product page?')) {
        alert('Review featured!');
    }
}

function reportReview() {
    if (confirm('Report this review as spam?')) {
        alert('Review reported as spam!');
    }
}
</script>
@endsection