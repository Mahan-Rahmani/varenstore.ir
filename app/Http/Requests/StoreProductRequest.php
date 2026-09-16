<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        $productId = $this->route('product')?->id;

        return [
            'category_id' => ['required', 'exists:categories,id'],
            'sku' => ['required', 'string', 'max:50', 'unique:products,sku,' . $productId],
            'name' => ['required', 'string', 'max:255'],
            'short_description' => ['nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'sale_price' => ['nullable', 'numeric', 'min:0', 'lt:price'],
            'stock' => ['required', 'integer', 'min:0'],
            'featured_image' => ['nullable', 'string', 'max:500'],
            'gallery_images' => ['nullable', 'array'],
            'gallery_images.*' => ['nullable', 'string', 'max:500'],
            'is_active' => ['nullable', 'boolean'],
            'is_featured' => ['nullable', 'boolean'],
            'size_guide_image' => ['nullable', 'string', 'max:500'],
            'available_sizes' => ['nullable', 'array'],
            'available_colors' => ['nullable', 'array'],
            'attributes' => ['nullable', 'array'],
            'attributes.*.name' => ['required_with:attributes.*.value', 'string'],
            'attributes.*.value' => ['required_with:attributes.*.name', 'string'],
        ];
    }
}
