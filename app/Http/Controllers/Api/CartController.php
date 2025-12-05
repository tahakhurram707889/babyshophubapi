<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartRequest;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // ⭐ Get User Cart List
    public function cartList()
    {
        $cartItems = Cart::with('product')
            ->where('user_id', auth()->id())
            ->get();

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

    // ⭐ Add to Cart
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1'
        ]);

        $product = Product::find($request->product_id);

        // Check if already in cart
        $cartItem = Cart::where('user_id', auth()->id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($cartItem) {
            // if exists → increase quantity
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            // otherwise create new cart item
            Cart::create([
                'user_id'    => auth()->id(),
                'product_id' => $request->product_id,
                'quantity'   => $request->quantity,
            ]);
        }

        return response()->json([
            'status'  => true,
            'message' => 'Product added to cart successfully'
        ], 201);
    }

    // ⭐ Update Cart Quantity
    public function updateCart(Request $request)
    {
        $request->validate([
            'cart_id'  => 'required|exists:carts,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $cartItem = Cart::where('id', $request->cart_id)
            ->where('user_id', auth()->id())
            ->first();

        if (!$cartItem) {
            return response()->json([
                'status'  => false,
                'message' => 'Cart item not found'
            ], 404);
        }

        // update quantity
        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return response()->json([
            'status'  => true,
            'message' => 'Cart updated successfully'
        ]);
    }

    // ⭐ Remove Cart Item
    public function removeCartItem($id)
    {
        $cartItem = Cart::where('id', $id)
            ->where('user_id', auth()->id())
            ->first();

        if (!$cartItem) {
            return response()->json([
                'status'  => false,
                'message' => 'Cart item not found'
            ], 404);
        }

        $cartItem->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Item removed from cart'
        ]);
    }
}
