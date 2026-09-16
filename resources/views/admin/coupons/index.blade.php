@extends('layouts.admin')

@section('title', 'مدیریت کدهای تخفیف')

@section('content')
<div class="space-y-6">
    <!-- Action Bar -->
    <div class="flex flex-wrap items-center justify-between gap-4">
        <form action="{{ route('admin.coupons.index') }}" method="GET" class="flex items-center gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="جستجوی کد تخفیف..." 
                   class="px-4 py-2.5 text-xs bg-white border border-slate-200 rounded-2xl w-64 focus:outline-none focus:border-slate-400 font-mono shadow-sm">
            
            <select name="type" onchange="this.form.submit()" class="px-3 py-2.5 text-xs bg-white border border-slate-200 rounded-2xl focus:outline-none font-bold">
                <option value="">همه انواع</option>
                <option value="percentage" {{ request('type') === 'percentage' ? 'selected' : '' }}>درصدی</option>
                <option value="fixed" {{ request('type') === 'fixed' ? 'selected' : '' }}>مبلغ ثابت</option>
            </select>

            <button type="submit" class="px-5 py-2.5 bg-slate-900 hover:bg-black text-white font-bold text-xs rounded-2xl shadow transition">
                جستجو
            </button>
        </form>

        <a href="{{ route('admin.coupons.create') }}" class="px-5 py-2.5 bg-[#ef394e] hover:bg-rose-600 text-white font-bold text-xs rounded-2xl shadow-md transition flex items-center gap-2">
            <i class="fa-solid fa-plus text-xs"></i>
            <span>تعریف کد تخفیف جدید</span>
        </a>
    </div>

    <!-- Coupons Table -->
    <div class="bg-white rounded-3xl border border-slate-200/80 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-right text-xs">
                <thead class="bg-slate-50 text-slate-400 font-bold">
                    <tr>
                        <th class="p-4">کد کوپن</th>
                        <th class="p-4">نوع و مقدار</th>
                        <th class="p-4">حداقل خرید / سقف</th>
                        <th class="p-4">مصرف</th>
                        <th class="p-4">انقضا</th>
                        <th class="p-4">وضعیت</th>
                        <th class="p-4 text-left">عملیات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($coupons as $coupon)
                        @php
                            $isExpired = $coupon->expires_at && now()->greaterThan($coupon->expires_at);
                        @endphp
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="p-4">
                                <span class="font-mono font-black text-sm text-slate-900 bg-slate-100 px-3 py-1 rounded-xl">
                                    {{ $coupon->code }}
                                </span>
                            </td>
                            <td class="p-4">
                                @if($coupon->type === \App\Enums\CouponType::PERCENTAGE)
                                    <span class="px-2.5 py-1 bg-purple-100 text-purple-800 font-black rounded-lg text-xs">
                                        {{ (int)$coupon->value }}٪ درصدی
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 bg-blue-100 text-blue-800 font-black rounded-lg text-xs">
                                        {{ number_format($coupon->value) }} تومان
                                    </span>
                                @endif
                            </td>
                            <td class="p-4 font-bold text-slate-700">
                                <div>
                                    <span class="text-slate-400 text-[10px] block">حداقل:</span>
                                    <span>{{ $coupon->min_order_amount ? number_format($coupon->min_order_amount) . ' تومان' : 'بدون شرط' }}</span>
                                </div>
                                @if($coupon->max_discount_amount)
                                    <div class="mt-0.5">
                                        <span class="text-slate-400 text-[10px] block">سقف:</span>
                                        <span class="text-rose-600">{{ number_format($coupon->max_discount_amount) }} تومان</span>
                                    </div>
                                @endif
                            </td>
                            <td class="p-4 font-bold">
                                <span class="text-slate-900 font-black">{{ $coupon->used_count }}</span>
                                <span class="text-slate-400">/ {{ $coupon->usage_limit ?? 'نامحدود' }}</span>
                            </td>
                            <td class="p-4">
                                @if($coupon->expires_at)
                                    <span class="dir-ltr text-right block font-mono text-[11px] {{ $isExpired ? 'text-rose-600 font-bold' : 'text-slate-600' }}">
                                        {{ $coupon->expires_at->format('Y/m/d H:i') }}
                                    </span>
                                    @if($isExpired)
                                        <span class="text-[9px] text-rose-500 font-bold block">منقضی</span>
                                    @endif
                                @else
                                    <span class="text-slate-400">نامحدود</span>
                                @endif
                            </td>
                            <td class="p-4">
                                <form action="{{ route('admin.coupons.toggle', $coupon->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-2.5 py-1 rounded-xl text-[11px] font-bold transition {{ $coupon->is_active ? 'bg-emerald-100 text-emerald-800 hover:bg-emerald-200' : 'bg-slate-100 text-slate-500 hover:bg-slate-200' }}">
                                        {{ $coupon->is_active ? 'فعال' : 'غیرفعال' }}
                                    </button>
                                </form>
                            </td>
                            <td class="p-4 text-left">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.coupons.edit', $coupon->id) }}" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs rounded-xl transition">
                                        ویرایش
                                    </a>
                                    <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="POST" class="inline" onsubmit="return confirm('آیا از حذف این کد تخفیف مطمئن هستید؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold text-xs rounded-xl transition">
                                            حذف
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-slate-400 font-bold">
                                هیچ کد تخفیفی یافت نشد.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">{{ $coupons->links() }}</div>
</div>
@endsection