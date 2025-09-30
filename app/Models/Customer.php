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
        'points',
        'add_license',
        // 'maintenance_status',
        // 'allowed_maintenance',

    ];

    protected $table = 'customers';
    protected $connection = 'mysql';
    // public $timestamps = false;

    public static function viewCustomer($page)
    {
        //notin code;
        $code_notin = ['0000', '4494', '7787', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];
        // dd($code_notin);
        $pagination = DB::table('customers')->select(DB::raw('customer_id'))
                        // ->whereNotIn('customer_code',['0000', '4494'])
                        ->whereNotIn('customer_code',$code_notin)
                        ->get();

        $count_page = count($pagination);

        $perpage = 10;
        $total_page = ceil($count_page / $perpage);
        $start = ($perpage * $page) - $perpage;

        $customer = DB::table('customers')->select('id', 'customer_code', 'customer_name', 'email', 'status','status_update','customer_status', 'created_at')
                    // ->whereNotIn('customer_code',['0000', '4494'])
                    ->whereNotIn('customer_code',$code_notin)
                    ->orderBy('id','asc')
                    ->offset($start)
                    ->limit($perpage)
                    ->get();

        return [$customer, $start, $total_page, $page];
    }

    public static function customerCompleted($page)
    {
        //notin code;
        $code_notin = ['0000', '4494', '7787', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];

        $pagination = DB::table('customers')->select(DB::raw('customer_id'))
                        ->whereNotIn('customer_code',$code_notin)
                        ->where('status','ดำเนินการแล้ว')
                        ->get();

        $count_page = count($pagination);
        // dd($count_page);

        $perpage = 10;
        $total_page = ceil($count_page / $perpage);
        $start = ($perpage * $page) - $perpage;

        $customer = DB::table('customers')->select('id', 'customer_code', 'customer_name', 'email', 'status','status_update','customer_status', 'created_at')
                    ->where('status','ดำเนินการแล้ว')
                    // ->whereNotIn('customer_code',['0000', '4494'])
                    ->whereNotIn('customer_code',$code_notin)
                    ->offset($start)
                    ->limit($perpage)
                    ->get();

        return [$customer, $start, $total_page, $page];
    }
    public static function customerAction($page)
    {

        //notin code;
        $code_notin = ['0000', '4494', '7787', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];

        $pagination = DB::table('customers')->select(DB::raw('customer_id'))
                        ->whereNotIn('customer_code',$code_notin)
                        ->where('status','ต้องดำเนินการ')
                        ->get();

        $count_page = count($pagination);

        $perpage = 10;
        $total_page = ceil($count_page / $perpage);
        $start = ($perpage * $page) - $perpage;

        $customer = DB::table('customers')->select('id', 'customer_code', 'customer_name', 'email', 'status','status_update','customer_status', 'created_at')
                    ->where('status','ต้องดำเนินการ')
                    // ->whereNotIn('customer_code',['0000', '4494'])
                    ->whereNotIn('customer_code', $code_notin)
                    ->offset($start)
                    ->limit($perpage)
                    ->get();

        return [$customer, $start, $total_page, $page];
    }

    public static function customerRegistration($page)
    {
        //notin code;
        $code_notin = ['0000', '4494', '7787', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];

        $count_page = DB::table('customers')->where('status','ลงทะเบียนใหม่')
                        ->whereNotIn('customer_code',$code_notin)
                        ->count();

        $perpage = 10;
        $total_page = ceil($count_page / $perpage);
        $start = ($perpage * $page) - $perpage;

        $customer = DB::table('customers')->select('id', 'customer_code', 'customer_name', 'email', 'status','status_update','customer_status', 'created_at')
                    ->where('status','ลงทะเบียนใหม่')
                    // ->whereNotIn('customer_code',['0000', '4494'])
                    ->whereNotIn('customer_code', $code_notin)
                    ->offset($start)
                    ->limit($perpage)
                    ->get();

        return [$customer, $start, $total_page, $page];
    }
    public static function customerWaiting($page)
    {
        //notin code;
        $code_notin = ['0000', '4494', '7787', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];

        $count_page = DB::table('customers')->where('status','รอดำเนินการ')
                        ->whereNotIn('customer_code',$code_notin)
                        ->count();

        $perpage = 10;
        $total_page = ceil($count_page / $perpage);
        $start = ($perpage * $page) - $perpage;

        $customer = DB::table('customers')->select('id', 'customer_code', 'customer_name', 'email', 'status','status_update','customer_status', 'created_at')
                    ->where('status','รอดำเนินการ')
                    // ->whereNotIn('customer_code',['0000', '4494'])
                    ->whereNotIn('customer_code', $code_notin)
                    ->offset($start)
                    ->limit($perpage)
                    ->get();

        return [$customer, $start, $total_page, $page];
    }
    public static function latestUpdate($page)
    {
        //notin code;
        $code_notin = ['0000', '4494', '7787', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];

        $pagination = DB::table('customers')->select(DB::raw('customer_id'))
                        ->whereNotIn('customer_code',$code_notin)
                        ->where('status_update','updated')
                        ->get();

        $count_page = count($pagination);

        $perpage = 10;
        $total_page = ceil($count_page / $perpage);
        $start = ($perpage * $page) - $perpage;

        $customer = DB::table('customers')->select('id', 'customer_code', 'customer_name', 'email', 'status','status_update','customer_status', 'created_at')
                    ->where('status_update','updated')
                    // ->whereNotIn('customer_code',['0000', '4494'])
                    ->whereNotIn('customer_code', $code_notin)
                    ->offset($start)
                    ->limit($perpage)
                    ->get();

        return [$customer, $start, $total_page, $page];
    }
    public static function customerInactive($page)
    {

        //notin code;
        $code_notin = ['0000', '4494', '7787', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];

        $pagination = DB::table('customers')->select(DB::raw('customer_id'))
                        ->whereNotIn('customer_code',$code_notin)
                        ->where('customer_status','inactive')
                        ->get();

        $count_page = count($pagination);

        $perpage = 10;
        $total_page = ceil($count_page / $perpage);
        $start = ($perpage * $page) - $perpage;

        $customer = DB::table('customers')->select('id', 'customer_code', 'customer_name', 'email', 'status','status_update','customer_status', 'created_at')
                    ->where('customer_status','inactive')
                    // ->whereNotIn('customer_code',['0000', '4494'])
                    ->whereNotIn('customer_code', $code_notin)
                    ->offset($start)
                    ->limit($perpage)
                    ->get();

        return [$customer, $start, $total_page, $page];
    }
    public static function customerFollowing($page)
    {

        //notin code;
        $code_notin = ['0000', '4494', '7787', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];

        $pagination = DB::table('customers')->select(DB::raw('customer_id'))
                        ->whereNotIn('customer_code',$code_notin)
                        ->where('status_user','กำลังติดตาม')
                        ->get();

        $count_page = count($pagination);

        $perpage = 10;
        $total_page = ceil($count_page / $perpage);
        $start = ($perpage * $page) - $perpage;

        $customer = DB::table('customers')->select('id', 'customer_code', 'customer_name', 'email', 'status','status_update','customer_status', 'created_at')
                    ->where('status_user','กำลังติดตาม')
                    ->whereNotIn('customer_code', $code_notin)
                    ->offset($start)
                    ->limit($perpage)
                    ->get();

        return [$customer, $start, $total_page, $page];
    }
    public static function customerCheckLicense($page)
    {

        //notin code;
        $code_notin = ['0000', '4494', '7787', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];

        $pagination = DB::table('customers')->select(DB::raw('customer_id'))
                        ->whereNotIn('customer_code',$code_notin)
                        ->where('add_license','ระบุขายส่ง')
                        ->get();

        $count_page = count($pagination);

        $perpage = 10;
        $total_page = ceil($count_page / $perpage);
        $start = ($perpage * $page) - $perpage;

        $customer = DB::table('customers')->select('id', 'customer_code', 'customer_name', 'email', 'status','status_update','customer_status', 'created_at')
                    ->where('add_license','ระบุขายส่ง')
                    ->whereNotIn('customer_code', $code_notin)
                    ->offset($start)
                    ->limit($perpage)
                    ->get();

        return [$customer, $start, $total_page, $page];
    }

    public static function customerCheckLicense_1($page)
    {

        //notin code;
        $code_notin = ['0000', '4494', '7787','8118', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];

        $pagination = DB::table('customers')->select(DB::raw('customer_id'))
                        ->whereNotIn('customer_code',$code_notin)
                        ->where('type','ข.ย.1')
                        ->get();

        $count_page = count($pagination);

        $perpage = 10;
        $total_page = ceil($count_page / $perpage);
        $start = ($perpage * $page) - $perpage;

        $customer = DB::table('customers')->select('id', 'customer_code', 'customer_name', 'email', 'status','status_update','customer_status', 'created_at')
                    ->where('type','ข.ย.1')
                    ->whereNotIn('customer_code', $code_notin)
                    ->offset($start)
                    ->limit($perpage)
                    ->get();

        return [$customer, $start, $total_page, $page];
    }

    public static function customerCheckLicense_2($page)
    {

        //notin code;
        $code_notin = ['0000', '4494', '7787','8118', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];

        $pagination = DB::table('customers')->select(DB::raw('customer_id'))
                        ->whereNotIn('customer_code',$code_notin)
                        ->where('type','ข.ย.2')
                        ->get();

        $count_page = count($pagination);

        $perpage = 10;
        $total_page = ceil($count_page / $perpage);
        $start = ($perpage * $page) - $perpage;

        $customer = DB::table('customers')->select('id', 'customer_code', 'customer_name', 'email', 'status','status_update','customer_status', 'created_at')
                    ->where('type','ข.ย.2')
                    ->whereNotIn('customer_code', $code_notin)
                    ->offset($start)
                    ->limit($perpage)
                    ->get();

        return [$customer, $start, $total_page, $page];
    }

    public static function customerCheckLicense_3($page)
    {

        //notin code;
        $code_notin = ['0000', '4494', '7787','8118', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];

        $pagination = DB::table('customers')->select(DB::raw('customer_id'))
                        ->whereNotIn('customer_code',$code_notin)
                        ->where('type','สมพ.2')
                        ->get();

        $count_page = count($pagination);

        $perpage = 10;
        $total_page = ceil($count_page / $perpage);
        $start = ($perpage * $page) - $perpage;

        $customer = DB::table('customers')->select('id', 'customer_code', 'customer_name', 'email', 'status','status_update','customer_status', 'created_at')
                    ->where('type','สมพ.2')
                    ->whereNotIn('customer_code', $code_notin)
                    ->offset($start)
                    ->limit($perpage)
                    ->get();

        return [$customer, $start, $total_page, $page];
    }

    public static function customerCheckLicense_4($page)
    {

        //notin code;
        $code_notin = ['0000', '4494', '7787','8118', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];

        $pagination = DB::table('customers')->select(DB::raw('customer_id'))
                        ->whereNotIn('customer_code',$code_notin)
                        ->where('type','คลินิกยา/สถานพยาบาล')
                        ->get();

        $count_page = count($pagination);

        $perpage = 10;
        $total_page = ceil($count_page / $perpage);
        $start = ($perpage * $page) - $perpage;

        $customer = DB::table('customers')->select('id', 'customer_code', 'customer_name', 'email', 'status','status_update','customer_status', 'created_at')
                    ->where('type','คลินิกยา/สถานพยาบาล')
                    ->whereNotIn('customer_code', $code_notin)
                    ->offset($start)
                    ->limit($perpage)
                    ->get();

        return [$customer, $start, $total_page, $page];
    }

    public static function customerCheckLicense_5($page)
    {

        //notin code;
        $code_notin = ['0000', '4494', '7787','8118', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];

        $pagination = DB::table('customers')->select(DB::raw('customer_id'))
                        ->whereNotIn('customer_code',$code_notin)
                        ->where('type','')
                        ->get();

        $count_page = count($pagination);

        $perpage = 10;
        $total_page = ceil($count_page / $perpage);
        $start = ($perpage * $page) - $perpage;

        $customer = DB::table('customers')->select('id', 'customer_code', 'customer_name', 'email', 'status','status_update','customer_status', 'created_at')
                    ->where('type','')
                    ->whereNotIn('customer_code', $code_notin)
                    ->offset($start)
                    ->limit($perpage)
                    ->get();

        return [$customer, $start, $total_page, $page];
    }

    public static function customerEdit($id)
    {
        $customer_edit = DB::table('customers')->where('id', $id)->first();

        return [$customer_edit];
    }

    public static function viewCustomerAdminArea($page, $admin_id)
    {

        //notin code;
        $code_notin = ['0000', '4494', '7787', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];

        // $count_page = Customer::where('admin_area', $admin_id)->whereNotIn('customer_id', ['0000', '4494'])->count();
        $count_page = DB::table('customers')->where('admin_area', $admin_id)->whereNotIn('customer_id', $code_notin)->count();

        $perpage = 10;
        $total_page = ceil($count_page / $perpage);
        $start = ($perpage * $page) - $perpage;

        $customer = DB::table('customers')->select('id', 'customer_code', 'customer_name', 'email', 'status','status_update','customer_status', 'created_at')
                    ->where('admin_area',$admin_id)
                    // ->whereNotIn('customer_code',['0000', '4494'])
                    ->whereNotIn('customer_code', $code_notin)
                    ->offset($start)
                    ->limit($perpage)
                    ->get();

        return [$customer, $start, $total_page, $page];
    }

    //รอดำเนินการ เขตรับผิดชอบว
    public static function viewCustomerAdminAreaWaiting($page, $admin_id)
    {

        //notin code;
        $code_notin = ['0000', '4494', '7787', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];

        // $count_page = Customer::where('status', 'รอดำเนินการ')->where('admin_area', $admin_id)->whereNotIn('customer_id', ['0000', '4494'])->count();
        $count_page = DB::table('customers')->where('status', 'รอดำเนินการ')->where('admin_area', $admin_id)->whereNotIn('customer_id', $code_notin)->count();

        $perpage = 10;
        $total_page = ceil($count_page / $perpage);
        $start = ($perpage * $page) - $perpage;

        $customer = DB::table('customers')->select('id', 'customer_code', 'customer_name', 'email', 'status','status_update','customer_status', 'created_at')
                    ->where('status', 'รอดำเนินการ')
                    ->where('admin_area',$admin_id)
                    // ->whereNotIn('customer_code',['0000', '4494'])
                    ->whereNotIn('customer_code', $code_notin)
                    ->offset($start)
                    ->limit($perpage)
                    ->get();

        return [$customer, $start, $total_page, $page];
    }

    //ต้องดำเนินการ เขตรับผิดชอบว
    public static function viewCustomerAdminAreaAction($page, $admin_id)
    {
        //notin code;
        $code_notin = ['0000', '4494', '7787', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];

        // $count_page = Customer::where('status', 'ต้องดำเนินการ')->where('admin_area', $admin_id)->whereNotIn('customer_id', ['0000', '4494'])->count();
        $count_page = DB::table('customers')->where('status', 'ต้องดำเนินการ')->where('admin_area', $admin_id)->whereNotIn('customer_id', $code_notin)->count();

        $perpage = 10;
        $total_page = ceil($count_page / $perpage);
        $start = ($perpage * $page) - $perpage;

        $customer = DB::table('customers')->select('id', 'customer_code', 'customer_name', 'email', 'status','status_update','customer_status', 'created_at')
                    ->where('status', 'ต้องดำเนินการ')
                    ->where('admin_area',$admin_id)
                    // ->whereNotIn('customer_code',['0000', '4494'])
                    ->whereNotIn('customer_code', $code_notin)
                    ->offset($start)
                    ->limit($perpage)
                    ->get();

        return [$customer, $start, $total_page, $page,  $count_page];
    }

     //ดำเนินการแล้ว เขตรับผิดชอบว
     public static function viewCustomerAdminAreaCompleted($page, $admin_id)
     {

        //notin code;
        $code_notin = ['0000', '4494', '7787', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];

        // $count_page = Customer::where('status', 'ดำเนินการแล้ว')->where('admin_area', $admin_id)->whereNotIn('customer_id', ['0000', '4494'])->count();
        $count_page = DB::table('customers')->where('status', 'ดำเนินการแล้ว')->where('admin_area', $admin_id)->whereNotIn('customer_id', $code_notin)->count();

        $perpage = 10;
        $total_page = ceil($count_page / $perpage);
        $start = ($perpage * $page) - $perpage;

        $customer = DB::table('customers')->select('id', 'customer_code', 'customer_name', 'email', 'status','status_update','customer_status', 'created_at')
                    ->where('status', 'ดำเนินการแล้ว')
                    ->where('admin_area',$admin_id)
                    // ->whereNotIn('customer_code',['0000', '4494'])
                    ->whereNotIn('customer_code',$code_notin)
                    ->offset($start)
                    ->limit($perpage)
                    ->get();

        return [$customer, $start, $total_page, $page];
     }

     public static function viewCustomerAdminAreaRegistration($page, $admin_id)
     {

        //notin code;
        $code_notin = ['0000', '4494', '7787', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];

        // $count_page = Customer::where('status', 'ดำเนินการแล้ว')->where('admin_area', $admin_id)->whereNotIn('customer_id', ['0000', '4494'])->count();
        $count_page = DB::table('customers')->where('status', 'ดำเนินการแล้ว')->where('admin_area', $admin_id)->whereNotIn('customer_id', $code_notin)->count();

        $perpage = 10;
        $total_page = ceil($count_page / $perpage);
        $start = ($perpage * $page) - $perpage;

        $customer = DB::table('customers')->select('id', 'customer_code', 'customer_name', 'email', 'status','status_update','customer_status', 'created_at')
                    ->where('status', 'ลงทะเบียนใหม่')
                    ->where('admin_area',$admin_id)
                    // ->whereNotIn('customer_code',['0000', '4494'])
                    ->whereNotIn('customer_code',$code_notin)
                    ->offset($start)
                    ->limit($perpage)
                    ->get();

        return [$customer, $start, $total_page, $page];
     }
}
