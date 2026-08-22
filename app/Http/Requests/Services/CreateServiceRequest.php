<?php

namespace App\Http\Requests\Services;

use Illuminate\Foundation\Http\FormRequest;

class CreateServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:services,name',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'status' => [
                'nullable',
                'boolean',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'اسم الخدمة مطلوب.',
            'name.string' => 'اسم الخدمة يجب أن يكون نصًا.',
            'name.max' => 'اسم الخدمة يجب ألا يتجاوز 255 حرفًا.',
            'name.unique' => 'هذه الخدمة موجودة بالفعل.',

            'description.string' => 'وصف الخدمة يجب أن يكون نصًا.',

            'status.boolean' => 'حالة الخدمة يجب أن تكون صحيحة أو غير صحيحة.',
        ];
    }
}
