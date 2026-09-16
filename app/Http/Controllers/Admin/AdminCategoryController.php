<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class AdminCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|url',
            'description' => 'nullable|string'
        ]);
        
        Category::create([
            'name' => $request->name,
            'image' => $request->image,
            'description' => $request->description,
            'is_active' => true
        ]);
        
        return back()->with('success', 'دسته‌بندی با موفقیت ایجاد شد.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return back()->with('success', 'دسته‌بندی با موفقیت حذف شد.');
    }
}
