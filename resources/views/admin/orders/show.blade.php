@extends('layouts.admin')

@section('title', 'Order #' . $order->id)

@section('content')
<div class="row">
    <div class="col-md-8">
        <!-- Order Items Card -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Order Items ({{ $order->items->count() }})</h5>
                <span class="badge bg-primary">Total: ${{ number_format($order->total_amount, 2) }}</span>
            </div>
            <div class="card-body">
                @if($order->items->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Product</th>
                                    <th class="text-center">Price</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($item->product && $item->product->image)
                                                <img src="{{ asset('storage/' . $item->product->image) }}" 
                                                     alt="{{ $item->product->name }}" 
                                                     width="40" height="40" 
                                                     class="rounded me-2">
                                            @else
                                                <div class="bg-light rounded d-flex align-items-center justify-content-center me-2"
                                                     style="width: 40px; height: 40px;">
                                                    <i class="bi bi-box text-muted"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <strong>{{ $item->product->name ?? 'Product Deleted' }}</strong>
                                                @if($item->product)
                                                    <div class="text-muted small">
                                                        Category: {{ $item->product->category->name ?? 'N/A' }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">${{ number_format($item->price, 2) }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-secondary">{{ $item->quantity }}</span>
                                    </td>
                                    <td class="text-end fw-bold">
                                        ${{ number_format($item->price * $item->quantity, 2) }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="4" class="text-end"><strong>Subtotal:</strong></td>
                                    <td class="text-end">${{ number_format($orderStats['subtotal'], 2) }}</td>
                                </tr>
                                <tr class="table-primary">
                                    <td colspan="4" class="text-end"><h5 class="mb-0">Total Amount:</h5></td>
                                    <td class="text-end"><h5 class="mb-0">${{ number_format($order->total_amount, 2) }}</h5></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-cart-x text-muted" style="font-size: 3rem;"></i>
                        <p class="text-muted mt-3">No items in this order.</p>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Order Activity Log -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Order Activity</h5>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-marker bg-success"></div>
                        <div class="timeline-content">
                            <h6>Order Created</h6>
                            <p class="text-muted small mb-0">{{ $order->created_at->format('F d, Y H:i A') }}</p>
                        </div>
                    </div>
                    @if($order->status != 'pending')
                    <div class="timeline-item">
                        <div class="timeline-marker bg-primary"></div>
                        <div class="timeline-content">
                            <h6>Status Updated to {{ ucfirst($order->status) }}</h6>
                            <p class="text-muted small mb-0">{{ $order->updated_at->format('F d, Y H:i A') }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <!-- Customer Information Card -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Customer Information</h5>
                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editAddressModal">
                    <i class="bi bi-pencil"></i> Edit Address
                </button>
            </div>
            <div class="card-body">
                <!-- Customer Basic Info -->
                <div class="mb-4">
                    <h6>Customer Details</h6>
                    <div class="mb-3">
                        <label class="form-label text-muted small mb-1">Customer Name</label>
                        <div class="d-flex align-items-center">
                            <i class="bi bi-person-circle me-2"></i>
                            <div>
                                <strong>{{ $order->user->name ?? 'Guest' }}</strong>
                                <div class="text-muted small">{{ $order->user->email ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Phone Number -->
                    <div class="mb-3">
                        <label class="form-label text-muted small mb-1">Phone Number</label>
                        <div class="d-flex align-items-center">
                            <i class="bi bi-telephone me-2"></i>
                            <div>
                                @if($order->user && $order->user->address)
                                    <strong>{{ $order->user->address->phone ?? 'Not provided' }}</strong>
                                @else
                                    <span class="text-danger">Phone number not provided</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Shipping Address -->
                <div class="mb-4">
                    <h6>Shipping Address</h6>
                    @if($order->user && $order->user->address)
                        <div class="border rounded p-3 bg-light">
                            <div class="d-flex align-items-start">
                                <i class="bi bi-geo-alt me-2 mt-1 text-primary"></i>
                                <div>
                                    <strong>{{ $order->user->address->full_name ?? $order->user->name }}</strong><br>
                                    {{ $order->user->address->address_line_1 }}<br>
                                    @if($order->user->address->address_line_2)
                                        {{ $order->user->address->address_line_2 }}<br>
                                    @endif
                                    {{ $order->user->address->city }}, {{ $order->user->address->state }}<br>
                                    {{ $order->user->address->postal_code }}
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle"></i>
                            No shipping address found for this customer.
                        </div>
                    @endif
                </div>
                
                <!-- Order Information -->
                <div class="mb-4">
                    <h6>Order Information</h6>
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label text-muted small mb-1">Order ID</label>
                            <div class="badge bg-secondary">#{{ $order->id }}</div>
                        </div>
                        <div class="col-6">
                            <label class="form-label text-muted small mb-1">Order Date</label>
                            <div>{{ $order->created_at->format('M d, Y') }}</div>
                        </div>
                    </div>
                </div>
                
                <!-- Status Information -->
                <div class="mb-4">
                    <h6>Current Status</h6>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="badge bg-{{ $order->status == 'completed' ? 'success' : ($order->status == 'processing' ? 'primary' : ($order->status == 'cancelled' ? 'danger' : 'warning')) }} fs-6 px-3 py-2">
                            {{ ucfirst($order->status) }}
                        </span>
                        
                        <span class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : ($order->payment_status == 'failed' ? 'danger' : 'warning') }}">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </div>
                </div>
                
                <!-- Status Update Forms -->
                <div class="mt-4">
                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="mb-3">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="status" class="form-label"><strong>Update Order Status</strong></label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>🚚 Processing</option>
                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>✅ Completed</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>❌ Cancelled</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-arrow-clockwise"></i> Update Status
                        </button>
                    </form>
                    
                    <form action="{{ route('admin.orders.updatePaymentStatus', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="payment_status" class="form-label"><strong>Update Payment Status</strong></label>
                            <select class="form-select" id="payment_status" name="payment_status" required>
                                <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                                <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>💳 Paid</option>
                                <option value="failed" {{ $order->payment_status == 'failed' ? 'selected' : '' }}>❌ Failed</option>
                                <option value="refunded" {{ $order->payment_status == 'refunded' ? 'selected' : '' }}>↩️ Refunded</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-warning w-100">
                            <i class="bi bi-credit-card"></i> Update Payment Status
                        </button>
                    </form>
                </div>
                
                <!-- Back Button -->
                <div class="mt-3">
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary w-100">
                        <i class="bi bi-arrow-left"></i> Back to Orders
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Order Summary Card -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Order Summary</h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6 mb-3">
                        <div class="text-muted small">Items</div>
                        <h4>{{ $orderStats['total_items'] }}</h4>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="text-muted small">Subtotal</div>
                        <h4>${{ number_format($orderStats['subtotal'], 2) }}</h4>
                    </div>
                </div>
                <div class="text-center">
                    <a href="#" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-printer"></i> Print Invoice
                    </a>
                    <a href="#" class="btn btn-sm btn-outline-success">
                        <i class="bi bi-envelope"></i> Email Invoice
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Address Modal -->
<div class="modal fade" id="editAddressModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Shipping Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.orders.updateShippingInfo', $order->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    @php
                        $address = $order->user->address ?? null;
                    @endphp
                    
                    <div class="mb-3">
                        <label class="form-label">Full Name *</label>
                        <input type="text" class="form-control" name="full_name" 
                               value="{{ $address->full_name ?? $order->user->name ?? '' }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Phone Number *</label>
                        <input type="text" class="form-control" name="phone" 
                               value="{{ $address->phone ?? '' }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Address Line 1 *</label>
                        <input type="text" class="form-control" name="address_line_1" 
                               value="{{ $address->address_line_1 ?? '' }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Address Line 2</label>
                        <input type="text" class="form-control" name="address_line_2" 
                               value="{{ $address->address_line_2 ?? '' }}">
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">City *</label>
                            <input type="text" class="form-control" name="city" 
                                   value="{{ $address->city ?? '' }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">State *</label>
                            <input type="text" class="form-control" name="state" 
                                   value="{{ $address->state ?? '' }}" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Postal Code *</label>
                        <input type="text" class="form-control" name="postal_code" 
                               value="{{ $address->postal_code ?? '' }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}
.timeline:before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #dee2e6;
}
.timeline-item {
    position: relative;
    margin-bottom: 20px;
}
.timeline-marker {
    position: absolute;
    left: -30px;
    top: 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
}
.timeline-content {
    padding-bottom: 10px;
}
.bg-light {
    background-color: #f8f9fa !important;
}
</style>
@endsection