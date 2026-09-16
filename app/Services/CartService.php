<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CartService
{
    private const SESSION_KEY = 'shopping_cart';

    public function getCart(): array
    {
        return Session::get(self::SESSION_KEY, []);
    }

    public function add(Product $product, int $quantity = 1, array $attributes = []): bool
    {
        $cart = $this->getCart();
        $key = $this->buildItemKey($product->id, $attributes);

        $currentQty = isset($cart[$key]) ? $cart[$key]['quantity'] : 0;
        $newQty = $currentQty + $quantity;

        if ($product->stock < $newQty) {
            return false; // Not enough stock
        }

        $unitPrice = $product->current_price;

        $cart[$key] = [
            'id' => $product->id,
            'sku' => $product->sku,
            'name' => $product->name,
            'slug' => $product->slug,
            'unit_price' => $unitPrice,
            'original_price' => (float)$product->price,
            'quantity' => $newQty,
            'image' => $product->featured_image,
            'attributes' => $attributes,
            'subtotal' => $unitPrice * $newQty,
        ];

        Session::put(self::SESSION_KEY, $cart);
        return true;
    }

    public function update(string $key, int $quantity): bool
    {
        $cart = $this->getCart();

        if (!isset($cart[$key])) {
            return false;
        }

        if ($quantity <= 0) {
            return $this->remove($key);
        }

        $product = Product::find($cart[$key]['id']);
        if (!$product || $product->stock < $quantity) {
            return false;
        }

        $cart[$key]['quantity'] = $quantity;
        $cart[$key]['subtotal'] = $cart[$key]['unit_price'] * $quantity;

        Session::put(self::SESSION_KEY, $cart);
        return true;
    }

    public function remove(string $key): bool
    {
        $cart = $this->getCart();

        if (isset($cart[$key])) {
            unset($cart[$key]);
            Session::put(self::SESSION_KEY, $cart);
            return true;
        }

        return false;
    }

    public function clear(): void
    {
        Session::forget(self::SESSION_KEY);
        Session::forget('applied_coupon');
    }

    public function getSubtotal(): float
    {
        $cart = $this->getCart();
        $subtotal = 0.0;
        foreach ($cart as $item) {
            $subtotal += $item['subtotal'];
        }
        return (float)$subtotal;
    }

    public function getItemsCount(): int
    {
        $cart = $this->getCart();
        $count = 0;
        foreach ($cart as $item) {
            $count += $item['quantity'];
        }
        return $count;
    }

    private function buildItemKey(int $productId, array $attributes): string
    {
        ksort($attributes);
        return md5($productId . '_' . serialize($attributes));
    }
}
