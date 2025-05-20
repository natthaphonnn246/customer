<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    protected $fillable = [

        'subcategories_id',
        'subcategories_name',

    ];

    protected $table = 'subcategories';
    protected $connection = 'mysql';
}
