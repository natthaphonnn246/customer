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
        'status_checked',
        'password',
        'telephone',
        'address',
        'province',
        'amphur',
        'district',
        'zipcode',
        'email_login',
        'text_add'
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
        $user = User::select('name', 'user_code','admin_area', 'email', 'status_checked', 'created_at')->get();
        return [$user];
    }

    public static function adminEdit ($code)
    {
        $admin = User::select('user_code', 'name','admin_area', 'email','email_login', 'role','telephone', 'address','province', 'amphur', 'district', 'zipcode', 'created_at', 'text_add')
                ->where('user_code', [$code])
                ->get();
        return [$admin];
    }
}