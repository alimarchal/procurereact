<?php

namespace App\Models;

use App\Enums\BusinessStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Business extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * These are the fields that can be filled using the `create()` or `update()` methods.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'description',
        'reference_number',
        'name',
        'name_arabic',
        'email',
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
        'apply_discount_type',
        'language',
        'website',
        'bank_name',
        'iban',
        'company_type',
        'company_logo',
        'company_stamp',
        'amount',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * These are the fields that should be converted to their corresponding PHP types when retrieved from the database.
     *
     * @var array
     */
    protected $casts = [
        // Cast the 'amount' field to a decimal with 2 places.
        'amount' => 'decimal:2',
        // Cast the 'status' field to an instance of the BusinessStatus enum.
        'status' => BusinessStatus::class,
        // Cast the 'show_email_on_invoice' field to a boolean.
        'show_email_on_invoice' => 'boolean',
        // Cast the 'vat_percentage' field to a decimal with 2 places.
        'vat_percentage' => 'decimal:2'
    ];

    /**
     * Get the user that owns the business.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
