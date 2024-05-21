<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface OrderRepositoryInterface
{
    public function getAll(): Collection;

    public function getById(int $id): Model|Builder|null;

    public function getStatusHistories(int $id): Collection|array|null;
}
