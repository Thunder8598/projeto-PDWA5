<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::controller(AuthController::class)->group(function () {
    Route::post("/auth", "create");
    Route::delete("/auth", "destroy");
});
