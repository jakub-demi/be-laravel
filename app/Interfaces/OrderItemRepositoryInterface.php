<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface OrderItemRepositoryInterface
{
    public function getAllByOrderId(int $orderId): Collection;

    public function getById(int $id): Model|Collection|Builder|array|null;
}
