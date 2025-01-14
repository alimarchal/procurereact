<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class BusinessResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => $this->whenLoaded('user'),
            'parent' => new BusinessResource($this->whenLoaded('parent')),
            'children' => BusinessResource::collection($this->whenLoaded('children')),
            'basic_info' => [
                'name' => $this->name,
                'name_arabic' => $this->name_arabic,
                'email' => $this->email,
                'ibr' => $this->ibr,
            ],
            'registration' => [
                'cr_number' => $this->cr_number,
                'vat_number' => $this->vat_number,
                'vat_number_arabic' => $this->vat_number_arabic,
            ],
            'contact' => [
                'cell' => $this->cell,
                'mobile' => $this->mobile,
                'phone' => $this->phone,
            ],
            'location' => [
                'address' => $this->address,
                'city' => $this->city,
                'country' => $this->country,
            ],
            'business_details' => [
                'customer_industry' => $this->customer_industry,
                'sale_type' => $this->sale_type,
                'article_no' => $this->article_no,
                'type' => [
                    'english' => $this->business_type_english,
                    'arabic' => $this->business_type_arabic,
                ],
                'description' => [
                    'english' => $this->business_description_english,
                    'arabic' => $this->business_description_arabic,
                ],
            ],
            'invoice_settings' => [
                'side' => [
                    'arabic' => $this->invoice_side_arabic,
                    'english' => $this->invoice_side_english,
                ],
                'description' => [
                    'english' => $this->english_description,
                    'arabic' => $this->arabic_description,
                ],
                'vat_percentage' => $this->vat_percentage,
                'apply_discount_type' => $this->apply_discount_type,
                'language' => $this->language,
                'show_email' => $this->show_email_on_invoice,
            ],
            'website' => $this->website,
            'banking' => [
                'bank_name' => $this->bank_name,
                'iban' => $this->iban,
            ],
            'files' => [
                'logo' => $this->company_logo ? asset('storage/' . $this->company_logo) : null,
                'stamp' => $this->company_stamp ? asset('storage/' . $this->company_stamp) : null,
            ],
            'timestamps' => [
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
                'deleted_at' => $this->deleted_at,
            ],
        ];
    }
}
