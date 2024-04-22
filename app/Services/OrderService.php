<?php

namespace App\Services;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class OrderService
{
    public function store(array $data): Model|Builder
    {
        $data['due_date'] = Carbon::parse($data['due_date'])->toDateTimeString();
        return Order::create($data);
    }

    public function update(int $id, array $data)
    {
        return Order::where("id", "=", $id)->update($data);
    }

    public function delete(int $id): int
    {
        $order = Order::where("id", "=", $id)->first();
        $orderNumber = $order->order_number;
        $order->delete();
        return $orderNumber;
    }
}
