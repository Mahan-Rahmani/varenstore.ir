

<?php $__env->startSection('account_breadcrumb', 'سفارش‌های من'); ?>

<?php $__env->startSection('account_content'); ?>
<div class="space-y-6">
    <div class="bg-white rounded-3xl border border-zinc-200 p-6 shadow-sm">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-zinc-100">
            <div>
                <h1 class="text-base font-black text-zinc-900 mb-1">تاریخچه سفارش‌های من</h1>
                <p class="text-xs text-zinc-400">لیست تمامی سفارش‌های ثبت شده در فروشگاه وارِن</p>
            </div>
        </div>

        <!-- Filter Tabs -->
        <div class="flex items-center gap-2 overflow-x-auto py-4 border-b border-zinc-100 text-xs font-bold">
            <a href="<?php echo e(route('account.orders')); ?>" 
               class="px-3.5 py-1.5 rounded-xl whitespace-nowrap transition <?php echo e(!request('status') ? 'bg-black text-white' : 'bg-zinc-100 text-zinc-600 hover:bg-zinc-200'); ?>">
                همه سفارش‌ها
            </a>
            <a href="<?php echo e(route('account.orders', ['status' => 'processing'])); ?>" 
               class="px-3.5 py-1.5 rounded-xl whitespace-nowrap transition <?php echo e(request('status') === 'processing' ? 'bg-black text-white' : 'bg-zinc-100 text-zinc-600 hover:bg-zinc-200'); ?>">
                در حال پردازش
            </a>
            <a href="<?php echo e(route('account.orders', ['status' => 'completed'])); ?>" 
               class="px-3.5 py-1.5 rounded-xl whitespace-nowrap transition <?php echo e(request('status') === 'completed' ? 'bg-black text-white' : 'bg-zinc-100 text-zinc-600 hover:bg-zinc-200'); ?>">
                تحویل شده
            </a>
            <a href="<?php echo e(route('account.orders', ['status' => 'pending'])); ?>" 
               class="px-3.5 py-1.5 rounded-xl whitespace-nowrap transition <?php echo e(request('status') === 'pending' ? 'bg-black text-white' : 'bg-zinc-100 text-zinc-600 hover:bg-zinc-200'); ?>">
                در انتظار بررسی
            </a>
            <a href="<?php echo e(route('account.orders', ['status' => 'cancelled'])); ?>" 
               class="px-3.5 py-1.5 rounded-xl whitespace-nowrap transition <?php echo e(request('status') === 'cancelled' ? 'bg-black text-white' : 'bg-zinc-100 text-zinc-600 hover:bg-zinc-200'); ?>">
                لغو شده
            </a>
        </div>

        <!-- Orders List -->
        <div class="pt-5">
            <?php if($orders->isEmpty()): ?>
                <div class="text-center py-12">
                    <div class="w-14 h-14 rounded-full bg-zinc-100 text-zinc-400 flex items-center justify-center text-xl mx-auto mb-3">
                        <i class="fa-solid fa-box-open"></i>
                    </div>
                    <h3 class="font-black text-zinc-800 text-sm mb-1">هیچ سفارشی در این بخش یافت نشد!</h3>
                    <p class="text-xs text-zinc-400 mb-4">می‌توانید فیلترهای دیگر را بررسی کنید یا خرید جدیدی ثبت نمایید.</p>
                </div>
            <?php else: ?>
                <div class="space-y-4">
                    <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="border border-zinc-200/80 rounded-2xl p-5 hover:border-zinc-300 transition bg-white shadow-sm">
                            <div class="flex flex-wrap items-center justify-between gap-3 pb-3 border-b border-zinc-100 text-xs">
                                <div class="flex items-center gap-3">
                                    <span class="font-black text-zinc-900 font-mono text-sm">#<?php echo e($order->order_number); ?></span>
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

                            <div class="pt-4 flex flex-wrap items-center justify-between gap-4">
                                <div class="flex items-center gap-2.5 overflow-x-auto py-1">
                                    <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="w-14 h-16 rounded-xl bg-zinc-50 border border-zinc-200 overflow-hidden shrink-0 flex items-center justify-center p-0.5" title="<?php echo e($item->product_name); ?>">
                                            <?php if($item->product?->featured_image): ?>
                                                <img src="<?php echo e($item->product->featured_image); ?>" alt="<?php echo e($item->product_name); ?>" class="w-full h-full object-cover rounded-lg">
                                            <?php else: ?>
                                                <i class="fa-solid fa-box text-zinc-300 text-xs"></i>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <div class="mr-2">
                                        <span class="text-xs font-bold text-zinc-800 block"><?php echo e($order->items->count()); ?> قلم کالا</span>
                                        <span class="text-[10px] text-zinc-400">ارسال به: <?php echo e($order->city); ?></span>
                                    </div>
                                </div>

                                <div class="flex items-center gap-4">
                                    <div class="text-left">
                                        <span class="text-[10px] text-zinc-400 block font-bold">مبلغ نهایی:</span>
                                        <span class="text-sm font-black text-zinc-900"><?php echo e(number_format($order->grand_total)); ?> تومان</span>
                                    </div>
                                    <a href="<?php echo e(route('account.orders.show', $order->order_number)); ?>" 
                                       class="px-4 py-2.5 bg-black hover:bg-[#ef394e] text-white font-bold text-xs rounded-xl transition flex items-center gap-2 shadow-sm">
                                        <span>مشاهده فاکتور و رهگیری</span>
                                        <i class="fa-solid fa-arrow-left text-[11px]"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div class="mt-6">
                    <?php echo e($orders->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('account.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/account/orders.blade.php ENDPATH**/ ?>