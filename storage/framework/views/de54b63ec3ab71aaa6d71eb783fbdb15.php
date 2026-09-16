

<?php $__env->startSection('title', 'داشبورد و خلاصه وضعیت فروشگاه'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-4 sm:space-y-6">
    <!-- Stat Cards (2 cols on mobile for maximum readability & tap comfort) -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-2.5 sm:gap-4">
        <div class="bg-white p-3.5 sm:p-5 rounded-2xl sm:rounded-3xl border border-slate-200/80 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-[10px] sm:text-xs text-slate-400 font-bold block mb-0.5 sm:mb-1">درآمد کل فروش</span>
                <span class="text-sm sm:text-xl font-black text-emerald-600 block"><?php echo e(number_format($totalRevenue)); ?> <span class="text-[9px] sm:text-xs font-normal text-slate-500">تومان</span></span>
            </div>
            <div class="w-9 h-9 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-base sm:text-xl shrink-0">
                <i class="fa-solid fa-sack-dollar"></i>
            </div>
        </div>

        <div class="bg-white p-3.5 sm:p-5 rounded-2xl sm:rounded-3xl border border-slate-200/80 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-[10px] sm:text-xs text-slate-400 font-bold block mb-0.5 sm:mb-1">کل سفارش‌ها</span>
                <span class="text-sm sm:text-xl font-black text-slate-900 block"><?php echo e(number_format($totalOrders)); ?> <span class="text-[9px] sm:text-xs font-normal text-slate-500">سفارش</span></span>
            </div>
            <div class="w-9 h-9 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-base sm:text-xl shrink-0">
                <i class="fa-solid fa-receipt"></i>
            </div>
        </div>

        <div class="bg-white p-3.5 sm:p-5 rounded-2xl sm:rounded-3xl border border-slate-200/80 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-[10px] sm:text-xs text-slate-400 font-bold block mb-0.5 sm:mb-1">محصولات فعال</span>
                <span class="text-sm sm:text-xl font-black text-slate-900 block"><?php echo e(number_format($totalProducts)); ?> <span class="text-[9px] sm:text-xs font-normal text-slate-500">کالا</span></span>
            </div>
            <div class="w-9 h-9 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center text-base sm:text-xl shrink-0">
                <i class="fa-solid fa-box-open"></i>
            </div>
        </div>

        <div class="bg-white p-3.5 sm:p-5 rounded-2xl sm:rounded-3xl border border-slate-200/80 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-[10px] sm:text-xs text-slate-400 font-bold block mb-0.5 sm:mb-1">مشتریان ثبت‌نامی</span>
                <span class="text-sm sm:text-xl font-black text-slate-900 block"><?php echo e(number_format($totalCustomers)); ?> <span class="text-[9px] sm:text-xs font-normal text-slate-500">کاربر</span></span>
            </div>
            <div class="w-9 h-9 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-base sm:text-xl shrink-0">
                <i class="fa-solid fa-users"></i>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6">
        <!-- Recent Orders -->
        <div class="lg:col-span-2 bg-white rounded-2xl sm:rounded-3xl border border-slate-200/80 p-4 sm:p-6 shadow-xs">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                <h3 class="text-xs sm:text-sm font-black text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-clock-rotate-left text-[#ef394e]"></i>
                    <span>آخرین سفارش‌های ثبت شده</span>
                </h3>
                <a href="<?php echo e(route('admin.orders.index')); ?>" class="text-[11px] sm:text-xs text-[#ef394e] font-bold hover:underline">مشاهده همه</a>
            </div>

            <?php echo $__env->make('admin.dashboard-recent-orders-mobile', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <div class="hidden sm:block overflow-x-auto">
                <table class="w-full text-right text-xs">
                    <thead class="bg-slate-50 text-slate-400 font-bold">
                        <tr>
                            <th class="p-3 rounded-r-xl">کد سفارش</th>
                            <th class="p-3">مشتری</th>
                            <th class="p-3">مبلغ نهایی</th>
                            <th class="p-3">پرداخت</th>
                            <th class="p-3 rounded-l-xl">وضعیت</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="p-3 font-mono font-bold text-sky-600">
                                    <a href="<?php echo e(route('admin.orders.show', $order->id)); ?>">#<?php echo e($order->order_number); ?></a>
                                </td>
                                <td class="p-3 font-bold text-slate-800"><?php echo e($order->customer_name); ?></td>
                                <td class="p-3 font-black text-slate-900"><?php echo e(number_format($order->grand_total)); ?> <span class="text-[10px] font-normal text-slate-400">تومان</span></td>
                                <td class="p-3">
                                    <span class="px-2.5 py-1 text-[11px] font-bold rounded-lg <?php echo e($order->payment_status->badgeColor()); ?>">
                                        <?php echo e(match($order->payment_status->value) {
                                            'paid' => 'پرداخت شده',
                                            'unpaid' => 'پرداخت نشده',
                                            'failed' => 'ناموفق',
                                            'refunded' => 'مرجوع شده',
                                            default => $order->payment_status->value
                                        }); ?>

                                    </span>
                                </td>
                                <td class="p-3">
                                    <span class="px-2.5 py-1 text-[11px] font-bold rounded-lg <?php echo e($order->status->badgeColor()); ?>">
                                        <?php echo e(match($order->status->value) {
                                            'pending' => 'در انتظار بررسی',
                                            'processing' => 'در حال پردازش',
                                            'completed' => 'تحویل شده',
                                            'cancelled' => 'لغو شده',
                                            default => $order->status->value
                                        }); ?>

                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Low Stock Alert -->
        <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-200/80 p-4 sm:p-6 shadow-xs">
            <h3 class="text-xs sm:text-sm font-black text-slate-900 mb-4 pb-3 border-b border-slate-100 flex items-center gap-2">
                <i class="fa-solid fa-triangle-exclamation text-amber-500"></i>
                <span>هشدار کمبود موجودی</span>
            </h3>
            <div class="space-y-2 sm:space-y-3">
                <?php $__empty_1 = true; $__currentLoopData = $lowStockProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="flex items-center justify-between text-xs p-2.5 sm:p-3 bg-slate-50 rounded-xl sm:rounded-2xl border border-slate-100">
                        <div>
                            <span class="font-bold text-slate-800 block line-clamp-1 mb-0.5 text-[11px] sm:text-xs"><?php echo e($p->name); ?></span>
                            <span class="text-slate-400 font-mono text-[10px]">کد: <?php echo e($p->sku); ?></span>
                        </div>
                        <span class="px-2 py-0.5 sm:px-2.5 sm:py-1 bg-amber-100 text-amber-900 font-black rounded-lg sm:rounded-xl text-[10px] sm:text-[11px] shrink-0">
                            <?php echo e($p->stock); ?> عدد
                        </span>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-xs text-slate-400 italic text-center py-6">موجودی کافی است.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/dashboard.blade.php ENDPATH**/ ?>