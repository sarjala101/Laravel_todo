<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TodoController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;


/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect('/login');
});


/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Route::get('/login', [LoginController::class, 'showLogin']);

Route::post('/login', [LoginController::class, 'login']);

Route::get('/register', [RegisterController::class, 'showRegister']);

Route::post('/register', [RegisterController::class, 'register']);

Route::post('/logout', [LoginController::class, 'logout']);


/*
|--------------------------------------------------------------------------
| Todo Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/todo', [TodoController::class, 'index']);

    Route::post('/todo', [TodoController::class, 'store']);

    Route::get('/todo/{id}', [TodoController::class, 'show']);

    Route::get('/todo/{id}/edit', [TodoController::class, 'edit']);

    Route::put('/todo/{id}', [TodoController::class, 'update']);

    Route::patch('/todo/{id}/complete', [TodoController::class, 'complete']);

    Route::delete('/todo/{id}', [TodoController::class, 'destroy']);

});

