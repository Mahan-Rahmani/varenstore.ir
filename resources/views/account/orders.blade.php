@extends('account.layout')

@section('account_breadcrumb', 'سفارش‌های من')

@section('account_content')
<div class="space-y-6">
    <div class="bg-white rounded-3xl border border-zinc-200 p-6 shadow-sm">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-zinc-100">
            <div>
                <h1 class="text-base font-black text-zinc-900 mb-1">تاریخچه سفارش‌های من</h1>
                <p class="text-xs text-zinc-400">لیست تمامی سفارش‌های ثبت شده در فروشگاه وارِن</p>
            </div>
        </div>

        <!-- Filter Tabs -->
        <div class="flex items-center gap-2 overflow-x-auto py-4 border-b border-zinc-100 text-xs font-bold">
            <a href="{{ route('account.orders') }}" 
               class="px-3.5 py-1.5 rounded-xl whitespace-nowrap transition {{ !request('status') ? 'bg-black text-white' : 'bg-zinc-100 text-zinc-600 hover:bg-zinc-200' }}">
                همه سفارش‌ها
            </a>
            <a href="{{ route('account.orders', ['status' => 'processing']) }}" 
               class="px-3.5 py-1.5 rounded-xl whitespace-nowrap transition {{ request('status') === 'processing' ? 'bg-black text-white' : 'bg-zinc-100 text-zinc-600 hover:bg-zinc-200' }}">
                در حال پردازش
            </a>
            <a href="{{ route('account.orders', ['status' => 'completed']) }}" 
               class="px-3.5 py-1.5 rounded-xl whitespace-nowrap transition {{ request('status') === 'completed' ? 'bg-black text-white' : 'bg-zinc-100 text-zinc-600 hover:bg-zinc-200' }}">
                تحویل شده
            </a>
            <a href="{{ route('account.orders', ['status' => 'pending']) }}" 
               class="px-3.5 py-1.5 rounded-xl whitespace-nowrap transition {{ request('status') === 'pending' ? 'bg-black text-white' : 'bg-zinc-100 text-zinc-600 hover:bg-zinc-200' }}">
                در انتظار بررسی
            </a>
            <a href="{{ route('account.orders', ['status' => 'cancelled']) }}" 
               class="px-3.5 py-1.5 rounded-xl whitespace-nowrap transition {{ request('status') === 'cancelled' ? 'bg-black text-white' : 'bg-zinc-100 text-zinc-600 hover:bg-zinc-200' }}">
                لغو شده
            </a>
        </div>

        <!-- Orders List -->
        <div class="pt-5">
            @if($orders->isEmpty())
                <div class="text-center py-12">
                    <div class="w-14 h-14 rounded-full bg-zinc-100 text-zinc-400 flex items-center justify-center text-xl mx-auto mb-3">
                        <i class="fa-solid fa-box-open"></i>
                    </div>
                    <h3 class="font-black text-zinc-800 text-sm mb-1">هیچ سفارشی در این بخش یافت نشد!</h3>
                    <p class="text-xs text-zinc-400 mb-4">می‌توانید فیلترهای دیگر را بررسی کنید یا خرید جدیدی ثبت نمایید.</p>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($orders as $order)
                        <div class="border border-zinc-200/80 rounded-2xl p-5 hover:border-zinc-300 transition bg-white shadow-sm">
                            <div class="flex flex-wrap items-center justify-between gap-3 pb-3 border-b border-zinc-100 text-xs">
                                <div class="flex items-center gap-3">
                                    <span class="font-black text-zinc-900 font-mono text-sm">#{{ $order->order_number }}</span>
                                    <span class="text-zinc-400 text-[11px]">{{ $order->created_at->format('Y/m/d - H:i') }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="px-2.5 py-1 text-[11px] font-bold rounded-lg {{ $order->status->badgeColor() }}">
                                        {{ match($order->status->value) {
                                            'pending' => 'در انتظار بررسی',
                                            'processing' => 'در حال پردازش',
                                            'completed' => 'تحویل شده',
                                            'cancelled' => 'لغو شده',
                                            default => $order->status->value
                                        } }}
                                    </span>
                                    <span class="px-2.5 py-1 text-[11px] font-bold rounded-lg {{ $order->payment_status->badgeColor() }}">
                                        {{ match($order->payment_status->value) {
                                            'paid' => 'پرداخت شده',
                                            'unpaid' => 'پرداخت نشده',
                                            'failed' => 'ناموفق',
                                            'refunded' => 'مرجوع شده',
                                            default => $order->payment_status->value
                                        } }}
                                    </span>
                                </div>
                            </div>

                            <div class="pt-4 flex flex-wrap items-center justify-between gap-4">
                                <div class="flex items-center gap-2.5 overflow-x-auto py-1">
                                    @foreach($order->items as $item)
                                        <div class="w-14 h-16 rounded-xl bg-zinc-50 border border-zinc-200 overflow-hidden shrink-0 flex items-center justify-center p-0.5" title="{{ $item->product_name }}">
                                            @if($item->product?->featured_image)
                                                <img src="{{ $item->product->featured_image }}" alt="{{ $item->product_name }}" class="w-full h-full object-cover rounded-lg">
                                            @else
                                                <i class="fa-solid fa-box text-zinc-300 text-xs"></i>
                                            @endif
                                        </div>
                                    @endforeach
                                    <div class="mr-2">
                                        <span class="text-xs font-bold text-zinc-800 block">{{ $order->items->count() }} قلم کالا</span>
                                        @php
                                            $sampleAttrs = $order->items->first()?->attributes_snapshot;
                                        @endphp
                                        @if(!empty($sampleAttrs))
                                            <div class="flex items-center gap-1.5 mt-0.5 flex-wrap">
                                                @foreach($sampleAttrs as $k => $v)
                                                    <span class="text-[10px] text-zinc-500 font-bold bg-zinc-100 px-1.5 py-0.5 rounded">{{ $k }}: {{ $v }}</span>
                                                @endforeach
                                            </div>
                                        @endif
                                        <span class="text-[10px] text-zinc-400 block mt-0.5">ارسال به: {{ $order->city }}</span>
                                    </div>
                                </div>

                                <div class="flex items-center gap-4">
                                    <div class="text-left">
                                        <span class="text-[10px] text-zinc-400 block font-bold">مبلغ نهایی:</span>
                                        <span class="text-sm font-black text-zinc-900">{{ number_format($order->grand_total) }} تومان</span>
                                    </div>
                                    <a href="{{ route('account.orders.show', $order->order_number) }}" 
                                       class="px-4 py-2.5 bg-black hover:bg-[#ef394e] text-white font-bold text-xs rounded-xl transition flex items-center gap-2 shadow-sm">
                                        <span>مشاهده فاکتور و رهگیری</span>
                                        <i class="fa-solid fa-arrow-left text-[11px]"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection