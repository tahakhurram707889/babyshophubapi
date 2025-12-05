<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('items.product', 'user')->orderBy('id','desc')->get();
        return response()->json(['status'=>true,'orders'=>$orders]);
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $request->validate(['status'=>'required|string|in:pending,processing,completed,cancelled']);

        $order->status = $request->status;
        $order->save();

        return response()->json(['status'=>true,'message'=>'Order status updated.','order'=>$order]);
    }
}
