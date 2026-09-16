<!-- Mega VAREN Footer -->
<footer class="bg-[#111111] text-zinc-300 mt-20 border-t border-zinc-800 text-xs">
    <div class="max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 border-b border-zinc-800/80 flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <img src="<?php echo e(asset('images/logo/VAREN_WHITE_WITH%20LOGOTYPE%20AND%20SLOGAN.png')); ?>" 
                 alt="چاپ تیشرت وارن VAREN" 
                 class="h-12 w-auto object-contain">
            <div>
                <span class="text-[11px] text-zinc-400 font-bold block">شماره همراه پشتیبانی: <strong class="text-white font-mono dir-ltr inline-block">۰۹۳۹۵۸۰۸۴۱۲</strong></span>
                <span class="text-[10px] text-zinc-500 font-medium">پاسخگویی آنلاین و ثبت سفارش اختصاصی</span>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <a href="https://instagram.com/varen.fashions" target="_blank" rel="noopener" 
               class="px-4 py-2 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-500 hover:to-pink-500 text-white font-bold rounded-xl flex items-center gap-2 transition shadow">
                <i class="fa-brands fa-instagram text-sm"></i>
                <span class="font-mono text-xs">varen.fashions</span>
            </a>
            <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})" class="px-4 py-2 bg-zinc-900 hover:bg-zinc-800 text-white font-bold rounded-xl border border-zinc-800 flex items-center gap-2">
                <span>بازگشت به بالا</span>
                <i class="fa-solid fa-chevron-up text-xs"></i>
            </button>
        </div>
    </div>

    <!-- Features -->
    <div class="max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 border-b border-zinc-800/80 grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
        <div>
            <i class="fa-solid fa-shirt text-2xl text-[#ef394e] mb-1"></i>
            <span class="font-bold text-white text-xs block">۱۰۰٪ پنبه سوپر</span>
            <span class="text-zinc-500 text-[10px]">پارچه لطیف و بدون آبرفت</span>
        </div>
        <div>
            <i class="fa-solid fa-palette text-2xl text-[#ef394e] mb-1"></i>
            <span class="font-bold text-white text-xs block">چاپ ماندگار DTF</span>
            <span class="text-zinc-500 text-[10px]">ضمانت شستشو و ثبات رنگ</span>
        </div>
        <div>
            <i class="fa-solid fa-wand-magic-sparkles text-2xl text-[#ef394e] mb-1"></i>
            <span class="font-bold text-white text-xs block">چاپ طرح اختصاصی</span>
            <span class="text-zinc-500 text-[10px]">طرح دلخواه شما روی تیشرت</span>
        </div>
        <div>
            <i class="fa-solid fa-truck-fast text-2xl text-[#ef394e] mb-1"></i>
            <span class="font-bold text-white text-xs block">ارسال به سراسر ایران</span>
            <span class="text-zinc-500 text-[10px]">پست پیشتاز و تیپاکس</span>
        </div>
    </div>

    <!-- Navigation & eNamad Badges -->
    <div class="max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8">
        <div>
            <h4 class="font-black text-white text-sm mb-4 border-r-2 border-[#ef394e] pr-2">دسته‌بندی‌های وارن</h4>
            <ul class="space-y-2.5 font-bold text-zinc-400">
                <li><a href="<?php echo e(route('home', ['category' => 'men'])); ?>" class="hover:text-white">تیشرت مردانه</a></li>
                <li><a href="<?php echo e(route('home', ['category' => 'women'])); ?>" class="hover:text-white">تیشرت زنانه و اورسایز</a></li>
                <li><a href="<?php echo e(route('home', ['category' => 'custom'])); ?>" class="hover:text-white">چاپ طرح دلخواه شما</a></li>
                <li><a href="<?php echo e(route('home', ['category' => 'hoodie'])); ?>" class="hover:text-white">هودی و دورس پاییزه</a></li>
            </ul>
        </div>

        <div>
            <h4 class="font-black text-white text-sm mb-4 border-r-2 border-[#ef394e] pr-2">خدمات مشتریان</h4>
            <ul class="space-y-2.5 font-bold text-zinc-400">
                <li><a href="#" class="hover:text-white">پرسش‌های متداول</a></li>
                <li><a href="#" class="hover:text-white">رویه‌های بازگرداندن</a></li>
                <li><a href="#" class="hover:text-white">حریم خصوصی</a></li>
            </ul>
        </div>

        <div>
            <h4 class="font-black text-white text-sm mb-4 border-r-2 border-[#ef394e] pr-2">راهنمای خرید</h4>
            <ul class="space-y-2.5 font-bold text-zinc-400">
                <li><a href="#" class="hover:text-white">نحوه ثبت سفارش</a></li>
                <li><a href="#" class="hover:text-white">شیوه ارسال مرسولات</a></li>
                <li><a href="#" class="hover:text-white">شیوه‌های پرداخت</a></li>
            </ul>
        </div>

        <!-- Brand About & Badges -->
        <div class="lg:col-span-2 space-y-6">
            <div>
                <h4 class="font-black text-white text-sm mb-2">چاپ تیشرت و پوشاک وارِن (VAREN)</h4>
                <p class="text-zinc-400 leading-relaxed text-[11px]">
                    فروشگاه و کارگاه تخصصی تولید و چاپ تیشرت وارن (FOR YOU | WITH ART). ما با استفاده از بالاترین کیفیت پارچه ۱۰۰٪ پنبه سوپر و پیشرفته‌ترین تکنولوژی چاپ ماندگار، هم کالکشن‌های اختصاصی و هنری خودمان را عرضه می‌کنیم و هم طرح‌های دلخواه و سفارشی شما را با بهترین کیفیت چاپ و به سراسر کشور ارسال می‌نماییم.
                </p>
                <div class="mt-3 flex items-center gap-2 text-zinc-400 text-[11px]">
                    <i class="fa-solid fa-location-dot text-[#ef394e]"></i>
                    <span>مشهد، مجتمع تجاری الماس شرق</span>
                </div>
            </div>

            <div>
                <h5 class="font-bold text-white text-xs mb-3">نمادها و مجوزهای رسمی اعتمادسازی</h5>
                <div class="flex items-center gap-3">
                    <div class="w-20 h-20 bg-zinc-900 border border-zinc-800 rounded-2xl p-2 flex flex-col items-center justify-center text-center hover:border-zinc-700 cursor-pointer">
                        <i class="fa-solid fa-certificate text-xl text-amber-400 mb-1"></i>
                        <span class="text-[9px] font-bold text-white block">نماد اعتماد</span>
                        <span class="text-[7px] text-zinc-500">eNamad</span>
                    </div>

                    <div class="w-20 h-20 bg-zinc-900 border border-zinc-800 rounded-2xl p-2 flex flex-col items-center justify-center text-center hover:border-zinc-700 cursor-pointer">
                        <i class="fa-solid fa-shield-cat text-xl text-[#ef394e] mb-1"></i>
                        <span class="text-[9px] font-bold text-white block">نشان ثبت</span>
                        <span class="text-[7px] text-zinc-500">ساماندهی</span>
                    </div>

                    <div class="w-20 h-20 bg-zinc-900 border border-zinc-800 rounded-2xl p-2 flex flex-col items-center justify-center text-center hover:border-zinc-700 cursor-pointer">
                        <i class="fa-solid fa-building-columns text-xl text-sky-400 mb-1"></i>
                        <span class="text-[9px] font-bold text-white block">درگاه پرداخت</span>
                        <span class="text-[7px] text-zinc-500">شاپرک</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Copyright -->
    <div class="bg-black py-6 border-t border-zinc-900 text-center text-zinc-500 text-[11px]">
        <div class="max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-2">
            <span>&copy; <?php echo e(date('Y')); ?> فروشگاه چاپ تیشرت وارِن (VAREN). تمامی حقوق محفوظ است.</span>
            <span class="text-zinc-600">FOR YOU | WITH ART</span>
        </div>
    </div>
</footer>
<?php /**PATH /var/www/html/resources/views/layouts/footer.blade.php ENDPATH**/ ?>