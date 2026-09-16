<?php
// Recent orders card list component for mobile
?>
<div class="space-y-2.5 sm:hidden">
    <?php $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a href="<?php echo e(route('admin.orders.show', $order->id)); ?>" class="block p-3 bg-slate-50 hover:bg-slate-100/80 active:scale-[0.99] rounded-xl border border-slate-100 transition">
            <div class="flex items-center justify-between mb-1.5">
                <span class="font-mono font-bold text-sky-600 text-xs">#<?php echo e($order->order_number); ?></span>
                <span class="text-xs font-black text-slate-900"><?php echo e(number_format($order->grand_total)); ?> <span class="text-[9px] font-normal text-slate-400">تومان</span></span>
            </div>
            <div class="flex items-center justify-between text-[11px]">
                <span class="font-bold text-slate-700"><?php echo e($order->customer_name); ?></span>
                <div class="flex items-center gap-1">
                    <span class="px-1.5 py-0.5 text-[9px] font-bold rounded <?php echo e($order->payment_status->badgeColor()); ?>">
                        <?php echo e(match($order->payment_status->value) {
                            'paid' => 'پرداخت شد',
                            'unpaid' => 'پرداخت نشده',
                            'failed' => 'ناموفق',
                            'refunded' => 'مرجوع',
                            default => $order->payment_status->value
                        }); ?>

                    </span>
                    <span class="px-1.5 py-0.5 text-[9px] font-bold rounded <?php echo e($order->status->badgeColor()); ?>">
                        <?php echo e(match($order->status->value) {
                            'pending' => 'در انتظار',
                            'processing' => 'پردازش',
                            'completed' => 'تحویل شده',
                            'cancelled' => 'لغو شده',
                            default => $order->status->value
                        }); ?>

                    </span>
                </div>
            </div>
        </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php /**PATH /var/www/html/resources/views/admin/dashboard-recent-orders-mobile.blade.php ENDPATH**/ ?>