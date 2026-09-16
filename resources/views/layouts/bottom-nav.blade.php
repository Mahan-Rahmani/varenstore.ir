<!-- Mobile Bottom Navigation Bar (Hidden on desktop) -->
<nav class="md:hidden fixed bottom-0 inset-x-0 bg-white/95 backdrop-blur-md border-t border-zinc-200 py-2 px-3 z-40 shadow-[0_-4px_20px_rgba(0,0,0,0.05)]">
    <div class="flex items-center justify-around text-center">
        <!-- 1. صفحه نخست -->
        <a href="{{ route('home') }}" class="flex flex-col items-center gap-1 text-zinc-500 hover:text-black py-1 px-2 transition {{ request()->routeIs('home') && !request('category') ? 'text-black font-extrabold' : '' }}">
            <i class="fa-solid fa-house text-base"></i>
            <span class="text-[10px]">خانه</span>
        </a>

        <!-- 2. دسته‌بندی‌ها (باز کردن کشوی موبایل) -->
        <button type="button" @click="mobileDrawerOpen = true" class="flex flex-col items-center gap-1 text-zinc-500 hover:text-black py-1 px-2 transition">
            <i class="fa-solid fa-layer-group text-base"></i>
            <span class="text-[10px]">دسته‌ها</span>
        </button>

        <!-- 3. چاپ اختصاصی (دکمه مرکزی برجسته) -->
        <a href="{{ route('home', ['category' => 'custom']) }}" class="flex flex-col items-center -mt-5 group">
            <div class="w-12 h-12 rounded-2xl bg-zinc-950 text-white flex items-center justify-center shadow-lg shadow-zinc-400/40 group-hover:scale-105 group-hover:bg-indigo-600 transition duration-300">
                <i class="fa-solid fa-wand-magic-sparkles text-lg text-amber-300"></i>
            </div>
            <span class="text-[9px] font-black text-zinc-800 mt-1">چاپ دلخواه</span>
        </a>

        <!-- 4. سبد خرید -->
        @inject('cartService', 'App\Services\CartService')
        <a href="{{ route('cart.index') }}" class="relative flex flex-col items-center gap-1 text-zinc-500 hover:text-black py-1 px-2 transition {{ request()->routeIs('cart.*') ? 'text-black font-extrabold' : '' }}">
            <div class="relative">
                <i class="fa-solid fa-bag-shopping text-base"></i>
                @if($cartService->getItemsCount() > 0)
                    <span class="absolute -top-1.5 -right-2 px-1.5 py-0.2 text-[9px] font-black text-white bg-[#ef394e] rounded-full">
                        {{ $cartService->getItemsCount() }}
                    </span>
                @endif
            </div>
            <span class="text-[10px]">سبد خرید</span>
        </a>

        <!-- 5. حساب کاربری / ورود -->
        @auth
            <a href="{{ route('account.dashboard') }}" class="flex flex-col items-center gap-1 text-zinc-500 hover:text-black py-1 px-2 transition {{ request()->routeIs('account.*') ? 'text-black font-extrabold' : '' }}">
                <i class="fa-solid fa-user text-base"></i>
                <span class="text-[10px]">حساب من</span>
            </a>
        @else
            <a href="{{ route('login') }}" class="flex flex-col items-center gap-1 text-zinc-500 hover:text-black py-1 px-2 transition {{ request()->routeIs('login') ? 'text-black font-extrabold' : '' }}">
                <i class="fa-regular fa-user text-base"></i>
                <span class="text-[10px]">ورود</span>
            </a>
        @endauth
    </div>
</nav>