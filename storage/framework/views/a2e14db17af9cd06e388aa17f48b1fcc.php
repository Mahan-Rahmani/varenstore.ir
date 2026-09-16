<div class="mt-12 bg-white rounded-3xl border border-zinc-200 p-6 sm:p-8 shadow-sm" x-data="{ activeTab: 'description' }">
    <!-- Tab Headers -->
    <div class="flex items-center gap-6 border-b border-zinc-200 text-xs font-black overflow-x-auto">
        <button @click="activeTab = 'description'"
                class="pb-4 border-b-2 transition-all duration-300 flex items-center gap-2 whitespace-nowrap"
                :class="activeTab === 'description' ? 'border-[#ef394e] text-[#ef394e]' : 'border-transparent text-zinc-500 hover:text-zinc-900'">
            <i class="fa-solid fa-align-right text-xs"></i>
            <span>معرفی و نقد کالا</span>
        </button>

        <button @click="activeTab = 'specs'"
                class="pb-4 border-b-2 transition-all duration-300 flex items-center gap-2 whitespace-nowrap"
                :class="activeTab === 'specs' ? 'border-[#ef394e] text-[#ef394e]' : 'border-transparent text-zinc-500 hover:text-zinc-900'">
            <i class="fa-solid fa-list-check text-xs"></i>
            <span>مشخصات فنی و دوخت</span>
            <?php if($product->attributes->count() > 0): ?>
                <span class="px-1.5 py-0.2 bg-zinc-100 text-zinc-600 rounded-full text-[10px]"><?php echo e($product->attributes->count()); ?></span>
            <?php endif; ?>
        </button>

        <button @click="activeTab = 'reviews'"
                class="pb-4 border-b-2 transition-all duration-300 flex items-center gap-2 whitespace-nowrap"
                :class="activeTab === 'reviews' ? 'border-[#ef394e] text-[#ef394e]' : 'border-transparent text-zinc-500 hover:text-zinc-900'">
            <i class="fa-regular fa-comment-dots text-xs"></i>
            <span>دیدگاه خریداران</span>
            <span class="px-1.5 py-0.2 bg-zinc-100 text-zinc-600 rounded-full text-[10px]">۴</span>
        </button>
    </div>

    <!-- Tab 1: Description -->
    <div x-show="activeTab === 'description'" class="pt-6 text-xs text-zinc-600 leading-relaxed space-y-4">
        <div class="prose prose-sm max-w-none text-zinc-700 font-normal leading-loose">
            <?php if($product->description): ?>
                <?php echo nl2br(e($product->description)); ?>

            <?php else: ?>
                <p><?php echo e($product->short_description ?? 'توضیحات تکمیلی برای این محصول به زودی درج خواهد شد.'); ?></p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Tab 2: Specifications -->
    <div x-show="activeTab === 'specs'" class="pt-6">
        <?php if($product->attributes->count() > 0): ?>
            <div class="max-w-2xl divide-y divide-zinc-100 border border-zinc-100 rounded-2xl overflow-hidden">
                <?php $__currentLoopData = $product->attributes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="grid grid-cols-3 text-xs p-3.5 <?php echo e($loop->even ? 'bg-zinc-50/70' : 'bg-white'); ?>">
                        <span class="text-zinc-400 font-bold"><?php echo e($attr->attribute_name); ?></span>
                        <span class="col-span-2 text-zinc-800 font-black"><?php echo e($attr->attribute_value); ?></span>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <p class="text-xs text-zinc-400 py-4">مشخصات فنی ثبت نشده است.</p>
        <?php endif; ?>
    </div>

    <!-- Tab 3: Reviews -->
    <div x-show="activeTab === 'reviews'" class="pt-6 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
            <div class="bg-zinc-50 rounded-2xl p-5 text-center border border-zinc-100">
                <span class="text-3xl font-black text-zinc-900 block mb-1">۴.۸</span>
                <div class="flex items-center justify-center gap-1 text-amber-400 text-xs mb-2">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star-half-stroke"></i>
                </div>
                <span class="text-[11px] text-zinc-400 font-bold block">از مجموع ۴ دیدگاه ثبت شده</span>
                <span class="text-[11px] text-emerald-600 font-bold block mt-2">۹۲٪ از خریداران خرید این کالا را پیشنهاد کرده‌اند</span>
            </div>

            <div class="md:col-span-2 space-y-3">
                <div class="p-4 bg-zinc-50/60 rounded-2xl border border-zinc-100 text-xs">
                    <div class="flex items-center justify-between mb-2">
                        <span class="font-black text-zinc-800">علی رضایی</span>
                        <span class="text-[10px] text-zinc-400">۲ روز پیش</span>
                    </div>
                    <p class="text-zinc-600 leading-relaxed font-normal">کیفیت دوخت و متریال واقعاً عالیه. جنس پارچه فوق‌العاده نرمه و رنگش دقیقاً مطابق تصویر بود.</p>
                </div>
                <div class="p-4 bg-zinc-50/60 rounded-2xl border border-zinc-100 text-xs">
                    <div class="flex items-center justify-between mb-2">
                        <span class="font-black text-zinc-800">سارا محمدی</span>
                        <span class="text-[10px] text-zinc-400">هفته گذشته</span>
                    </div>
                    <p class="text-zinc-600 leading-relaxed font-normal">تنخور بسیار زیبایی داره، بسته‌بندی عالی و ارسال اکسپرس سر وقت رسید. پیشنهاد می‌کنم.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /var/www/html/resources/views/shop/partials/product_tabs.blade.php ENDPATH**/ ?>