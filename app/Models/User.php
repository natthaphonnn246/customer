<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        
        'user_code',
        'user_id',
        'admin_area',
        'name',
        'email',
        'role',
        'admin_role',
        'status_checked',
        'password',
        'telephone',
        'address',
        'province',
        'amphur',
        'district',
        'zipcode',
        'email_login',
        'text_add',
        'allowed_user_status',
        'check_login',
        'login_date',
        'last_activity',
        'is_blocked',
        'purchase_status',
    ];
    protected $table = 'users';
    protected $connection = 'mysql';
    // public $timestamps = false;
    

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public static function user()
    {
        $user = User::select('id', 'name', 'user_code','admin_area', 'email', 'status_checked','is_blocked', 'created_at')->get();
        return [$user];
    }

    public static function adminEdit ($id)
    {
        $admin = User::where('id', $id)->first();
        return $admin;
    }
}
