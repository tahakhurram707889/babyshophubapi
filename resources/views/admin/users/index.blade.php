@extends('layouts.admin')

@section('title', 'Users Management')

@section('styles')
<style>
    .user-avatar {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 1.2rem;
        color: white;
        flex-shrink: 0;
    }

    .user-avatar-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .user-avatar-success {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    }

    .user-avatar-danger {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }

    .user-avatar-warning {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    }

    .status-badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
    }

    .action-buttons {
        display: flex;
        gap: 8px;
    }

    .action-btn {
        width: 35px;
        height: 35px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        transition: all 0.3s;
    }

    .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .filter-card {
        background: white;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        margin-bottom: 25px;
    }

    .stats-card {
        padding: 20px;
        border-radius: 15px;
        color: white;
        margin-bottom: 20px;
    }

    .table-container {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    }

    .table-header {
        background: #f8fafc;
        padding: 20px;
        border-bottom: 1px solid #e9ecef;
    }

    .table-responsive {
        border-radius: 15px;
    }

    .table > thead {
        background: #f8fafc;
    }

    .table > thead > tr > th {
        border-bottom: 2px solid #e9ecef;
        padding: 15px;
        font-weight: 600;
        color: #4a5568;
    }

    .table > tbody > tr > td {
        padding: 15px;
        vertical-align: middle;
        border-bottom: 1px solid #e9ecef;
    }

    .table > tbody > tr:hover {
        background-color: #f8fafc;
    }

    .table > tbody > tr:last-child > td {
        border-bottom: none;
    }

    .pagination-container {
        background: white;
        padding: 20px;
        border-top: 1px solid #e9ecef;
    }

    .empty-state {
        padding: 50px 20px;
        text-align: center;
    }

    .empty-state-icon {
        font-size: 3rem;
        color: #cbd5e0;
        margin-bottom: 20px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="header-title">Users Management</h1>
            <p class="text-muted mb-0">Manage all users and their permissions</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-primary" onclick="exportUsers()">
                <i class="bi bi-download me-2"></i> Export
            </button>
            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                <i class="bi bi-plus-circle me-2"></i> Add User
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="stats-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-1">TOTAL USERS</h6>
                        <h2 class="text-white mb-0">{{ $totalUsers }}</h2>
                    </div>
                    <i class="bi bi-people fs-1 text-white-50"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stats-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-1">ADMIN USERS</h6>
                        <h2 class="text-white mb-0">{{ $adminUsers }}</h2>
                    </div>
                    <i class="bi bi-shield-check fs-1 text-white-50"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stats-card" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-1">CUSTOMER USERS</h6>
                        <h2 class="text-white mb-0">{{ $customerUsers }}</h2>
                    </div>
                    <i class="bi bi-person fs-1 text-white-50"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stats-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-1">TODAY'S SIGNUPS</h6>
                        <h2 class="text-white mb-0">{{ \App\Models\User::whereDate('created_at', today())->count() }}</h2>
                    </div>
                    <i class="bi bi-calendar-plus fs-1 text-white-50"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="filter-card">
        <div class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Search User</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control" placeholder="Name or email..." id="searchInput">
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label">User Role</label>
                <select class="form-select" id="roleFilter">
                    <option value="">All Roles</option>
                    <option value="admin">Admin</option>
                    <option value="customer">Customer</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Registration Date</label>
                <select class="form-select" id="dateFilter">
                    <option value="">All Time</option>
                    <option value="today">Today</option>
                    <option value="week">This Week</option>
                    <option value="month">This Month</option>
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button class="btn btn-primary w-100" onclick="applyFilters()">
                    <i class="bi bi-filter me-2"></i> Apply Filters
                </button>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="table-container">
        <div class="table-header">
            <h5 class="mb-0">All Users</h5>
            <p class="text-muted mb-0">{{ $users->total() }} users found</p>
        </div>

        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th width="50">
                            <input type="checkbox" class="form-check-input" id="selectAll">
                        </th>
                        <th>USER</th>
                        <th>EMAIL</th>
                        <th>ROLE</th>
                        <th>ORDERS</th>
                        <th>ADDRESS</th>
                        <th>JOINED</th>
                        <th>STATUS</th>
                        <th class="text-end">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>
                            <input type="checkbox" class="form-check-input user-checkbox" value="{{ $user->id }}">
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                @php
                                    $avatarColors = ['user-avatar-primary', 'user-avatar-success', 'user-avatar-danger', 'user-avatar-warning'];
                                    $colorClass = $avatarColors[$user->id % 4];
                                @endphp
                                <div class="user-avatar {{ $colorClass }} me-3">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <strong>{{ $user->name }}</strong>
                                    <div class="text-muted small">ID: {{ $user->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->is_admin)
                                <span class="status-badge" style="background: rgba(239, 68, 68, 0.1); color: #ef4444;">
                                    <i class="bi bi-shield-check me-1"></i> Admin
                                </span>
                            @else
                                <span class="status-badge" style="background: rgba(34, 197, 94, 0.1); color: #22c55e;">
                                    <i class="bi bi-person me-1"></i> Customer
                                </span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-primary">{{ $user->orders_count }}</span>
                            <div class="text-muted small">Orders</div>
                        </td>
                        <td>
                            @if($user->address)
                                <span class="status-badge" style="background: rgba(34, 197, 94, 0.1); color: #22c55e;">
                                    <i class="bi bi-check-circle me-1"></i> Has Address
                                </span>
                            @else
                                <span class="status-badge" style="background: rgba(251, 191, 36, 0.1); color: #f59e0b;">
                                    <i class="bi bi-exclamation-circle me-1"></i> No Address
                                </span>
                            @endif
                        </td>
                        <td>
                            <div>{{ $user->created_at->format('M d, Y') }}</div>
                            <div class="text-muted small">{{ $user->created_at->diffForHumans() }}</div>
                        </td>
                        <td>
                            <span class="status-badge" style="background: rgba(34, 197, 94, 0.1); color: #22c55e;">
                                <i class="bi bi-check-circle me-1"></i> Active
                            </span>
                        </td>
                        <td class="text-end">
                            <div class="action-buttons">
                                <a href="{{ route('admin.users.show', $user->id) }}" 
                                   class="action-btn btn-info" title="View">
                                    <i class="bi bi-eye text-white"></i>
                                </a>
                                
                                <form action="{{ route('admin.users.toggleAdmin', $user->id) }}" 
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="action-btn btn-warning" 
                                            title="{{ $user->is_admin ? 'Demote to Customer' : 'Promote to Admin' }}">
                                        <i class="bi bi-arrow-repeat text-white"></i>
                                    </button>
                                </form>
                                
                                @if(!$user->is_admin)
                                <button type="button" class="action-btn btn-danger" 
                                        onclick="confirmDelete({{ $user->id }})"
                                        title="Delete">
                                    <i class="bi bi-trash text-white"></i>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9">
                            <div class="empty-state">
                                <div class="empty-state-icon">
                                    <i class="bi bi-people"></i>
                                </div>
                                <h5>No Users Found</h5>
                                <p class="text-muted">There are no users in the system yet.</p>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                                    <i class="bi bi-plus-circle me-2"></i> Add First User
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($users->hasPages())
        <div class="pagination-container">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} users
                </div>
                <div>
                    {{ $users->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Bulk Actions -->
    @if($users->count() > 0)
    <div class="card mt-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-3">
                    <span class="text-muted" id="selectedCount">0 users selected</span>
                    <select class="form-select form-select-sm w-auto" id="bulkAction">
                        <option value="">Bulk Actions</option>
                        <option value="promote">Promote to Admin</option>
                        <option value="demote">Demote to Customer</option>
                        <option value="delete">Delete Selected</option>
                    </select>
                    <button class="btn btn-sm btn-primary" onclick="applyBulkAction()" id="applyBulkBtn" disabled>
                        Apply
                    </button>
                </div>
                <div class="text-muted">
                    Total: {{ $users->total() }} users
                </div>
            </div>
        </div>
    </div>
    @endif

</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addUserForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Full Name *</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email Address *</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Password *</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Confirm Password *</label>
                            <input type="password" class="form-control" name="password_confirmation" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">User Role</label>
                            <select class="form-select" name="role">
                                <option value="customer">Customer</option>
                                <option value="admin">Administrator</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="text" class="form-control" name="phone">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create User</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Select All functionality
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.user-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
    updateSelectedCount();
});

// Update selected count
function updateSelectedCount() {
    const selected = document.querySelectorAll('.user-checkbox:checked').length;
    document.getElementById('selectedCount').textContent = `${selected} users selected`;
    document.getElementById('applyBulkBtn').disabled = selected === 0;
}

// Add change event to checkboxes
document.querySelectorAll('.user-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', updateSelectedCount);
});

