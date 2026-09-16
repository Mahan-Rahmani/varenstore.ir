@extends('layouts.app')

@section('content')
<div class="max-w-[1700px] w-full mx-auto px-4 sm:px-6 lg:px-10 py-8">
    <h1 class="text-xl font-black text-black mb-6 border-b pb-2">سبد خرید شما</h1>

    @if(empty($cartItems))
        <div class="bg-white rounded-3xl border p-12 text-center max-w-lg mx-auto shadow-sm">
            <h2 class="text-base font-bold text-zinc-800 mb-2">سبد خرید شما خالی است</h2>
            <a href="{{ route('home') }}" class="inline-block bg-black text-white font-bold text-xs px-6 py-3 rounded-xl">مشاهده مد فصل</a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-4">
                @foreach($cartItems as $key => $item)
                    <div class="bg-white rounded-2xl border p-4 flex items-center justify-between shadow-sm">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-16 bg-zinc-100 rounded-xl overflow-hidden flex-shrink-0">
                                @if($item['image'])
                                    <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                                @endif
                            </div>
                            <div>
                                <h3 class="font-bold text-xs text-black">{{ $item['name'] }}</h3>
                                @if(!empty($item['attributes']))
                                    <div class="flex items-center gap-1.5 mt-1 flex-wrap">
                                        @foreach($item['attributes'] as $attrKey => $attrVal)
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-zinc-100 border border-zinc-200 text-[10px] font-extrabold text-zinc-700">
                                                <span class="text-zinc-400">{{ $attrKey }}:</span>
                                                <span>{{ $attrVal }}</span>
                                            </span>
                                        @endforeach
                                    </div>
                                @endif
                                <span class="text-xs font-black text-zinc-700 block mt-1.5">{{ number_format($item['unit_price']) }} تومان</span>
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <form action="{{ route('cart.update', $key) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" onchange="this.form.submit()" class="w-12 py-1 text-center bg-zinc-100 border rounded-xl font-bold text-xs">
                            </form>
                            <span class="text-xs font-black text-black w-24 text-left">{{ number_format($item['subtotal']) }} تومان</span>
                            <form action="{{ route('cart.remove', $key) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-zinc-400 hover:text-rose-600 text-xs"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <div>
                <div class="bg-white rounded-2xl border p-6 space-y-6 shadow-sm">
                    <h3 class="text-sm font-black text-black pb-2 border-b">خلاصه صورت‌حساب</h3>

                    <div>
                        @if($appliedCoupon)
                            <div class="p-3 bg-emerald-50 border border-emerald-200 rounded-xl flex items-center justify-between text-xs">
                                <div>
                                    <span class="font-bold text-emerald-800">کد: {{ $appliedCoupon['code'] }}</span>
                                    <span class="block text-emerald-600 font-bold">-{{ number_format($discount) }} تومان</span>
                                </div>
                                <form action="{{ route('cart.coupon.remove') }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-emerald-700 hover:text-rose-600"><i class="fa-solid fa-xmark"></i></button>
                                </form>
                            </div>
                        @else
                            <form action="{{ route('cart.coupon.apply') }}" method="POST" class="flex gap-2">
                                @csrf
                                <input type="text" name="code" placeholder="کد تخفیف" class="flex-1 px-3 py-2 text-xs bg-zinc-50 border rounded-xl uppercase font-bold">
                                <button type="submit" class="px-4 py-2 bg-black text-white font-bold text-xs rounded-xl">اعمال</button>
                            </form>
                        @endif
                    </div>

                    <div class="space-y-3 text-xs font-bold text-zinc-600 pt-2 border-t">
                        <div class="flex justify-between"><span>مجموع قیمت کالاها</span><span>{{ number_format($subtotal) }} تومان</span></div>
                        @if($discount > 0)
                            <div class="flex justify-between text-emerald-600"><span>تخفیف</span><span>-{{ number_format($discount) }} تومان</span></div>
                        @endif
                        <div class="flex justify-between"><span>هزینه ارسال</span><span>{{ $shipping == 0 ? 'رایگان' : number_format($shipping).' تومان' }}</span></div>
                        <div class="flex justify-between text-sm font-black text-black pt-3 border-t">
                            <span>مبلغ قابل پرداخت</span>
                            <span class="text-[#ef394e]">{{ number_format($grandTotal) }} تومان</span>
                        </div>
                    </div>

                    @auth
                        <a href="{{ route('checkout.index') }}" class="block w-full text-center bg-black hover:bg-[#ef394e] text-white font-bold text-xs py-3.5 rounded-xl shadow transition">
                            ادامه فرآیند خرید <i class="fa-solid fa-arrow-left mr-2"></i>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="block w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs py-3.5 rounded-xl shadow transition">
                            <i class="fa-solid fa-right-to-bracket ml-1.5"></i> ورود به حساب و ثبت نهایی سفارش
                        </a>
                        <p class="text-[10px] text-zinc-400 text-center font-normal">برای تکمیل خرید و دریافت کد رهگیری، لطفا ابتدا وارد شوید.</p>
                    @endauth
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

