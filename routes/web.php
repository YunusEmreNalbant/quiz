<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('panel', [\App\Http\Controllers\MainController::class, 'dashboard'])->name('dashboard');
    Route::get('quiz/detay/{slug}', [\App\Http\Controllers\MainController::class, 'quiz_detail'])->name('quiz.detail');
    Route::get('quiz/{slug}', [\App\Http\Controllers\MainController::class, 'quiz'])->name('quiz.join');
    Route::post('quiz/{slug}/result', [\App\Http\Controllers\MainController::class, 'result'])->name('quiz.result');
});

Route::group(['middleware' => ['auth', 'isAdmin'], 'prefix' => 'admin'], function () {
    Route::get('quizzes/{id}', [\App\Http\Controllers\Admin\QuizController::class, 'destroy'])->whereNumber('id')->name('quizzes.destroy');
    Route::get('quiz/{quiz_id}/questions/{id}', [\App\Http\Controllers\Admin\QuestionController::class, 'destroy'])->whereNumber('id')->name('questions.destroy');
    Route::resource('quizzes', \App\Http\Controllers\Admin\QuizController::class);
    Route::resource('quiz/{quiz_id}/questions', \App\Http\Controllers\Admin\QuestionController::class);
});
