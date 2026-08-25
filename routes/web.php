<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/todo', [TodoController::class, 'index']);

Route::post('/todo', [TodoController::class, 'store']);

Route::get('/todo/{id}/edit', [TodoController::class, 'edit']);

Route::put('/todo/{id}', [TodoController::class, 'update']);

Route::delete('/todo/{id}', [TodoController::class, 'destroy']);