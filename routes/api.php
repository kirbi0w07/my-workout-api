<?php

use App\Http\Controllers\WorkoutPlanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Authentication routes
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);
Route::post('/signin', [\App\Http\Controllers\AuthController::class, 'signin']);
Route::delete('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->middleware('auth:api');

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::middleware('auth:api')->group(function () {
    Route::get('/user-profile', [\App\Http\Controllers\UserProfileController::class, 'index']);
    Route::post('/user-profile', [\App\Http\Controllers\UserProfileController::class, 'store']);
    Route::put('/user-profile/{userProfile}', [\App\Http\Controllers\UserProfileController::class, 'update']);
    Route::delete('/user-profile/{userProfile}', [\App\Http\Controllers\UserProfileController::class, 'destroy']);
    Route::get('/workout-plans', [\App\Http\Controllers\WorkoutPlanController::class, 'index']);
    Route::post('/workout-plans', [\App\Http\Controllers\WorkoutPlanController::class, 'store']);
    Route::get('/workout-plans/{workoutPlan}', [WorkoutPlanController::class, 'show']);
    Route::put('/workout-plans/{workoutPlan}', [WorkoutPlanController::class, 'update']);
    Route::delete('/workout-plans/{workoutPlan}', [WorkoutPlanController::class, 'destroy']);
    Route::post('/workout-sessions', [\App\Http\Controllers\WorkoutSessionController::class, 'store']);
    Route::put('/workout-sessions/{workoutSession}/finish', [\App\Http\Controllers\WorkoutSessionController::class, 'finish']);
});
