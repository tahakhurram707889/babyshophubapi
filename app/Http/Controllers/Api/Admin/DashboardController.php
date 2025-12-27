<?php
// app/Http\Controllers\Admin\DashboardController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Total Users
        $totalUsers = User::count();

        // Total Products
        $totalProducts = Product::count();

        // Total Orders
        $totalOrders = Order::count();

        // Total Revenue
        $totalRevenue = Order::where('status', 'completed')->sum('total_amount');

        // Recent Orders
        $recentOrders = Order::with('user')->latest()->take(5)->get();
        
        return view('admin.dashboard', compact(
            'totalUsers', 
            'totalProducts', 
            'totalOrders', 
            'totalRevenue',
            'recentOrders'
        ));
    }
}