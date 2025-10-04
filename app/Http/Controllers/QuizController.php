<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\Attempt;
use App\Models\AttemptAnswer;
class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::all();
        return response()->json($quizzes);
    }
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
      ]);
    
        $quiz = new Quiz();
        $quiz->title = $validatedData['title'];
        $quiz->description = $validatedData['description'] ?? '';
        $quiz->save();
        return response()->json(['message' => 'Quiz created successfully', 'quiz_id' => $quiz->id], 201);
    }  

     public function submit(Request $request, $quizId)
    {
        $validatedData = $request->validate([
            'answers' => 'required|array',
            'answers.*.question_id' => 'required|exists:questions,id',
            'answers.*.selected_option_ids' => 'nullable|array',
            'answers.*.text_answer' => 'nullable|string|max:300',
        ]);
        
        $quiz = Quiz::with('questions.options')->findOrFail($quizId);
        
        $score = 0;
        $total = 0;

        $attempt = Attempt::create([
            'quiz_id' => $quizId,
            'user_id' => $request->user()?->id, // nullable for guests
            'score' => 0, // temp
            'total' => 0, // temp
            'metadata' => json_encode([
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ])
        ]);

        foreach ($validatedData['answers'] as $answerData) {
            $question = $quiz->questions->find($answerData['question_id']);
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

            if ($isCorrect) $score += $question->points;
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
