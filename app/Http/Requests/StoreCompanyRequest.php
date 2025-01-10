<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'name_arabic' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'cr_number' => 'nullable|string|max:50',
            'vat_number' => 'nullable|string|max:50',
            'vat_number_arabic' => 'nullable|string|max:50',
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
            'company_type' => 'required|in:customer,vendor',
            'language' => 'required|in:english,arabic',
            'vat_percentage' => 'required|numeric|between:0,100',
            'company_logo' => 'nullable|image|max:5120',
            'company_stamp' => 'nullable|image|max:5120'
        ];
    }
}
