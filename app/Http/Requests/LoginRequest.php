<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // allow all users to use this request
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email address.',
            'password.required' => 'Password is required.',
        ];
    }
}
