

<?php $__env->startSection('account_breadcrumb', 'جزئیات سفارش #' . $order->order_number); ?>

<?php $__env->startSection('account_content'); ?>
<div class="space-y-6">
    <!-- Top Bar with Print -->
    <div class="bg-white rounded-3xl border border-zinc-200 p-6 shadow-sm flex flex-wrap items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-3">
                <h1 class="text-base sm:text-lg font-black text-zinc-900 font-mono">سفارش #<?php echo e($order->order_number); ?></h1>
                <span class="px-2.5 py-0.5 text-xs font-bold rounded-lg <?php echo e($order->status->badgeColor()); ?>">
                    <?php echo e(match($order->status->value) {
                        'pending' => 'در انتظار بررسی',
                        'processing' => 'در حال پردازش',
                        'completed' => 'تحویل شده',
                        'cancelled' => 'لغو شده',
                        default => $order->status->value
                    }); ?>

                </span>
            </div>
            <span class="text-xs text-zinc-400 block mt-1">ثبت شده در تاریخ <?php echo e($order->created_at->format('Y/m/d - ساعت H:i')); ?></span>
        </div>

        <div class="flex items-center gap-2">
            <button onclick="window.print()" class="px-4 py-2 bg-zinc-100 hover:bg-zinc-200 text-zinc-800 font-bold text-xs rounded-xl transition flex items-center gap-2">
                <i class="fa-solid fa-print"></i>
                <span>چاپ فاکتور</span>
            </button>
            <a href="<?php echo e(route('account.orders')); ?>" class="px-4 py-2 bg-zinc-900 hover:bg-black text-white font-bold text-xs rounded-xl transition flex items-center gap-2">
                <i class="fa-solid fa-arrow-right text-xs"></i>
                <span>بازگشت به سفارش‌ها</span>
            </a>
        </div>
    </div>

    <!-- Stepper Tracker -->
    <div class="bg-white rounded-3xl border border-zinc-200 p-6 shadow-sm">
        <h2 class="text-xs font-black text-zinc-800 mb-6 pb-2 border-b border-zinc-100 flex items-center gap-2">
            <i class="fa-solid fa-route text-[#ef394e]"></i>
            <span>وضعیت و رهگیری مرسوله</span>
        </h2>

        <?php
            $isCancelled = $order->status->value === 'cancelled';
            $step = match($order->status->value) {
                'pending' => 1,
                'processing' => 2,
                'completed' => 4,
                'cancelled' => 0,
                default => 1
            };
        ?>

        <?php if($isCancelled): ?>
            <div class="p-4 bg-rose-50 border border-rose-200 rounded-2xl text-rose-700 text-xs font-bold flex items-center gap-3">
                <i class="fa-solid fa-circle-xmark text-lg"></i>
                <span>این سفارش لغو شده است. در صورت نیاز به پیگیری با پشتیبانی تماس بگیرید.</span>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-4 gap-2 relative">
                <!-- Step 1 -->
                <div class="flex flex-col items-center text-center">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-black text-xs mb-2 <?php echo e($step >= 1 ? 'bg-emerald-500 text-white shadow-md shadow-emerald-500/20' : 'bg-zinc-100 text-zinc-400'); ?>">
                        <i class="fa-solid fa-receipt"></i>
                    </div>
                    <span class="text-xs font-bold <?php echo e($step >= 1 ? 'text-zinc-900' : 'text-zinc-400'); ?>">ثبت سفارش</span>
                </div>

                <!-- Step 2 -->
                <div class="flex flex-col items-center text-center">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-black text-xs mb-2 <?php echo e($step >= 2 ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20' : 'bg-zinc-100 text-zinc-400'); ?>">
                        <i class="fa-solid fa-box-open"></i>
                    </div>
                    <span class="text-xs font-bold <?php echo e($step >= 2 ? 'text-zinc-900' : 'text-zinc-400'); ?>">آماده‌سازی</span>
                </div>

                <!-- Step 3 -->
                <div class="flex flex-col items-center text-center">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-black text-xs mb-2 <?php echo e($step >= 3 ? 'bg-amber-500 text-white shadow-md shadow-amber-500/20' : 'bg-zinc-100 text-zinc-400'); ?>">
                        <i class="fa-solid fa-truck-fast"></i>
                    </div>
                    <span class="text-xs font-bold <?php echo e($step >= 3 ? 'text-zinc-900' : 'text-zinc-400'); ?>">تحویل پست</span>
                </div>

                <!-- Step 4 -->
                <div class="flex flex-col items-center text-center">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-black text-xs mb-2 <?php echo e($step >= 4 ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/20' : 'bg-zinc-100 text-zinc-400'); ?>">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    <span class="text-xs font-bold <?php echo e($step >= 4 ? 'text-zinc-900' : 'text-zinc-400'); ?>">تحویل به مشتری</span>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Grid for Items & Summary -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Order Items -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-3xl border border-zinc-200 p-6 shadow-sm">
                <h3 class="text-xs font-black text-zinc-900 mb-4 pb-2 border-b border-zinc-100">
                    اقلام سفارش (<?php echo e($order->items->count()); ?> کالا)
                </h3>

                <div class="divide-y divide-zinc-100">
                    <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="py-3.5 flex items-center justify-between gap-4">
                            <div class="flex items-center gap-3.5">
                                <div class="w-16 h-20 bg-zinc-50 rounded-xl border border-zinc-200 overflow-hidden shrink-0 flex items-center justify-center p-0.5">
                                    <?php if($item->product?->featured_image): ?>
                                        <img src="<?php echo e($item->product->featured_image); ?>" alt="<?php echo e($item->product_name); ?>" class="w-full h-full object-cover rounded-lg">
                                    <?php else: ?>
                                        <i class="fa-solid fa-box text-zinc-300 text-lg"></i>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <h4 class="font-bold text-xs text-zinc-900 mb-1">
                                        <?php if($item->product): ?>
                                            <a href="<?php echo e(route('product.show', $item->product->slug)); ?>" class="hover:text-[#ef394e] transition">
                                                <?php echo e($item->product_name); ?>

                                            </a>
                                        <?php else: ?>
                                            <?php echo e($item->product_name); ?>

                                        <?php endif; ?>
                                    </h4>
                                    <span class="text-[11px] text-zinc-400 font-mono block">کد کالا: <?php echo e($item->sku); ?></span>
                                    <span class="text-[11px] text-zinc-500 font-bold block mt-0.5">تعداد: <?php echo e($item->quantity); ?> عدد</span>
                                </div>
                            </div>

                            <div class="text-left">
                                <span class="text-xs font-black text-zinc-900 block"><?php echo e(number_format($item->subtotal)); ?> تومان</span>
                                <span class="text-[10px] text-zinc-400 block mt-0.5">هر واحد: <?php echo e(number_format($item->unit_price)); ?></span>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <!-- Recipient & Delivery Address -->
            <div class="bg-white rounded-3xl border border-zinc-200 p-6 shadow-sm">
                <h3 class="text-xs font-black text-zinc-900 mb-4 pb-2 border-b border-zinc-100">
                    اطلاعات تحویل‌گیرنده و نشانی
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div>
                        <span class="text-zinc-400 block mb-0.5">تحویل‌گیرنده:</span>
                        <strong class="text-zinc-800"><?php echo e($order->customer_name); ?></strong>
                    </div>
                    <div>
                        <span class="text-zinc-400 block mb-0.5">شماره تماس:</span>
                        <strong class="text-zinc-800 font-mono"><?php echo e($order->customer_phone); ?></strong>
                    </div>
                    <div>
                        <span class="text-zinc-400 block mb-0.5">شهر:</span>
                        <strong class="text-zinc-800"><?php echo e($order->city); ?></strong>
                    </div>
                    <div>
                        <span class="text-zinc-400 block mb-0.5">کد پستی:</span>
                        <strong class="text-zinc-800 font-mono"><?php echo e($order->postal_code); ?></strong>
                    </div>
                    <div class="sm:col-span-2">
                        <span class="text-zinc-400 block mb-0.5">نشانی پستی:</span>
                        <span class="text-zinc-700 font-medium"><?php echo e($order->shipping_address); ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Invoice Breakdown -->
        <div>
            <div class="bg-white rounded-3xl border border-zinc-200 p-6 shadow-sm space-y-4">
                <h3 class="text-xs font-black text-zinc-900 pb-2 border-b border-zinc-100">
                    خلاصه مالی سفارش
                </h3>

                <div class="space-y-3 text-xs font-bold text-zinc-600">
                    <div class="flex justify-between">
                        <span>مبلغ اقلام:</span>
                        <span class="text-zinc-800"><?php echo e(number_format($order->subtotal)); ?> تومان</span>
                    </div>

                    <?php if($order->discount_amount > 0): ?>
                        <div class="flex justify-between text-emerald-600">
                            <span>تخفیف (کوپن <?php echo e($order->coupon_code); ?>):</span>
                            <span>-<?php echo e(number_format($order->discount_amount)); ?> تومان</span>
                        </div>
                    <?php endif; ?>

                    <div class="flex justify-between">
                        <span>هزینه حمل و نقل:</span>
                        <span class="text-zinc-800"><?php echo e($order->shipping_fee == 0 ? 'رایگان' : number_format($order->shipping_fee) . ' تومان'); ?></span>
                    </div>

                    <?php if($order->tax_amount > 0): ?>
                        <div class="flex justify-between text-zinc-500">
                            <span>مالیات بر ارزش افزوده:</span>
                            <span><?php echo e(number_format($order->tax_amount)); ?> تومان</span>
                        </div>
                    <?php endif; ?>

                    <div class="pt-3 border-t border-zinc-200 flex justify-between items-baseline">
                        <span class="text-sm font-black text-zinc-900">مبلغ پرداخت‌شده:</span>
                        <span class="text-base font-black text-[#ef394e]"><?php echo e(number_format($order->grand_total)); ?> تومان</span>
                    </div>
                </div>

                <div class="pt-4 border-t border-zinc-100 space-y-2 text-xs">
                    <div class="flex justify-between text-zinc-500">
                        <span>روش پرداخت:</span>
                        <span class="font-bold text-zinc-800"><?php echo e($order->payment_method === 'zarinpal' ? 'درگاه زرین‌پال' : 'پرداخت تستی'); ?></span>
                    </div>
                    <div class="flex justify-between text-zinc-500">
                        <span>وضعیت تراکنش:</span>
                        <span class="px-2 py-0.5 text-[10px] font-bold rounded <?php echo e($order->payment_status->badgeColor()); ?>">
                            <?php echo e($order->payment_status === \App\Enums\PaymentStatus::PAID ? 'موفق' : $order->payment_status->value); ?>

                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('account.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/account/order_show.blade.php ENDPATH**/ ?>