<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $table = 'orders_tb';

    protected $fillable = [
        'po_number',
        'po_date',
        'customer_code',
        'customer_name',
        'price_level',
        'status',
        'total_amount',
        'created_by',
    ];

    protected $casts = [
        'po_date' => 'date',
        'total_amount' => 'decimal:2',
    ];

    /**
     * รายการสินค้าในใบสั่งซื้อ
     */
    public function items(): HasMany
    {
        return $this->hasMany(Ordering::class, 'order_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_code', 'customer_code'); 
        // 'customer_code' คือ foreign key ของ order -> customer
    }

}
