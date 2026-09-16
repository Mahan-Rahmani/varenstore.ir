

<?php $__env->startSection('content'); ?>
<div class="max-w-md mx-auto px-4 py-16">
    <div class="bg-white rounded-3xl border border-zinc-200 p-8 shadow-sm">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-black text-black">ایجاد حساب کاربری</h1>
            <p class="text-xs text-zinc-500 mt-1">به خانواده وارِن بپیوندید</p>
        </div>

        <form action="<?php echo e(route('register')); ?>" method="POST" class="space-y-4 text-xs font-bold">
            <?php echo csrf_field(); ?>
            <div x-data="{ hasEnglish: false }">
                <label class="block text-zinc-700 mb-1">
                    نام و نام خانوادگی 
                    <span class="text-[10px] text-zinc-400 font-normal">(فقط حروف فارسی)</span>
                </label>
                <input type="text" name="name" value="<?php echo e(old('name')); ?>" required 
                       placeholder="مثال: علی رضایی"
                       @input="hasEnglish = /[a-zA-Z]/.test($event.target.value)"
                       class="w-full px-3 py-2.5 bg-zinc-50 border rounded-xl focus:outline-none focus:bg-white focus:border-zinc-400">
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
                <label class="block text-zinc-700 mb-1">
                    شماره همراه 
                    <span class="text-rose-500 font-bold">*</span>
                </label>
                <input type="tel" name="phone" value="<?php echo e(old('phone')); ?>" required 
                       placeholder="مثال: 09123456789"
                       dir="ltr"
                       class="w-full px-3 py-2.5 bg-zinc-50 border rounded-xl focus:outline-none focus:bg-white focus:border-zinc-400 font-mono text-left">
                <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-rose-600 text-[10px] mt-1 block"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div>
                <label class="block text-zinc-700 mb-1">
                    نشانی ایمیل 
                    <span class="text-[10px] text-zinc-400 font-normal">(اختیاری)</span>
                </label>
                <input type="email" name="email" value="<?php echo e(old('email')); ?>" 
                       placeholder="example@mail.com"
                       dir="ltr"
                       class="w-full px-3 py-2.5 bg-zinc-50 border rounded-xl focus:outline-none focus:bg-white focus:border-zinc-400 font-mono text-left">
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-rose-600 text-[10px] mt-1 block"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div>
                <label class="block text-zinc-700 mb-1">رمز عبور</label>
                <input type="password" name="password" required class="w-full px-3 py-2.5 bg-zinc-50 border rounded-xl focus:outline-none">
                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-rose-600 text-[10px] mt-1 block"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div>
                <label class="block text-zinc-700 mb-1">تکرار رمز عبور</label>
                <input type="password" name="password_confirmation" required class="w-full px-3 py-2.5 bg-zinc-50 border rounded-xl focus:outline-none">
            </div>

            <button type="submit" class="w-full py-3 bg-black hover:bg-[#ef394e] text-white font-black text-xs rounded-xl shadow transition">
                عضویت در وارِن
            </button>
        </form>

        <div class="mt-6 pt-6 border-t border-zinc-100 text-center text-xs font-bold text-zinc-500">
            قبلاً ثبت‌نام کرده‌اید؟ <a href="<?php echo e(route('login')); ?>" class="text-[#ef394e] hover:underline">ورود به حساب</a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/auth/register.blade.php ENDPATH**/ ?>