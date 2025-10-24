<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuestionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'questions' => 'required|array|min:1',
            'questions.*.type' => 'required|string|in:single,multiple,text',
            'questions.*.text' => 'required|string',
            'questions.*.expected_answer' => 'nullable|string',
            'questions.*.text_answer_limit' => 'nullable|integer',
            'questions.*.points' => 'required|integer|min:1',
            'questions.*.options' => 'required_if:questions.*.type,single,multiple|array|min:2',
            'questions.*.options.*.text' => 'required|string',
            'questions.*.options.*.is_correct' => 'required_if:questions.*.type,single,multiple|boolean',

        ];
    }
    public function messages(): array
    {
        return [
            'questions.required' => 'At least one question is required.',
            'questions.array' => 'Questions must be provided in an array format.',
            'questions.min' => 'At least one question must be provided.',
            'questions.*.type.required' => 'Each question must have a type.',
            'questions.*.type.in' => 'Question type must be one of the following: single, multiple, text.',
            'questions.*.text.required' => 'Each question must have text.',
            'questions.*.points.required' => 'Each question must have points assigned.',
            'questions.*.points.min' => 'Points for each question must be at least 1.',
            'questions.*.options.required_if' => 'Options are required for single and multiple choice questions.',
            'questions.*.options.array' => 'Options must be provided in an array format.',
            'questions.*.options.min' => 'At least two options are required for single and multiple choice questions.',
            'questions.*.options.*.text.required' => 'Each option must have text.',
            'questions.*.options.*.is_correct.required_if' => 'Each option must specify if it is correct for single and multiple choice questions.',
        ];
    }
}
