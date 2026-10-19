<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\QuizSetController;
use App\Http\Controllers\LoginAuthController;
use App\Http\Controllers\QuizTopicController;
use App\Http\Controllers\QuizEditorsController;

Route::apiResource('roles', RolesController::class);
Route::apiResource('users', UsersController::class);
Route::apiResource('quiz-topics', QuizTopicController::class);
Route::apiResource('quiz-set', QuizSetController::class);
Route::apiResource('quiz-editors-questions', QuizEditorsController::class);
Route::post('login', [LoginAuthController::class, 'login']);



Route::patch('update-password/{id}', [UsersController::class, "updatePassword"]);
Route::patch('update-quiz-set-status/{id}', [QuizSetController::class, "changeQuizSetStatus"]);

Route::middleware('auth:sanctum')->group(function () {
    
});




