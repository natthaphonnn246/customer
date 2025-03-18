<?php

namespace App\Http\Controllers\Portal;

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

class PortalCustomerController
{

    public function dashboardCharts(Request $request)
    {

        //notin code;
        $code_notin = ['0000', '4494', '7787', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];

        $id = $request->user()->admin_area;
        $code = $request->user()->user_code;

        $user_name = User::select('name', 'admin_area','user_code', 'rights_area')->where('user_code', $code)->first();
        $status_all = Customer::select('status')
                                ->where('admin_area', $id)
                                ->whereNotIn('customer_status', ['inactive'])
                                // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                ->whereNotIn('customer_id', $code_notin)
                                ->count();

        $status_waiting = Customer::where('admin_area', $id)
                                    ->where('status', 'รอดำเนินการ')
                                    ->whereNotIn('customer_status', ['inactive'])
                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();
                                    // dd($count_waiting);
        $status_action = Customer::where('admin_area', $id)
                                    ->where('status', 'ต้องดำเนินการ')
                                    ->whereNotIn('customer_status', ['inactive'])
                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();

        $status_completed = Customer::where('admin_area', $id)
                                    ->where('status', 'ดำเนินการแล้ว')
                                    ->whereNotIn('customer_status', ['inactive'])
                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();

        $status_alert = $status_waiting + $status_action;

        return view('portal/dashboard', compact('user_name', 'status_all', 'status_waiting', 'status_action', 'status_completed', 'status_alert'));
    
    }
    public function indexPortal(Request $request)
    {
            //notin code;
            $code_notin = ['0000', '4494', '7787', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];

            $code = $request->user()->user_code;
        
            $user_name = User::select('name', 'admin_area','user_code')->where('user_code', $code)->first();
            $admin_area_list = User::select('admin_area', 'name', 'rights_area', 'user_id')->where('user_code', $code)->first();

            $admin_area = Customer::select('admin_area', 'status')->where('admin_area', $user_name->admin_area)->first();
            // dd($admin_area->admin_area);

            $status_all = Customer::select('status')
                                        ->where('admin_area', $admin_area->admin_area)
                                        ->whereNotIn('customer_status', ['inactive'])
                                        // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                        ->whereNotIn('customer_id', $code_notin)
                                        ->count();

            $status_waiting = Customer::select('status')
                                        ->where('admin_area', $admin_area->admin_area)
                                        ->where('status', 'รอดำเนินการ')
                                        ->whereNotIn('customer_status', ['inactive'])
                                        // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                        ->whereNotIn('customer_id', $code_notin)
                                        ->count();
            // dd($status_waiting);

            $status_action = Customer::select('status')
                                        ->where('admin_area', $admin_area->admin_area)
                                        ->where('status', 'ต้องดำเนินการ')
                                        ->whereNotIn('customer_status', ['inactive'])
                                        // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                        ->whereNotIn('customer_id', $code_notin)
                                        ->count();

            $status_completed = Customer::select('status')
                                        ->where('admin_area', $admin_area->admin_area)
                                        ->where('status', 'ดำเนินการแล้ว')
                                        ->whereNotIn('customer_status', ['inactive'])
                                        // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                        ->whereNotIn('customer_id', $code_notin)
                                        ->count();

            $status_alert = $status_waiting + $status_action;
            // dd($customer_tb);

            $sale_area = Salearea::select('sale_area', 'sale_name')
                        ->orderBy('sale_area', 'asc')
                        ->get();

            $provinces = Province::province();
            
            return view('portal/signin', compact('provinces', 'user_name', 'admin_area_list', 'sale_area', 'status_all', 'status_waiting', 'status_action', 'status_completed', 'status_alert'));
      
    }

     //สำหรับแอดมินไม่ได้รับสิทธิ์เขตรับผิดชอบ;
    public function portalSign(Request $request)
    {
            $code = $request->user()->user_code;
        
            $user_name = User::select('name', 'admin_area','user_code')->where('user_code', $code)->first();

            // dd($user_name->name);
            $admin_area_list = User::select('admin_area', 'name', 'rights_area', 'user_id')->get();

            $sale_area = Salearea::select('sale_area', 'sale_name')
                        ->orderBy('sale_area', 'asc')
                        ->get();

            $provinces = Province::province();
            return view('portal/portal-sign', compact('provinces', 'user_name', 'admin_area_list', 'sale_area'));
    }

