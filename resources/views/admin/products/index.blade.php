@extends('layouts.admin')

@section('title', 'مدیریت کاتالوگ محصولات')

@section('content')
<div class="space-y-4 sm:space-y-6">
    <!-- Action Bar -->
    <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
        <form action="{{ route('admin.products.index') }}" method="GET" class="flex items-center gap-2 w-full sm:w-auto">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="جستجو نام یا کد کالا (SKU)..." 
                   class="px-3.5 py-2.5 text-xs bg-white border border-slate-200 rounded-xl sm:rounded-2xl flex-1 sm:w-80 focus:outline-none focus:border-slate-400 font-medium shadow-xs">
            <button type="submit" class="px-4 py-2.5 bg-slate-900 active:bg-black text-white font-bold text-xs rounded-xl sm:rounded-2xl shadow transition shrink-0">
                جستجو
            </button>
        </form>

        <a href="{{ route('admin.products.create') }}" class="px-4 py-2.5 bg-[#ef394e] hover:bg-rose-600 text-white font-bold text-xs rounded-xl sm:rounded-2xl shadow-md transition flex items-center justify-center gap-2">
            <i class="fa-solid fa-plus text-xs"></i>
            <span>افزودن محصول جدید</span>
        </a>
    </div>

    <!-- Mobile Products Card List -->
    @include('admin.products.products-mobile-list')

    <!-- Desktop Products Table -->
    <div class="hidden sm:block bg-white rounded-3xl border border-slate-200/80 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-right text-xs">
                <thead class="bg-slate-50 text-slate-400 font-bold">
                    <tr>
                        <th class="p-4">نام کالا</th>
                        <th class="p-4">کد (SKU)</th>
                        <th class="p-4">دسته‌بندی</th>
                        <th class="p-4">قیمت اصلی</th>
                        <th class="p-4">قیمت تخفیف</th>
                        <th class="p-4">موجودی</th>
                        <th class="p-4">وضعیت</th>
                        <th class="p-4 text-left">عملیات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($products as $product)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-12 bg-slate-100 rounded-xl overflow-hidden shrink-0 flex items-center justify-center p-0.5 border">
                                        @if($product->featured_image)
                                            <img src="{{ $product->featured_image }}" alt="{{ $product->name }}" class="w-full h-full object-cover rounded-lg">
                                        @else
                                            <i class="fa-solid fa-image text-slate-300"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <a href="{{ route('product.show', $product->slug) }}" target="_blank" class="font-bold text-slate-800 hover:text-[#ef394e] transition block line-clamp-1">
                                            {{ $product->name }}
                                        </a>
                                        @if($product->has_discount)
                                            <span class="inline-block px-1.5 py-0.2 bg-rose-100 text-[#ef394e] text-[9px] font-black rounded-md">
                                                ٪{{ $product->discount_percentage }} تخفیف
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="p-4 font-mono text-slate-500 font-bold">{{ $product->sku }}</td>
                            <td class="p-4 font-bold text-sky-600">{{ $product->category?->name ?? '-' }}</td>
                            <td class="p-4 font-black text-slate-900">{{ number_format($product->price) }} تومان</td>
                            <td class="p-4 font-bold text-emerald-600">
                                {{ $product->sale_price ? number_format($product->sale_price) . ' تومان' : '-' }}
                            </td>
                            <td class="p-4 font-bold">
                                <span class="px-2.5 py-1 rounded-xl text-[11px] {{ $product->stock <= 5 ? 'bg-rose-100 text-rose-700' : 'bg-slate-100 text-slate-800' }}">
                                    {{ $product->stock }} عدد
                                </span>
                            </td>
                            <td class="p-4">
                                <div class="flex flex-col gap-1 items-start">
                                    <span class="px-2 py-0.5 rounded-md text-[10px] font-bold {{ $product->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-500' }}">
                                        {{ $product->is_active ? 'فعال' : 'غیرفعال' }}
                                    </span>
                                    @if($product->is_featured)
                                        <span class="px-2 py-0.5 rounded-md text-[9px] font-black bg-amber-100 text-amber-800">
                                            ★ ویژه
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="p-4 text-left">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs rounded-xl transition">
                                        ویرایش
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline" onsubmit="return confirm('آیا از حذف این محصول اطمینان دارید؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold text-xs rounded-xl transition">
                                            حذف
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">{{ $products->links() }}</div>
</div>
@endsection

