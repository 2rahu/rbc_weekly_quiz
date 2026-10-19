<?php

use App\Models\Questions;
use App\Models\QuizSetModel;
use App\Http\Middleware\UserCheck;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\TempController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Ques_Controller;
use App\Http\Controllers\QuizSetController;
use App\Http\Controllers\UserAdminController;
use App\Http\Controllers\QuizTopicsController;
use App\Http\Controllers\QuizQuiestionsController;
use App\Http\Controllers\QuizEditorQuestionsController;

// Route::get('/storage-link', function () {
//     Artisan::call('storage:link');
//     return "Storage link created successfully!";
// });


// Dummy Rout

// Route::get('/', function () {
//     $quizStatus = QuizSetModel::orderBy('quiz_set_id', 'desc')->get(); // ID ke descending order mein data fetch
//     return view('show_all_quiz_status', compact('quizStatus'));
// })->name('weekly.quiz');
// Route::get('play-quiz/{id}',[QuizSetController::class,'weeklyquiz'])->name('play.quiz');

// Route::middleware(['admin-check'])->group(function(){
//     Route::get('quiz-topic-index',[QuizTopicsController::class,'index'])->name('quiz.topic.index');
//     Route::post('quiz-topic-store',[QuizTopicsController::class,'store'])->name('quiz.topic.store');
//     Route::get('quiz-topic-edit/{id}',[QuizTopicsController::class,'edit'])->name('quiz.topic.edit');
//     Route::put('quiz-topic-update/{id}',[QuizTopicsController::class,'update'])->name('quiz.topic.update');
//     Route::get('quiz-topic-delete/{id}',[QuizTopicsController::class,'destory'])->name('quiz.topic.delete');

//     Route::get('quiz-set-index',[QuizSetController::class,'index'])->name('quiz.set.index');
//     // Route::post('quiz-set-store',[QuizSetController::class,'store'])->name('quiz.set.store');
//     Route::get('quiz-set-edit/{id}',[QuizSetController::class,'edit'])->name('quiz.set.edit');
//     Route::put('quiz-set-update/{id}',[QuizSetController::class,'update'])->name('quiz.set.update');
//     Route::get('quiz-set-delete/{id}',[QuizSetController::class,'destroy'])->name('quiz.set.delete');
//     Route::get('quiz-set-status/{id}',[QuizSetController::class,'changestatus'])->name('quiz.set.status');

//     Route::get('quiz-question-index',[QuizQuiestionsController::class,'index'])->name('quiz.question.index');
//     Route::post('quiz-question-store',[QuizQuiestionsController::class,'store'])->name('quiz.question.store');
//     Route::get('quiz-question-edit/{id}',[QuizQuiestionsController::class,'edit'])->name('quiz.question.edit');
//     Route::put('quiz-question-update/{id}',[QuizQuiestionsController::class,'update'])->name('quiz.question.update');
//     Route::delete('quiz-question-delete/{id}',[QuizQuiestionsController::class,'destory'])->name('quiz.question.delete');

//     Route::get('quiz-editor-index',[QuizEditorQuestionsController::class,'index'])->name('quiz.editor.index');
//     Route::get('quiz-editor-form',[QuizEditorQuestionsController::class,'form_show'])->name('quiz.editor.form');
//     Route::post('quiz-editor-store',[QuizEditorQuestionsController::class,'store'])->name('quiz.editor.store');
//     Route::get('quiz-editor-edit/{id}',[QuizEditorQuestionsController::class,'edit'])->name('quiz.editor.edit');
//     Route::post('quiz-editor-update/{id}',[QuizEditorQuestionsController::class,'update'])->name('quiz.editor.update');
//     Route::get('quiz-editor-edit-image/{id}',[QuizEditorQuestionsController::class,'edit_image'])->name('quiz.editor.edit.image');
//     Route::post('quiz-editor-update-image/{id}',[QuizEditorQuestionsController::class,'update_image'])->name('quiz.editor.update.image');
//     Route::get('quiz-editor-delete/{id}',[QuizEditorQuestionsController::class,'destroy'])->name('quiz.editor.delete');
//     Route::get('quiz-editor-delete_image/{id}',[QuizEditorQuestionsController::class,'destroy_image'])->name('quiz.editor.delete.image');

//     Route::get('quiz-temp-index', [TempController::class, 'index'])->name('quiz.temp.index');
//     Route::get('quiz-temp-store{id}', [TempController::class, 'store'])->name('quiz.temp.store');
//     Route::get('quiz-temp-delete{id}', [TempController::class, 'destroy'])->name('quiz.temp.delete');
//     Route::post('quiz-temp-transfer',[TempController::class,'transfer'])->name('quiz.temp.transfer');
//     Route::get('user-details', [LoginController::class, 'userlist'])->name('user.details');
//     Route::post('login-store', [LoginController::class, 'store'])->name('login.store');
//     Route::get('login-edit/{id}', [LoginController::class, 'edit'])->name('login.edit');
//     Route::post('login-update/{id}',[LoginController::class,'update'])->name('login.update');
//     Route::post('login-password-edit/{id}',[LoginController::class,'edit_password'])->name('login.password.edit');
//     Route::post('login-password-update/{id}',[LoginController::class,'update_password'])->name('login.password.update');
//     Route::get('login-delete/{id}',[LoginController::class,'destroy'])->name('login.delete');
// });

// Route::get('login-index', [LoginController::class, 'index'])->name('login.index');
// Route::post('login', [LoginController::class, 'login'])->name('login');

// Route::middleware(['user-check'])->group(function(){
//     Route::get('quiz-useradmin-index', [UserAdminController::class, 'index'])->name('quiz.useradmin.index');
//     Route::get('quiz-form-show', [UserAdminController::class, 'form_show'])->name('quiz.form.show');
//     Route::post('quiz-useradmin-store',[UserAdminController::class,'store'])->name('quiz.useradmin.store');
//     Route::get('quiz-useradmin-edit/{id}',[UserAdminController::class,'edit'])->name('quiz.useradmin.edit');
//     Route::post('quiz-useradmin-update/{id}',[UserAdminController::class,'update'])->name('quiz.useradmin.update');
//     Route::get('quiz-useradmin-edit-image/{id}',[UserAdminController::class,'edit_image'])->name('quiz.useradmin.edit.image');
//     Route::post('quiz-useradmin-update-image/{id}',[UserAdminController::class,'update_image'])->name('quiz.useradmin.update.image');
//     Route::get('quiz-useradmin-delete/{id}',[UserAdminController::class,'destroy'])->name('quiz.useradmin.delete');
//     Route::get('quiz-useradmin-delete-image/{id}',[UserAdminController::class,'destroy_image'])->name('quiz.useradmin.delete.image');
//     Route::post('quiz-useradmin-store-topic', [UserAdminController::class, 'store_topic'])->name('quiz.useradmin.store.topic');
//     Route::get('quiz-useradmin-approved', [UserAdminController::class, 'approved'])->name('quiz.useradmin.approved');
//     Route::get('user-logout', [LoginController::class, 'logout'])->name('user.logout');
// });



