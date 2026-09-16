<?php

namespace App\Services\Payment;

use InvalidArgumentException;

class PaymentManager
{
    public function getGateway(?string $driver = null): GatewayInterface
    {
        $driver = $driver ?: config('shop.payment.default', 'mock');

        return match ($driver) {
            'mock' => new MockGateway(),
            'zarinpal' => new ZarinpalGateway(),
            default => throw new InvalidArgumentException("Unsupported payment driver: {$driver}"),
        };
    }
}
