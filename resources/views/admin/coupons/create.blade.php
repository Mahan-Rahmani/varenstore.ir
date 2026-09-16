@extends('layouts.admin')

@section('title', 'تعریف کد تخفیف جدید')

@section('content')
<div class="max-w-3xl mx-auto bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 shadow-sm"
     x-data="{
         type: '{{ old('type', 'percentage') }}',
         code: '{{ old('code') }}',
         generateCode() {
             const chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
             let res = 'OFF';
             for (let i = 0; i < 5; i++) {
                 res += chars.charAt(Math.floor(Math.random() * chars.length));
             }
             this.code = res;
         }
     }">
    <div class="flex items-center justify-between pb-4 mb-6 border-b border-slate-100">
        <div>
            <h2 class="text-base font-black text-slate-900 mb-1">تعریف کوپن تخفیف</h2>
            <p class="text-xs text-slate-400">کد تخفیف را با قوانین مشخص برای مشتریان تعریف کنید.</p>
        </div>
        <a href="{{ route('admin.coupons.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition">
            انصراف
        </a>
    </div>

    @if($errors->any())
        <div class="p-4 mb-6 text-rose-800 bg-rose-50 border border-rose-200 rounded-2xl text-xs font-bold space-y-1">
            @foreach($errors->all() as $err)
                <p>• {{ $err }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('admin.coupons.store') }}" method="POST" class="space-y-6">
        @csrf
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 text-xs font-bold">
            <!-- Coupon Code -->
            <div class="sm:col-span-2">
                <div class="flex items-center justify-between mb-1.5">
                    <label class="text-slate-700">کد تخفیف (حروف انگلیسی یا اعداد) *</label>
                    <button type="button" @click="generateCode()" class="text-[#ef394e] hover:underline flex items-center gap-1 text-[11px]">
                        <i class="fa-solid fa-wand-magic-sparkles text-[10px]"></i> ایجاد کد تصادفی
                    </button>
                </div>
                <input type="text" name="code" x-model="code" required 
                       class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl font-mono text-sm uppercase tracking-wider focus:bg-white focus:outline-none focus:border-slate-400">
            </div>

            <!-- Type -->
            <div>
                <label class="block mb-1.5 text-slate-700">نوع تخفیف *</label>
                <select name="type" x-model="type" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:border-slate-400">
                    <option value="percentage">درصدی (٪)</option>
                    <option value="fixed">مبلغ ثابت (تومان)</option>
                </select>
            </div>

            <!-- Value -->
            <div>
                <label class="block mb-1.5 text-slate-700">
                    <span x-show="type === 'percentage'">درصد تخفیف (مثال: 20 برای ۲۰٪) *</span>
                    <span x-show="type === 'fixed'">مبلغ تخفیف (تومان) *</span>
                </label>
                <input type="number" name="value" value="{{ old('value') }}" min="1" required 
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:border-slate-400 font-mono">
            </div>

            <!-- Min Order -->
            <div>
                <label class="block mb-1.5 text-slate-700">حداقل مبلغ سفارش (تومان)</label>
                <input type="number" name="min_order_amount" value="{{ old('min_order_amount') }}" placeholder="اختیاری" 
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:border-slate-400 font-mono">
            </div>

            <!-- Max Discount Cap -->
            <div x-show="type === 'percentage'">
                <label class="block mb-1.5 text-slate-700">حداکثر سقف تخفیف (تومان)</label>
                <input type="number" name="max_discount_amount" value="{{ old('max_discount_amount') }}" placeholder="اختیاری" 
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:border-slate-400 font-mono">
            </div>

            <!-- Usage Limit -->
            <div>
                <label class="block mb-1.5 text-slate-700">سقف تعداد دفعات استفاده</label>
                <input type="number" name="usage_limit" value="{{ old('usage_limit') }}" min="1" placeholder="خالی = نامحدود" 
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:border-slate-400 font-mono">
            </div>

            <!-- Expires At -->
            <div>
                <label class="block mb-1.5 text-slate-700">تاریخ و زمان انقضا</label>
                <input type="datetime-local" name="expires_at" value="{{ old('expires_at') }}" 
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:border-slate-400 font-mono dir-ltr">
            </div>

            <!-- Active Switch -->
            <div class="sm:col-span-2 p-4 bg-slate-50 rounded-2xl border border-slate-200/80">
                <label class="flex items-center gap-2.5 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="w-4 h-4 text-[#ef394e] rounded border-slate-300">
                    <span class="text-xs font-bold text-slate-800">کد تخفیف از هم‌اکنون فعال و قابل استفاده باشد</span>
                </label>
            </div>
        </div>

        <div class="pt-4 border-t border-slate-100 flex justify-end">
            <button type="submit" class="px-6 py-3 bg-black hover:bg-[#ef394e] text-white font-black text-xs rounded-xl shadow transition duration-300">
                ذخیره و فعال‌سازی کد تخفیف
            </button>
        </div>
    </form>
</div>
@endsection