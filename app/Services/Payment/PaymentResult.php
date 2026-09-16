<?php

namespace App\Services\Payment;

class PaymentResult
{
    public function __construct(
        public bool $successful,
        public ?string $redirectUrl = null,
        public ?string $transactionReference = null,
        public ?string $cardPan = null,
        public ?string $message = null,
        public array $rawResponse = []
    ) {}
}

