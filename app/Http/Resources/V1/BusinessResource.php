<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BusinessResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'name_arabic' => $this->name_arabic,
            'email' => $this->email,
            'cr_number' => $this->cr_number,
            'vat_number' => $this->vat_number,
            'vat_number_arabic' => $this->vat_number_arabic,
            'cell' => $this->cell,
            'mobile' => $this->mobile,
            'phone' => $this->phone,
            'address' => $this->address,
            'city' => $this->city,
            'country' => $this->country,
            'customer_industry' => $this->customer_industry,
            'sale_type' => $this->sale_type,
            'article_no' => $this->article_no,
            'business_type_english' => $this->business_type_english,
            'business_type_arabic' => $this->business_type_arabic,
            'business_description_english' => $this->business_description_english,
            'business_description_arabic' => $this->business_description_arabic,
            'invoice_side_arabic' => $this->invoice_side_arabic,
            'invoice_side_english' => $this->invoice_side_english,
            'english_description' => $this->english_description,
            'arabic_description' => $this->arabic_description,
            'vat_percentage' => $this->vat_percentage,
            'apply_discount_type' => $this->apply_discount_type,
            'language' => $this->language,
            'show_email_on_invoice' => $this->show_email_on_invoice,
            'website' => $this->website,
            'bank_name' => $this->bank_name,
            'iban' => $this->iban,
            'company_type' => $this->company_type,
            'company_logo' => $this->company_logo,
            'company_stamp' => $this->company_stamp,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
