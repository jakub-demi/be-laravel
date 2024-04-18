<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware("auth:sanctum")->group(function () {
    Route::get("/user", [UserController::class, "user"]);

    Route::prefix("/user")->group(function () {
       Route::post("/update-profile", [UserController::class, "updateUserProfile"]);
    });
});
