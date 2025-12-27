<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Baby Shop Hub - @yield('title')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <!-- Custom Styles -->
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3a0ca3;
            --success-color: #4cc9f0;
            --warning-color: #f72585;
            --danger-color: #ef476f;
            --info-color: #7209b7;
            --dark-color: #212529;
            --light-color: #f8f9fa;
            --sidebar-width: 260px;
            --sidebar-collapsed-width: 70px;
            --header-height: 70px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: #f5f7fb;
            overflow-x: hidden;
        }

        /* Sidebar Styles */
        .sidebar-wrapper {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            position: fixed;
            height: 100vh;
            z-index: 1000;
            transition: all 0.3s ease;
            box-shadow: 5px 0 15px rgba(0, 0, 0, 0.1);
        }

        .sidebar-collapsed {
            width: var(--sidebar-collapsed-width);
        }

        .sidebar-header {
            padding: 20px 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: var(--header-height);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
            font-size: 1.4rem;
            color: white;
            text-decoration: none;
        }

        .logo-icon {
            font-size: 1.8rem;
            color: #ffd166;
        }

        .logo-text {
            transition: opacity 0.3s;
        }

        .sidebar-collapsed .logo-text {
            opacity: 0;
            width: 0;
            overflow: hidden;
        }

        .toggle-btn {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            color: white;
            width: 35px;
            height: 35px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
        }

        .toggle-btn:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .sidebar-menu {
            padding: 20px 0;
            height: calc(100vh - var(--header-height));
            overflow-y: auto;
        }

        .sidebar-menu::-webkit-scrollbar {
            width: 5px;
        }

        .sidebar-menu::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
        }

        .menu-item {
            padding: 12px 20px;
            margin: 5px 15px;
            border-radius: 10px;
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.3s;
            position: relative;
        }

        .menu-item:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            transform: translateX(5px);
        }

        .menu-item.active {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            font-weight: 500;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .menu-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 60%;
            background: #ffd166;
            border-radius: 0 4px 4px 0;
        }

        .menu-icon {
            font-size: 1.2rem;
            min-width: 24px;
        }

        .menu-text {
            transition: opacity 0.3s;
            white-space: nowrap;
        }

        .sidebar-collapsed .menu-text {
            opacity: 0;
            width: 0;
            overflow: hidden;
        }

        .badge-count {
            background: var(--warning-color);
            color: white;
            font-size: 0.7rem;
            padding: 2px 8px;
            border-radius: 10px;
            margin-left: auto;
        }

        .sidebar-collapsed .badge-count {
            position: absolute;
            top: 5px;
            right: 5px;
            font-size: 0.6rem;
            padding: 1px 5px;
        }

        .menu-divider {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            margin: 15px 20px;
        }

        .user-profile {
            padding: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(45deg, var(--success-color), var(--info-color));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1.2rem;
        }

        .user-info {
            flex-grow: 1;
        }

        .user-name {
            font-weight: 600;
            font-size: 0.9rem;
            color: white;
        }

        .user-role {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.7);
        }

        .sidebar-collapsed .user-info {
            display: none;
        }

        /* Main Content Styles */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            transition: margin-left 0.3s;
            min-height: 100vh;
        }

        .main-collapsed {
            margin-left: var(--sidebar-collapsed-width);
        }

        /* Header Styles */
        .main-header {
            height: var(--header-height);
            background: white;
            border-bottom: 1px solid #e9ecef;
            padding: 0 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 1.5rem;
            color: var(--dark-color);
            margin: 0;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .notification-btn, .fullscreen-btn {
            background: none;
            border: none;
            color: #6c757d;
            font-size: 1.2rem;
            cursor: pointer;
            position: relative;
            transition: color 0.3s;
        }

        .notification-btn:hover, .fullscreen-btn:hover {
            color: var(--primary-color);
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: var(--danger-color);
            color: white;
            font-size: 0.6rem;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .user-dropdown {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            padding: 8px 15px;
            border-radius: 10px;
            transition: background 0.3s;
        }

        .user-dropdown:hover {
            background: #f8f9fa;
        }

        .dropdown-arrow {
            font-size: 0.8rem;
            color: #6c757d;
        }

        /* Main Content */
        .main-content {
            padding: 30px;
            min-height: calc(100vh - var(--header-height));
        }

        /* Alerts */
        .alert {
            border: none;
            border-radius: 10px;
            padding: 15px 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .alert-success {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
            border-left: 4px solid #28a745;
        }

        .alert-danger {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            color: #721c24;
            border-left: 4px solid #dc3545;
        }

        .alert-info {
            background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%);
            color: #0c5460;
            border-left: 4px solid #17a2b8;
        }

        .alert-warning {
            background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
            color: #856404;
            border-left: 4px solid #ffc107;
        }

        /* Cards */
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s, box-shadow 0.3s;
            margin-bottom: 25px;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background: white;
            border-bottom: 1px solid #e9ecef;
            padding: 20px 25px;
            border-radius: 15px 15px 0 0 !important;
        }

        .card-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            color: var(--dark-color);
            margin: 0;
        }

        .card-body {
            padding: 25px;
        }

        /* Buttons */
        .btn {
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 500;
            transition: all 0.3s;
            border: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
        }

        .btn-success {
            background: linear-gradient(135deg, #4cc9f0 0%, #4895ef 100%);
        }

        .btn-warning {
            background: linear-gradient(135deg, #f72585 0%, #b5179e 100%);
        }

        .btn-danger {
            background: linear-gradient(135deg, #ef476f 0%, #f15bb5 100%);
        }

        /* Tables */
        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
            color: var(--dark-color);
            padding: 15px;
            white-space: nowrap;
        }

        .table tbody td {
            padding: 15px;
            vertical-align: middle;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(67, 97, 238, 0.05);
        }

        /* Badges */
        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 500;
            font-size: 0.85rem;
        }

        .badge-success {
            background: rgba(76, 201, 240, 0.1);
            color: #4cc9f0;
        }

        .badge-warning {
            background: rgba(247, 37, 133, 0.1);
            color: #f72585;
        }

        .badge-danger {
            background: rgba(239, 71, 111, 0.1);
            color: #ef476f;
        }

        .badge-info {
            background: rgba(114, 9, 183, 0.1);
            color: #7209b7;
        }

        /* Footer */
        .footer {
            background: white;
            border-top: 1px solid #e9ecef;
            padding: 20px 30px;
            text-align: center;
            color: #6c757d;
            font-size: 0.9rem;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar-wrapper {
                transform: translateX(-100%);
            }
            
            .sidebar-mobile-open {
                transform: translateX(0);
            }
            
            .main-wrapper {
                margin-left: 0 !important;
            }
            
            .mobile-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: 999;
            }
            
            .mobile-overlay.active {
                display: block;
            }
            
            .mobile-toggle-btn {
                display: flex;
                align-items: center;
                justify-content: center;
                background: var(--primary-color);
                color: white;
                border: none;
                width: 40px;
                height: 40px;
                border-radius: 8px;
                margin-right: 15px;
            }
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
    </style>
    
    @yield('styles')
</head>
<body>
    <!-- Mobile Overlay -->
    <div class="mobile-overlay" id="mobileOverlay"></div>

    <!-- Sidebar -->
    <div class="sidebar-wrapper" id="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('admin.dashboard') }}" class="logo">
                <i class="bi bi-emoji-sunglasses logo-icon"></i>
                <span class="logo-text">Baby Shop Hub</span>
            </a>
            <button class="toggle-btn" id="sidebarToggle">
                <i class="bi bi-chevron-left"></i>
            </button>
        </div>

        <div class="sidebar-menu">
            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2 menu-icon"></i>
                <span class="menu-text">Dashboard</span>
            </a>

            <!-- Users -->
            <a href="{{ route('admin.users.index') }}" class="menu-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="bi bi-people menu-icon"></i>
                <span class="menu-text">Users</span>
                <span class="badge-count">{{ \App\Models\User::count() }}</span>
            </a>

            <!-- Products -->
            <a href="{{ route('admin.products.index') }}" class="menu-item {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                <i class="bi bi-box menu-icon"></i>
                <span class="menu-text">Products</span>
                <span class="badge-count">{{ \App\Models\Product::count() }}</span>
            </a>

            <!-- Categories -->
            <a href="{{ route('admin.categories.index') }}" class="menu-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <i class="bi bi-tags menu-icon"></i>
                <span class="menu-text">Categories</span>
                <span class="badge-count">{{ \App\Models\Category::count() }}</span>
            </a>

            <!-- Orders -->
            <a href="{{ route('admin.orders.index') }}" class="menu-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                <i class="bi bi-cart menu-icon"></i>
                <span class="menu-text">Orders</span>
                <span class="badge-count">{{ \App\Models\Order::count() }}</span>
            </a>

            <!-- Shopping Carts -->
            <a href="{{ route('admin.carts.index') }}" class="menu-item {{ request()->routeIs('admin.carts.*') ? 'active' : '' }}">
                <i class="bi bi-basket menu-icon"></i>
                <span class="menu-text">Shopping Carts</span>
                <span class="badge-count">{{ \App\Models\Cart::count() }}</span>
            </a>

            <!-- Addresses -->
            <a href="{{ route('admin.addresses.index') }}" class="menu-item {{ request()->routeIs('admin.addresses.*') ? 'active' : '' }}">
                <i class="bi bi-geo-alt menu-icon"></i>
                <span class="menu-text">Addresses</span>
                <span class="badge-count">{{ \App\Models\Address::count() }}</span>
            </a>

            <!-- Reviews -->
<a href="{{ route('admin.reviews.index') }}" class="menu-item {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
    <i class="bi bi-star menu-icon"></i>
    <span class="menu-text">Reviews</span>
    <span class="badge-count">{{ \App\Models\Review::count() }}</span>
</a>

            <!-- Logout -->
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="menu-item">
                <i class="bi bi-box-arrow-right menu-icon"></i>
                <span class="menu-text">Logout</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>

        <!-- User Profile -->
        <div class="user-profile">
            <div class="user-avatar">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div class="user-info">
                <div class="user-name">{{ Auth::user()->name }}</div>
                <div class="user-role">{{ Auth::user()->is_admin ? 'Administrator' : 'Customer' }}</div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-wrapper" id="mainWrapper">
        <!-- Header -->
        <header class="main-header">
            <div class="d-flex align-items-center">
                <button class="mobile-toggle-btn d-lg-none me-3" id="mobileToggle">
                    <i class="bi bi-list"></i>
                </button>
                <h1 class="header-title">@yield('title')</h1>
            </div>
            
            <div class="header-actions">
                <!-- Notifications -->
                <button class="notification-btn" id="notificationBtn">
                    <i class="bi bi-bell"></i>
                    <span class="notification-badge">3</span>
                </button>

                <!-- Fullscreen -->
                <button class="fullscreen-btn" id="fullscreenBtn">
                    <i class="bi bi-arrows-fullscreen"></i>
                </button>

                <!-- User Dropdown -->
                <div class="user-dropdown" id="userDropdown">
                    <div class="user-avatar small">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="d-none d-md-block">
                        <div class="user-name">{{ Auth::user()->name }}</div>
                        <div class="user-role">{{ Auth::user()->is_admin ? 'Admin' : 'Customer' }}</div>
                    </div>
                    <i class="bi bi-chevron-down dropdown-arrow"></i>
                </div>
            </div>
        </header>

        <!-- Content -->
        <main class="main-content fade-in">
            <!-- Alerts -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('info'))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <i class="bi bi-info-circle-fill me-2"></i>
                    {{ session('info') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('warning'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle-fill me-2"></i>
                    {{ session('warning') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-6 text-md-start text-center">
                        &copy; {{ date('Y') }} Baby Shop Hub. All rights reserved.
                    </div>
                    <div class="col-md-6 text-md-end text-center">
                        <span class="text-muted">v1.0.0 | Last updated: {{ date('M d, Y') }}</span>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom Scripts -->
    <script>
        // Sidebar Toggle
        const sidebar = document.getElementById('sidebar');
        const mainWrapper = document.getElementById('mainWrapper');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const mobileToggle = document.getElementById('mobileToggle');
        const mobileOverlay = document.getElementById('mobileOverlay');
        const icon = sidebarToggle.querySelector('i');

        // Check localStorage for sidebar state
        const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
        
        if (isCollapsed) {
            sidebar.classList.add('sidebar-collapsed');
            mainWrapper.classList.add('main-collapsed');
            icon.classList.remove('bi-chevron-left');
            icon.classList.add('bi-chevron-right');
        }

        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('sidebar-collapsed');
            mainWrapper.classList.toggle('main-collapsed');
            
            // Toggle icon
            if (sidebar.classList.contains('sidebar-collapsed')) {
                icon.classList.remove('bi-chevron-left');
                icon.classList.add('bi-chevron-right');
                localStorage.setItem('sidebarCollapsed', 'true');
            } else {
                icon.classList.remove('bi-chevron-right');
                icon.classList.add('bi-chevron-left');
                localStorage.setItem('sidebarCollapsed', 'false');
            }
        });

        // Mobile Toggle
        mobileToggle.addEventListener('click', () => {
            sidebar.classList.add('sidebar-mobile-open');
            mobileOverlay.classList.add('active');
        });

        mobileOverlay.addEventListener('click', () => {
            sidebar.classList.remove('sidebar-mobile-open');
            mobileOverlay.classList.remove('active');
        });

        // Fullscreen Toggle
        const fullscreenBtn = document.getElementById('fullscreenBtn');
        const fullscreenIcon = fullscreenBtn.querySelector('i');

        fullscreenBtn.addEventListener('click', () => {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen().then(() => {
                    fullscreenIcon.classList.remove('bi-arrows-fullscreen');
                    fullscreenIcon.classList.add('bi-arrows-angle-contract');
                });
            } else {
                document.exitFullscreen().then(() => {
                    fullscreenIcon.classList.remove('bi-arrows-angle-contract');
                    fullscreenIcon.classList.add('bi-arrows-fullscreen');
                });
            }
        });

        // User Dropdown
        const userDropdown = document.getElementById('userDropdown');
        userDropdown.addEventListener('click', () => {
            // Create dropdown menu
            const dropdownMenu = document.createElement('div');
            dropdownMenu.className = 'dropdown-menu show position-absolute';
            dropdownMenu.style.cssText = `
                min-width: 200px;
                border: none;
                border-radius: 10px;
                box-shadow: 0 10px 30px rgba(0,0,0,0.1);
                padding: 10px 0;
            `;
            
            dropdownMenu.innerHTML = `
                <div class="dropdown-item py-2 px-3">
                    <div class="d-flex align-items-center">
                        <div class="user-avatar me-3">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="fw-bold">{{ Auth::user()->name }}</div>
                            <small class="text-muted">{{ Auth::user()->email }}</small>
                        </div>
                    </div>
                </div>
                <div class="dropdown-divider my-2"></div>
                <a href="{{ route('admin.users.show', Auth::id()) }}" class="dropdown-item py-2 px-3">
                    <i class="bi bi-person me-2"></i> My Profile
                </a>
                <a href="{{ route('admin.dashboard') }}" class="dropdown-item py-2 px-3">
                    <i class="bi bi-gear me-2"></i> Settings
                </a>
                <div class="dropdown-divider my-2"></div>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item py-2 px-3 text-danger">
                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                </a>
            `;
            
            // Position and show dropdown
            const rect = userDropdown.getBoundingClientRect();
            dropdownMenu.style.top = rect.bottom + 5 + 'px';
            dropdownMenu.style.right = window.innerWidth - rect.right + 'px';
            
            document.body.appendChild(dropdownMenu);
            
            // Close dropdown when clicking outside
            const closeDropdown = (e) => {
                if (!userDropdown.contains(e.target) && !dropdownMenu.contains(e.target)) {
                    dropdownMenu.remove();
                    document.removeEventListener('click', closeDropdown);
                }
            };
            
            setTimeout(() => {
                document.addEventListener('click', closeDropdown);
            }, 0);
        });

        // Notification Dropdown
        const notificationBtn = document.getElementById('notificationBtn');
        notificationBtn.addEventListener('click', () => {
            // Create notification dropdown
            const notificationMenu = document.createElement('div');
            notificationMenu.className = 'dropdown-menu show position-absolute';
            notificationMenu.style.cssText = `
                min-width: 300px;
                border: none;
                border-radius: 10px;
                box-shadow: 0 10px 30px rgba(0,0,0,0.1);
                padding: 0;
            `;
            
            notificationMenu.innerHTML = `
                <div class="p-3 border-bottom">
                    <h6 class="mb-0">Notifications</h6>
                    <small class="text-muted">You have 3 new notifications</small>
                </div>
                <div class="notification-list" style="max-height: 300px; overflow-y: auto;">
                    <a href="#" class="dropdown-item py-3 px-3 border-bottom">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <div class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-cart text-white"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">New Order Received</h6>
                                <p class="mb-0 text-muted small">Order #1234 has been placed</p>
                                <small class="text-muted">2 minutes ago</small>
                            </div>
                        </div>
                    </a>
                    <a href="#" class="dropdown-item py-3 px-3 border-bottom">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <div class="avatar-sm bg-success rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-check-lg text-white"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">Payment Successful</h6>
                                <p class="mb-0 text-muted small">Payment for order #1234 completed</p>
                                <small class="text-muted">1 hour ago</small>
                            </div>
                        </div>
                    </a>
                    <a href="#" class="dropdown-item py-3 px-3">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <div class="avatar-sm bg-warning rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-star text-white"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">New Review</h6>
                                <p class="mb-0 text-muted small">John Doe reviewed "Baby Stroller"</p>
                                <small class="text-muted">5 hours ago</small>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="p-3 border-top text-center">
                    <a href="#" class="text-primary small">View All Notifications</a>
                </div>
            `;
            
            // Position and show dropdown
            const rect = notificationBtn.getBoundingClientRect();
            notificationMenu.style.top = rect.bottom + 5 + 'px';
            notificationMenu.style.right = window.innerWidth - rect.right + 'px';
            
            document.body.appendChild(notificationMenu);
            
            // Close dropdown when clicking outside
            const closeNotification = (e) => {
                if (!notificationBtn.contains(e.target) && !notificationMenu.contains(e.target)) {
                    notificationMenu.remove();
                    document.removeEventListener('click', closeNotification);
                }
            };
            
            setTimeout(() => {
                document.addEventListener('click', closeNotification);
            }, 0);
        });

        // Confirm delete function
        function confirmDelete(event, message = 'Are you sure you want to delete this item?') {
            if (!confirm(message)) {
                event.preventDefault();
            }
        }

        // Add animation to page load
        document.addEventListener('DOMContentLoaded', () => {
            document.body.style.opacity = '0';
            document.body.style.transition = 'opacity 0.3s';
            
            setTimeout(() => {
                document.body.style.opacity = '1';
            }, 100);
        });
    </script>
    
    @yield('scripts')
</body>
</html>