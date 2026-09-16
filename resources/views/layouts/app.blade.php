<!DOCTYPE html>
<html lang="fa" dir="rtl" class="h-full bg-[#f8f8f8]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name', 'چاپ تیشرت وارِن | VAREN'))</title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="@yield('meta_description', 'فروشگاه تخصصی پوشاک، تیشرت، هودی و دورس با ماندگارترین کیفیت چاپ DTF و طراحی‌های ترند هنری در فروشگاه آنلاین وارِن (VAREN)')">
    <meta name="keywords" content="@yield('meta_keywords', 'تیشرت, چاپ تیشرت, هودی, دورس, پوشاک, تیشرت انیمه, تیشرت استریت ویر, خرید تیشرت, سفارش تیشرت سفارشی, وارن, VAREN')">
    <meta name="robots" content="@yield('meta_robots', 'index, follow')">
    <link rel="canonical" href="@yield('canonical_url', url()->current())">
    
    <!-- Open Graph / Social Media Meta Tags -->
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:title" content="@yield('og_title', 'چاپ تیشرت وارِن | VAREN')">
    <meta property="og:description" content="@yield('og_description', 'فروشگاه تخصصی پوشاک، تیشرت، هودی و دورس با ماندگارترین کیفیت چاپ DTF و طراحی‌های ترند هنری.')">
    <meta property="og:url" content="@yield('og_url', url()->current())">
    <meta property="og:site_name" content="وارِن | VAREN">
    <meta property="og:image" content="@yield('og_image', asset('images/logo/VAREN_BLACK_WITHOUT%20LOGOTYPE%20AND%20SLOGAN.png'))">
    <meta property="og:locale" content="fa_IR">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('og_title', 'چاپ تیشرت وارِن | VAREN')">
    <meta name="twitter:description" content="@yield('og_description', 'فروشگاه تخصصی پوشاک، تیشرت، هودی و دورس با ماندگارترین کیفیت چاپ DTF.')">
    <meta name="twitter:image" content="@yield('og_image', asset('images/logo/VAREN_BLACK_WITHOUT%20LOGOTYPE%20AND%20SLOGAN.png'))">

    <link rel="icon" type="image/png" href="{{ asset('images/logo/VAREN_BLACK_WITHOUT%20LOGOTYPE%20AND%20SLOGAN.png') }}">

    <!-- Schema.org Organization & WebSite JSON-LD -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@graph": [
        {
          "@type": "Organization",
          "@id": "{{ url('/') }}/#organization",
          "name": "وارِن | VAREN",
          "url": "{{ url('/') }}",
          "logo": {
            "@type": "ImageObject",
            "url": "{{ asset('images/logo/VAREN_BLACK_WITHOUT%20LOGOTYPE%20AND%20SLOGAN.png') }}"
          }
        },
        {
          "@type": "WebSite",
          "@id": "{{ url('/') }}/#website",
          "url": "{{ url('/') }}",
          "name": "فروشگاه آنلاین وارِن | VAREN",
          "publisher": {
            "@id": "{{ url('/') }}/#organization"
          },
          "potentialAction": {
            "@type": "SearchAction",
            "target": {
              "@type": "EntryPoint",
              "urlTemplate": "{{ url('/') }}?search={search_term_string}"
            },
            "query-input": "required name=search_term_string"
          }
        }
      ]
    }
    </script>
    @stack('schemas')
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
        }
        .fa, .fas, .far, .fal, .fad, .fab, .fa-solid, .fa-regular, .fa-brands, [class^="fa-"], [class*=" fa-"] {
            font-family: "Font Awesome 6 Free", "Font Awesome 6 Brands", FontAwesome !important;
        }
        .font-mono {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace !important;
        }
    </style>
