<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    protected $fillable = [

        'product_id',
        'product_name',
        'generic_name',
        'category',
        'sub_category',
        'type',
        'unit',
        'cost',
        'price_1',
        'price_2',
        'price_3',
        'price_4',
        'price_5',
        'quantity',
        'status',

    ];

    protected $table = 'products';
    protected $connection = 'mysql';
}
