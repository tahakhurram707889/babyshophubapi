<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return response()->json(['status' => true, 'categories' => $categories]);
    }

    public function store(Request $request)
    {
        $request->validate(['name'=>'required|string|max:255']);

        $category = Category::create($request->all());

        return response()->json(['status' => true, 'message' => 'Category created.', 'category' => $category], 201);
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate(['name'=>'required|string|max:255']);

        $category->update($request->all());

        return response()->json(['status' => true, 'message' => 'Category updated.', 'category' => $category]);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return response()->json(['status' => true, 'message' => 'Category deleted.']);
    }
}
