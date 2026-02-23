<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromotionOrders extends Model
{
    protected $fillable = [

        'po',
        'created_by',
        'created_by_id',
        'order_date',
        'total_amount',
        'status',
    ];

    protected $connection = 'mysql';

    public function items()
    {
        return $this->hasMany(PromotionItems::class);
    }
}