// Bulk Actions
function applyBulkAction() {
    const action = document.getElementById('bulkAction').value;
    const selectedUsers = Array.from(document.querySelectorAll('.user-checkbox:checked'))
        .map(checkbox => checkbox.value);
    
    if (!action) {
        alert('Please select an action');
        return;
    }
    
    if (selectedUsers.length === 0) {
        alert('Please select at least one user');
        return;
    }
    
    let message = '';
    switch(action) {
        case 'promote':
            message = `Promote ${selectedUsers.length} user(s) to admin?`;
            break;
        case 'demote':
            message = `Demote ${selectedUsers.length} user(s) to customer?`;
            break;
        case 'delete':
            message = `Delete ${selectedUsers.length} user(s)? This action cannot be undone.`;
            break;
    }
    
    if (confirm(message)) {
        // Implement bulk action API call
        console.log(`Applying ${action} to users:`, selectedUsers);
        alert('Bulk action feature will be implemented soon!');
    }
}

// Confirm Delete
function confirmDelete(userId) {
    if (confirm('Are you sure you want to delete this user? This will also delete their orders and related data.')) {
        // Implement delete API call
        console.log('Deleting user:', userId);
        alert('Delete feature will be implemented soon!');
    }
}

// Apply Filters
function applyFilters() {
    const search = document.getElementById('searchInput').value;
    const role = document.getElementById('roleFilter').value;
    const date = document.getElementById('dateFilter').value;
    
    console.log('Applying filters:', { search, role, date });
    alert('Filter feature will be implemented soon!');
}

// Export Users
function exportUsers() {
    alert('Export feature coming soon!');
}

// Add User Form
document.getElementById('addUserForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Implement form submission
    console.log('Adding new user:', new FormData(this));
    alert('Add user feature will be implemented soon!');
});
</script>
@endsection