<?php

namespace App\Http\Requests\LeadSources;

use Illuminate\Foundation\Http\FormRequest;

class CreateLeadSourceRequest extends FormRequest
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
                'unique:lead_sources,name',
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
            'name.required' => 'اسم مصدر العميل مطلوب.',
            'name.string' => 'اسم مصدر العميل يجب أن يكون نصًا.',
            'name.max' => 'اسم مصدر العميل يجب ألا يتجاوز 255 حرفًا.',
            'name.unique' => 'مصدر العميل موجود بالفعل.',

            'status.boolean' => 'حالة مصدر العميل يجب أن تكون صحيحة أو غير صحيحة.',
        ];
    }
}
