<!-- Mobile Bottom Ergonomic Navigation Bar -->
<nav class="md:hidden fixed bottom-0 inset-x-0 bg-white/95 backdrop-blur-md border-t border-slate-200/80 z-40 px-2 py-1.5 shadow-lg pb-safe">
    <div class="flex items-center justify-around">
        
        <!-- Dashboard -->
        <a href="<?php echo e(route('admin.dashboard')); ?>" 
           class="flex flex-col items-center gap-1 py-1 px-3 rounded-xl transition <?php echo e(request()->routeIs('admin.dashboard') ? 'text-[#ef394e] font-black' : 'text-slate-500 font-bold hover:text-slate-900'); ?>">
            <i class="fa-solid fa-chart-pie text-base <?php echo e(request()->routeIs('admin.dashboard') ? 'scale-110' : ''); ?>"></i>
            <span class="text-[10px]">داشبورد</span>
        </a>

        <!-- Orders -->
        <a href="<?php echo e(route('admin.orders.index')); ?>" 
           class="flex flex-col items-center gap-1 py-1 px-3 rounded-xl transition <?php echo e(request()->routeIs('admin.orders.*') ? 'text-[#ef394e] font-black' : 'text-slate-500 font-bold hover:text-slate-900'); ?>">
            <i class="fa-solid fa-receipt text-base <?php echo e(request()->routeIs('admin.orders.*') ? 'scale-110' : ''); ?>"></i>
            <span class="text-[10px]">سفارش‌ها</span>
        </a>

        <!-- Products -->
        <a href="<?php echo e(route('admin.products.index')); ?>" 
           class="flex flex-col items-center gap-1 py-1 px-3 rounded-xl transition <?php echo e(request()->routeIs('admin.products.*') ? 'text-[#ef394e] font-black' : 'text-slate-500 font-bold hover:text-slate-900'); ?>">
            <i class="fa-solid fa-box-open text-base <?php echo e(request()->routeIs('admin.products.*') ? 'scale-110' : ''); ?>"></i>
            <span class="text-[10px]">محصولات</span>
        </a>

        <!-- Users -->
        <a href="<?php echo e(route('admin.users.index')); ?>" 
           class="flex flex-col items-center gap-1 py-1 px-3 rounded-xl transition <?php echo e(request()->routeIs('admin.users.*') ? 'text-[#ef394e] font-black' : 'text-slate-500 font-bold hover:text-slate-900'); ?>">
            <i class="fa-solid fa-users text-base <?php echo e(request()->routeIs('admin.users.*') ? 'scale-110' : ''); ?>"></i>
            <span class="text-[10px]">مشتریان</span>
        </a>

        <!-- More Menu (Opens Drawer) -->
        <button type="button" @click="mobileMenuOpen = true" 
                class="flex flex-col items-center gap-1 py-1 px-3 rounded-xl text-slate-500 font-bold hover:text-slate-900 transition">
            <i class="fa-solid fa-ellipsis text-base"></i>
            <span class="text-[10px]">بیشتر</span>
        </button>
    </div>
</nav>
<?php /**PATH /var/www/html/resources/views/layouts/admin-mobile-nav.blade.php ENDPATH**/ ?>