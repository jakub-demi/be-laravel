<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class UserService
{
    public function store(array $data): Model|Builder
    {
        return User::create($data);
    }

    public function update(int $id, array $data): Collection|Model|null
    {
        $user = User::findOrFail($id);
        $user->update($data);
        return $user;
    }

    public function delete(int $id): string
    {
        $user = User::findOrFail($id);
        $userFullName = $user->full_name;
        $user->delete();
        return $userFullName;
    }
}
