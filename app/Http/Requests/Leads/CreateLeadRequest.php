<?php

namespace App\Http\Requests\Leads;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateLeadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            /*
            |--------------------------------------------------------------------------
            | Customer Information
            |--------------------------------------------------------------------------
            */

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'phone' => [
                'required',
                'string',
                'max:20',
            ],

            'whatsapp' => [
                'nullable',
                'string',
                'max:20',
            ],


            'business_type' => [
                'required',
                'string',
                'max:255',
            ],

            'city' => [
                'nullable',
                'string',
                'max:255',
            ],

            'address' => [
                'nullable',
                'string',
            ],

            /*
            |--------------------------------------------------------------------------
            | Lead Source
            |--------------------------------------------------------------------------
            */

            'lead_source_id' => [
                'required',
                'integer',
                'exists:lead_sources,id',
            ],


            /*
            |--------------------------------------------------------------------------
            | Notes
            |--------------------------------------------------------------------------
            */

            'notes' => [
                'nullable',
                'string',
            ],

            /*
            |--------------------------------------------------------------------------
            | Follow Up
            |--------------------------------------------------------------------------
            */

            'next_follow_up_at' => [
                'nullable',
                'date',
            ],

            /*
            |--------------------------------------------------------------------------
            | Services
            |--------------------------------------------------------------------------
            */

            'services' => [
                'nullable',
                'array',
            ],

            'services.*' => [
                'integer',
                'exists:services,id',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'اسم العميل مطلوب.',
            'name.string' => 'اسم العميل يجب أن يكون نصًا.',
            'name.max' => 'اسم العميل يجب ألا يتجاوز 255 حرفًا.',

            'phone.required' => 'رقم الهاتف مطلوب.',
            'phone.string' => 'رقم الهاتف يجب أن يكون نصًا.',
            'phone.max' => 'رقم الهاتف يجب ألا يتجاوز 20 رقمًا.',

            'whatsapp.string' => 'رقم الواتساب يجب أن يكون نصًا.',
            'whatsapp.max' => 'رقم الواتساب يجب ألا يتجاوز 20 رقمًا.',

            'business_type.required' => 'نوع النشاط مطلوب.',
            'business_type.string' => 'نوع النشاط يجب أن يكون نصًا.',
            'business_type.max' => 'نوع النشاط يجب ألا يتجاوز 255 حرفًا.',

            'city.string' => 'المدينة يجب أن تكون نصًا.',
            'city.max' => 'اسم المدينة يجب ألا يتجاوز 255 حرفًا.',

            'address.string' => 'العنوان يجب أن يكون نصًا.',

            'lead_source_id.required' => 'مصدر العميل مطلوب.',
            'lead_source_id.integer' => 'مصدر العميل يجب أن يكون رقمًا.',
            'lead_source_id.exists' => 'مصدر العميل المحدد غير موجود.',


            'notes.string' => 'الملاحظات يجب أن تكون نصًا.',

            'next_follow_up_at.date' => 'تاريخ المتابعة غير صحيح.',

            'services.array' => 'الخدمات يجب أن تكون قائمة.',
            'services.*.integer' => 'معرف الخدمة يجب أن يكون رقمًا.',
            'services.*.exists' => 'إحدى الخدمات المحددة غير موجودة.',
        ];
    }
}
