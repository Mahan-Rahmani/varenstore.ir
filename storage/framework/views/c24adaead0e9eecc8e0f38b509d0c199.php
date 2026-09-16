

<?php $__env->startSection('content'); ?>
<?php
    $formattedSlides = isset($sliders) && $sliders->isNotEmpty() 
        ? $sliders->map(fn($s) => [
            'title' => $s->title ?? '',
            'subtitle' => $s->subtitle ?? '',
            'tag' => $s->tag ?? '',
            'button_text' => $s->button_text ?: 'مشاهده و خرید',
            'image' => $s->image_url,
            'link' => $s->link ?: url('/'),
        ])->values()->toArray()
        : [
            [
                'title' => 'تیشرت‌های اختصاصی وارِن | VAREN',
                'subtitle' => '۱۰۰٪ پنبه سوپر با ماندگارترین کیفیت چاپ و طراحی‌های ترند هنری',
                'tag' => 'کالکشن جدید وارن',
                'button_text' => 'مشاهده محصولات',
                'image' => 'https://images.unsplash.com/photo-1521572267360-ee0c2909d518?w=1600&q=80',
                'link' => route('home', ['category' => 'men'])
            ],
            [
                'title' => 'چاپ طرح دلخواه شما روی تیشرت',
                'subtitle' => 'هر طرح، ایده یا عکسی که دوست دارید با بالاترین رزولوشن و دوام شستشو',
                'tag' => 'سفارش اختصاصی DTF',
                'button_text' => 'سفارش اختصاصی',
                'image' => 'https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?w=1600&q=80',
                'link' => route('home', ['category' => 'custom'])
            ],
            [
                'title' => 'هودی و دورس‌های پاییزی و زمستانه',
                'subtitle' => 'تنخور فوق‌العاده، دوخت تمیز و مناسب برای استایل روزمره و استریت‌ویر',
                'tag' => 'FOR YOU | WITH ART',
                'button_text' => 'مشاهده کالکشن',
                'image' => 'https://images.unsplash.com/photo-1556905055-8f358a7a47b2?w=1600&q=80',
                'link' => route('home', ['category' => 'hoodie'])
            ]
        ];
