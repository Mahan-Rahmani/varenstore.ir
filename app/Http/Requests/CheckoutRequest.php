<?php

namespace App\Http\Requests;

use App\Rules\PersianName;
use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_name' => ['required', 'string', 'max:255', new PersianName()],
            'customer_phone' => ['required', 'string', 'regex:/^09[0-9]{9}$/'],
            'customer_email' => ['nullable', 'email', 'max:255'],
            'shipping_address' => ['required', 'string', 'max:500'],
            'city' => ['required', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'postal_code' => ['required', 'string', 'max:20'],
            'order_notes' => ['nullable', 'string', 'max:1000'],
            'payment_method' => ['required', 'string', 'in:mock,zarinpal'],
        ];
    }

    public function messages(): array
    {
        return [
            'customer_name.required' => 'نام و نام خانوادگی تحویل‌گیرنده الزامی است.',
            'customer_phone.required' => 'شماره همراه تحویل‌گیرنده الزامی است.',
            'customer_phone.regex' => 'شماره همراه باید ۱۱ رقم بوده و با ۰۹ شروع شود.',
            'customer_email.email' => 'فرمت نشانی ایمیل وارد شده معتبر نیست.',
            'shipping_address.required' => 'نشانی دقیق پستی تحویل‌گیرنده الزامی است.',
            'city.required' => 'نام شهر الزامی است.',
            'postal_code.required' => 'کد پستی ۱۰ رقمی الزامی است.',
            'payment_method.required' => 'انتخاب درگاه پرداخت الزامی است.',
        ];
    }
}
