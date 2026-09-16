

<?php $__env->startSection('title', 'جزئیات سفارش #' . $order->order_number); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Top Header Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 p-6 shadow-sm flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-base sm:text-lg font-black text-slate-900 font-mono">سفارش #<?php echo e($order->order_number); ?></h2>
            <span class="text-xs text-slate-400 font-bold block mt-1">تاریخ ثبت: <?php echo e($order->created_at->format('Y/m/d - ساعت H:i')); ?></span>
        </div>
        <div class="flex items-center gap-2">
            <span class="px-3 py-1 text-xs font-bold rounded-xl <?php echo e($order->status->badgeColor()); ?>">
                <?php echo e(match($order->status->value) {
                    'pending' => 'در انتظار بررسی',
                    'processing' => 'در حال پردازش',
                    'completed' => 'تحویل شده',
                    'cancelled' => 'لغو شده',
                    default => $order->status->value
                }); ?>

            </span>
            <span class="px-3 py-1 text-xs font-bold rounded-xl <?php echo e($order->payment_status->badgeColor()); ?>">
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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Column -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Items Table -->
            <div class="bg-white rounded-3xl border border-slate-200/80 p-6 shadow-sm">
                <h3 class="text-xs font-black text-slate-900 mb-4 pb-3 border-b border-slate-100">
                    اقلام سفارش (<?php echo e($order->items->count()); ?> کالا)
                </h3>
                <div class="divide-y divide-slate-100">
                    <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="py-3 flex items-center justify-between text-xs">
                            <div>
                                <span class="font-bold text-slate-900 block mb-0.5"><?php echo e($item->product_name); ?></span>
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="text-slate-400 font-mono text-[11px]">کد کالا: <?php echo e($item->sku); ?></span>
                                    <?php if(!empty($item->attributes_snapshot)): ?>
                                        <?php $__currentLoopData = $item->attributes_snapshot; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attrK => $attrV): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <span class="px-2 py-0.5 rounded bg-amber-50 text-amber-800 border border-amber-200 text-[10px] font-black">
                                                <?php echo e($attrK); ?>: <?php echo e($attrV); ?>

                                            </span>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="text-left">
                                <span class="font-black text-slate-900 block"><?php echo e(number_format($item->subtotal)); ?> تومان</span>
                                <span class="text-slate-400 text-[11px] block mt-0.5"><?php echo e($item->quantity); ?> عدد × <?php echo e(number_format($item->unit_price)); ?></span>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <!-- Status Update Form -->
            <div class="bg-white rounded-3xl border border-slate-200/80 p-6 shadow-sm">
                <h3 class="text-xs font-black text-slate-900 mb-4 pb-3 border-b border-slate-100">
                    تغییر وضعیت سفارش و پرداخت
                </h3>
                <form action="<?php echo e(route('admin.orders.updateStatus', $order->id)); ?>" method="POST" class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-end">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PATCH'); ?>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">وضعیت سفارش</label>
                        <select name="status" class="w-full px-3.5 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl font-bold focus:outline-none">
                            <?php $__currentLoopData = \App\Enums\OrderStatus::cases(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $st): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($st->value); ?>" <?php echo e($order->status === $st ? 'selected' : ''); ?>>
                                    <?php echo e(match($st->value) {
                                        'pending' => 'در انتظار بررسی',
                                        'processing' => 'در حال پردازش',
                                        'completed' => 'تحویل شده',
                                        'cancelled' => 'لغو شده',
                                        default => $st->value
                                    }); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">وضعیت پرداخت</label>
                        <select name="payment_status" class="w-full px-3.5 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl font-bold focus:outline-none">
                            <?php $__currentLoopData = \App\Enums\PaymentStatus::cases(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pst): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($pst->value); ?>" <?php echo e($order->payment_status === $pst ? 'selected' : ''); ?>>
                                    <?php echo e(match($pst->value) {
                                        'paid' => 'پرداخت شده',
                                        'unpaid' => 'پرداخت نشده',
                                        'failed' => 'ناموفق',
                                        'refunded' => 'مرجوع شده',
                                        default => $pst->value
                                    }); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div>
                        <button type="submit" class="w-full px-5 py-2.5 bg-black hover:bg-[#ef394e] text-white font-bold text-xs rounded-xl transition shadow">
                            ثبت تغییرات وضعیت
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Customer & Delivery Sidebar -->
        <div>
            <div class="bg-white rounded-3xl border border-slate-200/80 p-6 shadow-sm space-y-4 text-xs">
                <h3 class="text-xs font-black text-slate-900 pb-3 border-b border-slate-100">
                    اطلاعات تحویل‌گیرنده
                </h3>
                <div>
                    <span class="text-slate-400 block mb-0.5 font-bold">نام و نام خانوادگی:</span>
                    <strong class="text-slate-900"><?php echo e($order->customer_name); ?></strong>
                </div>
                <div>
                    <span class="text-slate-400 block mb-0.5 font-bold">ایمیل:</span>
                    <strong class="text-slate-900 font-mono"><?php echo e($order->customer_email); ?></strong>
                </div>
                <div>
                    <span class="text-slate-400 block mb-0.5 font-bold">شماره تماس:</span>
                    <strong class="text-slate-900 font-mono"><?php echo e($order->customer_phone); ?></strong>
                </div>
                <div>
                    <span class="text-slate-400 block mb-0.5 font-bold">نشانی ارسال مرسوله:</span>
                    <strong class="text-slate-900 block mb-0.5"><?php echo e($order->city); ?> - کد پستی: <?php echo e($order->postal_code); ?></strong>
                    <span class="text-slate-600 font-medium"><?php echo e($order->shipping_address); ?></span>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/orders/show.blade.php ENDPATH**/ ?>