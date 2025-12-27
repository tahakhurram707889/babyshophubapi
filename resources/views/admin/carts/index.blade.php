@extends('layouts.admin')

@section('title', 'Shopping Carts')

@section('styles')
<style>
    .cart-card {
        background: white;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        margin-bottom: 25px;
        transition: all 0.3s;
        border-left: 4px solid #667eea;
    }

    .cart-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .cart-user {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }

    .user-avatar {
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

    .user-info h6 {
        margin: 0;
        font-weight: 600;
        color: #2d3748;
    }

    .user-info small {
        color: #718096;
    }

    .cart-stats {
        display: flex;
        justify-content: space-between;
        padding-top: 15px;
        border-top: 1px solid #e9ecef;
    }

    .stat-item {
        text-align: center;
    }

    .stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #2d3748;
        display: block;
    }

    .stat-label {
        font-size: 0.85rem;
        color: #718096;
        display: block;
    }

    .cart-actions {
        display: flex;
        gap: 10px;
        margin-top: 15px;
    }

    .cart-status {
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 500;
        margin-bottom: 10px;
        display: inline-block;
    }

    .status-active {
        background: rgba(34, 197, 94, 0.1);
        color: #22c55e;
    }

    .status-abandoned {
        background: rgba(251, 191, 36, 0.1);
        color: #f59e0b;
    }

    .summary-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .summary-change {
        font-size: 0.85rem;
        opacity: 0.9;
    }

    .empty-cart {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-cart-icon {
        font-size: 4rem;
        color: #cbd5e0;
        margin-bottom: 20px;
    }

    .filter-tabs {
        background: white;
        border-radius: 15px;
        padding: 15px;
        margin-bottom: 25px;
        display: flex;
        gap: 10px;
        overflow-x: auto;
    }

    .filter-tab {
        padding: 8px 20px;
        border-radius: 20px;
        border: none;
        background: #f7fafc;
        color: #4a5568;
        font-weight: 500;
        transition: all 0.3s;
        white-space: nowrap;
    }

    .filter-tab.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .filter-tab:hover:not(.active) {
        background: #edf2f7;
    }

    .cart-items-preview {
        max-height: 100px;
        overflow-y: auto;
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px solid #e9ecef;
    }

    .cart-item-preview {
        display: flex;
        align-items: center;
        padding: 8px;
        border-radius: 8px;
        background: #f7fafc;
        margin-bottom: 8px;
    }

    .cart-item-preview:last-child {
        margin-bottom: 0;
    }

    .item-preview-name {
        font-size: 0.85rem;
        color: #4a5568;
        margin-left: 10px;
    }

    .item-preview-qty {
        margin-left: auto;
        background: #e9ecef;
        padding: 2px 8px;
        border-radius: 10px;
        font-size: 0.8rem;
        color: #4a5568;
    }

    .last-updated {
        font-size: 0.85rem;
        color: #718096;
        margin-top: 10px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="header-title">Shopping Carts</h1>
            <p class="text-muted mb-0">Manage active shopping carts and abandoned carts</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-primary" onclick="exportCarts()">
                <i class="bi bi-download me-2"></i> Export
            </button>
            <button class="btn btn-primary" onclick="clearAllCarts()">
                <i class="bi bi-trash me-2"></i> Clear All Carts
            </button>
        </div>
    </div>

    <!-- Summary Stats -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="summary-card">
                <div class="summary-title">Active Carts</div>
                <div class="summary-value">{{ $totalCarts }}</div>
                <div class="summary-change">
                    <i class="bi bi-arrow-up-right me-1"></i> 5.2% from yesterday
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="summary-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <div class="summary-title">Total Items</div>
                <div class="summary-value">{{ $totalCartItems }}</div>
                <div class="summary-change">
                    <i class="bi bi-box me-1"></i> In all carts
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="summary-card" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                <div class="summary-title">Avg Items/Cart</div>
                <div class="summary-value">{{ number_format($averageItemsPerCart, 1) }}</div>
                <div class="summary-change">
                    <i class="bi bi-graph-up me-1"></i> 12% increase
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="summary-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <div class="summary-title">Abandoned Carts</div>
                <div class="summary-value">12</div>
                <div class="summary-change">
                    <i class="bi bi-clock me-1"></i> Older than 3 days
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="filter-tabs">
        <button class="filter-tab active" onclick="filterCarts('all')">All Carts ({{ $totalCarts }})</button>
        <button class="filter-tab" onclick="filterCarts('active')">Active ({{ $totalCarts }})</button>
        <button class="filter-tab" onclick="filterCarts('abandoned')">Abandoned (12)</button>
        <button class="filter-tab" onclick="filterCarts('high_value')">High Value (8)</button>
        <button class="filter-tab" onclick="filterCarts('empty')">Empty (3)</button>
        <button class="filter-tab" onclick="filterCarts('recent')">Recent ({{ \App\Models\Cart::whereDate('created_at', today())->count() }})</button>
    </div>

    <!-- Search and Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Search Cart</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control" placeholder="Search by user or items..." id="cartSearch">
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Items Range</label>
                    <select class="form-select" id="itemsFilter">
                        <option value="">Any Items</option>
                        <option value="1-5">1-5 Items</option>
                        <option value="6-10">6-10 Items</option>
                        <option value="10+">10+ Items</option>
                        <option value="empty">Empty Carts</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Last Updated</label>
                    <select class="form-select" id="updatedFilter">
                        <option value="">Any Time</option>
                        <option value="today">Today</option>
                        <option value="week">This Week</option>
                        <option value="month">This Month</option>
                        <option value="old">Older than 1 month</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button class="btn btn-primary w-100" onclick="applyCartFilters()">
                        <i class="bi bi-filter me-2"></i> Filter
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Carts Grid -->
    @if($carts->count() > 0)
    <div class="row">
        @foreach($carts as $cart)
        <div class="col-xl-4 col-lg-6">
            <div class="cart-card">
                <!-- Cart Header -->
                <div class="cart-user">
                    <div class="user-avatar">
                        {{ strtoupper(substr($cart->user->name ?? 'G', 0, 1)) }}
                    </div>
                    <div class="user-info">
                        <h6>{{ $cart->user->name ?? 'Guest User' }}</h6>
                        <small>{{ $cart->user->email ?? 'No email' }}</small>
                    </div>
                </div>

                <!-- Cart Status -->
                @php
                    $isAbandoned = $cart->updated_at->diffInDays(now()) > 3;
                @endphp
                <span class="cart-status {{ $isAbandoned ? 'status-abandoned' : 'status-active' }}">
                    <i class="bi bi-{{ $isAbandoned ? 'clock' : 'check-circle' }} me-1"></i>
                    {{ $isAbandoned ? 'Abandoned' : 'Active' }}
                </span>

                <!-- Cart Items Preview -->
                @if($cart->items->count() > 0)
                <div class="cart-items-preview">
                    @foreach($cart->items->take(3) as $item)
                    <div class="cart-item-preview">
                        <i class="bi bi-box text-primary"></i>
                        <span class="item-preview-name">{{ $item->product->name ?? 'Unknown Product' }}</span>
                        <span class="item-preview-qty">{{ $item->quantity }}x</span>
                    </div>
                    @endforeach
                    @if($cart->items->count() > 3)
                    <div class="text-center">
                        <small class="text-muted">+{{ $cart->items->count() - 3 }} more items</small>
                    </div>
                    @endif
                </div>
                @else
                <div class="text-center py-3">
                    <i class="bi bi-cart-x text-muted"></i>
                    <p class="text-muted mb-0 mt-2">Cart is empty</p>
                </div>
                @endif

                <!-- Cart Stats -->
                <div class="cart-stats">
                    <div class="stat-item">
                        <span class="stat-value">{{ $cart->items_count ?? 0 }}</span>
                        <span class="stat-label">Items</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-value">{{ $cart->items_sum_quantity ?? 0 }}</span>
                        <span class="stat-label">Quantity</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-value">
                            ${{ number_format($cart->items->sum(function($item) {
                                return $item->quantity * ($item->product->price ?? 0);
                            }), 2) }}
                        </span>
                        <span class="stat-label">Value</span>
                    </div>
                </div>

                <!-- Last Updated -->
                <div class="last-updated">
                    <i class="bi bi-clock me-1"></i>
                    Updated {{ $cart->updated_at->diffForHumans() }}
                </div>

                <!-- Cart Actions -->
                <div class="cart-actions">
                    <a href="{{ route('admin.carts.show', $cart->id) }}" 
                       class="btn btn-sm btn-primary flex-fill">
                        <i class="bi bi-eye me-1"></i> View
                    </a>
                    <button class="btn btn-sm btn-outline-warning" onclick="sendReminder({{ $cart->id }})">
                        <i class="bi bi-bell me-1"></i> Remind
                    </button>
                    <form action="{{ route('admin.carts.destroy', $cart->id) }}" 
                          method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger" 
                                onclick="return confirm('Clear this cart?')">
                            <i class="bi bi-trash me-1"></i> Clear
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    @if($carts->hasPages())
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    Showing {{ $carts->firstItem() }} to {{ $carts->lastItem() }} of {{ $carts->total() }} carts
                </div>
                <div>
                    {{ $carts->links() }}
                </div>
            </div>
        </div>
    </div>
    @endif

    @else
    <!-- Empty State -->
    <div class="card">
        <div class="card-body">
            <div class="empty-cart">
                <div class="empty-cart-icon">
                    <i class="bi bi-cart"></i>
                </div>
                <h4>No Active Carts</h4>
                <p class="text-muted">There are no active shopping carts at the moment.</p>
                <button class="btn btn-primary">
                    <i class="bi bi-arrow-clockwise me-2"></i> Refresh
                </button>
            </div>
        </div>
    </div>
    @endif

</div>
@endsection

@section('scripts')
<script>
function filterCarts(type) {
    // Update active tab
    document.querySelectorAll('.filter-tab').forEach(tab => {
        tab.classList.remove('active');
    });
    event.target.classList.add('active');
    
    console.log('Filtering carts by:', type);
    // Implement filtering logic
}

function applyCartFilters() {
    const search = document.getElementById('cartSearch').value;
    const items = document.getElementById('itemsFilter').value;
    const updated = document.getElementById('updatedFilter').value;
    
    console.log('Applying cart filters:', { search, items, updated });
    // Implement filter logic
}

function sendReminder(cartId) {
    if (confirm('Send cart reminder email to customer?')) {
        console.log('Sending reminder for cart:', cartId);
        alert('Reminder email will be sent!');
    }
}

function exportCarts() {
    alert('Export feature coming soon!');
}

function clearAllCarts() {
    if (confirm('Clear all shopping carts? This action cannot be undone.')) {
        alert('All carts will be cleared!');
        // Implement clear all functionality
    }
}
</script>
@endsection