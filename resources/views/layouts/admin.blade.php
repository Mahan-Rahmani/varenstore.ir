<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>پنل مدیریت - {{ config('app.name', 'چاپ تیشرت وارِن') }}</title>
    <!-- Google Fonts & CDN Fallback for Vazirmatn -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.003/Vazirmatn-font-face.css" rel="stylesheet" type="text/css" />

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        body, button, input, select, textarea, p, span, h1, h2, h3, h4, h5, h6, a, div, label {
            font-family: 'Vazirmatn', -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, sans-serif;
            -webkit-tap-highlight-color: transparent;
        }
        .fa, .fas, .far, .fal, .fad, .fab, .fa-solid, .fa-regular, .fa-brands, [class^="fa-"], [class*=" fa-"] {
            font-family: "Font Awesome 6 Free", "Font Awesome 6 Brands", FontAwesome !important;
        }
        .font-mono {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace !important;
        }
        .pb-safe {
            padding-bottom: env(safe-area-inset-bottom, 16px);
        }
    </style>
</head>
<body x-data="{ mobileMenuOpen: false }" class="min-h-screen flex flex-col md:flex-row font-sans text-slate-800 bg-slate-100 antialiased selection:bg-rose-500 selection:text-white">
    @include('layouts.admin-mobile-header')
    @include('layouts.admin-mobile-drawer')
    <!-- Admin Sidebar -->
    <aside class="w-64 bg-slate-900 text-slate-300 flex flex-col justify-between hidden md:flex shrink-0 border-l border-slate-800">
        <div>
            <!-- Brand Logo -->
            <div class="h-16 flex items-center px-6 border-b border-slate-800">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                    <img src="{{ asset('images/logo/VAREN_WHITE_WITHOUT%20LOGOTYPE%20AND%20SLOGAN.png') }}" alt="VAREN" class="h-9 w-9 object-contain">
                    <div class="flex flex-col">
                        <span class="text-base font-black text-white tracking-tight">پنل مدیریت وارن</span>
                        <span class="text-[9px] text-slate-400 font-bold">VAREN ADMIN</span>
                    </div>
                </a>
            </div>

            <!-- Navigation Links -->
            <nav class="p-4 space-y-1.5 text-xs font-bold">
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-2xl transition {{ request()->routeIs('admin.dashboard') ? 'bg-[#ef394e] text-white shadow-lg shadow-red-500/20' : 'hover:bg-slate-800 text-slate-300' }}">
                    <i class="fa-solid fa-chart-pie text-sm"></i>
                    <span>داشبورد و آمار کلی</span>
                </a>

                <a href="{{ route('admin.products.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-2xl transition {{ request()->routeIs('admin.products.*') ? 'bg-[#ef394e] text-white shadow-lg shadow-red-500/20' : 'hover:bg-slate-800 text-slate-300' }}">
                    <i class="fa-solid fa-box-open text-sm"></i>
                    <span>مدیریت محصولات</span>
                </a>

                <a href="{{ route('admin.sliders.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-2xl transition {{ request()->routeIs('admin.sliders.*') ? 'bg-[#ef394e] text-white shadow-lg shadow-red-500/20' : 'hover:bg-slate-800 text-slate-300' }}">
                    <i class="fa-solid fa-[#ef394e] fa-images text-sm"></i>
                    <span>اسلایدر و بنرها</span>
                </a>

                <a href="{{ route('admin.categories.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-2xl transition {{ request()->routeIs('admin.categories.*') ? 'bg-[#ef394e] text-white shadow-lg shadow-red-500/20' : 'hover:bg-slate-800 text-slate-300' }}">
                    <i class="fa-solid fa-layer-group text-sm"></i>
                    <span>مدیریت دسته‌بندی‌ها</span>
                </a>

                <a href="{{ route('admin.orders.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-2xl transition {{ request()->routeIs('admin.orders.*') ? 'bg-[#ef394e] text-white shadow-lg shadow-red-500/20' : 'hover:bg-slate-800 text-slate-300' }}">
                    <i class="fa-solid fa-receipt text-sm"></i>
                    <span>مدیریت سفارش‌ها</span>
                </a>

                <a href="{{ route('admin.coupons.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-2xl transition {{ request()->routeIs('admin.coupons.*') ? 'bg-[#ef394e] text-white shadow-lg shadow-red-500/20' : 'hover:bg-slate-800 text-slate-300' }}">
                    <i class="fa-solid fa-ticket text-sm"></i>
                    <span>کدهای تخفیف</span>
                </a>

                <a href="{{ route('admin.users.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-2xl transition {{ request()->routeIs('admin.users.*') ? 'bg-[#ef394e] text-white shadow-lg shadow-red-500/20' : 'hover:bg-slate-800 text-slate-300' }}">
                    <i class="fa-solid fa-users text-sm"></i>
                    <span>کاربران و مشتریان</span>
                </a>
            </nav>
        </div>

        <!-- Footer Sidebar -->
        <div class="p-4 border-t border-slate-800">
            <a href="{{ route('home') }}" class="flex items-center gap-2 px-4 py-2.5 text-xs font-bold text-slate-400 hover:text-white transition rounded-xl hover:bg-slate-800">
                <i class="fa-solid fa-store"></i>
                <span>بازگشت به فروشگاه</span>
            </a>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-h-0 overflow-y-auto">
        <!-- Desktop Top Header -->
        <header class="h-16 bg-white border-b border-slate-200 px-6 hidden md:flex items-center justify-between sticky top-0 z-30 shadow-xs">
            <h1 class="text-sm font-black text-slate-800">@yield('title', 'کنترل پنل مدیریت')</h1>
            <div class="flex items-center gap-4 text-xs font-bold">
                <span class="text-slate-500">مدیر آنلاین: <strong class="text-slate-900">{{ auth()->user()->name }}</strong></span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-rose-600 hover:text-rose-700 flex items-center gap-1.5 transition">
                        <i class="fa-solid fa-power-off text-xs"></i>
                        <span>خروج</span>
                    </button>
                </form>
            </div>
        </header>

        <!-- Main Body -->
        <main class="p-3.5 sm:p-6 pb-24 md:pb-8 flex-1">
            @if(session('success'))
                <div class="p-3.5 sm:p-4 mb-4 sm:mb-6 text-emerald-900 bg-emerald-50 border border-emerald-200 rounded-2xl text-xs font-bold flex items-center gap-2 shadow-xs">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-base shrink-0"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="p-3.5 sm:p-4 mb-4 sm:mb-6 text-rose-900 bg-rose-50 border border-rose-200 rounded-2xl text-xs font-bold flex items-center gap-2 shadow-xs">
                    <i class="fa-solid fa-circle-exclamation text-rose-600 text-base shrink-0"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    @include('layouts.admin-mobile-nav')
</body>
</html>

