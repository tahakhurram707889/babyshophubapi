@extends('layouts.admin')

@section('title', 'Product Reviews')

@section('styles')
<style>
    .review-card {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        margin-bottom: 25px;
        transition: all 0.3s;
        border-left: 4px solid #fbbf24;
    }

    .review-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .review-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 20px;
    }

    .review-user {
        display: flex;
        align-items: center;
    }

    .user-avatar-sm {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        margin-right: 15px;
        flex-shrink: 0;
    }

    .user-info h6 {
        margin: 0;
        font-weight: 600;
        color: #2d3748;
    }

    .user-info small {
        color: #718096;
    }

    .rating-stars {
        color: #fbbf24;
        font-size: 1.2rem;
    }

    .review-content {
        padding: 20px;
        background: #fef3c7;
        border-radius: 10px;
        margin-bottom: 20px;
        position: relative;
    }

    .review-content::before {
        content: '"';
        position: absolute;
        top: 10px;
        left: 10px;
        font-size: 4rem;
        color: rgba(251, 191, 36, 0.2);
        font-family: serif;
        line-height: 1;
    }

    .review-text {
        position: relative;
        z-index: 1;
        font-style: italic;
        color: #92400e;
        line-height: 1.6;
    }

    .review-product {
        display: flex;
        align-items: center;
        padding: 15px;
        background: #f7fafc;
        border-radius: 10px;
        margin-bottom: 15px;
    }

    .product-image {
        width: 60px;
        height: 60px;
        border-radius: 10px;
        overflow: hidden;
        margin-right: 15px;
        flex-shrink: 0;
        background: #e9ecef;
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
        font-size: 1.5rem;
        color: #cbd5e0;
    }

    .product-info {
        flex-grow: 1;
    }

    .product-name {
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 5px;
    }

    .product-category {
        font-size: 0.85rem;
        color: #718096;
    }

    .review-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 15px;
        border-top: 1px solid #e9ecef;
    }

    .review-date {
        font-size: 0.85rem;
        color: #718096;
    }

    .review-actions {
        display: flex;
        gap: 10px;
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
        background: #f7fafc;
        border-radius: 10px;
    }

    .stat-value {
        font-size: 1.8rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 5px;
    }

    .stat-label {
        font-size: 0.85rem;
        color: #718096;
    }

    .rating-distribution {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        margin-bottom: 25px;
    }

    .rating-bar {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }

    .rating-label {
        width: 100px;
        font-weight: 500;
        color: #2d3748;
    }

    .rating-progress {
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

    .rating-count {
        width: 60px;
        text-align: right;
        font-size: 0.9rem;
        color: #4a5568;
    }

    .summary-card {
        background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
        color: white;
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 25px;
    }

    .summary-title {
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        opacity: 0.9;
        margin-bottom: 10px;
    }

    .summary-value {
        font-size: 2.2rem;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .summary-change {
        font-size: 0.85rem;
        opacity: 0.9;
    }

    .average-rating {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        margin-top: 10px;
    }

    .average-value {
        font-size: 2.5rem;
        font-weight: 700;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-state-icon {
        font-size: 4rem;
        color: #cbd5e0;
        margin-bottom: 20px;
    }

    .filter-section {
        background: white;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        margin-bottom: 25px;
    }

    .review-status {
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 500;
        display: inline-block;
    }

    .status-published {
        background: rgba(34, 197, 94, 0.1);
        color: #22c55e;
    }

    .status-pending {
        background: rgba(251, 191, 36, 0.1);
        color: #f59e0b;
    }

    .status-spam {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="header-title">Product Reviews</h1>
            <p class="text-muted mb-0">Manage customer reviews and ratings</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-primary" onclick="exportReviews()">
                <i class="bi bi-download me-2"></i> Export
            </button>
            <button class="btn btn-primary" onclick="syncReviews()">
                <i class="bi bi-arrow-clockwise me-2"></i> Sync Reviews
            </button>
        </div>
    </div>

    <!-- Summary Stats -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="summary-card">
                <div class="summary-title">Total Reviews</div>
                <div class="summary-value">{{ $totalReviews }}</div>
                <div class="summary-change">
                    <i class="bi bi-star me-1"></i> {{ $recentReviews->count() }} new this month
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="summary-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <div class="summary-title">Average Rating</div>
                <div class="summary-value">{{ number_format($averageRating, 1) }}/5</div>
                <div class="average-rating">
                    <div class="rating-stars">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= floor($averageRating))
                                <i class="bi bi-star-fill"></i>
                            @elseif($i <= ceil($averageRating))
                                <i class="bi bi-star-half"></i>
                            @else
                                <i class="bi bi-star"></i>
                            @endif
                        @endfor
                    </div>
                    <span class="average-value">{{ number_format($averageRating, 1) }}</span>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="summary-card" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                <div class="summary-title">5 Star Reviews</div>
                <div class="summary-value">
                    @php
                        $fiveStarCount = $ratingDistribution->where('rating', 5)->first()->count ?? 0;
                    @endphp
                    {{ $fiveStarCount }}
                </div>
                <div class="summary-change">
                    {{ $totalReviews > 0 ? number_format(($fiveStarCount / $totalReviews) * 100, 1) : 0 }}% of total
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="summary-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <div class="summary-title">Today's Reviews</div>
                <div class="summary-value">
                    {{ \App\Models\Review::whereDate('created_at', today())->count() }}
                </div>
                <div class="summary-change">
                    <i class="bi bi-arrow-up-right me-1"></i> Keep it up!
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Left Column - Reviews List -->
        <div class="col-lg-8">
            <!-- Filters -->
            <div class="filter-section">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Search Reviews</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text" class="form-control" placeholder="Search reviews..." id="reviewSearch">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Rating</label>
                        <select class="form-select" id="ratingFilter">
                            <option value="">All Ratings</option>
                            <option value="5">5 Stars</option>
                            <option value="4">4 Stars</option>
                            <option value="3">3 Stars</option>
                            <option value="2">2 Stars</option>
                            <option value="1">1 Star</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" id="statusFilter">
                            <option value="">All Status</option>
                            <option value="published">Published</option>
                            <option value="pending">Pending</option>
                            <option value="spam">Spam</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button class="btn btn-primary w-100" onclick="applyReviewFilters()">
                            <i class="bi bi-filter me-2"></i> Filter
                        </button>
                    </div>
                </div>
            </div>

            <!-- Reviews List -->
            @if($reviews->count() > 0)
                @foreach($reviews as $review)
                <div class="review-card">
                    <!-- Review Header -->
                    <div class="review-header">
                        <div class="review-user">
                            <div class="user-avatar-sm">
                                {{ strtoupper(substr($review->user->name ?? 'U', 0, 1)) }}
                            </div>
                            <div class="user-info">
                                <h6>{{ $review->user->name ?? 'Unknown User' }}</h6>
                                <small>{{ $review->user->email ?? 'No email' }}</small>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="rating-stars mb-2">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->rating)
                                        <i class="bi bi-star-fill"></i>
                                    @else
                                        <i class="bi bi-star"></i>
                                    @endif
                                @endfor
                                <span class="ms-2 fw-bold">{{ $review->rating }}/5</span>
                            </div>
                            <span class="review-status status-published">
                                <i class="bi bi-check-circle me-1"></i> Published
                            </span>
                        </div>
                    </div>

                    <!-- Product Info -->
                    @if($review->product)
                    <div class="review-product">
                        <div class="product-image">
                            @if($review->product->image)
                                <img src="{{ asset('storage/' . $review->product->image) }}" 
                                     alt="{{ $review->product->name }}">
                            @else
                                <i class="bi bi-box"></i>
                            @endif
                        </div>
                        <div class="product-info">
                            <div class="product-name">{{ $review->product->name }}</div>
                            <div class="product-category">{{ $review->product->category->name ?? 'N/A' }}</div>
                        </div>
                        <div class="text-end">
                            <div class="fw-bold">${{ number_format($review->product->price, 2) }}</div>
                            <small class="text-muted">{{ $review->product->stock }} in stock</small>
                        </div>
                    </div>
                    @endif

                    <!-- Review Content -->
                    <div class="review-content">
                        <div class="review-text">
                            {{ $review->review ?? 'No review text provided.' }}
                        </div>
                    </div>

                    <!-- Review Stats -->
                    <div class="stats-grid">
                        <div class="stat-box">
                            <div class="stat-value">
                                {{ $review->user->reviews()->count() ?? 0 }}
                            </div>
                            <div class="stat-label">User Reviews</div>
                        </div>
                        <div class="stat-box">
                            <div class="stat-value">
                                {{ $review->product->reviews()->count() ?? 0 }}
                            </div>
                            <div class="stat-label">Product Reviews</div>
                        </div>
                    </div>

                    <!-- Review Meta & Actions -->
                    <div class="review-meta">
                        <div class="review-date">
                            <i class="bi bi-calendar me-1"></i>
                            {{ $review->created_at->format('F d, Y • h:i A') }}
                        </div>
                        <div class="review-actions">
                            <a href="{{ route('admin.reviews.show', $review->id) }}" 
                               class="btn btn-sm btn-primary">
                                <i class="bi bi-eye me-1"></i> View
                            </a>
                            <button class="btn btn-sm btn-outline-success" onclick="approveReview({{ $review->id }})">
                                <i class="bi bi-check-circle me-1"></i> Approve
                            </button>
                            <button class="btn btn-sm btn-outline-warning" onclick="editReview({{ $review->id }})">
                                <i class="bi bi-pencil me-1"></i> Edit
                            </button>
                            <form action="{{ route('admin.reviews.destroy', $review->id) }}" 
                                  method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" 
                                        onclick="return confirm('Delete this review?')">
                                    <i class="bi bi-trash me-1"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach

                <!-- Pagination -->
                @if($reviews->hasPages())
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted">
                                Showing {{ $reviews->firstItem() }} to {{ $reviews->lastItem() }} of {{ $reviews->total() }} reviews
                            </div>
                            <div>
                                {{ $reviews->links() }}
                            </div>
                        </div>
                    </div>
                </div>
                @endif

            @else
            <!-- Empty State -->
            <div class="card">
                <div class="card-body">
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="bi bi-star"></i>
                        </div>
                        <h4>No Reviews Found</h4>
                        <p class="text-muted">There are no product reviews in the system yet.</p>
                        <button class="btn btn-primary" onclick="syncReviews()">
                            <i class="bi bi-arrow-clockwise me-2"></i> Check for New Reviews
                        </button>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Right Column - Rating Stats -->
        <div class="col-lg-4">
            <!-- Rating Distribution -->
            <div class="rating-distribution">
                <h5 class="mb-4">Rating Distribution</h5>
                @if($ratingDistribution->count() > 0)
                    @foreach($ratingDistribution as $rating)
                    <div class="rating-bar">
                        <div class="rating-label">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $rating->rating)
                                    <i class="bi bi-star-fill text-warning"></i>
                                @else
                                    <i class="bi bi-star text-muted"></i>
                                @endif
                            @endfor
                        </div>
                        <div class="rating-progress">
                            <div class="rating-fill" 
                                 style="width: {{ $rating->percentage }}%">
                            </div>
                        </div>
                        <div class="rating-count">
                            {{ $rating->count }} ({{ $rating->percentage }}%)
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-bar-chart text-muted" style="font-size: 2rem;"></i>
                        <p class="text-muted mt-2">No rating data available</p>
                    </div>
                @endif
            </div>

            <!-- Recent Reviews -->
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-4">Recent Reviews</h5>
                    @if($recentReviews->count() > 0)
                        @foreach($recentReviews as $review)
                        <div class="border-bottom pb-3 mb-3">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h6 class="mb-1">{{ $review->user_name ?? 'User' }}</h6>
                                    <div class="rating-stars small">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating)
                                                <i class="bi bi-star-fill"></i>
                                            @else
                                                <i class="bi bi-star"></i>
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($review->created_at)->diffForHumans() }}</small>
                            </div>
                            <p class="mb-0 small text-truncate">{{ Str::limit($review->review, 50) }}</p>
                            <small class="text-muted">on {{ $review->product_name }}</small>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center py-3">
                            <p class="text-muted">No recent reviews</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Review Insights -->
            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="mb-4">Review Insights</h5>
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Review Response Rate</span>
                            <span class="fw-bold">65%</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-success" style="width: 65%"></div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Average Response Time</span>
                            <span class="fw-bold">12 hours</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-warning" style="width: 60%"></div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h6>Top Reviewed Products</h6>
                        <div class="list-group list-group-flush">
                            <!-- Add top products here -->
                            <div class="list-group-item px-0">
                                <div class="d-flex justify-content-between">
                                    <span>Baby Stroller Pro</span>
                                    <span class="badge bg-primary">42 reviews</span>
                                </div>
                            </div>
                            <div class="list-group-item px-0">
                                <div class="d-flex justify-content-between">
                                    <span>Organic Baby Food</span>
                                    <span class="badge bg-primary">38 reviews</span>
                                </div>
                            </div>
                            <div class="list-group-item px-0">
                                <div class="d-flex justify-content-between">
                                    <span>Baby Monitor</span>
                                    <span class="badge bg-primary">35 reviews</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="mb-4">Quick Actions</h5>
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-primary" onclick="exportReviews()">
                            <i class="bi bi-download me-2"></i> Export Reviews
                        </button>
                        <button class="btn btn-outline-success" onclick="approveAllPending()">
                            <i class="bi bi-check-circle me-2"></i> Approve All Pending
                        </button>
                        <button class="btn btn-outline-warning" onclick="checkSpam()">
                            <i class="bi bi-shield-exclamation me-2"></i> Check for Spam
                        </button>
                        <button class="btn btn-outline-info" onclick="generateReport()">
                            <i class="bi bi-file-earmark-text me-2"></i> Generate Report
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
function exportReviews() {
    alert('Export feature coming soon!');
}

function syncReviews() {
    if (confirm('Sync reviews from external sources?')) {
        alert('Review sync process started!');
    }
}

function applyReviewFilters() {
    const search = document.getElementById('reviewSearch').value;
    const rating = document.getElementById('ratingFilter').value;
    const status = document.getElementById('statusFilter').value;
    
    console.log('Applying review filters:', { search, rating, status });
    // Implement filter logic
}

function approveReview(reviewId) {
    if (confirm('Approve this review?')) {
        console.log('Approving review:', reviewId);
        alert('Review approved!');
    }
}

function editReview(reviewId) {
    console.log('Editing review:', reviewId);
    alert('Edit feature will be implemented soon!');
}

function approveAllPending() {
    if (confirm('Approve all pending reviews?')) {
        alert('All pending reviews will be approved!');
    }
}

function checkSpam() {
    if (confirm('Check for spam reviews?')) {
        alert('Spam check process started!');
    }
}

function generateReport() {
    alert('Report generation feature coming soon!');
}
</script>
@endsection