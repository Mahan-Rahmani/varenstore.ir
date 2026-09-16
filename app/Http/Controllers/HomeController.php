<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')->active();

        // Category Filter
        if ($request->filled('category')) {
            $category = Category::where('slug', $request->query('category'))->first();
            if ($category) {
                // Include subcategories
                $categoryIds = Category::where('id', $category->id)
                    ->orWhere('parent_id', $category->id)
                    ->pluck('id');
                $query->whereIn('category_id', $categoryIds);
            }
        }

        // Search Filter
        if ($request->filled('search')) {
            $search = $request->query('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        // Sorting
        $sort = $request->query('sort', 'latest');
        match ($sort) {
            'price_low' => $query->orderBy('price', 'asc'),
            'price_high' => $query->orderBy('price', 'desc'),
            default => $query->latest(),
        };

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::roots()->with('children')->active()->orderBy('sort_order')->get();
        $featuredProducts = Product::active()->featured()->take(4)->get();

        // Today's High-Discount Products (ordered by highest discount percentage)
        $discountedProducts = Product::with('category')
            ->active()
            ->discounted()
            ->orderByDiscount('desc')
            ->take(12)
            ->get();

        // Hero Sliders
        $sliders = Slider::active()->ordered()->get();

        return view('shop.index', compact('products', 'categories', 'featuredProducts', 'discountedProducts', 'sliders'));
    }

    public function show(string $slug)
    {
        $product = Product::with(['category', 'attributes'])
            ->active()
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedProducts = Product::active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('shop.show', compact('product', 'relatedProducts'));
    }
}
