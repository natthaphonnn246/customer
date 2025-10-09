<?php

namespace App\Http\Controllers\Portal;

use App\Models\User;
use App\Models\Salearea;
use App\Models\Customer;
use App\Models\Category;
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
use App\Models\ReportSeller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use Carbon\Carbon;
use Illuminate\Database\Query\JoinClause;
use App\Mail\StatusUpdatedMail;
use App\Mail\RegisterUpdatedMail;
use Illuminate\Support\Facades\Mail;
use App\Models\ProductType;
use App\Models\Setting;
use Illuminate\Pagination\LengthAwarePaginator;


class PortalCustomerController
{

    public function dashboardCharts(Request $request)
    {

        //notin code;
        $code_notin = ['0000', '4494', '7787', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];

        $id = $request->user()->admin_area;
        $code = $request->user()->user_code;

        $user_name = User::select('name', 'admin_area','user_code', 'rights_area')->where('user_code', $code)->first();
        $status_all = DB::table('customers')->select('status')
                                ->where('admin_area', $id)
                                ->whereNotIn('customer_status', ['inactive'])
                                // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                ->whereNotIn('customer_id', $code_notin)
                                ->count();

        $status_waiting = DB::table('customers')->where('admin_area', $id)
                                    ->where('status', 'รอดำเนินการ')
                                    ->whereNotIn('customer_status', ['inactive'])
                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();
                                    // dd($count_waiting);
        $status_action = DB::table('customers')->where('admin_area', $id)
                                    ->where('status', 'ต้องดำเนินการ')
                                    ->whereNotIn('customer_status', ['inactive'])
                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();

        $status_completed = DB::table('customers')->where('admin_area', $id)
                                    ->where('status', 'ดำเนินการแล้ว')
                                    ->whereNotIn('customer_status', ['inactive'])
                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();

        $status_alert = $status_waiting + $status_action;

        $check_modal_waiting = DB::table('customers')
                                ->select('id', 'customer_id', 'customer_name')
                                ->where('admin_area', $id)
                                ->whereNotIn('customer_id', $code_notin)
                                ->where('customer_status', '!=', 'inactive')
                                ->where('status', 'ต้องดำเนินการ')
                                ->get();

        $count_modal_waiting = count($check_modal_waiting);
        $check_edit = DB::table('settings')->where('setting_id', '=', 'WS01')->first()?->check_edit;

        return view('portal/dashboard', compact(
                                                'user_name', 
                                                'status_all', 
                                                'status_waiting', 
                                                'status_action', 
                                                'status_completed', 
                                                'status_alert',
                                                'check_modal_waiting',
                                                'count_modal_waiting',
                                                'check_edit'
                                            ));
    
    }
    public function indexPortal(Request $request)
    {
            //notin code;
            $code_notin = ['0000', '4494', '7787', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];

            $code = $request->user()->user_code;
        
            $user_name = User::select('name', 'admin_area','user_code')->where('user_code', $code)->first();
            $admin_area_list = User::select('admin_area', 'name', 'rights_area', 'user_id')->where('user_code', $code)->first();

            $admin_area = DB::table('customers')->select('admin_area', 'status')->where('admin_area', $user_name->admin_area)->first();
            // dd($admin_area->admin_area);

            $status_all = DB::table('customers')->select('status')
                                        ->where('admin_area', $admin_area->admin_area)
                                        ->whereNotIn('customer_status', ['inactive'])
                                        // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                        ->whereNotIn('customer_id', $code_notin)
                                        ->count();

            $status_waiting = DB::table('customers')->select('status')
                                        ->where('admin_area', $admin_area->admin_area)
                                        ->where('status', 'รอดำเนินการ')
                                        ->whereNotIn('customer_status', ['inactive'])
                                        // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                        ->whereNotIn('customer_id', $code_notin)
                                        ->count();
            // dd($status_waiting);

            $status_action = DB::table('customers')->select('status')
                                        ->where('admin_area', $admin_area->admin_area)
                                        ->where('status', 'ต้องดำเนินการ')
                                        ->whereNotIn('customer_status', ['inactive'])
                                        // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                        ->whereNotIn('customer_id', $code_notin)
                                        ->count();

            $status_completed = DB::table('customers')->select('status')
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
            if($admin_area == null) {
                $admin_area = '';
            }
            $cert_store = $request->file('cert_store');
            $cert_medical = $request->file('cert_medical');
            $cert_commerce = $request->file('cert_commerce');
            $cert_vat = $request->file('cert_vat');
            $cert_id = $request->file('cert_id');

            $cert_expire = $request->cert_expire;
            // $status = 'รอดำเนินการ';
            $status = 'ลงทะเบียนใหม่';
            $purchase = $request->purchase;
        }   

            if($cert_store != '' && $customer_id != '')
            {
                // $image_cert_store = $request->file('cert_store')->storeAs('img_certstore', $customer_id.'_certstore.jpg');
                $image_cert_store = $request->file('cert_store')->storeAs('img_certstore', $customer_id.'_certstore.jpg', 'cert_image');
            } else {
                $image_cert_store = '';
            }

            if($cert_medical != '' && $customer_id != '')
            {
                $image_cert_medical = $request->file('cert_medical')->storeAs('img_certmedical', $customer_id.'_certmedical.jpg', 'cert_image');
            } else {
                $image_cert_medical = '';
            }

            if($cert_commerce != '' && $customer_id != '')
            {
                $image_cert_commerce = $request->file('cert_commerce')->storeAs('img_certcommerce', $customer_id.'_certcommerce.jpg', 'cert_image');
            } else {
                $image_cert_commerce = '';
            }

            if($cert_vat != '' && $customer_id != '')
            {
                $image_cert_vat = $request->file('cert_vat')->storeAs('img_certvat', $customer_id.'_certvat.jpg', 'cert_image');
            } else {
                $image_cert_vat = '';
            }

