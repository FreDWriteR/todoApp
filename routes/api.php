<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::middleware('guest')->group(function () {
    Route::apiResource('tasks', TaskController::class);

    Route::post('tasks/{task}', [TaskController::class, 'update']);

    Route::post('tasks/{task}/delete', [TaskController::class, 'destroy']);
});
