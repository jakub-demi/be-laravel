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
        $orderUsers = $this->handleOrderUsers($data);
        $order = Order::create($data);
        $order->users()->attach($orderUsers);
        return $order;
    }

    public function update(int $id, array $data): Model|Builder
    {
        $order = Order::findOrFail($id);
        $orderUsers = $this->handleOrderUsers($data);
        $order->update($data);
        $order->users()->sync($orderUsers);
        return $order;
    }

    public function delete(int $id): int
    {
        $order = Order::findOrFail($id);
        $orderNumber = $order->order_number;
        $order->users()->detach();
        $order->delete();
        return $orderNumber;
    }

    private function handleOrderUsers(array &$data): array
    {
        if (empty($data["order_users"])) return [];

        $orderUsers = $data["order_users"];
        unset($data["order_users"]);

        return $orderUsers;
    }
}
