<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function stats()
    {
        // Total Users
        $totalUsers = User::count();

        // Total Products
        $totalProducts = Product::count();

        // Total Orders
        $totalOrders = Order::count();

        // Total Revenue
        $totalRevenue = Order::where('status', 'completed')->sum('total_amount');

        return response()->json([
            'message' => 'Dashboard Stats Loaded',
            'data' => [
                'total_users'    => $totalUsers,
                'total_products' => $totalProducts,
                'total_orders'   => $totalOrders,
                'total_revenue'  => $totalRevenue,
            ]
        ], 200);
    }
}
