<?php
// Orders card list for mobile devices
?>
<div class="space-y-3 sm:hidden">
    <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-xs space-y-3">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-slate-400 text-[10px] block mb-0.5">کد سفارش</span>
                    <a href="<?php echo e(route('admin.orders.show', $order->id)); ?>" class="font-mono font-bold text-sky-600 text-sm">
                        #<?php echo e($order->order_number); ?>

                    </a>
                </div>
                <div class="text-left">
                    <span class="text-slate-400 text-[10px] block mb-0.5">مبلغ کل</span>
                    <span class="font-black text-slate-900 text-sm"><?php echo e(number_format($order->grand_total)); ?> <span class="text-[10px] font-normal text-slate-400">تومان</span></span>
                </div>
            </div>

            <div class="pt-2.5 border-t border-slate-100 flex items-center justify-between text-xs">
                <div>
                    <span class="font-bold text-slate-800 block"><?php echo e($order->customer_name); ?></span>
                    <span class="text-[10px] text-slate-400 font-mono"><?php echo e($order->created_at->format('Y/m/d - H:i')); ?></span>
                </div>
                <div class="flex items-center gap-1.5">
                    <span class="px-2 py-0.5 text-[10px] font-bold rounded-lg <?php echo e($order->payment_status->badgeColor()); ?>">
                        <?php echo e(match($order->payment_status->value) {
                            'paid' => 'پرداخت شد',
                            'unpaid' => 'پرداخت نشده',
                            'failed' => 'ناموفق',
                            'refunded' => 'مرجوع',
                            default => $order->payment_status->value
                        }); ?>

                    </span>
                    <span class="px-2 py-0.5 text-[10px] font-bold rounded-lg <?php echo e($order->status->badgeColor()); ?>">
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

            <div class="pt-2">
                <a href="<?php echo e(route('admin.orders.show', $order->id)); ?>" 
                   class="w-full py-2.5 bg-slate-900 active:bg-black text-white font-bold text-xs rounded-xl transition flex items-center justify-center gap-1.5 shadow-xs">
                    <span>مشاهده جزئیات و مدیریت سفارش</span>
                    <i class="fa-solid fa-chevron-left text-[10px]"></i>
                </a>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="bg-white rounded-2xl p-8 text-center border border-slate-200/80 text-slate-400 text-xs font-bold">
            سفارشی با این مشخصات یافت نشد.
        </div>
    <?php endif; ?>
</div>
<?php /**PATH /var/www/html/resources/views/admin/orders/orders-mobile-list.blade.php ENDPATH**/ ?>