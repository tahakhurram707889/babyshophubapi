@extends('layouts.admin')

@section('title', 'Address Details')

@section('styles')
<style>
    .address-header {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        border-radius: 15px;
        padding: 25px;
        color: white;
        margin-bottom: 25px;
        position: relative;
        overflow: hidden;
    }

    .address-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.1);
    }

    .address-user-info {
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

    .address-badges {
        display: flex;
        gap: 10px;
        margin-top: 15px;
    }

    .badge {
        padding: 8px 15px;
        border-radius: 20px;
        font-weight: 500;
        background: rgba(255,255,255,0.2);
        color: white;
        border: 1px solid rgba(255,255,255,0.3);
    }

    .address-details-card {
        background: white;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        margin-bottom: 25px;
    }

    .detail-section {
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 2px solid #e9ecef;
    }

    .detail-section:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .section-title {
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-title i {
        color: #4facfe;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
    }

    .detail-item {
        padding: 15px;
        background: #f7fafc;
        border-radius: 10px;
    }

    .detail-label {
        font-size: 0.85rem;
        color: #718096;
        margin-bottom: 5px;
        display: block;
    }

    .detail-value {
        font-weight: 600;
        color: #2d3748;
        font-size: 1.1rem;
    }

    .map-container {
        height: 300px;
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        margin-top: 20px;
        position: relative;
        overflow: hidden;
    }

    .map-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.3);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .user-stats-card {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        margin-bottom: 25px;
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

    .recent-orders {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
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

    .action-buttons {
        display: grid;
        gap: 10px;
        margin-top: 20px;
    }

    .action-btn {
        width: 100%;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    
    <!-- Back Button -->
    <div class="mb-4">
        <a href="{{ route('admin.addresses.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i> Back to Addresses
        </a>
    </div>

    <!-- Address Header -->
    <div class="address-header">
        <div class="d-flex align-items-center address-user-info">
            <div class="user-avatar-lg">
                {{ strtoupper(substr($address->user->name ?? 'U', 0, 1)) }}
            </div>
            <div>
                <h2 class="mb-1">{{ $address->full_name }}</h2>
                <p class="mb-0 opacity-75">{{ $address->user->email ?? 'User not found' }}</p>
                
                <div class="address-badges">
                    <span class="badge">
                        <i class="bi bi-geo-alt me-1"></i> {{ $address->city }}, {{ $address->state }}
                    </span>
                    <span class="badge">
                        <i class="bi bi-calendar me-1"></i> Added {{ $address->created_at->format('M d, Y') }}
                    </span>
                    <span class="badge">
                        <i class="bi bi-clock me-1"></i> Updated {{ $address->updated_at->diffForHumans() }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Left Column - Address Details -->
        <div class="col-lg-8">
            <!-- Address Details -->
            <div class="address-details-card">
                <!-- Contact Information -->
                <div class="detail-section">
                    <h5 class="section-title">
                        <i class="bi bi-person-circle"></i> Contact Information
                    </h5>
                    <div class="detail-grid">
                        <div class="detail-item">
                            <span class="detail-label">Full Name</span>
                            <span class="detail-value">{{ $address->full_name }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Phone Number</span>
                            <span class="detail-value">{{ $address->phone ?? 'Not provided' }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Email</span>
                            <span class="detail-value">{{ $address->user->email ?? 'N/A' }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">User ID</span>
                            <span class="detail-value">#{{ $address->user_id }}</span>
                        </div>
                    </div>
                </div>

                <!-- Address Information -->
                <div class="detail-section">
                    <h5 class="section-title">
                        <i class="bi bi-house-door"></i> Address Information
                    </h5>
                    <div class="detail-grid">
                        <div class="detail-item">
                            <span class="detail-label">Address Line 1</span>
                            <span class="detail-value">{{ $address->address_line_1 }}</span>
                        </div>
                        @if($address->address_line_2)
                        <div class="detail-item">
                            <span class="detail-label">Address Line 2</span>
                            <span class="detail-value">{{ $address->address_line_2 }}</span>
                        </div>
                        @endif
                        <div class="detail-item">
                            <span class="detail-label">City</span>
                            <span class="detail-value">{{ $address->city }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">State/Province</span>
                            <span class="detail-value">{{ $address->state }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Postal Code</span>
                            <span class="detail-value">{{ $address->postal_code }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Country</span>
                            <span class="detail-value">United States</span>
                        </div>
                    </div>
                </div>

                <!-- Map Preview -->
                <div class="detail-section">
                    <h5 class="section-title">
                        <i class="bi bi-map"></i> Location Map
                    </h5>
                    <div class="map-container">
                        <div class="map-overlay">
                            <div class="text-center">
                                <i class="bi bi-geo-alt fs-1"></i>
                                <h4 class="mt-3">{{ $address->city }}, {{ $address->state }}</h4>
                                <p class="mb-0">{{ $address->address_line_1 }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Orders -->
            @if($address->user && $address->user->orders->count() > 0)
            <div class="recent-orders">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="section-title mb-0">
                        <i class="bi bi-cart"></i> Recent Orders
                    </h5>
                    <a href="{{ route('admin.orders.index') }}?user_id={{ $address->user_id }}" 
                       class="btn btn-sm btn-link">View All</a>
                </div>
                
                @foreach($address->user->orders->take(5) as $order)
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
            </div>
            @endif
        </div>

        <!-- Right Column - User Stats & Actions -->
        <div class="col-lg-4">
            <!-- User Statistics -->
            @if($address->user)
            <div class="user-stats-card">
                <h5 class="section-title">
                    <i class="bi bi-graph-up"></i> User Statistics
                </h5>
                <div class="stats-grid">
                    <div class="stat-box">
                        <div class="stat-value">{{ $userOrders }}</div>
                        <div class="stat-label">Total Orders</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-value">${{ number_format($userTotalSpent, 2) }}</div>
                        <div class="stat-label">Total Spent</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-value">
                            @if($userOrders > 0)
                                ${{ number_format($userTotalSpent / $userOrders, 2) }}
                            @else
                                $0.00
                            @endif
                        </div>
                        <div class="stat-label">Avg Order Value</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-value">
                            {{ $address->user->created_at->diffForHumans(null, true) }}
                        </div>
                        <div class="stat-label">Customer For</div>
                    </div>
                </div>

                <div class="mt-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Order Frequency</span>
                        <span class="fw-bold">
                            @if($userOrders > 0)
                                {{ number_format(30 / $userOrders, 1) }} days/order
                            @else
                                N/A
                            @endif
                        </span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-primary" 
                             style="width: {{ min($userOrders * 10, 100) }}%">
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Quick Actions -->
            <div class="card">
                <div class="card-body">
                    <h5 class="section-title">
                        <i class="bi bi-lightning"></i> Quick Actions
                    </h5>
                    <div class="action-buttons">
                        @if($address->user)
                        <a href="{{ route('admin.users.show', $address->user_id) }}" 
                           class="btn btn-outline-primary action-btn">
                            <i class="bi bi-person me-2"></i> View User Profile
                        </a>
                        @endif
                        
                        <button class="btn btn-outline-success action-btn" onclick="editAddress()">
                            <i class="bi bi-pencil me-2"></i> Edit Address
                        </button>
                        
                        <button class="btn btn-outline-warning action-btn" onclick="verifyAddress()">
                            <i class="bi bi-check-circle me-2"></i> Verify Address
                        </button>
                        
                        <button class="btn btn-outline-info action-btn" onclick="showOnMap()">
                            <i class="bi bi-map me-2"></i> View on Google Maps
                        </button>
                        
                        <form action="{{ route('admin.addresses.destroy', $address->id) }}" 
                              method="POST" class="d-grid">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger action-btn" 
                                    onclick="return confirm('Delete this address? This action cannot be undone.')">
                                <i class="bi bi-trash me-2"></i> Delete Address
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Address Notes -->
            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="section-title">
                        <i class="bi bi-journal-text"></i> Admin Notes
                    </h5>
                    <textarea class="form-control" rows="4" placeholder="Add notes about this address..."></textarea>
                    <button class="btn btn-sm btn-primary mt-3 w-100">Save Notes</button>
                </div>
            </div>

            <!-- Address Validation -->
            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="section-title">
                        <i class="bi bi-shield-check"></i> Address Validation
                    </h5>
                    <div class="alert alert-success">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-check-circle-fill fs-4 me-3"></i>
                            <div>
                                <h6 class="mb-1">Address Verified</h6>
                                <p class="mb-0 small">This address has been validated and confirmed.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2 mt-3">
                        <button class="btn btn-sm btn-outline-success">
                            <i class="bi bi-check-circle me-2"></i> Mark as Verified
                        </button>
                        <button class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-x-circle me-2"></i> Mark as Invalid
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
function editAddress() {
    alert('Edit address feature will be implemented soon!');
}

function verifyAddress() {
    if (confirm('Verify this address? This will validate the address details.')) {
        alert('Address verification process started!');
    }
}

function showOnMap() {
    const address = "{{ $address->address_line_1 }}, {{ $address->city }}, {{ $address->state }} {{ $address->postal_code }}";
    const url = `https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(address)}`;
    window.open(url, '_blank');
}
</script>
@endsection