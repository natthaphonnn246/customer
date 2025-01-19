<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Redirect;

class Customer extends Model
{
    protected $fillable = [

        'customer_id',
        'customer_code',
        'customer_name',
        'price_level',
        'email',
        'phone',
        'telephone',
        'address',
        'province',
        'amphur',
        'district',
        'zip_code',
        'geography',
        'admin_area',
        'sale_area',
        'text_area',
        'text_admin',
        'cert_store',
        'cert_medical',
        'cert_commerce',
        'cert_vat',
        'cert_id',
        'cert_number',
        'cert_expire',
        'status',
        'password',
        'status_update',
        'type',
        'register_by',
        'customer_status',
        'status_user',
        // 'maintenance_status',
        // 'allowed_maintenance',

    ];

    protected $table = 'customers';
    protected $connection = 'mysql';
    // public $timestamps = false;

    public static function viewCustomer($page)
    {
        $pagination = Customer::select(DB::raw('customer_id'))->get();
        $count_page = count($pagination);

        $perpage = 10;
        $total_page = ceil($count_page / $perpage);
        $start = ($perpage * $page) - $perpage;

        $customer = DB::table('customers')->select('customer_code', 'customer_name', 'email', 'status','status_update','customer_status', 'created_at')
                    ->whereNotIn('customer_code',['0000', '4494'])
                    ->offset($start)
                    ->limit($perpage)
                    ->get();

        return [$customer, $start, $total_page, $page];
    }

    public static function customerEdit($id)
    {
        $customer_edit = Customer::where('customer_id', $id)->first();

        return [$customer_edit];
    }
}
