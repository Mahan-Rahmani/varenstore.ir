

<?php $__env->startSection('account_breadcrumb', 'داشبورد'); ?>

<?php $__env->startSection('account_content'); ?>
<div class="space-y-6">
    <!-- Welcome Banner -->
    <div class="bg-gradient-to-l from-zinc-900 to-zinc-800 text-white rounded-3xl p-6 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-black mb-1">سلام، <?php echo e($user->name); ?> عزیز خوش آمدید! 👋</h1>
            <p class="text-xs text-zinc-300 font-medium">از طریق این پنل می‌توانید سفارش‌ها و اطلاعات کاربری خود را مدیریت کنید.</p>
        </div>
        <a href="<?php echo e(route('home')); ?>" class="self-start sm:self-auto px-5 py-2.5 bg-white text-zinc-900 hover:bg-[#ef394e] hover:text-white font-black text-xs rounded-xl shadow transition duration-300">
            مشاهده فروشگاه
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl border border-zinc-200 p-4 shadow-sm flex items-center gap-3.5">
            <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg shrink-0">
                <i class="fa-solid fa-boxes-stacked"></i>
            </div>
            <div>
                <span class="text-[11px] text-zinc-400 font-bold block">کل سفارش‌ها</span>
                <span class="text-lg font-black text-zinc-900"><?php echo e($totalOrders); ?></span>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-zinc-200 p-4 shadow-sm flex items-center gap-3.5">
            <div class="w-11 h-11 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg shrink-0">
                <i class="fa-solid fa-clock-rotate-left"></i>
            </div>
            <div>
                <span class="text-[11px] text-zinc-400 font-bold block">در حال پردازش</span>
                <span class="text-lg font-black text-zinc-900"><?php echo e($processingCount); ?></span>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-zinc-200 p-4 shadow-sm flex items-center gap-3.5">
            <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg shrink-0">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div>
                <span class="text-[11px] text-zinc-400 font-bold block">تحویل شده</span>
                <span class="text-lg font-black text-zinc-900"><?php echo e($completedCount); ?></span>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-zinc-200 p-4 shadow-sm flex items-center gap-3.5">
            <div class="w-11 h-11 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-lg shrink-0">
                <i class="fa-solid fa-hourglass-half"></i>
            </div>
            <div>
                <span class="text-[11px] text-zinc-400 font-bold block">در انتظار تایید</span>
                <span class="text-lg font-black text-zinc-900"><?php echo e($pendingCount); ?></span>
            </div>
        </div>
    </div>

    <!-- Recent Orders Section -->
    <div class="bg-white rounded-3xl border border-zinc-200 p-6 shadow-sm">
        <div class="flex items-center justify-between pb-4 mb-4 border-b border-zinc-100">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-bag-shopping text-[#ef394e]"></i>
                <h2 class="text-sm font-black text-zinc-900">آخرین سفارش‌های من</h2>
            </div>
            <?php if($recentOrders->isNotEmpty()): ?>
                <a href="<?php echo e(route('account.orders')); ?>" class="text-xs font-bold text-[#ef394e] hover:underline flex items-center gap-1">
                    <span>مشاهده همه سفارش‌ها</span>
                    <i class="fa-solid fa-chevron-left text-[10px]"></i>
                </a>
            <?php endif; ?>
        </div>

        <?php if($recentOrders->isEmpty()): ?>
            <div class="text-center py-10">
                <div class="w-14 h-14 rounded-full bg-zinc-100 text-zinc-400 flex items-center justify-center text-xl mx-auto mb-3">
                    <i class="fa-solid fa-receipt"></i>
                </div>
                <h3 class="font-black text-zinc-800 text-sm mb-1">هنوز سفارشی ثبت نکرده‌اید!</h3>
                <p class="text-xs text-zinc-400 mb-4">جدیدترین محصولات و تخفیف‌های ویژه فصل را مشاهده کنید.</p>
                <a href="<?php echo e(route('home')); ?>" class="inline-flex items-center gap-2 px-5 py-2.5 bg-black text-white hover:bg-[#ef394e] font-bold text-xs rounded-xl transition">
                    <i class="fa-solid fa-bag-shopping"></i>
                    <span>شروع خرید آنلاین</span>
                </a>
            </div>
        <?php else: ?>
            <div class="space-y-4">
                <?php $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="border border-zinc-100 rounded-2xl p-4 hover:border-zinc-300 transition-colors bg-zinc-50/50">
                        <div class="flex flex-wrap items-center justify-between gap-3 pb-3 border-b border-zinc-200/60 text-xs">
                            <div class="flex items-center gap-3">
                                <span class="font-black text-zinc-900 font-mono">#<?php echo e($order->order_number); ?></span>
                                <span class="text-zinc-400 text-[11px]"><?php echo e($order->created_at->format('Y/m/d - H:i')); ?></span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="px-2.5 py-1 text-[11px] font-bold rounded-lg <?php echo e($order->status->badgeColor()); ?>">
                                    <?php echo e(match($order->status->value) {
                                        'pending' => 'در انتظار بررسی',
                                        'processing' => 'در حال پردازش',
                                        'completed' => 'تحویل شده',
                                        'cancelled' => 'لغو شده',
                                        default => $order->status->value
                                    }); ?>

                                </span>
                                <span class="px-2.5 py-1 text-[11px] font-bold rounded-lg <?php echo e($order->payment_status->badgeColor()); ?>">
                                    <?php echo e(match($order->payment_status->value) {
                                        'paid' => 'پرداخت شده',
                                        'unpaid' => 'پرداخت نشده',
                                        'failed' => 'ناموفق',
                                        'refunded' => 'مرجوع شده',
                                        default => $order->payment_status->value
                                    }); ?>

                                </span>
                            </div>
                        </div>

                        <div class="pt-3 flex flex-wrap items-center justify-between gap-4">
                            <div class="flex items-center gap-2 overflow-x-auto py-1">
                                <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="w-12 h-14 rounded-xl bg-white border border-zinc-200 overflow-hidden shrink-0 flex items-center justify-center p-0.5" title="<?php echo e($item->product_name); ?>">
                                        <?php if($item->product?->featured_image): ?>
                                            <img src="<?php echo e($item->product->featured_image); ?>" alt="<?php echo e($item->product_name); ?>" class="w-full h-full object-cover rounded-lg">
                                        <?php else: ?>
                                            <i class="fa-solid fa-box text-zinc-300 text-xs"></i>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <span class="text-[11px] text-zinc-500 font-bold mr-2"><?php echo e($order->items->count()); ?> کالا</span>
                            </div>

                            <div class="flex items-center gap-4">
                                <div class="text-left">
                                    <span class="text-[10px] text-zinc-400 block font-bold">مبلغ نهایی:</span>
                                    <span class="text-xs font-black text-zinc-900"><?php echo e(number_format($order->grand_total)); ?> تومان</span>
                                </div>
                                <a href="<?php echo e(route('account.orders.show', $order->order_number)); ?>" 
                                   class="px-3.5 py-2 bg-white hover:bg-black hover:text-white text-zinc-800 border border-zinc-300 font-bold text-xs rounded-xl transition flex items-center gap-1.5 shadow-sm">
                                    <span>مشاهده فاکتور</span>
                                    <i class="fa-solid fa-arrow-left text-[10px]"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('account.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/account/dashboard.blade.php ENDPATH**/ ?>