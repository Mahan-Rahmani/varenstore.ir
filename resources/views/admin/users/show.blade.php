@extends('layouts.admin')

@section('title', 'پروفایل کاربر: ' . $user->name)

@section('content')
<div class="space-y-6">
    <!-- User Overview Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-4 pb-6 border-b border-slate-100">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-[#ef394e]/10 text-[#ef394e] flex items-center justify-center font-black text-xl border border-[#ef394e]/20">
                    {{ mb_substr($user->name, 0, 1) }}
                </div>
                <div>
                    <h2 class="text-base sm:text-lg font-black text-slate-900">{{ $user->name }}</h2>
                    <span class="text-xs text-slate-400 font-mono block">{{ $user->email }}</span>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <span class="px-3 py-1 rounded-xl text-xs font-bold {{ $user->isAdmin() ? 'bg-amber-100 text-amber-900' : 'bg-blue-50 text-blue-700' }}">
                    {{ $user->isAdmin() ? 'مدیر سیستم' : 'مشتری عادی' }}
                </span>
                <a href="{{ route('admin.users.edit', $user->id) }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs rounded-xl transition">
                    ویرایش مشخصات
                </a>
                <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-slate-900 hover:bg-black text-white font-bold text-xs rounded-xl transition">
                    بازگشت
                </a>
            </div>
        </div>

        <!-- Metrics Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-6 text-xs">
            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                <span class="text-slate-400 font-bold block mb-1">شماره همراه</span>
                <strong class="text-slate-900 font-mono text-sm">{{ $user->phone ?? 'ثبت نشده' }}</strong>
            </div>
            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                <span class="text-slate-400 font-bold block mb-1">کل سفارش‌ها</span>
                <strong class="text-slate-900 text-sm">{{ $user->orders->count() }} سفارش</strong>
            </div>
            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                <span class="text-slate-400 font-bold block mb-1">مجموع خرید موفق</span>
                <strong class="text-emerald-600 text-sm font-black">{{ number_format($paidOrdersSum) }} تومان</strong>
            </div>
        </div>
    </div>

    <!-- User Orders History Table -->
    <div class="bg-white rounded-3xl border border-slate-200/80 p-6 shadow-sm">
        <h3 class="text-xs font-black text-slate-900 mb-4 pb-3 border-b border-slate-100 flex items-center gap-2">
            <i class="fa-solid fa-receipt text-[#ef394e]"></i>
            <span>تاریخچه سفارش‌های این کاربر</span>
        </h3>

        <div class="overflow-x-auto">
            <table class="w-full text-right text-xs">
                <thead class="bg-slate-50 text-slate-400 font-bold">
                    <tr>
                        <th class="p-3">کد سفارش</th>
                        <th class="p-3">تاریخ ثبت</th>
                        <th class="p-3">مبلغ پرداختی</th>
                        <th class="p-3">وضعیت پرداخت</th>
                        <th class="p-3">وضعیت مرسوله</th>
                        <th class="p-3 text-left">فاکتور</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($user->orders as $order)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="p-3 font-mono font-bold text-sky-600">
                                <a href="{{ route('admin.orders.show', $order->id) }}">#{{ $order->order_number }}</a>
                            </td>
                            <td class="p-3 text-slate-400 dir-ltr text-right">{{ $order->created_at->format('Y/m/d H:i') }}</td>
                            <td class="p-3 font-black text-slate-900">{{ number_format($order->grand_total) }} تومان</td>
                            <td class="p-3">
                                <span class="px-2 py-0.5 text-[10px] font-bold rounded {{ $order->payment_status->badgeColor() }}">
                                    {{ match($order->payment_status->value) {
                                        'paid' => 'پرداخت شده',
                                        'unpaid' => 'پرداخت نشده',
                                        'failed' => 'ناموفق',
                                        'refunded' => 'مرجوع شده',
                                        default => $order->payment_status->value
                                    } }}
                                </span>
                            </td>
                            <td class="p-3">
                                <span class="px-2 py-0.5 text-[10px] font-bold rounded {{ $order->status->badgeColor() }}">
                                    {{ match($order->status->value) {
                                        'pending' => 'در انتظار بررسی',
                                        'processing' => 'در حال پردازش',
                                        'completed' => 'تحویل شده',
                                        'cancelled' => 'لغو شده',
                                        default => $order->status->value
                                    } }}
                                </span>
                            </td>
                            <td class="p-3 text-left">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="px-3 py-1 bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs rounded-lg transition">
                                    مشاهده فاکتور
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-6 text-center text-slate-400 font-bold">
                                این کاربر تاکنون سفارشی ثبت نکرده است.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
