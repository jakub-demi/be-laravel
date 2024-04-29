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
        return Order::find($orderId)->order_items()->create($data);
    }

    public function update(int $id, array $data): Model|Builder
    {
        $orderItem = OrderItem::find($id);
        $orderItem->update($data);
        return $orderItem->first();
    }

    public function delete(int $id): string
    {
        $orderItem = OrderItem::find($id);
        $name = $orderItem->name;
        $orderItem->delete();
        return $name;
    }
}
