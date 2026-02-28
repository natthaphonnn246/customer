<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpecialDeal extends Model
{
    protected $fillable = [

        'product_id',
        'product_code',
        'product_name',
        'qty_pack',
        'unit',
        'price',
        'is_active',
        'created_by_id',
        'ip',
        'stock_pack'
    ];

    protected $table = 'special_deals';
    protected $connection = 'mysql';


    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
