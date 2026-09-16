@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto px-4 py-16">
    <div class="bg-white rounded-3xl border border-zinc-200 p-8 shadow-sm">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-black text-black">ورود به حساب کاربری</h1>
            <p class="text-xs text-zinc-500 mt-1">جهت پیگیری سفارشات و خرید سریع وارد شوید</p>
        </div>

        <form action="{{ route('login') }}" method="POST" class="space-y-4 text-xs font-bold">
            @csrf
            <div>
                <label class="block text-zinc-700 mb-1">شماره همراه</label>
                <input type="tel" name="phone" value="{{ old('phone') }}" required 
                       placeholder="مثال: 09123456789" 
                       dir="ltr"
                       class="w-full px-3 py-2.5 bg-zinc-50 border rounded-xl focus:outline-none focus:bg-white focus:border-zinc-400 font-mono text-left">
                @error('phone') <span class="text-rose-600 text-[10px] mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <div class="flex items-center justify-between mb-1">
                    <label class="block text-zinc-700">رمز عبور</label>
                    <a href="{{ route('login.otp.request') }}" class="text-[11px] text-[#ef394e] hover:underline font-medium">
                        رمز عبور را فراموش کرده‌اید؟
                    </a>
                </div>
                <input type="password" name="password" required 
                       placeholder="رمز عبور خود را وارد کنید"
                       class="w-full px-3 py-2.5 bg-zinc-50 border rounded-xl focus:outline-none focus:bg-white focus:border-zinc-400">
                @error('password') <span class="text-rose-600 text-[10px] mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="flex items-center justify-between text-[11px] text-zinc-500">
                <label class="flex items-center gap-1.5 cursor-pointer">
                    <input type="checkbox" name="remember" class="rounded border-zinc-300 text-black focus:ring-0">
                    <span>مرا به خاطر بسپار</span>
                </label>
            </div>

            <button type="submit" class="w-full py-3 bg-black hover:bg-[#ef394e] text-white font-black text-xs rounded-xl shadow transition">
                ورود با رمز عبور
            </button>

            <!-- Secondary Action: OTP / SMS Login -->
            <div class="pt-2">
                <a href="{{ route('login.otp.request') }}" class="w-full py-2.5 bg-zinc-100 hover:bg-zinc-200 text-zinc-800 font-bold text-xs rounded-xl transition flex items-center justify-center gap-2">
                    <i class="fa-solid fa-mobile-screen-button"></i>
                    ورود با کد یکبار مصرف (پیامک)
                </a>
            </div>
        </form>

        <div class="mt-6 pt-6 border-t border-zinc-100 text-center text-xs font-bold text-zinc-500">
            حساب کاربری ندارید؟ <a href="{{ route('register') }}" class="text-[#ef394e] hover:underline">ثبت‌نام کنید</a>
        </div>
    </div>
</div>
@endsection


