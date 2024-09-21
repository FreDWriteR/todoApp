<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::middleware('guest')->group(function () {
    Route::apiResource('tasks', TaskController::class);
});
