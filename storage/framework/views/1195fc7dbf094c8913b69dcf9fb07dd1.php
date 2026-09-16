

<?php $__env->startSection('content'); ?>
<div class="max-w-[1700px] w-full mx-auto px-4 sm:px-6 lg:px-10 py-12">
    <div class="bg-white rounded-3xl border border-zinc-200 p-8 shadow-sm">
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl font-bold">
                <i class="fa-solid fa-check"></i>
            </div>
            <h1 class="text-2xl font-black text-black">سفارش شما با موفقیت ثبت شد!</h1>
            <p class="text-xs text-zinc-500 mt-2">با تشکر از خرید شما. شماره پیگیری سفارش: <strong class="text-black font-mono"><?php echo e($order->order_number); ?></strong></p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-4 bg-zinc-50 rounded-2xl mb-8 text-xs font-bold">
            <div>
                <span class="text-zinc-400 block mb-1">اطلاعات تحویل‌گیرنده</span>
                <strong class="text-black block"><?php echo e($order->customer_name); ?></strong>
                <span class="text-zinc-500 block mt-1"><?php echo e($order->customer_phone); ?></span>
                <span class="text-zinc-500 block"><?php echo e($order->customer_email); ?></span>
            </div>
            <div>
                <span class="text-zinc-400 block mb-1">نشانی ارسال</span>
                <strong class="text-black block"><?php echo e($order->city); ?> - کدپستی: <?php echo e($order->postal_code); ?></strong>
                <span class="text-zinc-500 block mt-1"><?php echo e($order->shipping_address); ?></span>
            </div>
        </div>

        <div class="border-t border-zinc-100 pt-6 mb-6">
            <h3 class="text-xs font-black text-black mb-4">اقلام سفارش</h3>
            <div class="space-y-3">
                <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex items-center justify-between text-xs font-bold py-2 border-b border-zinc-100">
                        <div>
                            <span class="text-black"><?php echo e($item->product_name); ?></span>
                            <span class="text-zinc-400 block font-normal text-[10px]">تعداد: <?php echo e($item->quantity); ?> عدد</span>
                        </div>
                        <span class="text-black"><?php echo e(number_format($item->subtotal)); ?> تومان</span>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <div class="bg-black text-white p-6 rounded-2xl flex flex-col sm:flex-row items-center justify-between gap-4">
            <div>
                <span class="text-[10px] text-zinc-400 block">مبلغ کل پرداختی</span>
                <span class="text-xl font-black text-emerald-400"><?php echo e(number_format($order->grand_total)); ?> تومان</span>
            </div>
            <div class="flex items-center gap-3">
                <?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(route('account.orders.show', $order->order_number)); ?>" class="px-5 py-2.5 bg-white/15 hover:bg-white text-white hover:text-black font-black text-xs rounded-xl transition">
                        پیگیری در حساب کاربری
                    </a>
                <?php endif; ?>
                <a href="<?php echo e(route('home')); ?>" class="px-5 py-2.5 bg-[#ef394e] hover:bg-rose-600 text-white font-black text-xs rounded-xl transition">
                    بازگشت به فروشگاه
                </a>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/shop/success.blade.php ENDPATH**/ ?>