@extends('layouts.admin')

@section('title', 'ویرایش مشخصات کاربر: ' . $user->name)

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 shadow-sm">
    <div class="flex items-center justify-between pb-4 mb-6 border-b border-slate-100">
        <div>
            <h2 class="text-base font-black text-slate-900 mb-1">ویرایش اطلاعات کاربر</h2>
            <p class="text-xs text-slate-400">شناسه کاربر: #{{ $user->id }}</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition">
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

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-5 text-xs font-bold">
        @csrf
        @method('PUT')

        <div>
            <label class="block mb-1.5 text-slate-700">نام و نام خانوادگی *</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" required 
                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:border-slate-400">
        </div>

        <div>
            <label class="block mb-1.5 text-slate-700">آدرس ایمیل *</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" required 
                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:border-slate-400 font-mono">
        </div>

        <div>
            <label class="block mb-1.5 text-slate-700">شماره همراه</label>
            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="مثال: 09123456789" 
                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:border-slate-400 font-mono">
        </div>

        <div>
            <label class="block mb-1.5 text-slate-700">نقش کاربری در سیستم *</label>
            <select name="role" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:border-slate-400">
                <option value="customer" {{ old('role', $user->role->value) === 'customer' ? 'selected' : '' }}>مشتری عادی</option>
                <option value="admin" {{ old('role', $user->role->value) === 'admin' ? 'selected' : '' }}>مدیر سیستم (دسترسی کامل به پنل)</option>
            </select>
            <p class="text-[10px] text-slate-400 mt-1 font-normal">با تغییر نقش به مدیر سیستم، این کاربر دسترسی کامل به پنل مدیریت خواهد داشت.</p>
        </div>

        <div class="pt-4 border-t border-slate-100 flex justify-end">
            <button type="submit" class="px-6 py-3 bg-black hover:bg-[#ef394e] text-white font-black text-xs rounded-xl shadow transition duration-300">
                ذخیره تغییرات کاربر
            </button>
        </div>
    </form>
</div>
@endsection
