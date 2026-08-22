<?php

namespace App\Http\Requests\Services;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $serviceId = $this->route('id');

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('services', 'name')->ignore($serviceId),
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'status' => [
                'required',
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
            'name.unique' => 'اسم الخدمة مستخدم بالفعل.',

            'description.string' => 'وصف الخدمة يجب أن يكون نصًا.',

            'status.required' => 'حالة الخدمة مطلوبة.',
            'status.boolean' => 'حالة الخدمة يجب أن تكون صحيحة أو غير صحيحة.',
        ];
    }
}
