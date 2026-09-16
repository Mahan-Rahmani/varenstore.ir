<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Models\Order;
use App\Services\CartService;
use App\Services\CheckoutService;
use App\Services\CouponService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function __construct(
        protected CartService $cartService,
        protected CouponService $couponService,
        protected CheckoutService $checkoutService
    ) {}

    public function index()
    {
        $cartItems = $this->cartService->getCart();

        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'سبد خرید شما خالی است.');
        }

        $subtotal = $this->cartService->getSubtotal();
        $appliedCoupon = $this->couponService->getAppliedCoupon();
        $discount = $appliedCoupon['discount'] ?? 0;
        $shipping = ($subtotal >= config('shop.free_shipping_threshold', 500000)) ? 0 : config('shop.shipping_cost', 49000);
        $tax = round(($subtotal - $discount) * config('shop.tax_rate', 0.0), 2);
        $grandTotal = max(0, $subtotal - $discount + $shipping + $tax);

        $user = Auth::user();

        return view('shop.checkout', compact(
            'cartItems', 'subtotal', 'appliedCoupon', 'discount', 'shipping', 'tax', 'grandTotal', 'user'
        ));
    }

    public function store(CheckoutRequest $request)
    {
        $userId = Auth::id();
        $result = $this->checkoutService->processCheckout($request->validated(), $userId);

        if (!$result['success']) {
            return back()->with('error', $result['message'])->withInput();
        }

        $paymentResult = $result['payment_result'];

        if ($paymentResult->redirectUrl) {
            return redirect()->away($paymentResult->redirectUrl);
        }

        return redirect()->route('checkout.success', ['order' => $result['order']->order_number]);
    }

    public function callback(Request $request, Order $order)
    {
        $result = $this->checkoutService->handlePaymentCallback($order, $request);

        if ($result->successful) {
            return redirect()->route('checkout.success', ['order' => $order->order_number])
                ->with('success', 'پرداخت با موفقیت انجام و تایید شد. شماره پیگیری: ' . ($result->transactionReference ?? ''));
        }

        return redirect()->route('cart.index')
            ->with('error', 'پرداخت ناموفق بود یا توسط شما لغو شد: ' . ($result->message ?? ''));
    }

    public function success(string $orderNumber)
    {
        $order = Order::with('items')->where('order_number', $orderNumber)->firstOrFail();
        return view('shop.success', compact('order'));
    }
}
