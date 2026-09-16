@extends('layouts.app')

@section('content')
<div class="max-w-[1700px] w-full mx-auto px-4 sm:px-6 lg:px-10 py-8">
    <!-- Breadcrumb -->
    <div class="flex items-center gap-2 text-xs text-zinc-400 font-bold mb-6">
        <a href="{{ route('home') }}" class="hover:text-black transition">صفحه اصلی</a>
        <i class="fa-solid fa-chevron-left text-[10px]"></i>
        <span class="text-zinc-800">حساب کاربری من</span>
        @hasSection('account_breadcrumb')
            <i class="fa-solid fa-chevron-left text-[10px]"></i>
            <span class="text-[#ef394e]">@yield('account_breadcrumb')</span>
        @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 items-start">
        <!-- Account Sidebar -->
        <aside class="bg-white rounded-3xl border border-zinc-200 p-5 shadow-sm">
            <!-- User Profile Summary -->
            <div class="flex items-center gap-3 pb-5 border-b border-zinc-100">
                <div class="w-12 h-12 rounded-2xl bg-[#ef394e]/10 text-[#ef394e] flex items-center justify-center font-black text-lg border border-[#ef394e]/20">
                    <i class="fa-regular fa-user"></i>
                </div>
                <div class="overflow-hidden">
                    <h2 class="font-black text-sm text-zinc-900 truncate">{{ auth()->user()->name }}</h2>
                    <span class="text-[11px] text-zinc-400 font-mono block mt-0.5">{{ auth()->user()->phone ?? auth()->user()->email }}</span>
                </div>
            </div>

            <!-- Navigation Links -->
            <nav class="mt-4 space-y-1 text-xs font-bold">
                <a href="{{ route('account.dashboard') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-2xl transition {{ request()->routeIs('account.dashboard') ? 'bg-[#ef394e] text-white shadow-md shadow-red-500/20' : 'text-zinc-700 hover:bg-zinc-50' }}">
                    <i class="fa-solid fa-table-columns text-sm"></i>
                    <span>داشبورد و وضعیت</span>
                </a>

                <a href="{{ route('account.orders') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-2xl transition {{ request()->routeIs('account.orders*') ? 'bg-[#ef394e] text-white shadow-md shadow-red-500/20' : 'text-zinc-700 hover:bg-zinc-50' }}">
                    <i class="fa-solid fa-bag-shopping text-sm"></i>
                    <span>سفارش‌های من</span>
                </a>

                <a href="{{ route('account.profile') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-2xl transition {{ request()->routeIs('account.profile') ? 'bg-[#ef394e] text-white shadow-md shadow-red-500/20' : 'text-zinc-700 hover:bg-zinc-50' }}">
                    <i class="fa-regular fa-id-card text-sm"></i>
                    <span>اطلاعات حساب کاربری</span>
                </a>

                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" 
                       class="flex items-center gap-3 px-4 py-3 rounded-2xl text-amber-600 hover:bg-amber-50 transition border border-amber-200/50 mt-2">
                        <i class="fa-solid fa-gauge-high text-sm"></i>
                        <span>ورود به پنل مدیریت</span>
                    </a>
                @endif

                <div class="pt-2 border-t border-zinc-100 mt-2">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-rose-600 hover:bg-rose-50 transition text-right">
                            <i class="fa-solid fa-arrow-right-from-bracket text-sm"></i>
                            <span>خروج از حساب</span>
                        </button>
                    </form>
                </div>
            </nav>
        </aside>

        <!-- Account Main Content -->
        <main class="lg:col-span-3">
            @yield('account_content')
        </main>
    </div>
</div>
@endsection
