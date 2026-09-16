@extends('layouts.app')

@section('content')
<div class="max-w-[1700px] w-full mx-auto px-4 sm:px-6 lg:px-10 py-8">
    <h1 class="text-xl font-black text-black mb-6 border-b pb-2">ثبت سفارش و پرداخت</h1>

    <form action="{{ route('checkout.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-6">
                <!-- Customer Details -->
                <div class="bg-white rounded-3xl border border-zinc-200 p-6 shadow-sm">
                    <h2 class="text-sm font-black text-black mb-4 pb-2 border-b">۱. اطلاعات گیرنده و تحویل سفارش</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs font-bold">
                        <div x-data="{ hasEnglish: false }">
                            <label class="block mb-1 text-zinc-700">
                                نام و نام خانوادگی *
                                <span class="text-[10px] text-zinc-400 font-normal">(فقط حروف فارسی)</span>
                            </label>
                            <input type="text" name="customer_name" value="{{ old('customer_name', $user?->name) }}" required 
                                   placeholder="مثال: علی رضایی"
                                   @input="hasEnglish = /[a-zA-Z]/.test($event.target.value)"
                                   class="w-full px-3 py-2 bg-zinc-50 border rounded-xl focus:bg-white focus:outline-none focus:border-zinc-400">
                            <p x-show="hasEnglish" style="display: none;" class="text-amber-600 text-[10px] mt-1 font-medium flex items-center gap-1">
                                <i class="fa-solid fa-triangle-exclamation"></i> لطفاً کیبورد خود را به فارسی تغییر دهید. نوشتن نام انگلیسی مجاز نیست.
                            </p>
                            @error('customer_name') <span class="text-rose-600 text-[10px] mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block mb-1 text-zinc-700">
                                شماره همراه تحویل‌گیرنده *
                            </label>
                            <input type="tel" name="customer_phone" value="{{ old('customer_phone', $user?->phone) }}" required 
                                   placeholder="مثال: 09123456789"
                                   dir="ltr"
                                   class="w-full px-3 py-2 bg-zinc-50 border rounded-xl focus:bg-white focus:outline-none focus:border-zinc-400 font-mono text-left">
                            @error('customer_phone') <span class="text-rose-600 text-[10px] mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block mb-1 text-zinc-700">
                                نشانی ایمیل 
                                <span class="text-[10px] text-zinc-400 font-normal">(اختیاری)</span>
                            </label>
                            <input type="email" name="customer_email" value="{{ old('customer_email', $user?->email) }}" 
                                   placeholder="example@mail.com"
                                   dir="ltr"
                                   class="w-full px-3 py-2 bg-zinc-50 border rounded-xl focus:bg-white focus:outline-none focus:border-zinc-400 font-mono text-left">
                            @error('customer_email') <span class="text-rose-600 text-[10px] mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block mb-1 text-zinc-700">شهر *</label>
                            <input type="text" name="city" value="{{ old('city') }}" required class="w-full px-3 py-2 bg-zinc-50 border rounded-xl">
                        </div>
                        <div>
                            <label class="block mb-1 text-zinc-700">کد پستی *</label>
                            <input type="text" name="postal_code" value="{{ old('postal_code') }}" required class="w-full px-3 py-2 bg-zinc-50 border rounded-xl">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block mb-1 text-zinc-700">نشانی دقیق پستی *</label>
                            <textarea name="shipping_address" rows="2" required class="w-full px-3 py-2 bg-zinc-50 border rounded-xl">{{ old('shipping_address') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Payment Gateway -->
                <div class="bg-white rounded-3xl border border-zinc-200 p-6 shadow-sm">
                    <h2 class="text-sm font-black text-black mb-4 pb-2 border-b">۲. انتخاب درگاه پرداخت اینترنتی</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <label class="p-4 border-2 rounded-2xl flex items-center gap-3 cursor-pointer bg-amber-50/50 border-amber-300">
                            <input type="radio" name="payment_method" value="zarinpal" checked class="accent-[#ef394e]">
                            <div>
                                <span class="block font-black text-xs text-black flex items-center gap-1.5">
                                    <i class="fa-solid fa-credit-card text-[#ef394e]"></i>
                                    درگاه پرداخت امن زرین‌پال
                                </span>
                                <span class="block text-[10px] text-zinc-500 mt-0.5">اتصال به کلیه کارت‌های عضو شبکه شتاب</span>
                            </div>
                        </label>
                        <label class="p-4 border rounded-2xl flex items-center gap-3 cursor-pointer bg-zinc-50">
                            <input type="radio" name="payment_method" value="mock" class="accent-black">
                            <div>
                                <span class="block font-black text-xs text-black">پرداخت شبیه‌ساز (تستی)</span>
                                <span class="block text-[10px] text-zinc-500 mt-0.5">تست سفارش بدون کسر وجه واقعی</span>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <div>
                <div class="bg-white rounded-3xl border border-zinc-200 p-6 shadow-sm space-y-4">
                    <h3 class="text-sm font-black text-black pb-2 border-b">خلاصه صورت‌حساب</h3>
                    <div class="space-y-3 text-xs font-bold text-zinc-600">
                        <div class="flex justify-between"><span>مبلغ کل کالاها</span><span>{{ number_format($subtotal) }} تومان</span></div>
                        @if($discount > 0)
                            <div class="flex justify-between text-emerald-600"><span>تخفیف</span><span>-{{ number_format($discount) }} تومان</span></div>
                        @endif
                        <div class="flex justify-between"><span>هزینه ارسال</span><span>{{ $shipping == 0 ? 'رایگان' : number_format($shipping).' تومان' }}</span></div>
                        <div class="flex justify-between text-sm font-black text-black pt-3 border-t">
                            <span>مبلغ نهایی</span>
                            <span class="text-[#ef394e]">{{ number_format($grandTotal) }} تومان</span>
                        </div>
                    </div>
                    <button type="submit" class="w-full bg-black hover:bg-[#ef394e] text-white font-black py-3.5 rounded-xl shadow transition text-xs">
                        پرداخت و تکمیل سفارش
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

