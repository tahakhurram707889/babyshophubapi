@extends('layouts.admin')

@section('title', 'Cart Details')

@section('styles')
<style>
    .cart-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 15px;
        padding: 25px;
        color: white;
        margin-bottom: 25px;
        position: relative;
        overflow: hidden;
    }

    .cart-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.1);
    }

    .cart-user-info {
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

    .cart-summary-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-top: 25px;
    }

    .summary-stat {
        text-align: center;
        padding: 20px;
        background: rgba(255,255,255,0.1);
        border-radius: 10px;
        backdrop-filter: blur(10px);
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        display: block;
    }

    .stat-label {
        font-size: 0.9rem;
        opacity: 0.9;
        display: block;
        margin-top: 5px;
    }

    .cart-item-card {
        background: white;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 15px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.05);
        display: flex;
        align-items: center;
        transition: all 0.3s;
        border-left: 4px solid #667eea;
    }

    .cart-item-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .item-image {
        width: 80px;
        height: 80px;
        border-radius: 10px;
        overflow: hidden;
        margin-right: 20px;
        flex-shrink: 0;
        background: #f7fafc;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .item-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .item-image i {
        font-size: 2rem;
        color: #cbd5e0;
    }

    .item-info {
        flex-grow: 1;
    }

    .item-name {
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 5px;
    }

    .item-category {
        font-size: 0.85rem;
        color: #718096;
        margin-bottom: 8px;
    }

    .item-price {
        font-weight: 600;
        color: #2d3748;
    }

    .item-quantity {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .quantity-badge {
        background: #e9ecef;
        padding: 5px 15px;
        border-radius: 20px;
        font-weight: 600;
        color: #4a5568;
    }

    .item-total {
        text-align: right;
        min-width: 120px;
    }

    .item-total-value {
        font-size: 1.2rem;
        font-weight: 700;
        color: #2d3748;
    }

    .item-actions {
        display: flex;
        gap: 10px;
        margin-left: 20px;
    }

    .cart-total-card {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        margin-bottom: 25px;
    }

    .total-row {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid #e9ecef;
    }

    .total-row:last-child {
        border-bottom: none;
        font-size: 1.3rem;
        font-weight: 700;
        color: #2d3748;
        padding-top: 20px;
        margin-top: 10px;
        border-top: 2px solid #e9ecef;
    }

    .total-label {
        color: #718096;
    }

    .total-value {
        font-weight: 600;
        color: #2d3748;
    }

    .cart-actions-card {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    }

    .action-buttons {
        display: grid;
        gap: 10px;
    }

    .cart-timeline {
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
        background: #667eea;
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

    .empty-cart-state {
        text-align: center;
        padding: 50px 20px;
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    }

    .empty-cart-icon {
        font-size: 4rem;
        color: #cbd5e0;
        margin-bottom: 20px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    
    <!-- Back Button -->
    <div class="mb-4">
        <a href="{{ route('admin.carts.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i> Back to Carts
        </a>
    </div>

    <!-- Cart Header -->
    <div class="cart-header">
        <div class="d-flex align-items-center cart-user-info">
            <div class="user-avatar-lg">
                {{ strtoupper(substr($cart->user->name ?? 'G', 0, 1)) }}
            </div>
            <div>
                <h2 class="mb-1">{{ $cart->user->name ?? 'Guest User' }}</h2>
                <p class="mb-0 opacity-75">{{ $cart->user->email ?? 'No email' }}</p>
                <div class="mt-2">
                    <span class="badge bg-light text-dark me-2">
                        Cart ID: {{ $cart->id }}
                    </span>
                    <span class="badge bg-warning">
                        <i class="bi bi-clock me-1"></i>
                        Updated {{ $cart->updated_at->diffForHumans() }}
                    </span>
                </div>
            </div>
        </div>

        <div class="cart-summary-stats">
            <div class="summary-stat">
                <span class="stat-value">{{ $cartStats['total_items'] }}</span>
                <span class="stat-label">Total Items</span>
            </div>
            <div class="summary-stat">
                <span class="stat-value">{{ $cart->items->count() }}</span>
                <span class="stat-label">Unique Products</span>
            </div>
            <div class="summary-stat">
                <span class="stat-value">${{ number_format($cartStats['total_value'], 2) }}</span>
                <span class="stat-label">Cart Value</span>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Cart Items -->
        <div class="col-lg-8">
            @if($cart->items->count() > 0)
            <div class="card">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">Cart Items ({{ $cart->items->count() }})</h5>
                </div>
                <div class="card-body">
                    @foreach($cart->items as $item)
                    <div class="cart-item-card">
                        <div class="item-image">
                            @if($item->product && $item->product->image)
                                <img src="{{ asset('storage/' . $item->product->image) }}" 
                                     alt="{{ $item->product->name }}">
                            @else
                                <i class="bi bi-box"></i>
                            @endif
                        </div>
                        
                        <div class="item-info">
                            <div class="item-name">{{ $item->product->name ?? 'Product Deleted' }}</div>
                            <div class="item-category">{{ $item->product->category->name ?? 'N/A' }}</div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="item-price">${{ number_format($item->product->price ?? 0, 2) }}</div>
                                <div class="item-quantity">
                                    <span class="quantity-badge">{{ $item->quantity }} items</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="item-total">
                            <div class="item-total-value">
                                ${{ number_format(($item->product->price ?? 0) * $item->quantity, 2) }}
                            </div>
                        </div>
                        
                        <div class="item-actions">
                            <button class="btn btn-sm btn-outline-primary" 
                                    onclick="updateQuantity({{ $item->id }}, 'increase')">
                                <i class="bi bi-plus"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-secondary" 
                                    onclick="updateQuantity({{ $item->id }}, 'decrease')">
                                <i class="bi bi-dash"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger" 
                                    onclick="removeItem({{ $item->id }})">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @else
            <div class="empty-cart-state">
                <div class="empty-cart-icon">
                    <i class="bi bi-cart-x"></i>
                </div>
                <h4>Cart is Empty</h4>
                <p class="text-muted">This shopping cart doesn't contain any items.</p>
            </div>
            @endif

            <!-- Cart Timeline -->
            <div class="cart-timeline mt-4">
                <h5 class="mb-4">Cart Activity</h5>
                <div class="timeline-item">
                    <div class="timeline-icon">
                        <i class="bi bi-plus"></i>
                    </div>
                    <div class="timeline-content">
                        <div class="timeline-title">Cart Created</div>
                        <div class="timeline-time">{{ $cart->created_at->format('F d, Y • h:i A') }}</div>
                    </div>
                </div>
                
                @if($cart->items->count() > 0)
                <div class="timeline-item">
                    <div class="timeline-icon">
                        <i class="bi bi-cart-plus"></i>
                    </div>
                    <div class="timeline-content">
                        <div class="timeline-title">First Item Added</div>
                        <div class="timeline-time">{{ $cart->items->first()->created_at->format('F d, Y • h:i A') }}</div>
                    </div>
                </div>
                
                <div class="timeline-item">
                    <div class="timeline-icon">
                        <i class="bi bi-clock"></i>
                    </div>
                    <div class="timeline-content">
                        <div class="timeline-title">Last Updated</div>
                        <div class="timeline-time">{{ $cart->updated_at->format('F d, Y • h:i A') }}</div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Cart Summary & Actions -->
        <div class="col-lg-4">
            <!-- Cart Total -->
            <div class="cart-total-card">
                <h5 class="mb-4">Cart Summary</h5>
                <div class="total-row">
                    <span class="total-label">Subtotal</span>
                    <span class="total-value">${{ number_format($cartStats['total_value'], 2) }}</span>
                </div>
                <div class="total-row">
                    <span class="total-label">Shipping</span>
                    <span class="total-value">$0.00</span>
                </div>
                <div class="total-row">
                    <span class="total-label">Tax (10%)</span>
                    <span class="total-value">${{ number_format($cartStats['total_value'] * 0.1, 2) }}</span>
                </div>
                <div class="total-row">
                    <span class="total-label">Total</span>
                    <span class="total-value">${{ number_format($cartStats['total_value'] * 1.1, 2) }}</span>
                </div>
            </div>

            <!-- Cart Actions -->
            <div class="cart-actions-card">
                <h5 class="mb-4">Cart Actions</h5>
                <div class="action-buttons">
                    <a href="{{ route('admin.users.show', $cart->user_id) }}" 
                       class="btn btn-outline-primary">
                        <i class="bi bi-person me-2"></i> View User Profile
                    </a>
                    
                    <button class="btn btn-outline-success" onclick="convertToOrder()">
                        <i class="bi bi-cart-check me-2"></i> Convert to Order
                    </button>
                    
                    <button class="btn btn-outline-warning" onclick="sendCartReminder()">
                        <i class="bi bi-bell me-2"></i> Send Reminder
                    </button>
                    
                    <button class="btn btn-outline-info" onclick="duplicateCart()">
                        <i class="bi bi-copy me-2"></i> Duplicate Cart
                    </button>
                    
                    <form action="{{ route('admin.carts.destroy', $cart->id) }}" 
                          method="POST" class="d-grid">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger" 
                                onclick="return confirm('Clear this cart? All items will be removed.')">
                            <i class="bi bi-trash me-2"></i> Clear Cart
                        </button>
                    </form>
                </div>
            </div>

            <!-- Cart Notes -->
            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="mb-3">Admin Notes</h5>
                    <textarea class="form-control" rows="4" placeholder="Add notes about this cart..."></textarea>
                    <button class="btn btn-sm btn-primary mt-3 w-100">Save Notes</button>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
function updateQuantity(itemId, action) {
    console.log(`${action} quantity for item:`, itemId);
    alert(`Quantity will be ${action === 'increase' ? 'increased' : 'decreased'}!`);
}

function removeItem(itemId) {
    if (confirm('Remove this item from cart?')) {
        console.log('Removing item:', itemId);
        alert('Item will be removed!');
    }
}

function convertToOrder() {
    if (confirm('Convert this cart to an order?')) {
        alert('Cart will be converted to an order!');
    }
}

function sendCartReminder() {
    if (confirm('Send cart reminder email to customer?')) {
        alert('Reminder email will be sent!');
    }
}

function duplicateCart() {
    if (confirm('Create a duplicate of this cart?')) {
        alert('Cart will be duplicated!');
    }
}
</script>
@endsection