@extends('layouts.admin')

@section('title', 'Orders')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4>Orders Management</h4>
        <p class="text-muted mb-0">Total Orders: {{ $totalOrders }} | Pending: {{ $pendingOrders }} | Completed: {{ $completedOrders }}</p>
    </div>
    <div>
        <button class="btn btn-outline-secondary me-2" onclick="printOrders()">
            <i class="bi bi-printer"></i> Print
        </button>
        <button class="btn btn-outline-success" onclick="exportOrders()">
            <i class="bi bi-file-earmark-excel"></i> Export
        </button>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3 col-sm-6">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h6 class="card-title">Total Orders</h6>
                <h2>{{ $totalOrders }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <h6 class="card-title">Pending</h6>
                <h2>{{ $pendingOrders }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h6 class="card-title">Completed</h6>
                <h2>{{ $completedOrders }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h6 class="card-title">Total Revenue</h6>
                <h2>${{ number_format($totalRevenue, 2) }}</h2>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('admin.orders.index') }}" method="GET" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select class="form-select" name="status">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Payment Status</label>
                <select class="form-select" name="payment_status">
                    <option value="">All Payments</option>
                    <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>Failed</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Date From</label>
                <input type="date" class="form-control" name="date_from" value="{{ request('date_from') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Date To</label>
                <input type="date" class="form-control" name="date_to" value="{{ request('date_to') }}">
            </div>
            <div class="col-12 text-end">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-filter"></i> Apply Filters
                </button>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Clear
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Orders Table -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Orders List</h5>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="selectAll">
            <label class="form-check-label small" for="selectAll">Select All</label>
        </div>
    </div>
    <div class="card-body">
        @if($orders->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th width="50">
                                <input type="checkbox" class="form-check-input" id="checkAll">
                            </th>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                            <th>Payment</th>
                            <th>Order Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td>
                                <input type="checkbox" class="form-check-input order-checkbox" 
                                       value="{{ $order->id }}">
                            </td>
                            <td>
                                <strong>#{{ $order->id }}</strong>
                                <div class="text-muted small">
                                    {{ $order->items->count() }} items
                                </div>
                            </td>
                            <td>
                                <div>
                                    <strong>{{ $order->user->name ?? 'Guest' }}</strong>
                                    <div class="text-muted small">{{ $order->user->email ?? 'N/A' }}</div>
                                </div>
                            </td>
                            <td>
                                <strong>${{ number_format($order->total_amount, 2) }}</strong>
                            </td>
                            <td>
                                <span class="badge bg-{{ $order->status == 'completed' ? 'success' : ($order->status == 'processing' ? 'primary' : ($order->status == 'cancelled' ? 'danger' : 'warning')) }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : ($order->payment_status == 'failed' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </td>
                            <td>
                                {{ $order->created_at->format('M d, Y') }}
                                <div class="text-muted small">
                                    {{ $order->created_at->format('h:i A') }}
                                </div>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" 
                                       class="btn btn-info" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="#" class="btn btn-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger" 
                                            onclick="confirmDelete({{ $order->id }})"
                                            title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Bulk Actions -->
            <div class="mt-3 d-flex justify-content-between align-items-center">
                <div>
                    <select class="form-select form-select-sm w-auto d-inline" id="bulkAction">
                        <option value="">Bulk Actions</option>
                        <option value="complete">Mark as Completed</option>
                        <option value="cancel">Mark as Cancelled</option>
                        <option value="delete">Delete Selected</option>
                    </select>
                    <button class="btn btn-sm btn-primary ms-2" onclick="applyBulkAction()">
                        Apply
                    </button>
                </div>
                
                <!-- Pagination -->
                <div>
                    {{ $orders->links() }}
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-cart-x text-muted" style="font-size: 3rem;"></i>
                <p class="text-muted mt-3">No orders found.</p>
                <a href="#" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Create Test Order
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
// Select All functionality
document.getElementById('checkAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.order-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});

// Bulk Action
function applyBulkAction() {
    const action = document.getElementById('bulkAction').value;
    const selectedOrders = Array.from(document.querySelectorAll('.order-checkbox:checked'))
        .map(checkbox => checkbox.value);
    
    if (!action) {
        alert('Please select an action');
        return;
    }
    
    if (selectedOrders.length === 0) {
        alert('Please select at least one order');
        return;
    }
    
    if (confirm(`Are you sure you want to ${action} ${selectedOrders.length} order(s)?`)) {
        // Send AJAX request for bulk action
        fetch("{{ route('admin.orders.bulkUpdate') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                order_ids: selectedOrders,
                action: action
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }
}

// Confirm Delete
function confirmDelete(orderId) {
    if (confirm('Are you sure you want to delete this order?')) {
        fetch(`/admin/orders/${orderId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => {
            if (response.ok) {
                location.reload();
            }
        });
    }
}

// Export and Print functions
function printOrders() {
    window.print();
}

function exportOrders() {
    // Implement CSV export
    alert('Export feature coming soon!');
}
</script>
@endsection