    //singin customer;
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

            $register_by = $request->register_by;
            if($register_by == null) {
                $register_by = '';
            }

            $admin_area = $request->admin_area;
            $cert_store = $request->file('cert_store');
            $cert_medical = $request->file('cert_medical');
            $cert_commerce = $request->file('cert_commerce');
            $cert_vat = $request->file('cert_vat');
            $cert_id = $request->file('cert_id');

            $cert_expire = $request->cert_expire;
            $status = 'รอดำเนินการ';
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

            $delivery_by = $request->delivery_by;

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
                        'register_by' => $register_by,
                        'customer_status' => 'inactive',
                        'status_user' => '',
                        'delivery_by' => $delivery_by,
                        // 'maintenance_status' => '',
                        // 'allowed_maintenance' => '',

                    ]);

        } else {

            return back()->with('error_code', 'ลงทะเบียนไม่สำเร็จ กรุณาตรวจสอบอีกรอบครับ');

        }

            return back()->with('success', 'ลงทะเบียนสำเร็จ กรุณาติดต่อผู้ดูแลด้วยครับ');

    }

    //portal/customer;
    public function customerView(Request $request)
    {

        $page = $request->page;
        if ($page) {
            $page = $request->page;
        } else {
            $page = 1;
        }

        $keyword_code = $request->keyword;
        $id = $request->user()->admin_area;
        $code = $request->user()->user_code;

        //notin code;
        $code_notin = ['0000', '4494', '7787', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];

        $count_page = Customer::where('admin_area', $id)
                                ->whereNotIn('customer_id', $code_notin)
                                ->count();
   
        $perpage = 10;
        $total_page = ceil($count_page / $perpage);
        $start = ($perpage * $page) - $perpage;
        
        $user_name = User::select('name', 'admin_area','user_code', 'rights_area')->where('user_code', $code)->first();
        $customer_list = Customer::select('id', 'admin_area', 'customer_code', 'customer_name', 'sale_area', 'status', 'email', 'created_at', 'customer_status')
                                    ->where('admin_area', $id)
                                    ->whereNotIn('customer_status', ['inactive'])
                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->offset($start)
                                    ->limit($perpage)
                                    ->get();

        $status_all = Customer::select('status')
                                ->where('admin_area', $id)
                                ->whereNotIn('customer_status', ['inactive'])
                                // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                ->whereNotIn('customer_id', $code_notin)
                                ->count();

        $status_waiting = Customer::where('admin_area', $id)
                                    ->where('status', 'รอดำเนินการ')
                                    ->whereNotIn('customer_status', ['inactive'])
                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();
                                    // dd($count_waiting);
        $status_action = Customer::where('admin_area', $id)
                                    ->where('status', 'ต้องดำเนินการ')
                                    ->whereNotIn('customer_status', ['inactive'])
                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();

        $status_completed = Customer::where('admin_area', $id)
                                    ->where('status', 'ดำเนินการแล้ว')
                                    ->whereNotIn('customer_status', ['inactive'])
                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();

        $status_alert = $status_waiting + $status_action;

        //keyword;
        if($keyword_code != '') {
            $customer_list = Customer::where('admin_area',$id)
                            // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                            ->whereNotIn('customer_id', $code_notin)
                            ->where('customer_id', 'Like', "%{$keyword_code}%")
                            ->orWhere('customer_name', 'Like', "%{$keyword_code}%")
                            ->whereIn('admin_area', [$id])
                            ->get();

                            // dd($customer_list);
            $count_page = Customer::where('admin_area', $id)->where('customer_id', $keyword_code)
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();

            $perpage = 10;
            $total_page = ceil($count_page / $perpage);
            $start = ($perpage * $page) - $perpage;

            $check_customer_code = Customer::where('admin_area',$id)
                                            // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                            ->whereNotIn('customer_id', $code_notin)
                                            ->where('customer_id',  'Like', "%{$keyword_code}%")
                                            ->orWhere('customer_name', 'Like', "%{$keyword_code}%")
                                            ->whereIn('admin_area', [$id])
                                            ->first();

            // dd($check_customer_code);

            // dd($check_search->admin_area);
            if(!$check_customer_code  == null) {
                return view('portal/customer', compact('customer_list', 'user_name', 'page', 'total_page', 'start', 'status_waiting', 'status_action', 'status_completed', 'status_all', 'status_alert'));
            }

                return redirect()->route('portal.customer');
            
 
        }
        return view('portal/customer', compact('customer_list', 'user_name', 'page', 'total_page', 'start', 'status_waiting', 'status_action', 'status_completed', 'status_all', 'status_alert'));
    }
    
    //portal/customer/status/{status_custoemr};
    public function customerViewEdit(Request $request, $status_customer)
    {
        // dd($status_customer);

        $page = $request->page;
        if ($page) {
            $page = $request->page;
        } else {
            $page = 1;
        }

        //notin code;
        $code_notin = ['0000', '4494', '7787', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];

        $id = $request->user()->admin_area;
        $code = $request->user()->user_code;

        $keyword_code = $request->keyword;
        // dd($keyword_code);

        if($status_customer == 'waiting') {

            $count_page = Customer::where('admin_area', $id)
                                    ->where('status', "รอดำเนินการ")
                                    ->whereNotIn('customer_status', ['inactive'])
                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();
    
            $perpage = 10;
            $total_page = ceil($count_page / $perpage);
            $start = ($perpage * $page) - $perpage;
            
            $user_name = User::select('name', 'admin_area','user_code', 'rights_area')->where('user_code', $code)->first();
            $customer_list = Customer::select('id', 'admin_area', 'customer_code', 'customer_name', 'sale_area', 'status', 'email', 'created_at', 'customer_status')
                                    ->where('admin_area', $id)
                                    ->where('status', 'รอดำเนินการ')
                                    ->whereNotIn('customer_status', ['inactive'])
                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->offset($start)
                                    ->limit($perpage)
                                    ->get();

            $count_all = Customer::select('status')
                                    ->where('admin_area', $id)
                                    ->whereNotIn('customer_status', ['inactive'])
                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();
    
            $count_waiting = Customer::where('admin_area', $id)
                                        ->where('status', 'รอดำเนินการ')
                                        ->whereNotIn('customer_status', ['inactive'])
                                        // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                        ->whereNotIn('customer_id', $code_notin)
                                        ->count();
                                        // dd($count_waiting);
            $count_action = Customer::where('admin_area', $id)
                                        ->where('status', 'ต้องดำเนินการ')
                                        ->whereNotIn('customer_status', ['inactive'])
                                        // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                        ->whereNotIn('customer_id', $code_notin)
                                        ->count();
    
            $count_completed = Customer::where('admin_area', $id)
                                        ->where('status', 'ดำเนินการแล้ว')
                                        ->whereNotIn('customer_status', ['inactive'])
                                        // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                        ->whereNotIn('customer_id', $code_notin)
                                        ->count();
    
            $count_alert = $count_waiting + $count_action;
            
              //keyword;

         /*    $check_customer_codes = Customer::where('status', '0')->where('customer_id',  'Like', "%{$keyword_code}%")
                                            ->orWhere('customer_name', 'Like', "%{$keyword_code}%")
                                            ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                            ->whereIn('admin_area', [$id])
                                            ->where('admin_area',$id)
                                            ->whereNotIn('customer_status', ['inactive'])
                                            ->first();

            dd($check_customer_codes->customer_id); */
            if($keyword_code != '') {
                $customer_list = Customer::where('status', '0')
                                            ->where('admin_area',$id)
                                            // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                            ->whereNotIn('customer_id', $code_notin)
                                            ->where('customer_id', 'Like', "%{$keyword_code}%")
                                            // ->orWhere('customer_name', 'Like', "%{$keyword_code}%")
                                            ->whereIn('admin_area', [$id])
                                            ->whereNotIn('customer_status', ['inactive'])
                                            ->get();

                                // dd($customer_list);
                $count_page = Customer::where('admin_area', $id)->where('customer_id', $keyword_code)->count();

                $perpage = 10;
                $total_page = ceil($count_page / $perpage);
                $start = ($perpage * $page) - $perpage;

                $check_customer_code = Customer::where('status', '0')
                                                ->where('admin_area',$id)
                                                // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                                ->whereNotIn('customer_id', $code_notin)
                                                ->where('customer_id',  'Like', "%{$keyword_code}%")
                                                // ->orWhere('customer_name', 'Like', "%{$keyword_code}%")
                                                ->whereIn('admin_area', [$id])
                                                ->whereNotIn('customer_status', ['inactive'])
                                                ->first();

                // dd($check_customer_code);

                // dd($check_search->admin_area);
                if(!$check_customer_code  == null) {
                    return view('portal/customer-waiting', compact('customer_list', 'user_name', 'page', 'total_page', 'start', 'count_all',  'count_waiting', 'count_action', 'count_completed', 'count_alert', 'status_customer'));
                }

                    return back();
    
            }

        return view('portal/customer-waiting', compact('customer_list', 'user_name', 'page', 'total_page', 'start', 'count_all',  'count_waiting', 'count_action', 'count_completed', 'count_alert', 'status_customer'));

        } else if($status_customer == 'action') {
            
            $count_page = Customer::where('admin_area', $id)
                                    ->where('status', "ต้องดำเนินการ")
                                    ->whereNotIn('customer_status', ['inactive'])
                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();
    
            $perpage = 10;
            $total_page = ceil($count_page / $perpage);
            $start = ($perpage * $page) - $perpage;
            
            $user_name = User::select('name', 'admin_area','user_code', 'rights_area')->where('user_code', $code)->first();
            $customer_list = Customer::select('id', 'admin_area', 'customer_code', 'customer_name', 'sale_area', 'status', 'email', 'created_at', 'customer_status')
                                    ->where('admin_area', $id)
                                    ->where('status', 'ต้องดำเนินการ')
                                    ->whereNotIn('customer_status', ['inactive'])
                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->offset($start)
                                    ->limit($perpage)
                                    ->get();

            $count_all = Customer::select('status')
                                    ->where('admin_area', $id)
                                    ->whereNotIn('customer_status', ['inactive'])
                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();

            $count_waiting = Customer::where('admin_area', $id)
                                        ->where('status', 'รอดำเนินการ')
                                        ->whereNotIn('customer_status', ['inactive'])
                                        // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                        ->whereNotIn('customer_id', $code_notin)
                                        ->count();

            $count_action = Customer::where('admin_area', $id)
                                        ->where('status', 'ต้องดำเนินการ')
                                        ->whereNotIn('customer_status', ['inactive'])
                                        // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                        ->whereNotIn('customer_id', $code_notin)
                                        ->count();

            $count_completed = Customer::where('admin_area', $id)
                                            ->where('status', 'ดำเนินการแล้ว')
                                            ->whereNotIn('customer_status', ['inactive'])
                                            // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                            ->whereNotIn('customer_id', $code_notin)
                                            ->count();

            $count_alert = $count_waiting + $count_action;

            //search;
            if($keyword_code != '') {
                $customer_list = Customer::where('status', 'ต้องดำเนินการ')
                                            ->where('admin_area',$id)
                                            // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                            ->whereNotIn('customer_id', $code_notin)
                                            ->where('customer_id', 'Like', "%{$keyword_code}%")
                                            // ->orWhere('customer_name', 'Like', "%{$keyword_code}%")
                                            ->whereIn('admin_area', [$id])
                                            ->whereNotIn('customer_status', ['inactive'])
                                            ->get();

                                // dd($customer_list);
                $count_page = Customer::where('admin_area', $id)->where('customer_id', $keyword_code)->count();

                $perpage = 10;
                $total_page = ceil($count_page / $perpage);
                $start = ($perpage * $page) - $perpage;

                $check_customer_code = Customer::where('status', 'ต้องดำเนินการ')
                                                ->where('admin_area',$id)
                                                // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                                ->whereNotIn('customer_id', $code_notin)
                                                ->where('customer_id',  'Like', "%{$keyword_code}%")
                                                // ->orWhere('customer_name', 'Like', "%{$keyword_code}%")
                                                ->whereIn('admin_area', [$id])
                                                ->whereNotIn('customer_status', ['inactive'])
                                                ->first();

                // dd($check_customer_code);

                // dd($check_search->admin_area);
                if(!$check_customer_code  == null) {
                    return view('portal/customer-action', compact('customer_list', 'user_name', 'page', 'total_page', 'start','count_all', 'count_waiting', 'count_action', 'count_completed','count_alert',  'status_customer'));
                }
                return back();
            }

            return view('portal/customer-action', compact('customer_list', 'user_name', 'page', 'total_page', 'start','count_all', 'count_waiting', 'count_action', 'count_completed','count_alert',  'status_customer'));
        
        } else if ($status_customer == 'completed') {

            $count_page = Customer::where('admin_area', $id)
                                    ->whereNotIn('customer_status', ['inactive'])
                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->where('status', "ดำเนินการแล้ว")
                                    ->count();
    
            $perpage = 10;
            $total_page = ceil($count_page / $perpage);
            $start = ($perpage * $page) - $perpage;
            
            $user_name = User::select('name', 'admin_area','user_code', 'rights_area')->where('user_code', $code)->first();
            $customer_list = Customer::select('id', 'admin_area', 'customer_code', 'customer_name', 'sale_area', 'status', 'email', 'created_at', 'customer_status')
                                    ->where('admin_area', $id)
                                    ->where('status', "ดำเนินการแล้ว")
                                    ->whereNotIn('customer_status', ['inactive'])
                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->offset($start)
                                    ->limit($perpage)
                                    ->get();

            $count_all = Customer::select('status')
                                    ->where('admin_area', $id)
                                    ->whereNotIn('customer_status', ['inactive'])
                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();
        
            $count_waiting = Customer::where('admin_area', $id)
                                        ->where('status', 'รอดำเนินการ')
                                        ->whereNotIn('customer_status', ['inactive'])
                                        // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                        ->whereNotIn('customer_id', $code_notin)
                                        ->count();

            $count_action = Customer::where('admin_area', $id)
                                        ->where('status', 'ต้องดำเนินการ')
                                        ->whereNotIn('customer_status', ['inactive'])
                                        // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                        ->whereNotIn('customer_id', $code_notin)
                                        ->count();

            $count_completed = Customer::where('admin_area', $id)
                                            ->where('status', 'ดำเนินการแล้ว')
                                            ->whereNotIn('customer_status', ['inactive'])
                                            // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                            ->whereNotIn('customer_id', $code_notin)
                                            ->count();

            $count_alert = $count_waiting + $count_action;

            //search;
            if($keyword_code != '') {
                $customer_list = Customer::where('status', 'ดำเนินการแล้ว')
                                            ->where('admin_area',$id)
                                            // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                            ->whereNotIn('customer_id', $code_notin)
                                            ->where('customer_id', 'Like', "%{$keyword_code}%")
                                            // ->orWhere('customer_name', 'Like', "%{$keyword_code}%")
                                            ->whereIn('admin_area', [$id])
                                            ->whereNotIn('customer_status', ['inactive'])
                                            ->get();

                                // dd($customer_list);
                $count_page = Customer::where('admin_area', $id)->where('customer_id', $keyword_code)
                                        ->whereNotIn('customer_id', $code_notin)->count();

                $perpage = 10;
                $total_page = ceil($count_page / $perpage);
                $start = ($perpage * $page) - $perpage;

                $check_customer_code = Customer::where('status', 'ดำเนินการแล้ว')
                                                ->where('admin_area',$id)
                                                // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                                ->whereNotIn('customer_id', $code_notin)
                                                ->where('customer_id',  'Like', "%{$keyword_code}%")
                                                // ->orWhere('customer_name', 'Like', "%{$keyword_code}%")
                                                ->whereIn('admin_area', [$id])
                                                ->whereNotIn('customer_status', ['inactive'])
                                                ->first();

                // dd($check_customer_code);

                // dd($check_search->admin_area);
                if(!$check_customer_code  == null) {
                    return view('portal/customer-completed', compact('customer_list', 'user_name', 'page', 'total_page', 'start','count_all', 'count_waiting', 'count_action', 'count_completed','count_alert', 'status_customer'));
                }
                return back();
            }

            return view('portal/customer-completed', compact('customer_list', 'user_name', 'page', 'total_page', 'start','count_all', 'count_waiting', 'count_action', 'count_completed','count_alert', 'status_customer'));
        }
    }

    public function customerEdit(Request $request, $id) 
    {

        //notin code;
        $code_notin = ['0000', '4494', '7787', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];

        // dd($id);
        $customer_edit = Customer::customerEdit($id);
        
        $customer_edit = $customer_edit[0];

        $code = $request->user()->user_code;
        $user_name = User::select('name', 'admin_area','user_code','rights_area')->where('user_code', $code)->first();
        // dd($customer_edit->sale_area);
        
        $province = DB::table('provinces')->select('id', 'name_th')->orderBy('id', 'asc')->get();
        $amphur = DB::table('amphures')->select('name_th', 'province_id')->get();
        $district = DB::table('districts')->select('name_th', 'amphure_id')->get();

        $check_admin_area = $user_name->admin_area;
        // dd($check_admin_area);
        $count_all = Customer::select('status')
                    ->where('admin_area', $check_admin_area)
                    ->whereNotIn('customer_status', ['inactive'])
                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                    ->whereNotIn('customer_id', $code_notin)
                    ->count();

        $count_waiting = Customer::where('admin_area', $check_admin_area)
                        ->where('status', 'รอดำเนินการ')
                        ->whereNotIn('customer_status', ['inactive'])
                        // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                        ->whereNotIn('customer_id', $code_notin)
                        ->count();

        $count_action = Customer::where('admin_area', $check_admin_area)
                        ->where('status', 'ต้องดำเนินการ')
                        ->whereNotIn('customer_status', ['inactive'])
                        // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                        ->whereNotIn('customer_id', $code_notin)
                        ->count();

        $count_completed = Customer::where('admin_area', $check_admin_area)
                            ->where('status', 'ดำเนินการแล้ว')
                            ->whereNotIn('customer_status', ['inactive'])
                            // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                            ->whereNotIn('customer_id', $code_notin)
                            ->count();

        $count_alert = $count_waiting + $count_action;

        $sale_name = Salearea::select('sale_name')->where('sale_area', $customer_edit->sale_area)->first();
        if($sale_name == null) {
            return view('portal/customer-detail', compact('customer_edit', 'province', 'amphur', 'district', 'user_name'));
        }
        
        return view('portal/customer-detail', compact('customer_edit', 'province', 'amphur', 'district', 'user_name', 'sale_name', 'count_all', 'count_waiting', 'count_action', 'count_completed', 'count_alert'));
    }
    //update customer;
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
                if($telephone == null) {
                    $telephone = '';
                }
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
                if($cert_expire == null) {
                    $cert_expire = '';
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
                $delivery_by = $request->delivery_by;

     /*    } */
            Customer::where('id', $id)
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
                        'delivery_by' => $delivery_by,
                    
                    ]);

                // check user id;
                $check_customer_id = Customer::select('id')->where('id', $id)->first();
                $customer_id =  $check_customer_id->id;

                if ($customer_id == $id)
                {
                    echo 'success';
                //    return redirect('/webpanel/customer/'.$id)->with('success', 'check_success');
                }
                else {
                    echo 'fail';
                }
            
    }

    //update image;
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

    /// search customer;
    public function customerSearch(Request $request)
    {
        $keyword = $request->keyword;

        $id = $request->user()->admin_area;

        $check_search_code = Customer::where('customer_id', 'like', '%'.$keyword.'%')
                                        ->orWhere('customer_name', 'like', '%'.$keyword.'%')
                                        ->where('admin_area', $id)->first();
        
        // echo json_encode(array('code' => $check_search_code->admin_area, 'id'=>$id));

        $arr_keyword = ['0000', '4494', '7787', '9000'];
        
        if(in_array($keyword, $arr_keyword) || $check_search_code->admin_area != $id)
        {
          
            echo 'ไม่พบข้อมูล';
            return;
            

        } else {

            $customers = Customer::where('customer_id', 'like', "%{$keyword}%")
                                    ->where('admin_area', $id)
                                    ->orWhere('customer_name', 'like', "%{$keyword}%")
                                    ->whereIn('admin_area', [$id])
                                    ->where('admin_area', $id)->paginate(2);

 /* 
            $check_search = Customer::where('customer_id', 'like', '%'.$keyword)
                                    ->orWhere('customer_name', 'like', '%'.$keyword.'%')
                                    ->whereNotIn('admin_area',[$id])->first();

                                    echo $check_search->admin_area; */
        /*     if($customers== null) {
                echo 'ไม่พบข้อมูล';
                return;
            } */

           
                foreach($customers as $row_customer)
                {

 
                    // if($row_customer->customer_id !=  '0000' AND $check_search->admin_area == $id AND $check_search->admin_area != '') {
                    if($row_customer->customer_id !=  '0000') {

                        echo
                        '

                                
                       <div style="background-color: #17192A; absolute: potision; position: static;">
                            <div class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75  hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-example" data-collapse-toggle="dropdown-example">
                                
                                <a  href="/portal/customer/'.$row_customer->customer_id .'" style="text-decoration: none;"> '.$row_customer->customer_id .' ' .':'.' ' .$row_customer->customer_name.' </a>
                            
                            </div>
                        </div> 
                        
                        ';
                    }
                    
                }
                
            
        }
        
    }

}
