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
use App\Exports\CustomerAreaExport;
use App\Models\ReportSeller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Illuminate\Database\Query\JoinClause;


class WebpanelCustomerController
{
    
    public function index(Request $request): View
    {
        // dd(strtotime('2025-04-21'));
        $page = $request->page;
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

        //notin code;
        $code_notin = ['0000', '4494', '7787', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];

        $check_id = ReportSeller::whereNotIn('customer_id', $code_notin)
                                    ->select('customer_id')
                                    ->distinct()
                                    ->get(); 

        $check_purchase = ReportSeller::select('customer_id')
                                        ->selectRaw('MAX(date_purchase) as date_purchase')
                                        ->whereNotIn('customer_id', $code_notin)
                                        ->groupBy('customer_id')
                                        ->orderByDesc('date_purchase')
                                        ->get();

        // $total_customer = Customer::whereNotIn('customer_code', $code_notin)->count();
        // $total_status_registration = Customer::where('status', 'ลงทะเบียนใหม่')->whereNotIn('customer_code', $code_notin)->count();
        // $total_status_waiting = Customer::where('status', 'รอดำเนินการ')->whereNotIn('customer_code', $code_notin)->count();
        // $total_status_action = Customer::where('status', 'ต้องดำเนินการ')->whereNotIn('customer_code', $code_notin)->count();
        // $total_status_completed = Customer::where('status', 'ดำเนินการแล้ว')->whereNotIn('customer_code', $code_notin)->count();
        // $total_status_updated = Customer::where('status_update', 'updated')->whereNotIn('customer_code', $code_notin)->count();
        // $customer_status_inactive = Customer::where('customer_status', 'inactive')->whereNotIn('customer_code', $code_notin)->count();

        //Raw query เพิ่ม performance;
        $total_customer             = DB::table('customers')->whereNotIn('customer_code', $code_notin)->count();
        $total_status_registration  = DB::table('customers')->where('status', 'ลงทะเบียนใหม่')->whereNotIn('customer_code', $code_notin)->count();
        $total_status_waiting       = DB::table('customers')->where('status', 'รอดำเนินการ')->whereNotIn('customer_code', $code_notin)->count();
        $total_status_action        = DB::table('customers')->where('status', 'ต้องดำเนินการ')->whereNotIn('customer_code', $code_notin)->count();
        $total_status_completed     = DB::table('customers')->where('status', 'ดำเนินการแล้ว')->whereNotIn('customer_code', $code_notin)->count();
        $total_status_updated       = DB::table('customers')->where('status_update', 'updated')->whereNotIn('customer_code', $code_notin)->count();
        $customer_status_inactive   = DB::table('customers')->where('customer_status', 'inactive')->whereNotIn('customer_code', $code_notin)->count();

        $user_id_admin = $request->user()->user_id;
        //เพิ่มลูกค้า;
        // $admin_area_list = User::select('admin_area', 'name', 'rights_area', 'user_code')->get();

        $status_registration = DB::table('customers')->where('status', 'ลงทะเบียนใหม่')
                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();

        $status_waiting = DB::table('customers')->where('status', 'รอดำเนินการ')
                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();

        $status_updated = DB::table('customers')->where('status_update', 'updated')
                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();

        $status_alert = $status_waiting + $status_updated;

        //dropdown admin_area;
        $admin_area =  User::where('admin_area', '!=', '')->where('rights_area', '!=', '')->get();
        ////////////////////////////////////////////////////////

        $keyword_search = $request->keyword;
        // dd($keyword);

        if($keyword_search != '') {

            $count_page = Customer::whereNotIn('customer_id', $code_notin)
                                    ->where('customer_id', 'Like', "%{$keyword_search}%")
                                    ->OrWhere('customer_name', 'Like', "%{$keyword_search}%")
                                    ->count();
            // dd($count_page);

            $perpage = 10;
            $total_page = ceil($count_page / $perpage);

            // dd($total_page);
            $start = ($perpage * $page) - $perpage;

            // $customer = Customer::whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
            $customer = DB::table('customers')->whereNotIn('customer_id', $code_notin)
                            ->where('customer_id', 'Like', "%{$keyword_search}%")
                            ->orWhere('customer_name', 'Like', "%{$keyword_search}%")
                            ->offset($start)
                            ->limit($perpage)
                            ->get();

            // $check_keyword = Customer::whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
            $check_keyword = DB::table('customers')->whereNotIn('customer_id', $code_notin)
                                ->where('customer_id', 'Like', "%{$keyword_search}%")
                                ->orWhere('customer_name', 'Like', "%{$keyword_search}%")
                                ->first();

          /*   $report_seller = ReportSeller::whereNotIn('customer_id', $code_notin)
                                        ->where(function ($query) use ($keyword_search) {
                                            $query->where('customer_id', 'like', "%{$keyword_search}%")
                                                ->orWhere('customer_name', 'like', "%{$keyword_search}%");
                                            })
                                        ->select('date_purchase', 'purchase_order', 'customer_id', 'product_id', 'product_name', 'unit', 'quantity')
                                        ->groupBy('customer_id', 'purchase_order', 'date_purchase', 'product_id', 'product_name', 'unit', 'quantity')
                                        ->orderByDesc('date_purchase')
                                        ->get(); */

                // 1. หา date_purchase ล่าสุดของแต่ละ customer
                $latest_po = DB::table('report_sellers')->select('customer_id', DB::raw('MAX(date_purchase) as latest_date'))
                                ->whereNotIn('customer_id', $code_notin)
                                ->when($keyword_search, function ($query) use ($keyword_search) {
                                    $query->where(function ($q) use ($keyword_search) {
                                        $q->where('customer_id', 'like', "%{$keyword_search}%")
                                        ->orWhere('customer_name', 'like', "%{$keyword_search}%");
                                    });
                                })
                                ->groupBy('customer_id');

                // 2. Join กับข้อมูลสินค้าใน PO ล่าสุด
   /*              $report_seller = ReportSeller::joinSub($latest_po, 'latest', function ($join) {
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

                $check_purchase = ReportSeller::whereNotIn('customer_id', $code_notin)
                                                ->where(function ($query) use ($keyword_search) {
                                                    $query->where('customer_id', 'like', "%{$keyword_search}%")
                                                        ->orWhere('customer_name', 'like', "%{$keyword_search}%");
                                                    })
                                                ->select('date_purchase', 'purchase_order', 'customer_id')
                                                ->groupBy('customer_id', 'purchase_order', 'date_purchase')
                                                ->orderByDesc('date_purchase')
                                                ->first(); */

            //เช็คว่า วันที่สั่ง + 7 วัน เปรียบเทียบกับเวลาปัจจุบันว่า เกิน 7 วันไหม เช่น สั่งวันที่ 21-04-68 แต่วันนี้ 26-06-68 เกิน 7 วัน == true;
         /*    $check_over_5 = Carbon::parse($check_purchase?->date_purchase)->addDays(5)->lessThan(now());
            $check_over_7 = Carbon::parse($check_purchase?->date_purchase)->addDays(7)->lessThan(now()); */
            // dd($check_over_7);

            // dd($check_purchase->date_purchase);

            // dd($check_search->admin_area);
            if (!empty($check_keyword)) {
                return view('webpanel/customer', compact(
                                                        'check_keyword', 
                                                        'admin_area', 
                                                        'customer', 
                                                        'start', 
                                                        'total_page', 
                                                        'page', 
                                                        'total_customer', 
                                                        'total_status_waiting', 
                                                        'total_status_registration',
                                                        'total_status_action', 
                                                        'total_status_completed', 
                                                        'total_status_updated', 
                                                        'customer_status_inactive', 
                                                        'status_alert', 
                                                        'status_waiting', 
                                                        'status_registration', 
                                                        'status_updated', 
                                                        'user_id_admin',
                                                       /*  'check_over_5',
                                                        'check_over_7',
                                                        'report_seller' */
                                                        'check_id',
                                                        'check_purchase'
                                                    ));
        
            }

                // return back();

        }
                                    
        //เช็คว่า วันที่สั่ง + 7 วัน เปรียบเทียบกับเวลาปัจจุบันว่า เกิน 7 วันไหม เช่น สั่งวันที่ 21-04-68 แต่วันนี้ 26-06-68 เกิน 7 วัน == true;


/*         $check_id = ReportSeller::whereNotIn('customer_id', $code_notin)
                                    ->select('customer_id')
                                    ->distinct()
                                    ->get(); 

        $check_purchase = ReportSeller::select('customer_id')
                                    ->selectRaw('MAX(date_purchase) as date_purchase')
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->groupBy('customer_id')
                                    ->orderByDesc('date_purchase')
                                    ->get();
                             */
    
/*         $diffDay_five = Carbon::parse($check_purchase?->date_purchase)->addDays(5)->lessThan(now());
        $diffDay_seven = Carbon::parse($check_purchase?->date_purchase)->addDays(7)->lessThan(now()); */
        // dd($check_purchase->customer_id);

        return view('webpanel/customer', compact(
                                                'admin_area', 
                                                'customer', 
                                                'start', 
                                                'total_page', 
                                                'page', 
                                                'total_customer', 
                                                'total_status_waiting', 
                                                'total_status_registration',
                                                'total_status_action', 
                                                'total_status_completed', 
                                                'total_status_updated', 
                                                'customer_status_inactive', 
                                                'status_alert', 
                                                'status_waiting', 
                                                'status_registration', 
                                                'status_updated', 
                                                'user_id_admin',
                                                'check_id',
                                                'check_purchase'
                                                /* 'diffDay_five',
                                                'diffDay_seven', */
                                            ));
        
    }

    public function purchase(Request $request)
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
                $latest_po = DB::table('report_sellers')
                                ->select('customer_id', DB::raw('MAX(date_purchase) as latest_date'))
                                ->whereNotIn('customer_id', $code_notin)
                                ->where('customer_id', $use_id)
                                ->groupBy('customer_id');

