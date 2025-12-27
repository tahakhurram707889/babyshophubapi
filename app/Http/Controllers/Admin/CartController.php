<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::with(['user', 'items.product'])
            ->withCount('items')
            ->withSum('items', 'quantity')
            ->latest()
            ->paginate(15);
            
        $totalCarts = Cart::count();
        $totalCartItems = CartItem::sum('quantity');
        $averageItemsPerCart = $totalCarts > 0 ? $totalCartItems / $totalCarts : 0;
        
        return view('admin.carts.index', compact('carts', 'totalCarts', 'totalCartItems', 'averageItemsPerCart'));
    }
    
    public function show($id)
    {
        $cart = Cart::with(['user', 'items.product.category'])
            ->findOrFail($id);
            
        $cartStats = [
            'total_items' => $cart->items->sum('quantity'),
            'total_value' => $cart->items->sum(function($item) {
                return $item->quantity * ($item->product->price ?? 0);
            }),
            'unique_products' => $cart->items->count()
        ];
        
        return view('admin.carts.show', compact('cart', 'cartStats'));
    }
    
    public function destroy($id)
    {
        $cart = Cart::findOrFail($id);
        $cart->delete();
        
        return redirect()->route('admin.carts.index')
            ->with('success', 'Cart cleared successfully.');
    }
}