<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::middleware('guest')->group(function () {
    Route::get('/todo', function () {
        return view('tasks'); // подключение вашего шаблона
    });
});
