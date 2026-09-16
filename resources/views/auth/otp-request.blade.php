@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto px-4 py-16">
    <div class="bg-white rounded-3xl border border-zinc-200 p-8 shadow-sm">
        <div class="text-center mb-6">
            <div class="w-12 h-12 bg-zinc-100 text-zinc-800 rounded-2xl flex items-center justify-center mx-auto mb-3 text-xl">
                <i class="fa-solid fa-key"></i>
            </div>
            <h1 class="text-2xl font-black text-black">ورود با رمز یکبار مصرف</h1>
            <p class="text-xs text-zinc-500 mt-1">رمز عبور خود را فراموش کرده‌اید؟ شماره همراه خود را وارد کنید.</p>
        </div>

        <form action="{{ route('login.otp.send') }}" method="POST" class="space-y-4 text-xs font-bold">
            @csrf
            <div>
                <label class="block text-zinc-700 mb-1">شماره همراه حساب کاربری</label>
                <input type="tel" name="phone" value="{{ old('phone') }}" required 
                       placeholder="مثال: 09123456789" 
                       dir="ltr"
                       autofocus
                       class="w-full px-3 py-2.5 bg-zinc-50 border rounded-xl focus:outline-none focus:bg-white focus:border-zinc-400 font-mono text-left">
                @error('phone') <span class="text-rose-600 text-[10px] mt-1 block">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="w-full py-3 bg-black hover:bg-[#ef394e] text-white font-black text-xs rounded-xl shadow transition">
                دریافت کد تایید پیامکی (SMS)
            </button>
        </form>

        <div class="mt-6 pt-6 border-t border-zinc-100 flex flex-col gap-2 text-center text-xs font-bold text-zinc-500">
            <div>
                رمز عبور خود را به خاطر دارید؟ <a href="{{ route('login') }}" class="text-[#ef394e] hover:underline">ورود با رمز عبور</a>
            </div>
            <div>
                حساب کاربری ندارید؟ <a href="{{ route('register') }}" class="text-zinc-800 hover:underline">ثبت‌نام در وارِن</a>
            </div>
        </div>
    </div>
</div>
@endsection
