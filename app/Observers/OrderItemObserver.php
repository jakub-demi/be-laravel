<?php

namespace App\Observers;

use App\Models\OrderItem;

class OrderItemObserver
{
    /**
     * Handle the OrderItem "creating" event.
     */
    public function creating(OrderItem $orderItem): void
    {
        $orderItem->cost_with_vat = $orderItem->vat ? $orderItem->cost + ($orderItem->cost * $orderItem->vat) : $orderItem->cost;
    }

    /**
     * Handle the OrderItem "updating" event.
     */
    public function updating(OrderItem $orderItem): void
    {
        $orderItem->cost_with_vat = $orderItem->vat ? $orderItem->cost + ($orderItem->cost * $orderItem->vat) : $orderItem->cost;
    }
}
