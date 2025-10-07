<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'token' => 'required|string|exists:user_tokens,token',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[A-Z]/',        // at least one uppercase
                'regex:/[0-9]/',        // at least one number
                'regex:/[@$!%*#?&]/',   // at least one special character
                'confirmed',
            ],
        ];
    }

    /**
     * Custom error messages for validation.
     */
    public function messages(): array
    {
        return [
            'token.required' => 'The reset token is missing.',
            'token.exists' => 'The provided token is invalid or expired.',

            'password.required' => 'Please enter your new password.',
            'password.min' => 'Your password must be at least 8 characters long.',
            'password.regex' => 'Your password must contain at least one uppercase letter, one number, and one special character.',
            'password.confirmed' => 'The password confirmation does not match.',
        ];
    }
}
