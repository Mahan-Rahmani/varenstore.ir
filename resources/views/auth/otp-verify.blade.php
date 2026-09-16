@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto px-4 py-16">
    <div class="bg-white rounded-3xl border border-zinc-200 p-8 shadow-sm"
         x-data="{
             timeLeft: 120,
             canResend: false,
             init() {
                 let timer = setInterval(() => {
                     if (this.timeLeft > 0) {
                         this.timeLeft--;
                     } else {
                         this.canResend = true;
                         clearInterval(timer);
                     }
                 }, 1000);
             },
             formatTime() {
                 let minutes = Math.floor(this.timeLeft / 60);
                 let seconds = this.timeLeft % 60;
                 return (minutes < 10 ? '0' : '') + minutes + ':' + (seconds < 10 ? '0' : '') + seconds;
             }
         }">
        
        <div class="text-center mb-6">
            <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center mx-auto mb-3 text-xl">
                <i class="fa-solid fa-comment-sms"></i>
            </div>
            <h1 class="text-2xl font-black text-black">تایید کد پیامک شده</h1>
            <p class="text-xs text-zinc-500 mt-1">
                کد تایید ۵ رقمی ارسال شده به شماره 
                <span class="font-mono font-bold text-zinc-800 dir-ltr inline-block">{{ $phone }}</span>
                را وارد کنید.
            </p>
        </div>

        <form action="{{ route('login.otp.process') }}" method="POST" class="space-y-4 text-xs font-bold">
            @csrf
            <div>
                <label class="block text-zinc-700 mb-1 text-center">کد تایید ۵ رقمی</label>
                <input type="text" name="otp" required 
                       placeholder="•••••" 
                       maxlength="5"
                       dir="ltr"
                       autofocus
                       class="w-full px-4 py-3 bg-zinc-50 border rounded-xl focus:outline-none focus:bg-white focus:border-zinc-400 font-mono text-center text-xl tracking-[0.5em]">
                @error('otp') <span class="text-rose-600 text-[10px] mt-1 block text-center">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="w-full py-3 bg-black hover:bg-[#ef394e] text-white font-black text-xs rounded-xl shadow transition">
                تایید و ورود به حساب
            </button>
        </form>

        <div class="mt-6 pt-4 border-t border-zinc-100 flex flex-col items-center gap-3 text-xs font-bold text-zinc-500">
            <div x-show="!canResend" class="text-zinc-400 flex items-center gap-1.5 font-medium">
                <i class="fa-regular fa-clock"></i>
                امکان ارسال مجدد کد تا: 
                <span x-text="formatTime()" class="font-mono font-bold text-zinc-700">02:00</span>
            </div>

            <form x-show="canResend" style="display: none;" action="{{ route('login.otp.send') }}" method="POST" class="w-full">
                @csrf
                <input type="hidden" name="phone" value="{{ $phone }}">
                <button type="submit" class="w-full py-2.5 text-[#ef394e] bg-rose-50 hover:bg-rose-100 rounded-xl transition text-center flex items-center justify-center gap-1.5">
                    <i class="fa-solid fa-rotate-right"></i> ارسال مجدد کد پیامکی
                </button>
            </form>

            <div class="pt-2">
                <a href="{{ route('login.otp.request') }}" class="text-zinc-500 hover:text-black transition">
                    ویرایش شماره همراه
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
