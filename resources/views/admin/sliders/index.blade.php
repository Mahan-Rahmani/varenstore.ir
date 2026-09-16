@extends('layouts.admin')

@section('title', 'مدیریت اسلایدر و بنرهای صفحه اصلی')

@section('content')
<div class="space-y-6">
    <!-- Action Bar -->
    <div class="flex items-center justify-between gap-4">
        <div class="flex gap-2">
            <div class="px-4 py-2 bg-white border border-slate-200 rounded-2xl text-xs font-bold shadow-sm">
                مجموع اسلایدها: <span class="font-black text-slate-900">{{ $totalSlides }}</span>
            </div>
            <div class="px-4 py-2 bg-emerald-50 border border-emerald-100 rounded-2xl text-xs font-bold text-emerald-800 shadow-sm">
                فعال: <span class="font-black">{{ $activeSlides }}</span>
            </div>
        </div>

        <a href="{{ route('admin.sliders.create') }}" class="px-5 py-2.5 bg-[#ef394e] hover:bg-rose-600 text-white font-bold text-xs rounded-2xl shadow-md transition flex items-center gap-2">
            <i class="fa-solid fa-plus text-xs"></i>
            <span>افزودن اسلاید جدید</span>
        </a>
    </div>

    <!-- Sliders List -->
    <div class="bg-white rounded-3xl border border-slate-200/80 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-right text-xs">
                <thead class="bg-slate-50 text-slate-400 font-bold">
                    <tr>
                        <th class="p-4 w-20 text-center">تصویر</th>
                        <th class="p-4">عنوان / زیرعنوان</th>
                        <th class="p-4 text-center">ترتیب</th>
                        <th class="p-4 text-center">وضعیت</th>
                        <th class="p-4 text-left">عملیات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($sliders as $slider)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="p-4">
                                <img src="{{ $slider->image_url }}" alt="slider" class="w-16 h-10 object-cover rounded-lg border border-slate-100">
                            </td>
                            <td class="p-4">
                                <div class="font-black text-slate-900 mb-0.5">{{ $slider->title ?: 'بدون عنوان' }}</div>
                                <div class="text-slate-400 font-bold truncate max-w-[250px]">{{ $slider->subtitle ?: 'بدون زیرعنوان' }}</div>
                            </td>
                            <td class="p-4 text-center font-mono font-bold">{{ $slider->sort_order }}</td>
                            <td class="p-4 text-center">
                                <form action="{{ route('admin.sliders.toggle', $slider->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="px-3 py-1 rounded-lg text-[10px] font-black transition {{ $slider->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                                        {{ $slider->is_active ? 'فعال' : 'غیرفعال' }}
                                    </button>
                                </form>
                            </td>
                            <td class="p-4 text-left">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.sliders.edit', $slider->id) }}" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold rounded-xl transition">ویرایش</a>
                                    <form action="{{ route('admin.sliders.destroy', $slider->id) }}" method="POST" onsubmit="return confirm('حذف شود؟')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold rounded-xl transition">حذف</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="p-8 text-center text-slate-400 font-bold">هنوز اسلایدی ثبت نشده است.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
