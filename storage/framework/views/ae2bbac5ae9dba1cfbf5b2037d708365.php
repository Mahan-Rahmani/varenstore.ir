<?php
// Admin Mobile Header component
?>
<header class="md:hidden bg-white/95 backdrop-blur border-b border-slate-200 sticky top-0 z-40 px-3.5 h-14 flex items-center justify-between shadow-xs">
    <div class="flex items-center gap-2.5">
        <button type="button" @click="mobileMenuOpen = true" 
                class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 active:scale-95 transition">
            <i class="fa-solid fa-bars-staggered text-base"></i>
        </button>
        <a href="<?php echo e(route('admin.dashboard')); ?>" class="flex items-center gap-2">
            <img src="<?php echo e(asset('images/logo/VAREN_BLACK_WITHOUT%20LOGOTYPE%20AND%20SLOGAN.png')); ?>" alt="VAREN" class="h-7 w-7 object-contain">
            <span class="font-black text-xs text-slate-900">مدیریت وارِن</span>
        </a>
    </div>

    <div class="flex items-center gap-2">
        <a href="<?php echo e(route('home')); ?>" target="_blank" 
           class="w-9 h-9 rounded-xl bg-slate-100 flex items-center justify-center text-slate-700 text-xs hover:bg-slate-200 transition" 
           title="مشاهده فروشگاه">
            <i class="fa-solid fa-store"></i>
        </a>
        <form method="POST" action="<?php echo e(route('logout')); ?>" class="inline">
            <?php echo csrf_field(); ?>
            <button type="submit" 
                    class="w-9 h-9 rounded-xl bg-rose-50 flex items-center justify-center text-rose-600 text-xs hover:bg-rose-100 transition" 
                    title="خروج از حساب">
                <i class="fa-solid fa-power-off"></i>
            </button>
        </form>
    </div>
</header>
<?php /**PATH /var/www/html/resources/views/layouts/admin-mobile-header.blade.php ENDPATH**/ ?>