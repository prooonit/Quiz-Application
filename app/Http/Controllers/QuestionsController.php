<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\Option;
use Illuminate\Support\Facades\DB;

class QuestionsController extends Controller
{
    /**
     * Store new question(s) for a quiz
     */
    public function store(Request $request, $quizId)
    {
        // Validate that the quiz exists
        $quiz = Quiz::findOrFail($quizId);

        $validatedData = $request->validate([
            'questions' => 'required|array|min:1',
            'questions.*.type' => 'required|string|in:single,multiple,text',
            'questions.*.text' => 'required|string',
            'questions.*.expected_answer' => 'nullable|string',
            'questions.*.text_answer_limit' => 'nullable|integer',
            'questions.*.points' => 'required|integer|min:1',
            'questions.*.options' => 'required_if:questions.*.type,single,multiple|array|min:2',
            'questions.*.options.*.text' => 'required|string',
            'questions.*.options.*.is_correct' => 'required_if:questions.*.type,single,multiple|boolean',
        ]);

        DB::beginTransaction();

        try {
            $createdQuestions = [];

            foreach ($validatedData['questions'] as $qData) {
                $question = $quiz->questions()->create([
                    'type' => $qData['type'],
                    'text' => $qData['text'],
                    'expected_answer' => $qData['expected_answer'] ?? null,
                    'text_answer_limit' => $qData['text_answer_limit'] ?? 300,
                    'points' => $qData['points'],
                ]);

                // If question has options
                if (isset($qData['options']) && in_array($qData['type'], ['single','multiple'])) {
                    foreach ($qData['options'] as $optData) {
                        $question->options()->create([
                            'text' => $optData['text'],
                            'is_correct' => $optData['is_correct'],
                        ]);
                    }
                }

                $createdQuestions[] = $question->id;
            }

            DB::commit();

            return response()->json([
                'message' => 'Questions created successfully',
                'question_ids' => $createdQuestions
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to create questions', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * List all questions for a quiz
     */
    public function index($quizId)
    {
        $quiz = Quiz::findOrFail($quizId);

        $questions = $quiz->questions()->with('options:id,question_id,text')->get();

        return response()->json($questions);
    }

    /**
     * Update a specific question
     */
    public function update(Request $request, $questionId)
    {
        $question = Question::findOrFail($questionId);

        $validatedData = $request->validate([
            'type' => 'sometimes|string|in:single,multiple,text',
            'text' => 'sometimes|string',
            'expected_answer' => 'nullable|string',
            'text_answer_limit' => 'nullable|integer',
            'points' => 'sometimes|integer|min:1',
        ]);

        $question->update($validatedData);

        return response()->json(['message' => 'Question updated successfully']);
    }

    /**
     * Delete a specific question
     */
    public function destroy($questionId)
    {
        $question = Question::findOrFail($questionId);
        $question->delete();

        return response()->json(['message' => 'Question deleted successfully']);
    }
}
