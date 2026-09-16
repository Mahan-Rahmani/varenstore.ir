<?php if(isset($relatedProducts) && $relatedProducts->isNotEmpty()): ?>
    <div class="mt-14 pt-10 border-t border-zinc-200">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-2.5">
                <span class="w-2.5 h-6 bg-[#ef394e] rounded-full"></span>
                <h3 class="text-base sm:text-lg font-black text-zinc-900">محصولات مشابه و پیشنهادی</h3>
            </div>
            <a href="<?php echo e(route('home', ['category' => $product->category?->slug])); ?>" class="text-xs font-bold text-[#ef394e] hover:underline flex items-center gap-1">
                <span>مشاهده بیشتر</span>
                <i class="fa-solid fa-chevron-left text-[10px]"></i>
            </a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4 sm:gap-6">
            <?php $__currentLoopData = $relatedProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-white rounded-2xl border border-zinc-200 p-3 flex flex-col justify-between shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                    <div class="relative aspect-[3/4] bg-zinc-50 rounded-xl overflow-hidden mb-3">
                        <?php if($rel->featured_image): ?>
                            <img src="<?php echo e($rel->featured_image); ?>" alt="<?php echo e($rel->name); ?>" loading="lazy" class="w-full h-full object-cover object-center group-hover:scale-105 transition duration-500">
                        <?php else: ?>
                            <div class="w-full h-full flex items-center justify-center text-zinc-300 bg-zinc-100">
                                <i class="fa-regular fa-image text-3xl"></i>
                            </div>
                        <?php endif; ?>

                        <?php if($rel->has_discount): ?>
                            <span class="absolute top-2 right-2 bg-[#ef394e] text-white text-[11px] font-black px-2 py-0.5 rounded-full shadow">
                                ٪<?php echo e($rel->discount_percentage); ?>

                            </span>
                        <?php endif; ?>
                    </div>

                    <div class="flex-1 flex flex-col justify-between">
                        <div>
                            <span class="text-[10px] font-bold text-zinc-400 block mb-1 truncate"><?php echo e($rel->category?->name ?? 'وارِن | VAREN'); ?></span>
                            <h4 class="font-bold text-zinc-900 text-xs line-clamp-2 leading-relaxed group-hover:text-[#ef394e] transition-colors">
                                <a href="<?php echo e(route('product.show', $rel->slug)); ?>"><?php echo e($rel->name); ?></a>
                            </h4>
                        </div>

                        <div class="mt-3 pt-2.5 border-t border-zinc-100 flex items-center justify-between">
                            <div>
                                <?php if($rel->has_discount): ?>
                                    <span class="text-[10px] text-zinc-400 line-through block"><?php echo e(number_format($rel->price)); ?></span>
                                    <span class="text-xs font-black text-zinc-950"><?php echo e(number_format($rel->sale_price)); ?> <span class="text-[9px] font-medium text-zinc-500">تومان</span></span>
                                <?php else: ?>
                                    <span class="text-xs font-black text-zinc-950"><?php echo e(number_format($rel->price)); ?> <span class="text-[9px] font-medium text-zinc-500">تومان</span></span>
                                <?php endif; ?>
                            </div>
                            <a href="<?php echo e(route('product.show', $rel->slug)); ?>" class="w-7 h-7 rounded-lg bg-zinc-100 group-hover:bg-[#ef394e] text-zinc-700 group-hover:text-white flex items-center justify-center transition">
                                <i class="fa-solid fa-chevron-left text-[10px]"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH /var/www/html/resources/views/shop/partials/related_products.blade.php ENDPATH**/ ?>