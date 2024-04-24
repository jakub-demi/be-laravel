<?php

namespace App\Observers;

use App\Models\Order;
use Illuminate\Support\Facades\Log;

class OrderObserver
{
    /**
     * Handle the Order "creating" event.
     */
    public function creating(Order $order): void
    {
        $order->order_number = static::generateOrderNumber();
    }

    protected static function generateOrderNumber(): int
    {
        $currentYear = date('Y');
        $lastOrder = Order::whereYear('created_at', $currentYear)->orderByDesc('id')->first();

        if (!$lastOrder) {
            $nextOrderNumber = 1;
        } else {
            $lastOrderNumber = (int)substr($lastOrder->order_number, -6);
            $nextOrderNumber = $lastOrderNumber + 1;
        }

        return (int)($currentYear . str_pad($nextOrderNumber, 6, '0', STR_PAD_LEFT));
    }
}
