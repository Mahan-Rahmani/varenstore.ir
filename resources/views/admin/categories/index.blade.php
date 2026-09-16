@extends('layouts.admin')

@section('title', 'مدیریت دسته‌بندی‌های موضوعی (Circular Categories)')

@section('content')
<div class="max-w-4xl mx-auto p-6 space-y-6">
    <!-- Create Category Card -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200/80">
        <div class="flex items-center gap-2 mb-4 pb-3 border-b border-slate-100">
            <i class="fa-solid fa-[#ef394e] fa-icons text-[#ef394e]"></i>
            <h2 class="text-base font-black text-slate-800">ایجاد دسته‌بندی موضوعی جدید</h2>
        </div>
        
        <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block mb-1 text-xs font-bold text-slate-700">نام موضوع (مثال: طرح‌های موسیقی) *</label>
                    <input type="text" name="name" placeholder="عنوان دسته‌بندی" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold" required>
                </div>
                <div>
                    <label class="block mb-1 text-xs font-bold text-slate-700">آدرس تصویر دایره‌ای (URL Image) *</label>
                    <input type="url" name="image" placeholder="https://.../music-icon.jpg" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-mono dir-ltr text-left">
                </div>
            </div>
            
            <div>
                <label class="block mb-1 text-xs font-bold text-slate-700">توضیح کوتاه موضوع</label>
                <input type="text" name="description" placeholder="توضیحی درباره طرح‌های این موضوع..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" class="px-6 py-2.5 bg-black hover:bg-[#ef394e] text-white rounded-xl font-black text-xs transition duration-200 flex items-center gap-2">
                    <i class="fa-solid fa-plus"></i>
                    <span>ذخیره و ثبت دسته‌بندی</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Categories List Card -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200/80">
        <h2 class="text-base font-black text-slate-800 mb-4 pb-3 border-b border-slate-100">لیست دسته‌بندی‌های موضوعی فعال</h2>
        
        @if($categories->isEmpty())
            <p class="text-xs text-slate-400 font-bold text-center py-6">هنوز هیچ دسته‌بندی موضوعی ثبت نشده است.</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach($categories as $category)
                    <div class="flex items-center justify-between p-3.5 bg-slate-50 rounded-2xl border border-slate-200/60">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-full overflow-hidden bg-slate-200 border-2 border-[#ef394e] p-0.5 shrink-0">
                                @if($category->image)
                                    <img src="{{ $category->image }}" alt="{{ $category->name }}" class="w-full h-full object-cover rounded-full">
                                @else
                                    <div class="w-full h-full bg-slate-900 text-white flex items-center justify-center font-black text-sm rounded-full">
                                        {{ mb_substr($category->name, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                            <div>
                                <span class="font-black text-xs text-slate-800 block mb-0.5">{{ $category->name }}</span>
                                <span class="text-[10px] text-slate-400 font-mono block">اسلاگ: {{ $category->slug }}</span>
                            </div>
                        </div>

                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('آیا از حذف این دسته‌بندی اطمینان دارید؟');">
                            @csrf 
                            @method('DELETE')
                            <button class="w-8 h-8 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-100 flex items-center justify-center transition">
                                <i class="fa-solid fa-trash text-xs"></i>
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection

