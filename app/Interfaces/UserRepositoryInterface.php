<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface UserRepositoryInterface
{
    /**
     * Get all users.
    */
    public function getAll(): Collection;

    /**
     * Get specific user by user $id.
     * @param int $id
    */
    public function getById(int $id): Model|Collection|Builder|array|null;
}
