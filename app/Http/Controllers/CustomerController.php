<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use App\Models\Customer;
use App\Models\Province;
use Illuminate\Http\File;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CustomerController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {

        @$page = $_GET['page'];
        if ($page) {
            $page = $_GET['page'];
        } else {
            $page = 1;
        }

        $row_customer = Customer::viewCustomer($page);
        $customer = $row_customer[0];
        $start = $row_customer[1];
        $total_page = $row_customer[2];
        $page = $row_customer[3];

        return view('webpanel/customer', compact('customer', 'start', 'total_page', 'page'));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function customerCreate() {

        $provinces = Province::province();
        $admin_area_list = User::select('admin_area', 'name', 'rights_area')->get();

        return view('webpanel/customer-create', compact('provinces', 'admin_area_list'));
    }
    public function create(Request $request)
    {
        // dd($request->customer_code);
        date_default_timezone_set("Asia/Bangkok");

        if($request->has('submit_form') == true)
        {

            $request->validate([
                'customer_code' => 'required|max: 4',
        
            ]);

            $customer_id = $request->customer_code;
            $customer_code = $request->customer_code;
            $customer_name = $request->customer_name;
            $price_level = $request->price_level;
            $email = $request->email;
            if($email == null) {
                $email = '';
            }
            $phone = $request->phone;
            if($phone == null) {
                $phone = '';
            }

            $telephone = $request->telephone;
            if($telephone == null) {
                $telephone = '';
            }

            $address = $request->address;
            $province = $request->province;
            $amphur = $request->amphur;
            $district = $request->district;
            $zip_code = $request->zip_code;

            $sale_area = $request->sale_area;
            if($sale_area == null) {
                $sale_area = '';
            }

            $admin_area = $request->admin_area;
            if($admin_area == null) {
                $admin_area = '';
            }

            $text_area = $request->text_add;
            if($text_area == null) {
                $text_area = '';
            }

            $cert_number = $request->cert_number;
            if($cert_number == null) {
                $cert_number = '';
            }
    
            $cert_store = $request->file('cert_store');
            $cert_medical = $request->file('cert_medical');
            $cert_commerce = $request->file('cert_commerce');
            $cert_vat = $request->file('cert_vat');
            $cert_id = $request->file('cert_id');
       
            $cert_expire = $request->cert_expire;
            $status = '';

        }   

            if($cert_store != '' && $customer_id != '')
            {
                $image_cert_store = $request->file('cert_store')->storeAs('img_certstore', $customer_id.'_certstore.jpg');
            } else {
                $image_cert_store = '';
            }

            if($cert_medical != '' && $customer_id != '')
            {
                $image_cert_medical = $request->file('cert_medical')->storeAs('img_certmedical', $customer_id.'_certmedical.jpg');
            } else {
                $image_cert_medical = '';
            }

            if($cert_commerce != '' && $customer_id != '')
            {
                $image_cert_commerce = $request->file('cert_commerce')->storeAs('img_certcommerce', $customer_id.'_certcommerce.jpg');
            } else {
                $image_cert_commerce = '';
            }

            if($cert_vat != '' && $customer_id != '')
            {
                $image_cert_vat = $request->file('cert_vat')->storeAs('img_certvat', $customer_id.'_certvat.jpg');
            } else {
                $image_cert_vat = '';
            }

            if($cert_id != '' && $customer_id != '')
            {
                $image_cert_id = $request->file('cert_id')->storeAs('img_certid', $customer_id.'_certid.jpg');
            } else {
                $image_cert_id = '';
            }

            $province_master = DB::table('provinces')->select('id', 'name_th')->whereIn('id', [$province])->get();
            foreach ($province_master as $row)
            {
                $province_row = $row->name_th;
            }

       /*  $customer = new Customer;
        $customer->customer_code = $request->customer_code;
        $customer->save(); */

       Customer::create([

                    'customer_id' => $customer_id,
                    'customer_code' => $customer_code,
                    'customer_name' => $customer_name,
                    'price_level' => $price_level,
                    'email' => $email,
                    'phone' => $phone,
                    'telephone' => $telephone,
                    'address' => $address,
                    'province' =>  $province_row,
                    'amphur' => $amphur,
                    'district' => $district,
                    'zip_code' => $zip_code,
                    'geography' => '',
                    'admin_area' => $admin_area,
                    'sale_area' => $sale_area,
                    'text_area' => $text_area,
                    'text_admin' => '',
                    'cert_store' => $image_cert_store,
                    'cert_medical' =>  $image_cert_medical,
                    'cert_commerce' => $image_cert_commerce,
                    'cert_vat' => $image_cert_vat,
                    'cert_id' => $image_cert_id,
                    'cert_number' => $cert_number,
                    'cert_expire' => $cert_expire,
                    'status' => $status,
                    'password' => '',
                    'status_code' => '',
                    'status_update' => '',
                    'type' => '',
                    // 'maintenance_status' => '',
                    // 'allowed_maintenance' => '',

                ]);

                return redirect('/webpanel/customer');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        $customer_edit = Customer::customerEdit($id);
        $customer_view = $customer_edit[0];

        $admin_area_list  = User::select('admin_area', 'name', 'rights_area')->get();

        $admin_area_check = Customer::select('admin_area')->where('customer_code', $id)->first();
        // dd($admin_area_check->admin_area);

        $province = DB::table('provinces')->select('id', 'name_th')->orderBy('id', 'asc')->get();
        $amphur = DB::table('amphures')->select('name_th', 'province_id')->get();
        $district = DB::table('districts')->select('name_th', 'amphure_id')->get();

        return view('webpanel/customer-detail', compact('customer_view', 'province', 'amphur', 'district', 'admin_area_list', 'admin_area_check'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        date_default_timezone_set("Asia/Bangkok");
/* 
        if($request->has('submit_update'))
        { */
                $customer_id = $request->customer_code;
                $customer_name = $request->customer_name;
                $price_level = $request->price_level;
                $phone = $request->phone;
                if($phone == null) {
                    $phone = '';
                }
                $telephone = $request->telephone;
                $address = $request->address;
                $province = $request->province;
                $amphur = $request->amphur;
                $district = $request->district;
                $zip_code = $request->zip_code;
                $admin_area = $request->admin_area;
                $email = $request->email;
                if($email == null) {
                    $email = '';
                }
                $text_area = $request->text_add;
                if($text_area == null) {
                    $text_area = '';
                }
                $text_admin = $request->text_admin;
                if($text_admin == null) {
                    $text_admin = '';
                }
                $sale_area = $request->sale_area;
                if($sale_area == null) {
                    $sale_area = '';
                }
                $cert_number = $request->cert_number;
                if($cert_number == null) {
                    $cert_number = '';
                }
                $password = $request->password;
                if($password == null) {
                    $password = '';
                }
                $cert_expire = $request->cert_expire;
                $status = $request->status;

                $status_update = $request->status_update;
                if($status_update == null) {
                    $status_update = '';
                }

                $province_master = DB::table('provinces')->select('id', 'name_th', 'geography_id')->where('id', $province)->first();
                $province_row = $province_master->name_th;

                if(!empty($province_row)) {
                    $geography_id = $province_master->geography_id;
                    $geography = DB::table('geographies')->select('name')->where('id', $geography_id)->first();
                    $geography_name = $geography->name;

                } else {
                    $geography_name = $request->geography;
                }

                $type = $request->type;
                if($type == null) {
                    $type = '';
                }

     /*    } */
            Customer::where('customer_id', $id)
                    ->update ([

                        /* 'customer_id' => $customer_id,
                        'customer_code' => $customer_code, */
                        'customer_name' => $customer_name,
                        'price_level' => $price_level,
                        'customer_name' => $customer_name,
                        'email' => $email,
                        'phone' => $phone,
                        'telephone' => $telephone,
                        'address' => $address,
                        'province' =>  $province_row,
                        'amphur' => $amphur,
                        'district' => $district,
                        'zip_code' => $zip_code,
                        'geography' => $geography_name,
                        'admin_area' => $admin_area,
                        'sale_area' => $sale_area,
                        'text_area' => $text_area,
                        'text_admin' => $text_admin,
                        'cert_number' => $cert_number,
                        'cert_expire' => $cert_expire,
                        'status' => $status,
                        'password' => $password,
                        'status_update' => $status_update,
                        'type' => $type,
                        // 'maintenance_status' => '',
                        // 'allowed_maintenance' => '',
                    
                    ]);

                // check user id;
                $check_customer_id = Customer::select('customer_id')->where('customer_id', $id)->first();
                $customer_id =  $check_customer_id->customer_id;

                if ($customer_id == $id)
                {
                    echo 'success';
                //    return redirect('/webpanel/customer/'.$id)->with('success', 'check_success');
                }
                else {
                    echo 'fail';
                }
            
    }

    public function certStore(Request $request, $id)
    {

            if($request->has('submit_store'))
            {

                $check_cert_store = $request->file('cert_store');
                $cert_store = $check_cert_store;
    
                if($cert_store != '' && $id != '') {
                    $image_cert_store = $request->file('cert_store')->storeAs('img_certstore', $id.'_certstore.jpg');

                } else if ($cert_store == '') {
                    $cert_store_old = Customer::select('cert_store')->where('customer_id', $id)->first();
                    $image_cert_store = $cert_store_old->cert_store;

                } else {
                    $image_cert_store = '';
                }

                Customer::where('customer_id', $id)
                        ->update ([

                            'cert_store' => $image_cert_store,

                        ]);

            }
            return back();
    }

    public function certMedical(Request $request, $id)
    {

            if($request->has('submit_medical'))
            {

                $check_cert_medical = $request->file('cert_medical');
                $cert_medical =  $check_cert_medical ;

                if($cert_medical != '' && $id != '') {
                    $image_cert_medical = $request->file('cert_medical')->storeAs('img_certmedical', $id.'_certmedical.jpg');

                } else if ($cert_medical == '') {
                    $cert_medical_old = Customer::select('cert_medical')->where('customer_id',$id)->first();
                    $image_cert_medical = $cert_medical_old->cert_medical;

                } else {
                    $image_cert_medical = '';
                }

                Customer::where('customer_id', $id)
                        ->update ([
                            
                            'cert_medical' =>  $image_cert_medical,

                        ]);

            }
            return back();
    }

    public function certCommerce(Request $request, $id)
    {

            if($request->has('cert_commerce'))
            {
                $check_cert_commerce = $request->file('cert_commerce');
                $cert_commerce = $check_cert_commerce;

                if($cert_commerce != '' && $id != '')
                {
                    $image_cert_commerce = $request->file('cert_commerce')->storeAs('img_certcommerce', $id.'_certcommerce.jpg');

                } elseif($cert_commerce == '') {
                    $cert_commerce_old = Customer::select('cert_commerce')->where('customer_id', $id)->first();
                    $image_cert_commerce = $cert_commerce_old->cert_commerce;

                } else {
                    $image_cert_commerce = '';
                }
        
                Customer::where('customer_id', $id)
                        ->update ([

                            'cert_commerce' =>  $image_cert_commerce,

                        ]);

            }
            return back();
    }

    public function certVat(Request $request, $id)
    {

            if($request->has('submit_vat'))
            {
                $check_cert_vat = $request->file('cert_vat');
                $cert_vat = $check_cert_vat;

                if($cert_vat != '' && $id != '') {
                    $image_cert_vat = $request->file('cert_vat')->storeAs('img_certvat', $id.'_certvat.jpg');

                } else if($cert_vat == '') {
                    $cert_vat_old = Customer::select('cert_vat')->where('customer_id', $id)->first();
                    $image_cert_vat = $cert_vat_old->cert_vat;

                } else {
                    $image_cert_vat = '';
                }
        
                Customer::where('customer_id', $id)
                        ->update ([

                            'cert_vat' =>  $image_cert_vat,

                        ]);

            }
            return back();
    }

    public function certId(Request $request, $id)
    {

            if($request->has('submit_id'))
            {
                $check_cert_id = $request->file('cert_id');
                $cert_id = $check_cert_id;

                if($cert_id != '' && $id != '') {
                    $image_cert_id = $request->file('cert_id')->storeAs('img_certid', $id.'_certid.jpg');

                } elseif ($cert_id == '') {
                    $cert_id_old = Customer::select('cert_id')->where('customer_id', $id)->first();
                    $image_cert_id = $cert_id_old->cert_id;

                } else {
                    $image_cert_id = '';
                } 
        
                Customer::where('customer_id', $id)
                        ->update ([

                            'cert_id' =>  $image_cert_id,

                        ]);

            }
            return back();
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }

    public function indexPortal(Request $request)
    {
            $code = $request->user()->user_code;
        
            $user_name = User::select('name', 'admin_area','user_code')->where('user_code', $code)->first();
            $admin_area_list = User::select('admin_area', 'name', 'rights_area')->where('user_code', $code)->first();

            $provinces = Province::province();
            return view('portal/signin', compact('provinces', 'user_name', 'admin_area_list'));
    }

    public function portalSign(Request $request)
    {
            $code = $request->user()->user_code;
        
            $user_name = User::select('name', 'admin_area','user_code')->where('user_code', $code)->first();
            $admin_area_list = User::select('admin_area', 'name', 'rights_area')->get();

            $provinces = Province::province();
            return view('portal/portal-sign', compact('provinces', 'user_name', 'admin_area_list'));
    }

    public function signin(Request $request)
    {
        // dd($request->customer_code);
        // date_default_timezone_set("Asia/Bangkok");

        if($request->has('submit_form'))
        {

            date_default_timezone_set("Asia/Bangkok");

            $request->validate([
                'customer_code' => 'required|max: 4',
            ]);

            $customer_id = $request->customer_code;
            $customer_code = $request->customer_code;
            $customer_name = $request->customer_name;
            $price_level = $request->price_level;

            $email = $request->email;
            if($email == null) {
                $email = '';
            }

            $phone = $request->phone;
            if($phone == null) {
                $phone = '';
            }

            $telephone = $request->telephone;
            $address = $request->address;
            $province = $request->province;
            $amphur = $request->amphur;
            $district = $request->district;
            $zip_code = $request->zip_code;

            $sale_area = $request->sale_area;
            if($sale_area == null) {
                $sale_area = '';
            }

            $text_area = $request->text_add;
            if($text_area == null) {
                $text_area = '';
            }

            $cert_number = $request->cert_number;
            if($cert_number == null) {
                $cert_number = '';
            }

            $admin_area = $request->admin_area;
            $cert_store = $request->file('cert_store');
            $cert_medical = $request->file('cert_medical');
            $cert_commerce = $request->file('cert_commerce');
            $cert_vat = $request->file('cert_vat');
            $cert_id = $request->file('cert_id');

            $cert_expire = $request->cert_expire;
            $status = '';
        }   

            if($cert_store != '' && $customer_id != '')
            {
                $image_cert_store = $request->file('cert_store')->storeAs('img_certstore', $customer_id.'_certstore.jpg');
            } else {
                $image_cert_store = '';
            }

            if($cert_medical != '' && $customer_id != '')
            {
                $image_cert_medical = $request->file('cert_medical')->storeAs('img_certmedical', $customer_id.'_certmedical.jpg');
            } else {
                $image_cert_medical = '';
            }

            if($cert_commerce != '' && $customer_id != '')
            {
                $image_cert_commerce = $request->file('cert_commerce')->storeAs('img_certcommerce', $customer_id.'_certcommerce.jpg');
            } else {
                $image_cert_commerce = '';
            }

            if($cert_vat != '' && $customer_id != '')
            {
                $image_cert_vat = $request->file('cert_vat')->storeAs('img_certvat', $customer_id.'_certvat.jpg');
            } else {
                $image_cert_vat = '';
            }

            if($cert_id != '' && $customer_id != '')
            {
                $image_cert_id = $request->file('cert_id')->storeAs('img_certid', $customer_id.'_certid.jpg');
            } else {
                $image_cert_id = '';
            }

            $province_master = DB::table('provinces')->select('id', 'name_th')->whereIn('id', [$province])->get();
            foreach ($province_master as $row)
            {
                $province_row = $row->name_th;
            }

       /*  $customer = new Customer;
        $customer->customer_code = $request->customer_code;
        $customer->save(); */

        $customer = Customer::where('customer_code', $customer_code)->first();
        // dd($customer);

        if($customer == null)
        {
            Customer::create([

                        'customer_id' => $customer_id,
                        'customer_code' => $customer_code,
                        'customer_name' => $customer_name,
                        'price_level' => $price_level,
                        'email' => $email,
                        'phone' => $phone,
                        'telephone' => $telephone,
                        'address' => $address,
                        'province' =>  $province_row,
                        'amphur' => $amphur,
                        'district' => $district,
                        'zip_code' => $zip_code,
                        'geography' => '',
                        'admin_area' => $admin_area,
                        'sale_area' => $sale_area,
                        'text_area' => $text_area,
                        'text_admin' => '',
                        'cert_store' => $image_cert_store,
                        'cert_medical' =>  $image_cert_medical,
                        'cert_commerce' => $image_cert_commerce,
                        'cert_vat' => $image_cert_vat,
                        'cert_id' => $image_cert_id,
                        'cert_number' => $cert_number,
                        'cert_expire' => $cert_expire,
                        'status' => $status,
                        'password' => '',
                        'status_update' => '',
                        'type' => '',
                        // 'maintenance_status' => '',
                        // 'allowed_maintenance' => '',

                    ]);

        } else {

            return back()->with('error_code', 'ลงทะเบียนไม่สำเร็จ กรุณาตรวจสอบอีกรอบครับ');

        }

            return back()->with('success', 'ลงทะเบียนสำเร็จ กรุณาติดต่อผู้ดูแลด้วยครับ');

    }

    public function customerView(Request $request)
    {
        
        $id = $request->user()->admin_area;
        $code = $request->user()->user_code;
        
        $user_name = User::select('name', 'admin_area','user_code')->where('user_code', $code)->get();
        $admin_area = DB::table('customers')->select('admin_area', 'customer_code', 'customer_name', 'sale_area', 'status', 'email', 'created_at')->whereIn('admin_area', [$id])->get();
  
        return view('portal/customer', compact('admin_area', 'user_name'));
    }

    public function customerEdit(Request $request, $id) 
    {
        $customer_edit = Customer::customerEdit($id);
        $customer_edit = $customer_edit[0];

        $code = $request->user()->user_code;
        $user_name = User::select('name', 'admin_area','user_code')->where('user_code', $code)->first();

        $province = DB::table('provinces')->select('id', 'name_th')->orderBy('id', 'asc')->get();
        $amphur = DB::table('amphures')->select('name_th', 'province_id')->get();
        $district = DB::table('districts')->select('name_th', 'amphure_id')->get();

        return view('portal/customer-detail', compact('customer_edit', 'province', 'amphur', 'district', 'user_name'));
    }

    public function updateEdit(Request $request, $id)
    {

        date_default_timezone_set("Asia/Bangkok");
/* 
        if($request->has('submit_update'))
        { */

                $phone = $request->phone;
                if($phone == null) {
                    $phone = '';
                }
                $telephone = $request->telephone;
                $address = $request->address;
                $province = $request->province;
                $amphur = $request->amphur;
                $district = $request->district;
                $zip_code = $request->zip_code;

                $email = $request->email;
                if($email == null) {
                    $email = '';
                }
 
                $cert_number = $request->cert_number;
                if($cert_number == null) {
                    $cert_number = '';
                }

                $cert_expire = $request->cert_expire;

                $province_master = DB::table('provinces')->select('id', 'name_th', 'geography_id')->where('id', $province)->first();
                $province_row = $province_master->name_th;

                if(!empty($province_row)) {
                    $geography_id = $province_master->geography_id;
                    $geography = DB::table('geographies')->select('name')->where('id', $geography_id)->first();
                    $geography_name = $geography->name;

                } else {
                    $geography_name = $request->geography;
                }

     /*    } */
            Customer::where('customer_id', $id)
                    ->update ([

               
                        'email' => $email,
                        'phone' => $phone,
                        'telephone' => $telephone,
                        'address' => $address,
                        'province' =>  $province_row,
                        'amphur' => $amphur,
                        'district' => $district,
                        'zip_code' => $zip_code,
                        'geography' => $geography_name,
                        'cert_number' => $cert_number,
                        'cert_expire' => $cert_expire,
                        'status_update' => 'updated',
                    
                    ]);

                // check user id;
                $check_customer_id = Customer::select('customer_id')->where('customer_id', $id)->first();
                $customer_id =  $check_customer_id->customer_id;

                if ($customer_id == $id)
                {
                    echo 'success';
                //    return redirect('/webpanel/customer/'.$id)->with('success', 'check_success');
                }
                else {
                    echo 'fail';
                }
            
    }

}
