<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    /** @use HasFactory<\Database\Factories\CompanyFactory> */
    use HasFactory;

    protected $fillable = [
        // Basic Information
        'user_id',
        'name',
        'name_arabic',
        'email',

        // Registration Numbers
        'cr_number',
        'vat_number',
        'vat_number_arabic',

        // Contact Information
        'cell',
        'mobile',
        'phone',

        // Location Information
        'address',
        'city',
        'country',

        // Business Details
        'customer_industry',
        'sale_type',
        'article_no',
        'business_type_english',
        'business_type_arabic',
        'business_description_english',
        'business_description_arabic',

        // Invoice Settings
        'invoice_side_arabic',
        'invoice_side_english',
        'english_description',
        'arabic_description',
        'vat_percentage',
        'apply_discount_type',
        'language',
        'show_email_on_invoice',

        // Website Information
        'website',

        // Banking Information
        'bank_name',
        'iban',

        // Type Information
        'company_type',

        // File Uploads
        'company_logo',
        'company_stamp'
    ];
    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function quotations()
    {
        return $this->hasMany(Quotation::class);
    }

    public function deliveryNotes()
    {
        return $this->hasMany(DeliveryNote::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function getFullAddressAttribute()
    {
        return "{$this->address}, {$this->city}, {$this->country}";
    }
}
