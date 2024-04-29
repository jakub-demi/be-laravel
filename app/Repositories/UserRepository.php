<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class UserRepository implements UserRepositoryInterface
{

    public function getAll(): Collection
    {
        return User::all();
    }

    public function getById(int $id): Model|Collection|Builder|array|null
    {
        return User::find($id);
    }
}
