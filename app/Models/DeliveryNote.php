<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeliveryNote extends Model
{
    /** @use HasFactory<\Database\Factories\DeliveryNoteFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'delivery_number', 'quotation_id', 'company_id', 'created_by',
        'po_number', 'delivery_date', 'delivery_status', 'received_by',
        'delivered_by', 'received_date', 'notes'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function receiver()
    {
        return $this->belongsTo(Contact::class, 'received_by');
    }

    public function deliverer()
    {
        return $this->belongsTo(Contact::class, 'delivered_by');
    }

    public function items()
    {
        return $this->hasMany(DeliveryNoteItem::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($delivery) {
            $delivery->delivery_number = 'DN-' . date('Y') . sprintf('%06d', static::count() + 1);
        });
    }
}
