<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\QuestionsController;
use App\Http\Controllers\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::resource('/quizzes', QuizController::class)->only(['index', 'store', 'update']);
    Route::resource('/quizzes/{quiz}/questions', QuestionsController::class)->only(['index', 'store']);
    Route::post('/quizzes/{quiz}/submit', [QuizController::class, 'submit']);
});
