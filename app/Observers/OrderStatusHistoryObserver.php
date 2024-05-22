<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\OrderStatusHistory;

class OrderStatusHistoryObserver
{
    /**
     * Handle the OrderStatusHistory "created" event.
     */
    public function created(OrderStatusHistory $statusHistory): void
    {
        $cacheKey = Order::class . ".specific.{$statusHistory->order_id}." . OrderStatusHistory::class . ".all";
        cache()->forget($cacheKey);
    }
}
