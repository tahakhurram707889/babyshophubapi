<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // ⭐ Place Order
    public function placeOrder(Request $request)
{
    $user = $request->user();

    // 1️⃣ Get user's cart
    $cart = \App\Models\Cart::where('user_id', $user->id)->first();

    if (!$cart) {
        return response()->json([
            'status' => false,
            'message' => 'Your cart is empty.'
        ], 400);
    }

    // 2️⃣ Get cart items via cart_id
    $cartItems = CartItem::with('product')
        ->where('cart_id', $cart->id)
        ->get();

    if ($cartItems->isEmpty()) {
        return response()->json([
            'status' => false,
            'message' => 'Your cart is empty.'
        ], 400);
    }

    // 3️⃣ Calculate total
    $total = $cartItems->sum(fn($item) =>
        $item->quantity * $item->product->price
    );

    // 4️⃣ Create order
    $order = Order::create([
        'user_id' => $user->id,
        'total_amount' => $total,
        'status' => 'pending',
        'payment_status' => 'pending',
    ]);

    // 5️⃣ Create order items
    foreach ($cartItems as $item) {
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $item->product_id,
            'quantity' => $item->quantity,
            'price' => $item->product->price,
        ]);
    }

    // 6️⃣ Clear cart items
    CartItem::where('cart_id', $cart->id)->delete();

    return response()->json([
        'status' => true,
        'message' => 'Order placed successfully',
        'order' => $order
    ], 201);
}


    // ⭐ Order History
    public function orderHistory(Request $request)
    {
        $orders = Order::with('items.product')
            ->where('user_id', $request->user()->id)
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'orders' => $orders
        ]);
    }

    // ⭐ Order Details
    public function orderDetails(Request $request, $id)
    {
        $order = Order::with('items.product')
            ->where('id', $id)
            ->where('user_id', $request->user()->id)
            ->first();

        if (!$order) {
            return response()->json([
                'status' => false,
                'message' => 'Order not found.'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'order' => $order
        ]);
    }

   
}
