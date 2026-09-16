

<?php $__env->startSection('title', 'مدیریت و لیست سفارش‌ها'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-4 sm:space-y-6">
    <!-- Filter/Search -->
    <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
        <form action="<?php echo e(route('admin.orders.index')); ?>" method="GET" class="flex items-center gap-2 w-full sm:w-auto">
            <input type="text" name="search" value="<?php echo e(request('search')); ?>" 
                   placeholder="جستجوی کد سفارش، شماره همراه، نام..." 
                   class="px-3.5 py-2.5 text-xs bg-white border border-slate-200 rounded-xl sm:rounded-2xl flex-1 sm:w-80 focus:outline-none focus:border-slate-400 font-medium shadow-xs">
            <button type="submit" class="px-4 py-2.5 bg-slate-900 active:bg-black text-white font-bold text-xs rounded-xl sm:rounded-2xl shadow transition shrink-0">
                جستجو
            </button>
        </form>
    </div>

    <!-- Mobile Orders Card View -->
    <?php echo $__env->make('admin.orders.orders-mobile-list', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- Desktop Orders Table View -->
    <div class="hidden sm:block bg-white rounded-3xl border border-slate-200/80 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-right text-xs">
                <thead class="bg-slate-50 text-slate-400 font-bold">
                    <tr>
                        <th class="p-4">کد سفارش</th>
                        <th class="p-4">مشتری</th>
                        <th class="p-4">تاریخ ثبت</th>
                        <th class="p-4">مبلغ کل</th>
                        <th class="p-4">وضعیت پرداخت</th>
                        <th class="p-4">وضعیت سفارش</th>
                        <th class="p-4 text-left">عملیات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="p-4 font-mono font-bold text-sky-600">
                                <a href="<?php echo e(route('admin.orders.show', $order->id)); ?>">#<?php echo e($order->order_number); ?></a>
                            </td>
                            <td class="p-4 font-bold text-slate-800"><?php echo e($order->customer_name); ?></td>
                            <td class="p-4 text-slate-400 dir-ltr text-right"><?php echo e($order->created_at->format('Y/m/d - H:i')); ?></td>
                            <td class="p-4 font-black text-slate-900"><?php echo e(number_format($order->grand_total)); ?> تومان</td>
                            <td class="p-4">
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
                            <td class="p-4">
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
                            <td class="p-4 text-left">
                                <a href="<?php echo e(route('admin.orders.show', $order->id)); ?>" class="px-3.5 py-1.5 bg-slate-900 hover:bg-black text-white font-bold text-xs rounded-xl transition">
                                    جزئیات و تغییر وضعیت
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4"><?php echo e($orders->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/orders/index.blade.php ENDPATH**/ ?>