<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [

        'categories_id',
        'categories_name',

    ];

    protected $table = 'categories';
    protected $connection = 'mysql';
}