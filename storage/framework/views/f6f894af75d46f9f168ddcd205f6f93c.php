

<?php $__env->startSection('title', 'ویرایش اسلاید'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-base font-black text-slate-800">ویرایش اسلاید</h2>
        <a href="<?php echo e(route('admin.sliders.index')); ?>" class="px-4 py-2 bg-slate-100 text-slate-700 font-bold text-xs rounded-xl hover:bg-slate-200 transition">
            بازگشت به لیست
        </a>
    </div>

    <form action="<?php echo e(route('admin.sliders.update', $slider->id)); ?>" method="POST" enctype="multipart/form-data" 
          x-data="{ imageType: 'file', previewUrl: '<?php echo e($slider->image_url); ?>' }" class="space-y-6">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <!-- Image Upload -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm space-y-4">
            <h3 class="text-xs font-black text-slate-900 border-b border-slate-100 pb-3">تصویر اسلاید</h3>

            <div class="flex items-center gap-4 text-xs font-bold">
                <label class="flex items-center gap-1.5 cursor-pointer">
                    <input type="radio" name="img_type" value="file" x-model="imageType" class="text-[#ef394e]">
                    <span>آپلود فایل جدید</span>
                </label>
                <label class="flex items-center gap-1.5 cursor-pointer">
                    <input type="radio" name="img_type" value="url" x-model="imageType" class="text-[#ef394e]">
                    <span>ویرایش آدرس عکس (URL)</span>
                </label>
            </div>

            <div x-show="imageType === 'file'" class="space-y-2">
                <input type="file" name="image_file" accept="image/*"
                       @change="const file = $event.target.files[0]; if (file) previewUrl = URL.createObjectURL(file)"
                       class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-slate-900 file:text-white hover:file:bg-[#ef394e] transition">
            </div>

            <div x-show="imageType === 'url'" class="space-y-2">
                <input type="url" name="image_url" value="<?php echo e(old('image_url', $slider->image)); ?>" 
                       @input="previewUrl = $event.target.value"
                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-mono dir-ltr text-left">
            </div>

            <div class="mt-3 relative rounded-2xl overflow-hidden border border-slate-200 h-48 bg-slate-900">
                <img :src="previewUrl" class="w-full h-full object-cover">
            </div>
        </div>

        <!-- Content -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm space-y-4 text-xs font-bold">
            <h3 class="text-xs font-black text-slate-900 border-b border-slate-100 pb-3">متن‌ها و لینک</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-slate-700 mb-1">عنوان اصلی (H2)</label>
                    <input type="text" name="title" value="<?php echo e(old('title', $slider->title)); ?>" class="w-full px-4 py-2.5 bg-slate-50 border rounded-xl">
                </div>
                <div>
                    <label class="block text-slate-700 mb-1">برچسب ویژه (Tag Badge)</label>
                    <input type="text" name="tag" value="<?php echo e(old('tag', $slider->tag)); ?>" class="w-full px-4 py-2.5 bg-slate-50 border rounded-xl">
                </div>
            </div>

            <div>
                <label class="block text-slate-700 mb-1">زیرعنوان / توضیح</label>
                <input type="text" name="subtitle" value="<?php echo e(old('subtitle', $slider->subtitle)); ?>" class="w-full px-4 py-2.5 bg-slate-50 border rounded-xl">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-slate-700 mb-1">متن دکمه</label>
                    <input type="text" name="button_text" value="<?php echo e(old('button_text', $slider->button_text)); ?>" class="w-full px-4 py-2.5 bg-slate-50 border rounded-xl">
                </div>
                <div>
                    <label class="block text-slate-700 mb-1">لینک هدف</label>
                    <input type="text" name="link" value="<?php echo e(old('link', $slider->link)); ?>" class="w-full px-4 py-2.5 bg-slate-50 border rounded-xl font-mono dir-ltr text-left">
                </div>
            </div>
        </div>

        <!-- Settings -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm flex items-center justify-between text-xs font-bold">
            <div class="flex items-center gap-6">
                <div>
                    <label class="block text-slate-700 mb-1">ترتیب نمایش</label>
                    <input type="number" name="sort_order" value="<?php echo e(old('sort_order', $slider->sort_order)); ?>" class="w-24 px-3 py-2 bg-slate-50 border rounded-xl font-mono text-center">
                </div>
                <label class="flex items-center gap-2 cursor-pointer mt-5">
                    <input type="checkbox" name="is_active" value="1" <?php echo e($slider->is_active ? 'checked' : ''); ?> class="w-4 h-4 rounded text-[#ef394e]">
                    <span>اسلاید فعال باشد</span>
                </label>
            </div>

            <button type="submit" class="px-6 py-3 bg-[#ef394e] hover:bg-rose-600 text-white font-black rounded-xl shadow transition">
                بروزرسانی اسلاید
            </button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/sliders/edit.blade.php ENDPATH**/ ?>