<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\QuestionsController;

Route::get('/health', function () {
    return "Pronit rahangdale";
});
Route::resource('/quizzes', QuizController::class)->only(['index','store','update']) ;

Route::resource('/quizzes/{quiz}/questions', QuestionsController::class)->only(['index','store']);

Route::post('/quizzes/{quiz}/submit', [QuizController::class, 'submit']);
