<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get("/login", function() {
    return redirect()->away(env("SPA_URL") . "/login");
})->name("login");


//todo:dev remove
Route::get("/t", function () {
    dd(App\Models\Order::find(5)->order_items()->get());
});

Route::get("/t2/{orderId}", [App\Http\Controllers\OrderItemController::class, "index"]);
