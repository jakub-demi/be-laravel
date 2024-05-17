<?php

namespace App\Providers;

use App\Interfaces\CategoryRepositoryInterface;
use App\Interfaces\OrderItemRepositoryInterface;
use App\Interfaces\OrderRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\CategoryRepository;
use App\Repositories\OrderItemRepository;
use App\Repositories\OrderRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public array $bindings = [
        OrderRepositoryInterface::class => OrderRepository::class,
        OrderItemRepositoryInterface::class => OrderItemRepository::class,
        UserRepositoryInterface::class => UserRepository::class,
        CategoryRepositoryInterface::class => CategoryRepository::class,
    ];

    public function register(): void
    {
        $this->bindRepositories();
    }

    private function bindRepositories(): void
    {
        foreach ($this->bindings as $interface => $repository) {
            $this->app->bind($interface, $repository);
        }
    }
}
