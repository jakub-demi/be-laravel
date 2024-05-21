<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Models\OrderStatusHistory;

class OrderStatusHistoryService
{
    public function changeStatus(int $orderId, string $status): void
    {
        OrderStatusHistory::create([
            "order_id" => $orderId,
            "user_id" => auth()->user()->id,
            "status" => $status,
        ]);
    }
}
