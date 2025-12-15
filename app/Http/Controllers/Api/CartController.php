<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Get User Cart List
    public function cartList()
    {
        $cart = Cart::with('items.product')->firstOrCreate([
            'user_id' => auth()->id(),
        ]);

        $cartItems = $cart->items;

        // Calculate total price
        $total = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        return response()->json([
            'status' => true,
            'cart_items' => $cartItems,
            'total_price' => $total
        ]);
    }

    // Add to Cart
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1'
        ]);

        // Get or create user's cart
        $cart = Cart::firstOrCreate([
            'user_id' => auth()->id(),
        ]);

        // Check if product already in cart
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $request->product_id)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            CartItem::create([
                'cart_id'    => $cart->id,
                'product_id' => $request->product_id,
                'quantity'   => $request->quantity,
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Product added to cart successfully'
        ], 201);
    }

    // Update Cart Quantity
    public function updateCart(Request $request)
    {
        $request->validate([
            'cart_item_id' => 'required|exists:cart_items,id',
            'quantity'     => 'required|integer|min:1'
        ]);

        $cartItem = CartItem::where('id', $request->cart_item_id)
            ->whereHas('cart', fn($q) => $q->where('user_id', auth()->id()))
            ->first();

        if (!$cartItem) {
            return response()->json([
                'status' => false,
                'message' => 'Cart item not found'
            ], 404);
        }

        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return response()->json([
            'status' => true,
            'message' => 'Cart updated successfully'
        ]);
    }

    // Remove Cart Item
    public function removeCartItem($id)
    {
        $cartItem = CartItem::where('id', $id)
            ->whereHas('cart', fn($q) => $q->where('user_id', auth()->id()))
            ->first();

        if (!$cartItem) {
            return response()->json([
                'status' => false,
                'message' => 'Cart item not found'
            ], 404);
        }

        $cartItem->delete();

        return response()->json([
            'status' => true,
            'message' => 'Item removed from cart'
        ]);
    }
}
