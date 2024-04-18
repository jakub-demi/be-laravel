<?php

namespace App\Providers;

use App\Interfaces\OrderRepositoryInterface;
use App\OrderRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public array $bindings = [
        OrderRepository::class => OrderRepositoryInterface::class,
    ];

    public function register(): void
    {
        $this->bindRepositories();
    }

    private function bindRepositories(): void
    {
        foreach ($this->bindings as $repository => $interface) {
            $this->app->bind($interface, $repository);
        }
    }
}
