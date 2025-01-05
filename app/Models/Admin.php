<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $fillable = [

        'admin_id',
        'code',
        'admin_area',
        'admin_name',
        'email',
        'role',
        'telephone',
        'address',
        'province',
        'amphur',
        'district',
        'zipcode',
        'text_add',
        'status_checked',
        'email_login',
        'password',
    ];
    protected $table = 'user_tb';
    protected $connection = 'mysql';
    // public $timestamps = false;

    public static function adminEdit ($code)
    {
        $admin = Admin::select('admin_id', 'code','admin_area', 'admin_name', 'email', 'role','telephone', 'address','province', 'amphur', 'district', 'zipcode', 'created_at')
                ->where('admin_id', [$code])
                ->get();
        return [$admin];
    }
}