            if($cert_id != '' && $customer_id != '')
            {
                $image_cert_id = $request->file('cert_id')->storeAs('img_certid', $customer_id.'_certid.jpg', 'cert_image');
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
                        'points' => '0',
                        'add_license' => 'ไม่ระบุ',
                        'purchase'    => $purchase
                        // 'maintenance_status' => '',
                        // 'allowed_maintenance' => '',

                    ]);

        } else {

            return back()->with('error_code', 'ลงทะเบียนไม่สำเร็จ กรุณาตรวจสอบอีกรอบครับ');

        }

           // $status = Customer::findOrFail($id);
           $status = Customer::where('customer_code', $customer_code)->first();
        //    dd($status->status);

           if ($status->status === 'ลงทะเบียนใหม่') {
               
            //    $checkUpdate = 'register';
               Mail::to('vmdrugcenter2019@gmail.com')->queue(new RegisterUpdatedMail($status->customer_code));

               //not queue;
               /* Mail::to('vmdrugcenter2019@gmail.com')->send(new StatusUpdatedMail($status->id)); */

           }

        return back()->with('success', 'ลงทะเบียนสำเร็จ กรุณาติดต่อผู้ดูแลด้วยครับ');

    }

    //portal/customer;
    public function customerView(Request $request)
    {
        // dd('dd');

        $page = $request->page;
        if ($page) {
            $page = $request->page;
        } else {
            $page = 1;
        }


        $check_edit = DB::table('settings')->where('setting_id', '=', 'WS01')->first()?->check_edit;
        // dd($check_edit);

        $keyword_code = $request->keyword;
        $id = $request->user()->admin_area;
        $code = $request->user()->user_code;

        //notin code;
        $code_notin = ['0000', '4494', '7787', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];

        // $count_page = Customer::where('admin_area', $id)
        //                         ->whereNotIn('customer_id', $code_notin)
        //                         ->count();

        //check modal;
        $check_modal_waiting = DB::table('customers')
                                ->select('id', 'customer_id', 'customer_name')
                                ->where('admin_area', $id)
                                ->whereNotIn('customer_id', $code_notin)
                                ->where('customer_status', '!=', 'inactive')
                                ->where('status', 'ต้องดำเนินการ')
                                ->get();

        $count_modal_waiting = count($check_modal_waiting);
        // dd(count($check_modal_waiting));
        $count_page = DB::table('customers')->where('admin_area', $id)
                                ->whereNotIn('customer_id', $code_notin)
                                ->where('customer_status', '!=', 'inactive')
                                ->count();
                                // dd($count_page);
   
        $perpage = 10;
        $total_page = ceil($count_page / $perpage);
        $start = ($perpage * $page) - $perpage;
        
        $user_name = User::select('name', 'admin_area','user_code', 'rights_area')->where('user_code', $code)->first();
        $pur_report = User::select('purchase_status')->where('user_code', $code)->first();
        // dd($pur_report->admin_role);

        $customer_list = DB::table('customers')->select('id', 'admin_area', 'customer_code', 'customer_name', 'sale_area', 'status', 'email', 'created_at', 'customer_status')
                                    ->where('admin_area', $id)
                                    ->whereNotIn('customer_status', ['inactive'])
                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->offset($start)
                                    ->limit($perpage)
                                    ->get();

        $status_all = DB::table('customers')->select('status')
                                ->where('admin_area', $id)
                                ->whereNotIn('customer_status', ['inactive'])
                                // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                ->whereNotIn('customer_id', $code_notin)
                                ->count();

        $status_waiting = DB::table('customers')->where('admin_area', $id)
                                    ->where('status', 'รอดำเนินการ')
                                    ->whereNotIn('customer_status', ['inactive'])
                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();
                                    // dd($count_waiting);
        $status_action = DB::table('customers')->where('admin_area', $id)
                                    ->where('status', 'ต้องดำเนินการ')
                                    ->whereNotIn('customer_status', ['inactive'])
                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();

        $status_completed = DB::table('customers')->where('admin_area', $id)
                                    ->where('status', 'ดำเนินการแล้ว')
                                    ->whereNotIn('customer_status', ['inactive'])
                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();

        $status_alert = $status_waiting + $status_action;

        $check_id = DB::table('report_sellers')->whereNotIn('customer_id', $code_notin)
                                ->select('customer_id')
                                ->distinct()
                                ->get(); 

        $check_purchase = DB::table('report_sellers')->whereNotIn('customer_id', $code_notin)
                                        ->select('customer_id')
                                        ->selectRaw('MAX(date_purchase) as date_purchase')
                                        ->groupBy('customer_id')
                                        ->orderByDesc('date_purchase')
                                        ->get(); 


/*         $setting_check = Setting::where('setting_id', 'WS01')->value('check_type');
        $code_type = User::where('user_id', $code)->first()->value('allowed_check_type');
        
        if ((int)$setting_check === 1 && (int)$code_type === 1) {
            $check_type_pass = 1;
        } else {
            $check_type_pass = 0;
        } */
        //keyword;
        if($keyword_code != '') {
            $customer_list = DB::table('customers')->where('admin_area',$id)
                            // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                            ->whereNotIn('customer_id', $code_notin)
                            ->where('customer_id', 'Like', "%{$keyword_code}%")
                            ->orWhere('customer_name', 'Like', "%{$keyword_code}%")
                            ->whereIn('admin_area', [$id])
                            ->get();

                            // dd($customer_list);
            $count_page = DB::table('customers')->where('admin_area', $id)->where('customer_id', $keyword_code)
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();

            $perpage = 10;
            $total_page = ceil($count_page / $perpage);
            $start = ($perpage * $page) - $perpage;

            $check_customer_code = DB::table('customers')->where('admin_area',$id)
                                            // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                            ->whereNotIn('customer_id', $code_notin)
                                            ->where('customer_id',  'Like', "%{$keyword_code}%")
                                            ->orWhere('customer_name', 'Like', "%{$keyword_code}%")
                                            ->whereIn('admin_area', [$id])
                                            ->first();

            // dd($check_customer_code);

            // dd($check_search->admin_area);
            if (!empty($check_customer_code)) {
                return view('portal/customer', array_merge(
                                                compact(
                                                    'customer_list', 
                                                    'user_name', 
                                                    'page', 
                                                    'total_page', 
                                                    'start', 
                                                    'status_waiting', 
                                                    'status_action', 
                                                    'status_completed', 
                                                    'status_all', 
                                                    'status_alert', 
                                                    'pur_report', 
                                                    'check_id', 
                                                    'check_purchase',
                                                    'check_edit',
                                                /*     'count_modal_waiting',
                                                    'check_modal_waiting' */
                                                ),
                                                ['json_edit' => json_encode($check_edit)]
                                            ));
                
            //  dd('check');
            }

                return redirect()->route('portal.customer');
            
 
        }
        // dd($customer_list);
        return view('portal/customer', array_merge(
                                        compact(
                                            'customer_list', 
                                            'user_name', 
                                            'page', 
                                            'total_page', 
                                            'start', 
                                            'status_waiting', 
                                            'status_action', 
                                            'status_completed', 
                                            'status_all', 
                                            'status_alert', 
                                            'pur_report', 
                                            'check_id', 
                                            'check_purchase',
                                            'check_edit',
                                            'count_modal_waiting',
                                            'check_modal_waiting',
                                        ),
                                        ['json_edit' => json_encode($check_edit)]
                                    ));
        
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

        $check_edit = DB::table('settings')->where('setting_id', '=', 'WS01')->first()?->check_edit;

        $id = $request->user()->admin_area;
        $code = $request->user()->user_code;

        $keyword_code = $request->keyword;
        // dd($keyword_code);

        if($status_customer == 'waiting') {

            $count_page = DB::table('customers')->where('admin_area', $id)
                                    ->where('status', "รอดำเนินการ")
                                    ->whereNotIn('customer_status', ['inactive'])
                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();
    
            $perpage = 10;
            $total_page = ceil($count_page / $perpage);
            $start = ($perpage * $page) - $perpage;
            
            $user_name = User::select('name', 'admin_area','user_code', 'rights_area')->where('user_code', $code)->first();
            $customer_list = DB::table('customers')->select('id', 'admin_area', 'customer_code', 'customer_name', 'sale_area', 'status', 'email', 'created_at', 'customer_status')
                                    ->where('admin_area', $id)
                                    ->where('status', 'รอดำเนินการ')
                                    ->whereNotIn('customer_status', ['inactive'])
                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->offset($start)
                                    ->limit($perpage)
                                    ->get();

            $count_all = DB::table('customers')->select('status')
                                    ->where('admin_area', $id)
                                    ->whereNotIn('customer_status', ['inactive'])
                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();
    
            $count_waiting = DB::table('customers')->where('admin_area', $id)
                                        ->where('status', 'รอดำเนินการ')
                                        ->whereNotIn('customer_status', ['inactive'])
                                        // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                        ->whereNotIn('customer_id', $code_notin)
                                        ->count();
                                        // dd($count_waiting);
            $count_action = DB::table('customers')->where('admin_area', $id)
                                        ->where('status', 'ต้องดำเนินการ')
                                        ->whereNotIn('customer_status', ['inactive'])
                                        // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                        ->whereNotIn('customer_id', $code_notin)
                                        ->count();
    
            $count_completed = DB::table('customers')->where('admin_area', $id)
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

                $customer_list = DB::table('customers')->where('status', 'รอดำเนินการ')
                                            ->where('admin_area',$id)
                                            // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                            ->whereNotIn('customer_id', $code_notin)
                                            ->where('customer_id', 'Like', "%{$keyword_code}%")
                                            // ->orWhere('customer_name', 'Like', "%{$keyword_code}%")
                                            ->whereIn('admin_area', [$id])
                                            ->whereNotIn('customer_status', ['inactive'])
                                            ->get();

                                // dd($customer_list);
                $count_page = DB::table('customers')->where('admin_area', $id)->where('customer_id', $keyword_code)->count();

                $perpage = 10;
                $total_page = ceil($count_page / $perpage);
                $start = ($perpage * $page) - $perpage;

                $check_customer_code = DB::table('customers')->where('status', 'รอดำเนินการ')
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
                if (!empty($check_customer_code)) {

                    // dd('customer');
                    return view('portal/customer-waiting', array_merge(
                                                            compact(
                                                                    'customer_list', 
                                                                    'user_name', 
                                                                    'page', 
                                                                    'total_page', 
                                                                    'start', 
                                                                    'count_all',  
                                                                    'count_waiting', 
                                                                    'count_action', 
                                                                    'count_completed', 
                                                                    'count_alert', 
                                                                    'status_customer',
                                                                    'check_edit'
                                                                ),
                                                                ['json_edit' => json_encode($check_edit)]
                                                            ));
                }

                    return back();
    
            }

            return view('portal/customer-waiting', array_merge(
                                                    compact(
                                                            'customer_list', 
                                                            'user_name', 
                                                            'page', 
                                                            'total_page', 
                                                            'start', 
                                                            'count_all',  
                                                            'count_waiting', 
                                                            'count_action', 
                                                            'count_completed', 
                                                            'count_alert', 
                                                            'status_customer',
                                                            'check_edit'
                                                        ),
                                                        ['json_edit' => json_encode($check_edit)]
                                                    ));

        } else if($status_customer == 'action') {
            
            $count_page = DB::table('customers')->where('admin_area', $id)
                                    ->where('status', "ต้องดำเนินการ")
                                    ->whereNotIn('customer_status', ['inactive'])
                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();
    
            $perpage = 10;
            $total_page = ceil($count_page / $perpage);
            $start = ($perpage * $page) - $perpage;
            
            $user_name = User::select('name', 'admin_area','user_code', 'rights_area')->where('user_code', $code)->first();
            $customer_list = DB::table('customers')->select('id', 'admin_area', 'customer_code', 'customer_name', 'sale_area', 'status', 'email', 'created_at', 'customer_status')
                                    ->where('admin_area', $id)
                                    ->where('status', 'ต้องดำเนินการ')
                                    ->whereNotIn('customer_status', ['inactive'])
                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->offset($start)
                                    ->limit($perpage)
                                    ->get();

            $count_all = DB::table('customers')->select('status')
                                    ->where('admin_area', $id)
                                    ->whereNotIn('customer_status', ['inactive'])
                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();

            $count_waiting = DB::table('customers')->where('admin_area', $id)
                                        ->where('status', 'รอดำเนินการ')
                                        ->whereNotIn('customer_status', ['inactive'])
                                        // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                        ->whereNotIn('customer_id', $code_notin)
                                        ->count();

            $count_action = DB::table('customers')->where('admin_area', $id)
                                        ->where('status', 'ต้องดำเนินการ')
                                        ->whereNotIn('customer_status', ['inactive'])
                                        // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                        ->whereNotIn('customer_id', $code_notin)
                                        ->count();

            $count_completed = DB::table('customers')->where('admin_area', $id)
                                            ->where('status', 'ดำเนินการแล้ว')
                                            ->whereNotIn('customer_status', ['inactive'])
                                            // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                            ->whereNotIn('customer_id', $code_notin)
                                            ->count();

            $count_alert = $count_waiting + $count_action;

            //search;
            if($keyword_code != '') {
                $customer_list = DB::table('customers')->where('status', 'ต้องดำเนินการ')
                                            ->where('admin_area',$id)
                                            // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                            ->whereNotIn('customer_id', $code_notin)
                                            ->where('customer_id', 'Like', "%{$keyword_code}%")
                                            // ->orWhere('customer_name', 'Like', "%{$keyword_code}%")
                                            ->whereIn('admin_area', [$id])
                                            ->whereNotIn('customer_status', ['inactive'])
                                            ->get();

                                // dd($customer_list);
                $count_page = DB::table('customers')->where('admin_area', $id)->where('customer_id', $keyword_code)->count();

                $perpage = 10;
                $total_page = ceil($count_page / $perpage);
                $start = ($perpage * $page) - $perpage;

                $check_customer_code = DB::table('customers')->where('status', 'ต้องดำเนินการ')
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
                if (!empty($check_customer_code)) {
                    return view('portal/customer-action', array_merge(
                                                                compact(
                                                                    'customer_list', 
                                                                    'user_name', 
                                                                    'page', 
                                                                    'total_page', 
                                                                    'start',
                                                                    'count_all', 
                                                                    'count_waiting', 
                                                                    'count_action', 
                                                                    'count_completed',
                                                                    'count_alert',  
                                                                    'status_customer',
                                                                    'check_edit'
                                                                ), ['json_edit' => json_encode($check_edit)]
                                                            ));
                }
                return back();
            }

            return view('portal/customer-action', array_merge(
                                                    compact(
                                                            'customer_list', 
                                                            'user_name', 
                                                            'page', 
                                                            'total_page', 
                                                            'start',
                                                            'count_all', 
                                                            'count_waiting', 
                                                            'count_action', 
                                                            'count_completed',
                                                            'count_alert',  
                                                            'status_customer',
                                                            'check_edit'
                                                        ), ['json_edit' => json_encode($check_edit)]
                                                    ));
        
        } else if ($status_customer == 'completed') {

            $count_page = DB::table('customers')->where('admin_area', $id)
                                    ->whereNotIn('customer_status', ['inactive'])
                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->where('status', "ดำเนินการแล้ว")
                                    ->count();
    
            $perpage = 10;
            $total_page = ceil($count_page / $perpage);
            $start = ($perpage * $page) - $perpage;
            
            $user_name = User::select('name', 'admin_area','user_code', 'rights_area')->where('user_code', $code)->first();
            $customer_list = DB::table('customers')->select('id', 'admin_area', 'customer_code', 'customer_name', 'sale_area', 'status', 'email', 'created_at', 'customer_status')
                                    ->where('admin_area', $id)
                                    ->where('status', "ดำเนินการแล้ว")
                                    ->whereNotIn('customer_status', ['inactive'])
                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->offset($start)
                                    ->limit($perpage)
                                    ->get();

            $count_all = DB::table('customers')->select('status')
                                    ->where('admin_area', $id)
                                    ->whereNotIn('customer_status', ['inactive'])
                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();
        
            $count_waiting = DB::table('customers')->where('admin_area', $id)
                                        ->where('status', 'รอดำเนินการ')
                                        ->whereNotIn('customer_status', ['inactive'])
                                        // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                        ->whereNotIn('customer_id', $code_notin)
                                        ->count();

            $count_action = DB::table('customers')->where('admin_area', $id)
                                        ->where('status', 'ต้องดำเนินการ')
                                        ->whereNotIn('customer_status', ['inactive'])
                                        // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                        ->whereNotIn('customer_id', $code_notin)
                                        ->count();

            $count_completed = DB::table('customers')->where('admin_area', $id)
                                            ->where('status', 'ดำเนินการแล้ว')
                                            ->whereNotIn('customer_status', ['inactive'])
                                            // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                            ->whereNotIn('customer_id', $code_notin)
                                            ->count();

            $count_alert = $count_waiting + $count_action;

            //search;
            if($keyword_code != '') {
                $customer_list = DB::table('customers')->where('status', 'ดำเนินการแล้ว')
                                            ->where('admin_area',$id)
                                            // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                            ->whereNotIn('customer_id', $code_notin)
                                            ->where('customer_id', 'Like', "%{$keyword_code}%")
                                            // ->orWhere('customer_name', 'Like', "%{$keyword_code}%")
                                            ->whereIn('admin_area', [$id])
                                            ->whereNotIn('customer_status', ['inactive'])
                                            ->get();

                                // dd($customer_list);
                $count_page = DB::table('customers')->where('admin_area', $id)->where('customer_id', $keyword_code)
                                        ->whereNotIn('customer_id', $code_notin)->count();

                $perpage = 10;
                $total_page = ceil($count_page / $perpage);
                $start = ($perpage * $page) - $perpage;

                $check_customer_code = DB::table('customers')->where('status', 'ดำเนินการแล้ว')
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
                if (!empty($check_customer_code)) {
                    return view('portal/customer-completed', array_merge(
                                                                    compact(
                                                                        'customer_list', 
                                                                        'user_name', 
                                                                        'page', 
                                                                        'total_page', 
                                                                        'start',
                                                                        'count_all', 
                                                                        'count_waiting', 
                                                                        'count_action', 
                                                                        'count_completed',
                                                                        'count_alert', 
                                                                        'status_customer',
                                                                        'check_edit'
                                                                    ), ['json_edit' => json_encode($check_edit)]
                                                                ));
                }
                return back();
            }

            return view('portal/customer-completed', array_merge(
                                                            compact(
                                                                'customer_list', 
                                                                'user_name', 
                                                                'page', 
                                                                'total_page', 
                                                                'start',
                                                                'count_all', 
                                                                'count_waiting', 
                                                                'count_action', 
                                                                'count_completed',
                                                                'count_alert', 
                                                                'status_customer',
                                                                'check_edit'
                                                            ), ['json_edit' => json_encode($check_edit)]
                                                            ));
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
        
        $province   = DB::table('provinces')->select('id', 'name_th')->orderBy('id', 'asc')->get();
        $amphur     = DB::table('amphures')->select('name_th', 'province_id')->get();
        $district   = DB::table('districts')->select('name_th', 'amphure_id')->get();

        $check_admin_area = $user_name->admin_area;
        // dd($check_admin_area);
        $count_all = DB::table('customers')->select('status')
                        ->where('admin_area', $check_admin_area)
                        ->whereNotIn('customer_status', ['inactive'])
                        // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                        ->whereNotIn('customer_id', $code_notin)
                        ->count();

        $count_waiting = DB::table('customers')->where('admin_area', $check_admin_area)
                            ->where('status', 'รอดำเนินการ')
                            ->whereNotIn('customer_status', ['inactive'])
                            // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                            ->whereNotIn('customer_id', $code_notin)
                            ->count();

        $count_action = DB::table('customers')->where('admin_area', $check_admin_area)
                            ->where('status', 'ต้องดำเนินการ')
                            ->whereNotIn('customer_status', ['inactive'])
                            // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                            ->whereNotIn('customer_id', $code_notin)
                            ->count();

        $count_completed = DB::table('customers')->where('admin_area', $check_admin_area)
                                ->where('status', 'ดำเนินการแล้ว')
                                ->whereNotIn('customer_status', ['inactive'])
                                // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                ->whereNotIn('customer_id', $code_notin)
                                ->count();

        $count_alert = $count_waiting + $count_action;

        $sale_name = Salearea::select('sale_name')->where('sale_area', $customer_edit->sale_area)->first();
        if($sale_name == null) {
            // return view('portal/customer-detail', compact('customer_edit', 'province', 'amphur', 'district', 'user_name'));
            return view('portal/customer-detail', compact('customer_edit', 'province', 'amphur', 'district', 'user_name', 'count_all', 'count_waiting', 'count_action', 'count_completed', 'count_alert'));

        }
        
        return view('portal/customer-detail', compact('customer_edit', 'province', 'amphur', 'district', 'user_name', 'sale_name', 'count_all', 'count_waiting', 'count_action', 'count_completed', 'count_alert'));
    }
    //update customer;
    public function updateEdit(Request $request, $id)
    {

        // dd($id);

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

                $purchase = $request->purchase;

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
                            'purchase' => $purchase,
                    
                    ]);

                    $status = Customer::findOrFail($id);
                    // dd($status->id);

                    if ($status->status_update === 'updated') {
                        
                        $checkUpdate = 'submit';
                        Mail::to('vmdrugcenter2019@gmail.com')->queue(new StatusUpdatedMail($status->id,$checkUpdate));

                        //not queue;
                        /* Mail::to('vmdrugcenter2019@gmail.com')->send(new StatusUpdatedMail($status->id)); */

                    }
                    
        
             /*    return response()->json([
                    'message' => 'อัปเดตสถานะเรียบร้อย (ส่งอีเมลในคิวแล้ว)',
                    'order'   => $order
                ]); */

                // usleep(100000);
                // check user id;
                $check_customer_id = Customer::select('id')->where('id', $id)->first();
                $customer_id =  $check_customer_id->id;

                if ($customer_id == $id)
                {
                    // echo 'success';
                    return redirect('/portal/customer/'.$id)->with('status', 'updated_success');
                }
                else {
                    // echo 'fail';
                    return redirect('/portal/customer/'.$id)->with('status', 'updated_fail');
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
                    // $image_cert_store = $request->file('cert_store')->storeAs('img_certstore', $id.'_certstore.jpg');
                    $image_cert_store = $request->file('cert_store')->storeAs('img_certstore', $id.'_certstore.jpg', 'cert_image');

                } else if ($cert_store == '') {
                    $cert_store_old = Customer::select('cert_store')->where('customer_id', $id)->first();
                    $image_cert_store = $cert_store_old->cert_store;

                } else {
                    $image_cert_store = '';
                }

                Customer::where('customer_id', $id)
                        ->update ([

                            // 'cert_store' => "storage/".$image_cert_store,
                            'cert_store' => $image_cert_store,
                            'status_update' => 'updated',

                        ]);

                // $status = Customer::findOrFail($id);
                $status = Customer::where('customer_id', $id)->first();
                // dd($status->status_update);

                if ($status->status_update === 'updated') {
                    
                    $checkUpdate = 'certstore';
                    Mail::to('vmdrugcenter2019@gmail.com')->queue(new StatusUpdatedMail($status->id, $checkUpdate));

                    //not queue;
                    /* Mail::to('vmdrugcenter2019@gmail.com')->send(new StatusUpdatedMail($status->id)); */

                }

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
                    $image_cert_medical = $request->file('cert_medical')->storeAs('img_certmedical', $id.'_certmedical.jpg', 'cert_image');

                } else if ($cert_medical == '') {
                    $cert_medical_old = Customer::select('cert_medical')->where('customer_id',$id)->first();
                    $image_cert_medical = $cert_medical_old->cert_medical;

                } else {
                    $image_cert_medical = '';
                }

                Customer::where('customer_id', $id)
                        ->update ([
                            
                            'cert_medical' =>  $image_cert_medical,
                            'status_update' => 'updated',

                        ]);

                // $status = Customer::findOrFail($id);
                $status = Customer::where('customer_id', $id)->first();
                // dd($status->status_update);

                if ($status->status_update === 'updated') {
                    
                    $checkUpdate = 'certmedical';
                    Mail::to('vmdrugcenter2019@gmail.com')->queue(new StatusUpdatedMail($status->id, $checkUpdate));

                    //not queue;
                    /* Mail::to('vmdrugcenter2019@gmail.com')->send(new StatusUpdatedMail($status->id)); */

                }

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
                    $image_cert_commerce = $request->file('cert_commerce')->storeAs('img_certcommerce', $id.'_certcommerce.jpg', 'cert_image');

                } elseif($cert_commerce == '') {
                    $cert_commerce_old = Customer::select('cert_commerce')->where('customer_id', $id)->first();
                    $image_cert_commerce = $cert_commerce_old->cert_commerce;

                } else {
                    $image_cert_commerce = '';
                }
        
                Customer::where('customer_id', $id)
                        ->update ([
                            // 'cert_commerce' =>  $image_cert_commerce,
                            'cert_commerce' => $image_cert_commerce,
                            'status_update' => 'updated',

                        ]);

                // $status = Customer::findOrFail($id);
                $status = Customer::where('customer_id', $id)->first();
                // dd($status->status_update);

                if ($status->status_update === 'updated') {
                    
                    // Mail::to('vmdrugcenter2019@gmail.com')->queue(new StatusUpdatedMail($status->id));

                    //not queue;
                    /* Mail::to('vmdrugcenter2019@gmail.com')->send(new StatusUpdatedMail($status->id)); */

                }

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
                    $image_cert_vat = $request->file('cert_vat')->storeAs('img_certvat', $id.'_certvat.jpg', 'cert_image');

                } else if($cert_vat == '') {
                    $cert_vat_old = Customer::select('cert_vat')->where('customer_id', $id)->first();
                    $image_cert_vat = $cert_vat_old->cert_vat;

                } else {
                    $image_cert_vat = '';
                }
        
                Customer::where('customer_id', $id)
                        ->update ([

                            'cert_vat' =>  $image_cert_vat,
                            'status_update' => 'updated',

                        ]);

                // $status = Customer::findOrFail($id);
                $status = Customer::where('customer_id', $id)->first();
                // dd($status->status_update);

                if ($status->status_update === 'updated') {
                    
                    // Mail::to('vmdrugcenter2019@gmail.com')->queue(new StatusUpdatedMail($status->id));

                    //not queue;
                    /* Mail::to('vmdrugcenter2019@gmail.com')->send(new StatusUpdatedMail($status->id)); */

                }

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
                    $image_cert_id = $request->file('cert_id')->storeAs('img_certid', $id.'_certid.jpg', 'cert_image');

                } elseif ($cert_id == '') {
                    $cert_id_old = Customer::select('cert_id')->where('customer_id', $id)->first();
                    $image_cert_id = $cert_id_old->cert_id;

                } else {
                    $image_cert_id = '';
                } 
                
                Customer::where('customer_id', $id)
                        ->update ([

                            'cert_id' => $image_cert_id,
                            'status_update' => 'updated',

                        ]);

                // $status = Customer::findOrFail($id);
                $status = Customer::where('customer_id', $id)->first();
                // dd($status->status_update);

                if ($status->status_update === 'updated') {
                    
                    // Mail::to('vmdrugcenter2019@gmail.com')->queue(new StatusUpdatedMail($status->id));

                    //not queue;
                    /* Mail::to('vmdrugcenter2019@gmail.com')->send(new StatusUpdatedMail($status->id)); */

                }

            }
            return back();
    }

    /// search customer;
    public function customerSearch(Request $request)
    {
        $keyword = $request->keyword;

        $id = $request->user()->admin_area;

        $check_search_code = DB::table('customers')->where('customer_id', 'like', '%'.$keyword.'%')
                            ->orWhere('customer_name', 'like', '%'.$keyword.'%')
                            ->whereNotIn('customer_status', ['inactive'])
                            ->where('admin_area', $id)
                            ->first();
        
        // echo json_encode(array('code' => $check_search_code->admin_area, 'id'=>$id));

        $arr_keyword = ['0000', '4494', '7787', '9000'];
        
        if(in_array($keyword, $arr_keyword) || $check_search_code->admin_area != $id)
        {
          
            echo 'ไม่พบข้อมูล';
            return;
            

        } else {

            $customers = DB::table('customers')->where('customer_id', 'like', "%{$keyword}%")
                            ->whereNotIn('customer_status', ['inactive'])
                            ->where('admin_area', $id)
                            ->orWhere('customer_name', 'like', "%{$keyword}%")
                            ->whereIn('admin_area', [$id])
                            ->where('admin_area', $id)
                            ->paginate(2);

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
                                
                                <a  href="/portal/customer/'.$row_customer->id .'" style="text-decoration: none;"> '.$row_customer->customer_id .' ' .':'.' ' .$row_customer->customer_name.' </a>
                            
                            </div>
                        </div> 
                        
                        ';
                    }
                    
                }
                
            
        }
        
    }

    public function fixedDate(Request $request) {

            $fixed = $request->fixed_id;

            // dd($fixed);
            
        /*     $date = Carbon::parse(now());
            $datePast_7 = $date->subDays(7);
            $datePast_5 = $date->subDays(5); */
            $datePast_7 = Carbon::now()->subDays(7);
            $datePast_6 = Carbon::now()->subDays(6);
            $datePast_5 = Carbon::now()->subDays(5);
            $datePast_4 = Carbon::now()->subDays(4);
            $datePast_3 = Carbon::now()->subDays(3);

            //เช็ควันเริ่ม;
            $from_7 = ($datePast_7->toDateString()); 
            $from_6 = ($datePast_6->toDateString()); 
            $from_5 = ($datePast_5->toDateString()); 
            $from_4 = ($datePast_4->toDateString()); 
            $from_3 = ($datePast_3->toDateString()); 

            //วันปัจจุบัน;
            $to = date('Y-m-d');

            $page = $request->page;
            if ($page) {
                $page = $request->page;
            } else {
                $page = 1;
            }

            $id = $request->user()->admin_area;
            $code = $request->user()->user_code;

            //notin code;
            $code_notin = ['0000', '4494', '7787', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];
            if (empty($code_notin)) {
                $code_notin = [0]; // ใส่ค่า default ที่ไม่มีผล
            }
            
            // $count_page = Customer::where('admin_area', $id)
            //                         ->whereNotIn('customer_id', $code_notin)
            //                         ->count();

                        
            $user_name = User::select('name', 'admin_area','user_code', 'rights_area')->where('user_code', $code)->first();
            $pur_report = User::select('purchase_status')->where('user_code', $code)->first();

            $status_all = DB::table('customers')->select('status')
                            ->where('admin_area', $id)
                            ->whereNotIn('customer_status', ['inactive'])
                            // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                            ->whereNotIn('customer_id', $code_notin)
                            ->count();

            $status_waiting =  DB::table('customers')->where('admin_area', $id)
                                ->where('status', 'รอดำเนินการ')
                                ->whereNotIn('customer_status', ['inactive'])
                                // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                ->whereNotIn('customer_id', $code_notin)
                                ->count();
                                // dd($count_waiting);

            $status_action =  DB::table('customers')->where('admin_area', $id)
                                ->where('status', 'ต้องดำเนินการ')
                                ->whereNotIn('customer_status', ['inactive'])
                                // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                ->whereNotIn('customer_id', $code_notin)
                                ->count();

            $status_completed =  DB::table('customers')->where('admin_area', $id)
                                    ->where('status', 'ดำเนินการแล้ว')
                                    ->whereNotIn('customer_status', ['inactive'])
                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();

            $status_alert = $status_waiting + $status_action;


            if($fixed == 'morethan')
            {
                $count_page =  DB::table('customers')
                                    ->select(
                                        'customers.customer_id',
                                        'customers.customer_name',
                                        DB::raw('MAX(report_sellers.date_purchase) as last_purchase_date')
                                    )
                                    ->join('report_sellers', 'customers.customer_id', '=', 'report_sellers.customer_id')
                                    ->where('customers.admin_area', $id)
                                    ->groupBy('customers.customer_id', 'customers.customer_name')
                                    ->having('last_purchase_date', '<=', $from_7)
                                    ->count(); 

                $perpage = 10;
                $total_page = ceil($count_page / $perpage);
                // dd($total_page);
                $start = ($perpage * $page) - $perpage;
    
                $customer_list =  DB::table('customers')->select(
                                                'customers.id',
                                                'customers.customer_id',
                                                'customers.customer_name',
                                                'customers.status',
                                                'customers.admin_area',
                                                'customers.sale_area',
                                                'customers.email',
                                                'customers.customer_status',
                                                'customers.created_at',
                                                DB::raw('MAX(report_sellers.date_purchase) as last_purchase_date')
                                            )
                                            ->join('report_sellers', 'customers.customer_id', '=', 'report_sellers.customer_id')
                                            ->where('customers.admin_area', $id)
                                            ->groupBy(
                                                'customers.id',
                                                'customers.customer_id',
                                                'customers.customer_name',
                                                'customers.status',
                                                'customers.admin_area',
                                                'customers.sale_area',
                                                'customers.email',
                                                'customers.customer_status',
                                            )
                                            ->having('last_purchase_date', '<=', $from_7)
                                            ->orderBydesc('last_purchase_date')
                                            ->offset($start)
                                            ->limit($perpage)
                                            ->get();

                                                // dd($customer_list);
                                            
                        /*         
                            SELECT 
                            customers.customer_id,
                            MAX(report_sellers.date_purchase) as last_purchase
                            FROM report_sellers
                            INNER JOIN customers ON customers.customer_id = report_sellers.customer_id
                            WHERE customers.admin_area = 'A10'
                            GROUP BY customers.customer_id
                            HAVING last_purchase <= '2025-06-15'; */

                                            
                        $check_id = DB::table('report_sellers')->whereNotIn('customer_id', $code_notin)
                                        ->select('customer_id')
                                        ->distinct()
                                        ->get(); 
            
                        $check_purchase = DB::table('report_sellers')->whereNotIn('customer_id', $code_notin)
                                            ->select('customer_id')
                                            ->selectRaw('MAX(date_purchase) as date_purchase')
                                            ->groupBy('customer_id')
                                            ->orderByDesc('date_purchase')
                                            ->get(); 
            

                        return view('portal/customer-checkpur', compact(
                                                                        'user_name', 
                                                                        'status_alert', 
                                                                        'status_all', 
                                                                        'status_waiting', 
                                                                        'status_action', 
                                                                        'status_completed', 
                                                                        'total_page', 
                                                                        'page',
                                                                        'start',
                                                                        'customer_list',
                                                                        'check_id',
                                                                        'check_purchase',
                                                                        'pur_report'
                                                                    ));
            } elseif($fixed == 'coming') {

                        $count_page = DB::table('customers')->select(
                                                        'customers.customer_id',
                                                        'customers.customer_name',
                                                        DB::raw('MAX(report_sellers.date_purchase) as last_purchase_date')
                                                    )
                                                    ->join('report_sellers', 'customers.customer_id', '=', 'report_sellers.customer_id')
                                                    ->where('customers.admin_area', $id)
                                                    ->groupBy('customers.customer_id', 'customers.customer_name')
                                                    // ->havingBetween('last_purchase_date', $from_5)
                                                    ->havingRaw('last_purchase_date BETWEEN ? AND ?', [$from_6, $from_5])
                                                    ->count(); 
                                                    // dd($count_page);

                        $perpage = 10;
                        $total_page = ceil($count_page / $perpage);
                        // dd($total_page);
                        $start = ($perpage * $page) - $perpage;

                        $customer_list = DB::table('customers')->select(
                                                        'customers.id',
                                                        'customers.customer_id',
                                                        'customers.customer_name',
                                                        'customers.status',
                                                        'customers.admin_area',
                                                        'customers.sale_area',
                                                        'customers.email',
                                                        'customers.customer_status',
                                                        'customers.created_at',
                                                        DB::raw('MAX(report_sellers.date_purchase) as last_purchase_date')
                                                    )
                                                    ->join('report_sellers', 'customers.customer_id', '=', 'report_sellers.customer_id')
                                                    ->where('customers.admin_area', $id)
                                                    ->groupBy(
                                                        'customers.id',
                                                        'customers.customer_id',
                                                        'customers.customer_name',
                                                        'customers.status',
                                                        'customers.admin_area',
                                                        'customers.sale_area',
                                                        'customers.email',
                                                        'customers.customer_status',
                                                        'customers.created_at'
                                                    )
                                                    // ->having('last_purchase_date', '<=', $from_5)
                                                    // ->havingBetween('last_purchase_date', [$from_7, $from_5]) 
                                                    ->havingRaw('last_purchase_date BETWEEN ? AND ?', [$from_6, $from_5])

                                                    ->orderBydesc('last_purchase_date')
                                                    ->offset($start)
                                                    ->limit($perpage) 
                                                    // ->get();
                                                    ->get();
                                                    // dd($customer_list);


                                            // dd($customer_list);
                                        
                                      /*       SELECT 
                                            customers.customer_id,
                                            MAX(report_sellers.date_purchase) as last_purchase
                                        FROM report_sellers
                                        INNER JOIN customers 
                                            ON customers.customer_id = report_sellers.customer_id
                                        WHERE customers.admin_area = 'A10'
                                        GROUP BY customers.customer_id
                                        HAVING last_purchase BETWEEN '2025-06-20' AND '2025-06-22'; */

                                        
                        $check_id = DB::table('report_sellers')->whereNotIn('customer_id', $code_notin)
                                            ->select('customer_id')
                                            ->distinct()
                                            ->get(); 

                        $check_purchase = DB::table('report_sellers')->whereNotIn('customer_id', $code_notin)
                                                    ->select('customer_id')
                                                    ->selectRaw('MAX(date_purchase) as date_purchase')
                                                    ->groupBy('customer_id')
                                                    ->orderByDesc('date_purchase')
                                                    ->get(); 


                        return view('portal/customer-checkpur-coming', compact(
                                                                    'user_name', 
                                                                    'status_alert', 
                                                                    'status_all', 
                                                                    'status_waiting', 
                                                                    'status_action', 
                                                                    'status_completed', 
                                                                    'total_page', 
                                                                    'page',
                                                                    'start',
                                                                    'customer_list',
                                                                    'check_id',
                                                                    'check_purchase',
                                                                    'pur_report'
                                                                ));
            
            } elseif ($fixed == 'normal') {

                        $count_page = DB::table('customers')->select(
                                                        'customers.customer_id',
                                                        'customers.customer_name',
                                                        DB::raw('MAX(report_sellers.date_purchase) as last_purchase_date')
                                                    )
                                                    ->join('report_sellers', 'customers.customer_id', '=', 'report_sellers.customer_id')
                                                    ->where('customers.admin_area', $id)
                                                    ->groupBy('customers.customer_id', 'customers.customer_name')
                                                    // ->havingBetween('last_purchase_date', $from_5)
                                                    ->havingRaw('last_purchase_date BETWEEN ? AND ?', [$from_4, $from_3])
                                                    ->count(); 
                                                    // dd($count_page);

                        $perpage = 10;
                        $total_page = ceil($count_page / $perpage);
                        // dd($total_page);
                        $start = ($perpage * $page) - $perpage;

                        $customer_list = DB::table('customers')->select(
                                                                        'customers.id',
                                                                        'customers.customer_id',
                                                                        'customers.customer_name',
                                                                        'customers.status',
                                                                        'customers.admin_area',
                                                                        'customers.sale_area',
                                                                        'customers.email',
                                                                        'customers.customer_status',
                                                                        'customers.created_at',
                                                                        DB::raw('MAX(report_sellers.date_purchase) as last_purchase_date')
                                                                    )
                                                    ->join('report_sellers', 'customers.customer_id', '=', 'report_sellers.customer_id')
                                                    ->where('customers.admin_area', $id)
                                                    ->groupBy(
                                                                'customers.id',
                                                                'customers.customer_id',
                                                                'customers.customer_name',
                                                                'customers.status',
                                                                'customers.admin_area',
                                                                'customers.sale_area',
                                                                'customers.email',
                                                                'customers.customer_status',
                                                                'customers.created_at'
                                                            )
                                                    // ->having('last_purchase_date', '<=', $from_5)
                                                    // ->havingBetween('last_purchase_date', [$from_7, $from_5]) 
                                                    ->havingRaw('last_purchase_date BETWEEN ? AND ?', [$from_4, $from_3])

                                                    ->orderBydesc('last_purchase_date')
                                                    ->offset($start)
                                                    ->limit($perpage) 
                                                    // ->get();
                                                    ->get();
                                                    // dd($customer_list);


                                                // dd($customer_list);
                                            
                                        /*       SELECT 
                                                customers.customer_id,
                                                MAX(report_sellers.date_purchase) as last_purchase
                                            FROM report_sellers
                                            INNER JOIN customers 
                                                ON customers.customer_id = report_sellers.customer_id
                                            WHERE customers.admin_area = 'A10'
                                            GROUP BY customers.customer_id
                                            HAVING last_purchase BETWEEN '2025-06-20' AND '2025-06-22'; */

                                            
                        $check_id = DB::table('report_sellers')->whereNotIn('customer_id', $code_notin)
                                                    ->select('customer_id')
                                                    ->distinct()
                                                    ->get(); 

                        $check_purchase = DB::table('report_sellers')->whereNotIn('customer_id', $code_notin)
                                                        ->select('customer_id')
                                                        ->selectRaw('MAX(date_purchase) as date_purchase')
                                                        ->groupBy('customer_id')
                                                        ->orderByDesc('date_purchase')
                                                        ->get(); 


                        return view('portal/customer-checkpur-normal', compact(
                                                        'user_name', 
                                                        'status_alert', 
                                                        'status_all', 
                                                        'status_waiting', 
                                                        'status_action', 
                                                        'status_completed', 
                                                        'total_page', 
                                                        'page',
                                                        'start',
                                                        'customer_list',
                                                        'check_id',
                                                        'check_purchase',
                                                        'pur_report'
                                                    ));
            } else {

                        $count_page = DB::table('customers')->leftJoin('report_sellers', 'customers.customer_id', '=', 'report_sellers.customer_id')
                                                ->select('customers.customer_id', DB::raw('COUNT(report_sellers.purchase_order) as count_po'))
                                                ->where('customers.admin_area', $id)
                                                ->groupBy('customers.customer_id')
                                                ->havingRaw('count_po < 1')
                                                ->get()
                                                ->count();

                        $perpage = 10;
                        $total_page = ceil($count_page / $perpage);
                        // dd($total_page);
                        $start = ($perpage * $page) - $perpage;

                        $customer_list = DB::table('customers')->select(
                                                            'customers.id',
                                                            'customers.customer_id',
                                                            'customers.customer_name',
                                                            'customers.status',
                                                            'customers.admin_area',
                                                            'customers.sale_area',
                                                            'customers.email',
                                                            'customers.customer_status',
                                                            'customers.created_at',
                                                            DB::raw('COUNT(report_sellers.purchase_order) as count_po')
                                                        )
                                                        ->leftjoin('report_sellers', 'customers.customer_id', '=', 'report_sellers.customer_id')
                                                        ->where('customers.admin_area', $id)
                                                        ->groupBy(
                                                            'customers.id',
                                                            'customers.customer_id',
                                                            'customers.customer_name',
                                                            'customers.status',
                                                            'customers.admin_area',
                                                            'customers.sale_area',
                                                            'customers.email',
                                                            'customers.customer_status',
                                                            'customers.created_at'
                                                        )
                                                        ->havingRaw('count_po < 1')
                                                        ->orderBydesc('customers.customer_id')
                                                        ->offset($start)
                                                        ->limit($perpage) 
                                                        // ->get();
                                                        ->get();
                                                        // dd($customer_list);


                                    // dd($customer_list);
                                
                            /*       SELECT 
                                    customers.customer_id,
                                    MAX(report_sellers.date_purchase) as last_purchase
                                FROM report_sellers
                                INNER JOIN customers 
                                    ON customers.customer_id = report_sellers.customer_id
                                WHERE customers.admin_area = 'A10'
                                GROUP BY customers.customer_id
                                HAVING last_purchase BETWEEN '2025-06-20' AND '2025-06-22'; */

                                
                            $check_id = DB::table('report_sellers')->whereNotIn('customer_id', $code_notin)
                                                    ->select('customer_id')
                                                    ->distinct()
                                                    ->get(); 

                            $check_purchase = DB::table('report_sellers')->whereNotIn('customer_id', $code_notin)
                                            ->select('customer_id')
                                            ->selectRaw('MAX(date_purchase) as date_purchase')
                                            ->groupBy('customer_id')
                                            ->orderByDesc('date_purchase')
                                            ->get(); 


                            return view('portal/customer-checkpur-nopurchase', compact(
                                                                                        'user_name', 
                                                                                        'status_alert', 
                                                                                        'status_all', 
                                                                                        'status_waiting', 
                                                                                        'status_action', 
                                                                                        'status_completed', 
                                                                                        'total_page', 
                                                                                        'page',
                                                                                        'start',
                                                                                        'customer_list',
                                                                                        'check_id',
                                                                                        'check_purchase',
                                                                                        'pur_report'
                                                                                    ));
            }

        

    }

    public function purchaseOrder(Request $request)
    {
        
        $use_id = $request->use_id;
        $code_notin = ['0000', '4494', '7787', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];

        if ($use_id) {

            /* $check_id = ReportSeller::whereNotIn('customer_id', $code_notin)
                                    ->select('customer_id', 'customer_name')
                                    ->where('customer_id', $use_id)
                                    ->distinct()
                                    ->get(); */

                                          // 1. หา date_purchase ล่าสุดของแต่ละ customer
                $latest_po = DB::table('report_sellers')->select('customer_id', DB::raw('MAX(date_purchase) as latest_date'))
                                            ->whereNotIn('customer_id', $code_notin)
                                            ->where('customer_id', $use_id)
                                            ->groupBy('customer_id');

                // 2. Join กับข้อมูลสินค้าใน PO ล่าสุด
                $report_seller = DB::table('report_sellers')->joinSub($latest_po, 'latest', function ($join) {
                                                $join->on('report_sellers.customer_id', '=', 'latest.customer_id')
                                                    ->on('report_sellers.date_purchase', '=', 'latest.latest_date');
                                                })
                                                ->select(
                                                    'report_sellers.date_purchase',
                                                    'report_sellers.customer_id',
                                                    'report_sellers.purchase_order',
                                                    'report_sellers.product_id',
                                                    'report_sellers.product_name',
                                                    'report_sellers.unit',
                                                    'report_sellers.quantity',
                                                    DB::raw('(report_sellers.price*report_sellers.quantity) as total_sale')
                                                )
                                                ->orderBy('report_sellers.customer_id')
                                                ->get();

            return response()->json([
                'status'  => 'success',
                'use_id'  =>  $report_seller->toArray(),
                'message' => 'รับค่าเรียบร้อย'
            ]);
        }

        return response()->json([
            'status'  => 'error',
            'message' => 'ไม่พบข้อมูล'
        ], 400);
    }

    //แบบอนุญาตขายยา;
    public function protalIndexType(Request $request)
    {
         //notin code;
         $code_notin = ['0000', '4494', '7787', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];

         $id = $request->user()->admin_area;
         $code = $request->user()->user_code;
 
         $user_name = User::select('name', 'admin_area','user_code', 'rights_area')->where('user_code', $code)->first();
         $status_all = DB::table('customers')->select('status')
                                 ->where('admin_area', $id)
                                 ->whereNotIn('customer_status', ['inactive'])
                                 // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                 ->whereNotIn('customer_id', $code_notin)
                                 ->count();
 
         $status_waiting = DB::table('customers')->where('admin_area', $id)
                                     ->where('status', 'รอดำเนินการ')
                                     ->whereNotIn('customer_status', ['inactive'])
                                     // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                     ->whereNotIn('customer_id', $code_notin)
                                     ->count();
                                     // dd($count_waiting);
         $status_action = DB::table('customers')->where('admin_area', $id)
                                     ->where('status', 'ต้องดำเนินการ')
                                     ->whereNotIn('customer_status', ['inactive'])
                                     // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                     ->whereNotIn('customer_id', $code_notin)
                                     ->count();
 
         $status_completed = DB::table('customers')->where('admin_area', $id)
                                     ->where('status', 'ดำเนินการแล้ว')
                                     ->whereNotIn('customer_status', ['inactive'])
                                     // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                     ->whereNotIn('customer_id', $code_notin)
                                     ->count();
 
         $status_alert = $status_waiting + $status_action;

        $check_rights_type = User::where('user_code', $code)->first()->allowed_check_type;

        $setting_rights_type = DB::table('settings')->where('setting_id', 'WS01')->first()->check_type;

        $user = Auth::user();
        $log_login_date = ProductType::where('user_id', $user->user_id)
                        ->latest('id')
                        ->first();
                    // กำหนดเวลาเข้าใช้งาน
        $setting_timer = Setting::where('setting_id', 'WS01')->first();
        $check_type_time = $setting_timer?->check_time_type ?? 300;

            // แปลง last_activity เป็น timestamp (ถ้าเก็บ datetime)
            $lastActiveTimestamp = strtotime($log_login_date->last_activity);
        

        // เช็คว่าเกิน 300 วินาทีหรือไม่
        if ((time() - $lastActiveTimestamp) > $check_type_time) {
            $check_timer = 1;
            
        } else {
            $check_timer = 0;
        }
        
         return view('portal/portal-product-type', compact(
                                                 'user_name', 
                                                 'status_all', 
                                                 'status_waiting', 
                                                 'status_action', 
                                                 'status_completed', 
                                                 'status_alert',
                                                 'check_rights_type',
                                                 'setting_rights_type',
                                                 'check_timer',
                                             ));
     
    }

    public function protalTypeKhoryor(Request $request)
    {
        $from = $request->from ?? date('Y-m-d');
        $to   = $request->to ?? date('Y-m-d');
        $generic = $request->generic ?: 'ไม่ระบุ'; 
        $product = $request->product ?: 'ไม่ระบุ'; 
        
        $keyword = $request->keyword;
        //notin code;
        $code_notin = ['0000', '4494', '7787', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];

        $id = $request->user()->admin_area;
        $code = $request->user()->user_code;

        $user_name = User::select('name', 'admin_area','user_code', 'rights_area')->where('user_code', $code)->first();
        $status_all = DB::table('customers')->select('status')
                                ->where('admin_area', $id)
                                ->whereNotIn('customer_status', ['inactive'])
                                // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                ->whereNotIn('customer_id', $code_notin)
                                ->count();

        $status_waiting = DB::table('customers')->where('admin_area', $id)
                                    ->where('status', 'รอดำเนินการ')
                                    ->whereNotIn('customer_status', ['inactive'])
                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();
                                    // dd($count_waiting);
        $status_action = DB::table('customers')->where('admin_area', $id)
                                    ->where('status', 'ต้องดำเนินการ')
                                    ->whereNotIn('customer_status', ['inactive'])
                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();

        $status_completed = DB::table('customers')->where('admin_area', $id)
                                    ->where('status', 'ดำเนินการแล้ว')
                                    ->whereNotIn('customer_status', ['inactive'])
                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();

        $status_alert = $status_waiting + $status_action;


        $category = Category::orderBy('categories_id', 'ASC')->get();

        $cate_id = $request->cate_id;
        // dd($cate_id);

                    $results = collect();

                    if (isset($cate_id)) {
                       /*  $products = DB::table('products as p')
                            ->select('product_id', 'product_name', 'generic_name', 'khor_yor_2')
                            ->where('khor_yor_2', 1)
                            ->where('category', $cate_id)
                            ->orderBy('product_id', 'ASC')
                            ->get(); */

                            DB::table('products as p')
                                ->select('product_id', 'product_name', 'generic_name', 'khor_yor_2')
                                ->where('khor_yor_2', 1)
                                ->where('category', $cate_id)
                                ->orderBy('product_id', 'ASC')
                                ->chunk(1000, function ($products) use (&$results) {

                                        // รวมข้อมูลแต่ละ chunk เข้า collection หลัก
                                        $results = $results->merge($products);
                                });
                              


                    } else {

                        
                    
                            DB::table('products as p')
                                ->where('khor_yor_2', 1)
                                ->select('product_id', 'product_name', 'generic_name', 'khor_yor_2')
                                ->when($keyword, function ($query) use ($keyword) {
                                    $query->where(function ($q) use ($keyword) {
                                        $q->where('product_id', 'like', "%{$keyword}%")
                                        ->orWhere('product_name', 'like', "%{$keyword}%");
                                    });
                                })
                                ->orderBy('product_id', 'ASC')
                                ->chunk(1000, function ($products) use (&$results) {

                                        // รวมข้อมูลแต่ละ chunk เข้า collection หลัก
                                        $results = $results->merge($products);
                                });

                                // Pagination
                                $row_perPage = 50;
                                $row_page = request()->get('page', 1);
                                $total = $results->count();
                                $row_total_page = ceil($total / $row_perPage);
                                $row_start = $start = ($row_page - 1) * $row_perPage + 1;

                                // ดึงข้อมูลเฉพาะหน้าที่ต้องการ
                                $results = $results->slice(($row_page - 1) * $row_perPage, $row_perPage)->values();

              
                    }

                    $perPage = isset($cate_id) ? '' : $row_perPage;
                    $page = isset($cate_id) ? '' : $row_page;
                    $total_page = isset($cate_id) ? 1 : $row_total_page;
                    $start = isset($cate_id) ? 1 : $row_start;
                    
                    return view('portal/portal-product-khoryor', compact(
                                'user_name', 
                                'status_all', 
                                'status_waiting', 
                                'status_action', 
                                'status_completed', 
                                'status_alert',
                                'category',
                                'total_page',
                                'page',
                                'start'
                            ), ['khor_yor_2' => $results]);
                
    }

    public function protalTypeSomphor(Request $request)
    {
        $from = $request->from ?? date('Y-m-d');
        $to   = $request->to ?? date('Y-m-d');
        $generic = $request->generic ?: 'ไม่ระบุ'; 
        $product = $request->product ?: 'ไม่ระบุ'; 
        
        $keyword = $request->keyword;
        //notin code;
        $code_notin = ['0000', '4494', '7787', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];

        $id = $request->user()->admin_area;
        $code = $request->user()->user_code;

        $user_name = User::select('name', 'admin_area','user_code', 'rights_area')->where('user_code', $code)->first();
        $status_all = DB::table('customers')->select('status')
                                ->where('admin_area', $id)
                                ->whereNotIn('customer_status', ['inactive'])
                                // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                ->whereNotIn('customer_id', $code_notin)
                                ->count();

        $status_waiting = DB::table('customers')->where('admin_area', $id)
                                    ->where('status', 'รอดำเนินการ')
                                    ->whereNotIn('customer_status', ['inactive'])
                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();
                                    // dd($count_waiting);
        $status_action = DB::table('customers')->where('admin_area', $id)
                                    ->where('status', 'ต้องดำเนินการ')
                                    ->whereNotIn('customer_status', ['inactive'])
                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();

        $status_completed = DB::table('customers')->where('admin_area', $id)
                                    ->where('status', 'ดำเนินการแล้ว')
                                    ->whereNotIn('customer_status', ['inactive'])
                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();

        $status_alert = $status_waiting + $status_action;


        $category = Category::orderBy('categories_id', 'ASC')->get();

        $cate_id = $request->cate_id;
        // dd($cate_id);

                    $results = collect();

                    if (isset($cate_id)) {

                            DB::table('products as p')
                                ->select(
                                        'product_id', 
                                        'product_name', 
                                        'generic_name', 
                                        'som_phor_2'
                                        )
                                ->where('som_phor_2', 1)
                                ->where('category', $cate_id)
                                ->orderBy('product_id', 'ASC')
                                ->chunk(1000, function ($products) use (&$results) {

                                        // รวมข้อมูลแต่ละ chunk เข้า collection หลัก
                                        $results = $results->merge($products);
                                });
                              


                    } else {
                        
                    
                            DB::table('products as p')
                                ->where('som_phor_2', 1)
                                ->select(
                                        'product_id', 
                                        'product_name', 
                                        'generic_name', 
                                        'som_phor_2'
                                        )
                                ->when($keyword, function ($query) use ($keyword) {
                                    $query->where(function ($q) use ($keyword) {
                                        $q->where('product_id', 'like', "%{$keyword}%")
                                        ->orWhere('product_name', 'like', "%{$keyword}%");
                                    });
                                })
                                ->orderBy('product_id', 'ASC')
                                ->chunk(1000, function ($products) use (&$results) {

                                        // รวมข้อมูลแต่ละ chunk เข้า collection หลัก
                                        $results = $results->merge($products);
                                });

                                // Pagination
                                $row_perPage = 50;
                                $row_page = request()->get('page', 1);
                                $total = $results->count();
                                $row_total_page = ceil($total / $row_perPage);
                                $row_start = $start = ($row_page - 1) * $row_perPage + 1;

                                // ดึงข้อมูลเฉพาะหน้าที่ต้องการ
                                $results = $results->slice(($row_page - 1) * $row_perPage, $row_perPage)->values();
                       
              
                    }

                    $perPage = isset($cate_id) ? '' : $row_perPage;
                    $page = isset($cate_id) ? '' : $row_page;
                    $total_page = isset($cate_id) ? 1 : $row_total_page;
                    $start = isset($cate_id) ? 1 : $row_start;
                    
                    return view('portal/portal-product-somphor', compact(
                                'user_name', 
                                'status_all', 
                                'status_waiting', 
                                'status_action', 
                                'status_completed', 
                                'status_alert',
                                'category',
                                'total_page',
                                'page',
                                'start'
                            ), ['somphor_2' => $results]);
        
    }

}
