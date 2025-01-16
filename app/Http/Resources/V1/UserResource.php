<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //return parent::toArray($request);
        return [
            'id' => $this->id,
            'parent_id' => $this->parent_id,
            'name' => $this->name,
            'email' => $this->email,
            'type' => $this->type,
            'is_active' => $this->is_active,
            'is_super_admin' => $this->is_super_admin,
            'gender' => $this->gender,
            'country_of_business' => $this->country_of_business,
            'city_of_business' => $this->city_of_business,
            'country_of_bank' => $this->country_of_bank,
            'bank' => $this->bank,
            'iban' => $this->iban,
            'currency' => $this->currency,
            'mobile_number' => $this->mobile_number,
            'dob' => $this->dob,
            'mac_address' => $this->mac_address,
            'device_name' => $this->device_name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
