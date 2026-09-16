<?php

return [
    'currency' => env('SHOP_CURRENCY', 'IRT'),
    'currency_symbol' => env('SHOP_CURRENCY_SYMBOL', 'تومان'),
    'shipping_cost' => env('SHOP_SHIPPING_COST', 49000), // 49,000 Tomans
    'free_shipping_threshold' => env('SHOP_FREE_SHIPPING_THRESHOLD', 500000), // Free shipping above 500,000 Tomans
    'tax_rate' => env('SHOP_TAX_RATE', 0.0), // 0% separate tax for Iranian retail

    'payment' => [
        'default' => env('PAYMENT_GATEWAY', 'zarinpal'),
        'gateways' => [
            'zarinpal' => [
                'name' => 'درگاه پرداخت اینترنتی زرین‌پال',
                'merchant_id' => env('ZARINPAL_MERCHANT_ID', '00000000-0000-0000-0000-000000000000'),
                'sandbox' => env('ZARINPAL_SANDBOX', true),
            ],
            'mock' => [
                'name' => 'پرداخت تستی و شبیه‌ساز بانکی',
            ],
        ],
    ],
];
