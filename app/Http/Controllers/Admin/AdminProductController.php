<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->filled('search')) {
            $search = $request->query('search');
            $query->where('name', 'like', "%{$search}%")->orWhere('sku', 'like', "%{$search}%");
        }

        $products = $query->latest()->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();
        $attributesData = $data['attributes'] ?? [];
        $availableSizes = $data['available_sizes'] ?? [];
        $availableColors = $data['available_colors'] ?? [];
        $sizeGuideImage = $data['size_guide_image'] ?? null;

        unset($data['attributes'], $data['available_sizes'], $data['available_colors'], $data['size_guide_image']);

        $data['is_active'] = $request->boolean('is_active');
        $data['is_featured'] = $request->boolean('is_featured');
        if (isset($data['gallery_images'])) {
            $data['gallery_images'] = array_values(array_filter($data['gallery_images']));
        }

        $product = Product::create($data);

        // Process size, color & size guide attributes
        if (!empty($availableSizes)) {
            $attributesData[] = [
                'name' => 'سایز',
                'value' => implode(',', $availableSizes),
            ];
        }

        if (!empty($availableColors)) {
            $attributesData[] = [
                'name' => 'رنگ',
                'value' => implode(',', $availableColors),
            ];
        }

        if (!empty($sizeGuideImage)) {
            $attributesData[] = [
                'name' => 'راهنمای سایز',
                'value' => $sizeGuideImage,
            ];
        }

        foreach ($attributesData as $attr) {
            if (!empty($attr['name']) && !empty($attr['value'])) {
                ProductAttribute::create([
                    'product_id' => $product->id,
                    'attribute_name' => $attr['name'],
                    'attribute_value' => $attr['value'],
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'محصول با موفقیت ایجاد شد.');
    }

    public function edit(Product $product)
    {
        $product->load('attributes');
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(StoreProductRequest $request, Product $product)
    {
        $data = $request->validated();
        $attributesData = $data['attributes'] ?? [];
        $availableSizes = $data['available_sizes'] ?? [];
        $availableColors = $data['available_colors'] ?? [];
        $sizeGuideImage = $data['size_guide_image'] ?? null;

        unset($data['attributes'], $data['available_sizes'], $data['available_colors'], $data['size_guide_image']);

        $data['is_active'] = $request->boolean('is_active');
        $data['is_featured'] = $request->boolean('is_featured');
        if (isset($data['gallery_images'])) {
            $data['gallery_images'] = array_values(array_filter($data['gallery_images']));
        }

        $product->update($data);

        // Filter out existing size/color/size-guide from manual attributes array to prevent duplication
        $attributesData = array_filter($attributesData, function ($attr) {
            return !in_array($attr['name'] ?? '', ['سایز', 'رنگ', 'راهنمای سایز']);
        });

        // Process size, color & size guide attributes
        if (!empty($availableSizes)) {
            $attributesData[] = [
                'name' => 'سایز',
                'value' => implode(',', $availableSizes),
            ];
        }

        if (!empty($availableColors)) {
            $attributesData[] = [
                'name' => 'رنگ',
                'value' => implode(',', $availableColors),
            ];
        }

        if (!empty($sizeGuideImage)) {
            $attributesData[] = [
                'name' => 'راهنمای سایز',
                'value' => $sizeGuideImage,
            ];
        }

        // Sync attributes
        $product->attributes()->delete();
        foreach ($attributesData as $attr) {
            if (!empty($attr['name']) && !empty($attr['value'])) {
                ProductAttribute::create([
                    'product_id' => $product->id,
                    'attribute_name' => $attr['name'],
                    'attribute_value' => $attr['value'],
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'محصول با موفقیت به‌روزرسانی شد.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return back()->with('success', 'Product deleted successfully.');
    }
}
