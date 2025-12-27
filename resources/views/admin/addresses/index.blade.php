@extends('layouts.admin')

@section('title', 'Addresses Management')

@section('styles')
<style>
    .address-card {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        margin-bottom: 25px;
        transition: all 0.3s;
        border-left: 4px solid #4facfe;
    }

    .address-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .address-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 20px;
    }

    .address-user {
        display: flex;
        align-items: center;
    }

    .user-avatar-sm {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
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

    .address-badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
    }

    .badge-primary {
        background: rgba(102, 126, 234, 0.1);
        color: #667eea;
    }

    .badge-success {
        background: rgba(34, 197, 94, 0.1);
        color: #22c55e;
    }

    .address-details {
        padding: 20px;
        background: #f7fafc;
        border-radius: 10px;
        margin-bottom: 20px;
    }

    .detail-row {
        display: flex;
        margin-bottom: 10px;
    }

    .detail-row:last-child {
        margin-bottom: 0;
    }

    .detail-icon {
        width: 20px;
        color: #4facfe;
        margin-right: 10px;
        flex-shrink: 0;
    }

    .detail-label {
        color: #718096;
        min-width: 100px;
        flex-shrink: 0;
    }

    .detail-value {
        color: #2d3748;
        font-weight: 500;
        flex-grow: 1;
    }

    .address-actions {
        display: flex;
        gap: 10px;
        justify-content: flex-end;
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

    .city-stats {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        margin-bottom: 25px;
    }

    .city-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid #e9ecef;
    }

    .city-item:last-child {
        border-bottom: none;
    }

    .city-name {
        font-weight: 500;
        color: #2d3748;
    }

    .city-count {
        background: #edf2f7;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.9rem;
        color: #4a5568;
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

    .map-preview {
        height: 150px;
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        margin-top: 15px;
    }

    .filter-section {
        background: white;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        margin-bottom: 25px;
    }

    .summary-card {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
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
</style>
@endsection

@section('content')
<div class="container-fluid">
    
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="header-title">Addresses Management</h1>
            <p class="text-muted mb-0">Manage customer shipping addresses</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-primary" onclick="exportAddresses()">
                <i class="bi bi-download me-2"></i> Export
            </button>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAddressModal">
                <i class="bi bi-plus-circle me-2"></i> Add Address
            </button>
        </div>
    </div>

    <!-- Summary Stats -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="summary-card">
                <div class="summary-title">Total Addresses</div>
                <div class="summary-value">{{ $totalAddresses }}</div>
                <div class="summary-change">
                    <i class="bi bi-people me-1"></i> For {{ $usersWithAddress }} users
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="summary-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <div class="summary-title">Users with Address</div>
                <div class="summary-value">{{ $usersWithAddress }}</div>
                <div class="summary-change">
                    {{ number_format(($usersWithAddress / max($totalAddresses, 1)) * 100, 1) }}% of users
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="summary-card" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                <div class="summary-title">Without Address</div>
                <div class="summary-value">{{ $usersWithoutAddress }}</div>
                <div class="summary-change">
                    {{ number_format(($usersWithoutAddress / max($totalAddresses, 1)) * 100, 1) }}% of users
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="summary-card" style="background: linear-gradient(135deg, #ff9a9e 0%, #fad0c4 100%);">
                <div class="summary-title">Top City</div>
                <div class="summary-value">
                    @if($cityStats->count() > 0)
                        {{ $cityStats->first()->city }}
                    @else
                        N/A
                    @endif
                </div>
                <div class="summary-change">
                    @if($cityStats->count() > 0)
                        {{ $cityStats->first()->count }} addresses
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Left Column - Addresses List -->
        <div class="col-lg-8">
            <!-- Filters -->
            <div class="filter-section">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Search Address</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text" class="form-control" placeholder="Search by name, city..." id="addressSearch">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">City</label>
                        <select class="form-select" id="cityFilter">
                            <option value="">All Cities</option>
                            @foreach($cityStats as $city)
                            <option value="{{ $city->city }}">{{ $city->city }} ({{ $city->count }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Sort By</label>
                        <select class="form-select" id="sortFilter">
                            <option value="newest">Newest First</option>
                            <option value="oldest">Oldest First</option>
                            <option value="name">Name A-Z</option>
                            <option value="city">City</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Addresses List -->
            @if($addresses->count() > 0)
                @foreach($addresses as $address)
                <div class="address-card">
                    <div class="address-header">
                        <div class="address-user">
                            <div class="user-avatar-sm">
                                {{ strtoupper(substr($address->user->name ?? 'U', 0, 1)) }}
                            </div>
                            <div class="user-info">
                                <h6>{{ $address->full_name }}</h6>
                                <small>{{ $address->user->email ?? 'User not found' }}</small>
                            </div>
                        </div>
                        <div>
                            <span class="address-badge badge-primary">
                                <i class="bi bi-geo-alt me-1"></i> {{ $address->city }}
                            </span>
                        </div>
                    </div>

                    <div class="address-details">
                        <div class="detail-row">
                            <i class="bi bi-telephone detail-icon"></i>
                            <span class="detail-label">Phone:</span>
                            <span class="detail-value">{{ $address->phone ?? 'Not provided' }}</span>
                        </div>
                        <div class="detail-row">
                            <i class="bi bi-house detail-icon"></i>
                            <span class="detail-label">Address:</span>
                            <span class="detail-value">{{ $address->address_line_1 }}</span>
                        </div>
                        @if($address->address_line_2)
                        <div class="detail-row">
                            <i class="bi bi-house-add detail-icon"></i>
                            <span class="detail-label">Address 2:</span>
                            <span class="detail-value">{{ $address->address_line_2 }}</span>
                        </div>
                        @endif
                        <div class="detail-row">
                            <i class="bi bi-geo detail-icon"></i>
                            <span class="detail-label">City/State:</span>
                            <span class="detail-value">{{ $address->city }}, {{ $address->state }} {{ $address->postal_code }}</span>
                        </div>
                        <div class="detail-row">
                            <i class="bi bi-calendar detail-icon"></i>
                            <span class="detail-label">Added:</span>
                            <span class="detail-value">{{ $address->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>

                    <!-- Stats -->
                    <div class="stats-grid">
                        <div class="stat-box">
                            <div class="stat-value">
                                {{ $address->user->orders()->count() ?? 0 }}
                            </div>
                            <div class="stat-label">Orders</div>
                        </div>
                        <div class="stat-box">
                            <div class="stat-value">
                                ${{ number_format($address->user->orders()->where('status', 'completed')->sum('total_amount') ?? 0, 2) }}
                            </div>
                            <div class="stat-label">Spent</div>
                        </div>
                    </div>

                    <!-- Map Preview -->
                    <div class="map-preview">
                        <i class="bi bi-map fs-1"></i>
                    </div>

                    <!-- Actions -->
                    <div class="address-actions mt-3">
                        <a href="{{ route('admin.addresses.show', $address->id) }}" 
                           class="btn btn-sm btn-primary">
                            <i class="bi bi-eye me-1"></i> View Details
                        </a>
                        <a href="{{ route('admin.users.show', $address->user_id) }}" 
                           class="btn btn-sm btn-outline-info">
                            <i class="bi bi-person me-1"></i> View User
                        </a>
                        <button class="btn btn-sm btn-outline-warning" onclick="editAddress({{ $address->id }})">
                            <i class="bi bi-pencil me-1"></i> Edit
                        </button>
                        <form action="{{ route('admin.addresses.destroy', $address->id) }}" 
                              method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" 
                                    onclick="return confirm('Delete this address?')">
                                <i class="bi bi-trash me-1"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach

                <!-- Pagination -->
                @if($addresses->hasPages())
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted">
                                Showing {{ $addresses->firstItem() }} to {{ $addresses->lastItem() }} of {{ $addresses->total() }} addresses
                            </div>
                            <div>
                                {{ $addresses->links() }}
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
                            <i class="bi bi-geo-alt"></i>
                        </div>
                        <h4>No Addresses Found</h4>
                        <p class="text-muted">There are no saved addresses in the system yet.</p>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAddressModal">
                            <i class="bi bi-plus-circle me-2"></i> Add First Address
                        </button>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Right Column - City Stats -->
        <div class="col-lg-4">
            <!-- City Statistics -->
            <div class="city-stats">
                <h5 class="mb-4">City Distribution</h5>
                @if($cityStats->count() > 0)
                    @foreach($cityStats as $city)
                    <div class="city-item">
                        <span class="city-name">{{ $city->city }}</span>
                        <span class="city-count">{{ $city->count }} addresses</span>
                    </div>
                    @endforeach
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-building text-muted" style="font-size: 2rem;"></i>
                        <p class="text-muted mt-2">No city data available</p>
                    </div>
                @endif
            </div>

            <!-- Quick Stats -->
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-4">Address Statistics</h5>
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Users with Address</span>
                            <span class="fw-bold">{{ $usersWithAddress }} users</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-primary" 
                                 style="width: {{ ($usersWithAddress / max($totalAddresses, 1)) * 100 }}%">
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Address Coverage</span>
                            <span class="fw-bold">
                                {{ number_format(($usersWithAddress / max(($usersWithAddress + $usersWithoutAddress), 1)) * 100, 1) }}%
                            </span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-success" 
                                 style="width: {{ ($usersWithAddress / max(($usersWithAddress + $usersWithoutAddress), 1)) * 100 }}%">
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h6>Recent Updates</h6>
                        <div class="list-group list-group-flush">
                            @foreach($addresses->take(3) as $address)
                            <div class="list-group-item px-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <small class="text-muted">{{ $address->city }}</small>
                                        <div class="small">{{ $address->full_name }}</div>
                                    </div>
                                    <small class="text-muted">{{ $address->updated_at->diffForHumans() }}</small>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="mb-4">Quick Actions</h5>
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#importAddressesModal">
                            <i class="bi bi-upload me-2"></i> Import Addresses
                        </button>
                        <button class="btn btn-outline-success" onclick="exportAddresses()">
                            <i class="bi bi-download me-2"></i> Export to CSV
                        </button>
                        <button class="btn btn-outline-warning" onclick="validateAddresses()">
                            <i class="bi bi-check-circle me-2"></i> Validate All
                        </button>
                        <button class="btn btn-outline-info" onclick="showAddressMap()">
                            <i class="bi bi-map me-2"></i> View Map
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Add Address Modal -->
<div class="modal fade" id="addAddressModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Address</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addAddressForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Select User *</label>
                            <select class="form-select" name="user_id" required>
                                <option value="">Choose User</option>
                                <!-- Populate with users -->
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Full Name *</label>
                            <input type="text" class="form-control" name="full_name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone Number *</label>
                            <input type="text" class="form-control" name="phone" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Address Line 1 *</label>
                            <input type="text" class="form-control" name="address_line_1" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Address Line 2</label>
                            <input type="text" class="form-control" name="address_line_2">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">City *</label>
                            <input type="text" class="form-control" name="city" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">State *</label>
                            <input type="text" class="form-control" name="state" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Postal Code *</label>
                            <input type="text" class="form-control" name="postal_code" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Address</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function exportAddresses() {
    alert('Export feature coming soon!');
}

function editAddress(addressId) {
    console.log('Editing address:', addressId);
    alert('Edit feature will be implemented soon!');
}

function validateAddresses() {
    if (confirm('Validate all addresses? This will check for incomplete or invalid addresses.')) {
        alert('Address validation process started!');
    }
}

function showAddressMap() {
    alert('Map view will be implemented soon!');
}
</script>
@endsection