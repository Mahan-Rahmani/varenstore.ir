<?php

namespace App\Services\Payment;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MockGateway implements GatewayInterface
{
    public function requestPayment(Order $order, string $callbackUrl): PaymentResult
    {
        $mockRef = 'MOCK-' . strtoupper(Str::random(12));
        
        // Return direct success for simulation
        $separator = str_contains($callbackUrl, '?') ? '&' : '?';
        $redirectUrl = $callbackUrl . $separator . 'mock_ref=' . $mockRef . '&status=OK';

        return new PaymentResult(
            successful: true,
            redirectUrl: $redirectUrl,
            transactionReference: $mockRef,
            message: 'Direct sandbox gateway simulated.'
        );
    }

    public function verifyPayment(Request $request, Order $order): PaymentResult
    {
        $status = $request->query('status', 'OK');
        $ref = $request->query('mock_ref', 'MOCK-VERIFIED-' . strtoupper(Str::random(8)));

        if ($status === 'OK') {
            return new PaymentResult(
                successful: true,
                transactionReference: $ref,
                message: 'Mock payment verified successfully.',
                rawResponse: ['status' => 'OK', 'ref' => $ref]
            );
        }

        return new PaymentResult(
            successful: false,
            message: 'Mock payment failed or was cancelled.',
            rawResponse: ['status' => $status]
        );
    }
}
