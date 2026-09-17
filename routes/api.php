<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\AcademicQualificationController;
use App\Http\Controllers\Api\ExperienceController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\SkillController;
use App\Http\Controllers\Api\AchievementController;
use App\Http\Controllers\Api\CourseworkController;
use App\Http\Controllers\Api\InterestController;


/*
|--------------------------------------------------------------------------
| Authentication Routes (Unchanged)
|--------------------------------------------------------------------------
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/check-email', [AuthController::class, 'checkEmail']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


/*
|--------------------------------------------------------------------------
| User Profile & Related Collection Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    // General Profile
    Route::get('/user/profile', [ProfileController::class, 'show']);
    Route::put('/user/profile', [ProfileController::class, 'update']);

    // Academic Qualifications
    Route::get('/user/academic-qualifications', [AcademicQualificationController::class, 'index']);
    Route::post('/user/academic-qualifications', [AcademicQualificationController::class, 'store']);
    Route::put('/user/academic-qualifications/{id}', [AcademicQualificationController::class, 'update']);
    Route::delete('/user/academic-qualifications/{id}', [AcademicQualificationController::class, 'destroy']);

    // Experiences
    Route::get('/user/experiences', [ExperienceController::class, 'index']);
    Route::post('/user/experiences', [ExperienceController::class, 'store']);
    Route::put('/user/experiences/{id}', [ExperienceController::class, 'update']);
    Route::delete('/user/experiences/{id}', [ExperienceController::class, 'destroy']);

    // Projects
    Route::get('/user/projects', [ProjectController::class, 'index']);
    Route::post('/user/projects', [ProjectController::class, 'store']);
    Route::put('/user/projects/{id}', [ProjectController::class, 'update']);
    Route::delete('/user/projects/{id}', [ProjectController::class, 'destroy']);

    // Skills
    Route::get('/user/skills', [SkillController::class, 'index']);
    Route::post('/user/skills', [SkillController::class, 'store']);
    Route::put('/user/skills/{id}', [SkillController::class, 'update']);
    Route::delete('/user/skills/{id}', [SkillController::class, 'destroy']);

    // Achievements
    Route::get('/user/achievements', [AchievementController::class, 'index']);
    Route::post('/user/achievements', [AchievementController::class, 'store']);
    Route::put('/user/achievements/{id}', [AchievementController::class, 'update']);
    Route::delete('/user/achievements/{id}', [AchievementController::class, 'destroy']);

    // Courseworks
    Route::get('/user/courseworks', [CourseworkController::class, 'index']);
    Route::post('/user/courseworks', [CourseworkController::class, 'store']);
    Route::put('/user/courseworks/{id}', [CourseworkController::class, 'update']);
    Route::delete('/user/courseworks/{id}', [CourseworkController::class, 'destroy']);

    // Interests
    Route::get('/user/interests', [InterestController::class, 'index']);
    Route::post('/user/interests', [InterestController::class, 'store']);
    Route::put('/user/interests/{id}', [InterestController::class, 'update']);
    Route::delete('/user/interests/{id}', [InterestController::class, 'destroy']);

});