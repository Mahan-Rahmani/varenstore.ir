<?php
    $navCategories = \App\Models\Category::roots()->with('children')->active()->orderBy('sort_order')->get();
?>

<!-- Mobile Off-Canvas Drawer (Only on Mobile) -->
<div x-show="mobileDrawerOpen" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     style="display: none;"
     class="fixed inset-0 z-50 md:hidden bg-black/60 backdrop-blur-sm">

    <!-- Drawer Content -->
    <div @click.away="mobileDrawerOpen = false" 
         x-show="mobileDrawerOpen"
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in duration-250 transform"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="translate-x-full"
         class="fixed inset-y-0 right-0 max-w-xs w-full bg-white shadow-2xl flex flex-col z-50 overflow-hidden text-xs font-bold text-zinc-700">
        
        <!-- Header -->
        <div class="p-4 border-b border-zinc-100 flex items-center justify-between bg-zinc-50/50">
            <img src="<?php echo e(asset('images/logo/VAREN_BLACK_WITH%20LOGOTYPE%20AND%20SLOGAN.png')); ?>" alt="وارن" class="h-8 w-auto">
            <button type="button" @click="mobileDrawerOpen = false" class="w-8 h-8 rounded-full bg-zinc-100 flex items-center justify-center text-zinc-500">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>

        <!-- Links Body -->
        <div class="flex-1 overflow-y-auto p-4 space-y-3">
            <a href="<?php echo e(route('home')); ?>" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-zinc-50 text-zinc-800">
                <i class="fa-solid fa-house text-zinc-400"></i>
                <span>صفحه نخست</span>
            </a>

            <a href="<?php echo e(route('home', ['category' => 'custom'])); ?>" class="flex items-center justify-between p-3 rounded-2xl bg-indigo-50 border border-indigo-100 text-indigo-950">
                <span class="flex items-center gap-2"><i class="fa-solid fa-wand-magic-sparkles text-indigo-600"></i> چاپ طرح دلخواه شما</span>
                <span class="px-2 py-0.5 text-[10px] bg-indigo-600 text-white rounded-full">DTF</span>
            </a>

            <a href="<?php echo e(route('home', ['category' => 'hoodie'])); ?>" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-zinc-50 text-zinc-800">
                <i class="fa-solid fa-snowflake text-zinc-400"></i>
                <span>هودی و دورس زمستانه</span>
            </a>

            <a href="<?php echo e(route('home')); ?>" class="flex items-center gap-3 p-2.5 rounded-xl text-rose-600 bg-rose-50/60 font-black">
                <i class="fa-solid fa-fire animate-pulse text-sm"></i>
                <span>تخفیف‌های ویژه وارن</span>
            </a>

            <div class="h-px bg-zinc-100 my-1"></div>

            <!-- Categories Accordion -->
            <div x-data="{ exp: false }" class="space-y-1">
                <button type="button" @click="exp = !exp" class="w-full flex items-center justify-between p-2.5 rounded-xl hover:bg-zinc-50 text-zinc-800">
                    <span class="flex items-center gap-2.5"><i class="fa-solid fa-palette text-zinc-400"></i> دسته‌بندی طرح‌ها</span>
                    <i class="fa-solid fa-chevron-down text-[10px] text-zinc-400" :class="exp ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="exp" class="pr-5 pl-1 space-y-1 pt-1" style="display: none;">
                    <?php $__currentLoopData = $navCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('home', ['category' => $cat->slug])); ?>" class="block p-1.5 font-bold text-zinc-800"><?php echo e($cat->name); ?></a>
                        <?php $__currentLoopData = $cat->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(route('home', ['category' => $sub->slug])); ?>" class="block pr-3 py-1 text-[11px] text-zinc-500">- <?php echo e($sub->name); ?></a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <div class="h-px bg-zinc-100 my-1"></div>

            <a href="<?php echo e(route('account.orders')); ?>" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-zinc-50 text-zinc-700">
                <i class="fa-solid fa-truck-fast text-emerald-500"></i>
                <span>پیگیری سفارشات</span>
            </a>

            <button type="button" @click="mobileDrawerOpen = false; sizeModalOpen = true" class="w-full flex items-center gap-3 p-2.5 rounded-xl hover:bg-zinc-50 text-zinc-700">
                <i class="fa-solid fa-ruler-combined text-amber-500"></i>
                <span>راهنمای سایز و شستشو</span>
            </button>

            <a href="https://t.me/+989395808412" target="_blank" class="flex items-center gap-3 p-2.5 rounded-xl text-sky-700 bg-sky-50/70">
                <i class="fa-brands fa-telegram text-sky-500 text-base"></i>
                <span>مشاوره و چاپ سازمانی (تلگرام)</span>
            </a>
        </div>

        <div class="p-4 border-t border-zinc-100 bg-zinc-50/70 text-[11px] text-zinc-500 text-center">
            شماره پشتیبانی: <span class="font-mono font-bold text-zinc-800 dir-ltr inline-block">۰۹۳۹۵۸۰۸۴۱۲</span>
        </div>
    </div>
</div>
<?php /**PATH /var/www/html/resources/views/layouts/mobile-drawer.blade.php ENDPATH**/ ?>