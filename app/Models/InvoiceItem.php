<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    /** @use HasFactory<\Database\Factories\InvoiceItemFactory> */
    use HasFactory;
    protected $fillable = [
        'invoice_id',
        'item_id',
        'quantity',
        'unit_price',
        'total'
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function($invoiceItem) {
            $invoiceItem->unit_price = $invoiceItem->item->unit_price;
            $invoiceItem->total = $invoiceItem->quantity * $invoiceItem->unit_price;
        });

        static::created(function($invoiceItem) {
            $invoiceItem->invoice->calculateTotals();
        });

        static::deleted(function($invoiceItem) {
            $invoiceItem->invoice->calculateTotals();
        });
    }

    public function getSubtotalAttribute()
    {
        return $this->quantity * $this->unit_price;
    }
}
