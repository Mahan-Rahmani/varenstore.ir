@if(isset($relatedProducts) && $relatedProducts->isNotEmpty())
    <div class="mt-14 pt-10 border-t border-zinc-200">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-2.5">
                <span class="w-2.5 h-6 bg-[#ef394e] rounded-full"></span>
                <h3 class="text-base sm:text-lg font-black text-zinc-900">محصولات مشابه و پیشنهادی</h3>
            </div>
            <a href="{{ route('home', ['category' => $product->category?->slug]) }}" class="text-xs font-bold text-[#ef394e] hover:underline flex items-center gap-1">
                <span>مشاهده بیشتر</span>
                <i class="fa-solid fa-chevron-left text-[10px]"></i>
            </a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4 sm:gap-6">
            @foreach($relatedProducts as $rel)
                <div class="bg-white rounded-2xl border border-zinc-200 p-3 flex flex-col justify-between shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                    <div class="relative aspect-[3/4] bg-zinc-50 rounded-xl overflow-hidden mb-3">
                        @if($rel->featured_image)
                            <img src="{{ $rel->featured_image }}" alt="{{ $rel->name }}" loading="lazy" class="w-full h-full object-cover object-center group-hover:scale-105 transition duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-zinc-300 bg-zinc-100">
                                <i class="fa-regular fa-image text-3xl"></i>
                            </div>
                        @endif

                        @if($rel->has_discount)
                            <span class="absolute top-2 right-2 bg-[#ef394e] text-white text-[11px] font-black px-2 py-0.5 rounded-full shadow">
                                ٪{{ $rel->discount_percentage }}
                            </span>
                        @endif
                    </div>

                    <div class="flex-1 flex flex-col justify-between">
                        <div>
                            <span class="text-[10px] font-bold text-zinc-400 block mb-1 truncate">{{ $rel->category?->name ?? 'وارِن | VAREN' }}</span>
                            <h4 class="font-bold text-zinc-900 text-xs line-clamp-2 leading-relaxed group-hover:text-[#ef394e] transition-colors">
                                <a href="{{ route('product.show', $rel->slug) }}">{{ $rel->name }}</a>
                            </h4>
                        </div>

                        <div class="mt-3 pt-2.5 border-t border-zinc-100 flex items-center justify-between">
                            <div>
                                @if($rel->has_discount)
                                    <span class="text-[10px] text-zinc-400 line-through block">{{ number_format($rel->price) }}</span>
                                    <span class="text-xs font-black text-zinc-950">{{ number_format($rel->sale_price) }} <span class="text-[9px] font-medium text-zinc-500">تومان</span></span>
                                @else
                                    <span class="text-xs font-black text-zinc-950">{{ number_format($rel->price) }} <span class="text-[9px] font-medium text-zinc-500">تومان</span></span>
                                @endif
                            </div>
                            <a href="{{ route('product.show', $rel->slug) }}" class="w-7 h-7 rounded-lg bg-zinc-100 group-hover:bg-[#ef394e] text-zinc-700 group-hover:text-white flex items-center justify-center transition">
                                <i class="fa-solid fa-chevron-left text-[10px]"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
