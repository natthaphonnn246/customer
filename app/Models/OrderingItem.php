<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderingItem extends Model
{
    protected $table = 'ordering_items';

    protected $fillable = [
        'product_id',
        'order_id',
        'product_code',
        'product_name',
        'unit',
        'qty',
        'price',
        'total_price',
        'remark',
        'reserve',
        'ordering_date',
        'cancel_by',
        'cancel_by_name',
        'cancelled_at',
        'status'
    ];

    protected $casts = [
        'reserve' => 'boolean',
        'price' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
    public function specialDeal()
    {
        return $this->hasOne(SpecialDeal::class, 'product_id', 'product_id');
    }
}
