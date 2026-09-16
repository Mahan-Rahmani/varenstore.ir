@extends('layouts.app')

@php
    $selectedCat = request('category') ? $categories->firstWhere('slug', request('category')) : null;
    $selectedCatName = $selectedCat ? $selectedCat->name : null;
@endphp

@if($selectedCatName)
    @section('title', 'خرید تیشرت و پوشاک ' . $selectedCatName . ' | فروشگاه وارِن')
    @section('meta_description', 'خرید آنلاین جدیدترین مدل‌های تیشرت، هودی و پوشاک ' . $selectedCatName . ' با پارچه ۱۰۰٪ پنبه و ماندگارترین چاپ در فروشگاه آنلاین وارِن (VAREN).')
    @section('meta_keywords', 'خرید تیشرت ' . $selectedCatName . ', تیشرت ' . $selectedCatName . ', قیمت تیشرت ' . $selectedCatName . ', پوشاک وارن')
@elseif(request('search'))
    @section('title', 'جستجوی ' . request('search') . ' | فروشگاه آنلاین وارِن')
    @section('meta_description', 'مشاهده و خرید آنلاین انواع تیشرت، دورس و هودی مرتبط با ' . request('search') . ' در فروشگاه اینترنتی وارِن.')
@else
    @section('title', 'خرید تیشرت، هودی و پوشاک سفارشی | فروشگاه اینترنتی وارِن (VAREN)')
    @section('meta_description', 'فروشگاه آنلاین وارِن (VAREN) مرجع تخصصی خرید تیشرت ۱۰۰٪ پنبه، دورس پاییزی، هودی، طرح‌های انیمه، گیمینگ و استریت‌ویر با چاپ ماندگار DTF.')
    @section('meta_keywords', 'خرید تیشرت, چاپ تیشرت, تیشرت انیمه, هودی لش, دورس مردانه, سفارش چاپ تیشرت سفارشی, تیشرت استریت ویر, وارن')
@endif

@push('schemas')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "جنس تیشرت‌های فروشگاه وارِن از چیست؟",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "تمامی تیشرت‌ها و پوشاک وارِن از پارچه ۱۰۰٪ پنبه سوپر با بافت باکیفیت و تنخور استاندارد تولید می‌شوند."
      }
    },
    {
      "@type": "Question",
      "name": "کیفیت و دوام چاپ طرح‌ها روی تیشرت چگونه است؟",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "چاپ طرح‌ها با پیشرفته‌ترین تکنولوژی چاپ DTF انجام می‌شود که در برابر شستشو کاملاً مقاوم، بدون پوسته شدن و با وضوح تصویر فوق‌العاده است."
      }
    },
    {
      "@type": "Question",
      "name": "شرایط ارسال سفارشات در وارِن چگونه است؟",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "سفارش‌ها با بسته‌بندی ویژه به سراسر کشور ارسال می‌شوند و خریدهای بالای ۵۰۰ هزار تومان شامل ارسال اکسپرس رایگان می‌باشند."
      }
    }
  ]
}
</script>
@endpush