</head>
<body x-data="{ mobileDrawerOpen: false, sizeModalOpen: false }" class="flex flex-col min-h-full bg-[#f8f8f8] text-slate-800">
    <!-- Top Animated Announcement Bar -->
    <div class="bg-gradient-to-r from-zinc-950 via-zinc-900 to-zinc-950 text-white text-xs py-2.5 text-center font-medium border-b border-zinc-800 flex items-center justify-center gap-2 overflow-hidden shadow-sm">
        <span class="inline-flex items-center justify-center px-2 py-0.5 text-[10px] font-black bg-[#ef394e] text-white rounded-full animate-pulse">ویژه</span>
        <span class="tracking-wide">ارسال اکسپرس رایگان خریدهای بالای ۵۰۰ هزار تومان | کد تخفیف: <strong class="text-amber-400 font-extrabold tracking-wider underline">PARSPACK50</strong></span>
    </div>

    <!-- Main Animated Sticky Header -->
    <header x-data="{ atTop: true, mobileMenuOpen: false, mobileSearchOpen: false }" 
            @scroll.window="atTop = (window.pageYOffset > 20 ? false : true)"
            :class="atTop ? 'bg-white/90 backdrop-blur-md' : 'bg-white/95 backdrop-blur-lg shadow-md'"
            class="sticky top-0 z-50 transition-all duration-300 border-b border-zinc-100">
        
        <div class="max-w-[1700px] w-full mx-auto px-4 sm:px-6 lg:px-10">
            <div class="flex items-center justify-between h-20 gap-4 sm:gap-6">
                
                <div class="flex items-center gap-3">
                    <!-- Mobile Hamburger Button -->
                    <button type="button" @click="mobileDrawerOpen = true" 
                            class="md:hidden w-10 h-10 rounded-2xl bg-zinc-100 hover:bg-zinc-200 text-zinc-800 flex items-center justify-center transition">
                        <i class="fa-solid fa-bars-staggered text-base"></i>
                    </button>

                    <!-- Logo with Real VAREN Branding -->
                    <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                        <img src="{{ asset('images/logo/VAREN_BLACK_WITH%20LOGOTYPE%20AND%20SLOGAN.png') }}" 
                             alt="چاپ تیشرت وارن VAREN" 
                             class="h-10 sm:h-12 w-auto object-contain transition-transform duration-300 group-hover:scale-105">
                    </a>
                </div>

                <!-- Search Bar -->
                <div class="hidden md:flex flex-1 max-w-lg">
                    <form action="{{ route('home') }}" method="GET" class="w-full relative group">
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="جستجوی طرح‌های تیشرت، انیمه، موزیک، تایپوگرافی، طرح اختصاصی..." 
                               class="w-full pl-4 pr-11 py-2.5 text-xs bg-zinc-100/90 border border-transparent rounded-2xl focus:outline-none focus:bg-white focus:border-zinc-300 focus:ring-4 focus:ring-zinc-100 transition-all duration-300 text-zinc-800 font-medium">
                        <i class="fa-solid fa-magnifying-glass absolute right-4 top-3.5 text-zinc-400 group-focus-within:text-black transition-colors text-sm"></i>
                    </form>
                </div>


            <!-- User & Shopping Cart Actions with Bounce Animation -->
            <div class="flex items-center gap-2 sm:gap-3">
                <!-- Mobile Search Trigger Button (Only on mobile) -->
                <button type="button" @click="mobileSearchOpen = !mobileSearchOpen" 
                        class="md:hidden w-10 h-10 rounded-2xl bg-zinc-100 hover:bg-zinc-200 text-zinc-800 flex items-center justify-center transition">
                    <i class="fa-solid fa-magnifying-glass text-sm"></i>
                </button>
                @auth
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center gap-2 px-3 py-2 text-xs font-bold text-zinc-800 hover:text-[#ef394e] rounded-xl hover:bg-zinc-50 transition">
                            <div class="w-7 h-7 rounded-full bg-zinc-100 flex items-center justify-center text-zinc-700 font-bold border border-zinc-200">
                                <i class="fa-regular fa-user text-xs"></i>
                            </div>
                            <span class="hidden sm:inline">{{ auth()->user()->name }}</span>
                            <i class="fa-solid fa-chevron-down text-[10px] text-zinc-400 transition" :class="open ? 'rotate-180' : ''"></i>
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute left-0 mt-2 w-52 bg-white rounded-2xl shadow-2xl border border-zinc-100 py-2 z-50 text-xs font-bold">
                            <div class="px-4 py-2 border-b border-zinc-100 mb-1">
                                <span class="text-zinc-900 block truncate">{{ auth()->user()->name }}</span>
                                <span class="text-[10px] text-zinc-400 font-mono block">{{ auth()->user()->email }}</span>
                            </div>

                            <a href="{{ route('account.dashboard') }}" class="flex items-center gap-2.5 px-4 py-2 text-zinc-700 hover:text-black hover:bg-zinc-50 transition">
                                <i class="fa-solid fa-table-columns text-zinc-400"></i> داشبورد کاربری
                            </a>

                            <a href="{{ route('account.orders') }}" class="flex items-center gap-2.5 px-4 py-2 text-zinc-700 hover:text-black hover:bg-zinc-50 transition">
                                <i class="fa-solid fa-bag-shopping text-zinc-400"></i> سفارش‌های من
                            </a>

                            <a href="{{ route('account.profile') }}" class="flex items-center gap-2.5 px-4 py-2 text-zinc-700 hover:text-black hover:bg-zinc-50 transition">
                                <i class="fa-regular fa-id-card text-zinc-400"></i> مشخصات حساب
                            </a>

                            @if(auth()->user()->isAdmin())
                                <div class="border-t my-1"></div>
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-4 py-2 text-amber-600 hover:bg-amber-50 transition">
                                    <i class="fa-solid fa-gauge-high"></i> پنل مدیریت
                                </a>
                            @endif

                            <div class="border-t my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-right px-4 py-2 text-rose-600 hover:bg-rose-50 flex items-center gap-2.5 transition">
                                    <i class="fa-solid fa-right-from-bracket"></i> خروج از حساب
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 text-xs font-bold text-zinc-800 border border-zinc-300 rounded-xl hover:bg-black hover:text-white transition">
                        ورود / عضویت
                    </a>
                @endauth

                <!-- Cart Button with Bounce Badge -->
                @inject('cartService', 'App\Services\CartService')
                <a href="{{ route('cart.index') }}" class="group relative flex items-center gap-2 px-3.5 py-2 bg-zinc-100 hover:bg-black text-zinc-900 hover:text-white rounded-2xl transition">
                    <i class="fa-solid fa-bag-shopping text-base group-hover:scale-110 transition"></i>
                    <span class="text-xs font-black hidden sm:inline">سبد خرید</span>
                    @if($cartService->getItemsCount() > 0)
                        <span class="px-2 py-0.5 text-[11px] font-black text-white bg-[#ef394e] rounded-full animate-bounce">
                            {{ $cartService->getItemsCount() }}
                        </span>
                    @endif
                </a>
            </div>
        </div>

        <!-- Expandable Mobile Search Bar (Only on mobile) -->
        <div x-show="mobileSearchOpen" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             style="display: none;"
             class="md:hidden px-4 pb-3">
            <form action="{{ route('home') }}" method="GET" class="w-full relative">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="جستجوی طرح‌های تیشرت، انیمه، دورس..." 
                       class="w-full pl-4 pr-11 py-2.5 text-xs bg-zinc-100 border border-zinc-200 rounded-2xl focus:outline-none focus:bg-white focus:border-zinc-400 text-zinc-800 font-medium">
                <i class="fa-solid fa-magnifying-glass absolute right-4 top-3.5 text-zinc-400 text-sm"></i>
            </form>
        </div>

        @include('layouts.navigation')
    </header>

    <div class="max-w-[1700px] w-full mx-auto px-4 sm:px-6 lg:px-10 mt-4">
        @if(session('success'))
            <div class="p-3 mb-3 text-emerald-900 bg-emerald-50 border border-emerald-200 rounded-xl text-xs font-bold">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="p-3 mb-3 text-rose-900 bg-rose-50 border border-rose-200 rounded-xl text-xs font-bold">{{ session('error') }}</div>
        @endif
    </div>

    <main class="flex-grow pb-16 md:pb-0">@yield('content')</main>

@include('layouts.footer')

@include('layouts.mobile-drawer')
@include('layouts.bottom-nav')

</body>
</html>
