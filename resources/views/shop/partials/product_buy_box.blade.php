@php
    $dbSizes = $product->attributes->where('attribute_name', 'سایز')->first()?->attribute_value;
    $sizesList = $dbSizes ? array_map('trim', explode(',', $dbSizes)) : ['S', 'M', 'L', 'XL', '2XL', 'Oversize'];

    $dbColors = $product->attributes->where('attribute_name', 'رنگ')->first()?->attribute_value;
    $rawColorsList = $dbColors ? array_map('trim', explode(',', $dbColors)) : ['مشکی', 'سفید', 'زغالی', 'سرمه‌ای'];

    $allPresetColors = [
        'مشکی' => ['name' => 'مشکی', 'code' => '#18181b', 'bg' => 'bg-zinc-900'],
        'سفید' => ['name' => 'سفید', 'code' => '#ffffff', 'bg' => 'bg-white border-zinc-300'],
        'زغالی' => ['name' => 'زغالی', 'code' => '#3f3f46', 'bg' => 'bg-zinc-700'],
        'سرمه‌ای' => ['name' => 'سرمه‌ای', 'code' => '#1e3a8a', 'bg' => 'bg-blue-900'],
        'طوسی' => ['name' => 'طوسی', 'code' => '#9ca3af', 'bg' => 'bg-gray-400'],
        'کرم' => ['name' => 'کرم', 'code' => '#fef3c7', 'bg' => 'bg-amber-100 border-amber-300'],
        'قرمز' => ['name' => 'قرمز', 'code' => '#dc2626', 'bg' => 'bg-red-600'],
        'زیتونی' => ['name' => 'زیتونی', 'code' => '#3f6212', 'bg' => 'bg-lime-800'],
    ];

    $colorsList = [];
    foreach ($rawColorsList as $cName) {
        if (isset($allPresetColors[$cName])) {
            $colorsList[] = $allPresetColors[$cName];
        } else {
            $colorsList[] = ['name' => $cName, 'code' => '#6b7280', 'bg' => 'bg-slate-600'];
        }
    }

    $sizeGuideUrl = $product->attributes->where('attribute_name', 'راهنمای سایز')->first()?->attribute_value;
@endphp

