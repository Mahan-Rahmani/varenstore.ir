

<?php $__env->startSection('account_breadcrumb', 'اطلاعات حساب کاربری'); ?>

<?php $__env->startSection('account_content'); ?>
<div class="space-y-6">
    <div class="bg-white rounded-3xl border border-zinc-200 p-6 sm:p-8 shadow-sm">
        <div class="pb-5 mb-6 border-b border-zinc-100">
            <h1 class="text-base font-black text-zinc-900 mb-1">اطلاعات حساب کاربری</h1>
            <p class="text-xs text-zinc-400">مشخصات هویتی، اطلاعات تماس و رمز عبور خود را ویرایش کنید.</p>
        </div>

        <?php if($errors->any()): ?>
            <div class="p-4 mb-6 text-rose-800 bg-rose-50 border border-rose-200 rounded-2xl text-xs font-bold space-y-1">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <p>• <?php echo e($error); ?></p>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>

        <form action="<?php echo e(route('account.profile.update')); ?>" method="POST" class="space-y-6">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <!-- General Info -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs font-bold">
                <div x-data="{ hasEnglish: false }">
                    <label class="block mb-1.5 text-zinc-700">
                        نام و نام خانوادگی *
                        <span class="text-[10px] text-zinc-400 font-normal">(فقط حروف فارسی)</span>
                    </label>
                    <input type="text" name="name" value="<?php echo e(old('name', $user->name)); ?>" required
                           placeholder="مثال: علی رضایی"
                           @input="hasEnglish = /[a-zA-Z]/.test($event.target.value)"
                           class="w-full px-4 py-2.5 bg-zinc-50 border border-zinc-200 rounded-xl focus:bg-white focus:outline-none focus:border-zinc-400">
                    <p x-show="hasEnglish" style="display: none;" class="text-amber-600 text-[10px] mt-1 font-medium flex items-center gap-1">
                        <i class="fa-solid fa-triangle-exclamation"></i> لطفاً کیبورد خود را به فارسی تغییر دهید. نوشتن نام انگلیسی مجاز نیست.
                    </p>
                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-rose-600 text-[10px] mt-1 block"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label class="block mb-1.5 text-zinc-700">آدرس ایمیل *</label>
                    <input type="email" name="email" value="<?php echo e(old('email', $user->email)); ?>" required
                           class="w-full px-4 py-2.5 bg-zinc-50 border border-zinc-200 rounded-xl focus:bg-white focus:outline-none focus:border-zinc-400 font-mono">
                </div>

                <div class="sm:col-span-2">
                    <label class="block mb-1.5 text-zinc-700">شماره همراه</label>
                    <input type="text" name="phone" value="<?php echo e(old('phone', $user->phone)); ?>" placeholder="مثال: 09123456789"
                           class="w-full px-4 py-2.5 bg-zinc-50 border border-zinc-200 rounded-xl focus:bg-white focus:outline-none focus:border-zinc-400 font-mono">
                </div>
            </div>

            <!-- Password Change Section -->
            <div class="pt-6 border-t border-zinc-100">
                <h3 class="text-xs font-black text-zinc-900 mb-1">تغییر رمز عبور</h3>
                <p class="text-[11px] text-zinc-400 mb-4">تنها در صورتی که مایل به تغییر رمز عبور هستید، فیلدهای زیر را پر کنید.</p>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs font-bold">
                    <div>
                        <label class="block mb-1.5 text-zinc-700">رمز عبور فعلی</label>
                        <input type="password" name="current_password"
                               class="w-full px-4 py-2.5 bg-zinc-50 border border-zinc-200 rounded-xl focus:bg-white focus:outline-none focus:border-zinc-400">
                    </div>

                    <div>
                        <label class="block mb-1.5 text-zinc-700">رمز عبور جدید</label>
                        <input type="password" name="new_password"
                               class="w-full px-4 py-2.5 bg-zinc-50 border border-zinc-200 rounded-xl focus:bg-white focus:outline-none focus:border-zinc-400">
                    </div>

                    <div>
                        <label class="block mb-1.5 text-zinc-700">تکرار رمز عبور جدید</label>
                        <input type="password" name="new_password_confirmation"
                               class="w-full px-4 py-2.5 bg-zinc-50 border border-zinc-200 rounded-xl focus:bg-white focus:outline-none focus:border-zinc-400">
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-4 border-t border-zinc-100 flex items-center justify-end">
                <button type="submit" class="px-6 py-3 bg-black hover:bg-[#ef394e] text-white font-black text-xs rounded-xl shadow transition duration-300">
                    ذخیره تغییرات مشخصات
                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('account.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/account/profile.blade.php ENDPATH**/ ?>