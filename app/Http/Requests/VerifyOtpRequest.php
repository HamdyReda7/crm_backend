<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VerifyOtpRequest extends FormRequest
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

        ];
    }

    public function messages(): array
    {
        return [

            'email.required' => 'Email is required.',
            'email.email' => 'Invalid email address.',

            'otp.required' => 'Verification code is required.',
            'otp.digits' => 'Verification code must be 6 digits.',

        ];
    }
}
