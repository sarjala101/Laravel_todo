<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;

use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\SkillController;
use App\Http\Controllers\Api\AchievementController;
use App\Http\Controllers\Api\CourseworkController;
use App\Http\Controllers\Api\InterestController;


/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


/*
|--------------------------------------------------------------------------
| User Profile Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    //profile
    Route::get('/user/profile', [ProfileController::class, 'show']);
    Route::put('/user/profile', [ProfileController::class, 'update']);

    Route::get('/user/projects', [ProjectController::class, 'index']);
    Route::post('/user/projects', [ProjectController::class, 'store']);
    Route::put('/user/projects/{id}', [ProjectController::class, 'update']);
    Route::delete('/user/projects/{id}', [ProjectController::class, 'destroy']);

    Route::get('/user/skills', [SkillController::class, 'index']);
    Route::post('/user/skills', [SkillController::class, 'store']);
    Route::put('/user/skills/{id}', [SkillController::class, 'update']);
    Route::delete('/user/skills/{id}', [SkillController::class, 'destroy']);

    Route::get('/user/achievements', [AchievementController::class, 'index']);
    Route::post('/user/achievements', [AchievementController::class, 'store']);
    Route::put('/user/achievements/{id}', [AchievementController::class, 'update']);
    Route::delete('/user/achievements/{id}', [AchievementController::class, 'destroy']);

    Route::get('/user/courseworks', [CourseworkController::class, 'index']);
    Route::post('/user/courseworks', [CourseworkController::class, 'store']);
    Route::put('/user/courseworks/{id}', [CourseworkController::class, 'update']);
    Route::delete('/user/courseworks/{id}', [CourseworkController::class, 'destroy']);

    Route::get('/user/interests', [InterestController::class, 'index']);
    Route::post('/user/interests', [InterestController::class, 'store']);
    Route::put('/user/interests/{id}', [InterestController::class, 'update']);
    Route::delete('/user/interests/{id}', [InterestController::class, 'destroy']);

});