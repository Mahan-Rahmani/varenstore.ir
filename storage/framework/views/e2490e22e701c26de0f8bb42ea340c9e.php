

<?php $__env->startSection('content'); ?>
<div class="max-w-[1700px] w-full mx-auto px-4 sm:px-6 lg:px-10 py-8">
    <h1 class="text-xl font-black text-black mb-6 border-b pb-2">سبد خرید شما</h1>

    <?php if(empty($cartItems)): ?>
        <div class="bg-white rounded-3xl border p-12 text-center max-w-lg mx-auto shadow-sm">
            <h2 class="text-base font-bold text-zinc-800 mb-2">سبد خرید شما خالی است</h2>
            <a href="<?php echo e(route('home')); ?>" class="inline-block bg-black text-white font-bold text-xs px-6 py-3 rounded-xl">مشاهده مد فصل</a>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-4">
                <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-white rounded-2xl border p-4 flex items-center justify-between shadow-sm">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-16 bg-zinc-100 rounded-xl overflow-hidden flex-shrink-0">
                                <?php if($item['image']): ?>
                                    <img src="<?php echo e($item['image']); ?>" alt="<?php echo e($item['name']); ?>" class="w-full h-full object-cover">
                                <?php endif; ?>
                            </div>
                            <div>
                                <h3 class="font-bold text-xs text-black"><?php echo e($item['name']); ?></h3>
                                <?php if(!empty($item['attributes'])): ?>
                                    <div class="flex items-center gap-1.5 mt-1 flex-wrap">
                                        <?php $__currentLoopData = $item['attributes']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attrKey => $attrVal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-zinc-100 border border-zinc-200 text-[10px] font-extrabold text-zinc-700">
                                                <span class="text-zinc-400"><?php echo e($attrKey); ?>:</span>
                                                <span><?php echo e($attrVal); ?></span>
                                            </span>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                <?php endif; ?>
                                <span class="text-xs font-black text-zinc-700 block mt-1.5"><?php echo e(number_format($item['unit_price'])); ?> تومان</span>
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <form action="<?php echo e(route('cart.update', $key)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PATCH'); ?>
                                <input type="number" name="quantity" value="<?php echo e($item['quantity']); ?>" min="1" onchange="this.form.submit()" class="w-12 py-1 text-center bg-zinc-100 border rounded-xl font-bold text-xs">
                            </form>
                            <span class="text-xs font-black text-black w-24 text-left"><?php echo e(number_format($item['subtotal'])); ?> تومان</span>
                            <form action="<?php echo e(route('cart.remove', $key)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="text-zinc-400 hover:text-rose-600 text-xs"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <div>
                <div class="bg-white rounded-2xl border p-6 space-y-6 shadow-sm">
                    <h3 class="text-sm font-black text-black pb-2 border-b">خلاصه صورت‌حساب</h3>

                    <div>
                        <?php if($appliedCoupon): ?>
                            <div class="p-3 bg-emerald-50 border border-emerald-200 rounded-xl flex items-center justify-between text-xs">
                                <div>
                                    <span class="font-bold text-emerald-800">کد: <?php echo e($appliedCoupon['code']); ?></span>
                                    <span class="block text-emerald-600 font-bold">-<?php echo e(number_format($discount)); ?> تومان</span>
                                </div>
                                <form action="<?php echo e(route('cart.coupon.remove')); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button class="text-emerald-700 hover:text-rose-600"><i class="fa-solid fa-xmark"></i></button>
                                </form>
                            </div>
                        <?php else: ?>
                            <form action="<?php echo e(route('cart.coupon.apply')); ?>" method="POST" class="flex gap-2">
                                <?php echo csrf_field(); ?>
                                <input type="text" name="code" placeholder="کد تخفیف" class="flex-1 px-3 py-2 text-xs bg-zinc-50 border rounded-xl uppercase font-bold">
                                <button type="submit" class="px-4 py-2 bg-black text-white font-bold text-xs rounded-xl">اعمال</button>
                            </form>
                        <?php endif; ?>
                    </div>

                    <div class="space-y-3 text-xs font-bold text-zinc-600 pt-2 border-t">
                        <div class="flex justify-between"><span>مجموع قیمت کالاها</span><span><?php echo e(number_format($subtotal)); ?> تومان</span></div>
                        <?php if($discount > 0): ?>
                            <div class="flex justify-between text-emerald-600"><span>تخفیف</span><span>-<?php echo e(number_format($discount)); ?> تومان</span></div>
                        <?php endif; ?>
                        <div class="flex justify-between"><span>هزینه ارسال</span><span><?php echo e($shipping == 0 ? 'رایگان' : number_format($shipping).' تومان'); ?></span></div>
                        <div class="flex justify-between text-sm font-black text-black pt-3 border-t">
                            <span>مبلغ قابل پرداخت</span>
                            <span class="text-[#ef394e]"><?php echo e(number_format($grandTotal)); ?> تومان</span>
                        </div>
                    </div>

                    <?php if(auth()->guard()->check()): ?>
                        <a href="<?php echo e(route('checkout.index')); ?>" class="block w-full text-center bg-black hover:bg-[#ef394e] text-white font-bold text-xs py-3.5 rounded-xl shadow transition">
                            ادامه فرآیند خرید <i class="fa-solid fa-arrow-left mr-2"></i>
                        </a>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>" class="block w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs py-3.5 rounded-xl shadow transition">
                            <i class="fa-solid fa-right-to-bracket ml-1.5"></i> ورود به حساب و ثبت نهایی سفارش
                        </a>
                        <p class="text-[10px] text-zinc-400 text-center font-normal">برای تکمیل خرید و دریافت کد رهگیری، لطفا ابتدا وارد شوید.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/shop/cart.blade.php ENDPATH**/ ?>