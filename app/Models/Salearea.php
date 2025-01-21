<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Salearea extends Model
{
    protected $fillable = [

     'salearea_id',
     'sale_name',
     'sale_area',
     'text_add',
     'admin_area',
     
    ];
    protected $table = 'saleareas';
    protected $connection = 'mysql';
    // public $timestamps = false;
}
