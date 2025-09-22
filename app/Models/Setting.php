<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [

        'web_status',
        'allowed_web_status',
        'del_reportseller',
        'check_edit',
  
    ];
    protected $table = 'settings';
    protected $connection = 'mysql';
}

