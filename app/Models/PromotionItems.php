<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromotionItems extends Model
{

    protected $fillable = [

        'promotion_order_id',
        'product_id',
        'product_name',
        'qty',
        'unit',
        'price',
        'total',
        'note',
        'expire'
    ];

    protected $connection = 'mysql';
    public function order()
    {
        return $this->belongsTo(PromotionOrders::class, 'promotion_order_id');
    }
}
