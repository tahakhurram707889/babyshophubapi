<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    // ✔ List All Products
    public function index()
    {
        $products = Product::with('category')->get();
        return response()->json([
            'status' => true,
            'products' => $products
        ]);
    }

    // ✔ Create Product
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'slug'        => 'nullable',
            'price'       => 'required|numeric',
            'stock'       => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'image'       => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Auto Slug
        $slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->name);

        // Upload Image
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        // Create Product
        $product = Product::create([
            'name'        => $request->name,
            'slug'        => $slug,
            'price'       => $request->price,
            'stock'       => $request->stock,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'image'       => $imagePath,
        ]);

        return response()->json([
            'message' => 'Product created successfully',
            'product' => $product
        ], 201);
    }

    // ✔ Single Product
    public function show($id)
    {
        $product = Product::findOrFail($id);

        return response()->json([
            'status'  => true,
            'product' => $product
        ]);
    }

    // ✔ Update Product
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name'        => 'required|string|max:255',
            'slug'        => 'nullable',
            'price'       => 'required|numeric',
            'stock'       => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Slug
        $slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->name);

        // NEW IMAGE Upload
        if ($request->hasFile('image')) {

            // Delete old image
            if ($product->image && file_exists(storage_path('app/public/' . $product->image))) {
                unlink(storage_path('app/public/' . $product->image));
            }

            $imagePath = $request->file('image')->store('products', 'public');
        } else {
            $imagePath = $product->image;
        }

        // Update
        $product->update([
            'name'        => $request->name,
            'slug'        => $slug,
            'price'       => $request->price,
            'stock'       => $request->stock,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'image'       => $imagePath,
        ]);

        return response()->json([
            'message' => 'Product updated successfully',
            'product' => $product
        ]);
    }

    // ✔ Delete Product
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Delete image
        if ($product->image && file_exists(storage_path('app/public/' . $product->image))) {
            unlink(storage_path('app/public/' . $product->image));
        }

        $product->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Product deleted successfully'
        ]);
    }
}
