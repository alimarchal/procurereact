<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBusinessRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'description' => 'nullable|string',
            'reference_number' => 'nullable|string|unique:businesses',
            'name' => 'required|string|max:255',
            'name_arabic' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'cr_number' => 'nullable|string|max:50',
            'vat_number' => 'nullable|string|max:50',
            'vat_number_arabic' => 'nullable|string|max:255',
            'cell' => 'nullable|string|max:20',
            'mobile' => 'nullable|string|max:20',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'country' => 'nullable|string',
            'customer_industry' => 'nullable|string',
            'sale_type' => 'nullable|string',
            'article_no' => 'nullable|string',
            'business_type_english' => 'nullable|string',
            'business_type_arabic' => 'nullable|string',
            'business_description_english' => 'nullable|string',
            'business_description_arabic' => 'nullable|string',
            'invoice_side_arabic' => 'nullable|string',
            'invoice_side_english' => 'nullable|string',
            'english_description' => 'nullable|string',
            'arabic_description' => 'nullable|string',
            'vat_percentage' => 'nullable|numeric|between:0,100',
            'apply_discount_type' => 'nullable|string',
            'language' => 'nullable|string',
            'show_email_on_invoice' => 'nullable|boolean',
            'website' => 'nullable|url',
            'bank_name' => 'nullable|string',
            'iban' => 'nullable|string|max:50',
            'company_type' => 'nullable|string',
            'company_logo' => 'nullable|image|max:2048',
            'company_stamp' => 'nullable|image|max:2048',
            'amount' => 'nullable|numeric',
            'status' => 'nullable|string',
        ];
    }
}
