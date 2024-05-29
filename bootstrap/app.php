<?php

use App\Console\Commands\MakePhpUnitTest;
use App\Http\Middleware\AdminAccessMiddleware;
use App\Http\Middleware\OrdersAccessMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->statefulApi();
        $middleware->alias([
            "admin-access" => AdminAccessMiddleware::class,
            "orders-access" => OrdersAccessMiddleware::class,
        ]);
    })
    ->withCommands([
        MakePhpUnitTest::class,
    ])
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
