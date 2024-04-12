<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public array $bindings = [
        //
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
