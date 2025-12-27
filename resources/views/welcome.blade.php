<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Baby Shop Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">👶 Baby Shop Hub</a>
            <!-- Baby shop -->
            <div class="navbar-nav ms-auto">
                @auth
                    @if(Auth::user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" class="nav-link me-3">📊 Admin Dashboard</a>
                    @else
                        <span class="nav-link me-3">Welcome, {{ Auth::user()->name }}</span>
                    @endif
                    
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary">Admin Login</a>
                @endauth
            </div>
        </div>
    </nav>
    
    <div class="container mt-5">
        <div class="text-center">
            <h1 class="display-4 mb-4">Welcome to Baby Shop Hub</h1>
            <p class="lead mb-4">Your one-stop solution for baby products e-commerce</p>
            
            @auth
                <div class="alert alert-success">
                    <h5>You are logged in!</h5>
                    <p>Name: {{ Auth::user()->name }}</p>
                    <p>Email: {{ Auth::user()->email }}</p>
                    <p>Role: {{ Auth::user()->is_admin ? 'Administrator' : 'Customer' }}</p>
                    
                    @if(Auth::user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-success mt-2">
                            Go to Admin Dashboard
                        </a>
                    @endif
                </div>
            @else
                <div class="alert alert-info">
                    <h5>Admin Access Required</h5>
                    <p>Please login to access the admin panel.</p>
                    <a href="{{ route('login') }}" class="btn btn-primary">Admin Login</a>
                </div>
            @endauth
        </div>
    </div>
    
    <footer class="mt-5 py-3 bg-light text-center">
        <div class="container">
            <p class="mb-0">© {{ date('Y') }} Baby Shop Hub. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>