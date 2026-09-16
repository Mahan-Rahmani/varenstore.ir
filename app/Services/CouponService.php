<?php

namespace App\Services;

use App\Models\Coupon;
use Illuminate\Support\Facades\Session;

class CouponService
{
    private const SESSION_KEY = 'applied_coupon';

    public function apply(string $code, float $subtotal): array
    {
        $coupon = Coupon::where('code', strtoupper(trim($code)))->first();

        if (!$coupon) {
            return [
                'success' => false,
                'message' => 'Invalid coupon code.',
            ];
        }

        if (!$coupon->isValidForAmount($subtotal)) {
            $msg = 'Coupon cannot be applied.';
            if ($coupon->min_order_amount && $subtotal < $coupon->min_order_amount) {
                $msg = sprintf('Minimum order amount for this coupon is $%s.', number_format($coupon->min_order_amount, 2));
            } elseif ($coupon->expires_at && now()->greaterThan($coupon->expires_at)) {
                $msg = 'Coupon has expired.';
            } elseif ($coupon->usage_limit && $coupon->used_count >= $coupon->usage_limit) {
                $msg = 'Coupon usage limit has been reached.';
            }

            return [
                'success' => false,
                'message' => $msg,
            ];
        }

        $discount = $coupon->calculateDiscount($subtotal);

        Session::put(self::SESSION_KEY, [
            'id' => $coupon->id,
            'code' => $coupon->code,
            'discount' => $discount,
        ]);

        return [
            'success' => true,
            'message' => 'Coupon applied successfully!',
            'discount' => $discount,
            'coupon' => $coupon,
        ];
    }

    public function getAppliedCoupon(): ?array
    {
        return Session::get(self::SESSION_KEY);
    }

    public function remove(): void
    {
        Session::forget(self::SESSION_KEY);
    }

    public function recordUsage(string $couponCode): void
    {
        $coupon = Coupon::where('code', $couponCode)->first();
        if ($coupon) {
            $coupon->increment('used_count');
        }
    }
}
