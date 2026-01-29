<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
// use Illuminate\Database\Eloquent\Model;

class LineAccount extends Authenticatable
{
    use HasApiTokens;
    protected $table = 'line_users_tb';
    protected $fillable = [

                            'line_user_id',
                            'display_name',
                            'picture_url',
                            'liff_token',
                            'user_agent',
                            'ip_address',
                            'status_line',
                        ];
}
