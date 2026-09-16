

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
    <!-- Breadcrumb -->
    <nav class="flex items-center gap-2 text-xs text-zinc-400 font-bold mb-6 overflow-x-auto whitespace-nowrap">
        <a href="<?php echo e(route('home')); ?>" class="hover:text-black transition">وارِن</a>
        <i class="fa-solid fa-chevron-left text-[9px]"></i>
        <?php if($product->category): ?>
            <a href="<?php echo e(route('home', ['category' => $product->category->slug])); ?>" class="hover:text-black transition">
                <?php echo e($product->category->name); ?>

            </a>
            <i class="fa-solid fa-chevron-left text-[9px]"></i>
        <?php endif; ?>
        <span class="text-zinc-800 truncate"><?php echo e($product->name); ?></span>
    </nav>

    <?php
        $allImages = array_values(array_filter(array_merge(
            [$product->featured_image],
            is_array($product->gallery_images) ? $product->gallery_images : []
        )));
        if (empty($allImages)) {
            $allImages = [''];
        }
    ?>

    <!-- Main Showcase Card -->
    <div class="bg-white rounded-3xl border border-zinc-200 p-5 sm:p-6 lg:p-8 shadow-sm"
         x-data="{
             activeImage: '<?php echo e($allImages[0]); ?>',
             fullScreenImage: null,
             shareModalOpen: false,
             quantity: 1,
             maxStock: <?php echo e($product->stock); ?>,
             copied: false,
             isZoomed: false,
             originX: '50%',
             originY: '50%',
             handleMouseMove(e) {
                 const rect = e.currentTarget.getBoundingClientRect();
                 const x = ((e.clientX - rect.left) / rect.width) * 100;
                 const y = ((e.clientY - rect.top) / rect.height) * 100;
                 this.originX = `${x}%`;
                 this.originY = `${y}%`;
             },
             openShare() {
                 if (navigator.share) {
                     navigator.share({
                         title: '<?php echo e($product->name); ?>',
                         text: 'پوشاک و تیشرت‌های جذاب وارن:',
                         url: window.location.href
                     }).catch(() => {
                         this.shareModalOpen = true;
                     });
                 } else {
                     this.shareModalOpen = true;
                 }
             },
             copyLink() {
                 try {
                     if (navigator.clipboard && window.isSecureContext) {
                         navigator.clipboard.writeText(window.location.href);
                     } else {
                         const textArea = document.createElement('textarea');
                         textArea.value = window.location.href;
                         textArea.style.position = 'fixed';
                         textArea.style.left = '-99999px';
                         document.body.appendChild(textArea);
                         textArea.focus();
                         textArea.select();
                         document.execCommand('copy');
                         textArea.remove();
                     }
                     this.copied = true;
                     setTimeout(() => this.copied = false, 2500);
                 } catch (e) {}
             }
         }">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-start">
            
            <!-- FullScreen Modal -->
            <div x-show="fullScreenImage" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click.away="fullScreenImage = null"
                 class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/90 backdrop-blur-md"
                 style="display: none;">
                <button @click="fullScreenImage = null" class="absolute top-6 right-6 text-white hover:text-[#ef394e] transition">
                    <i class="fa-solid fa-xmark text-3xl"></i>
                </button>
                <img :src="fullScreenImage" alt="Zoom" class="max-w-full max-h-[90vh] object-contain rounded-xl">
            </div>

            <!-- Gallery (4 cols - Compact & Responsive) -->
            <div class="lg:col-span-4 flex flex-col gap-3.5 select-none max-w-md mx-auto w-full">
                <!-- Main Preview Image with Interactive Zoom & Adaptive Height -->
                <div class="relative bg-zinc-50/80 rounded-2xl overflow-hidden w-full h-auto min-h-[280px] max-h-[520px] flex items-center justify-center border border-zinc-100 group shadow-inner cursor-zoom-in"
                     @click="fullScreenImage = activeImage"
                     @mouseenter="isZoomed = true"
                     @mouseleave="isZoomed = false"
                     @mousemove="handleMouseMove($event)">
                    
                    <template x-if="activeImage">
                        <img :src="activeImage" alt="<?php echo e($product->name); ?>" 
                             :style="isZoomed ? `transform: scale(2); transform-origin: ${originX} ${originY};` : 'transform: scale(1); transform-origin: 50% 50%;'"
                             class="w-full h-auto max-h-[520px] object-contain rounded-2xl p-1 transition-transform ease-out will-change-transform duration-200 pointer-events-none">
                    </template>
                    <template x-if="!activeImage">
                        <span class="text-3xl font-black text-zinc-200">VAREN</span>
                    </template>
            <!-- Share Modal -->
            <div x-show="shareModalOpen" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 @click.away="shareModalOpen = false"
                 class="fixed inset-0 z-[120] flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm"
                 style="display: none;">
                <div class="bg-white rounded-3xl max-w-sm w-full p-6 shadow-2xl relative border border-zinc-200 text-center select-none">
                    <div class="flex items-center justify-between pb-3 mb-4 border-b border-zinc-100">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-share-nodes text-[#ef394e]"></i>
                            <h3 class="font-black text-sm text-zinc-900">اشتراک‌گذاری این محصول</h3>
                        </div>
                        <button type="button" @click="shareModalOpen = false" class="w-8 h-8 rounded-full bg-zinc-100 hover:bg-zinc-200 flex items-center justify-center text-zinc-600 transition">
                            <i class="fa-solid fa-xmark text-sm"></i>
                        </button>
                    </div>

                    <p class="text-xs text-zinc-500 font-bold mb-5">این طرح جذاب را با دوستان خود به اشتراک بگذارید:</p>

                    <!-- Share Action Grid -->
                    <div class="grid grid-cols-3 gap-3 mb-6">
                        <!-- Telegram -->
                        <a :href="'https://t.me/share/url?url=' + encodeURIComponent(window.location.href) + '&text=' + encodeURIComponent('<?php echo e($product->name); ?> | پوشاک وارِن')" 
                           target="_blank" rel="noopener"
                           class="flex flex-col items-center gap-2 p-3 rounded-2xl bg-sky-50 hover:bg-sky-100 text-sky-600 border border-sky-200 transition group">
                            <div class="w-10 h-10 rounded-full bg-sky-500 text-white flex items-center justify-center shadow-sm group-hover:scale-110 transition">
                                <i class="fa-brands fa-telegram text-lg"></i>
                            </div>
                            <span class="text-[11px] font-black">تلگرام</span>
                        </a>

                        <!-- WhatsApp -->
                        <a :href="'https://api.whatsapp.com/send?text=' + encodeURIComponent('<?php echo e($product->name); ?> | پوشاک وارِن: ' + window.location.href)" 
                           target="_blank" rel="noopener"
                           class="flex flex-col items-center gap-2 p-3 rounded-2xl bg-emerald-50 hover:bg-emerald-100 text-emerald-600 border border-emerald-200 transition group">
                            <div class="w-10 h-10 rounded-full bg-emerald-500 text-white flex items-center justify-center shadow-sm group-hover:scale-110 transition">
                                <i class="fa-brands fa-whatsapp text-lg"></i>
                            </div>
                            <span class="text-[11px] font-black">واتساپ</span>
                        </a>

                        <!-- SMS -->
                        <a :href="'sms:?body=' + encodeURIComponent('<?php echo e($product->name); ?> در فروشگاه وارن: ' + window.location.href)" 
                           class="flex flex-col items-center gap-2 p-3 rounded-2xl bg-purple-50 hover:bg-purple-100 text-purple-600 border border-purple-200 transition group">
                            <div class="w-10 h-10 rounded-full bg-purple-500 text-white flex items-center justify-center shadow-sm group-hover:scale-110 transition">
                                <i class="fa-solid fa-comment-sms text-lg"></i>
                            </div>
                            <span class="text-[11px] font-black">پیامک</span>
                        </a>
                    </div>

                    <!-- Direct Copy URL Input -->
                    <div class="flex items-center gap-2 p-1.5 bg-zinc-50 rounded-2xl border border-zinc-200">
                        <input type="text" readonly :value="window.location.href" class="flex-1 bg-transparent px-3 text-[11px] font-mono dir-ltr text-zinc-600 focus:outline-none truncate">
                        <button type="button" @click="copyLink()" class="px-4 py-2 bg-black hover:bg-[#ef394e] text-white font-black text-xs rounded-xl shadow transition shrink-0 flex items-center gap-1.5">
                            <i class="fa-solid" :class="copied ? 'fa-check text-emerald-400' : 'fa-copy'"></i>
                            <span x-text="copied ? 'کپی شد!' : 'کپی لینک'"></span>
                        </button>
                    </div>
                </div>
            </div>

                    <!-- Zoom Hint Badge -->
                    <div class="absolute bottom-3 right-3 px-2 py-1 bg-black/40 backdrop-blur-sm text-white rounded-lg text-[9px] font-bold flex items-center gap-1 pointer-events-none opacity-80 group-hover:opacity-0 transition-opacity">
                        <i class="fa-solid fa-magnifying-glass-plus"></i>
                        <span>هاور برای بزرگ‌نمایی</span>
                    </div>

                    <!-- Discount Tag -->
                    <?php if($product->has_discount): ?>
                        <span class="absolute top-3 right-3 bg-[#ef394e] text-white text-[11px] font-black px-2.5 py-0.5 rounded-full shadow-md pointer-events-none">
                            ٪<?php echo e($product->discount_percentage); ?> تخفیف
                        </span>
                    <?php endif; ?>

                    <!-- Action Buttons Floating -->
                    <div class="absolute top-3 left-3 flex flex-col gap-2 z-10">
                        <button @click="openShare()" 
                                class="w-8 h-8 rounded-xl bg-white/90 hover:bg-white text-zinc-700 hover:text-[#ef394e] shadow-sm flex items-center justify-center transition backdrop-blur-sm"
                                title="اشتراک‌گذاری در شبکه‌های اجتماعی">
                            <i class="fa-solid fa-share-nodes text-xs"></i>
                        </button>
                    </div>
                </div>

                <!-- Thumbnails Track -->
                <?php if(count($allImages) > 1): ?>
                    <div class="flex items-center gap-2 overflow-x-auto py-0.5 justify-center">
                        <?php $__currentLoopData = $allImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <button type="button" 
                                    @click="activeImage = '<?php echo e($img); ?>'"
                                    :class="activeImage === '<?php echo e($img); ?>' ? 'border-[#ef394e] ring-2 ring-[#ef394e]/20' : 'border-zinc-200 hover:border-zinc-400'"
                                    class="w-14 h-14 rounded-xl overflow-hidden border bg-zinc-50 shrink-0 transition-all">
                                <img src="<?php echo e($img); ?>" alt="<?php echo e($product->name); ?>" class="w-full h-full object-cover">
                            </button>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Product Info & Buy Box (8 cols) -->
            <?php echo $__env->make('shop.partials.product_buy_box', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
    </div>

    <!-- Product Tabs -->
    <?php echo $__env->make('shop.partials.product_tabs', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- Related Products -->
    <?php echo $__env->make('shop.partials.related_products', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/shop/show.blade.php ENDPATH**/ ?>