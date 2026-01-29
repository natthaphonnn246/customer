<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ordering extends Model
{
    protected $table = 'orderings_tb';

    protected $fillable = [
        'order_id',
        'product_code',
        'product_name',
        'unit',
        'qty',
        'price',
        'total_price',
        'remark',
        'reserve',
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
}
