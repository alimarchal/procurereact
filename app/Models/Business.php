<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Business extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'parent_id',
        'name',
        'name_arabic',
        'email',
        'ibr',
        'cr_number',
        'vat_number',
        'vat_number_arabic',
        'cell',
        'mobile',
        'phone',
        'address',
        'city',
        'country',
        'customer_industry',
        'sale_type',
        'article_no',
        'business_type_english',
        'business_type_arabic',
        'business_description_english',
        'business_description_arabic',
        'invoice_side_arabic',
        'invoice_side_english',
        'english_description',
        'arabic_description',
        'vat_percentage',
        'apply_discount_type',
        'language',
        'show_email_on_invoice',
        'website',
        'bank_name',
        'iban',
        'company_type',
        'company_logo',
        'company_stamp'
    ];

    protected $casts = [
        'show_email_on_invoice' => 'boolean',
        'vat_percentage' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(Business::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Business::class, 'parent_id');
    }
}
