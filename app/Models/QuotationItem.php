<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationItem extends Model
{
    /** @use HasFactory<\Database\Factories\QuotationItemFactory> */
    use HasFactory;
    protected $fillable = [
        'quotation_id',
        'item_id',
        'quantity',
        'unit_price',
        'total'
    ];

    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function($quotationItem) {
            $quotationItem->unit_price = $quotationItem->item->unit_price;
            $quotationItem->total = $quotationItem->quantity * $quotationItem->unit_price;
        });

        static::created(function($quotationItem) {
            $quotationItem->quotation->calculateTotals();
        });

        static::deleted(function($quotationItem) {
            $quotationItem->quotation->calculateTotals();
        });
    }

    public function getSubtotalAttribute()
    {
        return $this->quantity * $this->unit_price;
    }
}
