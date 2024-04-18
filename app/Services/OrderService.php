<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class OrderService
{
    public function store(array $data): Model|Builder
    {
        return Order::create($data);
    }

    public function update(int $id, array $data)
    {
        return Order::where("id", "=", $id)->update($data);
    }

    public function delete(int $id): int
    {
        $order = Order::query()->where("id", "=", $id);
        $orderNumber = $order->order_number;
        $order->delete();
        return $orderNumber;
    }
}
