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
    Route::apiResource("orders", OrderController::class);

    //! Order Items
    Route::get("/order-items/{orderId}", [OrderItemController::class, "index"])->name("order-items.index");
    Route::post("/order-items/{orderId}", [OrderItemController::class, "store"])->name("order-items.store");
    Route::apiResource("order-items", OrderItemController::class)->only(["show", "update", "destroy"]);
});
