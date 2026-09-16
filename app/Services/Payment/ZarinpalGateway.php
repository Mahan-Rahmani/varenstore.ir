<?php

namespace App\Services\Payment;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ZarinpalGateway implements GatewayInterface
{
    private string $merchantId;
    private bool $isSandbox;
    private string $requestUrl;
    private string $paymentUrl;
    private string $verifyUrl;

    public function __construct()
    {
        $this->merchantId = config('shop.payment.gateways.zarinpal.merchant_id', '00000000-0000-0000-0000-000000000000');
        $this->isSandbox = (bool) config('shop.payment.gateways.zarinpal.sandbox', true);

        $baseUrl = $this->isSandbox ? 'https://sandbox.zarinpal.com/pg' : 'https://api.zarinpal.com/pg';
        $webUrl = $this->isSandbox ? 'https://sandbox.zarinpal.com/pg' : 'https://www.zarinpal.com/pg';

        $this->requestUrl = $baseUrl . '/v4/payment/request.json';
        $this->paymentUrl = $webUrl . '/StartPay/';
        $this->verifyUrl  = $baseUrl . '/v4/payment/verify.json';
    }

    public function requestPayment(Order $order, string $callbackUrl): PaymentResult
    {
        // ZarinPal expects amount in Tomans (1 Toman = 10 Rials)
        $amountInTomans = (int) $order->grand_total;

        $response = Http::timeout(15)->post($this->requestUrl, [
            'merchant_id' => $this->merchantId,
            'amount' => $amountInTomans,
            'description' => "Order #{$order->order_number} payment",
            'callback_url' => $callbackUrl,
            'metadata' => [
                'email' => $order->customer_email,
                'mobile' => $order->customer_phone,
            ],
        ]);

        if ($response->successful()) {
            $data = $response->json();
            if (isset($data['data']['code']) && $data['data']['code'] == 100) {
                $authority = $data['data']['authority'];
                return new PaymentResult(
                    successful: true,
                    redirectUrl: $this->paymentUrl . $authority,
                    transactionReference: $authority,
                    message: 'Redirecting to ZarinPal gateway...',
                    rawResponse: $data
                );
            }

            return new PaymentResult(
                successful: false,
                message: $data['errors']['message'] ?? 'ZarinPal error: ' . json_encode($data['errors'] ?? []),
                rawResponse: $data
            );
        }

        return new PaymentResult(
            successful: false,
            message: 'Failed to communicate with ZarinPal payment gateway.'
        );
    }

    public function verifyPayment(Request $request, Order $order): PaymentResult
    {
        $authority = $request->query('Authority');
        $status = $request->query('Status');

        if (empty($authority)) {
            return new PaymentResult(
                successful: false,
                message: 'شناسه مرجع پرداخت (Authority) معتبر نمی‌باشد.',
                rawResponse: ['Status' => $status]
            );
        }

        if ($status !== 'OK') {
            return new PaymentResult(
                successful: false,
                message: 'پرداخت توسط کاربر لغو شد یا با خطا مواجه گردید.',
                rawResponse: ['Status' => $status, 'Authority' => $authority]
            );
        }

        $amountInTomans = (int) $order->grand_total;

        $response = Http::timeout(15)->post($this->verifyUrl, [
            'merchant_id' => $this->merchantId,
            'amount' => $amountInTomans,
            'authority' => $authority,
        ]);

        if ($response->successful()) {
            $data = $response->json();
            $code = $data['data']['code'] ?? 0;

            // 100 = verified, 101 = already verified
            if ($code == 100 || $code == 101) {
                $refId = (string)($data['data']['ref_id'] ?? $authority);
                $cardPan = $data['data']['card_pan'] ?? null;

                return new PaymentResult(
                    successful: true,
                    transactionReference: $refId,
                    cardPan: $cardPan,
                    message: 'تراکنش با موفقیت در زرین‌پال تایید شد.',
                    rawResponse: $data
                );
            }

            $errorMessage = $data['errors']['message'] ?? 'کد خطای زرین‌پال: ' . ($code ?: 'نامشخص');
            return new PaymentResult(
                successful: false,
                message: 'تایید پرداخت ناموفق بود: ' . $errorMessage,
                rawResponse: $data
            );
        }

        return new PaymentResult(
            successful: false,
            message: 'عدم پاسخگویی سرور تایید پرداخت زرین‌پال.',
            rawResponse: ['http_status' => $response->status(), 'body' => $response->body()]
        );
    }
}
