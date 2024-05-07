<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware("auth:sanctum")->group(function () {
    Route::get("/user", [UserController::class, "user"]);

    Route::prefix("/user")->group(function () {
       Route::post("/update-profile", [UserController::class, "updateUserProfile"]);
    });

    //! Orders
    Route::get("/orders", [OrderController::class, "index"])->name("orders.index");
    Route::get("/orders/{order}", [OrderController::class, "show"])->name("orders.show");

    Route::middleware("orders-access")->group(function () {
        Route::apiResource("orders", OrderController::class)->only(["store", "update", "destroy"]);

        //! Order Items
        Route::prefix("orders/{order}")->group(function () {
            Route::apiResource("order-items", OrderItemController::class);
        });
    });

    Route::get("/vat-rates", [OrderItemController::class, "vatRates"])->name("order-items.vat-rates");

    //! Users
    Route::apiResource("users", UserController::class);
});
