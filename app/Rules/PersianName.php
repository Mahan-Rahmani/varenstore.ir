<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PersianName implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_string($value)) {
            $fail('مقدار وارد شده برای نام باید متن باشد.');
            return;
        }

        $trimmed = trim($value);

        // Check if contains any English/Latin letters
        if (preg_match('/[a-zA-Z]/', $trimmed)) {
            $fail('نام و نام خانوادگی باید فقط به زبان فارسی نوشته شود و استفاده از حروف انگلیسی مجاز نیست.');
            return;
        }

        // Check if contains digits (English or Persian/Arabic numbers)
        if (preg_match('/[0-9\x{0660}-\x{0669}\x{06F0}-\x{06F9}]/u', $trimmed)) {
            $fail('نام و نام خانوادگی نمی‌تواند شامل اعداد یا ارقام باشد.');
            return;
        }

        // Must only contain Persian/Arabic alphabet letters, spaces and half-spaces (ZWNJ)
        $persianAlphabetPattern = '/^[\x{0621}-\x{0628}\x{062A}-\x{063A}\x{0641}-\x{0642}\x{0644}-\x{0648}\x{064E}-\x{0652}\x{0670}\x{067E}\x{0686}\x{0698}\x{06A9}\x{06AF}\x{06BE}\x{06CC}\x{200C}\s]+$/u';

        if (!preg_match($persianAlphabetPattern, $trimmed)) {
            $fail('نام و نام خانوادگی فقط باید شامل حروف الفبای فارسی باشد.');
            return;
        }

        // Minimum length check
        if (mb_strlen($trimmed) < 3) {
            $fail('نام و نام خانوادگی باید حداقل شامل ۳ حرف باشد.');
        }
    }
}
