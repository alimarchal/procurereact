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
            'user_id' => 'required|exists:users,id',
            'parent_id' => 'nullable|exists:businesses,id',
            'name' => 'required|string|max:255',
            'name_arabic' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'ibr' => 'nullable|string|max:255',
            'cr_number' => 'nullable|string|max:50',
            'vat_number' => 'nullable|string|max:50',
            'vat_number_arabic' => 'nullable|string|max:255',
            'cell' => 'nullable|string|max:20',
            'mobile' => 'nullable|string|max:20',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'customer_industry' => 'nullable|string|max:255',
            'sale_type' => 'nullable|string|max:255',
            'article_no' => 'nullable|string|max:255',
            'business_type_english' => 'nullable|string|max:255',
            'business_type_arabic' => 'nullable|string|max:255',
            'business_description_english' => 'nullable|string',
            'business_description_arabic' => 'nullable|string',
            'invoice_side_arabic' => 'nullable|string|max:255',
            'invoice_side_english' => 'nullable|string|max:255',
            'english_description' => 'nullable|string|max:255',
            'arabic_description' => 'nullable|string|max:255',
            'vat_percentage' => 'nullable|numeric|between:0,100',
            'apply_discount_type' => 'nullable|string|max:255',
            'language' => 'nullable|string|max:255',
            'show_email_on_invoice' => 'nullable|boolean',
            'website' => 'nullable|url|max:255',
            'bank_name' => 'nullable|string|max:255',
            'iban' => 'nullable|string|max:50',
            'company_type' => 'nullable|string|max:255',
            'company_logo' => 'nullable|image|max:2048',
            'company_stamp' => 'nullable|image|max:2048',
        ];
    }
}
