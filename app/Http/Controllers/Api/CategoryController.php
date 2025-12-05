<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
    // ⭐ Get All Categories
    public function index()
    {
        $categories = Category::withCount('products')->get();

        return response()->json([
            'status' => true,
            'categories' => $categories
        ], 200);
    }

    // ⭐ Get Products Under A Category
    public function products($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'status'  => false,
                'message' => 'Category not found'
            ], 404);
        }

        $products = Product::where('category_id', $id)->get();

        return response()->json([
            'status'  => true,
            'category' => $category->name,
            'products' => $products
        ]);
    }

    // ⭐ (ADMIN) Add New Category
    public function store(CategoryRequest $request)
    {
        $category = Category::create($request->validated());

        return response()->json([
            'status'  => true,
            'message' => 'Category created successfully',
            'category' => $category
        ], 201);
    }

    // ⭐ (ADMIN) Update Category
    public function update(CategoryRequest $request, $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'status' => false,
                'message' => 'Category not found'
            ], 404);
        }

        $category->update($request->validated());

        return response()->json([
            'status'  => true,
            'message' => 'Category updated successfully',
            'category' => $category
        ]);
    }

    // ⭐ (ADMIN) Delete Category
    public function destroy($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'status' => false,
                'message' => 'Category not found'
            ], 404);
        }

        $category->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Category deleted successfully'
        ]);
    }
}
