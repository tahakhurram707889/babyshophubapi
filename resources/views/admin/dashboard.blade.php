@extends('layouts.admin')

@section('title', 'Dashboard')

@section('styles')
<style>
    .stat-card {
        position: relative;
        overflow: hidden;
        border-radius: 15px;
        padding: 25px;
        color: white;
        margin-bottom: 25px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        min-height: 180px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.15);
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 100%);
        z-index: 1;
    }

    .stat-icon {
        position: absolute;
        right: 20px;
        top: 20px;
        font-size: 3.5rem;
        opacity: 0.2;
        z-index: 1;
    }

    .stat-content {
        position: relative;
        z-index: 2;
    }

    .stat-title {
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        opacity: 0.9;
        margin-bottom: 10px;
    }

    .stat-value {
        font-size: 2.2rem;
        font-weight: 700;
        margin-bottom: 5px;
        font-family: 'Poppins', sans-serif;
    }

    .stat-change {
        font-size: 0.85rem;
        opacity: 0.9;
    }

    .stat-change.positive {
        color: #4ade80;
    }

    .stat-change.negative {
        color: #f87171;
    }

    .revenue-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .orders-card {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }

    .products-card {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }

    .users-card {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    }

    .chart-container {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        margin-bottom: 25px;
        height: 100%;
    }

    .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .chart-title {
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 1.2rem;
        color: #2d3748;
        margin: 0;
    }

    .recent-item {
        display: flex;
        align-items: center;
        padding: 15px;
        border-bottom: 1px solid #e9ecef;
        transition: background 0.3s;
    }

    .recent-item:hover {
        background: #f8f9fa;
        border-radius: 10px;
    }

    .recent-item:last-child {
        border-bottom: none;
    }

    .recent-avatar {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        margin-right: 15px;
        flex-shrink: 0;
    }

    .recent-content {
        flex-grow: 1;
    }

    .recent-title {
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 5px;
    }

    .recent-subtitle {
        font-size: 0.85rem;
        color: #718096;
    }

    .recent-meta {
        text-align: right;
        font-size: 0.85rem;
        color: #718096;
    }

    .low-stock-item {
        padding: 15px;
        border-radius: 10px;
        background: #fff5f5;
        border-left: 4px solid #f56565;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .stock-warning {
        color: #f56565;
        font-weight: 600;
    }

    .category-item {
        padding: 15px;
        border-radius: 10px;
        background: #f7fafc;
        margin-bottom: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .category-name {
        font-weight: 500;
        color: #2d3748;
    }

    .category-count {
        background: #edf2f7;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.9rem;
        color: #4a5568;
    }

    .top-product-item {
        display: flex;
        align-items: center;
        padding: 15px;
        border-radius: 10px;
        background: #f7fafc;
        margin-bottom: 10px;
        transition: transform 0.3s;
    }

    .top-product-item:hover {
        transform: translateX(5px);
    }

    .product-rank {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        background: #e9ecef;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        color: #4a5568;
        margin-right: 15px;
        flex-shrink: 0;
    }

    .product-rank.rank-1 {
        background: #fed7d7;
        color: #c53030;
    }

    .product-rank.rank-2 {
        background: #feebc8;
        color: #dd6b20;
    }

    .product-rank.rank-3 {
        background: #c6f6d5;
        color: #276749;
    }

    .product-info {
        flex-grow: 1;
    }

    .product-name {
        font-weight: 500;
        color: #2d3748;
        margin-bottom: 5px;
    }

    .product-sales {
        font-size: 0.85rem;
        color: #718096;
    }

    .product-revenue {
        font-weight: 600;
        color: #2d3748;
    }

    .quick-stats {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
        margin-top: 20px;
    }

    .quick-stat {
        text-align: center;
        padding: 15px;
        background: #f7fafc;
        border-radius: 10px;
    }

    .quick-stat-value {
        font-size: 1.5rem;
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 5px;
    }

    .quick-stat-label {
        font-size: 0.85rem;
        color: #718096;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="header-title">Dashboard Overview</h1>
            <p class="text-muted mb-0">Welcome back, {{ Auth::user()->name }}! Here's what's happening with your store.</p>
        </div>
        <div class="d-flex gap-2">
            <div class="dropdown">
                <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="bi bi-calendar me-2"></i> Last 30 Days
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">Last 7 Days</a></li>
                    <li><a class="dropdown-item" href="#">Last 30 Days</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">Last Month</a></li>
                </ul>
            </div>
            <button class="btn btn-primary">
                <i class="bi bi-download me-2"></i> Export Report
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="stat-card revenue-card">
                <div class="stat-icon">
                    <i class="bi bi-currency-dollar"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-title">Total Revenue</div>
                    <div class="stat-value">${{ number_format($totalRevenue, 2) }}</div>
                    <div class="stat-change positive">
                        <i class="bi bi-arrow-up-right me-1"></i> 12.5% from last month
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stat-card orders-card">
                <div class="stat-icon">
                    <i class="bi bi-cart"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-title">Total Orders</div>
                    <div class="stat-value">{{ $totalOrders }}</div>
                    <div class="stat-change positive">
                        <i class="bi bi-arrow-up-right me-1"></i> {{ $completedOrders }} completed
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stat-card products-card">
                <div class="stat-icon">
                    <i class="bi bi-box"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-title">Total Products</div>
                    <div class="stat-value">{{ $totalProducts }}</div>
                    <div class="stat-change negative">
                        <i class="bi bi-exclamation-triangle me-1"></i> {{ $lowStock }} low stock
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stat-card users-card">
                <div class="stat-icon">
                    <i class="bi bi-people"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-title">Total Users</div>
                    <div class="stat-value">{{ $totalUsers }}</div>
                    <div class="stat-change positive">
                        <i class="bi bi-arrow-up-right me-1"></i> {{ $newUsersToday }} new today
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row">
        <!-- Recent Orders -->
        <div class="col-xl-4">
            <div class="chart-container">
                <div class="chart-header">
                    <h5 class="chart-title">Recent Orders</h5>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-link">View All</a>
                </div>
                <div class="recent-list">
                    @forelse($recentOrders as $order)
                    <div class="recent-item">
                        <div class="recent-avatar">
                            {{ strtoupper(substr($order->user->name ?? 'G', 0, 1)) }}
                        </div>
                        <div class="recent-content">
                            <div class="recent-title">Order #{{ $order->id }}</div>
                            <div class="recent-subtitle">{{ $order->user->name ?? 'Guest' }}</div>
                        </div>
                        <div class="recent-meta">
                            <div class="fw-bold">${{ number_format($order->total_amount, 2) }}</div>
                            <span class="badge bg-{{ $order->status == 'completed' ? 'success' : ($order->status == 'pending' ? 'warning' : 'primary') }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4">
                        <i class="bi bi-cart text-muted" style="font-size: 2rem;"></i>
                        <p class="text-muted mt-2">No recent orders</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Recent Reviews -->
        <div class="col-xl-4">
            <div class="chart-container">
                <div class="chart-header">
                    <h5 class="chart-title">Recent Reviews</h5>
                    <a href="{{ route('admin.reviews.index') }}" class="btn btn-sm btn-link">View All</a>
                </div>
                <div class="recent-list">
                    @forelse($recentReviews as $review)
                    <div class="recent-item">
                        <div class="recent-avatar">
                            {{ strtoupper(substr($review->user->name ?? 'U', 0, 1)) }}
                        </div>
                        <div class="recent-content">
                            <div class="recent-title">{{ $review->product->name ?? 'Product' }}</div>
                            <div class="recent-subtitle">{{ $review->user->name ?? 'User' }}</div>
                            <div class="star-rating small">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }} text-warning"></i>
                                @endfor
                            </div>
                        </div>
                        <div class="recent-meta">
                            <div class="text-muted small">{{ $review->created_at->format('M d') }}</div>
                            <span class="badge bg-{{ $review->rating >= 4 ? 'success' : ($review->rating >= 3 ? 'warning' : 'danger') }}">
                                {{ $review->rating }}/5
                            </span>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4">
                        <i class="bi bi-star text-muted" style="font-size: 2rem;"></i>
                        <p class="text-muted mt-2">No recent reviews</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Recent Users -->
        <div class="col-xl-4">
            <div class="chart-container">
                <div class="chart-header">
                    <h5 class="chart-title">Recent Users</h5>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-link">View All</a>
                </div>
                <div class="recent-list">
                    @if($recentUsers->count() > 0)
                        @foreach($recentUsers as $user)
                        <div class="recent-item">
                            <div class="recent-avatar">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div class="recent-content">
                                <div class="recent-title">{{ $user->name }}</div>
                                <div class="recent-subtitle">{{ $user->email }}</div>
                            </div>
                            <div class="recent-meta">
                                <div class="text-muted small">{{ $user->created_at->format('M d') }}</div>
                                <span class="badge bg-{{ $user->is_admin ? 'danger' : 'success' }}">
                                    {{ $user->is_admin ? 'Admin' : 'User' }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    @else
                    <div class="text-center py-4">
                        <i class="bi bi-people text-muted" style="font-size: 2rem;"></i>
                        <p class="text-muted mt-2">No users found</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Second Row -->
    <div class="row">
        <!-- Low Stock Products -->
        <div class="col-xl-6">
            <div class="chart-container">
                <div class="chart-header">
                    <h5 class="chart-title">Low Stock Alert</h5>
                    <span class="badge bg-danger">{{ $lowStockProducts->count() }} products</span>
                </div>
                @if($lowStockProducts->count() > 0)
                    @foreach($lowStockProducts as $product)
                    <div class="low-stock-item">
                        <div>
                            <div class="fw-bold">{{ $product->name }}</div>
                            <div class="text-muted small">{{ $product->category->name ?? 'N/A' }}</div>
                        </div>
                        <div class="text-end">
                            <div class="stock-warning">{{ $product->stock }} units left</div>
                            <div class="text-muted small">${{ number_format($product->price, 2) }}</div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-check-circle text-success" style="font-size: 2rem;"></i>
                        <p class="text-muted mt-2">All products have sufficient stock</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Top Products -->
        <div class="col-xl-6">
            <div class="chart-container">
                <div class="chart-header">
                    <h5 class="chart-title">Top Selling Products</h5>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-link">View All</a>
                </div>
                @if($topProducts->count() > 0)
                    @foreach($topProducts as $index => $product)
                    <div class="top-product-item">
                        <div class="product-rank rank-{{ $index + 1 }}">
                            {{ $index + 1 }}
                        </div>
                        <div class="product-info">
                            <div class="product-name">{{ $product->name }}</div>
                            <div class="product-sales">{{ $product->total_sold }} units sold</div>
                        </div>
                        <div class="product-revenue">
                            ${{ number_format($product->total_revenue, 2) }}
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-trophy text-muted" style="font-size: 2rem;"></i>
                        <p class="text-muted mt-2">No sales data available</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Third Row -->
    <div class="row">
        <!-- Category Stats -->
        <div class="col-xl-4">
            <div class="chart-container">
                <div class="chart-header">
                    <h5 class="chart-title">Categories</h5>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-sm btn-link">View All</a>
                </div>
                @if($categoryStats->count() > 0)
                    @foreach($categoryStats as $category)
                    <div class="category-item">
                        <div class="category-name">{{ $category->name }}</div>
                        <div class="category-count">{{ $category->products_count }} products</div>
                    </div>
                    @endforeach
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-tags text-muted" style="font-size: 2rem;"></i>
                        <p class="text-muted mt-2">No categories found</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="col-xl-8">
            <div class="chart-container">
                <div class="chart-header">
                    <h5 class="chart-title">Store Statistics</h5>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="quick-stats">
                            <div class="quick-stat">
                                <div class="quick-stat-value">{{ $adminUsers }}</div>
                                <div class="quick-stat-label">Admin Users</div>
                            </div>
                            <div class="quick-stat">
                                <div class="quick-stat-value">{{ $customerUsers }}</div>
                                <div class="quick-stat-label">Customers</div>
                            </div>
                            <div class="quick-stat">
                                <div class="quick-stat-value">{{ $totalCarts }}</div>
                                <div class="quick-stat-label">Active Carts</div>
                            </div>
                            <div class="quick-stat">
                                <div class="quick-stat-value">{{ $totalReviews }}</div>
                                <div class="quick-stat-label">Reviews</div>
                            </div>
                            <div class="quick-stat">
                                <div class="quick-stat-value">{{ $pendingOrders }}</div>
                                <div class="quick-stat-label">Pending Orders</div>
                            </div>
                            <div class="quick-stat">
                                <div class="quick-stat-value">{{ $processingOrders }}</div>
                                <div class="quick-stat-label">Processing</div>
                            </div>
                            <div class="quick-stat">
                                <div class="quick-stat-value">{{ $paidPayments }}</div>
                                <div class="quick-stat-label">Paid Orders</div>
                            </div>
                            <div class="quick-stat">
                                <div class="quick-stat-value">{{ $failedPayments }}</div>
                                <div class="quick-stat-label">Failed Payments</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mt-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Conversion Rate</span>
                                <span class="fw-bold">4.2%</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-success" style="width: 42%"></div>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Average Order Value</span>
                                <span class="fw-bold">${{ $totalOrders > 0 ? number_format($totalRevenue / $totalOrders, 2) : '0.00' }}</span>
                            </div>
                        </div>

                        <div class="mt-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Average Rating</span>
                                <span class="fw-bold">{{ number_format($averageRating, 1) }}/5</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-warning" style="width: {{ ($averageRating / 5) * 100 }}%"></div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Order Completion Rate</span>
                                <span class="fw-bold">{{ $totalOrders > 0 ? number_format(($completedOrders / $totalOrders) * 100, 1) : '0' }}%</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-info" style="width: {{ $totalOrders > 0 ? ($completedOrders / $totalOrders) * 100 : 0 }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
// Additional custom scripts can be added here if needed
</script>
@endsection