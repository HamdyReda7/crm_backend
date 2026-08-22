<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ChangePasswordRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'current_password' => [
                'required',
                'string',
            ],

            'password' => [
                'required',
                'string',
                'min:6',
                'confirmed',
                'different:current_password',
            ],

            'password_confirmation' => [
                'required',
                'string',
            ],
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'current_password.required' => 'كلمة المرور الحالية مطلوبة.',
            'current_password.string' => 'كلمة المرور الحالية يجب أن تكون نصًا.',

            'password.required' => 'كلمة المرور الجديدة مطلوبة.',
            'password.string' => 'كلمة المرور الجديدة يجب أن تكون نصًا.',
            'password.min' => 'كلمة المرور الجديدة يجب ألا تقل عن 6 أحرف.',
            'password.confirmed' => 'تأكيد كلمة المرور الجديدة غير متطابق.',
            'password.different' => 'كلمة المرور الجديدة يجب أن تختلف عن كلمة المرور الحالية.',

            'password_confirmation.required' => 'تأكيد كلمة المرور مطلوب.',
            'password_confirmation.string' => 'تأكيد كلمة المرور يجب أن يكون نصًا.',
        ];
    }
}
