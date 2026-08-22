<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeadResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            // بيانات العميل
            'name' => $this->name,
            'phone' => $this->phone,
            'whatsapp' => $this->whatsapp,
            'business_type' => $this->business_type,
            'city' => $this->city,
            'address' => $this->address,

            // مصدر العميل
            'lead_source' => $this->whenLoaded('leadSource', function () {
                return [
                    'id' => $this->leadSource->id,
                    'name' => $this->leadSource->name,
                ];
            }),

            // موظف المبيعات المسؤول
            'sales' => $this->whenLoaded('sales', function () {
                return [
                    'id' => $this->sales->id,
                    'name' => $this->sales->name,
                    'email' => $this->sales->email,
                    'phone' => $this->sales->phone,
                ];
            }),

            // الخدمات
            'services' => $this->whenLoaded('services', function () {
                return $this->services->map(function ($service) {
                    return [
                        'id' => $service->id,
                        'name' => $service->name,
                    ];
                });
            }),

            // الحالة والأولوية
            'status' => $this->status,

            // الملاحظات
            'notes' => $this->notes,

            // التواريخ
            'last_contact_at' => $this->last_contact_at,
            'next_follow_up_at' => $this->next_follow_up_at,
            'converted_at' => $this->converted_at,

            'created_at' => $this->created_at,
        ];
    }
}