                // 2. Join กับข้อมูลสินค้าใน PO ล่าสุด
                $report_seller = DB::table('report_sellers')
                                    ->joinSub($latest_po, 'latest', function ($join) {
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

/*     public function purchase(Request $request)
{
    $use_id = $request->use_id;

    // ตัวอย่างข้อมูลจาก Database
    $data = [
        [
            'product_id' => 'P001',
            'product_name' => 'สินค้า A',
            'unit' => 'ชิ้น',
            'qty' => 10
        ],
        [
            'product_id' => 'P002',
            'product_name' => 'สินค้า B',
            'unit' => 'กล่อง',
            'qty' => 5
        ]
    ];

    return response()->json([
        'status' => 'success',
        'use_id' => $use_id,
        'po_number' => 'PO123456',
        'items' => $data,
        'message' => 'ดึงข้อมูลสำเร็จ'
    ]);
} */



    public function indexAdminArea(Request $request, $admin_id)
    {

        // dd($request->status);
        // dd('index');
        $admin_area = User::where('admin_area', $admin_id)->first();

        $page = $request->page;
        if ($page) {
            $page = $request->page;
        } else {
            $page = 1;
        }

        //notin code;
        $code_notin = ['0000', '4494', '7787', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];

          //menu alert;
        $status_waiting = DB::table('customers')
                                ->where('status', 'รอดำเนินการ')
                                // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                ->whereNotIn('customer_id', $code_notin)
                                ->count();

        $status_registration = DB::table('customers')->where('status', 'ลงทะเบียนใหม่')
                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();

        $status_updated = DB::table('customers')
                                ->where('status_update', 'updated')
                                // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                ->whereNotIn('customer_id', $code_notin)
                                ->count();

        $status_alert = $status_waiting + $status_updated;

        $user_id_admin = $request->user()->user_id;

        //แสดงข้อมูลลูกค้า;
        $row_customer = Customer::viewCustomerAdminArea($page, $admin_id);
        $customer = $row_customer[0];
        $start = $row_customer[1];
        $total_page = $row_customer[2];
        $page = $row_customer[3];


        $check_id = DB::table('report_sellers')
                        ->whereNotIn('customer_id', $code_notin)
                        ->select('customer_id')
                        ->distinct()
                        ->get(); 

        $check_purchase = DB::table('report_sellers')
                            ->select('customer_id')
                            ->selectRaw('MAX(date_purchase) as date_purchase')
                            ->whereNotIn('customer_id', $code_notin)
                            ->groupBy('customer_id')
                            ->orderByDesc('date_purchase')
                            ->get();
                            

        // name;
        $admin_name = DB::table('users')->select('admin_area', 'name')->where('admin_area', $admin_id)->first();

        //Dashborad;
       /*  $total_customer_adminarea = Customer::whereNotIn('customer_code', ['0000','4494'])->where('admin_area', $admin_id)->count();
        $total_status_waiting = Customer::where('admin_area', $admin_id)->where('status', 'รอดำเนินการ')->whereNotIn('customer_code', ['0000','4494'])->count();
        $total_status_action = Customer::where('admin_area', $admin_id)->where('status', 'ต้องดำเนินการ')->whereNotIn('customer_code', ['0000','4494'])->count();
        $total_status_completed = Customer::where('admin_area', $admin_id)->where('status', 'ดำเนินการแล้ว')->whereNotIn('customer_code', ['0000','4494'])->count(); */

        $total_customer_adminarea   = DB::table('customers')->whereNotIn('customer_code', $code_notin)->where('admin_area', $admin_id)->count();
        $total_status_waiting       = DB::table('customers')->where('admin_area', $admin_id)->where('status', 'รอดำเนินการ')->whereNotIn('customer_code', $code_notin)->count();
        $total_status_action        = DB::table('customers')->where('admin_area', $admin_id)->where('status', 'ต้องดำเนินการ')->whereNotIn('customer_code', $code_notin)->count();
        $total_status_completed     = DB::table('customers')->where('admin_area', $admin_id)->where('status', 'ดำเนินการแล้ว')->whereNotIn('customer_code', $code_notin)->count();
        $total_status_registration  = DB::table('customers')->where('admin_area', $admin_id)->where('status', 'ลงทะเบียนใหม่')->whereNotIn('customer_code', $code_notin)->count();

            //dropdown admin_area;
            $admin_area =  DB::table('users')->where('admin_area', '!=', '')->where('rights_area', '!=', '')->get();
            ////////////////////////////////////////////////////////
    
            $keyword_search = $request->keyword;
            // dd($keyword);

            // dd($request->status);
        switch ($request->status)
        {
            case 'status-waiting':

            $row_customer = Customer::viewCustomerAdminAreaWaiting($page, $admin_id);
            $customer = $row_customer[0];
            $start = $row_customer[1];
            $total_page = $row_customer[2];
            $page = $row_customer[3];

            if($keyword_search != '') {
        
                    $count_page = DB::table('customers')->where('status','รอดำเนินการ')
                                        ->where('admin_area', $admin_id)
                                        // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                        ->whereNotIn('customer_id', $code_notin)
                                        ->where('customer_id', 'Like', "%{$keyword_search}%")->count();
                    // dd(($count_page));
        
                    $perpage = 10;
                    $total_page = ceil($count_page / $perpage);
                    $start = ($perpage * $page) - $perpage;

                    $customer = DB::table('customers')->where('status','รอดำเนินการ')
                                    ->where('admin_area', $admin_id)
                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->where('customer_id', 'Like', "%{$keyword_search}%")
                                    // ->orWhere('customer_name', 'Like', "%{$keyword_search}%")
                                    ->offset($start)
                                    ->limit($perpage)
                                    ->get();
                    // dd($customer);
                    $check_keyword = DB::table('customers')->where('status','รอดำเนินการ')
                                        ->where('admin_area', $admin_id)
                                        // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                        ->whereNotIn('customer_id', $code_notin)
                                        ->where('customer_id', 'Like', "%{$keyword_search}%")
                                        // ->orWhere('customer_name', 'Like', "%{$keyword_search}%")
                                        ->get();
        
                                                // dd($check_keyword );
                    // dd($check_customer_code);
        
                    // dd($check_search->admin_area);
                    if (!empty($check_keyword)) {

                        return view('webpanel/adminarea-waiting',compact(
                                                                        'check_keyword',
                                                                        'count_page', 
                                                                        'admin_name', 
                                                                        'customer', 
                                                                        'start', 
                                                                        'total_page', 
                                                                        'page', 
                                                                        'total_customer_adminarea',
                                                                        'total_status_registration', 
                                                                        'total_status_waiting', 
                                                                        'total_status_action', 
                                                                        'total_status_completed',
                                                                        'status_waiting',
                                                                        'status_registration', 
                                                                        'status_updated', 
                                                                        'status_alert', 
                                                                        'user_id_admin',
                                                                        'check_id',
                                                                        'check_purchase'
                                                                    ));
                
                    }
        
                        return back();
        
            }
            $count_page = 1;
           
            return view('webpanel/adminarea-waiting' ,compact(
                                                            'admin_name',
                                                            'count_page', 
                                                            'customer', 
                                                            'start', 
                                                            'total_page', 
                                                            'page', 
                                                            'total_customer_adminarea',
                                                            'total_status_registration', 
                                                            'total_status_waiting', 
                                                            'total_status_action', 
                                                            'total_status_completed',
                                                            'status_waiting',
                                                            'status_registration', 
                                                            'status_updated', 
                                                            'status_alert',
                                                            'user_id_admin',
                                                            'check_id',
                                                            'check_purchase'
                                                        ));
            break;

            case 'status-action':

                $row_customer = Customer::viewCustomerAdminAreaAction($page, $admin_id);
                $customer = $row_customer[0];
                $start = $row_customer[1];
                $total_page = $row_customer[2];
                $page = $row_customer[3];
                $count_page_master = $row_customer[4];

                // dd($count_page_master);
                if($keyword_search != '') {

                        $count_page = DB::table('customers')->where('status','ต้องดำเนินการ')
                                        ->where('admin_area', $admin_id)
                                        // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                        ->whereNotIn('customer_id', $code_notin)
                                        ->where('customer_id', 'Like', "%{$keyword_search}%")->count();
            
                        $perpage = 10;
                        $total_page = ceil($count_page / $perpage);
                        $start = ($perpage * $page) - $perpage;
    
                        $customer = DB::table('customers')
                                        ->where('status','ต้องดำเนินการ')
                                        ->where('admin_area', $admin_id)
                                        // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                        ->whereNotIn('customer_id', $code_notin)
                                        ->where('customer_id', 'Like', "%{$keyword_search}%")
                                        // ->orWhere('customer_name', 'Like', "%{$keyword_search}%")
                                        ->offset($start)
                                        ->limit($perpage)
                                        ->get();
            
                        $check_keyword = DB::table('customers')->where('status','ต้องดำเนินการ')
                                            ->where('admin_area', $admin_id)
                                            // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                            ->whereNotIn('customer_id', $code_notin)
                                            ->where('customer_id', 'Like', "%{$keyword_search}%")
                                            // ->orWhere('customer_name', 'Like', "%{$keyword_search}%")
                                            ->get();
            
                        // dd($check_customer_code);
            
                        // dd($check_search->admin_area);
                        if (!empty($check_keyword)) {

                            return view('webpanel/adminarea-action',compact(
                                                                            'check_keyword',
                                                                            'count_page', 
                                                                            'admin_name', 
                                                                            'customer', 
                                                                            'start', 
                                                                            'total_page', 
                                                                            'page', 
                                                                            'total_customer_adminarea',
                                                                            'total_status_registration',  
                                                                            'total_status_waiting', 
                                                                            'total_status_action', 
                                                                            'total_status_completed',
                                                                            'status_waiting', 
                                                                            'status_registration',  
                                                                            'status_updated', 
                                                                            'status_alert', 
                                                                            'user_id_admin',
                                                                            'check_id',
                                                                            'check_purchase'
                                                                        ));
                    
                        }
            
                            return back();
            
                }
                $count_page = 1;
                return view('webpanel/adminarea-action' ,compact(
                                                                'count_page_master',
                                                                'count_page', 
                                                                'admin_name', 
                                                                'customer', 
                                                                'start', 
                                                                'total_page', 
                                                                'page', 
                                                                'total_customer_adminarea', 
                                                                'total_status_registration', 
                                                                'total_status_waiting', 
                                                                'total_status_action', 
                                                                'total_status_completed',
                                                                'status_waiting', 
                                                                'status_registration', 
                                                                'status_updated', 
                                                                'status_alert', 
                                                                'user_id_admin',
                                                                'check_id',
                                                                'check_purchase'
                                                            ));
                break;

                case 'status-completed':

                    $row_customer = Customer::viewCustomerAdminAreaCompleted($page, $admin_id);
                    $customer = $row_customer[0];
                    $start = $row_customer[1];
                    $total_page = $row_customer[2];
                    $page = $row_customer[3];
    
                    if($keyword_search != '') {
                
                            $count_page = DB::table('customers')
                                            ->where('status','ดำเนินการแล้ว')
                                            ->where('admin_area', $admin_id)
                                            // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                            ->whereNotIn('customer_id', $code_notin)
                                            ->where('customer_id', 'Like', "%{$keyword_search}%")->count();
                            // dd(gettype($count_page));
                
                            $perpage = 10;
                            $total_page = ceil($count_page / $perpage);
                            $start = ($perpage * $page) - $perpage;
        
                            $customer = DB::table('customers')
                                            ->where('status','ดำเนินการแล้ว')
                                            ->where('admin_area', $admin_id)
                                            // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                            ->whereNotIn('customer_id', $code_notin)
                                            ->where('customer_id', 'Like', "%{$keyword_search}%")
                                            // ->orWhere('customer_name', 'Like', "%{$keyword_search}%")
                                            ->offset($start)
                                            ->limit($perpage)
                                            ->get();
                
                            $check_keyword = DB::table('customers')
                                                ->where('status','ดำเนินการแล้ว')
                                                ->where('admin_area', $admin_id)
                                                // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                                ->whereNotIn('customer_id', $code_notin)
                                                ->where('customer_id', 'Like', "%{$keyword_search}%")
                                                // ->orWhere('customer_name', 'Like', "%{$keyword_search}%")
                                                ->get();
                
                            // dd($check_customer_code);
                
                            // dd($check_search->admin_area);
                            if (!empty($check_keyword)) {
                                return view('webpanel/adminarea-completed',compact(
                                                                                    'check_keyword',
                                                                                    'count_page', 
                                                                                    'admin_name', 
                                                                                    'customer', 
                                                                                    'start', 
                                                                                    'total_page', 
                                                                                    'page', 
                                                                                    'total_customer_adminarea',
                                                                                    'total_status_registration', 
                                                                                    'total_status_waiting', 
                                                                                    'total_status_action', 
                                                                                    'total_status_completed',
                                                                                    'status_waiting',
                                                                                    'status_registration', 
                                                                                    'status_updated', 
                                                                                    'status_alert',
                                                                                    'user_id_admin',
                                                                                    'check_id',
                                                                                    'check_purchase'
                                                                                ));
                        
                            }
                
                                return back();
                
                    }
                    $count_page = 1;
                    return view('webpanel/adminarea-completed' ,compact(
                                                                        'admin_name',
                                                                        'count_page', 
                                                                        'customer', 
                                                                        'start', 
                                                                        'total_page', 
                                                                        'page', 
                                                                        'total_customer_adminarea',
                                                                        'total_status_registration', 
                                                                        'total_status_waiting', 
                                                                        'total_status_action', 
                                                                        'total_status_completed',
                                                                        'status_waiting',
                                                                        'status_registration', 
                                                                        'status_updated', 
                                                                        'status_alert', 
                                                                        'user_id_admin',
                                                                        'check_id',
                                                                        'check_purchase'
                                                                    ));
                    break;

                    case 'new-registration':

                        // dd('registration');
                        $row_customer = Customer::viewCustomerAdminAreaRegistration($page, $admin_id);
                        $customer = $row_customer[0];
                        $start = $row_customer[1];
                        $total_page = $row_customer[2];
                        $page = $row_customer[3];
        
                        // dd($keyword_search);
                        if($keyword_search != '') {
                    
                                $count_page = DB::table('customers')
                                                ->where('status','ลงทะเบียนใหม่')
                                                ->where('admin_area', $admin_id)
                                                // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                                ->whereNotIn('customer_id', $code_notin)
                                                ->where('customer_id', 'Like', "%{$keyword_search}%")->count();
                                // dd(gettype($count_page));
                    
                                $perpage = 10;
                                $total_page = ceil($count_page / $perpage);
                                $start = ($perpage * $page) - $perpage;
            
                                $customer = DB::table('customers')
                                                ->where('status','ลงทะเบียนใหม่')
                                                ->where('admin_area', $admin_id)
                                                // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                                ->whereNotIn('customer_id', $code_notin)
                                                ->where('customer_id', 'Like', "%{$keyword_search}%")
                                                // ->orWhere('customer_name', 'Like', "%{$keyword_search}%")
                                                ->offset($start)
                                                ->limit($perpage)
                                                ->get();
                    
                                $check_keyword = DB::table('customers')
                                                    ->where('status','ลงทะเบียนใหม่')
                                                    ->where('admin_area', $admin_id)
                                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                                    ->whereNotIn('customer_id', $code_notin)
                                                    ->where('customer_id', 'Like', "%{$keyword_search}%")
                                                    // ->orWhere('customer_name', 'Like', "%{$keyword_search}%")
                                                    ->get();

                                // dd($check_customer_code);
                    
                                // dd($check_search->admin_area);
                                if (!empty($check_keyword)) {

                                    // dd('check');
                                    return view('webpanel/adminarea-registration',compact(
                                                                                            'check_keyword',
                                                                                            'count_page',
                                                                                            'admin_name', 
                                                                                            'customer', 
                                                                                            'start', 
                                                                                            'total_page', 
                                                                                            'page', 
                                                                                            'total_customer_adminarea',
                                                                                            'total_status_registration', 
                                                                                            'total_status_waiting', 
                                                                                            'total_status_action', 
                                                                                            'total_status_completed',
                                                                                            'total_status_registration',
                                                                                            'status_waiting',
                                                                                            'status_registration', 
                                                                                            'status_updated', 
                                                                                            'status_alert', 
                                                                                            'user_id_admin',
                                                                                            'check_id',
                                                                                            'check_purchase'
                                                                                        ));
                            
                                }
                    
                                    return back();
                    
                        }
                        // dd('check');
                        $count_page = DB::table('customers')->where('status','ลงทะเบียนใหม่')
                                            ->where('admin_area', $admin_id)
                                            // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                            ->whereNotIn('customer_id', $code_notin)
                                            ->count();
                        // dd(gettype($count_page));

                        $perpage = 10;
                        $total_page = ceil($count_page / $perpage);
                        $start = ($perpage * $page) - $perpage;

                        // $count_page = 1;
                        return view('webpanel/adminarea-registration' ,compact(
                                                                                'admin_name',
                                                                                'count_page', 
                                                                                'customer', 
                                                                                'start', 
                                                                                'total_page', 
                                                                                'page', 
                                                                                'total_customer_adminarea', 
                                                                                'total_status_registration', 
                                                                                'total_status_waiting', 
                                                                                'total_status_action', 
                                                                                'total_status_completed', 
                                                                                'total_status_registration', 
                                                                                'status_waiting',
                                                                                'status_registration', 
                                                                                'status_updated', 
                                                                                'status_alert', 
                                                                                'user_id_admin',
                                                                                'check_id',
                                                                                'check_purchase'
                                                                            ));
                        break;
                    

            //customer/adminarea;
            default:

                if($keyword_search != '') {
            
                        $count_page = DB::table('customers')->where('admin_area', $admin_id)->where('customer_id', 'Like', "%{$keyword_search}%")->count();
                        // dd(gettype($count_page));
            
                        $perpage = 10;
                        $total_page = ceil($count_page / $perpage);
                        $start = ($perpage * $page) - $perpage;
    
                        $customer = DB::table('customers')
                                        ->where('admin_area', $admin_id)
                                        // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                        ->whereNotIn('customer_id', $code_notin)
                                        ->where('customer_id', 'Like', "%{$keyword_search}%")
                                        // ->orWhere('customer_name', 'Like', "%{$keyword_search}%")
                                        ->offset($start)
                                        ->limit($perpage)
                                        ->get();
            
                        // $check_keyword = Customer::whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                        $check_keyword = DB::table('customers')
                                            ->whereNotIn('customer_id', $code_notin)
                                            ->where('customer_id', 'Like', "%{$keyword_search}%")
                                            // ->orWhere('customer_name', 'Like', "%{$keyword_search}%")
                                            ->get();
            
                        // dd($check_customer_code);
            
                        // dd($check_search->admin_area);
                        if (!empty($check_keyword)) {
         
                            return view('webpanel/adminarea-detail',compact(
                                                                            'check_keyword',
                                                                            'count_page', 
                                                                            'admin_name', 
                                                                            'customer', 
                                                                            'start', 
                                                                            'total_page', 
                                                                            'page', 
                                                                            'total_customer_adminarea', 
                                                                            'total_status_waiting', 
                                                                            'total_status_action', 
                                                                            'total_status_completed',
                                                                            'total_status_registration' ,
                                                                            'status_waiting',
                                                                            'status_registration', 
                                                                            'status_updated', 
                                                                            'status_alert', 
                                                                            'user_id_admin',
                                                                            'check_id',
                                                                            'check_purchase'
                                                                        ));
                    
                        }
            
                            return back();
            
                }
                $count_page = 1;

                return view('webpanel/adminarea-detail',compact(
                                                                'admin_name',
                                                                'count_page', 
                                                                'customer', 
                                                                'start', 
                                                                'total_page', 
                                                                'page', 
                                                                'total_customer_adminarea', 
                                                                'total_status_waiting', 
                                                                'total_status_action', 
                                                                'total_status_completed',
                                                                'total_status_registration' ,
                                                                'status_waiting',
                                                                'status_registration', 
                                                                'status_updated', 
                                                                'status_alert', 
                                                                'user_id_admin',
                                                                'check_id',
                                                                'check_purchase'
                                                            ));
        }
        
    }

    public function indexStatusAdminArea(Request $request)
    {

    }

    public function indexStatus(Request $request, $status_check): View
    {

        $page = $request->page;
        if ($page) {
            $page = $request->page;
        } else {
            $page = 1;
        }

        //notin code;
        $code_notin = ['0000', '4494', '7787', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];

        //menu alert;
        $status_waiting = DB::table('customers')
                                ->where('status', 'รอดำเนินการ')
                                // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                ->whereNotIn('customer_id', $code_notin)
                                ->count();

        $status_updated = DB::table('customers')
                                ->where('status_update', 'updated')
                                // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                ->whereNotIn('customer_id', $code_notin)
                                ->count();

        $status_registration = DB::table('customers')
                                    ->where('status', 'ลงทะเบียนใหม่')
                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();

        $status_alert = $status_waiting + $status_updated;

        $user_id_admin = $request->user()->user_id;

        //แสดงข้อมูลลูกค้า;

        if (($status_check == 'new_registration')) {
            $row_customer = Customer::customerRegistration($page);
            $customer = $row_customer[0];
            // dd(gettype($customer));
            $start = $row_customer[1];
            $total_page = $row_customer[2];
            $page = $row_customer[3];

            //Dashborad;
           /*  $total_customer = Customer::whereNotIn('customer_code', ['0000','4494'])->count();
            $total_status_waiting = Customer::where('status', 'รอดำเนินการ')->whereNotIn('customer_code', ['0000','4494'])->count(); */

            $total_customer = DB::table('customers')->whereNotIn('customer_code', $code_notin)->count();
            $total_status_registration = DB::table('customers')->where('status', 'ลงทะเบียนใหม่')->whereNotIn('customer_code', $code_notin)->count();

            return view('webpanel/new-registration', compact('customer', 'start', 'total_page', 'page', 'total_customer', 'total_status_registration', 'status_waiting','status_registration',  'status_updated', 'status_alert', 'user_id_admin'));
        }
        else if($status_check == 'waiting') {

            $row_customer = Customer::customerWaiting($page);
            $customer = $row_customer[0];
            // dd(gettype($customer));
            $start = $row_customer[1];
            $total_page = $row_customer[2];
            $page = $row_customer[3];

            //Dashborad;
           /*  $total_customer = Customer::whereNotIn('customer_code', ['0000','4494'])->count();
            $total_status_waiting = Customer::where('status', 'รอดำเนินการ')->whereNotIn('customer_code', ['0000','4494'])->count(); */

            $total_customer =  DB::table('customers')->whereNotIn('customer_code', $code_notin)->count();
            $total_status_waiting =  DB::table('customers')->where('status', 'รอดำเนินการ')->whereNotIn('customer_code', $code_notin)->count();

            return view('webpanel/customer-waiting', compact('customer', 'start', 'total_page', 'page', 'total_customer', 'total_status_waiting', 'status_waiting', 'status_updated','status_registration', 'status_alert', 'user_id_admin'));

        } else if ($status_check == 'action') {

            $row_customer = Customer::customerAction($page);
            $customer = $row_customer[0];
            // dd(gettype($customer));
            $start = $row_customer[1];
            $total_page = $row_customer[2];
            $page = $row_customer[3];

            //Dashborad;
           /*  $total_customer = Customer::whereNotIn('customer_code', ['0000','4494'])->count();
            $total_status_action = Customer::where('status', 'ต้องดำเนินการ')->whereNotIn('customer_code', ['0000','4494'])->count(); */

            $total_customer = DB::table('customers')->whereNotIn('customer_code', $code_notin)->count();
            $total_status_action = DB::table('customers')->where('status', 'ต้องดำเนินการ')->whereNotIn('customer_code', $code_notin)->count();

            return view('webpanel/customer-action', compact('customer', 'start', 'total_page', 'page', 'total_customer', 'total_status_action', 'status_waiting','status_registration', 'status_updated', 'status_alert', 'user_id_admin'));
       
        } else if ($status_check == 'completed') {

            $row_customer = Customer::customerCompleted($page);
            $customer = $row_customer[0];
            // dd(gettype($customer));
            $start = $row_customer[1];
            $total_page = $row_customer[2];
            $page = $row_customer[3];

            //Dashborad;
          /*   $total_customer = Customer::whereNotIn('customer_code', ['0000','4494'])->count();
            $total_status_completed = Customer::where('status', 'ดำเนินการแล้ว')->whereNotIn('customer_code', ['0000','4494'])->count(); */

            $total_customer             = DB::table('customers')->whereNotIn('customer_code', $code_notin)->count();
            $total_status_completed     = DB::table('customers')->where('status', 'ดำเนินการแล้ว')->whereNotIn('customer_code', $code_notin)->count();

            return view('webpanel/customer-completed', compact('customer', 'start', 'total_page', 'page', 'total_customer', 'total_status_completed', 'status_waiting','status_registration', 'status_updated', 'status_alert', 'user_id_admin'));
        
        } else if ($status_check == 'latest_update') {

            $row_customer = Customer::latestUpdate($page);
            $customer = $row_customer[0];
            // dd(gettype($customer));
            $start = $row_customer[1];
            $total_page = $row_customer[2];
            $page = $row_customer[3];

            //Dashborad;
            /* $total_customer = Customer::whereNotIn('customer_code', ['0000','4494'])->count();
            $total_status_updated = Customer::where('status_update', 'updated')->whereNotIn('customer_code', ['0000','4494'])->count(); */

            $total_customer         = DB::table('customers')->whereNotIn('customer_code', $code_notin)->count();
            $total_status_updated   = DB::table('customers')->where('status_update', 'updated')->whereNotIn('customer_code', $code_notin)->count();

            return view('webpanel/update-latest', compact('customer', 'start', 'total_page', 'page', 'total_customer','total_status_updated', 'status_waiting', 'status_registration', 'status_updated', 'status_alert', 'user_id_admin'));

        } else if ($status_check == 'inactive') {

            $row_customer = Customer::customerInactive($page);
            $customer = $row_customer[0];
            // dd(gettype($customer));
            $start = $row_customer[1];
            $total_page = $row_customer[2];
            $page = $row_customer[3];

            //Dashborad;
            /* $total_customer = Customer::whereNotIn('customer_code', ['0000','4494'])->count();
            $customer_status_inactive = Customer::where('customer_status', 'inactive')->whereNotIn('customer_code', ['0000','4494'])->count(); */

            $total_customer = DB::table('customers')->whereNotIn('customer_code', $code_notin)->count();
            $customer_status_inactive = Customer::where('customer_status', 'inactive')->whereNotIn('customer_code', $code_notin)->count();

            return view('webpanel/customer-inactive', compact('customer', 'start', 'total_page', 'page', 'total_customer', 'customer_status_inactive', 'status_waiting', 'status_registration', 'status_updated', 'status_alert', 'user_id_admin'));

        } else if ($status_check == 'following') {

            $row_customer = Customer::customerFollowing($page);
            $customer = $row_customer[0];
            // dd(gettype($customer));
            $start = $row_customer[1];
            $total_page = $row_customer[2];
            $page = $row_customer[3];

            //Dashborad;
            /* $total_customer = Customer::whereNotIn('customer_code', ['0000','4494'])->count();
            $customer_status_following = Customer::where('status_user', 'กำลังติดตาม')->whereNotIn('customer_code', ['0000','4494'])->count(); */

            $total_customer             = DB::table('customers')->whereNotIn('customer_code', $code_notin)->count();
            $customer_status_following  = DB::table('customers')->where('status_user', 'กำลังติดตาม')->whereNotIn('customer_code', $code_notin)->count();

            return view('webpanel/customer-following', compact('customer', 'start', 'total_page', 'page', 'total_customer', 'customer_status_following', 'status_waiting', 'status_registration',  'status_updated', 'status_alert', 'user_id_admin'));

        } 
        
        else {
            return abort(403, 'Error requesting');
        }
        
    }
    /**
     * Show the form for creating a new resource.
     */
    public function customerCreate(Request $request) 
    {
        //notin code;
        $code_notin = ['0000', '4494', '7787', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];

        $provinces = Province::province();
        $admin_area_list = DB::table('users')->select('admin_area', 'name', 'rights_area', 'user_code')->get();

        $sale_area = Salearea::select('sale_area', 'sale_name')
                    ->orderBy('sale_area' ,'asc')
                    ->get();

        $status_waiting = DB::table('customers')->where('status', 'รอดำเนินการ')
                            // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                            ->whereNotIn('customer_id', $code_notin)
                            ->count();

        $status_registration = DB::table('customers')->where('status', 'ลงทะเบียนใหม่')
                                // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                ->whereNotIn('customer_id', $code_notin)
                                ->count();

        $status_updated = DB::table('customers')->where('status_update', 'updated')
                            // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                            ->whereNotIn('customer_id', $code_notin)
                            ->count();

        $status_alert = $status_waiting + $status_updated;

        $user_id_admin = $request->user()->user_id;

        return view('webpanel/customer-create', compact('provinces', 'admin_area_list', 'sale_area', 'status_alert', 'status_waiting', 'status_registration', 'status_updated', 'user_id_admin'));
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
            

            /* $cert_store = $request->file('cert_store')->dimensions(
                Rule::dimensions()
                    ->maxWidth(100)
                    ->maxHeight(100)
            ); */
            $cert_store = $request->file('cert_store');
            $cert_medical = $request->file('cert_medical');
            $cert_commerce = $request->file('cert_commerce');
            $cert_vat = $request->file('cert_vat');
            $cert_id = $request->file('cert_id');
       
            $cert_expire = $request->cert_expire;
            // $status = 'รอดำเนินการ';
            $status = 'ลงทะเบียนใหม่';

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
                    'delivery_by' => $delivery_by,
                    'points' => '0'
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

        date_default_timezone_set("Asia/Bangkok");
        //notin code;
        $code_notin = ['0000', '4494', '7787', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];

        $customer_edit = Customer::customerEdit($id);
        $customer_view = $customer_edit[0];

        // dd($customer_view->admin_area);
        $admin_area_list  = DB::table('users')->select('admin_area', 'name', 'rights_area', 'role')->get();

        $admin_area_check = DB::table('customers')->select('admin_area', 'customer_id')->where('id', $id)->first();
        // dd($admin_area_check->admin_area);

        $sale_area = Salearea::select('sale_area', 'sale_name')
                    ->orderBy('sale_area' ,'asc')
                    ->get();

        $province   = DB::table('provinces')->select('id', 'name_th')->orderBy('id', 'asc')->get();
        $amphur     = DB::table('amphures')->select('name_th', 'province_id')->get();
        $district   = DB::table('districts')->select('name_th', 'amphure_id')->get();

        $status_waiting = DB::table('customers')->where('status', 'รอดำเนินการ')
                        // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                        ->whereNotIn('customer_id', $code_notin)
                        ->count();

        $status_registration = DB::table('customers')
                                ->where('status', 'ลงทะเบียนใหม่')
                                // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                ->whereNotIn('customer_id', $code_notin)
                                ->count();

        $status_updated = DB::table('customers')->where('status_update', 'updated')
                            // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                            ->whereNotIn('customer_id', $code_notin)
                            ->count();

        $status_alert = $status_waiting + $status_updated;

        $user_id_admin = $request->user()->user_id;

        return view('webpanel/customer-detail', compact('customer_view', 'province', 'amphur', 'district', 'admin_area_list', 'admin_area_check', 'sale_area', 'status_waiting', 'status_registration', 'status_alert', 'status_updated', 'user_id_admin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

/*         if ($request->method() === 'HEAD') {
            return response()->noContent(); // หรือ 200 OK โดยไม่ทำอะไร
        }
 */
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
                if($admin_area == null) {
                    $admin_area = '';
                }
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

                $delivery_by = $request->delivery_by;

                $points = $request->points ?? 0;

     /*    } */
                DB::table('customers')
                    ->where('id', $id)
                    ->update ([

                        'customer_id' => $customer_id,
                        'customer_code' => $customer_id,
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
                        'delivery_by' => $delivery_by,
                        'points' => $points,
                        // 'maintenance_status' => '',
                        // 'allowed_maintenance' => '',
                    
                    ]);

                // usleep(100000);
                // check user id;
                $check_customer_id = Customer::select('id')->where('id', $id)->first();
                $customer_id =  $check_customer_id->id;

                if ($customer_id == $id)
                {
                    // echo 'success';
                    return redirect('/webpanel/customer/'.$id)->with('status', 'updated_success');
                
                }
                else {

                    // echo 'fail';
                    return redirect('/webpanel/customer/'.$id)->with('status', 'updated_fail');
                }
            
    }

    public function certStore(Request $request, $id)
    {

            if($request->has('submit_store'))
            {
                // dd('image');
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

                DB::table('customers')
                        ->where('customer_id', $id)
                        ->update ([

                            'cert_store' => $image_cert_store,
                            // 'cert_store' => "storage/".$image_cert_store,

                            'status_update' => 'updated',

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
                    $image_cert_medical = $request->file('cert_medical')->storeAs('img_certmedical', $id.'_certmedical.jpg', 'cert_image');

                } else if ($cert_medical == '') {
                    $cert_medical_old = Customer::select('cert_medical')->where('customer_id',$id)->first();
                    $image_cert_medical = $cert_medical_old->cert_medical;

                } else {
                    $image_cert_medical = '';
                }

                DB::table('customers')
                        ->where('customer_id', $id)
                        ->update ([
                            
                            'cert_medical' =>  $image_cert_medical,
                            'status_update' => 'updated',

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
                    $image_cert_commerce = $request->file('cert_commerce')->storeAs('img_certcommerce', $id.'_certcommerce.jpg', 'cert_image');

                } elseif($cert_commerce == '') {
                    $cert_commerce_old = Customer::select('cert_commerce')->where('customer_id', $id)->first();
                    $image_cert_commerce = $cert_commerce_old->cert_commerce;

                } else {
                    $image_cert_commerce = '';
                }
        
                DB::table('customers')
                        ->where('customer_id', $id)
                        ->update ([

                            'cert_commerce' =>  $image_cert_commerce,
                            'status_update' => 'updated',

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
                    $image_cert_vat = $request->file('cert_vat')->storeAs('img_certvat', $id.'_certvat.jpg', 'cert_image');

                } else if($cert_vat == '') {
                    $cert_vat_old = Customer::select('cert_vat')->where('customer_id', $id)->first();
                    $image_cert_vat = $cert_vat_old->cert_vat;

                } else {
                    $image_cert_vat = '';
                }
        
                DB::table('customers')
                        ->where('customer_id', $id)
                        ->update ([

                            'cert_vat' =>  $image_cert_vat,
                            'status_update' => 'updated',

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
                    $image_cert_id = $request->file('cert_id')->storeAs('img_certid', $id.'_certid.jpg', 'cert_image');

                } elseif ($cert_id == '') {
                    $cert_id_old = Customer::select('cert_id')->where('customer_id', $id)->first();
                    $image_cert_id = $cert_id_old->cert_id;

                } else {
                    $image_cert_id = '';
                } 
        
                DB::table('customers')
                        ->where('customer_id', $id)
                        ->update ([

                            'cert_id' =>  $image_cert_id,
                            'status_update' => 'updated',

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
        if($request->id_act == 2 && $request->status == 'active') {
            Customer::where('id', $request->code_id)
                    ->update ([ 'customer_status' => 'active' ]);

        }
    }

    public function statusiAct(Request $request)
    {
        if($request->id_inact == 1 && $request->status_in == 'inactive') {
            Customer::where('id', $request->code_id)
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

    public function import(Request $request)
    {

        //notin code;
        $code_notin = ['0000', '4494', '7787', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];

        //menu alert;
        $status_waiting = DB::table('customers')->where('status', 'รอดำเนินการ')
                            // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                            ->whereNotIn('customer_id', $code_notin)
                            ->count();

        $status_registration = DB::table('customers')->where('status', 'ลงทะเบียนใหม่')
                                // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                ->whereNotIn('customer_id', $code_notin)
                                ->count();

        $status_updated = DB::table('customers')->where('status_update', 'updated')
                            // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                            ->whereNotIn('customer_id', $code_notin)
                            ->count();

        $status_alert = $status_waiting + $status_updated;

        $user_id_admin = $request->user()->user_id;

        return view('/webpanel/importcustomer', compact('status_alert', 'status_waiting', 'status_updated', 'status_registration', 'user_id_admin'));
    }
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

                                    //delivery;
                                    $delivery_row = $row[18];
                                    if($delivery_row == 1) {
                                        $delivery_by ='owner';
                                    } else {
                                        $delivery_by ='standard';
                                    }

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
                                    $status = 'รอดำเนินการ';
                                    $password = '';
                                    $status_update = '';
                                    $type = $row[8];
                                    $register_by = 'import_master';
                                    $customer_status = 'active';
                                    // $delivery_by = 'standard';

                            
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
                                    'points' => $row[9],
                                    'register_by' => $register_by,
                                    'customer_status' => $customer_status,
                                    'status_user' => $status_user,
                                    'delivery_by' => $delivery_by,
        
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
   public function groupsCustomer(Request $request) 
   {

        //notin code;
        $code_notin = ['0000', '4494', '7787', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];

        $row_salearea = Salearea::select('sale_area', 'sale_name', 'admin_area', 'updated_at')->where('sale_area', '!=', '')
                            ->orderBy('sale_area', 'asc')
                            ->get();

        $customer_area_list = Customer::select('admin_area', 'sale_area')->first();
        $admin_area_list = User::select('admin_area', 'name', 'rights_area', 'user_id')->get();

        $status_waiting = DB::table('customers')->where('status', 'รอดำเนินการ')
                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();


        $status_registration = DB::table('customers')->where('status', 'ลงทะเบียนใหม่')
                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();

        $status_updated = DB::table('customers')->where('status_update', 'updated')
                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();

        $status_alert = $status_waiting + $status_updated;

        $user_id_admin = $request->user()->user_id;

        return view('/webpanel/groups-customer', compact('row_salearea', 'customer_area_list', 'admin_area_list', 'status_waiting', 'status_registration', 'status_updated', 'status_alert', 'user_id_admin'));
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

   //getcsv customer by customer_id;
   public function getCustomerCsv($customer_id)
   {

        //notin code;
        $code_notin = ['0000', '4494', '7787', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];

        $date = date('Y-m-d');
        $filename = 'Customer__'.$customer_id.'_'.$date. '.csv';
        // Start the output buffer.
        ob_start();

        // Set PHP headers for CSV output.
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename= '.$filename);
        
        $query = Customer::select('customer_code', 'customer_name', 'price_level', 'type', 'telephone','email', 'address', 'sale_area')
                            // ->whereNotIn('customer_code', ['0000','4494'])
                            ->whereNotIn('customer_code', $code_notin)
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

    public function updateView(Request $request)
    {

        //notin code;
        $code_notin = ['0000', '4494', '7787', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];

        //menu alert;
        $status_waiting = DB::table('customers')->where('status', 'รอดำเนินการ')
                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();

        $status_registration = DB::table('customers')->where('status', 'ลงทะเบียนใหม่')
                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();

        $status_updated = DB::table('customers')->where('status_update', 'updated')
                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();

        $status_alert = $status_waiting + $status_updated;

        $user_id_admin = $request->user()->user_id;

        return view('/webpanel/updatecsv', compact('status_alert', 'status_waiting', 'status_updated', 'status_registration', 'user_id_admin'));
    }

    public function updateCsv(Request $request)
    {

        date_default_timezone_set("Asia/Bangkok");

        if($request->has('submit_csv') == true) 
        {
            
                $path = $request->file('import_csv');
                if($path == null) {
                    $path == '';
    
                } else {

                    $count = 0;
                    $rename = 'Customer_update'.'_'.date("l jS \of F Y h:i:s A").'.csv';
                    $directory = $request->file('import_csv')->storeAs('importcsv',$rename,'importfiles'); //importfiles filesystem.php->disk;
                    $fileStream = fopen(storage_path('app/public/importcsv/'.$rename),'r');

                        while (!feof($fileStream)) 
                            {

                                $row = fgetcsv($fileStream , 1000 , "|");
                                // dd($row[0]);
                                // if($row[0] ??= '') {
                                if(!empty($row[0])) {
                                
                                    $customer_name_new = str_replace("'", "''", $row[2]);

                                    $sale_area_new = $row[1];
                                    if ($sale_area_new == '') {
                                        $sale_area_new = 'ไม่ระบุ';
                                    }

                                    $status_user = str_replace("'", "''", $row[10]); 

                                    //delivery;
                                    $delivery_row = $row[18];
                                    if($delivery_row == 1) {
                                        $delivery_by ='owner';
                                    } else {
                                        $delivery_by ='standard';
                                    }

                                    $customer_name = $customer_name_new;
                                    $price_level = $row[7];
  
                                    $sale_area = $sale_area_new;

                            
                $update = Customer::where('customer_id', $row[0])->update([

                                    'customer_id'   => $row[0],
                                    'customer_code' => $row[0],
                                    'customer_name' => $customer_name,
                                    'price_level'   => $price_level,
                                    'sale_area'     => $sale_area,
                                    'status_user'   => $status_user,
                                    'points'        => $row[9],
                                    'type'          => $row[8],
                                    'delivery_by'   => $delivery_by,
        
                                ]);
                                $count += $update;
                            }

                        }

                        fclose($fileStream);

                }

        }
        // $count = Customer::all()->count();
        
        return redirect('/webpanel/customer/updatecsv')->with('success_updated', 'นำเข้าข้อมูลสำเร็จ :'.' '.$count);
            
   }

   public function updateCause(Request $request)
   {

            // dd('customer-cause');
            date_default_timezone_set("Asia/Bangkok");

            if($request->has('submit_cause') == true) 
            {
                
                    $path = $request->file('import_csv');
                    if($path == null) {
                        $path == '';
        
                    } else {

                        $count = 0;
                        $rename = 'Customer_cause'.'_'.date("l jS \of F Y h:i:s A").'.csv';
                        $directory = $request->file('import_csv')->storeAs('importcsv',$rename,'importfiles'); //importfiles filesystem.php->disk;
                        $fileStream = fopen(storage_path('app/public/importcsv/'.$rename),'r');

                            while (!feof($fileStream)) 
                                {

                                    $row = fgetcsv($fileStream , 1000 , ",");
                                    // dd($row[0]);
                                    // if($row[0] ??= '') {
                                    if(!empty($row[0])) {
                                    
                                        $note = strip_tags($row[3]); // กรอง HTML
                                        $note = htmlspecialchars($note, ENT_QUOTES, 'UTF-8'); // escape
                                        $note = trim($note); // ตัดช่องว่าง
                                
                                    $update = DB::table('customers')->where('customer_id', $row[0])->update([

                                                        'customer_status' => 'inactive',
                                                        'text_area'       => $note,
                                                        'status_user'     => 'ไม่อนุมัติ, ถูกระงับสมาชิก',
                            
                                                    ]);
                                                    $count += $update;
                                                }

                            }

                            fclose($fileStream);

                    }

            }
            // $count = Customer::all()->count();
            
            return redirect('/webpanel/customer/updatecsv')->with('success_cause', 'นำเข้าข้อมูลสำเร็จ :'.' '.$count);

   }

   //delete customer;
   public function deleteCustomer(Request $request,  $id)
   {

        if(!empty($request->id)) {

            // echo json_encode(array('checkcode'=> $request->user_code));

            $customer = Customer::where('id', $id)->first();
            // dd($customer->cert_store);

            //delete image storage;
            // Storage::delete($customer->cert_store);
            Storage::disk('cert_image')->delete($customer->cert_store);
            Storage::disk('cert_image')->delete($customer->cert_medical);
            Storage::disk('cert_image')->delete($customer->cert_commerce);
            Storage::disk('cert_image')->delete($customer->cert_vat);
            Storage::disk('cert_image')->delete($customer->cert_id);

            $customer->delete();

            echo json_encode(array('checkcode'=> $request->id));

        }
    
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

           $customers = DB::table('customers')
                        ->where('customer_id', 'like', "%{$keyword}%")
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
                               
                               <a  href="/webpanel/customer/'.$row_customer->customer_id .'" style="text-decoration: none;"> '.$row_customer->customer_id .' ' .':'.' ' .$row_customer->customer_name.' </a>
                           
                           </div>
                       </div> 
                       
                       ';
                   }
                   
               }
               
           
       }
       
   }
   public function statusPurchase(Request $request) 
   {

                            $admin_id = $request->admin_id;
                            $fixed    = $request->fixed_id;


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

                            // $id = $request->user()->admin_area;
                            $code = $request->user()->user_code;

                            //notin code;
                        // dd($request->status);
                            // dd($status);
                            $admin_area = User::where('admin_area', $admin_id)->first();

                            $page = $request->page;
                            if ($page) {
                                $page = $request->page;
                            } else {
                                $page = 1;
                            }

                            //notin code;
                            $code_notin = ['0000', '4494', '7787', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];
                            if (empty($code_notin)) {
                                $code_notin = [0]; // ใส่ค่า default ที่ไม่มีผล
                            }
                            
                            //menu alert;
                            $status_waiting = DB::table('customers')
                                                ->where('status', 'รอดำเนินการ')
                                                // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                                ->whereNotIn('customer_id', $code_notin)
                                                ->count();

                            $status_registration = DB::table('customers')
                                                    ->where('status', 'ลงทะเบียนใหม่')
                                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                                    ->whereNotIn('customer_id', $code_notin)
                                                    ->count();

                            $status_updated = DB::table('customers')
                                                ->where('status_update', 'updated')
                                                // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                                ->whereNotIn('customer_id', $code_notin)
                                                ->count();

                            $status_alert = $status_waiting + $status_updated;

                            $user_id_admin = $request->user()->user_id;

                            //แสดงข้อมูลลูกค้า;
                            $row_customer = Customer::viewCustomerAdminArea($page, $admin_id);
                            // $customer = $row_customer[0];
                            $start = $row_customer[1];
                            $total_page = $row_customer[2];
                            $page = $row_customer[3];


                            $check_id = DB::table('report_sellers')
                                        ->whereNotIn('customer_id', $code_notin)
                                        ->select('customer_id')
                                        ->distinct()
                                        ->get(); 

                            $check_purchase = DB::table('report_sellers')
                                            ->select('customer_id')
                                            ->selectRaw('MAX(date_purchase) as date_purchase')
                                            ->whereNotIn('customer_id', $code_notin)
                                            ->groupBy('customer_id')
                                            ->orderByDesc('date_purchase')
                                            ->get();
                                                

                            // name;
                            $admin_name = User::select('admin_area', 'name')->where('admin_area', $admin_id)->first();

                            $total_customer_adminarea   = DB::table('customers')->whereNotIn('customer_code', $code_notin)->where('admin_area', $admin_id)->count();
                            $total_status_waiting       = DB::table('customers')->where('admin_area', $admin_id)->where('status', 'รอดำเนินการ')->whereNotIn('customer_code', $code_notin)->count();
                            $total_status_action        = DB::table('customers')->where('admin_area', $admin_id)->where('status', 'ต้องดำเนินการ')->whereNotIn('customer_code', $code_notin)->count();
                            $total_status_completed     = DB::table('customers')->where('admin_area', $admin_id)->where('status', 'ดำเนินการแล้ว')->whereNotIn('customer_code', $code_notin)->count();
                            $total_status_registration  = DB::table('customers')->where('admin_area', $admin_id)->where('status', 'ลงทะเบียนใหม่')->whereNotIn('customer_code', $code_notin)->count();
                            
                                //dropdown admin_area;
                            $admin_area =  User::where('admin_area', '!=', '')->where('rights_area', '!=', '')->get();
            
 
                            $user_name = User::select('name', 'admin_area','user_code', 'rights_area')->where('user_code', $code)->first();
                            // $pur_report = User::select('purchase_status')->where('user_code', $code)->first();

                            $status_all = DB::table('customers')
                                        ->select('status')
                                        ->where('admin_area', $admin_id)
                                        ->whereNotIn('customer_status', ['inactive'])
                                        // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                        ->whereNotIn('customer_id', $code_notin)
                                        ->count();

                            $status_waiting = DB::table('customers')
                                            ->where('admin_area', $admin_id)
                                            ->where('status', 'รอดำเนินการ')
                                            ->whereNotIn('customer_status', ['inactive'])
                                            // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                            ->whereNotIn('customer_id', $code_notin)
                                            ->count();
                                                        // dd($count_waiting);
                            $status_action = DB::table('customers')
                                            ->where('admin_area', $admin_id)
                                            ->where('status', 'ต้องดำเนินการ')
                                            ->whereNotIn('customer_status', ['inactive'])
                                            // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                            ->whereNotIn('customer_id', $code_notin)
                                            ->count();

                            $status_completed = DB::table('customers')
                                                ->where('admin_area', $admin_id)
                                                ->where('status', 'ดำเนินการแล้ว')
                                                ->whereNotIn('customer_status', ['inactive'])
                                                // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                                ->whereNotIn('customer_id', $code_notin)
                                                ->count();

                            $status_alert = $status_waiting + $status_action;


                            if($fixed == 'morethan')
                            {
                                $count_page = DB::table('customers')
                                                ->select(
                                                'customers.customer_id',
                                                'customers.customer_name',
                                                // DB::raw('MAX(DATE(report_sellers.created_at)) as last_purchase_date')
                                                DB::raw('MAX(report_sellers.date_purchase) as last_purchase_date')
                                            )
                                            ->join('report_sellers', 'customers.customer_id', '=', 'report_sellers.customer_id')
                                            ->where('customers.admin_area', $admin_id)
                                            ->groupBy('customers.customer_id', 'customers.customer_name')
                                            ->having('last_purchase_date', '<=', $from_7)
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
                                                        // DB::raw('MAX(DATE(report_sellers.created_at)) as last_purchase_date')

                                                        DB::raw('MAX(report_sellers.date_purchase) as last_purchase_date'),
                                                        'customers.status_update'
                                                    )
                                                    ->join('report_sellers', 'customers.customer_id', '=', 'report_sellers.customer_id')
                                                    ->where('customers.admin_area', $admin_id)
                                                    ->groupBy(
                                                        'customers.id',
                                                        'customers.customer_id',
                                                        'customers.customer_name',
                                                        'customers.status',
                                                        'customers.admin_area',
                                                        'customers.sale_area',
                                                        'customers.email',
                                                        'customers.customer_status',
                                                        'customers.status_update'
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
                                                        //  ->selectRaw('MAX(DATE(date_purchase)) as date_purchase')
                                                        ->groupBy('customer_id')
                                                        ->orderByDesc('date_purchase')
                                                        ->get(); 
                            

                                        return view('webpanel/customerpur-morethan', compact(
                                                                                            'count_page', 
                                                                                            'admin_name', 
                                                                                            'customer_list', 
                                                                                            'start', 
                                                                                            'total_page', 
                                                                                            'page', 
                                                                                            'total_customer_adminarea', 
                                                                                            'total_status_waiting', 
                                                                                            'total_status_action', 
                                                                                            'total_status_completed',
                                                                                            'total_status_registration' ,
                                                                                            'status_waiting',
                                                                                            'status_registration', 
                                                                                            'status_updated', 
                                                                                            'status_alert', 
                                                                                            'user_id_admin',
                                                                                            'check_id',
                                                                                            'check_purchase'
                                                                                    ));
                            } elseif($fixed == 'coming') {

                                        $count_page = DB::table('customers')
                                                    ->select(
                                                        'customers.customer_id',
                                                        'customers.customer_name',
                                                        DB::raw('MAX(report_sellers.date_purchase) as last_purchase_date')
                                                    )
                                                    ->join('report_sellers', 'customers.customer_id', '=', 'report_sellers.customer_id')
                                                    ->where('customers.admin_area', $admin_id)
                                                    ->groupBy('customers.customer_id', 'customers.customer_name')
                                                    // ->havingBetween('last_purchase_date', $from_5)
                                                    ->havingRaw('last_purchase_date BETWEEN ? AND ?', [$from_6, $from_5])
                                                    ->count(); 
                                                    // dd($count_page);

                                        $perpage = 10;
                                        $total_page = ceil($count_page / $perpage);
                                        // dd($total_page);
                                        $start = ($perpage * $page) - $perpage;

                                        $customer_list = DB::table('customers')
                                                        ->select(
                                                                'customers.id',
                                                                'customers.customer_id',
                                                                'customers.customer_name',
                                                                'customers.status',
                                                                'customers.admin_area',
                                                                'customers.sale_area',
                                                                'customers.email',
                                                                'customers.customer_status',
                                                                'customers.created_at',
                                                                DB::raw('MAX(report_sellers.date_purchase) as last_purchase_date'),
                                                                'customers.status_update'
                                                            )
                                                            ->join('report_sellers', 'customers.customer_id', '=', 'report_sellers.customer_id')
                                                            ->where('customers.admin_area', $admin_id)
                                                            ->groupBy(
                                                                'customers.id',
                                                                'customers.customer_id',
                                                                'customers.customer_name',
                                                                'customers.status',
                                                                'customers.admin_area',
                                                                'customers.sale_area',
                                                                'customers.email',
                                                                'customers.customer_status',
                                                                'customers.created_at',
                                                                'customers.status_update'
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
                                                        // ->selectRaw('MAX(DATE(date_purchase)) as date_purchase')
                                                        ->groupBy('customer_id')
                                                        ->orderByDesc('date_purchase')
                                                        ->get(); 


                                        return view('webpanel/customerpur-coming', compact(
                                                                                            'count_page', 
                                                                                            'admin_name', 
                                                                                            'customer_list', 
                                                                                            'start', 
                                                                                            'total_page', 
                                                                                            'page', 
                                                                                            'total_customer_adminarea', 
                                                                                            'total_status_waiting', 
                                                                                            'total_status_action', 
                                                                                            'total_status_completed',
                                                                                            'total_status_registration' ,
                                                                                            'status_waiting',
                                                                                            'status_registration', 
                                                                                            'status_updated', 
                                                                                            'status_alert', 
                                                                                            'user_id_admin',
                                                                                            'check_id',
                                                                                            'check_purchase'
                                                                                        ));
                            
                            } elseif ($fixed == 'normal') {

                                        $count_page = DB::table('customers')
                                                    ->select(
                                                            'customers.customer_id',
                                                            'customers.customer_name',
                                                            DB::raw('MAX(report_sellers.date_purchase) as last_purchase_date')
                                                    )
                                                    ->join('report_sellers', 'customers.customer_id', '=', 'report_sellers.customer_id')
                                                    ->where('customers.admin_area', $admin_id)
                                                    ->groupBy('customers.customer_id', 'customers.customer_name')
                                                    // ->havingBetween('last_purchase_date', $from_5)
                                                    ->havingRaw('last_purchase_date BETWEEN ? AND ?', [$from_4, $from_3])
                                                    ->count(); 
                                                    // dd($count_page);

                                        $perpage = 10;
                                        $total_page = ceil($count_page / $perpage);
                                        // dd($total_page);
                                        $start = ($perpage * $page) - $perpage;

                                        $customer_list = DB::table('customers')
                                                        ->select(
                                                                    'customers.id',
                                                                    'customers.customer_id',
                                                                    'customers.customer_name',
                                                                    'customers.status',
                                                                    'customers.admin_area',
                                                                    'customers.sale_area',
                                                                    'customers.email',
                                                                    'customers.customer_status',
                                                                    'customers.created_at',
                                                                    DB::raw('MAX(report_sellers.date_purchase) as last_purchase_date'),
                                                                    'customers.status_update'
                                                                )
                                                                ->join('report_sellers', 'customers.customer_id', '=', 'report_sellers.customer_id')
                                                                ->where('customers.admin_area', $admin_id)
                                                                ->groupBy(
                                                                    'customers.id',
                                                                    'customers.customer_id',
                                                                    'customers.customer_name',
                                                                    'customers.status',
                                                                    'customers.admin_area',
                                                                    'customers.sale_area',
                                                                    'customers.email',
                                                                    'customers.customer_status',
                                                                    'customers.created_at',
                                                                    'customers.status_update'
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

                                                            
                                        $check_id = DB::table('report_sellers')
                                                    ->whereNotIn('customer_id', $code_notin)
                                                    ->select('customer_id')
                                                    ->distinct()
                                                    ->get(); 

                                        $check_purchase = DB::table('report_sellers')
                                                        ->whereNotIn('customer_id', $code_notin)
                                                        ->select('customer_id')
                                                        ->selectRaw('MAX(date_purchase) as date_purchase')
                                                        ->groupBy('customer_id')
                                                        ->orderByDesc('date_purchase')
                                                        ->get(); 


                                        return view('webpanel/customerpur-normal', compact(
                                                                                            'count_page', 
                                                                                            'admin_name', 
                                                                                            'customer_list', 
                                                                                            'start', 
                                                                                            'total_page', 
                                                                                            'page', 
                                                                                            'total_customer_adminarea', 
                                                                                            'total_status_waiting', 
                                                                                            'total_status_action', 
                                                                                            'total_status_completed',
                                                                                            'total_status_registration' ,
                                                                                            'status_waiting',
                                                                                            'status_registration', 
                                                                                            'status_updated', 
                                                                                            'status_alert', 
                                                                                            'user_id_admin',
                                                                                            'check_id',
                                                                                            'check_purchase'
                                                                                        ));
                            } else {

                                // dd('dd');
                                        $count_page = DB::table('customers')
                                                        ->leftJoin('report_sellers', 'customers.customer_id', '=', 'report_sellers.customer_id')
                                                        ->select('customers.customer_id', DB::raw('COUNT(report_sellers.purchase_order) as count_po'))
                                                        ->where('customers.admin_area', $admin_id)
                                                        ->groupBy('customers.customer_id')
                                                        ->havingRaw('count_po < 1')
                                                        ->get()
                                                        ->count();

                                        $perpage = 10;
                                        $total_page = ceil($count_page / $perpage);
                                        // dd($total_page);
                                        $start = ($perpage * $page) - $perpage;

                                        $customer_list = DB::table('customers')
                                                        ->select(
                                                                'customers.id',
                                                                'customers.customer_id',
                                                                'customers.customer_name',
                                                                'customers.status',
                                                                'customers.admin_area',
                                                                'customers.sale_area',
                                                                'customers.email',
                                                                'customers.customer_status',
                                                                'customers.created_at',
                                                                DB::raw('COUNT(report_sellers.purchase_order) as count_po'),
                                                                'customers.status_update'
                                                            )
                                                            ->leftjoin('report_sellers', 'customers.customer_id', '=', 'report_sellers.customer_id')
                                                            ->where('customers.admin_area', $admin_id)
                                                            ->groupBy(
                                                                'customers.id',
                                                                'customers.customer_id',
                                                                'customers.customer_name',
                                                                'customers.status',
                                                                'customers.admin_area',
                                                                'customers.sale_area',
                                                                'customers.email',
                                                                'customers.customer_status',
                                                                'customers.created_at',
                                                                'customers.status_update'
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


                                            return view('webpanel/customerpur-nopurchase', compact(
                                                                                                    'count_page', 
                                                                                                    'admin_name', 
                                                                                                    'customer_list', 
                                                                                                    'start', 
                                                                                                    'total_page', 
                                                                                                    'page', 
                                                                                                    'total_customer_adminarea', 
                                                                                                    'total_status_waiting', 
                                                                                                    'total_status_action', 
                                                                                                    'total_status_completed',
                                                                                                    'total_status_registration' ,
                                                                                                    'status_waiting',
                                                                                                    'status_registration', 
                                                                                                    'status_updated', 
                                                                                                    'status_alert', 
                                                                                                    'user_id_admin',
                                                                                                    'check_id',
                                                                                                    'check_purchase'
                                                                                                ));
                            }
                

    }

}


/* @else
                            <td scope="row" style="color:#9C9C9C; text-align: center; padding:30px; width:20%;">
                                @if ($check_over_7)
                                    <span data-bs-toggle="modal" data-bs-target="#staticBackdrop_seven" style="cursor: pointer; border: solid 2px; padding: 10px; border-radius: 10px; color:rgb(255, 70, 70);">
                                        เกิน 7 วัน
                                    </span>

                                    @php
                                        $po_last = $report_seller->firstWhere('customer_id', $user_code)?->purchase_order;
                                        $date_pur = $report_seller->firstWhere('customer_id', $user_code)?->date_purchase;
                                    @endphp
                                    <div class="modal fade" id="staticBackdrop_seven" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <span class="modal-title" style="font-size:16px;" id="staticBackdropLabel">ร้านค้า : {{ $user_code.' '.'|'.' '.$user_name.'' }}</span>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="py-2 mt-2" style="text-align: left;">
                                                <span class="ms-3 py-2" style="text-align: start;">เลขที่ : {{ $po_last }}</span> |
                                                <span style="background-color: #e04b30; color:white; border-radius:5px; padding:3px;">{{ $date_pur }}</span>
                                            </div>
                                            {{-- <hr style="color:#a5a5a5;"> --}}
                                                <div class="modal-body">

                                                    <div class="relative overflow-x-auto">
                                                        <table class="w-full text-left">
                                                            <thead class="" style="background-color:#222222; color:rgb(255, 255, 255);">
                                                                <tr>
                                                                    <td scope="col" class="px-6 py-3 text-center">
                                                                        รหัสสินค้า
                                                                    </td>
                                                                    <td scope="col" class="px-6 py-3">
                                                                        ชื่อสินค้า
                                                                    </td>
                                                                    <td scope="col" class="px-6 py-3 text-center">
                                                                        หน่วย
                                                                    </td>
                                                                    <td scope="col" class="px-6 py-3 text-center">
                                                                        จำนวน
                                                                    </td>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @php
                                                                    $total = 0;
                                                                @endphp
                                                                @foreach ($report_seller as $row_seller )
                                                                @php
                                                                    $product_id   =  $row_seller?->product_id;
                                                                    $product_name =  $row_seller?->product_name;
                                                                    $unit         =  $row_seller?->unit;
                                                                    $qty          =  $row_seller?->quantity;
                                                                    $total        += $row_seller?->total_sale;
                                                                @endphp
                                                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200"">
                                                
                                                                    <td class="border border-gray-300 px-4 py-2 text-center">
                                                                        {{ $product_id }}
                                                                    </td>
                                                                    <td class="border border-gray-300 px-4 py-2">
                                                                        {{ $product_name}}
                                                                    </td>
                                                                    <td class="border border-gray-300 px-4 py-2 text-center">
                                                                        {{ $unit }}
                                                                    </td>
                                                                    <td class="border border-gray-300 px-4 py-2 text-center">
                                                                        {{ $qty}}
                                                                    </td>
                                                                </tr>
                                                                @endforeach

                                                                <td class="border border-gray-300 px-4 py-2 text-center" colspan="2">รวมเป็นเงิน</td>
                                                                <td class="border border-gray-300 px-4 py-2 text-center" colspan="2">฿{{ number_format($total,2) }}</td>
                                                                
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                </div>
                                        
                                            </div>
                                        </div>
                                    </div>
                                @elseif ($check_over_5)
                                    <span data-bs-toggle="modal" data-bs-target="#staticBackdrop_five" style="cursor: pointer; border: solid 2px; padding: 10px; border-radius: 10px; color:#ffa51d;">
                                        ใกล้ครบกำหนด
                                    </span>

                                    @php
                                        $po_last = $report_seller->firstWhere('customer_id', $user_code)?->purchase_order;
                                        $date_pur = $report_seller->firstWhere('customer_id', $user_code)?->date_purchase;
                                    @endphp
                                    <div class="modal fade" id="staticBackdrop_five" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <span class="modal-title" style="font-size:16px;" id="staticBackdropLabel">ร้านค้า : {{ $user_code.' '.'|'.' '.$user_name.'' }}</span>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="py-2 mt-2" style="text-align: left;">
                                                <span class="ms-3 py-2" style="text-align: start;">เลขที่ : {{ $po_last }}</span> |
                                                <span style="background-color: #ffa51d; color:white; border-radius:5px; padding:3px;">{{ $date_pur }}</span>
                                            </div>
                                            {{-- <hr style="color:#a5a5a5;"> --}}
                                                <div class="modal-body">

                                                    <div class="relative overflow-x-auto">
                                                        <table class="w-full text-left">
                                                            <thead class="" style="background-color:#222222; color:rgb(255, 255, 255);">
                                                                <tr>
                                                                    <td scope="col" class="px-6 py-3 text-center">
                                                                        รหัสสินค้า
                                                                    </td>
                                                                    <td scope="col" class="px-6 py-3">
                                                                        ชื่อสินค้า
                                                                    </td>
                                                                    <td scope="col" class="px-6 py-3 text-center">
                                                                        หน่วย
                                                                    </td>
                                                                    <td scope="col" class="px-6 py-3 text-center">
                                                                        จำนวน
                                                                    </td>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @php
                                                                    $total = 0;
                                                                @endphp
                                                                @foreach ($report_seller as $row_seller )
                                                                @php
                                                                    $product_id   = $row_seller?->product_id;
                                                                    $product_name = $row_seller?->product_name;
                                                                    $unit         = $row_seller?->unit;
                                                                    $qty          = $row_seller?->quantity;
                                                                    $total        += $row_seller?->total_sale;
                                                                @endphp
                                                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                                
                                                                    <td class="border border-gray-300 px-4 py-2 text-center">
                                                                        {{ $product_id }}
                                                                    </td>
                                                                    <td class="border border-gray-300 px-4 py-2">
                                                                        {{ $product_name}}
                                                                    </td>
                                                                    <td class="border border-gray-300 px-4 py-2 text-center">
                                                                        {{ $unit }}
                                                                    </td>
                                                                    <td class="border border-gray-300 px-4 py-2 text-center">
                                                                        {{ $qty}}
                                                                    </td>
                                                                </tr>
                                                                @endforeach

                                                                <td class="border border-gray-300 px-4 py-2 text-center" colspan="2">รวมเป็นเงิน</td>
                                                                <td class="border border-gray-300 px-4 py-2 text-center" colspan="2">฿{{ number_format($total,2) }}</td>

                                                            </tbody>
                                                        </table>
                                                    </div>

                                                </div>
                                        
                                            </div>
                                        </div>
                                    </div>
                                @else
                                
                                    <span data-bs-toggle="modal" data-bs-target="#staticBackdrop_normal" style="cursor: pointer; border: solid 2px; padding: 10px; border-radius: 10px; color:rgb(51, 197, 14);">
                                        ปกติ
                                    </span>

                                    @php
                                        $po_last = $report_seller->firstWhere('customer_id', $user_code)?->purchase_order;
                                        $date_pur = $report_seller->firstWhere('customer_id', $user_code)?->date_purchase;
                                    @endphp
                                    <div class="modal fade" id="staticBackdrop_normal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <span class="modal-title" style="font-size:16px;" id="staticBackdropLabel">ร้านค้า : {{ $user_code.' '.'|'.' '.$user_name.'' }}</span>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="py-2 mt-2" style="text-align: left;">
                                                <span class="ms-3 py-2" style="text-align: start;">เลขที่ : {{ $po_last }}</span> |
                                                <span style="background-color: #09be0f; color:white; border-radius:5px; padding:3px;">{{ $date_pur }}</span>
                                            </div>
                                            {{-- <hr style="color:#a5a5a5;"> --}}
                                                <div class="modal-body">

                                                    <div class="relative overflow-x-auto">
                                                        <table class="w-full text-left">
                                                            <thead class="" style="background-color:#222222; color:rgb(255, 255, 255);">
                                                                <tr>
                                                                    <td scope="col" class="px-6 py-3 text-center">
                                                                        รหัสสินค้า
                                                                    </td>
                                                                    <td scope="col" class="px-6 py-3">
                                                                        ชื่อสินค้า
                                                                    </td>
                                                                    <td scope="col" class="px-6 py-3 text-center">
                                                                        หน่วย
                                                                    </td>
                                                                    <td scope="col" class="px-6 py-3 text-center">
                                                                        จำนวน
                                                                    </td>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @php
                                                                    $total = 0;
                                                                @endphp
                                                                @foreach ($report_seller as $row_seller )
                                                                @php
                                                                    $product_id   = $row_seller?->product_id;
                                                                    $product_name = $row_seller?->product_name;
                                                                    $unit         = $row_seller?->unit;
                                                                    $qty          = $row_seller?->quantity;
                                                                    $total        += $row_seller?->total_sale;
                                                                @endphp
                                                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                                
                                                                    <td class="border border-gray-300 px-4 py-2 text-center">
                                                                        {{ $product_id }}
                                                                    </td>
                                                                    <td class="border border-gray-300 px-4 py-2">
                                                                        {{ $product_name}}
                                                                    </td>
                                                                    <td class="border border-gray-300 px-4 py-2 text-center">
                                                                        {{ $unit }}
                                                                    </td>
                                                                    <td class="border border-gray-300 px-4 py-2 text-center">
                                                                        {{ $qty}}
                                                                    </td>
                                                                </tr>
                                                                @endforeach

                                                                <td class="border border-gray-300 px-4 py-2 text-center" colspan="2">รวมเป็นเงิน</td>
                                                                <td class="border border-gray-300 px-4 py-2 text-center" colspan="2">฿{{ number_format($total,2) }}</td>
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                </div>
                                        
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </td> */