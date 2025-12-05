<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // ⭐ List All Products (with search + category filter)
    public function index(Request $request)
    {
        $query = Product::query();

        // 🔎 Search
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // 🔎 Filter by category
        if ($request->has('category_id') && $request->category_id != '') {
            $query->where('category_id', $request->category_id);
        }

        $products = $query->with('category')->get();

        return response()->json([
            'status' => true,
            'products' => $products
        ]);
    }

    // ⭐ Show Single Product (with reviews)
    public function show($id)
    {
        $product = Product::with('category', 'reviews.user')->find($id);

        if (!$product) {
            return response()->json([
                'status'  => false,
                'message' => 'Product not found'
            ], 404);
        }

        return response()->json([
            'status'  => true,
            'product' => $product
        ]);
    }

    // ⭐ Add New Product (ADMIN)
    public function store(ProductRequest $request)
    {
        $product = Product::create($request->validated());

        return response()->json([
            'status'  => true,
            'message' => 'Product created successfully',
            'product' => $product
        ], 201);
    }

    // ⭐ Update Product (ADMIN)
    public function update(ProductRequest $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'status'  => false,
                'message' => 'Product not found'
            ], 404);
        }

        $product->update($request->validated());

        return response()->json([
            'status'  => true,
            'message' => 'Product updated successfully',
            'product' => $product
        ]);
    }

    // ⭐ Delete Product (ADMIN)
    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'status'  => false,
                'message' => 'Product not found'
            ], 404);
        }

        $product->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Product deleted successfully'
        ]);
    }
}
