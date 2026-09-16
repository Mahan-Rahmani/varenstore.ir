<?php
    $navCategories = \App\Models\Category::roots()->with('children')->active()->orderBy('sort_order')->get();
?>

<div>
<!-- Desktop Modern Dropdown & Services Mega Navigation (Hidden on Mobile) -->
<nav class="hidden md:block border-t border-zinc-100 bg-white/95 backdrop-blur-sm relative z-40 text-xs font-bold text-zinc-700 select-none">
    <div class="max-w-[1700px] w-full mx-auto px-4 sm:px-6 lg:px-10">
        <ul class="flex items-center gap-5 lg:gap-7 py-2.5 overflow-visible">
            <!-- 1. Home -->
            <li>
                <a href="<?php echo e(route('home')); ?>" class="py-2 hover:text-black transition flex items-center gap-1.5">
                    <i class="fa-solid fa-house text-zinc-400 text-xs"></i>
                    <span>صفحه نخست</span>
                </a>
            </li>

            <!-- 2. Dynamic Categories Dropdown (طرح‌های ما) -->
            <li x-data="{ open: false }" @mouseleave="open = false" class="relative">
                <button @mouseenter="open = true" @click="open = !open" 
                        class="py-2 flex items-center gap-1.5 hover:text-black transition group">
                    <i class="fa-solid fa-palette text-zinc-400 group-hover:text-black transition text-xs"></i>
                    <span>طرح‌های ما</span>
                    <i class="fa-solid fa-chevron-down text-[9px] text-zinc-400 transition-transform duration-200 group-hover:text-black" 
                       :class="open ? 'rotate-180' : ''"></i>
                </button>

                <div x-show="open" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 translate-y-2"
                     style="display: none;"
                     class="absolute right-0 top-full pt-2 w-72 z-50">
                    <div class="bg-white rounded-2xl shadow-xl border border-zinc-100 p-2 space-y-1">
                        <a href="<?php echo e(route('home')); ?>" class="flex items-center justify-between px-3 py-2 rounded-xl text-zinc-800 hover:bg-zinc-50 hover:text-black transition">
                            <span class="flex items-center gap-2"><i class="fa-solid fa-layer-group text-zinc-400 text-[11px]"></i> همه طرح‌ها و دسته‌ها</span>
                            <span class="text-[10px] text-zinc-400 font-normal">کاتالوگ کامل</span>
                        </a>
                        <div class="h-px bg-zinc-100 my-1"></div>

                        <?php $__currentLoopData = $navCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="py-1">
                                <a href="<?php echo e(route('home', ['category' => $cat->slug])); ?>" 
                                   class="flex items-center justify-between px-3 py-1.5 rounded-lg text-zinc-800 hover:bg-zinc-50 hover:text-black font-extrabold transition">
                                    <span><?php echo e($cat->name); ?></span>
                                    <i class="fa-solid fa-arrow-left text-[9px] text-zinc-300"></i>
                                </a>
                                <?php if($cat->children->count() > 0): ?>
                                    <div class="pr-3 pl-2 py-1 space-y-0.5 border-r-2 border-zinc-100 mr-2 my-0.5">
                                        <?php $__currentLoopData = $cat->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subCat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <a href="<?php echo e(route('home', ['category' => $subCat->slug])); ?>" 
                                               class="block px-2.5 py-1 text-[11px] text-zinc-500 hover:text-black hover:bg-zinc-50 rounded-md transition">
                                                <?php echo e($subCat->name); ?>

                                            </a>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </li>
            <!-- 3. Custom DTF Print -->
            <li>
                <a href="<?php echo e(route('home', ['category' => 'custom'])); ?>" 
                   class="py-2 flex items-center gap-1.5 text-zinc-900 hover:text-indigo-600 transition group">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-600"></span>
                    </span>
                    <i class="fa-solid fa-wand-magic-sparkles text-indigo-600 text-xs"></i>
                    <span class="font-extrabold">چاپ طرح دلخواه شما</span>
                </a>
            </li>

            <!-- 4. Hoodie -->
            <li>
                <a href="<?php echo e(route('home', ['category' => 'hoodie'])); ?>" class="py-2 hover:text-black transition flex items-center gap-1.5">
                    <i class="fa-solid fa-snowflake text-zinc-400 text-xs"></i>
                    <span>هودی و دورس</span>
                </a>
            </li>

            <!-- 5. Services Dropdown -->
            <li x-data="{ open: false }" @mouseleave="open = false" class="relative">
                <button @mouseenter="open = true" @click="open = !open" 
                        class="py-2 flex items-center gap-1.5 hover:text-black transition group">
                    <i class="fa-solid fa-circle-question text-zinc-400 group-hover:text-black transition text-xs"></i>
                    <span>راهنما و خدمات</span>
                    <i class="fa-solid fa-chevron-down text-[9px] text-zinc-400 transition-transform duration-200 group-hover:text-black" 
                       :class="open ? 'rotate-180' : ''"></i>
                </button>

                <div x-show="open" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 translate-y-2"
                     style="display: none;"
                     class="absolute right-0 top-full pt-2 w-64 z-50">
                    <div class="bg-white rounded-2xl shadow-xl border border-zinc-100 p-2 space-y-1">
                        <a href="<?php echo e(route('account.orders')); ?>" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-zinc-700 hover:bg-zinc-50 hover:text-black transition">
                            <i class="fa-solid fa-truck-fast text-emerald-500 text-xs"></i>
                            <div>
                                <div class="font-bold">پیگیری وضعیت سفارش</div>
                                <div class="text-[10px] text-zinc-400 font-normal">مشاهده فاکتور و کد رهگیری</div>
                            </div>
                        </a>
                        <div class="h-px bg-zinc-100 my-1"></div>
                        <button type="button" @click="open = false; sizeModalOpen = true" 
                                class="w-full text-right flex items-center gap-2.5 px-3 py-2 rounded-xl text-zinc-700 hover:bg-zinc-50 hover:text-black transition group">
                            <i class="fa-solid fa-ruler-combined text-amber-500 text-xs group-hover:scale-110 transition"></i>
                            <div>
                                <div class="font-bold flex items-center justify-between">
                                    <span>راهنمای سایز و نگهداری</span>
                                    <span class="text-[9px] text-amber-600 bg-amber-50 px-1.5 py-0.5 rounded font-extrabold">مشاهده</span>
                                </div>
                                <div class="text-[10px] text-zinc-400 font-normal">جدول سایز و نکات شستشو</div>
                            </div>
                        </button>
                        <a href="https://t.me/+989395808412" target="_blank" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-zinc-700 hover:bg-sky-50 hover:text-sky-700 transition">
                            <i class="fa-brands fa-telegram text-sky-500 text-base"></i>
                            <div>
                                <div class="font-bold">مشاوره و چاپ سازمانی</div>
                                <div class="text-[10px] text-zinc-400 font-normal">ارتباط در تلگرام: ۰۹۳۹۵۸۰۸۴۱۲</div>
                            </div>
                        </a>
                    </div>
                </div>
            </li>

            <!-- 6. Discounts -->
            <li class="mr-auto">
                <a href="<?php echo e(route('home')); ?>" class="py-2 text-[#ef394e] font-black flex items-center gap-1.5 hover:scale-105 transition">
                    <i class="fa-solid fa-fire animate-pulse text-sm"></i>
                    <span>تخفیف‌های ویژه وارن</span>
                </a>
            </li>
        </ul>
    </div>
