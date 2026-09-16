@extends('layouts.admin')

@section('title', 'ویرایش محصول: ' . $product->name)

@section('content')
@php
    $galleryList = is_array($product->gallery_images) && !empty($product->gallery_images) ? $product->gallery_images : [''];
    $attrList = $product->attributes->count() > 0 
        ? $product->attributes->map(fn($a) => ['name' => $a->attribute_name, 'value' => $a->attribute_value])->values()->all() 
        : [['name' => '', 'value' => '']];
    
    $existingSizes = $product->attributes->where('attribute_name', 'سایز')->first()?->attribute_value;
    $existingSizesArray = $existingSizes ? array_map('trim', explode(',', $existingSizes)) : [];
    
    $existingColors = $product->attributes->where('attribute_name', 'رنگ')->first()?->attribute_value;
    $existingColorsArray = $existingColors ? array_map('trim', explode(',', $existingColors)) : [];
    
    $existingSizeGuide = $product->attributes->where('attribute_name', 'راهنمای سایز')->first()?->attribute_value;
@endphp

<div class="max-w-4xl mx-auto bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 shadow-sm"
     x-data="{
         price: '{{ old('price', (int)$product->price) }}',
         salePrice: '{{ old('sale_price', $product->sale_price ? (int)$product->sale_price : '') }}',
         gallery: {{ json_encode(old('gallery_images', $galleryList)) }},
         selectedSizes: {{ json_encode(old('available_sizes', $existingSizesArray)) }},
         presetSizes: ['S', 'M', 'L', 'XL', '2XL', '3XL', 'Oversize', 'Free Size'],
         selectedColors: {{ json_encode(old('available_colors', $existingColorsArray)) }},
         presetColors: [
             { name: 'مشکی', hex: '#18181b', bg: 'bg-zinc-900' },
             { name: 'سفید', hex: '#ffffff', bg: 'bg-white border-zinc-300' },
             { name: 'زغالی', hex: '#3f3f46', bg: 'bg-zinc-700' },
             { name: 'سرمه‌ای', hex: '#1e3a8a', bg: 'bg-blue-900' },
             { name: 'طوسی', hex: '#9ca3af', bg: 'bg-gray-400' },
             { name: 'کرم', hex: '#fef3c7', bg: 'bg-amber-100 border-amber-300' },
             { name: 'قرمز', hex: '#dc2626', bg: 'bg-red-600' },
             { name: 'زیتونی', hex: '#3f6212', bg: 'bg-lime-800' }
         ],
         attributes: {{ json_encode(old('attributes', $attrList)) }},
         toggleSize(sz) {
             if (this.selectedSizes.includes(sz)) {
                 this.selectedSizes = this.selectedSizes.filter(s => s !== sz);
             } else {
                 this.selectedSizes.push(sz);
             }
         },
         toggleColor(clr) {
             if (this.selectedColors.includes(clr)) {
                 this.selectedColors = this.selectedColors.filter(c => c !== clr);
             } else {
                 this.selectedColors.push(clr);
             }
         },
         get discountPercentage() {
             const p = parseFloat(this.price);
             const sp = parseFloat(this.salePrice);
             if (p > 0 && sp < p) {
                 return Math.round(((p - sp) / p) * 100);
             }
             return 0;
         }
     }">
    <div class="flex items-center justify-between pb-4 mb-6 border-b border-slate-100">
        <div>
            <h2 class="text-base font-black text-slate-900 mb-1">ویرایش مشخصات و قیمت کالا</h2>
            <p class="text-xs text-slate-400">شناسه کالا: {{ $product->sku }}</p>
        </div>
        <a href="{{ route('admin.products.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition">
            انصراف و بازگشت
        </a>
    </div>

    @if($errors->any())
        <div class="p-4 mb-6 text-rose-800 bg-rose-50 border border-rose-200 rounded-2xl text-xs font-bold space-y-1">
            @foreach($errors->all() as $err)
                <p>• {{ $err }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs font-bold">
            <div>
                <label class="block mb-1.5 text-slate-700">عنوان و نام محصول *</label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}" required 
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:border-slate-400">
            </div>

            <div>
                <label class="block mb-1.5 text-slate-700">کد منحصر به فرد کالا (SKU) *</label>
                <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" required 
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:border-slate-400 font-mono">
            </div>

            <div>
                <label class="block mb-1.5 text-slate-700">دسته‌بندی *</label>
                <select name="category_id" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:border-slate-400">
                    <option value="">انتخاب دسته‌بندی</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block mb-1.5 text-slate-700">موجودی در انبار *</label>
                <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" min="0" required 
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:border-slate-400 font-mono">
            </div>

            <div>
                <label class="block mb-1.5 text-slate-700">قیمت اصلی (تومان) *</label>
                <input type="number" name="price" x-model="price" required 
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:border-slate-400 font-mono">
            </div>

            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label class="text-slate-700">قیمت با تخفیف حراج (تومان)</label>
                    <template x-if="discountPercentage > 0">
                        <span class="text-[10px] font-black text-white bg-[#ef394e] px-2 py-0.5 rounded-full" x-text="`٪${discountPercentage} تخفیف`"></span>
                    </template>
                </div>
                <input type="number" name="sale_price" x-model="salePrice" 
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:border-slate-400 font-mono"
                       placeholder="در صورت عدم تخفیف خالی بگذارید">
            </div>

            <!-- Switches for Active & Featured -->
            <div class="sm:col-span-2 flex flex-wrap items-center gap-6 p-4 bg-slate-50 rounded-2xl border border-slate-200/80">
                <label class="flex items-center gap-2.5 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }} class="w-4 h-4 text-[#ef394e] rounded border-slate-300">
                    <span class="text-xs font-bold text-slate-800">محصول فعال و قابل نمایش در سایت باشد</span>
                </label>

                <label class="flex items-center gap-2.5 cursor-pointer">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }} class="w-4 h-4 text-[#ef394e] rounded border-slate-300">
                    <span class="text-xs font-bold text-slate-800">محصول ویژه (نمایش در ویترین اصلی)</span>
                </label>
            </div>

            <!-- Featured Image -->
            <div class="sm:col-span-2">
                <label class="block mb-1.5 text-slate-700">آدرس تصویر اصلی شاخص (URL) *</label>
                <input type="url" name="featured_image" value="{{ old('featured_image', $product->featured_image) }}" placeholder="https://..." required 
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:border-slate-400 font-mono dir-ltr text-left">
            </div>

            <!-- Gallery Images -->
            <div class="sm:col-span-2 space-y-2 p-4 bg-slate-50/70 rounded-2xl border border-slate-200/80">
                <div class="flex items-center justify-between">
                    <label class="text-slate-800">تصاویر گالری (سایر زوایای محصول)</label>
                    <button type="button" @click="gallery.push('')" class="text-[11px] font-bold text-[#ef394e] hover:underline flex items-center gap-1">
                        <i class="fa-solid fa-plus text-[10px]"></i> افزودن لینک تصویر گالری
                    </button>
                </div>
                <template x-for="(img, idx) in gallery" :key="idx">
                    <div class="flex items-center gap-2">
                        <input type="url" :name="`gallery_images[${idx}]`" x-model="gallery[idx]" placeholder="https://..." 
                               class="flex-1 px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs font-mono dir-ltr text-left">
                        <button type="button" @click="gallery.splice(idx, 1)" class="w-8 h-8 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-100 flex items-center justify-center">
                            <i class="fa-solid fa-trash text-xs"></i>
                        </button>
                    </div>
                </template>
            </div>

            <!-- Quick Sizes Selection -->
            <div class="sm:col-span-2 space-y-3 p-4 bg-slate-50/70 rounded-2xl border border-slate-200/80">
                <label class="block text-slate-800 font-bold text-xs">
                    انتخاب سایزهای موجود پوشاک (روی سایزهای مورد نظر کلیک کنید)
                </label>
                <div class="flex flex-wrap gap-2">
                    <template x-for="sz in presetSizes" :key="sz">
                        <button type="button" 
                                @click="toggleSize(sz)" 
                                :class="selectedSizes.includes(sz) ? 'bg-black text-white border-black shadow-sm' : 'bg-white text-slate-700 border-slate-200 hover:border-slate-400'" 
                                class="px-3.5 py-1.5 border rounded-xl font-mono text-xs font-black transition duration-200 flex items-center gap-1.5">
                            <span x-text="sz"></span>
                            <i x-show="selectedSizes.includes(sz)" class="fa-solid fa-check text-[10px]"></i>
                        </button>
                    </template>
                </div>
                <!-- Hidden inputs for sizes -->
                <template x-for="(sz, idx) in selectedSizes" :key="idx">
                    <input type="hidden" name="available_sizes[]" :value="sz">
                </template>
            </div>

            <!-- Quick Colors Selection -->
            <div class="sm:col-span-2 space-y-3 p-4 bg-slate-50/70 rounded-2xl border border-slate-200/80">
                <label class="block text-slate-800 font-bold text-xs">
                    انتخاب رنگ‌های موجود پارچه (روی رنگ‌های مورد نظر کلیک کنید)
                </label>
                <div class="flex flex-wrap gap-2">
                    <template x-for="clr in presetColors" :key="clr.name">
                        <button type="button" 
                                @click="toggleColor(clr.name)" 
                                :class="selectedColors.includes(clr.name) ? 'ring-2 ring-offset-2 ring-[#ef394e] bg-slate-100 font-black' : 'bg-white text-slate-700 border-slate-200 hover:border-slate-300'" 
                                class="px-3 py-1.5 border rounded-xl text-xs transition duration-200 flex items-center gap-2">
                            <span class="w-3.5 h-3.5 rounded-full border border-slate-300" :class="clr.bg"></span>
                            <span x-text="clr.name"></span>
                            <i x-show="selectedColors.includes(clr.name)" class="fa-solid fa-check text-[10px] text-[#ef394e]"></i>
                        </button>
                    </template>
                </div>
                <!-- Hidden inputs for colors -->
                <template x-for="(clr, idx) in selectedColors" :key="idx">
                    <input type="hidden" name="available_colors[]" :value="clr">
                </template>
            </div>

            <!-- Size Guide Image URL -->
            <div class="sm:col-span-2">
                <label class="block mb-1.5 text-slate-700 font-bold text-xs">
                    آدرس تصویر جدول راهنمای سایزبندی (URL)
                </label>
                <input type="url" name="size_guide_image" value="{{ old('size_guide_image', $existingSizeGuide) }}" placeholder="https://.../size-guide.jpg" 
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:border-slate-400 font-mono dir-ltr text-left">
            </div>

            <!-- Attributes (Colors, Sizes, Specs) -->
            <div class="sm:col-span-2 space-y-3 p-4 bg-slate-50/70 rounded-2xl border border-slate-200/80">
                <div class="flex items-center justify-between">
                    <label class="text-slate-800">ویژگی‌های کالا (رنگ، سایز، جنس پارچه، نحوه شستشو و...)</label>
                    <button type="button" @click="attributes.push({name: '', value: ''})" class="text-[11px] font-bold text-[#ef394e] hover:underline flex items-center gap-1">
                        <i class="fa-solid fa-plus text-[10px]"></i> افزودن ویژگی جدید
                    </button>
                </div>

                <template x-for="(attr, idx) in attributes" :key="idx">
                    <div class="grid grid-cols-1 sm:grid-cols-5 gap-2 items-center">
                        <input type="text" :name="`attributes[${idx}][name]`" x-model="attr.name" placeholder="عنوان (مثال: رنگ)" 
                               class="sm:col-span-2 px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs">
                        <input type="text" :name="`attributes[${idx}][value]`" x-model="attr.value" placeholder="مقدار (مثال: مشکی)" 
                               class="sm:col-span-2 px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs">
                        <button type="button" @click="attributes.splice(idx, 1)" class="w-8 h-8 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-100 flex items-center justify-center justify-self-end">
                            <i class="fa-solid fa-trash text-xs"></i>
                        </button>
                    </div>
                </template>
            </div>

            <div class="sm:col-span-2">
                <label class="block mb-1.5 text-slate-700">توضیحات و نقد کالا</label>
                <textarea name="description" rows="4" 
                          class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:border-slate-400 font-normal leading-relaxed">{{ old('description', $product->description) }}</textarea>
            </div>
        </div>

        <div class="pt-4 border-t border-slate-100 flex justify-end">
            <button type="submit" class="px-6 py-3 bg-black hover:bg-[#ef394e] text-white font-black text-xs rounded-xl shadow transition duration-300">
                ذخیره و به‌روزرسانی محصول
            </button>
        </div>
    </form>
</div>
@endsection

