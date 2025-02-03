<?php

namespace App\Http\Controllers\Webpanel;

use App\Models\User;
use App\Models\Salearea;
use App\Models\Customer;
use App\Models\Province;
use Illuminate\Http\File;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Imports\CustomerImport;
use App\Exports\CustomerCompletedExport;
use App\Exports\CustomerWaitingExport;
use App\Exports\CustomerActionExport;
use App\Exports\CustomerAllExport;
use App\Exports\CustomerInactiveExport;
use App\Exports\UpdateLatestExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;

class WebpanelCustomerController
{
    public function index(Request $request): View
    {

        @$page = $request->page;
        if ($page) {
            $page = $request->page;
        } else {
            $page = 1;
        }

        //แสดงข้อมูลลูกค้า;
        $row_customer = Customer::viewCustomer($page);
        $customer = $row_customer[0];
        $start = $row_customer[1];
        $total_page = $row_customer[2];
        $page = $row_customer[3];

        //Dashborad;
        $total_customer = Customer::whereNotIn('customer_code', ['0000','4494'])->count();
        $total_status_waiting = Customer::where('status', 0)->whereNotIn('customer_code', ['0000','4494'])->count();
        $total_status_action = Customer::where('status', 1)->whereNotIn('customer_code', ['0000','4494'])->count();
        $total_status_completed = Customer::where('status', 2)->whereNotIn('customer_code', ['0000','4494'])->count();
        $total_status_updated = Customer::where('status_update', 'updated')->whereNotIn('customer_code', ['0000','4494'])->count();
        $customer_status_inactive = Customer::where('customer_status', 'inactive')->whereNotIn('customer_code', ['0000','4494'])->count();

        //เพิ่มลูกค้า;
        // $admin_area_list = User::select('admin_area', 'name', 'rights_area', 'user_code')->get();

        return view('webpanel/customer', compact('customer', 'start', 'total_page', 'page', 'total_customer', 'total_status_waiting',
                'total_status_action', 'total_status_completed', 'total_status_updated', 'customer_status_inactive'));
        
    }

