<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'email' => 'required|email',

            'otp' => 'required|digits:6',

            'password' => 'required|min:8|confirmed',

        ];
    }

    public function messages(): array
    {
        return [

            'email.required' => 'Email is required.',
            'email.email' => 'Invalid email address.',

            'otp.required' => 'Verification code is required.',
            'otp.digits' => 'Verification code must be 6 digits.',

            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Password confirmation does not match.',

        ];
    }
}
