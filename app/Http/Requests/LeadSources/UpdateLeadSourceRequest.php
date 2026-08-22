<?php

namespace App\Http\Requests\LeadSources;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLeadSourceRequest extends FormRequest
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
                Rule::unique('lead_sources', 'name')->ignore(
                    $this->route('id'),
                    'id'
                ),
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
            'name.required' => 'اسم مصدر العميل مطلوب.',
            'name.string' => 'اسم مصدر العميل يجب أن يكون نصًا.',
            'name.max' => 'اسم مصدر العميل يجب ألا يتجاوز 255 حرفًا.',
            'name.unique' => 'اسم مصدر العميل مستخدم بالفعل.',

            'status.required' => 'حالة مصدر العميل مطلوبة.',
            'status.boolean' => 'حالة مصدر العميل يجب أن تكون صحيحة أو غير صحيحة.',
        ];
    }
}
