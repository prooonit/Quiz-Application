<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuizRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ];
    }
    public function messages(): array
    {
        return [
            'title.required' => 'The quiz title is required.',
            'title.string' => 'The quiz title must be a string.',
            'title.max' => 'The quiz title must not exceed 255 characters.',
            'description.string' => 'The quiz description must be a string.',
        ];
    }
}
