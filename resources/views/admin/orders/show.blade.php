@extends('layouts.admin')

@section('title', 'جزئیات سفارش #' . $order->order_number)

@section('content')
<div class="space-y-4 sm:space-y-6">
    <!-- Top Header Card -->
    <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-200/80 p-4 sm:p-6 shadow-xs flex flex-wrap items-center justify-between gap-3 sm:gap-4">
        <div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.orders.index') }}" class="sm:hidden text-slate-500 hover:text-black py-1 pr-1 pl-2">
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
                <h2 class="text-sm sm:text-lg font-black text-slate-900 font-mono">سفارش #{{ $order->order_number }}</h2>
            </div>
            <span class="text-[10px] sm:text-xs text-slate-400 font-bold block mt-0.5 sm:mt-1">تاریخ ثبت: {{ $order->created_at->format('Y/m/d - ساعت H:i') }}</span>
        </div>
        <div class="flex items-center gap-1.5 sm:gap-2">
            <span class="px-2.5 py-1 text-[10px] sm:text-xs font-bold rounded-lg sm:rounded-xl {{ $order->status->badgeColor() }}">
                {{ match($order->status->value) {
                    'pending' => 'در انتظار بررسی',
                    'processing' => 'در حال پردازش',
                    'completed' => 'تحویل شده',
                    'cancelled' => 'لغو شده',
                    default => $order->status->value
                } }}
            </span>
            <span class="px-2.5 py-1 text-[10px] sm:text-xs font-bold rounded-lg sm:rounded-xl {{ $order->payment_status->badgeColor() }}">
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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Column -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Items Table -->
            <div class="bg-white rounded-3xl border border-slate-200/80 p-6 shadow-sm">
                <h3 class="text-xs font-black text-slate-900 mb-4 pb-3 border-b border-slate-100">
                    اقلام سفارش ({{ $order->items->count() }} کالا)
                </h3>
                <div class="divide-y divide-slate-100">
                    @foreach($order->items as $item)
                        <div class="py-3 flex items-center justify-between text-xs">
                            <div>
                                <span class="font-bold text-slate-900 block mb-0.5">{{ $item->product_name }}</span>
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="text-slate-400 font-mono text-[11px]">کد کالا: {{ $item->sku }}</span>
                                    @if(!empty($item->attributes_snapshot))
                                        @foreach($item->attributes_snapshot as $attrK => $attrV)
                                            <span class="px-2 py-0.5 rounded bg-amber-50 text-amber-800 border border-amber-200 text-[10px] font-black">
                                                {{ $attrK }}: {{ $attrV }}
                                            </span>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            <div class="text-left">
                                <span class="font-black text-slate-900 block">{{ number_format($item->subtotal) }} تومان</span>
                                <span class="text-slate-400 text-[11px] block mt-0.5">{{ $item->quantity }} عدد × {{ number_format($item->unit_price) }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Status Update Form -->
            <div class="bg-white rounded-3xl border border-slate-200/80 p-6 shadow-sm">
                <h3 class="text-xs font-black text-slate-900 mb-4 pb-3 border-b border-slate-100">
                    تغییر وضعیت سفارش و پرداخت
                </h3>
                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-end">
                    @csrf
                    @method('PATCH')
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">وضعیت سفارش</label>
                        <select name="status" class="w-full px-3.5 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl font-bold focus:outline-none">
                            @foreach(\App\Enums\OrderStatus::cases() as $st)
                                <option value="{{ $st->value }}" {{ $order->status === $st ? 'selected' : '' }}>
                                    {{ match($st->value) {
                                        'pending' => 'در انتظار بررسی',
                                        'processing' => 'در حال پردازش',
                                        'completed' => 'تحویل شده',
                                        'cancelled' => 'لغو شده',
                                        default => $st->value
                                    } }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">وضعیت پرداخت</label>
                        <select name="payment_status" class="w-full px-3.5 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl font-bold focus:outline-none">
                            @foreach(\App\Enums\PaymentStatus::cases() as $pst)
                                <option value="{{ $pst->value }}" {{ $order->payment_status === $pst ? 'selected' : '' }}>
                                    {{ match($pst->value) {
                                        'paid' => 'پرداخت شده',
                                        'unpaid' => 'پرداخت نشده',
                                        'failed' => 'ناموفق',
                                        'refunded' => 'مرجوع شده',
                                        default => $pst->value
                                    } }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <button type="submit" class="w-full px-5 py-2.5 bg-black hover:bg-[#ef394e] text-white font-bold text-xs rounded-xl transition shadow">
                            ثبت تغییرات وضعیت
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Customer & Delivery Sidebar -->
        <div class="space-y-4">
            <!-- Payment Transaction Details (Security & Banking) -->
            <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-200/80 p-4 sm:p-6 shadow-xs space-y-3 text-xs">
                <h3 class="text-xs font-black text-slate-900 pb-3 border-b border-slate-100 flex items-center gap-2">
                    <i class="fa-solid fa-shield-halved text-emerald-600"></i>
                    <span>اطلاعات تراکنش بانکی (زرین‌پال / شاپرک)</span>
                </h3>
                
                @php $tx = $order->latestTransaction; @endphp
                @if($tx)
                    <div class="space-y-2">
                        <div class="flex justify-between items-center">
                            <span class="text-slate-400 font-bold">کد پیگیری بانکی (RefID):</span>
                            <span class="font-mono font-black text-emerald-600 dir-ltr select-all">{{ $tx->transaction_reference }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-slate-400 font-bold">درگاه پرداخت:</span>
                            <span class="font-bold text-slate-800">{{ $tx->gateway === 'zarinpal' ? 'زرین‌پال (شاپرک)' : 'پرداخت تستی' }}</span>
                        </div>
                        @if($tx->card_pan_masked)
                            <div class="flex justify-between items-center">
                                <span class="text-slate-400 font-bold">شماره کارت خریدار:</span>
                                <span class="font-mono font-bold text-slate-800 dir-ltr">{{ $tx->card_pan_masked }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between items-center">
                            <span class="text-slate-400 font-bold">وضعیت تراکنش:</span>
                            <span class="px-2 py-0.5 rounded-lg text-[10px] font-black {{ $tx->status === 'success' ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                                {{ $tx->status === 'success' ? 'موفق و تایید شده' : ($tx->status === 'pending' ? 'در انتظار پرداخت' : 'ناموفق / لغو شده') }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-slate-400 font-bold">تاریخ و ساعت تراکنش:</span>
                            <span class="font-mono text-slate-600 text-[11px] dir-ltr">{{ $tx->updated_at->format('Y/m/d - H:i:s') }}</span>
                        </div>
                    </div>
                @else
                    <p class="text-slate-400 italic text-[11px]">تراکنشی برای این سفارش ثبت نشده است.</p>
                @endif
            </div>

            <!-- Customer & Delivery Card -->
            <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-200/80 p-4 sm:p-6 shadow-xs space-y-4 text-xs">
                <h3 class="text-xs font-black text-slate-900 pb-3 border-b border-slate-100">
                    اطلاعات تحویل‌گیرنده
                </h3>
                <div>
                    <span class="text-slate-400 block mb-0.5 font-bold">نام و نام خانوادگی:</span>
                    <strong class="text-slate-900">{{ $order->customer_name }}</strong>
                </div>
                <div>
                    <span class="text-slate-400 block mb-0.5 font-bold">شماره همراه تحویل‌گیرنده:</span>
                    <strong class="text-slate-900 font-mono">{{ $order->customer_phone }}</strong>
                </div>
                @if($order->customer_email)
                    <div>
                        <span class="text-slate-400 block mb-0.5 font-bold">نشانی ایمیل:</span>
                        <strong class="text-slate-900 font-mono">{{ $order->customer_email }}</strong>
                    </div>
                @endif
                <div>
                    <span class="text-slate-400 block mb-0.5 font-bold">نشانی ارسال مرسوله:</span>
                    <strong class="text-slate-900 block mb-0.5">{{ $order->city }} - کد پستی: {{ $order->postal_code }}</strong>
                    <span class="text-slate-600 font-medium">{{ $order->shipping_address }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
