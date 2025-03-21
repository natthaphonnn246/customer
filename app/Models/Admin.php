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
        'maintenance_status',
        'allowed_maintenance_status',
        'allowed_user_status',
    ];
    protected $table = 'user_tb';
    protected $connection = 'mysql';
    // public $timestamps = false;

    public static function adminEdit ($id)
    {
        $admin = Admin::select('id','admin_id', 'code','admin_area', 'admin_name', 'email', 'role','telephone', 'address','province', 'amphur', 'district', 'zipcode', 'created_at')
                ->where('id', [$id])
                ->get();
        return [$admin];
    }
}
