<?php

namespace App\Repositories;

use App\Interfaces\OrderRepositoryInterface;
use App\Models\Order;
use App\Models\OrderStatusHistory;
use App\Services\CacheService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class OrderRepository implements OrderRepositoryInterface
{
    public function getAll(): Collection
    {
        return Order::all();
    }

    public function getById(int $id): Model|Builder|null
    {
        return Order::where("id", "=", $id)->first();
    }

    public function getStatusHistories(int $id): Collection|array|null
    {
        $statusHistories = Order::find($id)?->status_histories()->latest()->get();
        $cacheKey = Order::class . ".specific.$id." . OrderStatusHistory::class . ".all";
        CacheService::cacheCollection($cacheKey, $statusHistories);
        return cache($cacheKey);
    }
}
