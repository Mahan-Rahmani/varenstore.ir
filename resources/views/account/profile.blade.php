@extends('account.layout')

@section('account_breadcrumb', 'اطلاعات حساب کاربری')

@section('account_content')
<div class="space-y-6">
    <div class="bg-white rounded-3xl border border-zinc-200 p-6 sm:p-8 shadow-sm">
        <div class="pb-5 mb-6 border-b border-zinc-100">
            <h1 class="text-base font-black text-zinc-900 mb-1">اطلاعات حساب کاربری</h1>
            <p class="text-xs text-zinc-400">مشخصات هویتی، اطلاعات تماس و رمز عبور خود را ویرایش کنید.</p>
        </div>

        @if($errors->any())
            <div class="p-4 mb-6 text-rose-800 bg-rose-50 border border-rose-200 rounded-2xl text-xs font-bold space-y-1">
                @foreach($errors->all() as $error)
                    <p>• {{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('account.profile.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- General Info -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs font-bold">
                <div x-data="{ hasEnglish: false }">
                    <label class="block mb-1.5 text-zinc-700">
                        نام و نام خانوادگی *
                        <span class="text-[10px] text-zinc-400 font-normal">(فقط حروف فارسی)</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                           placeholder="مثال: علی رضایی"
                           @input="hasEnglish = /[a-zA-Z]/.test($event.target.value)"
                           class="w-full px-4 py-2.5 bg-zinc-50 border border-zinc-200 rounded-xl focus:bg-white focus:outline-none focus:border-zinc-400">
                    <p x-show="hasEnglish" style="display: none;" class="text-amber-600 text-[10px] mt-1 font-medium flex items-center gap-1">
                        <i class="fa-solid fa-triangle-exclamation"></i> لطفاً کیبورد خود را به فارسی تغییر دهید. نوشتن نام انگلیسی مجاز نیست.
                    </p>
                    @error('name') <span class="text-rose-600 text-[10px] mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block mb-1.5 text-zinc-700">
                        شماره همراه *
                    </label>
                    <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}" required 
                           placeholder="مثال: 09123456789"
                           dir="ltr"
                           class="w-full px-4 py-2.5 bg-zinc-50 border border-zinc-200 rounded-xl focus:bg-white focus:outline-none focus:border-zinc-400 font-mono text-left">
                    @error('phone') <span class="text-rose-600 text-[10px] mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="sm:col-span-2">
                    <label class="block mb-1.5 text-zinc-700">
                        آدرس ایمیل 
                        <span class="text-[10px] text-zinc-400 font-normal">(اختیاری)</span>
                    </label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                           placeholder="example@mail.com"
                           dir="ltr"
                           class="w-full px-4 py-2.5 bg-zinc-50 border border-zinc-200 rounded-xl focus:bg-white focus:outline-none focus:border-zinc-400 font-mono text-left">
                    @error('email') <span class="text-rose-600 text-[10px] mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Password Change Section -->
            <div class="pt-6 border-t border-zinc-100">
                <h3 class="text-xs font-black text-zinc-900 mb-1">تغییر رمز عبور</h3>
                <p class="text-[11px] text-zinc-400 mb-4">تنها در صورتی که مایل به تغییر رمز عبور هستید، فیلدهای زیر را پر کنید.</p>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs font-bold">
                    <div>
                        <label class="block mb-1.5 text-zinc-700">رمز عبور فعلی</label>
                        <input type="password" name="current_password"
                               class="w-full px-4 py-2.5 bg-zinc-50 border border-zinc-200 rounded-xl focus:bg-white focus:outline-none focus:border-zinc-400">
                    </div>

                    <div>
                        <label class="block mb-1.5 text-zinc-700">رمز عبور جدید</label>
                        <input type="password" name="new_password"
                               class="w-full px-4 py-2.5 bg-zinc-50 border border-zinc-200 rounded-xl focus:bg-white focus:outline-none focus:border-zinc-400">
                    </div>

                    <div>
                        <label class="block mb-1.5 text-zinc-700">تکرار رمز عبور جدید</label>
                        <input type="password" name="new_password_confirmation"
                               class="w-full px-4 py-2.5 bg-zinc-50 border border-zinc-200 rounded-xl focus:bg-white focus:outline-none focus:border-zinc-400">
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-4 border-t border-zinc-100 flex items-center justify-end">
                <button type="submit" class="px-6 py-3 bg-black hover:bg-[#ef394e] text-white font-black text-xs rounded-xl shadow transition duration-300">
                    ذخیره تغییرات مشخصات
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
