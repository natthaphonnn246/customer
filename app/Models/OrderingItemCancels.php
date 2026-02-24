<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderingItemCancels extends Model
{
    protected $table = 'ordering_item_cancels';
    
    protected $fillable = [
        'ordering_item_id',
        'product_code',
        'price',
        'qty',
        'total',
        'cancel_by',
        'cancel_by_name',
        'ip',
        'cancel_reason',
        'created_at'
    ];
}
