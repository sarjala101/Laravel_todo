<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TodoController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ForgetPasswordManager;

use Livewire\Volt\Volt;

/*
|--------------------------------------------------------------------------
| Livewire Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {

    Volt::route('/livewire-login', 'login')
        ->name('livewire.login');

    Volt::route('/livewire-register', 'register')
        ->name('livewire.register');

    Volt::route('/livewire-forgot-password', 'forgot-password')
        ->name('password.request');

    Volt::route('/livewire-reset-password/{token}', 'reset-password')
        ->name('password.reset');

});

Route::middleware('auth')->group(function () {

    Volt::route('/livewire-todo', 'todo-list')
        ->name('livewire.todo');

    Volt::route('/livewire-todo/{todo}', 'todo-show')
        ->name('livewire.todo.show');

    Volt::route('/livewire-todo/{todo}/edit', 'todo-edit')
        ->name('livewire.todo.edit');

    Volt::route('/livewire-account', 'account')
        ->name('livewire.account');

});

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});


/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Route::get('/login', [LoginController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [LoginController::class, 'login'])
    ->name('login.submit');

Route::get('/register', [RegisterController::class, 'showRegister'])
    ->name('register');

Route::post('/register', [RegisterController::class, 'register'])
    ->name('register.submit');

Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout');


/*
|--------------------------------------------------------------------------
| Forgot Password Routes
|--------------------------------------------------------------------------
*/

Route::get('/forgot-password', [ForgetPasswordManager::class, 'forgetPassword'])
    ->name('password.request');

Route::post('/forgot-password', [ForgetPasswordManager::class, 'sendResetLink'])
    ->name('password.email');

Route::get('/reset-password/{token}', [ForgetPasswordManager::class, 'resetPassword'])
    ->name('password.reset');

Route::post('/reset-password', [ForgetPasswordManager::class, 'updatePassword'])
    ->name('password.update');


/*
|--------------------------------------------------------------------------
| Todo Routes
|--------------------------------------------------------------------------
*/

            Route::middleware('auth')->group(function () {

    Route::get('/todo', [TodoController::class, 'index'])
        ->name('todo.index');

    Route::post('/todo', [TodoController::class, 'store'])
        ->name('todo.store');

    Route::get('/todo/{id}', [TodoController::class, 'show'])
        ->name('todo.show');

    Route::get('/todo/{id}/edit', [TodoController::class, 'edit'])
        ->name('todo.edit');

    Route::put('/todo/{id}', [TodoController::class, 'update'])
        ->name('todo.update');

    Route::patch('/todo/{id}/complete', [TodoController::class, 'complete'])
        ->name('todo.complete');

    Route::delete('/todo/{id}', [TodoController::class, 'destroy'])
        ->name('todo.destroy');

    Route::get('/account', function () {
        return view('account');
    })->name('account');
});



//temporary
// use Illuminate\Support\Facades\Mail;

// Route::get('/test-mail', function () {

//     Mail::raw(
//         'This is a test email from my Laravel Todo application.',
//         function ($message) {
//             $message->to('test@example.com')
//                     ->subject('Laravel Mailtrap Test');
//         }
//     );

//     return 'Test email sent!';
// });