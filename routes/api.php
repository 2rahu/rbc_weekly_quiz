<?php

use App\Exports\QuestionsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TempController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\QuizSetController;
use App\Http\Controllers\LoginAuthController;
use App\Http\Controllers\QuizTopicController;
use App\Http\Controllers\QuizEditorsController;

Route::apiResource('users', UsersController::class);
Route::apiResource('roles', RolesController::class);
Route::apiResource('quiz-topics', QuizTopicController::class);
Route::apiResource('quiz-set', QuizSetController::class);

Route::apiResource('quiz-editors-questions', QuizEditorsController::class);
Route::post('quiz-update-image/{id}', [QuizEditorsController::class, 'update_image']);

Route::post('login', [LoginAuthController::class, 'login']);

Route::get('questions-export', function () {
    return Excel::download( new QuestionsExport(),
        'questions.xlsx'    
    );
});


Route::apiResource('selected-questions', TempController::class)
    ->only(['index', 'destroy']);

Route::post('select-question/{id}', [TempController::class, 'store']);
Route::post('selected-questions-transfer', [TempController::class, 'transfer']);



Route::patch('update-password/{id}', [UsersController::class, "updatePassword"]);
Route::patch('update-quiz-set-status/{id}', [QuizSetController::class, "changeQuizSetStatus"]);

Route::middleware('auth:sanctum')->group(function () {
    
});




