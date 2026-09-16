<?php
// Products mobile card list component
?>
<div class="space-y-3 sm:hidden">
    <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="bg-white rounded-2xl border border-slate-200/80 p-3.5 shadow-xs space-y-3">
            <div class="flex items-start gap-3">
                <div class="w-14 h-16 bg-slate-100 rounded-xl overflow-hidden shrink-0 flex items-center justify-center p-0.5 border">
                    <?php if($product->featured_image): ?>
                        <img src="<?php echo e($product->featured_image); ?>" alt="<?php echo e($product->name); ?>" class="w-full h-full object-cover rounded-lg">
                    <?php else: ?>
                        <i class="fa-solid fa-image text-slate-300"></i>
                    <?php endif; ?>
                </div>
                <div class="flex-1 min-w-0">
                    <a href="<?php echo e(route('product.show', $product->slug)); ?>" target="_blank" class="font-bold text-slate-900 hover:text-[#ef394e] text-xs block line-clamp-2">
                        <?php echo e($product->name); ?>

                    </a>
                    <div class="flex items-center gap-1.5 mt-1">
                        <span class="text-[10px] font-mono text-slate-400 font-bold">کد: <?php echo e($product->sku); ?></span>
                        <?php if($product->category): ?>
                            <span class="text-[10px] text-sky-600 font-bold bg-sky-50 px-1.5 py-0.2 rounded">
                                <?php echo e($product->category->name); ?>

                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Pricing & Stock -->
            <div class="pt-2.5 border-t border-slate-100 flex items-center justify-between text-xs">
                <div>
                    <span class="text-[10px] text-slate-400 block">قیمت فروش</span>
                    <?php if($product->has_discount): ?>
                        <div class="flex items-center gap-1.5">
                            <span class="font-black text-emerald-600"><?php echo e(number_format($product->sale_price)); ?> تومان</span>
                            <span class="text-[10px] text-slate-400 line-through"><?php echo e(number_format($product->price)); ?></span>
                        </div>
                    <?php else: ?>
                        <span class="font-black text-slate-900"><?php echo e(number_format($product->price)); ?> تومان</span>
                    <?php endif; ?>
                </div>
                <div class="text-left">
                    <span class="text-[10px] text-slate-400 block mb-0.5">موجودی</span>
                    <span class="px-2 py-0.5 rounded-lg text-[10px] font-bold <?php echo e($product->stock <= 5 ? 'bg-rose-100 text-rose-700' : 'bg-slate-100 text-slate-800'); ?>">
                        <?php echo e($product->stock); ?> عدد
                    </span>
                </div>
            </div>

            <!-- Actions Bar -->
            <div class="pt-2 flex items-center gap-2">
                <a href="<?php echo e(route('admin.products.edit', $product->id)); ?>" 
                   class="flex-1 py-2 bg-slate-100 active:bg-slate-200 text-slate-800 font-bold text-xs rounded-xl transition text-center flex items-center justify-center gap-1">
                    <i class="fa-solid fa-pen-to-square text-[11px]"></i>
                    <span>ویرایش کالا</span>
                </a>
                <form action="<?php echo e(route('admin.products.destroy', $product->id)); ?>" method="POST" class="inline" onsubmit="return confirm('آیا از حذف این کالا اطمینان دارید؟')">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="px-3 py-2 bg-rose-50 active:bg-rose-100 text-rose-600 font-bold text-xs rounded-xl transition flex items-center justify-center">
                        <i class="fa-solid fa-trash text-[11px]"></i>
                    </button>
                </form>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="bg-white rounded-2xl p-8 text-center border border-slate-200/80 text-slate-400 text-xs font-bold">
            محصولی یافت نشد.
        </div>
    <?php endif; ?>
</div>
<?php /**PATH /var/www/html/resources/views/admin/products/products-mobile-list.blade.php ENDPATH**/ ?>