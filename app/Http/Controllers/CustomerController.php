<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\File;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
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
    public function create(Request $request)
    {
        dd($request);
        // date_default_timezone_set("Asia/Bangkok");

        if(isset($_POST['submit_form']) != '')
        {
            $customer_id = $_POST['customer_code'];
            $customer_code = $_POST['customer_code'];
            $customer_name = $_POST['customer_name'];
            $price_level = $_POST['price_level'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $telephone = $_POST['telephone'];
            $address = $_POST['address'];
            $province = $_POST['province'];
            $amphur = $_POST['amphur'];
            $district = $_POST['district'];
            $zip_code = $_POST['zip_code'];
            $admin_area = $_POST['admin_area'];
            $sale_area = $_POST['sale_area'];
            $text_area = $_POST['text_add'];
            $cert_store = $_FILES['cert_store']['name'];
            $cert_medical = $_FILES['cert_medical']['name'];
            $cert_commerce = $_FILES['cert_commerce']['name'];
            $cert_vat = $_FILES['cert_vat']['name'];
            $cert_id = $_FILES['cert_id']['name'];
            $cert_number = $_POST['cert_number'];
            $cert_expire = $_POST['cert_expire'];
            // $cert_expire = date('Y-m-d H:i:s');
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

        $customer = new Customer;
        $customer->customer_code = $request->customer_code;
        $customer->save();

        $customer = Customer::create([

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
    public function edit($id)
    {
        $customer_edit = Customer::customerEdit($id);
        $customer_view = $customer_edit[0];

        $province = DB::table('provinces')->select('id', 'name_th')->orderBy('id', 'asc')->get();
        $amphur = DB::table('amphures')->select('name_th', 'province_id')->get();
        $district = DB::table('districts')->select('name_th', 'amphure_id')->get();

        return view('webpanel/customer-detail', compact('customer_view', 'province', 'amphur', 'district'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        date_default_timezone_set("Asia/Bangkok");
            $request->validate ([
                
                'customer_code' =>'required|max:4',
                'customer_name' =>'required|max:100',
            ],
            [
                'customer_code.required' => 'กรุณากรอกรหัสลูกค้า',
                'customer_code.max' => 'รหัสลูกค้าต้องมี 4 หลัก',
                'customer_name.required' => 'กรุณากรอกชื่อลูกค้า',
            ]
            );
            
            $customer_id = $_POST['customer_code'];
            $customer_code = $_POST['customer_code'];
            $customer_name = $_POST['customer_name'];
            $price_level = $_POST['price_level'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $telephone = $_POST['telephone'];
            $address = $_POST['address'];
            $province = $_POST['province'];
            $amphur = $_POST['amphur'];
            $district = $_POST['district'];
            $zip_code = $_POST['zip_code'];
            $admin_area = $_POST['admin_area'];
            $sale_area = $_POST['sale_area'];
            $text_area = $_POST['text_add'];
            $text_admin = $_POST['text_admin'];
            $cert_number = $_POST['cert_number'];
            $cert_expire = $_POST['cert_expire'];
            $status = $_POST['status'];
            $password = $_POST['password'];

            $province_master = DB::table('provinces')->select('id', 'name_th')->whereIn('id', [$province])->get();
            foreach ($province_master as $row)
            {
                $province_row = $row->name_th;
            }
 

            DB::table('customers')
                ->where('customer_id', [$id])
                ->update
                ([

                    /* 'customer_id' => $customer_id,
                    'customer_code' => $customer_code, */
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
                    'admin_area' => $admin_area,
                    'sale_area' => $sale_area,
                    'text_area' => $text_area,
                    'text_admin' => $text_admin,
                    'cert_number' => $cert_number,
                    'cert_expire' => $cert_expire,
                    'status' => $status,
                    'password' => $password,
                
                ]);

                // check user id;
                $check_customer_id = DB::table('customers')->select('customer_id')->whereIn('customer_id', [$id])->get();
                foreach ($check_customer_id as $row)
                {
                    $customer_id = $row->customer_id;
                }
                if ($customer_id == $id)
                {
                    echo 'success';
                }
                else {
                    echo 'fail';
                }
            
    }

    public function certStore(Request $request, $id)
    {
            $check_cert_store = $request->file('cert_store');

            if(isset($_POST['submit_store']))
            {

                $cert_store = $check_cert_store;
    
                if($cert_store != '' && $id != '')
                {
                    $image_cert_store = $request->file('cert_store')->storeAs('img_certstore', $id.'_certstore.jpg');
                } else {
                    $image_cert_store = '';
                }

                DB::table('customers')
                ->where('customer_id', [$id])
                ->update
                ([
                    'cert_store' => $image_cert_store,
        
                ]);

            }
            return back();
    }

    public function certMedical(Request $request, $id)
    {

            $check_cert_medical = $request->file('cert_medical');

            if(isset($_POST['submit_medical']))
            {

                $cert_medical =  $check_cert_medical ;

                if($cert_medical != '' && $id != '')
                {
                    $image_cert_medical = $request->file('cert_medical')->storeAs('img_certmedical', $id.'_certmedical.jpg');
                } else {
                    $image_cert_medical = '';
                }

                DB::table('customers')
                ->where('customer_id', [$id])
                ->update
                ([

                    'cert_medical' =>  $image_cert_medical,

                ]);

            }
            return back();
    }

    public function certCommerce(Request $request, $id)
    {

            $check_cert_commerce = $request->file('cert_commerce');
            if(isset($_POST['submit_commerce']))
            {
                $cert_commerce = $check_cert_commerce;

                if($cert_commerce != '' && $id != '')
                {
                    $image_cert_commerce = $request->file('cert_commerce')->storeAs('img_certcommerce', $id.'_certcommerce.jpg');
                } else {
                    $image_cert_commerce = '';
                }
        
                DB::table('customers')
                ->where('customer_id', [$id])
                ->update
                ([

                    'cert_commerce' =>  $image_cert_commerce,

                ]);

            }
            return back();
    }

    public function certVat(Request $request, $id)
    {

            $check_cert_vat = $request->file('cert_vat');
            if(isset($_POST['submit_vat']))
            {
                $cert_vat = $check_cert_vat;

                if($cert_vat != '' && $id != '')
                {
                    $image_cert_vat = $request->file('cert_vat')->storeAs('img_certvat', $id.'_certvat.jpg');
                } else {
                    $image_cert_vat = '';
                }
        
                DB::table('customers')
                ->where('customer_id', [$id])
                ->update
                ([

                    'cert_vat' =>  $image_cert_vat,

                ]);

            }
            return back();
    }

    public function certId(Request $request, $id)
    {

            $check_cert_id = $request->file('cert_id');
            if(isset($_POST['submit_id']))
            {
                $cert_id = $check_cert_id;

                if($cert_id != '' && $id != '')
                {
                    $image_cert_id = $request->file('cert_id')->storeAs('img_certid', $id.'_certid.jpg');
                } else {
                    $image_cert_id = '';
                } 
        
                DB::table('customers')
                ->where('customer_id', [$id])
                ->update
                ([

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
}
