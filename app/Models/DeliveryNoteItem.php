<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryNoteItem extends Model
{
    /** @use HasFactory<\Database\Factories\DeliveryNoteItemFactory> */
    use HasFactory;

    protected $fillable = [
        'delivery_note_id',
        'item_id',
        'quantity'
    ];

    public function deliveryNote()
    {
        return $this->belongsTo(DeliveryNote::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($deliveryNoteItem) {
            // Decrease stock when delivery note item is created
            $deliveryNoteItem->item->updateStock($deliveryNoteItem->quantity, 'subtract');
        });

        static::deleted(function ($deliveryNoteItem) {
            // Increase stock when delivery note item is deleted
            $deliveryNoteItem->item->updateStock($deliveryNoteItem->quantity, 'add');
        });
    }

    public function getSubtotalAttribute()
    {
        return $this->quantity * $this->item->unit_price;
    }
}
