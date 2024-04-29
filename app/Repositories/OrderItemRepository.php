<?php

namespace App\Repositories;

use App\Interfaces\OrderItemRepositoryInterface;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class OrderItemRepository implements OrderItemRepositoryInterface
{
    public function getAllByOrderId(int $orderId): Collection
    {
        return Order::find($orderId)->order_items()->get();
    }

    public function getById(int $id): Model|Collection|Builder|array|null
    {
        return OrderItem::find($id);
    }
}
