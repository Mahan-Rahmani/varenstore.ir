<!-- Mobile Drawer Backdrop -->
<div x-show="mobileMenuOpen" 
     x-transition:enter="transition-opacity ease-linear duration-200"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition-opacity ease-linear duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 bg-black/60 backdrop-blur-xs z-50 md:hidden" 
     style="display: none;"
     @click="mobileMenuOpen = false"></div>

<!-- Mobile Drawer Slide-over -->
<div x-show="mobileMenuOpen" 
     x-transition:enter="transition ease-out duration-300 transform"
     x-transition:enter-start="translate-x-full"
     x-transition:enter-end="translate-x-0"
     x-transition:leave="transition ease-in duration-200 transform"
     x-transition:leave-start="translate-x-0"
     x-transition:leave-end="translate-x-full"
     class="fixed inset-y-0 right-0 max-w-xs w-full bg-slate-900 text-slate-300 z-50 shadow-2xl flex flex-col justify-between md:hidden"
     style="display: none;">
    
    <div>
        <!-- Drawer Header -->
        <div class="p-5 border-b border-slate-800 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <img src="<?php echo e(asset('images/logo/VAREN_WHITE_WITHOUT%20LOGOTYPE%20AND%20SLOGAN.png')); ?>" alt="VAREN" class="h-8 w-8 object-contain">
                <div>
                    <span class="text-sm font-black text-white block">پنل مدیریت وارن</span>
                    <span class="text-[10px] text-slate-400 font-bold"><?php echo e(auth()->user()->name); ?></span>
                </div>
            </div>
            <button type="button" @click="mobileMenuOpen = false" class="w-9 h-9 rounded-xl bg-slate-800 text-slate-400 flex items-center justify-center hover:text-white">
                <i class="fa-solid fa-xmark text-base"></i>
            </button>
        </div>

        <!-- Drawer Navigation Links -->
        <nav class="p-4 space-y-1.5 text-xs font-bold">
            <a href="<?php echo e(route('admin.dashboard')); ?>" 
               @click="mobileMenuOpen = false"
               class="flex items-center gap-3 px-4 py-3 rounded-2xl transition <?php echo e(request()->routeIs('admin.dashboard') ? 'bg-[#ef394e] text-white shadow-lg shadow-red-500/20' : 'hover:bg-slate-800 text-slate-300'); ?>">
                <i class="fa-solid fa-chart-pie text-sm w-5 text-center"></i>
                <span>داشبورد و آمار کلی</span>
            </a>

            <a href="<?php echo e(route('admin.orders.index')); ?>" 
               @click="mobileMenuOpen = false"
               class="flex items-center gap-3 px-4 py-3 rounded-2xl transition <?php echo e(request()->routeIs('admin.orders.*') ? 'bg-[#ef394e] text-white shadow-lg shadow-red-500/20' : 'hover:bg-slate-800 text-slate-300'); ?>">
                <i class="fa-solid fa-receipt text-sm w-5 text-center"></i>
                <span>مدیریت سفارش‌ها</span>
            </a>

            <a href="<?php echo e(route('admin.products.index')); ?>" 
               @click="mobileMenuOpen = false"
               class="flex items-center gap-3 px-4 py-3 rounded-2xl transition <?php echo e(request()->routeIs('admin.products.*') ? 'bg-[#ef394e] text-white shadow-lg shadow-red-500/20' : 'hover:bg-slate-800 text-slate-300'); ?>">
                <i class="fa-solid fa-box-open text-sm w-5 text-center"></i>
                <span>مدیریت محصولات</span>
            </a>

            <a href="<?php echo e(route('admin.sliders.index')); ?>" 
               @click="mobileMenuOpen = false"
               class="flex items-center gap-3 px-4 py-3 rounded-2xl transition <?php echo e(request()->routeIs('admin.sliders.*') ? 'bg-[#ef394e] text-white shadow-lg shadow-red-500/20' : 'hover:bg-slate-800 text-slate-300'); ?>">
                <i class="fa-solid fa-images text-sm w-5 text-center"></i>
                <span>اسلایدر و بنرها</span>
            </a>

            <a href="<?php echo e(route('admin.categories.index')); ?>" 
               @click="mobileMenuOpen = false"
               class="flex items-center gap-3 px-4 py-3 rounded-2xl transition <?php echo e(request()->routeIs('admin.categories.*') ? 'bg-[#ef394e] text-white shadow-lg shadow-red-500/20' : 'hover:bg-slate-800 text-slate-300'); ?>">
                <i class="fa-solid fa-layer-group text-sm w-5 text-center"></i>
                <span>دسته‌بندی‌ها</span>
            </a>

            <a href="<?php echo e(route('admin.coupons.index')); ?>" 
               @click="mobileMenuOpen = false"
               class="flex items-center gap-3 px-4 py-3 rounded-2xl transition <?php echo e(request()->routeIs('admin.coupons.*') ? 'bg-[#ef394e] text-white shadow-lg shadow-red-500/20' : 'hover:bg-slate-800 text-slate-300'); ?>">
                <i class="fa-solid fa-ticket text-sm w-5 text-center"></i>
                <span>کدهای تخفیف</span>
            </a>

            <a href="<?php echo e(route('admin.users.index')); ?>" 
               @click="mobileMenuOpen = false"
               class="flex items-center gap-3 px-4 py-3 rounded-2xl transition <?php echo e(request()->routeIs('admin.users.*') ? 'bg-[#ef394e] text-white shadow-lg shadow-red-500/20' : 'hover:bg-slate-800 text-slate-300'); ?>">
                <i class="fa-solid fa-users text-sm w-5 text-center"></i>
                <span>کاربران و مشتریان</span>
            </a>
        </nav>
    </div>

    <!-- Drawer Footer Actions -->
    <div class="p-4 border-t border-slate-800 space-y-2">
        <a href="<?php echo e(route('home')); ?>" target="_blank" class="flex items-center gap-2.5 px-4 py-3 text-xs font-bold text-slate-300 hover:text-white transition rounded-xl bg-slate-800/80">
            <i class="fa-solid fa-store text-sm text-[#ef394e]"></i>
            <span>مشاهده فروشگاه اصلی</span>
        </a>

        <form method="POST" action="<?php echo e(route('logout')); ?>">
            <?php echo csrf_field(); ?>
            <button type="submit" class="w-full flex items-center gap-2.5 px-4 py-3 text-xs font-bold text-rose-400 hover:text-rose-300 transition rounded-xl hover:bg-slate-800">
                <i class="fa-solid fa-power-off text-sm"></i>
                <span>خروج از حساب مدیریت</span>
            </button>
        </form>
    </div>
</div>
<?php /**PATH /var/www/html/resources/views/layouts/admin-mobile-drawer.blade.php ENDPATH**/ ?>