

<?php $__env->startSection('title', 'مدیریت کاربران و مشتریان'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Action Bar -->
    <div class="flex flex-wrap items-center justify-between gap-4">
        <form action="<?php echo e(route('admin.users.index')); ?>" method="GET" class="flex items-center gap-2">
            <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="جستجوی نام، ایمیل، شماره تماس..." 
                   class="px-4 py-2.5 text-xs bg-white border border-slate-200 rounded-2xl w-64 focus:outline-none focus:border-slate-400 font-medium shadow-sm">
            
            <select name="role" onchange="this.form.submit()" class="px-3 py-2.5 text-xs bg-white border border-slate-200 rounded-2xl focus:outline-none font-bold">
                <option value="">همه نقش‌ها</option>
                <option value="customer" <?php echo e(request('role') === 'customer' ? 'selected' : ''); ?>>مشتریان عادی</option>
                <option value="admin" <?php echo e(request('role') === 'admin' ? 'selected' : ''); ?>>مدیران سیستم</option>
            </select>

            <button type="submit" class="px-5 py-2.5 bg-slate-900 hover:bg-black text-white font-bold text-xs rounded-2xl shadow transition">
                جستجو
            </button>
        </form>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-3xl border border-slate-200/80 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-right text-xs">
                <thead class="bg-slate-50 text-slate-400 font-bold">
                    <tr>
                        <th class="p-4">کاربر</th>
                        <th class="p-4">شماره همراه</th>
                        <th class="p-4">نقش کاربری</th>
                        <th class="p-4">تعداد سفارش‌ها</th>
                        <th class="p-4">مجموع خرید موفق</th>
                        <th class="p-4">تاریخ عضویت</th>
                        <th class="p-4 text-left">عملیات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-2xl bg-slate-100 text-slate-700 flex items-center justify-center font-black text-xs shrink-0">
                                        <?php echo e(mb_substr($user->name, 0, 1)); ?>

                                    </div>
                                    <div>
                                        <a href="<?php echo e(route('admin.users.show', $user->id)); ?>" class="font-bold text-slate-900 hover:text-[#ef394e] transition block">
                                            <?php echo e($user->name); ?>

                                        </a>
                                        <span class="text-[11px] text-slate-400 font-mono block"><?php echo e($user->email); ?></span>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4 font-mono text-slate-600 font-bold">
                                <?php echo e($user->phone ?? 'ثبت نشده'); ?>

                            </td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 rounded-xl text-[11px] font-bold <?php echo e($user->isAdmin() ? 'bg-amber-100 text-amber-900' : 'bg-blue-50 text-blue-700'); ?>">
                                    <?php echo e($user->isAdmin() ? 'مدیر سیستم' : 'مشتری'); ?>

                                </span>
                            </td>
                            <td class="p-4 font-bold text-slate-800">
                                <?php echo e($user->orders_count); ?> سفارش
                            </td>
                            <td class="p-4 font-black text-slate-900">
                                <?php echo e(number_format($user->orders_sum_grand_total ?? 0)); ?> تومان
                            </td>
                            <td class="p-4 text-slate-400 dir-ltr text-right font-mono text-[11px]">
                                <?php echo e($user->created_at->format('Y/m/d')); ?>

                            </td>
                            <td class="p-4 text-left">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="<?php echo e(route('admin.users.show', $user->id)); ?>" class="px-3 py-1.5 bg-slate-900 hover:bg-black text-white font-bold text-xs rounded-xl transition">
                                        پروفایل و سفارش‌ها
                                    </a>
                                    <a href="<?php echo e(route('admin.users.edit', $user->id)); ?>" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs rounded-xl transition">
                                        ویرایش
                                    </a>
                                    <?php if($user->id !== auth()->id()): ?>
                                        <form action="<?php echo e(route('admin.users.destroy', $user->id)); ?>" method="POST" class="inline" onsubmit="return confirm('آیا از حذف این کاربر مطمئن هستید؟')">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold text-xs rounded-xl transition">
                                                حذف
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="p-8 text-center text-slate-400 font-bold">
                                کاربری یافت نشد.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4"><?php echo e($users->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/users/index.blade.php ENDPATH**/ ?>