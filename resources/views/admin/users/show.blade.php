@extends('layouts.admin')

@section('title', 'User: ' . $user->name)

@section('styles')
<style>
    .profile-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 15px;
        padding: 30px;
        color: white;
        margin-bottom: 25px;
        position: relative;
        overflow: hidden;
    }

    .profile-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.1);
    }

    .profile-avatar {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: rgba(255,255,255,0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        font-weight: 700;
        color: white;
        border: 4px solid rgba(255,255,255,0.3);
        margin-right: 25px;
        flex-shrink: 0;
    }

    .profile-info h2 {
        margin: 0;
        font-weight: 700;
    }

    .profile-meta {
        display: flex;
        gap: 20px;
        margin-top: 10px;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.9rem;
        opacity: 0.9;
    }

    .info-card {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        margin-bottom: 25px;
        height: 100%;
    }

    .info-card .card-title {
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid #e9ecef;
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid #e9ecef;
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .info-label {
        color: #718096;
        font-weight: 500;
    }

    .info-value {
        color: #2d3748;
        font-weight: 600;
    }

    .address-box {
        background: #f7fafc;
        border-radius: 10px;
        padding: 20px;
        border-left: 4px solid #667eea;
    }

    .address-line {
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .address-icon {
        color: #667eea;
        width: 20px;
    }

    .order-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px;
        border-radius: 10px;
        background: #f7fafc;
        margin-bottom: 10px;
        transition: all 0.3s;
    }

    .order-item:hover {
        background: #edf2f7;
        transform: translateX(5px);
    }

    .order-id {
        font-weight: 600;
        color: #2d3748;
    }

    .order-date {
        font-size: 0.85rem;
        color: #718096;
    }

    .order-amount {
        font-weight: 600;
        color: #2d3748;
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

    .activity-timeline {
        position: relative;
        padding-left: 30px;
    }

    .activity-timeline::before {
        content: '';
        position: absolute;
        left: 15px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e9ecef;
    }

    .timeline-item {
        position: relative;
        margin-bottom: 25px;
    }

    .timeline-dot {
        position: absolute;
        left: -30px;
        top: 5px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #667eea;
        border: 3px solid white;
        box-shadow: 0 0 0 3px #e9ecef;
    }

    .timeline-content {
        padding-bottom: 10px;
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

    .action-buttons {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .action-btn {
        flex: 1;
        min-width: 150px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    
    <!-- Back Button -->
    <div class="mb-4">
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i> Back to Users
        </a>
    </div>

    <!-- Profile Header -->
    <div class="profile-header">
        <div class="d-flex align-items-center position-relative">
            <div class="profile-avatar">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div class="profile-info">
                <h2>{{ $user->name }}</h2>
                <div class="profile-meta">
                    <div class="meta-item">
                        <i class="bi bi-envelope"></i>
                        {{ $user->email }}
                    </div>
                    <div class="meta-item">
                        <i class="bi bi-calendar"></i>
                        Joined {{ $user->created_at->format('F d, Y') }}
                    </div>
                    <div class="meta-item">
                        <i class="bi bi-clock"></i>
                        Last active {{ $user->updated_at->diffForHumans() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Left Column - User Info -->
        <div class="col-lg-4">
            <!-- Basic Information -->
            <div class="info-card">
                <h5 class="card-title">Basic Information</h5>
                <div class="info-item">
                    <span class="info-label">User ID</span>
                    <span class="info-value">#{{ $user->id }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Email</span>
                    <span class="info-value">{{ $user->email }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Role</span>
                    <span class="info-value">
                        @if($user->is_admin)
                            <span class="badge bg-danger">Administrator</span>
                        @else
                            <span class="badge bg-success">Customer</span>
                        @endif
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">Member Since</span>
                    <span class="info-value">{{ $user->created_at->format('M d, Y') }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Account Status</span>
                    <span class="info-value">
                        <span class="badge bg-success">Active</span>
                    </span>
                </div>
            </div>

            <!-- Address Information -->
            <div class="info-card">
                <h5 class="card-title">Shipping Address</h5>
                @if($user->address)
                    <div class="address-box">
                        <div class="address-line">
                            <i class="bi bi-person address-icon"></i>
                            <span class="fw-bold">{{ $user->address->full_name ?? $user->name }}</span>
                        </div>
                        <div class="address-line">
                            <i class="bi bi-telephone address-icon"></i>
                            <span>{{ $user->address->phone ?? 'Not provided' }}</span>
                        </div>
                        <div class="address-line">
                            <i class="bi bi-geo-alt address-icon"></i>
                            <div>
                                {{ $user->address->address_line_1 }}<br>
                                @if($user->address->address_line_2)
                                    {{ $user->address->address_line_2 }}<br>
                                @endif
                                {{ $user->address->city }}, {{ $user->address->state }}<br>
                                {{ $user->address->postal_code }}
                            </div>
                        </div>
                        <div class="address-line">
                            <i class="bi bi-clock address-icon"></i>
                            <span class="text-muted small">
                                Updated {{ $user->address->updated_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-geo-alt text-muted" style="font-size: 2rem;"></i>
                        <p class="text-muted mt-2">No address saved</p>
                    </div>
                @endif
            </div>

            <!-- Actions -->
            <div class="info-card">
                <h5 class="card-title">Actions</h5>
                <div class="action-buttons">
                    <form action="{{ route('admin.users.toggleAdmin', $user->id) }}" method="POST" class="w-100">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-{{ $user->is_admin ? 'warning' : 'primary' }} action-btn">
                            <i class="bi bi-arrow-repeat me-2"></i>
                            {{ $user->is_admin ? 'Demote to Customer' : 'Promote to Admin' }}
                        </button>
                    </form>
                    
                    @if(!$user->is_admin)
                    <button type="button" class="btn btn-outline-danger action-btn"
                            onclick="confirmDelete()">
                        <i class="bi bi-trash me-2"></i> Delete User
                    </button>
                    <form id="deleteForm" action="{{ route('admin.users.destroy', $user->id) }}" 
                          method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                    @endif
                    
                    <button class="btn btn-outline-primary action-btn">
                        <i class="bi bi-envelope me-2"></i> Send Email
                    </button>
                    
                    <button class="btn btn-outline-info action-btn">
                        <i class="bi bi-printer me-2"></i> Print Profile
                    </button>
                </div>
            </div>
        </div>

        <!-- Middle Column - Orders & Stats -->
        <div class="col-lg-5">
            <!-- Order Statistics -->
            <div class="info-card">
                <h5 class="card-title">Order Statistics</h5>
                <div class="stats-grid">
                    <div class="stat-box">
                        <div class="stat-value">{{ $totalOrders }}</div>
                        <div class="stat-label">Total Orders</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-value">${{ number_format($totalSpent, 2) }}</div>
                        <div class="stat-label">Total Spent</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-value">{{ $pendingOrders }}</div>
                        <div class="stat-label">Pending Orders</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-value">
                            @if($totalOrders > 0)
                                ${{ number_format($totalSpent / $totalOrders, 2) }}
                            @else
                                $0.00
                            @endif
                        </div>
                        <div class="stat-label">Avg Order Value</div>
                    </div>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="info-card">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="card-title mb-0">Recent Orders</h5>
                    <a href="{{ route('admin.orders.index') }}?user_id={{ $user->id }}" 
                       class="btn btn-sm btn-link">View All</a>
                </div>
                @if($user->orders && $user->orders->count() > 0)
                    @foreach($user->orders as $order)
                    <div class="order-item">
                        <div>
                            <div class="order-id">Order #{{ $order->id }}</div>
                            <div class="order-date">{{ $order->created_at->format('M d, Y • h:i A') }}</div>
                        </div>
                        <div class="text-end">
                            <div class="order-amount">${{ number_format($order->total_amount, 2) }}</div>
                            <span class="badge bg-{{ $order->status == 'completed' ? 'success' : ($order->status == 'pending' ? 'warning' : 'primary') }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-cart text-muted" style="font-size: 2rem;"></i>
                        <p class="text-muted mt-2">No orders yet</p>
                    </div>
                @endif
            </div>

            <!-- Shopping Cart -->
            @if($user->cart && $user->cart->items->count() > 0)
            <div class="info-card">
                <h5 class="card-title">Shopping Cart</h5>
                <div class="d-flex justify-content-between mb-3">
                    <div>
                        <span class="text-muted">Items in Cart:</span>
                        <h4 class="mb-0">{{ $user->cart->items->count() }}</h4>
                    </div>
                    <div class="text-end">
                        <span class="text-muted">Total Value:</span>
                        <h4 class="mb-0 text-success">
                            ${{ number_format($user->cart->items->sum(function($item) {
                                return $item->quantity * ($item->product->price ?? 0);
                            }), 2) }}
                        </h4>
                    </div>
                </div>
                <a href="{{ route('admin.carts.show', $user->cart->id) }}" 
                   class="btn btn-outline-info w-100">
                    <i class="bi bi-cart me-2"></i> View Cart Details
                </a>
            </div>
            @endif
        </div>

        <!-- Right Column - Activity -->
        <div class="col-lg-3">
            <!-- Recent Activity -->
            <div class="info-card">
                <h5 class="card-title">Recent Activity</h5>
                <div class="activity-timeline">
                    <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <div class="timeline-content">
                            <div class="timeline-title">Account Created</div>
                            <div class="timeline-time">{{ $user->created_at->format('M d, Y • h:i A') }}</div>
                        </div>
                    </div>
                    
                    @if($user->orders && $user->orders->count() > 0)
                    <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <div class="timeline-content">
                            <div class="timeline-title">First Order Placed</div>
                            <div class="timeline-time">{{ $user->orders->first()->created_at->format('M d, Y') }}</div>
                        </div>
                    </div>
                    
                    <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <div class="timeline-content">
                            <div class="timeline-title">Latest Order</div>
                            <div class="timeline-time">{{ $user->orders->first()->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                    @endif
                    
                    @if($user->address)
                    <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <div class="timeline-content">
                            <div class="timeline-title">Address Updated</div>
                            <div class="timeline-time">{{ $user->address->updated_at->diffForHumans() }}</div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Quick Links -->
            <div class="info-card">
                <h5 class="card-title">Quick Links</h5>
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.orders.index') }}?user_id={{ $user->id }}" 
                       class="btn btn-outline-primary">
                        <i class="bi bi-cart me-2"></i> View All Orders
                    </a>
                    <a href="mailto:{{ $user->email }}" class="btn btn-outline-success">
                        <i class="bi bi-envelope me-2"></i> Send Email
                    </a>
                    <button class="btn btn-outline-warning" onclick="resetPassword()">
                        <i class="bi bi-key me-2"></i> Reset Password
                    </button>
                </div>
            </div>

            <!-- User Notes -->
            <div class="info-card">
                <h5 class="card-title">Admin Notes</h5>
                <textarea class="form-control" rows="4" placeholder="Add notes about this user..."></textarea>
                <button class="btn btn-sm btn-primary mt-3 w-100">Save Notes</button>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
function confirmDelete() {
    if (confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
        document.getElementById('deleteForm').submit();
    }
}

function resetPassword() {
    if (confirm('Send password reset email to this user?')) {
        alert('Password reset email will be sent to ' + "{{ $user->email }}");
        // Implement password reset functionality
    }
}
</script>
@endsection