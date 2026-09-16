

<?php $__env->startSection('title', 'مدیریت اسلایدر و بنرهای صفحه اصلی'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Action Bar -->
    <div class="flex items-center justify-between gap-4">
        <div class="flex gap-2">
            <div class="px-4 py-2 bg-white border border-slate-200 rounded-2xl text-xs font-bold shadow-sm">
                مجموع اسلایدها: <span class="font-black text-slate-900"><?php echo e($totalSlides); ?></span>
            </div>
            <div class="px-4 py-2 bg-emerald-50 border border-emerald-100 rounded-2xl text-xs font-bold text-emerald-800 shadow-sm">
                فعال: <span class="font-black"><?php echo e($activeSlides); ?></span>
            </div>
        </div>

        <a href="<?php echo e(route('admin.sliders.create')); ?>" class="px-5 py-2.5 bg-[#ef394e] hover:bg-rose-600 text-white font-bold text-xs rounded-2xl shadow-md transition flex items-center gap-2">
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
                    <?php $__empty_1 = true; $__currentLoopData = $sliders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="p-4">
                                <img src="<?php echo e($slider->image_url); ?>" alt="slider" class="w-16 h-10 object-cover rounded-lg border border-slate-100">
                            </td>
                            <td class="p-4">
                                <div class="font-black text-slate-900 mb-0.5"><?php echo e($slider->title ?: 'بدون عنوان'); ?></div>
                                <div class="text-slate-400 font-bold truncate max-w-[250px]"><?php echo e($slider->subtitle ?: 'بدون زیرعنوان'); ?></div>
                            </td>
                            <td class="p-4 text-center font-mono font-bold"><?php echo e($slider->sort_order); ?></td>
                            <td class="p-4 text-center">
                                <form action="<?php echo e(route('admin.sliders.toggle', $slider->id)); ?>" method="POST">
                                    <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                    <button type="submit" class="px-3 py-1 rounded-lg text-[10px] font-black transition <?php echo e($slider->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500'); ?>">
                                        <?php echo e($slider->is_active ? 'فعال' : 'غیرفعال'); ?>

                                    </button>
                                </form>
                            </td>
                            <td class="p-4 text-left">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="<?php echo e(route('admin.sliders.edit', $slider->id)); ?>" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold rounded-xl transition">ویرایش</a>
                                    <form action="<?php echo e(route('admin.sliders.destroy', $slider->id)); ?>" method="POST" onsubmit="return confirm('حذف شود؟')">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold rounded-xl transition">حذف</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="5" class="p-8 text-center text-slate-400 font-bold">هنوز اسلایدی ثبت نشده است.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/sliders/index.blade.php ENDPATH**/ ?>