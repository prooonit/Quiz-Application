<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;
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
}
