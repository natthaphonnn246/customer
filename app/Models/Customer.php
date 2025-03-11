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
        'delivery_by',
        // 'maintenance_status',
        // 'allowed_maintenance',

    ];

    protected $table = 'customers';
    protected $connection = 'mysql';
    // public $timestamps = false;

    public static function viewCustomer($page)
    {
        $pagination = Customer::select(DB::raw('customer_id'))
                                ->whereNotIn('customer_code',['0000', '4494'])
                                ->get();
        $count_page = count($pagination);

        $perpage = 10;
        $total_page = ceil($count_page / $perpage);
        $start = ($perpage * $page) - $perpage;

        $customer = DB::table('customers')->select('id', 'customer_code', 'customer_name', 'email', 'status','status_update','customer_status', 'created_at')
                    ->whereNotIn('customer_code',['0000', '4494'])
                    ->orderBy('id','asc')
                    ->offset($start)
                    ->limit($perpage)
                    ->get();

        return [$customer, $start, $total_page, $page];
    }

    public static function customerCompleted($page)
    {
        $pagination = Customer::select(DB::raw('customer_id'))->where('status','ดำเนินการแล้ว')->get();
        $count_page = count($pagination);

        $perpage = 10;
        $total_page = ceil($count_page / $perpage);
        $start = ($perpage * $page) - $perpage;

        $customer = DB::table('customers')->select('id', 'customer_code', 'customer_name', 'email', 'status','status_update','customer_status', 'created_at')
                    ->where('status','ดำเนินการแล้ว')
                    ->whereNotIn('customer_code',['0000', '4494'])
                    ->offset($start)
                    ->limit($perpage)
                    ->get();

        return [$customer, $start, $total_page, $page];
    }
    public static function customerAction($page)
    {
        $pagination = Customer::select(DB::raw('customer_id'))->where('status','ต้องดำเนินการ')->get();
        $count_page = count($pagination);

        $perpage = 10;
        $total_page = ceil($count_page / $perpage);
        $start = ($perpage * $page) - $perpage;

        $customer = DB::table('customers')->select('id', 'customer_code', 'customer_name', 'email', 'status','status_update','customer_status', 'created_at')
                    ->where('status','ต้องดำเนินการ')
                    ->whereNotIn('customer_code',['0000', '4494'])
                    ->offset($start)
                    ->limit($perpage)
                    ->get();

        return [$customer, $start, $total_page, $page];
    }

    public static function customerWaiting($page)
    {
        $count_page = Customer::where('status','รอดำเนินการ')->count();

        $perpage = 10;
        $total_page = ceil($count_page / $perpage);
        $start = ($perpage * $page) - $perpage;

        $customer = DB::table('customers')->select('id', 'customer_code', 'customer_name', 'email', 'status','status_update','customer_status', 'created_at')
                    ->where('status','รอดำเนินการ')
                    ->whereNotIn('customer_code',['0000', '4494'])
                    ->offset($start)
                    ->limit($perpage)
                    ->get();

        return [$customer, $start, $total_page, $page];
    }
    public static function latestUpdate($page)
    {
        $pagination = Customer::select(DB::raw('customer_id'))->where('status_update','updated')->get();
        $count_page = count($pagination);

        $perpage = 10;
        $total_page = ceil($count_page / $perpage);
        $start = ($perpage * $page) - $perpage;

        $customer = DB::table('customers')->select('id', 'customer_code', 'customer_name', 'email', 'status','status_update','customer_status', 'created_at')
                    ->where('status_update','updated')
                    ->whereNotIn('customer_code',['0000', '4494'])
                    ->offset($start)
                    ->limit($perpage)
                    ->get();

        return [$customer, $start, $total_page, $page];
    }
    public static function customerInactive($page)
    {
        $pagination = Customer::select(DB::raw('customer_id'))->where('customer_status','inactive')->get();
        $count_page = count($pagination);

        $perpage = 10;
        $total_page = ceil($count_page / $perpage);
        $start = ($perpage * $page) - $perpage;

        $customer = DB::table('customers')->select('id', 'customer_code', 'customer_name', 'email', 'status','status_update','customer_status', 'created_at')
                    ->where('customer_status','inactive')
                    ->whereNotIn('customer_code',['0000', '4494'])
                    ->offset($start)
                    ->limit($perpage)
                    ->get();

        return [$customer, $start, $total_page, $page];
    }
    public static function customerFollowing($page)
    {
        $pagination = Customer::select(DB::raw('customer_id'))->where('status_user','กำลังติดตาม')->get();
        $count_page = count($pagination);

        $perpage = 10;
        $total_page = ceil($count_page / $perpage);
        $start = ($perpage * $page) - $perpage;

        $customer = DB::table('customers')->select('id', 'customer_code', 'customer_name', 'email', 'status','status_update','customer_status', 'created_at')
                    ->where('status_user','กำลังติดตาม')
                    ->whereNotIn('customer_code',['0000', '4494'])
                    ->offset($start)
                    ->limit($perpage)
                    ->get();

        return [$customer, $start, $total_page, $page];
    }

    public static function customerEdit($id)
    {
        $customer_edit = Customer::where('id', $id)->first();

        return [$customer_edit];
    }

    public static function viewCustomerAdminArea($page, $admin_id)
    {
        $count_page = Customer::where('admin_area', $admin_id)->whereNotIn('customer_id', ['0000', '4494'])->count();

        $perpage = 10;
        $total_page = ceil($count_page / $perpage);
        $start = ($perpage * $page) - $perpage;

        $customer = DB::table('customers')->select('id', 'customer_code', 'customer_name', 'email', 'status','status_update','customer_status', 'created_at')
                    ->where('admin_area',$admin_id)
                    ->whereNotIn('customer_code',['0000', '4494'])
                    ->offset($start)
                    ->limit($perpage)
                    ->get();

        return [$customer, $start, $total_page, $page];
    }

    //รอดำเนินการ เขตรับผิดชอบว
    public static function viewCustomerAdminAreaWaiting($page, $admin_id)
    {
        $count_page = Customer::where('status', 'รอดำเนินการ')->where('admin_area', $admin_id)->whereNotIn('customer_id', ['0000', '4494'])->count();

        $perpage = 10;
        $total_page = ceil($count_page / $perpage);
        $start = ($perpage * $page) - $perpage;

        $customer = DB::table('customers')->select('id', 'customer_code', 'customer_name', 'email', 'status','status_update','customer_status', 'created_at')
                    ->where('status', 'รอดำเนินการ')
                    ->where('admin_area',$admin_id)
                    ->whereNotIn('customer_code',['0000', '4494'])
                    ->offset($start)
                    ->limit($perpage)
                    ->get();

        return [$customer, $start, $total_page, $page];
    }

    //ต้องดำเนินการ เขตรับผิดชอบว
    public static function viewCustomerAdminAreaAction($page, $admin_id)
    {
        $count_page = Customer::where('status', 'ต้องดำเนินการ')->where('admin_area', $admin_id)->whereNotIn('customer_id', ['0000', '4494'])->count();

        $perpage = 10;
        $total_page = ceil($count_page / $perpage);
        $start = ($perpage * $page) - $perpage;

        $customer = DB::table('customers')->select('id', 'customer_code', 'customer_name', 'email', 'status','status_update','customer_status', 'created_at')
                    ->where('status', 'ต้องดำเนินการ')
                    ->where('admin_area',$admin_id)
                    ->whereNotIn('customer_code',['0000', '4494'])
                    ->offset($start)
                    ->limit($perpage)
                    ->get();

        return [$customer, $start, $total_page, $page,  $count_page];
    }

     //ดำเนินการแล้ว เขตรับผิดชอบว
     public static function viewCustomerAdminAreaCompleted($page, $admin_id)
     {
         $count_page = Customer::where('status', 'ดำเนินการแล้ว')->where('admin_area', $admin_id)->whereNotIn('customer_id', ['0000', '4494'])->count();
 
         $perpage = 10;
         $total_page = ceil($count_page / $perpage);
         $start = ($perpage * $page) - $perpage;
 
         $customer = DB::table('customers')->select('id', 'customer_code', 'customer_name', 'email', 'status','status_update','customer_status', 'created_at')
                     ->where('status', 'ดำเนินการแล้ว')
                     ->where('admin_area',$admin_id)
                     ->whereNotIn('customer_code',['0000', '4494'])
                     ->offset($start)
                     ->limit($perpage)
                     ->get();
 
         return [$customer, $start, $total_page, $page];
     }
}
