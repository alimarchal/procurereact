<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quotation extends Model
{
    /** @use HasFactory<\Database\Factories\QuotationFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'quotation_number', 'company_id', 'created_by', 'quotation_date',
        'valid_until', 'payment_terms', 'currency', 'subtotal', 'vat_rate',
        'vat_amount', 'discount', 'total', 'notes', 'status'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function items()
    {
        return $this->hasMany(QuotationItem::class);
    }

    public function deliveryNotes()
    {
        return $this->hasMany(DeliveryNote::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    public function calculateTotals()
    {
        $this->subtotal = $this->items->sum('total');
        $this->vat_amount = $this->subtotal * ($this->vat_rate / 100);
        $this->total = $this->subtotal + $this->vat_amount - $this->discount;
        $this->save();
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($quotation) {
            $quotation->quotation_number = 'QT-' . date('Y') . sprintf('%06d', static::count() + 1);
        });
    }
}
