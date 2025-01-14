<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IbrDirectCommission extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'ibr_no', 'transaction_id', 'amount', 'status'
    ];

    public function business(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public function ibr(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transaction(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    public function inDirectCommissions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(IbrIndirectCommission::class);
    }


}
