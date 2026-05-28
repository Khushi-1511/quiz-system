<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AttemptController;

Route::get('/', fn() => redirect()->route('quizzes.index'));

// Quiz routes
Route::resource('quizzes', QuizController::class)
    ->only(['index', 'create', 'store', 'show', 'destroy']);

// Question routes
Route::get('quizzes/{quiz}/questions/create', [QuestionController::class, 'create'])
    ->name('questions.create');
Route::post('quizzes/{quiz}/questions', [QuestionController::class, 'store'])
    ->name('questions.store');
Route::delete('quizzes/{quiz}/questions/{question}', [QuestionController::class, 'destroy'])
    ->name('questions.destroy');

// Attempt routes
Route::get('quizzes/{quiz}/attempt', [AttemptController::class, 'start'])
    ->name('attempts.start');
Route::post('quizzes/{quiz}/attempt', [AttemptController::class, 'submit'])
    ->name('attempts.submit');
Route::get('attempts/{attempt}/result', [AttemptController::class, 'result'])
    ->name('attempts.result');
Route::get('quizzes/{quiz}/responses', [QuizController::class, 'responses'])
    ->name('quizzes.responses');