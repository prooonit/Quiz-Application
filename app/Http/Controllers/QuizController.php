<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuizRequest;
use App\Http\Requests\SubmitQuizRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\Attempt;
use App\Models\AttemptAnswer;
use App\Http\Controllers\JWTAuth;
class QuizController extends Controller
{
    public function index()
    {
        // Fetch all quizzes with creator (author) info
        $quizzes = Quiz::with('creator:id,name,email')->get();
        return response()->json($quizzes);
    }

    public function store(StoreQuizRequest $request)
    {
        $validatedData = $request->validated();
        // Get the currently logged-in user's ID from the JWT token
        $userId = auth()->id();

        // Create the quiz and link it to the creator
        $quiz = new Quiz();
        $quiz->title = $validatedData['title'];
        $quiz->description = $validatedData['description'] ?? '';
        $quiz->created_by = $userId; // 🔹 Link the quiz to the logged-in user
        $quiz->save();

        return response()->json([
            'message' => 'Quiz created successfully',
            'quiz' => $quiz
        ], 201);
    }



    public function submit(SubmitQuizRequest $request, $quizId)
    {
        // Get the authenticated user from JWT
        $userId = auth()->id();
        $user = User::find($userId);
        //$user = JWTAuth::parseToken()->authenticate(); // throws exception if token invalid

        $validatedData = $request->validated();
        $quiz = Quiz::with('questions.options')->findOrFail($quizId);

        $score = 0;
        $total = 0;

        $attempt = Attempt::create([
            'quiz_id' => $quizId,
            'user_id' => $user->id, // fetch from JWT
            'score' => 0, // temporary
            'total' => 0, // temporary
            'metadata' => json_encode([
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ])
        ]);

        foreach ($validatedData['answers'] as $answerData) {

            $questions = $quiz->questions;
            $question = $questions->find($answerData['question_id']);
            $isCorrect = false;
            // Evaluate based on type
            if ($question->type == 'text') {
                if (isset($question->expected_answer) && isset($answerData['text_answer'])) {
                    $isCorrect = strtolower(trim($question->expected_answer)) == strtolower(trim($answerData['text_answer']));
                }
            } else {
                $correctOptionIds = $question->options->where('is_correct', true)->pluck('id')->toArray();
                $selectedOptionIds = $answerData['selected_option_ids'] ?? [];

                sort($correctOptionIds);
                sort($selectedOptionIds);
                $isCorrect = $correctOptionIds == $selectedOptionIds;
            }

            if ($isCorrect)
                $score += $question->points;
            $total += $question->points;

            AttemptAnswer::create([
                'attempt_id' => $attempt->id,
                'question_id' => $question->id,
                'selected_option_ids' => $answerData['selected_option_ids'] ?? null,
                'text_answer' => $answerData['text_answer'] ?? null,
                'is_correct' => $isCorrect
            ]);
        }

        // Update attempt score
        $attempt->update(['score' => $score, 'total' => $total]);

        return response()->json([
            'attempt_id' => $attempt->id,
            'score' => $score,
            'total' => $total
        ]);
    }
}
