<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SalesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,

            'image' => $this->image
                ? asset('img/users/' . $this->image)
                : null,

            'role' => $this->role,
            'status' => $this->status,

            'last_seen' => $this->last_seen,

            'leads_count' => $this->leads_count ?? 0,

            'created_at' => $this->created_at,
        ];
    }
}
