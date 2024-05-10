<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class OrderItemService
{
    public function store(int $orderId, array $data): Model|Builder
    {
        return Order::findOrFail($orderId)->order_items()->create($data);
    }

    public function update(int $id, array $data): Model|Builder
    {
        $orderItem = OrderItem::findOrFail($id);
        $orderItem->update($data);
        return $orderItem;
    }

    public function delete(int $id): string
    {
        $orderItem = OrderItem::findOrFail($id);
        $name = $orderItem->name;
        $orderItem->delete();
        return $name;
    }
}
