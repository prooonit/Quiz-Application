<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubmitQuizRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Allow all authenticated users (you can add custom checks if needed)
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'answers' => 'nullable|array',
            'answers.*.question_id' => 'required_with:answers|exists:questions,id',
            'answers.*.selected_option_ids' => 'nullable|array',
            'answers.*.text_answer' => 'nullable|string|max:300',
        ];
    }

    public function messages(): array
    {
        return [
            'answers.array' => 'Answers must be in an array format.',
            'answers.*.question_id.required_with' => 'Each answer must include a valid question ID.',
            'answers.*.question_id.exists' => 'Invalid question ID provided.',
            'answers.*.text_answer.max' => 'Text answer must not exceed 300 characters.',
      
        ];
    }
}
