<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LogStatus extends Model
{
    protected $fillable = [

        'user_id',
        'email',
        'user_name',
        'login_count',
        'login_check',
        'login_date',
        'last_activity',
        'ip_address',

    ];

    protected $table = 'tb_log_status';
    protected $connection = 'mysql';
}
