<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user', 'items.product')
            ->latest()
            ->paginate(10);
        
        // Calculate statistics
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $completedOrders = Order::where('status', 'completed')->count();
        $totalRevenue = Order::where('status', 'completed')->sum('total_amount');
        
        return view('admin.orders.index', compact('orders', 'totalOrders', 'pendingOrders', 'completedOrders', 'totalRevenue'));
    }
    
    public function show($id)
    {
        $order = Order::with('user', 'items.product' , 'user.address')->findOrFail($id);
        
        // Get order statistics for sidebar
        $orderStats = [
            'total_items' => $order->items->sum('quantity'),
            'subtotal' => $order->items->sum(function($item) {
                return $item->price * $item->quantity;
            }),
            'tax' => 0, // Add tax if applicable
            'shipping' => 0, // Add shipping if applicable
        ];
        
        return view('admin.orders.show', compact('order', 'orderStats'));
    }
    
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled'
        ]);
        
        $order->status = $request->status;
        $order->save();
        
        return back()->with('success', 'Order status updated successfully.');
    }
    
    public function updatePaymentStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        
        $request->validate([
            'payment_status' => 'required|in:pending,paid,failed,refunded'
        ]);
        
        $order->payment_status = $request->payment_status;
        $order->save();
        
        return back()->with('success', 'Payment status updated successfully.');
    }
    
    // Add these methods for address and phone update
    public function updateShippingInfo(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        
        $request->validate([
            'phone' => 'nullable|string|max:20',
            'shipping_address' => 'nullable|string|max:500'
        ]);
        
        $order->phone = $request->phone;
        $order->shipping_address = $request->shipping_address;
        $order->save();
        
        return back()->with('success', 'Shipping information updated successfully.');
    }
    
    // Bulk actions
    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'order_ids' => 'required|array',
            'order_ids.*' => 'exists:orders,id',
            'action' => 'required|in:complete,cancel,delete'
        ]);
        
        $orders = Order::whereIn('id', $request->order_ids);
        
        switch($request->action) {
            case 'complete':
                $orders->update(['status' => 'completed']);
                break;
            case 'cancel':
                $orders->update(['status' => 'cancelled']);
                break;
            case 'delete':
                $orders->delete();
                break;
        }
        
        return back()->with('success', 'Bulk action completed successfully.');
    }
}