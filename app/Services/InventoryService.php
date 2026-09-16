<?php

namespace App\Services;

use App\Models\Product;
use Exception;

class InventoryService
{
    public function verifyAvailability(array $cartItems): array
    {
        $errors = [];

        foreach ($cartItems as $item) {
            $product = Product::find($item['id']);
            if (!$product) {
                $errors[] = "Product '{$item['name']}' is no longer available.";
                continue;
            }

            if ($product->stock < $item['quantity']) {
                $errors[] = "Insufficient stock for '{$product->name}'. Available: {$product->stock}, Requested: {$item['quantity']}.";
            }
        }

        return $errors;
    }

    public function deductStock(array $cartItems): void
    {
        foreach ($cartItems as $item) {
            $product = Product::lockForUpdate()->find($item['id']);
            if ($product) {
                if ($product->stock < $item['quantity']) {
                    throw new Exception("Product {$product->name} does not have enough stock.");
                }
                $product->decrement('stock', $item['quantity']);
            }
        }
    }

    public function restoreStock(\App\Models\Order $order): void
    {
        foreach ($order->items as $item) {
            if ($item->product_id) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->increment('stock', $item->quantity);
                }
            }
        }
    }
}