<!-- Product Info & Premium Buy Box (8 cols) -->
<div class="lg:col-span-8 flex flex-col justify-between space-y-5"
     x-data="{
         selectedSize: '{{ $sizesList[0] ?? 'L' }}',
         selectedColor: '{{ $colorsList[0]['name'] ?? 'مشکی' }}',
         sizes: {{ json_encode($sizesList) }},
         colors: {{ json_encode($colorsList) }},
         showSizeGuide: false,
         buyBoxCopied: false,
         copyProductLink() {
             navigator.clipboard.writeText(window.location.href);
             this.buyBoxCopied = true;
             setTimeout(() => this.buyBoxCopied = false, 2500);
         }
     }">
    <div>
        <!-- Top Meta: Brand Tag, Rating & SKU -->
        <div class="flex flex-wrap items-center justify-between gap-3 pb-3 border-b border-zinc-100">
            <div class="flex items-center gap-2">
                <span class="px-3 py-1 bg-black text-white text-[10px] font-black tracking-wider uppercase rounded-full shadow-sm">
                    {{ $product->category?->name ?? 'برند وارِن | VAREN' }}
                </span>
                <span class="px-2.5 py-0.5 bg-emerald-50 text-emerald-700 text-[10px] font-bold rounded-full border border-emerald-200/60 flex items-center gap-1">
                    <i class="fa-solid fa-circle-check text-[9px]"></i>
                    اصالت ۱۰۰٪ تضمینی
                </span>
            </div>

            <div class="flex items-center gap-3 text-xs">
                <button type="button" 
                        @click="openShare()" 
                        class="px-2.5 py-1 bg-zinc-100 hover:bg-zinc-200 text-zinc-700 hover:text-black rounded-xl font-bold flex items-center gap-1.5 transition text-[11px]"
                        title="اشتراک‌گذاری در شبکه‌های اجتماعی">
                    <i class="fa-solid fa-share-nodes text-[11px] text-[#ef394e]"></i>
                    <span>اشتراک‌گذاری</span>
                </button>

                <div class="flex items-center gap-1 bg-amber-50 px-2.5 py-1 rounded-xl border border-amber-200/60">
                    <span class="text-amber-500 text-xs"><i class="fa-solid fa-star"></i></span>
                    <span class="font-black text-zinc-900 text-xs">۴.۹</span>
                    <span class="text-zinc-400 text-[10px] font-medium">(۲۸ نظر)</span>
                </div>
                <span class="text-zinc-400 font-mono text-[11px]">شناسه: {{ $product->sku }}</span>
            </div>
        </div>

        <!-- Product Title -->
        <h1 class="text-xl sm:text-2xl lg:text-3xl font-black text-zinc-950 mt-4 mb-3 leading-snug tracking-tight">
            {{ $product->name }}
        </h1>

        <!-- Short Description -->
        @if($product->short_description)
            <p class="text-xs sm:text-sm text-zinc-600 leading-relaxed font-medium mb-5 bg-zinc-50/60 p-3.5 rounded-2xl border border-zinc-100/80">
                {{ $product->short_description }}
            </p>
        @endif

        <!-- Attributes Highlight -->
        @if($product->attributes->count() > 0)
            <div class="mb-5 space-y-2">
                <h3 class="text-xs font-black text-zinc-800">مشخصات اصلی دوخت و چاپ:</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($product->attributes->take(4) as $attr)
                        <div class="px-3.5 py-1.5 bg-zinc-100/90 border border-zinc-200/80 rounded-xl text-xs flex items-center gap-1.5 font-bold">
                            <span class="text-zinc-400">{{ $attr->attribute_name }}:</span>
                            <span class="text-zinc-900 font-extrabold">{{ $attr->attribute_value }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Interactive Size Selection -->
        <div class="mb-5 space-y-2">
            <div class="flex items-center justify-between">
                <span class="text-xs font-black text-zinc-800 flex items-center gap-1.5">
                    <i class="fa-solid fa-ruler-horizontal text-zinc-400"></i>
                    <span>انتخاب سایز تیشرت:</span>
                    <strong class="text-[#ef394e] font-extrabold" x-text="selectedSize"></strong>
                </span>
                <button type="button" @click="showSizeGuide = true" class="text-[11px] font-bold text-zinc-500 hover:text-black underline transition flex items-center gap-1">
                    <i class="fa-solid fa-file-pen text-[10px]"></i>
                    <span>راهنمای سایزبندی</span>
                </button>
            </div>
            <div class="flex flex-wrap gap-2">
                <template x-for="size in sizes" :key="size">
                    <button type="button" 
                            @click="selectedSize = size"
                            :class="selectedSize === size ? 'bg-black text-white border-black shadow-md scale-105' : 'bg-white text-zinc-700 border-zinc-200 hover:border-zinc-400'"
                            class="px-4 py-2 border rounded-xl font-mono text-xs font-black transition-all duration-200">
                        <span x-text="size"></span>
                    </button>
                </template>
            </div>
        </div>

        <!-- Interactive Color Selection -->
        <div class="mb-5 space-y-2">
            <span class="text-xs font-black text-zinc-800 block">
                انتخاب رنگ پارچه: <strong class="text-zinc-900" x-text="selectedColor"></strong>
            </span>
            <div class="flex items-center gap-3">
                <template x-for="color in colors" :key="color.name">
                    <button type="button" 
                            @click="selectedColor = color.name"
                            :title="color.name"
                            :class="[color.bg, selectedColor === color.name ? 'ring-2 ring-offset-2 ring-[#ef394e] scale-110' : 'opacity-80 hover:opacity-100']"
                            class="w-7 h-7 rounded-full border shadow-sm transition-all duration-200 relative flex items-center justify-center">
                        <i x-show="selectedColor === color.name" class="fa-solid fa-check text-[10px]" :class="color.name === 'سفید' ? 'text-black' : 'text-white'"></i>
                    </button>
                </template>
            </div>
        </div>

        <!-- Premium Highlighted Price Card -->
        <div class="bg-gradient-to-r from-zinc-900 via-zinc-900 to-zinc-950 text-white rounded-2xl p-4 sm:p-5 mb-5 shadow-lg relative overflow-hidden">
            <div class="absolute -left-10 -bottom-10 w-32 h-32 bg-[#ef394e]/20 rounded-full blur-2xl pointer-events-none"></div>
            
            <div class="flex items-center justify-between relative z-10">
                <div class="space-y-1">
                    <span class="text-[11px] text-zinc-400 font-bold block">قیمت نهایی با احتساب مالیات:</span>
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-[#ef394e] text-white text-[10px] font-black">
                            تضمین قیمت
                        </span>
                        <span class="text-[11px] text-zinc-400">تحویل اکسپرس از کارگاه وارن</span>
                    </div>
                </div>

                <div class="text-left">
                    @if($product->has_discount)
                        <div class="flex items-center gap-2 justify-end mb-1">
                            <span class="text-xs text-zinc-400 line-through font-mono">{{ number_format($product->price) }} تومان</span>
                            <span class="bg-[#ef394e] text-white text-[10px] font-black px-2 py-0.5 rounded-full animate-pulse">
                                {{ $product->discount_percentage }}٪ تخفیف
                            </span>
                        </div>
                        <div class="flex items-baseline gap-1.5 justify-end">
                            <span class="text-2xl sm:text-3xl font-black text-amber-400 tracking-tight">{{ number_format($product->sale_price) }}</span>
                            <span class="text-xs font-bold text-zinc-300">تومان</span>
                        </div>
                    @else
                        <div class="flex items-baseline gap-1.5 justify-end">
                            <span class="text-2xl sm:text-3xl font-black text-white tracking-tight">{{ number_format($product->price) }}</span>
                            <span class="text-xs font-bold text-zinc-300">تومان</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Actions & Add to Cart Section -->
    <div class="pt-2 border-t border-zinc-100">
        @if($product->isInStock())
            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="size" :value="selectedSize">
                <input type="hidden" name="color" :value="selectedColor">

                <div class="flex flex-wrap sm:flex-nowrap items-center gap-3">
                    <!-- Quantity Counter -->
                    <div class="flex items-center border border-zinc-200 rounded-2xl bg-zinc-50 p-1.5 shadow-inner shrink-0">
                        <button type="button" 
                                @click="if(quantity > 1) quantity--" 
                                class="w-9 h-9 rounded-xl bg-white shadow flex items-center justify-center text-zinc-800 hover:text-black hover:bg-zinc-100 font-black text-sm active:scale-95 transition">
                            <i class="fa-solid fa-minus text-[10px]"></i>
                        </button>
                        <input type="number" name="quantity" x-model="quantity" min="1" :max="maxStock" 
                               class="w-12 text-center bg-transparent border-0 font-black text-sm text-zinc-950 focus:outline-none">
                        <button type="button" 
                                @click="if(quantity < maxStock) quantity++" 
                                class="w-9 h-9 rounded-xl bg-white shadow flex items-center justify-center text-zinc-800 hover:text-black hover:bg-zinc-100 font-black text-sm active:scale-95 transition">
                            <i class="fa-solid fa-plus text-[10px]"></i>
                        </button>
                    </div>

                    <!-- Add to Cart CTA -->
                    <button type="submit" 
                            class="flex-1 bg-[#ef394e] hover:bg-rose-600 text-white font-black py-3.5 px-6 rounded-2xl transition-all duration-300 flex items-center justify-center gap-3 text-xs sm:text-sm shadow-lg shadow-red-500/25 active:scale-98">
                        <i class="fa-solid fa-bag-shopping text-base"></i>
                        <span>افزودن به سبد خرید</span>
                    </button>
                </div>

                <!-- Stock Alert & Custom Order Note -->
                <div class="flex items-center justify-between text-[11px] font-bold pt-1">
                    @if($product->stock <= 5)
                        <span class="text-amber-600 flex items-center gap-1.5">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                            موجودی انبار محدود است (تنها {{ $product->stock }} عدد باقیست)
                        </span>
                    @else
                        <span class="text-emerald-600 flex items-center gap-1.5">
                            <i class="fa-solid fa-circle-check"></i>
                            موجود در انبار وارن (آماده چاپ فوری و ارسال)
                        </span>
                    @endif

                    <a href="{{ route('home', ['category' => 'custom']) }}" class="text-zinc-500 hover:text-black underline text-[11px]">
                        نیاز به چاپ طرح اختصاصی دارید؟
                    </a>
                </div>
            </form>
        @else
            <div class="p-4 bg-rose-50 border border-rose-200 text-rose-700 font-bold text-xs rounded-2xl text-center shadow-sm">
                متأسفانه این سایز/محصول در حال حاضر ناموجود است.
            </div>
        @endif

        <!-- Premium Brand Trust Badges -->
        <div class="grid grid-cols-4 gap-2 pt-5 mt-5 border-t border-zinc-100 text-center">
            <div class="p-2 bg-zinc-50/70 rounded-2xl border border-zinc-100">
                <i class="fa-solid fa-shirt text-[#ef394e] text-base mb-1 block"></i>
                <span class="text-[10px] font-black text-zinc-800 block">۱۰۰٪ پنبه سوپر</span>
                <span class="text-[8px] text-zinc-400 block mt-0.5">بدون آبرفت</span>
            </div>
            <div class="p-2 bg-zinc-50/70 rounded-2xl border border-zinc-100">
                <i class="fa-solid fa-palette text-[#ef394e] text-base mb-1 block"></i>
                <span class="text-[10px] font-black text-zinc-800 block">چاپ DTF ماندگار</span>
                <span class="text-[8px] text-zinc-400 block mt-0.5">ثبات رنگ تضمینی</span>
            </div>
            <div class="p-2 bg-zinc-50/70 rounded-2xl border border-zinc-100">
                <i class="fa-solid fa-truck-fast text-[#ef394e] text-base mb-1 block"></i>
                <span class="text-[10px] font-black text-zinc-800 block">ارسال سراسری</span>
                <span class="text-[8px] text-zinc-400 block mt-0.5">پست اکسپرس و تیپاکس</span>
            </div>
            <div class="p-2 bg-zinc-50/70 rounded-2xl border border-zinc-100">
                <i class="fa-solid fa-shield-cat text-[#ef394e] text-base mb-1 block"></i>
                <span class="text-[10px] font-black text-zinc-800 block">ضمانت کیفیت</span>
                <span class="text-[8px] text-zinc-400 block mt-0.5">تعویض در صورت ایراد</span>
            </div>
        </div>
    </div>

    <!-- Size Guide Modal -->
    <div x-show="showSizeGuide" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         @click.away="showSizeGuide = false"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
         style="display: none;">
        <div class="bg-white rounded-3xl max-w-xl w-full p-6 shadow-2xl relative border border-zinc-200">
            <div class="flex items-center justify-between pb-3 mb-4 border-b border-zinc-100">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-ruler-horizontal text-[#ef394e]"></i>
                    <h3 class="font-black text-sm text-zinc-900">جدول راهنمای سایزبندی پوشاک وارِن</h3>
                </div>
                <button type="button" @click="showSizeGuide = false" class="w-8 h-8 rounded-full bg-zinc-100 hover:bg-zinc-200 flex items-center justify-center text-zinc-600 transition">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>
            
            <div class="overflow-hidden rounded-2xl bg-zinc-50 border border-zinc-100 flex items-center justify-center min-h-[250px]">
                @if($sizeGuideUrl)
                    <img src="{{ $sizeGuideUrl }}" alt="راهنمای سایزبندی" class="w-full h-auto max-h-[70vh] object-contain rounded-2xl">
                @else
                    <div class="p-8 text-center space-y-2">
                        <i class="fa-solid fa-shirt text-4xl text-zinc-300"></i>
                        <p class="text-xs font-bold text-zinc-500">تصویر راهنمای سایز اختصاصی برای این محصول ثبت نشده است.</p>
                        <p class="text-[11px] text-zinc-400">سایزهای استاندارد به سانتی‌متر: S (48x68), M (51x70), L (54x72), XL (57x74), 2XL (60x76)</p>
                    </div>
                @endif
            </div>

            <div class="mt-4 text-center">
                <button type="button" @click="showSizeGuide = false" class="px-6 py-2 bg-black text-white text-xs font-black rounded-xl hover:bg-zinc-800 transition">
                    متوجه شدم
                </button>
            </div>
        </div>
    </div>
</div>