</nav>

    <!-- مودال اختصاصی راهنمای سایز و شستشو (با جایگاه آماده برای تصاویر) -->
    <div x-show="sizeModalOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         style="display: none;"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
        
        <div @click.away="sizeModalOpen = false" 
             class="bg-white rounded-3xl max-w-2xl w-full p-6 shadow-2xl border border-zinc-100 max-h-[90vh] overflow-y-auto">
            
            <div class="flex items-center justify-between pb-4 border-b border-zinc-100">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center">
                        <i class="fa-solid fa-ruler-combined text-sm"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-sm text-zinc-900">راهنمای انتخاب سایز و نگهداری پوشاک وارِن</h3>
                        <p class="text-[11px] text-zinc-400">بهترین تنخور و ماندگاری ۱۰۰٪ طرح‌های چاپی</p>
                    </div>
                </div>
                <button @click="sizeModalOpen = false" class="text-zinc-400 hover:text-black w-8 h-8 rounded-full hover:bg-zinc-100 flex items-center justify-center transition">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>

            <!-- جایگاه قرارگیری تصاویر جدول سایز -->
            <div class="mt-5 space-y-4">
                <div class="p-6 bg-zinc-50 border-2 border-dashed border-zinc-300 rounded-2xl text-center space-y-3">
                    <i class="fa-regular fa-images text-4xl text-zinc-400"></i>
                    <p class="text-xs text-zinc-700 font-bold">محل قرارگیری تصاویر راهنمای سایزبندی وارن</p>
                    <p class="text-[11px] text-zinc-400 leading-relaxed">
                        این بخش به عنوان جایگاه اختصاصی تعبیه شده است و می‌توانید در آینده تصاویر جدول سایزهای تیشرت اورسایز، بیسیک و هودی را در اینجا قرار دهید.
                    </p>
                </div>

                <!-- جدول ابعاد تقریبی -->
                <div class="overflow-x-auto">
                    <table class="w-full text-center text-xs border border-zinc-100 rounded-xl overflow-hidden">
                        <thead class="bg-zinc-100 text-zinc-700 font-bold">
                            <tr>
                                <th class="p-2.5">سایز</th>
                                <th class="p-2.5">عرض سینه (CM)</th>
                                <th class="p-2.5">قد تیشرت (CM)</th>
                                <th class="p-2.5">مناسب وزن (تقریبی)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100 text-zinc-600">
                            <tr><td class="p-2.5 font-bold">M</td><td class="p-2.5">۵۰</td><td class="p-2.5">۷۰</td><td class="p-2.5">۵۵ تا ۶۸ کیلوگرم</td></tr>
                            <tr><td class="p-2.5 font-bold">L</td><td class="p-2.5">۵۴</td><td class="p-2.5">۷۳</td><td class="p-2.5">۶۸ تا ۸۰ کیلوگرم</td></tr>
                            <tr><td class="p-2.5 font-bold">XL</td><td class="p-2.5">۵۸</td><td class="p-2.5">۷۶</td><td class="p-2.5">۸۰ تا ۹۲ کیلوگرم</td></tr>
                            <tr><td class="p-2.5 font-bold">2XL</td><td class="p-2.5">۶۲</td><td class="p-2.5">۷۹</td><td class="p-2.5">۹۲ تا ۱۰۵ کیلوگرم</td></tr>
                        </tbody>
                    </table>
                </div>

                <!-- نکات نگهداری و شستشو -->
                <div class="p-4 bg-emerald-50 border border-emerald-100 rounded-2xl text-[11px] text-emerald-950 space-y-1.5">
                    <div class="font-extrabold flex items-center gap-1.5 text-emerald-800">
                        <i class="fa-solid fa-circle-check"></i> نکات طلایی برای ماندگاری چاپ و پارچه ۱۰۰٪ پنبه:
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-emerald-900 pr-1">
                        <li>شستشو حتماً با آب سرد (حداکثر ۳۰ درجه سانتی‌گراد) و به صورت پشت‌ورو انجام شود.</li>
                        <li>از شوینده‌های ملایم مایع بدون سفیدکننده یا آنزیم‌های قوی استفاده کنید.</li>
                        <li>هنگام اتوکشی از تماس مستقیم اتو با بخش چاپی خودداری کنید و لباس را پشت‌ورو اتو نمایید.</li>
                    </ul>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <button @click="$store.appNav.sizeModalOpen = false" class="px-5 py-2 bg-zinc-900 text-white rounded-xl text-xs font-bold hover:bg-black transition">
                    متوجه شدم
                </button>
            </div>
        </div>
    </div>
</div><?php /**PATH /var/www/html/resources/views/layouts/navigation.blade.php ENDPATH**/ ?>