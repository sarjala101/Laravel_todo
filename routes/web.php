<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;

Route::get('/', function () {
    return redirect('/');
});

Route::get('/todo', [TodoController::class, 'index']);

Route::post('/todo', [TodoController::class, 'store']);

Route::get('/todo/{id}', [TodoController::class, 'show']);

Route::get('/todo/{id}/edit', [TodoController::class, 'edit']);

Route::put('/todo/{id}', [TodoController::class, 'update']);

Route::patch('/todo/{id}/complete', [TodoController::class, 'complete']);

Route::delete('/todo/{id}', [TodoController::class, 'destroy']);