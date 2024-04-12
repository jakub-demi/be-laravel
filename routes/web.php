<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get("/login", function() {
    return redirect()->away(env("SPA_URL") . "/login");
})->name("login");
