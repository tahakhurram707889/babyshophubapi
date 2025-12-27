<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Category;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Address;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WebDashboardController extends Controller
{
    public function index()
    {
        // ========== BASIC COUNTS ==========
        $totalUsers = User::count();
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalCategories = Category::count();
        $totalCarts = Cart::count();
        $totalAddresses = Address::count();
        $totalReviews = Review::count();
        
        // ========== REVENUE CALCULATIONS ==========
        $totalRevenue = Order::where('status', 'completed')->sum('total_amount');
        $pendingRevenue = Order::where('status', 'pending')->sum('total_amount');
        $processingRevenue = Order::where('status', 'processing')->sum('total_amount');
        $cancelledRevenue = Order::where('status', 'cancelled')->sum('total_amount');
        
        // ========== ORDER STATISTICS ==========
        $pendingOrders = Order::where('status', 'pending')->count();
        $processingOrders = Order::where('status', 'processing')->count();
        $completedOrders = Order::where('status', 'completed')->count();
        $cancelledOrders = Order::where('status', 'cancelled')->count();
        
        // ========== PAYMENT STATISTICS ==========
        $pendingPayments = Order::where('payment_status', 'pending')->count();
        $paidPayments = Order::where('payment_status', 'paid')->count();
        $failedPayments = Order::where('payment_status', 'failed')->count();
        $refundedPayments = Order::where('payment_status', 'refunded')->count();
        
        // ========== STOCK ANALYSIS ==========
        $totalStock = Product::sum('stock');
        $outOfStock = Product::where('stock', 0)->count();
        $lowStock = Product::where('stock', '>', 0)->where('stock', '<=', 10)->count();
        $inStock = Product::where('stock', '>', 10)->count();
        
        // ========== USER ANALYSIS ==========
        $adminUsers = User::where('is_admin', true)->count();
        $customerUsers = User::where('is_admin', false)->count();
        $newUsersToday = User::whereDate('created_at', today())->count();
        $newUsersThisWeek = User::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();
        
        // ========== MONTHLY DATA ==========
        // Monthly Revenue
        $monthlyRevenue = Order::selectRaw('
            MONTH(created_at) as month,
            MONTHNAME(created_at) as month_name,
            SUM(total_amount) as revenue,
            COUNT(*) as orders
        ')
        ->whereYear('created_at', date('Y'))
        ->where('status', 'completed')
        ->groupBy('month', 'month_name')
        ->orderBy('month')
        ->get();
        
        // Monthly Orders
        $monthlyOrders = Order::selectRaw('
            MONTH(created_at) as month,
            MONTHNAME(created_at) as month_name,
            COUNT(*) as total_orders,
            SUM(CASE WHEN status = "completed" THEN 1 ELSE 0 END) as completed_orders,
            SUM(CASE WHEN status = "pending" THEN 1 ELSE 0 END) as pending_orders
        ')
        ->whereYear('created_at', date('Y'))
        ->groupBy('month', 'month_name')
        ->orderBy('month')
        ->get();
        
        // ========== RECENT DATA ==========
        $recentOrders = Order::with('user')->latest()->take(10)->get();
        $recentProducts = Product::with('category')->latest()->take(10)->get();
        $recentUsers = User::latest()->take(10)->get();
        $recentReviews = Review::with('user', 'product')->latest()->take(10)->get();
        
        // ========== LOW STOCK PRODUCTS ==========
        $lowStockProducts = Product::where('stock', '<', 10)
            ->orderBy('stock')
            ->take(10)
            ->get();
        
        // ========== TOP SELLING PRODUCTS ==========
        $topProducts = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->selectRaw('
                products.id,
                products.name,
                products.image,
                SUM(order_items.quantity) as total_sold,
                SUM(order_items.quantity * order_items.price) as total_revenue
            ')
            ->groupBy('products.id', 'products.name', 'products.image')
            ->orderBy('total_sold', 'desc')
            ->take(10)
            ->get();
        
        // ========== CATEGORY WISE PRODUCTS ==========
        $categoryStats = Category::withCount('products')
            ->withSum('products', 'stock')
            ->orderBy('products_count', 'desc')
            ->get();
        
        // ========== USER ACTIVITY ==========
        $activeUsers = User::withCount(['orders', 'reviews'])
            ->orderBy('orders_count', 'desc')
            ->take(10)
            ->get();
        
        // ========== CART STATISTICS ==========
        $totalCartItems = CartItem::sum('quantity');
        $averageCartValue = Cart::has('items')->withSum('items', 'quantity')->get()->avg(function($cart) {
            return $cart->items_sum_quantity;
        });
        
        // ========== REVIEW RATINGS ==========
        $averageRating = Review::avg('rating');
        $ratingDistribution = Review::selectRaw('
            rating,
            COUNT(*) as count,
            ROUND(COUNT(*) * 100.0 / (SELECT COUNT(*) FROM product_reviews), 2) as percentage
        ')
        ->groupBy('rating')
        ->orderBy('rating', 'desc')
        ->get();
        
        return view('admin.dashboard', compact(
            // Basic Counts
            'totalUsers', 'totalProducts', 'totalOrders', 'totalCategories',
            'totalCarts', 'totalAddresses', 'totalReviews',
            
            // Revenue
            'totalRevenue', 'pendingRevenue', 'processingRevenue', 'cancelledRevenue',
            
            // Order Stats
            'pendingOrders', 'processingOrders', 'completedOrders', 'cancelledOrders',
            
            // Payment Stats
            'pendingPayments', 'paidPayments', 'failedPayments', 'refundedPayments',
            
            // Stock Analysis
            'totalStock', 'outOfStock', 'lowStock', 'inStock',
            
            // User Analysis
            'adminUsers', 'customerUsers', 'newUsersToday', 'newUsersThisWeek',
            
            // Monthly Data
            'monthlyRevenue', 'monthlyOrders',
            
            // Recent Data
            'recentOrders', 'recentProducts', 'recentUsers', 'recentReviews',
            
            // Low Stock
            'lowStockProducts',
            
            // Top Products
            'topProducts',
            
            // Category Stats
            'categoryStats',
            
            // User Activity
            'activeUsers',
            
            // Cart Stats
            'totalCartItems', 'averageCartValue',
            
            // Review Ratings
            'averageRating', 'ratingDistribution'
        ));
    }
}