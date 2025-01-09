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
            'company_type' => 'required|in:customer,vendor',
            'language' => 'required|in:english,arabic',
            'vat_percentage' => 'required|numeric|between:0,100',
            'company_logo' => 'nullable|image|max:5120',
            'company_stamp' => 'nullable|image|max:5120'
        ];
    }
}