?>
<div class="max-w-[1700px] w-full mx-auto px-4 sm:px-6 lg:px-10 py-6">
    <!-- Big Fashion Hero Slider (Alpine.js) -->
    <div x-data="{
            activeSlide: 0,
            slides: <?php echo e(\Illuminate\Support\Js::from($formattedSlides)); ?>,
            autoplayTimer: null,
            startAutoplay() {
                if (this.slides.length <= 1) return;
                this.autoplayTimer = setInterval(() => {
                    this.activeSlide = (this.activeSlide + 1) % this.slides.length;
                }, 5000);
            },
            stopAutoplay() {
                clearInterval(this.autoplayTimer);
            }
        }"
        x-init="startAutoplay()"
        @mouseenter="stopAutoplay()"
        @mouseleave="startAutoplay()"
        class="relative w-full h-72 sm:h-96 lg:h-[420px] rounded-3xl overflow-hidden shadow-lg mb-8 group select-none">

        <!-- Slides -->
        <template x-for="(slide, index) in slides" :key="index">
            <div x-show="activeSlide === index"
                 x-transition:enter="transition ease-out duration-700"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-105"
                 class="absolute inset-0 w-full h-full bg-cover bg-center"
                 :style="`background-image: url('${slide.image}');`">
                 
                <!-- Gradient Overlay -->
                <div class="absolute inset-0 bg-gradient-to-l from-black/80 via-black/40 to-transparent flex items-center">
                    <div class="max-w-xl pr-8 sm:pr-14 text-white">
                        <template x-if="slide.tag">
                            <span class="inline-block px-3 py-1 bg-[#ef394e] text-white text-xs font-black rounded-full mb-3 shadow" x-text="slide.tag"></span>
                        </template>
                        <template x-if="slide.title">
                            <h2 class="text-2xl sm:text-4xl font-black mb-3 leading-tight" x-text="slide.title"></h2>
                        </template>
                        <template x-if="slide.subtitle">
                            <p class="text-xs sm:text-sm text-zinc-200 mb-6 font-medium leading-relaxed" x-text="slide.subtitle"></p>
                        </template>
                        <a :href="slide.link" class="inline-flex items-center gap-2 px-6 py-3 bg-white text-black hover:bg-[#ef394e] hover:text-white font-black text-xs rounded-xl shadow-md transition duration-300">
                            <span x-text="slide.button_text || 'مشاهده و خرید'"></span>
                            <i class="fa-solid fa-arrow-left"></i>
                        </a>
                    </div>
                </div>
            </div>
        </template>

        <!-- Navigation Arrows -->
        <button x-show="slides.length > 1" @click="activeSlide = (activeSlide - 1 + slides.length) % slides.length" 
                class="absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-white/20 hover:bg-white text-white hover:text-black backdrop-blur-md flex items-center justify-center transition opacity-0 group-hover:opacity-100 shadow">
            <i class="fa-solid fa-chevron-right text-sm"></i>
        </button>
        <button x-show="slides.length > 1" @click="activeSlide = (activeSlide + 1) % slides.length" 
                class="absolute left-4 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-white/20 hover:bg-white text-white hover:text-black backdrop-blur-md flex items-center justify-center transition opacity-0 group-hover:opacity-100 shadow">
            <i class="fa-solid fa-chevron-left text-sm"></i>
        </button>

        <!-- Dots Indicator -->
        <div x-show="slides.length > 1" class="absolute bottom-4 left-1/2 -translate-x-1/2 flex items-center gap-2">
            <template x-for="(slide, index) in slides" :key="index">
                <button @click="activeSlide = index" 
                        class="h-2 rounded-full transition-all duration-300"
                        :class="activeSlide === index ? 'w-8 bg-[#ef394e]' : 'w-2 bg-white/50 hover:bg-white'">
                </button>
            </template>
        </div>
    </div>

    <!-- Thematic Circular Categories -->
    <div class="mb-10">
        <h3 class="text-sm font-black text-zinc-950 mb-6 flex items-center gap-2">
            <span class="w-1.5 h-5 bg-[#ef394e] rounded-full"></span>
            موضوعات مورد علاقه شما
        </h3>
        <div class="flex gap-4 sm:gap-8 overflow-x-auto pb-4 scrollbar-hide">
            <?php $__currentLoopData = \App\Models\Category::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('home', ['category' => $cat->slug])); ?>" class="flex flex-col items-center gap-3 flex-shrink-0 group w-28 sm:w-36">
                    <div class="w-28 h-28 sm:w-36 sm:h-36 rounded-full border-2 border-[#ef394e] p-1 shadow-lg relative">
                        <div class="absolute inset-0.5 rounded-full border border-zinc-100 overflow-hidden">
                            <?php if($cat->image): ?>
                                <img src="<?php echo e($cat->image); ?>" alt="<?php echo e($cat->name); ?>" class="w-full h-full object-cover transition-transform duration-500 ease-out group-hover:scale-125">
                            <?php else: ?>
                                <div class="w-full h-full bg-zinc-900 flex items-center justify-center text-white font-black text-3xl transition-transform duration-500 ease-out group-hover:scale-110">
                                    <?php echo e(mb_substr($cat->name, 0, 1)); ?>

                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <span class="text-[13px] font-black text-zinc-800 group-hover:text-[#ef394e] transition text-center"><?php echo e($cat->name); ?></span>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    <!-- Digistyle-Style "Today's Super Deals" Horizontal Slider -->
    <?php echo $__env->make('shop.partials.deals_slider', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div id="catalog" class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <aside>
            <div class="bg-white p-4 rounded-2xl border border-zinc-200 shadow-sm">
                <h3 class="text-xs font-black text-black mb-3 pb-2 border-b">دسته‌بندی‌ها</h3>
                <ul class="space-y-1 text-xs font-bold">
                    <li><a href="<?php echo e(route('home')); ?>" class="block px-3 py-1.5 rounded-xl <?php echo e(!request('category') ? 'bg-black text-white' : 'text-zinc-700'); ?>">همه محصولات</a></li>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><a href="<?php echo e(route('home', ['category' => $category->slug])); ?>" class="block px-3 py-1.5 rounded-xl <?php echo e(request('category') === $category->slug ? 'bg-black text-white' : 'text-zinc-700'); ?>"><?php echo e($category->name); ?></a></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        </aside>

        <div class="lg:col-span-3">
            <div class="flex items-center justify-between mb-4 text-xs font-bold">
                <p class="text-zinc-500">نمایش <strong><?php echo e($products->total()); ?></strong> کالا</p>
                <form action="<?php echo e(route('home')); ?>" method="GET">
                    <select name="sort" onchange="this.form.submit()" class="bg-white border rounded-xl px-2 py-1 text-xs font-bold">
                        <option value="latest" <?php echo e(request('sort') == 'latest' ? 'selected' : ''); ?>>جدیدترین</option>
                        <option value="price_low" <?php echo e(request('sort') == 'price_low' ? 'selected' : ''); ?>>ارزان‌ترین</option>
                        <option value="price_high" <?php echo e(request('sort') == 'price_high' ? 'selected' : ''); ?>>گران‌ترین</option>
                    </select>
                </form>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4 sm:gap-5">
                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-white rounded-2xl border border-zinc-200 overflow-hidden shadow-sm flex flex-col group">
                        <div class="relative aspect-[3/4] bg-zinc-100 overflow-hidden">
                            <?php if($product->featured_image): ?>
                                <img src="<?php echo e($product->featured_image); ?>" alt="<?php echo e($product->name); ?>" class="w-full h-full object-cover group-hover:scale-105 transition">
                            <?php endif; ?>
                            <?php if($product->has_discount): ?>
                                <span class="absolute top-2 right-2 bg-[#ef394e] text-white text-[11px] font-black px-2 py-0.5 rounded-full">٪<?php echo e($product->discount_percentage); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="p-3 flex-1 flex flex-col justify-between">
                            <div>
                                <span class="text-[10px] font-bold text-zinc-400 block mb-1"><?php echo e($product->category?->name ?? 'وارِن | VAREN'); ?></span>
                                <h3 class="font-bold text-zinc-900 text-xs line-clamp-2"><a href="<?php echo e(route('product.show', $product->slug)); ?>"><?php echo e($product->name); ?></a></h3>
                            </div>
                            <div class="mt-3 pt-2 border-t flex items-center justify-between">
                                <div>
                                    <?php if($product->has_discount): ?>
                                        <span class="text-[10px] text-zinc-400 line-through block ml-1"><?php echo e(number_format($product->price)); ?></span>
                                        <span class="text-xs font-black text-black"><?php echo e(number_format($product->sale_price)); ?> <span class="text-[9px]">تومان</span></span>
                                    <?php else: ?>
                                        <span class="text-xs font-black text-black"><?php echo e(number_format($product->price)); ?> <span class="text-[9px]">تومان</span></span>
                                    <?php endif; ?>
                                </div>
                                <a href="<?php echo e(route('product.show', $product->slug)); ?>" class="px-2.5 py-1 bg-black text-white text-[10px] font-bold rounded-lg hover:bg-[#ef394e] transition">خرید</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="mt-6"><?php echo e($products->links()); ?></div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/shop/index.blade.php ENDPATH**/ ?>