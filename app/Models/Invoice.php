<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    /** @use HasFactory<\Database\Factories\InvoiceFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'invoice_number', 'company_id', 'quotation_id', 'delivery_note_id',
        'created_by', 'invoice_date', 'due_date', 'payment_terms', 'currency',
        'subtotal', 'vat_rate', 'vat_amount', 'discount', 'total',
        'paid_amount', 'balance', 'status', 'notes'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }

    public function deliveryNote()
    {
        return $this->belongsTo(DeliveryNote::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function updatePaymentStatus()
    {
        $this->paid_amount = $this->payments->sum('amount');
        $this->balance = $this->total - $this->paid_amount;
        $this->status = $this->balance <= 0 ? 'paid' : ($this->paid_amount > 0 ? 'partial' : 'unpaid');
        $this->save();
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($invoice) {
            $invoice->invoice_number = 'INV-' . date('Y') . sprintf('%06d', static::count() + 1);
        });
    }
}
