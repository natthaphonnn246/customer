<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    protected $fillable = [

        'user_id',
        'user_name',
        'email',
        'login_count',
        'checked',
        'login_date',
        'last_activity',
        'ip_address',
    ];

    protected $table = 'tb_log_type';
    protected $connection = 'mysql';
    

}
