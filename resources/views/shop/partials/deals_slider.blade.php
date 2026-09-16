<!-- Digistyle-Style "Today's Super Deals" Horizontal Carousel -->
@if(isset($discountedProducts) && $discountedProducts->isNotEmpty())
    <section class="mb-10" x-data="{
        scroll(direction) {
            const container = this.$refs.track;
            const scrollAmount = direction === 'next' ? -320 : 320;
            container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
        }
    }">
        <div class="relative bg-gradient-to-l from-[#e01438] via-[#ef394e] to-[#e01438] rounded-3xl p-4 sm:p-6 shadow-xl shadow-red-500/20 overflow-hidden">
            <div class="absolute -top-24 -right-24 w-64 h-64 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
            <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-black/10 rounded-full blur-2xl pointer-events-none"></div>

            <!-- Navigation Buttons -->
            <button @click="scroll('prev')"
                    class="hidden md:flex absolute right-2 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full bg-white/90 hover:bg-white text-zinc-800 hover:text-[#ef394e] shadow-lg items-center justify-center transition-all hover:scale-110 active:scale-95 border border-zinc-100"
                    aria-label="قبلی">
                <i class="fa-solid fa-chevron-right text-xs"></i>
            </button>
            <button @click="scroll('next')"
                    class="hidden md:flex absolute left-2 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full bg-white/90 hover:bg-white text-zinc-800 hover:text-[#ef394e] shadow-lg items-center justify-center transition-all hover:scale-110 active:scale-95 border border-zinc-100"
                    aria-label="بعدی">
                <i class="fa-solid fa-chevron-left text-xs"></i>
            </button>

            <!-- Horizontal Track -->
            <div x-ref="track"
                 class="flex items-stretch gap-3 sm:gap-4 overflow-x-auto scroll-smooth py-1 px-1 [scrollbar-width:none] [-ms-overflow-style:none] [&::-webkit-scrollbar]:hidden">

                <!-- Leading Digistyle Promo Card -->
                <div class="w-48 sm:w-56 shrink-0 flex flex-col justify-between items-center text-center p-4 rounded-2xl bg-white/10 backdrop-blur-sm border border-white/20 text-white select-none"
                     x-data="{
                         hours: '00', minutes: '00', seconds: '00',
                         updateTimer() {
                             const now = new Date();
                             const endOfDay = new Date(now.getFullYear(), now.getMonth(), now.getDate(), 23, 59, 59);
                             const diff = Math.max(0, Math.floor((endOfDay - now) / 1000));
                             this.hours = String(Math.floor(diff / 3600)).padStart(2, '0');
                             this.minutes = String(Math.floor((diff % 3600) / 60)).padStart(2, '0');
                             this.seconds = String(diff % 60).padStart(2, '0');
                         },
                         init() {
                             this.updateTimer();
                             setInterval(() => this.updateTimer(), 1000);
                         }
                     }">
                    <div class="flex flex-col items-center">
                        <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center mb-3 shadow-inner ring-4 ring-white/10">
                            <i class="fa-solid fa-fire-flame-curved text-2xl text-amber-300 animate-pulse"></i>
                        </div>
                        <span class="inline-block px-2.5 py-0.5 bg-black/20 text-amber-300 rounded-full text-[10px] font-black mb-2 tracking-wide">حراج ویژه وارِن</span>
                        <h3 class="text-lg sm:text-xl font-black leading-snug tracking-tight text-white mb-1">پرتخفیف‌های امروز</h3>
                        <p class="text-[11px] text-white/80 font-medium">بیشترین درصد تخفیف روز</p>
                    </div>

                    <!-- Countdown -->
                    <div class="w-full my-4 pt-3 border-t border-white/15">
                        <div class="text-[10px] text-white/90 font-bold mb-2">فرصت باقی‌مانده:</div>
                        <div class="flex items-center justify-center gap-1 font-mono text-xs font-black dir-ltr">
                            <div class="bg-white text-zinc-900 px-2 py-1.5 rounded-lg shadow-sm font-black min-w-[28px]" x-text="seconds">00</div>
                            <span class="text-white text-xs font-black">:</span>
                            <div class="bg-white text-zinc-900 px-2 py-1.5 rounded-lg shadow-sm font-black min-w-[28px]" x-text="minutes">00</div>
                            <span class="text-white text-xs font-black">:</span>
                            <div class="bg-white text-zinc-900 px-2 py-1.5 rounded-lg shadow-sm font-black min-w-[28px]" x-text="hours">00</div>
                        </div>
                    </div>

                    <a href="#catalog" class="inline-flex items-center gap-1.5 text-xs font-black text-white hover:text-amber-200 transition-colors py-1 group/btn">
                        <span>مشاهده همه</span>
                        <i class="fa-solid fa-arrow-left text-[11px] transition-transform duration-300 group-hover/btn:-translate-x-1"></i>
                    </a>
                </div>

                <!-- Discounted Product Cards -->
                @foreach($discountedProducts as $deal)
                    <div class="w-48 sm:w-52 shrink-0 bg-white rounded-2xl p-3 flex flex-col justify-between border border-white/60 shadow-md hover:shadow-2xl hover:-translate-y-1.5 transition-all duration-300 group">
                        <div class="relative aspect-[3/4] bg-zinc-50 rounded-xl overflow-hidden mb-2.5">
                            @if($deal->featured_image)
                                <img src="{{ $deal->featured_image }}" alt="{{ $deal->name }}" loading="lazy" class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-zinc-300 bg-zinc-100">
                                    <i class="fa-regular fa-image text-3xl"></i>
                                </div>
                            @endif
                            <span class="absolute top-2 right-2 bg-[#ef394e] text-white text-[11px] font-black px-2 py-0.5 rounded-full shadow-md">
                                {{ $deal->discount_percentage }}٪
                            </span>
                            @if($deal->stock <= 5 && $deal->stock > 0)
                                <span class="absolute bottom-2 right-2 left-2 bg-amber-500/90 backdrop-blur-sm text-white text-[9px] font-extrabold text-center py-0.5 rounded-md shadow-sm">
                                    تنها {{ $deal->stock }} عدد باقیست
                                </span>
                            @endif
                        </div>

                        <div class="flex-1 flex flex-col justify-between">
                            <div>
                                <span class="text-[10px] font-bold text-zinc-400 block mb-1 truncate">{{ $deal->category?->name ?? 'وارِن | VAREN' }}</span>
                                <h4 class="font-bold text-zinc-900 text-xs line-clamp-2 leading-relaxed group-hover:text-[#ef394e] transition-colors">
                                    <a href="{{ route('product.show', $deal->slug) }}">{{ $deal->name }}</a>
                                </h4>
                            </div>

                            <div class="mt-3 pt-2.5 border-t border-zinc-100 flex flex-col items-end gap-1">
                                <span class="text-[11px] text-zinc-400 line-through">{{ number_format($deal->price) }}</span>
                                <div class="flex items-baseline gap-1 text-black font-black">
                                    <span class="text-sm font-black text-zinc-950">{{ number_format($deal->sale_price) }}</span>
                                    <span class="text-[10px] font-medium text-zinc-500">تومان</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Trailing View All Card -->
                <a href="#catalog" class="w-40 sm:w-44 shrink-0 bg-white/90 hover:bg-white rounded-2xl p-4 flex flex-col items-center justify-center text-center group border border-white/60 shadow-md hover:shadow-2xl transition-all duration-300">
                    <div class="w-12 h-12 rounded-full border-2 border-[#ef394e] text-[#ef394e] flex items-center justify-center mb-3 group-hover:bg-[#ef394e] group-hover:text-white transition-all shadow-sm group-hover:scale-110">
                        <i class="fa-solid fa-arrow-left text-sm"></i>
                    </div>
                    <span class="text-xs font-black text-zinc-900 group-hover:text-[#ef394e] transition-colors">مشاهده همه</span>
                    <span class="text-[10px] text-zinc-400 font-bold mt-1">تخفیف‌های داغ</span>
                </a>
            </div>
        </div>
    </section>
@endif