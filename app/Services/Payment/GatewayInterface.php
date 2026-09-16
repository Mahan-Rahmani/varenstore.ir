<?php

namespace App\Services\Payment;

use App\Models\Order;
use Illuminate\Http\Request;

interface GatewayInterface
{
    /**
     * Initiate payment transaction for order.
     */
    public function requestPayment(Order $order, string $callbackUrl): PaymentResult;

    /**
     * Verify payment status on return from gateway callback.
     */
    public function verifyPayment(Request $request, Order $order): PaymentResult;
}
