<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use App\Services\CouponService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(
        protected CartService $cartService,
        protected CouponService $couponService
    ) {}

    public function index()
    {
        $cartItems = $this->cartService->getCart();
        $subtotal = $this->cartService->getSubtotal();
        $appliedCoupon = $this->couponService->getAppliedCoupon();

        $discount = $appliedCoupon['discount'] ?? 0;
        $tax = round(($subtotal - $discount) * config('shop.tax_rate', 0.09), 2);
        $shipping = ($subtotal >= config('shop.free_shipping_threshold', 100)) ? 0 : config('shop.shipping_cost', 15);
        $grandTotal = max(0, $subtotal - $discount + $tax + $shipping);

        return view('shop.cart', compact('cartItems', 'subtotal', 'appliedCoupon', 'discount', 'tax', 'shipping', 'grandTotal'));
    }

    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => ['nullable', 'integer', 'min:1'],
            'attributes' => ['nullable', 'array'],
            'size' => ['nullable', 'string'],
            'color' => ['nullable', 'string'],
        ]);

        $quantity = $request->input('quantity', 1);
        $attributes = $request->input('attributes', []);

        if ($request->filled('size')) {
            $attributes['سایز'] = $request->input('size');
        }
        if ($request->filled('color')) {
            $attributes['رنگ'] = $request->input('color');
        }

        $success = $this->cartService->add($product, $quantity, $attributes);

        if (!$success) {
            return back()->with('error', 'موجودی انبار برای این تعداد کافی نیست.');
        }

        return redirect()->route('cart.index')->with('success', 'محصول با مشخصات انتخابی به سبد خرید اضافه شد.');
    }

    public function update(Request $request, string $key)
    {
        $request->validate([
            'quantity' => ['required', 'integer', 'min:0'],
        ]);

        $success = $this->cartService->update($key, $request->input('quantity'));

        if (!$success) {
            return back()->with('error', 'Could not update quantity. Not enough stock available.');
        }

        return back()->with('success', 'Cart updated successfully.');
    }

    public function remove(string $key)
    {
        $this->cartService->remove($key);
        return back()->with('success', 'Item removed from cart.');
    }

    public function applyCoupon(Request $request)
    {
        $request->validate(['code' => 'required|string']);

        $subtotal = $this->cartService->getSubtotal();
        $result = $this->couponService->apply($request->input('code'), $subtotal);

        if ($result['success']) {
            return back()->with('success', $result['message']);
        }

        return back()->with('error', $result['message']);
    }

    public function removeCoupon()
    {
        $this->couponService->remove();
        return back()->with('success', 'Coupon removed successfully.');
    }
}
