<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [

        'web_status',
        'allowed_web_status',
  
    ];
    protected $table = 'settings';
    protected $connection = 'mysql';
}