    public function indexStatus(Request $request, $status_check): View
    {

        $page = $request->page;
        if ($page) {
            $page = $request->page;
        } else {
            $page = 1;
        }

        //แสดงข้อมูลลูกค้า;

        if($status_check == 'waiting') {

            $row_customer = Customer::customerWaiting($page);
            $customer = $row_customer[0];
            // dd(gettype($customer));
            $start = $row_customer[1];
            $total_page = $row_customer[2];
            $page = $row_customer[3];

            //Dashborad;
            $total_customer = Customer::whereNotIn('customer_code', ['0000','4494'])->count();
            $total_status_waiting = Customer::where('status', 0)->whereNotIn('customer_code', ['0000','4494'])->count();

            return view('webpanel/customer-waiting', compact('customer', 'start', 'total_page', 'page', 'total_customer', 'total_status_waiting'));

        } else if ($status_check == 'action') {

            $row_customer = Customer::customerAction($page);
            $customer = $row_customer[0];
            // dd(gettype($customer));
            $start = $row_customer[1];
            $total_page = $row_customer[2];
            $page = $row_customer[3];

            //Dashborad;
            $total_customer = Customer::whereNotIn('customer_code', ['0000','4494'])->count();
            $total_status_action = Customer::where('status', 1)->whereNotIn('customer_code', ['0000','4494'])->count();

            return view('webpanel/customer-action', compact('customer', 'start', 'total_page', 'page', 'total_customer', 'total_status_action'));
       
        } else if ($status_check == 'completed') {

            $row_customer = Customer::customerCompleted($page);
            $customer = $row_customer[0];
            // dd(gettype($customer));
            $start = $row_customer[1];
            $total_page = $row_customer[2];
            $page = $row_customer[3];

            //Dashborad;
            $total_customer = Customer::whereNotIn('customer_code', ['0000','4494'])->count();
            $total_status_completed = Customer::where('status', 2)->whereNotIn('customer_code', ['0000','4494'])->count();

            return view('webpanel/customer-completed', compact('customer', 'start', 'total_page', 'page', 'total_customer', 'total_status_completed'));
        } else if ($status_check == 'latest_update') {

            $row_customer = Customer::latestUpdate($page);
            $customer = $row_customer[0];
            // dd(gettype($customer));
            $start = $row_customer[1];
            $total_page = $row_customer[2];
            $page = $row_customer[3];

            //Dashborad;
            $total_customer = Customer::whereNotIn('customer_code', ['0000','4494'])->count();
            $total_status_updated = Customer::where('status_update', 'updated')->whereNotIn('customer_code', ['0000','4494'])->count();

            return view('webpanel/update-latest', compact('customer', 'start', 'total_page', 'page', 'total_customer','total_status_updated'));

        } else if ($status_check == 'inactive') {

            $row_customer = Customer::customerInactive($page);
            $customer = $row_customer[0];
            // dd(gettype($customer));
            $start = $row_customer[1];
            $total_page = $row_customer[2];
            $page = $row_customer[3];

            //Dashborad;
            $total_customer = Customer::whereNotIn('customer_code', ['0000','4494'])->count();
            $customer_status_inactive = Customer::where('customer_status', 'inactive')->whereNotIn('customer_code', ['0000','4494'])->count();

            return view('webpanel/customer-inactive', compact('customer', 'start', 'total_page', 'page', 'total_customer', 'customer_status_inactive'));

        } else {
            return abort(403, 'Error requesting');
        }
        
    }
    /**
     * Show the form for creating a new resource.
     */
    public function customerCreate() {

        $provinces = Province::province();
        $admin_area_list = User::select('admin_area', 'name', 'rights_area', 'user_code')->get();

        $sale_area = Salearea::select('sale_area', 'sale_name')
                    ->orderBy('sale_area' ,'asc')
                    ->get();

        return view('webpanel/customer-create', compact('provinces', 'admin_area_list', 'sale_area'));
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

            $register_by = $request->register_by;
            if($register_by == null) {
                $register_by = '';
            }
    
            $cert_store = $request->file('cert_store');
            $cert_medical = $request->file('cert_medical');
            $cert_commerce = $request->file('cert_commerce');
            $cert_vat = $request->file('cert_vat');
            $cert_id = $request->file('cert_id');
       
            $cert_expire = $request->cert_expire;
            $status = '0';

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
                    'register_by' => $register_by,
                    'customer_status' => 'inactive',
                    'status_user' => '',
                    // 'maintenance_status' => '',
                    // 'allowed_maintenance' => '',

                ]);

                return redirect('/webpanel/customer');

    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        $customer_edit = Customer::customerEdit($id);
        $customer_view = $customer_edit[0];

        $admin_area_list  = User::select('admin_area', 'name', 'rights_area')->get();

        $admin_area_check = Customer::select('admin_area', 'customer_id')->where('customer_code', $id)->first();
        // dd($admin_area_check->customer_id);

        $sale_area = Salearea::select('sale_area', 'sale_name')
                    ->orderBy('sale_area' ,'asc')
                    ->get();

        $province = DB::table('provinces')->select('id', 'name_th')->orderBy('id', 'asc')->get();
        $amphur = DB::table('amphures')->select('name_th', 'province_id')->get();
        $district = DB::table('districts')->select('name_th', 'amphure_id')->get();

        return view('webpanel/customer-detail', compact('customer_view', 'province', 'amphur', 'district', 'admin_area_list', 'admin_area_check', 'sale_area'));
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
                if($telephone == null) {
                    $telephone = '';
                }
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

                $status_user = $request->status_user;
                if($status_user == null) {
                    $status_user = '';
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
                        'status_user' => $status_user,
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

    public function statusAct(Request $request)
    {
        if($request->id == 2 && $request->status == 'active') {
            Customer::where('customer_id', $request->user_code)
                    ->update ([ 'customer_status' => 'active' ]);

        }
    }

    public function statusiAct(Request $request)
    {
        if($request->id == 1 && $request->status_in == 'inactive') {
            Customer::where('customer_id', $request->user_code)
                    ->update ([ 'customer_status' => 'inactive' ]);

        }
    }

    //เก็บไว้ดู Import_csv;
  /*   public function importFile(Request $request)
    {

        date_default_timezone_set("Asia/Bangkok");

        if($request->has('submit_csv') == true) {

            $path = $request->file('import_csv');
            if($path == null) {
                $path == '';
                // dd($path);
            } else {
                $rename = 'Customer_all'.'_'.'.csv';
                Excel::import(new CustomerImport, $request->file('import_csv')->storeAs('importcsv',$rename,'importfiles'), 'importfiles', \Maatwebsite\Excel\Excel::CSV);
                // dd($path);
            }

        }

    } */

    //เก็บไว้ดู Import_csv;

    public function importFile(Request $request)
    {

        date_default_timezone_set("Asia/Bangkok");

        if($request->has('submit_csv') == true) 
        {
            
                $path = $request->file('import_csv');
                if($path == null) {
                    $path == '';
    
                } else {

                    $rename = 'Customer_all'.'_'.date("l jS \of F Y h:i:s A").'.csv';
                    $directory = $request->file('import_csv')->storeAs('importcsv',$rename,'importfiles'); //importfiles filesystem.php->disk;
                    $fileStream = fopen(storage_path('app/public/importcsv/'.$rename),'r');

                        while (!feof($fileStream)) 
                            {

                                $row = fgetcsv($fileStream , 1000 , "|");
                                // dd($row[0]);
                                if($row[0] ??= '') {
                                
                                    $customer_name_new = str_replace("'", "''", $row[2]);
                                    $address = str_replace("'", "''", $row[4]);
                                    $cert_number = str_replace("'", "''", $row[5]);
                                    $cert_expire_new = date('31/12/2024'); 
                                    $cert_store = str_replace("'", "''", $row[8]); 
                                    $cert_number = str_replace("'", "''", $row[5]);
                
                                    $province = explode(" ", $row[4]);
                                    $province_new = $province[count($province) - 5];
                                    // dd($province);
            
                                    if($province_new == '' || $province_new == 1) {
                                        $province = explode(" ", $row[4]);
                                        $province_new = $province[count($province) - 2];
                                        
                                    }

                                
                                    $province_check = DB::table('provinces')->select('name_th', 'geography_id')->where('name_th',$province_new)->first();
                                    // dd($province_check->geography_id);
                                    $geography_name = DB::table('geographies')->select('id', 'name')->where('id', $province_check->geography_id)->first();
                                    $name_geography = ($geography_name->name);
                                    // dd($name_geography);

                                    $amphur = explode(" ", $row[4]);
                                    $amphur_new = $amphur[count($amphur) - 6];
                                    // dd($amphur_new);
            
                                    if($amphur_new == '' || $amphur_new == 1) {
                                        $amphur = explode(" ", $row[4]);
                                        $amphur_new = $amphur[count($amphur) - 9];
                                        // dd($amphur_new);
                                    }

                                    //check saraburi;
                                    $check_arr = explode(" ", $row[4]);
                                    $check_saraburi = $check_arr[count($check_arr) - 2];
                                   
                                   /*  $check_arr_saraburi = array_filter($check_arr, function($value) {
                                        return $value == 'กรุงเทพมหานคร';
                                    }); */

                                    // dd($check_arr_saraburi);
                                 
                                
                                    $district = explode(" ", $row[4]);
                                    $count_arr = count($district);


                                    if($count_arr > 13) {

                                        //check saraburi;
                                        if($check_saraburi === 'สระบุรี') {
                                            $district_new = $district[count($district) - 10];

                                        } else {
                                            $district_new = $district[count($district) - 13];
                                        }
    
                                    } elseif ($count_arr == 13) {
                                        // $district = explode(" ", $row[4]);
                                        $district_new = $district[count($district) - 10];

                                    } elseif ($count_arr == 12) {
                                        // $district = explode(" ", $row[4]);
                                        $district_new = $district[count($district) - 10];

                                    } elseif ($count_arr == 11) {
                                        // $district = explode(" ", $row[4]);
                                        $district_new = $district[count($district) - 10];

                                    }
                                    
                

                                    $zip_code = explode(" ", $row[4]);
                                    $zip_code_new = $zip_code[count($zip_code) - 1];
        
                                    $address = explode(" ", $row[4]);
                                    $address_new = $zip_code[0];

                                    $sale_area_new = $row[1];
                                    if ($sale_area_new == '') {
                                        $sale_area_new = 'ไม่ระบุ';
                                    }

                                    $status_user = str_replace("'", "''", $row[10]); 

                                    $customer_id = $row[0];
                                    $customer_code  = $row[0];
                                    $customer_name = $customer_name_new;
                                    $price_level = $row[7];
                                    $email = '';
                                    $phone = '';
                                    $telephone = '';
                                    $address = $address_new;
                                    $province = $province_new;
                                    $amphur = $amphur_new;
                                    $district = $district_new;
                                    $zip_code = $zip_code_new;
                                    $geography = $geography_name;
                                    $admin_area = '';
                                    $sale_area = $sale_area_new;
                                    $text_area = '';
                                    $text_admin = '';
                                    $cert_store = '';
                                    $cert_medical = '';
                                    $cert_commerce = '';
                                    $cert_vat = '';
                                    $cert_id = '';
                                    $cert_number = $row[5];
                                    $cert_expire = $cert_expire_new;
                                    $status = '0';
                                    $password = '';
                                    $status_update = '';
                                    $type = $row[8];
                                    $register_by = 'import_naster';
                                    $customer_status = 'active';

                            
                            Customer::create([

                                    'customer_id' => $customer_id,
                                    'customer_code' => $customer_code,
                                    'customer_name' => $customer_name,
                                    'price_level' => $price_level,
                                    'email' => $email,
                                    'phone' => $phone,
                                    'telephone' => $telephone,
                                    'address' => $address,
                                    'province' =>  $province,
                                    'amphur' => $amphur,
                                    'district' => $district,
                                    'zip_code' => $zip_code,
                                    'geography' => $name_geography,
                                    'admin_area' => $admin_area,
                                    'sale_area' => $sale_area,
                                    'text_area' => $text_area,
                                    'text_admin' => $text_admin,
                                    'cert_store' => $cert_store,
                                    'cert_medical' =>  $cert_medical,
                                    'cert_commerce' => $cert_commerce,
                                    'cert_vat' => $cert_vat,
                                    'cert_id' => $cert_id,
                                    'cert_number' => $cert_number,
                                    'cert_expire' => $cert_expire,
                                    'status' => $status,
                                    'password' => $password,
                                    'status_update' => $status_update,
                                    'type' => $type,
                                    'register_by' => $register_by,
                                    'customer_status' => $customer_status,
                                    'status_user' => $status_user,
        
                                ]);
                            }

                        }

                        fclose($fileStream);

                }

        }
        $count = Customer::all()->count();
        return redirect('/webpanel/customer/importcustomer')->with('success_import', 'นำเข้าข้อมูลสำเร็จ :'.' '.$count);
            
   }

   ///groups customer;
   public function groupsCustomer() 
   {
    $row_salearea = Salearea::select('sale_area', 'sale_name', 'admin_area', 'updated_at')->where('sale_area', '!=', '')
                        ->orderBy('sale_area', 'asc')
                        ->get();

    $customer_area_list = Customer::select('admin_area', 'sale_area')->first();
    $admin_area_list = User::select('admin_area', 'name', 'rights_area', 'user_id')->get();

    return view('/webpanel/groups-customer', compact('row_salearea', 'customer_area_list', 'admin_area_list'));
   }
   public function updateAdminarea(Request $request, $sale_area)
   {

        date_default_timezone_set("Asia/Bangkok");
        $admin_area = $request->admin_area;
        if($request->admin_area == null) {
            $admin_area = '';
        }

        Customer::where('sale_area', $sale_area)->update(['admin_area' => $admin_area]);
        Salearea::where('sale_area', $sale_area)->update(['admin_area' => $admin_area]);

    // }
       return back()->with('success','อัปเดตข้อมูลเรียบร้อย');

    

   }

   public function exportCustomerExcel($status)
   {

    // dd($status);

     switch ($status) 
        {
            //get excel;
            case $status == 'getexcel_completed':
                $date = date('d-m-Y');
                return Excel::download(new CustomerCompletedExport, 'Customer_completed'.'_'.$date.'.'.'xlsx');
                break;

            case $status == 'getexcel_action':
                $date = date('d-m-Y');
                return Excel::download(new CustomerActionExport, 'Customer_action'.'_'.$date.'.'.'xlsx');
                break;

            case $status == 'getexcel_waiting':
                $date = date('d-m-Y');
                return Excel::download(new CustomerWaitingExport, 'Customer_waiting'.'_'.$date.'.'.'xlsx');
                break;

            case $status == 'getexcel_update':
                $date = date('d-m-Y');
                return Excel::download(new UpdateLatestExport, 'Customer_update'.'_'.$date.'.'.'xlsx');
                break;

            case $status == 'getexcel_inactive':
                $date = date('d-m-Y');
                return Excel::download(new CustomerInactiveExport, 'Customer_inactive'.'_'.$date.'.'.'xlsx');
                break;

            case $status == 'getexcel_customerall':
                $date = date('d-m-Y');
                return Excel::download(new CustomerAllExport, 'Customer_all'.'_'.$date.'.'.'xlsx');
                break;

            default:
                return back()->with('error_export', 'เกิดข้อผิดพลาด');
        }
        
   }

   public function exportCustomerCsv($status)
   {
        // dd($status);

        switch ($status)
        {

            case $status == 'getcsv_completed':
                $date = date('Y-m-d');
                $filename = 'Customer_completed_'. $date.'.csv';
                 // Start the output buffer.
                ob_start();

                // Set PHP headers for CSV output.
                header('Content-Type: text/csv; charset=utf-8');
                header('Content-Disposition: attachment; filename= '.$filename);
                
                $query = Customer::select('customer_code', 'customer_name', 'province', 'geography', 'admin_area', 'sale_area')
                                    ->whereNotIn('customer_code', ['0000','4494'])
                                    ->where('status', "2")
                                    ->get();

                $data = $query->toArray();
                // Clean up output buffer before writing anything to CSV file.
                ob_end_clean();
            break;

            case $status == 'getcsv_action':
                $date = date('Y-m-d');
                $filename = 'Customer_action_'. $date. '.csv';
                 // Start the output buffer.
                ob_start();

                // Set PHP headers for CSV output.
                header('Content-Type: text/csv; charset=utf-8');
                header('Content-Disposition: attachment; filename= '.$filename);
                
                $query = Customer::select('customer_code', 'customer_name', 'province', 'geography', 'admin_area', 'sale_area')
                                    ->whereNotIn('customer_code', ['0000','4494'])
                                    ->where('status', "1")
                                    ->get();

                $data = $query->toArray();
                // Clean up output buffer before writing anything to CSV file.
                ob_end_clean();
            break;

            case $status == 'getcsv_waiting':
                $date = date('Y-m-d');
                $filename = 'Customer_waiting_'. $date. '.csv';
                 // Start the output buffer.
                ob_start();

                // Set PHP headers for CSV output.
                header('Content-Type: text/csv; charset=utf-8');
                header('Content-Disposition: attachment; filename= '.$filename);
                
                $query = Customer::select('customer_code', 'customer_name', 'province', 'geography', 'admin_area', 'sale_area')
                                    ->whereNotIn('customer_code', ['0000','4494'])
                                    ->where('status', "0")
                                    ->get();

                $data = $query->toArray();
                // Clean up output buffer before writing anything to CSV file.
                ob_end_clean();
            break;

            case $status == 'getcsv_update':
                $date = date('Y-m-d');
                $filename = 'Customer_update_'. $date. '.csv';
                 // Start the output buffer.
                ob_start();

                // Set PHP headers for CSV output.
                header('Content-Type: text/csv; charset=utf-8');
                header('Content-Disposition: attachment; filename= '.$filename);
                
                $query = Customer::select('customer_code', 'customer_name', 'province', 'geography', 'admin_area', 'sale_area')
                                    ->whereNotIn('customer_code', ['0000','4494'])
                                    ->where('status_update', "updated")
                                    ->get();

                $data = $query->toArray();
                // Clean up output buffer before writing anything to CSV file.
                ob_end_clean();
            break;

            case $status == 'getcsv_inactive':
                $date = date('Y-m-d');
                $filename = 'Customer_inactive_'. $date. '.csv';
                 // Start the output buffer.
                ob_start();

                // Set PHP headers for CSV output.
                header('Content-Type: text/csv; charset=utf-8');
                header('Content-Disposition: attachment; filename= '.$filename);
                
                $query = Customer::select('customer_code', 'customer_name', 'province', 'geography', 'admin_area', 'sale_area')
                                    ->whereNotIn('customer_code', ['0000','4494'])
                                    ->where('customer_status', "inactive")
                                    ->get();

                $data = $query->toArray();
                // Clean up output buffer before writing anything to CSV file.
                ob_end_clean();
            break;

            case $status == 'getcsv_customerall':
                $date = date('Y-m-d');
                $filename = 'Customer_all_'. $date. '.csv';
                 // Start the output buffer.
                ob_start();

                // Set PHP headers for CSV output.
                header('Content-Type: text/csv; charset=utf-8');
                header('Content-Disposition: attachment; filename= '.$filename);
                
                $query = Customer::select('customer_code', 'customer_name', 'province', 'geography', 'admin_area', 'sale_area', 'status', 'customer_status')
                                    ->whereNotIn('customer_code', ['0000','4494'])
                                    ->get();

                $data = $query->toArray();
                // Clean up output buffer before writing anything to CSV file.
                ob_end_clean();
            break;


            default:
                return back()->with('error_export', 'เกิดข้อผิดพลาด');
        }

            // Create a file pointer with PHP.
            $output = fopen( 'php://output', 'w' );

            // Write headers to CSV file.
            // fputcsv( $output, $header_args );

            // Loop through the prepared data to output it to CSV file.
            foreach( $data as $data_item ){
                fputcsv($output, $data_item, "|" );
            }

            // Close the file pointer with PHP with the updated output.
            fclose( $output );
            exit;
   }

   public function getCustomerCsv($customer_id)
   {

            $date = date('Y-m-d');
            $filename = 'Customer__'.$customer_id.'_'.$date. '.csv';
            // Start the output buffer.
            ob_start();

            // Set PHP headers for CSV output.
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename= '.$filename);
            
            $query = Customer::select('customer_code', 'customer_name', 'price_level', 'type', 'telephone','email', 'address', 'sale_area')
                                ->whereNotIn('customer_code', ['0000','4494'])
                                ->where('customer_id', $customer_id)
                                ->get();

            $data = $query->toArray();

            // Create a file pointer with PHP.
            $output = fopen( 'php://output', 'w' );

            // Write headers to CSV file.
            // fputcsv( $output, $header_args );

            // Loop through the prepared data to output it to CSV file.
            foreach( $data as $data_item ){
                fputcsv($output, $data_item, "|" );
            }

            // Close the file pointer with PHP with the updated output.
            fclose( $output );
            exit;
   }

   //delete customer;
   public function deleteCustomer(Request $request,  $customer_code)
   {

        if(!empty($request->customer_code)) {

            // echo json_encode(array('checkcode'=> $request->user_code));

            $customer = Customer::where('customer_id', $customer_code)->first();
            // dd($customer->cert_store);

            //delete image storage;
            Storage::delete($customer->cert_store);
            Storage::delete($customer->cert_medical);
            Storage::delete($customer->cert_commerce);
            Storage::delete($customer->cert_vat);
            Storage::delete($customer->cert_id);

            $customer->delete();

            echo json_encode(array('checkcode'=> $request->customer_code));

        }
    
   }

   //delete admin;
   public function deleteAdmin(Request $request,  $user_code)
   {

        if(!empty($request->user_code)) {

            // echo json_encode(array('checkcode'=> $request->user_code));

            $useradmin = User::where('user_code', $user_code)->first();

            $useradmin ->delete();

            echo json_encode(array('checkcode'=> $request->user_code));

        }
    
   }


   //delete salearea;
   public function deleteSalearea(Request $request,  $sale_area)
   {

        if(!empty($request->sale_area)) {

            // echo json_encode(array('checkcode'=> $request->user_code));

            $salearea_del = Salearea::where('sale_area', $sale_area)->first();

            $salearea_del ->delete();

            echo json_encode(array('checkcode'=> $request->sale_area));

        }
    
   }

}
