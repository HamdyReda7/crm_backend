<?php

namespace App\Http\Requests\Sales;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSalesStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => [
                'required',
                Rule::in([
                    User::ACTIVE,
                    User::INACTIVE,
                ]),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'status.required' => 'حالة الحساب مطلوبة.',
            'status.in' => 'حالة الحساب يجب أن تكون نشط أو غير نشط.',
        ];
    }
}
