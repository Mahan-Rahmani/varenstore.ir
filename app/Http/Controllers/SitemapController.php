<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $products = Product::active()->latest()->get();
        $categories = Category::active()->get();

        $content = view('sitemap', compact('products', 'categories'));

        return response($content, 200)
            ->header('Content-Type', 'text/xml');
    }
}
