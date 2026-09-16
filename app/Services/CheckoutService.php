<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentTransaction;
use App\Services\Payment\PaymentManager;
use App\Services\Payment\PaymentResult;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutService
{
    public function __construct(
        protected CartService $cartService,
        protected CouponService $couponService,
        protected InventoryService $inventoryService,
        protected PaymentManager $paymentManager
    ) {}

    public function processCheckout(array $data, ?int $userId = null): array
    {
        $cart = $this->cartService->getCart();
        if (empty($cart)) {
            return ['success' => false, 'message' => 'Your cart is empty.'];
        }

        $stockErrors = $this->inventoryService->verifyAvailability($cart);
        if (!empty($stockErrors)) {
            return ['success' => false, 'message' => implode(' ', $stockErrors)];
        }

        $subtotal = $this->cartService->getSubtotal();
        $appliedCoupon = $this->couponService->getAppliedCoupon();
        $discountAmount = $appliedCoupon['discount'] ?? 0.00;
        $couponCode = $appliedCoupon['code'] ?? null;

        $shippingFee = ($subtotal >= config('shop.free_shipping_threshold', 500000.00)) ? 0.00 : config('shop.shipping_cost', 49000.00);
        $taxableAmount = max(0, $subtotal - $discountAmount);
        $taxAmount = round($taxableAmount * config('shop.tax_rate', 0.0), 2);
        $grandTotal = round(max(0, $taxableAmount + $shippingFee + $taxAmount), 2);

        $orderNumber = 'ORD-' . strtoupper(Str::random(10));
        $paymentMethod = $data['payment_method'] ?? config('shop.payment.default', 'mock');

        DB::beginTransaction();
        try {
            $order = Order::create([
                'order_number' => $orderNumber,
                'user_id' => $userId,
                'customer_name' => $data['customer_name'],
                'customer_phone' => $data['customer_phone'],
                'customer_email' => !empty($data['customer_email']) ? $data['customer_email'] : null,
                'shipping_address' => $data['shipping_address'],
                'city' => $data['city'],
                'state' => $data['state'] ?? null,
                'postal_code' => $data['postal_code'],
                'order_notes' => $data['order_notes'] ?? null,
                'subtotal' => $subtotal,
                'discount_amount' => $discountAmount,
                'coupon_code' => $couponCode,
                'shipping_fee' => $shippingFee,
                'tax_amount' => $taxAmount,
                'grand_total' => $grandTotal,
                'status' => OrderStatus::PENDING,
                'payment_status' => PaymentStatus::UNPAID,
                'payment_method' => $paymentMethod,
            ]);

            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'product_name' => $item['name'],
                    'sku' => $item['sku'],
                    'unit_price' => $item['unit_price'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['subtotal'],
                    'attributes_snapshot' => $item['attributes'] ?? [],
                ]);
            }

            $this->inventoryService->deductStock($cart);
            if ($couponCode) {
                $this->couponService->recordUsage($couponCode);
            }
            $this->cartService->clear();

            DB::commit();

            $callbackUrl = route('checkout.callback', ['order' => $order->id]);
            $gateway = $this->paymentManager->getGateway($paymentMethod);
            $paymentResult = $gateway->requestPayment($order, $callbackUrl);

            PaymentTransaction::create([
                'order_id' => $order->id,
                'transaction_reference' => $paymentResult->transactionReference ?? 'TX-' . Str::random(12),
                'gateway' => $paymentMethod,
                'amount' => $order->grand_total,
                'status' => 'pending',
                'gateway_response' => $paymentResult->rawResponse,
            ]);

            return ['success' => true, 'order' => $order, 'payment_result' => $paymentResult];
        } catch (Exception $e) {
            DB::rollBack();
            return ['success' => false, 'message' => 'Checkout error: ' . $e->getMessage()];
        }
    }

    public function handlePaymentCallback(Order $order, $request): PaymentResult
    {
        $gateway = $this->paymentManager->getGateway($order->payment_method);
        $result = $gateway->verifyPayment($request, $order);
        $tx = $order->latestTransaction;

        if ($result->successful) {
            $order->update([
                'payment_status' => PaymentStatus::PAID,
                'status' => OrderStatus::PROCESSING,
            ]);

            if ($tx) {
                $tx->update([
                    'status' => 'success',
                    'transaction_reference' => $result->transactionReference ?? $tx->transaction_reference,
                    'card_pan_masked' => $result->cardPan ?? $tx->card_pan_masked,
                    'gateway_response' => $result->rawResponse,
                ]);
            }
        } else {
            // Strictly set to FAILED and preserve stock restoration or safety
            $order->update([
                'payment_status' => PaymentStatus::FAILED,
                'status' => OrderStatus::CANCELLED,
            ]);

            if ($tx) {
                $tx->update([
                    'status' => 'failed',
                    'gateway_response' => $result->rawResponse,
                ]);
            }
        }

        return $result;
    }
}
