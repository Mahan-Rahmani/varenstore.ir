<?php

namespace Database\Seeders;

use App\Enums\CouponType;
use App\Models\Coupon;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    public function run(): void
    {
        // 10% OFF coupon
        Coupon::create([
            'code' => 'WELCOME10',
            'type' => CouponType::PERCENTAGE,
            'value' => 10.00,
            'min_order_amount' => 50.00,
            'max_discount_amount' => 100.00,
            'usage_limit' => 100,
            'used_count' => 0,
            'expires_at' => now()->addMonths(6),
            'is_active' => true,
        ]);

        // $50 Fixed discount coupon
        Coupon::create([
            'code' => 'PARSPACK50',
            'type' => CouponType::FIXED,
            'value' => 50.00,
            'min_order_amount' => 300.00,
            'max_discount_amount' => null,
            'usage_limit' => 50,
            'used_count' => 0,
            'expires_at' => now()->addMonths(3),
            'is_active' => true,
        ]);
    }
}