@section('content')
@php
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
@endphp
<div class="max-w-[1700px] w-full mx-auto px-4 sm:px-6 lg:px-10 py-6">
    <!-- Big Fashion Hero Slider (Alpine.js) -->
    <div x-data="{
            activeSlide: 0,
            slides: {{ \Illuminate\Support\Js::from($formattedSlides) }},
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
            @foreach(\App\Models\Category::all() as $cat)
                <a href="{{ route('home', ['category' => $cat->slug]) }}" class="flex flex-col items-center gap-3 flex-shrink-0 group w-28 sm:w-36">
                    <div class="w-28 h-28 sm:w-36 sm:h-36 rounded-full border-2 border-[#ef394e] p-1 shadow-lg relative">
                        <div class="absolute inset-0.5 rounded-full border border-zinc-100 overflow-hidden">
                            @if($cat->image)
                                <img src="{{ $cat->image }}" alt="{{ $cat->name }}" class="w-full h-full object-cover transition-transform duration-500 ease-out group-hover:scale-125">
                            @else
                                <div class="w-full h-full bg-zinc-900 flex items-center justify-center text-white font-black text-3xl transition-transform duration-500 ease-out group-hover:scale-110">
                                    {{ mb_substr($cat->name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <span class="text-[13px] font-black text-zinc-800 group-hover:text-[#ef394e] transition text-center">{{ $cat->name }}</span>
                </a>
            @endforeach
        </div>
    </div>

    <!-- Digistyle-Style "Today's Super Deals" Horizontal Slider -->
    @include('shop.partials.deals_slider')

    <div id="catalog" class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <aside>
            <div class="bg-white p-4 rounded-2xl border border-zinc-200 shadow-sm">
                <h3 class="text-xs font-black text-black mb-3 pb-2 border-b">دسته‌بندی‌ها</h3>
                <ul class="space-y-1 text-xs font-bold">
                    <li><a href="{{ route('home') }}" class="block px-3 py-1.5 rounded-xl {{ !request('category') ? 'bg-black text-white' : 'text-zinc-700' }}">همه محصولات</a></li>
                    @foreach($categories as $category)
                        <li><a href="{{ route('home', ['category' => $category->slug]) }}" class="block px-3 py-1.5 rounded-xl {{ request('category') === $category->slug ? 'bg-black text-white' : 'text-zinc-700' }}">{{ $category->name }}</a></li>
                    @endforeach
                </ul>
            </div>
        </aside>

        <div class="lg:col-span-3">
            <div class="flex items-center justify-between mb-4 text-xs font-bold">
                <p class="text-zinc-500">نمایش <strong>{{ $products->total() }}</strong> کالا</p>
                <form action="{{ route('home') }}" method="GET">
                    <select name="sort" onchange="this.form.submit()" class="bg-white border rounded-xl px-2 py-1 text-xs font-bold">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>جدیدترین</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>ارزان‌ترین</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>گران‌ترین</option>
                    </select>
                </form>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4 sm:gap-5">
                @foreach($products as $product)
                    <div class="bg-white rounded-2xl border border-zinc-200 overflow-hidden shadow-sm flex flex-col group">
                        <div class="relative aspect-[3/4] bg-zinc-100 overflow-hidden">
                            @if($product->featured_image)
                                <img src="{{ $product->featured_image }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition">
                            @endif
                            @if($product->has_discount)
                                <span class="absolute top-2 right-2 bg-[#ef394e] text-white text-[11px] font-black px-2 py-0.5 rounded-full">٪{{ $product->discount_percentage }}</span>
                            @endif
                        </div>
                        <div class="p-3 flex-1 flex flex-col justify-between">
                            <div>
                                <span class="text-[10px] font-bold text-zinc-400 block mb-1">{{ $product->category?->name ?? 'وارِن | VAREN' }}</span>
                                <h3 class="font-bold text-zinc-900 text-xs line-clamp-2"><a href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a></h3>
                            </div>
                            <div class="mt-3 pt-2 border-t flex items-center justify-between">
                                <div>
                                    @if($product->has_discount)
                                        <span class="text-[10px] text-zinc-400 line-through block ml-1">{{ number_format($product->price) }}</span>
                                        <span class="text-xs font-black text-black">{{ number_format($product->sale_price) }} <span class="text-[9px]">تومان</span></span>
                                    @else
                                        <span class="text-xs font-black text-black">{{ number_format($product->price) }} <span class="text-[9px]">تومان</span></span>
                                    @endif
                                </div>
                                <a href="{{ route('product.show', $product->slug) }}" class="px-2.5 py-1 bg-black text-white text-[10px] font-bold rounded-lg hover:bg-[#ef394e] transition">خرید</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-6">{{ $products->links() }}</div>
        </div>
    </div>

    <!-- SEO Content & FAQ Section -->
    <section class="mt-16 bg-white rounded-3xl border border-zinc-200 p-6 sm:p-8 lg:p-10 shadow-sm">
        <article class="prose max-w-none text-zinc-700 text-xs sm:text-sm leading-relaxed space-y-4">
            <h1 class="text-base sm:text-lg font-black text-zinc-900 border-r-4 border-[#ef394e] pr-3">
                خرید آنلاین تیشرت و پوشاک سفارشی وارِن (VAREN)
            </h1>
            <p>
                فروشگاه اینترنتی <strong>وارِن (VAREN)</strong> مرجع تخصصی طراحی، چاپ و فروش انواع <strong>تیشرت‌های ۱۰۰٪ پنبه سوپر</strong>، <strong>هودی</strong>، <strong>دورس پاییزی و زمستانه</strong> با طرح‌های ترند، انیمه‌ای، سینمایی و استریت‌ویر است. ما در وارِن با استفاده از جدیدترین تکنولوژی <strong>چاپ مستقیم DTF</strong>، بالاترین رزولوشن چاپ و ماندگاری کامل رنگ در برابر شستشوهای مداوم را تضمین می‌کنیم.
            </p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 my-6 pt-4 border-t border-zinc-100">
                <div class="p-4 rounded-2xl bg-zinc-50 border border-zinc-100">
                    <div class="flex items-center gap-2 mb-2">
                        <i class="fa-solid fa-shirt text-[#ef394e]"></i>
                        <h3 class="font-bold text-zinc-900 text-xs sm:text-sm">پارچه ۱۰۰٪ پنبه سوپر</h3>
                    </div>
                    <p class="text-zinc-600 text-xs">تنخور بی‌نظیر، ضد حساسیت و بدون آبرفت پس از شستشو با بهترین الیاف نخ پنبه.</p>
                </div>
                <div class="p-4 rounded-2xl bg-zinc-50 border border-zinc-100">
                    <div class="flex items-center gap-2 mb-2">
                        <i class="fa-solid fa-print text-[#ef394e]"></i>
                        <h3 class="font-bold text-zinc-900 text-xs sm:text-sm">چاپ تخصصی DTF</h3>
                    </div>
                    <p class="text-zinc-600 text-xs">وضوح تصویری حیرت‌انگیز، عدم ترک‌خوردگی و پوسته پوسته شدن چاپ در شستشو.</p>
                </div>
                <div class="p-4 rounded-2xl bg-zinc-50 border border-zinc-100">
                    <div class="flex items-center gap-2 mb-2">
                        <i class="fa-solid fa-truck-fast text-[#ef394e]"></i>
                        <h3 class="font-bold text-zinc-900 text-xs sm:text-sm">ارسال اکسپرس رایگان</h3>
                    </div>
                    <p class="text-zinc-600 text-xs">ارسال سریع سفارش‌های بالای ۵۰۰ هزار تومان به سراسر کشور با بسته‌بندی ایمن.</p>
                </div>
            </div>

            <!-- FAQ Collapse Box -->
            <h2 class="text-sm sm:text-base font-black text-zinc-900 pt-4 border-t border-zinc-100">سوالات متداول خریداران</h2>
            <div class="space-y-3 pt-2" x-data="{ openFaq: null }">
                <div class="border border-zinc-200 rounded-2xl overflow-hidden">
                    <button @click="openFaq = openFaq === 1 ? null : 1" class="w-full text-right p-4 bg-zinc-50 font-bold text-xs sm:text-sm flex justify-between items-center text-zinc-800">
                        <span>جنس تیشرت‌های وارِن از چیست؟</span>
                        <i class="fa-solid" :class="openFaq === 1 ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                    </button>
                    <div x-show="openFaq === 1" x-collapse class="p-4 text-xs text-zinc-600 bg-white border-t border-zinc-100">
                        تمامی محصولات وارِن از نخ پنبه ۱۰۰٪ سوپر شانه شده تهیه می‌شوند که خنک، نرم و مقاوم در برابر تغییر شکل در طول زمان هستند.
                    </div>
                </div>

                <div class="border border-zinc-200 rounded-2xl overflow-hidden">
                    <button @click="openFaq = openFaq === 2 ? null : 2" class="w-full text-right p-4 bg-zinc-50 font-bold text-xs sm:text-sm flex justify-between items-center text-zinc-800">
                        <span>کیفیت و دوام چاپ طرح‌ها چگونه است؟</span>
                        <i class="fa-solid" :class="openFaq === 2 ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                    </button>
                    <div x-show="openFaq === 2" x-collapse class="p-4 text-xs text-zinc-600 bg-white border-t border-zinc-100">
                        چاپ با تکنولوژی DTF دیجیتال با جوهرهای اورجینال کره انجام شده و تضمین می‌شود که در برابر شستشوی استاندارد به هیچ وجه رنگ ندهد یا دچار ترک‌خوردگی نشود.
                    </div>
                </div>

                <div class="border border-zinc-200 rounded-2xl overflow-hidden">
                    <button @click="openFaq = openFaq === 3 ? null : 3" class="w-full text-right p-4 bg-zinc-50 font-bold text-xs sm:text-sm flex justify-between items-center text-zinc-800">
                        <span>چگونه سایز مناسب خود را انتخاب کنم؟</span>
                        <i class="fa-solid" :class="openFaq === 3 ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                    </button>
                    <div x-show="openFaq === 3" x-collapse class="p-4 text-xs text-zinc-600 bg-white border-t border-zinc-100">
                        در صفحه هر محصول راهنمای دقیق سایزبندی (عرض سینه و ارتفاع) قرار داده شده است. پیشنهاد می‌کنیم یکی از تیشرت‌های محبوب خود را اندازه‌گیری کرده و با جدول مقایسه نمایید.
                    </div>
                </div>
            </div>
        </article>
    </section>
</div>
@endsection

