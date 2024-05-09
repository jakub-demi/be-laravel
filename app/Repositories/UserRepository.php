<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\Order;
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

    public function getUserAvatar(User $user): ?string
    {
        $avatar = $user->images()->where("type", "=", "profile-avatar")->first();
        return $avatar ? env("APP_URL") . $avatar->image : null;
    }

    public function getUsersAvatarsForOrder(Order $order): array
    {
        $users = $order->users()->get();
        $avatars = [];

        foreach($users as $user) {
            $avatars = $user->images()->where("type", "=", "profile-avatar")->first();
        }

        return $avatars;
    }
}
