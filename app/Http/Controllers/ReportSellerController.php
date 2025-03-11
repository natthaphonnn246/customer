<?php

namespace App\Http\Controllers;

use App\Models\ReportSeller;
use Illuminate\Http\Request;
use App\Imports\SellersImport;
use App\Models\Salearea;
use App\Models\Customer;
use App\Models\user;
use Illuminate\View\View;
use Illuminate\Http\File;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\JoinClause;

class ReportSellerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {

        // dd($request->max_price);
    
        // dd($request->to);

        $check_from = $request->from;
        $check_to = $request->to;

        $page = $request->page;
        if ($page) {
            $page = $request->page;
        } else {
            $page = 1;
        }

        if($check_from != null && $check_to != null)
        {

            $range_min = $request->min_seller;
            $range_max = $request->max_seller;

            // dd($range_min);
            
            if($range_min == null AND $range_max == null) {
            //แสดงข้อมูลลูกค้า;
            $pagination = ReportSeller::select(DB::raw('DISTINCT(customer_id)'))
                                        ->whereBetween('date_purchase', [$request->from, $request->to])
                                        ->get();
            $count_page = count($pagination);

            $perpage = 10;
            $total_page = ceil($count_page / $perpage);
            $start = ($perpage * $page) - $perpage;

            $report_seller = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name')
                                            ->join('customers', function (JoinClause $join) {
                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                            })
                                            ->groupBy('report_sellers.customer_id', 'customers.customer_name')
                                            ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                            ->offset($start)
                                            ->limit($perpage)
                                            ->get();

                                            // dd($report_seller);
            } else {

                //แสดงข้อมูลลูกค้า;
                $pagination = ReportSeller::select('customer_id', DB::raw('SUM(price*quantity) as total_sales'))
                                            ->groupBy('customer_id')
                                            ->whereBetween('date_purchase', [$request->from, $request->to])
                                            ->havingBetween('total_sales', [$range_min, $range_max])
                                            ->get();
                                $count_page = count($pagination);
                                // dd($count_page);

                $perpage = 10;
                $total_page = ceil($count_page / $perpage);
                $start = ($perpage * $page) - $perpage;

                $report_seller = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name')
                                ->join('customers', function (JoinClause $join) {
                                    $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                })
                                ->groupBy('report_sellers.customer_id', 'customers.customer_name')
                                ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                ->havingBetween('total_sales', [$range_min, $range_max])
                                ->offset($start)
                                ->limit($perpage)
                                ->get();

            }
            
        } else {
      
            date_default_timezone_set("Asia/Bangkok");
            // $keyword_date =  date('Y-m-d');
            $keyword_date_from = date('Y-m-d');
            $keyword_date_to =  date('Y-m-d');
            // dd($keyword_date);
            //แสดงข้อมูลลูกค้า;
            $pagination = ReportSeller::select(DB::raw('DISTINCT(customer_id)'))
                                        ->whereBetween('date_purchase', [$keyword_date_from, $keyword_date_to])
                                        ->get();
            $count_page = count($pagination);

            $perpage = 10;
            $total_page = ceil($count_page / $perpage);
            $start = ($perpage * $page) - $perpage;

            $report_seller = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price * quantity) as total_sales'), 'customers.customer_name')
                                            ->join('customers', function (JoinClause $join) {
                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                            })
                                            ->groupBy('report_sellers.customer_id', 'customers.customer_name')
                                            ->whereBetween('report_sellers.date_purchase', [$keyword_date_from, $keyword_date_to])
                                            ->havingBetween('total_sales', [$request, 50000])
                                            ->offset($start)
                                            ->limit($perpage)
                                            ->get();

        }

        //Dashborad;
        $total_customer = Customer::whereNotIn('customer_code', ['0000','4494'])->count();
        $total_status_waiting = Customer::where('status', 'รอดำเนินการ')->whereNotIn('customer_code', ['0000','4494'])->count();
        $total_status_action = Customer::where('status', 'ต้องดำเนินการ')->whereNotIn('customer_code', ['0000','4494'])->count();
        $total_status_completed = Customer::where('status', 'ดำเนินการแล้ว')->whereNotIn('customer_code', ['0000','4494'])->count();
        $total_status_updated = Customer::where('status_update', 'updated')->whereNotIn('customer_code', ['0000','4494'])->count();
        $customer_status_inactive = Customer::where('customer_status', 'inactive')->whereNotIn('customer_code', ['0000','4494'])->count();

        //เพิ่มลูกค้า;
        // $admin_area_list = User::select('admin_area', 'name', 'rights_area', 'user_code')->get();

        $status_waiting = Customer::where('status', 'รอดำเนินการ')
                                    ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->count();

        $status_updated = Customer::where('status_update', 'updated')
                                    ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->count();

        $status_alert = $status_waiting + $status_updated;

        //dropdown admin_area;
        $admin_area =  User::where('admin_area', '!=', '')->where('rights_area', '!=', '')->get();
        ////////////////////////////////////////////////////////

        $keyword_search = $request->keyword;
        // dd($keyword);

        if($keyword_search != '') {

            $count_page = Customer::where('customer_id', 'Like', "%{$keyword_search}%")->count();
            // dd($count_page);

            $perpage = 10;
            $total_page = ceil($count_page / $perpage);
            $start = ($perpage * $page) - $perpage;

            $customer = Customer::whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->where('customer_id', 'Like', "%{$keyword_search}%")
                                    ->orWhere('customer_name', 'Like', "%{$keyword_search}%")
                                    ->offset($start)
                                    ->limit($perpage)
                                    ->get();

            $check_keyword = Customer::whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                        ->where('customer_id', 'Like', "%{$keyword_search}%")
                                        ->orWhere('customer_name', 'Like', "%{$keyword_search}%")
                                        ->get();

            // dd($check_customer_code);

            // dd($check_search->admin_area);
            if(!$check_keyword  == null) {
                return view('report/seller', compact('check_from','check_to', 'check_keyword', 'admin_area', 'customer', 'start', 'total_page', 'page', 'total_customer', 'total_status_waiting',
                            'total_status_action', 'total_status_completed', 'total_status_updated', 'customer_status_inactive', 'status_alert', 'status_waiting', 'status_updated'));
        
            }
            

                // return back();
        }

        return view('report/seller', compact('check_from','check_to', 'admin_area', 'report_seller', 'start', 'total_page', 'page', 'total_customer', 'total_status_waiting',
                'total_status_action', 'total_status_completed', 'total_status_updated', 'customer_status_inactive', 'status_alert', 'status_waiting', 'status_updated'));

    }
    

    public function import()
    {
         //menu alert;
         $status_waiting = Customer::where('status', 'รอดำเนินการ')
                                    ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->count();

        $status_updated = Customer::where('status_update', 'updated')
                                    ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->count();

        $status_alert = $status_waiting + $status_updated;

        return view('/report/importseller', compact('status_alert', 'status_waiting', 'status_updated'));
    }

    //เก็บไว้ดู
 /*    public function importFile(Request $request)
    {

        date_default_timezone_set("Asia/Bangkok");

        if($request->has('submit_csv') == true) {

            $path = $request->file('import_csv');
            if($path == null) {
                $path == '';
            } else {
                $rename = 'Seller_all'.'_'.'.csv';
                Excel::import(new SellersImport, $request->file('import_csv')->storeAs('importcsv',$rename,'importfiles'), 'importfiles', \Maatwebsite\Excel\Excel::CSV);
            }

        }

    } */

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
                            
                            
                                    ReportSeller::create([

                                        'purchase_order' => $row[0],
                                        'report_sellers_id' => $row[1],
                                        'customer_id' => $row[1],
                                        'customer_name' => $row[2],
                                        'product_id' => $row[3],
                                        'product_name' => $row[4],
                                        'price' => $row[5],
                                        'quantity' => $row[6],
                                        'unit' => $row[7],
                                        'date_purchase' => $row[8],
                
                                        ]);
                                }

                        }

                        fclose($fileStream);

                }

        }
        $count = Customer::all()->count();
        
        return redirect('/webpanel/report/seller/importseller')->with('success_import', 'นำเข้าข้อมูลสำเร็จ :'.' '.$count);
            
   }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(ReportSeller $reportSeller)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ReportSeller $reportSeller)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ReportSeller $reportSeller)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ReportSeller $reportSeller)
    {
        //
    }

    public function rangeSeller(Request $request): View
    {

        // dd($request->max_price);
    
        // dd($request->from);

        $check_from = $request->from;
        $check_to = $request->to;

        $min_seller = $request->min_seller;
        $max_seller = $request->max_seller;


        $page = $request->page;
        if ($page) {
            $page = $request->page;
        } else {
            $page = 1;
        }

        if($check_from != null || $check_to != null || $min_seller != null || $max_seller != null)
        {

            //แสดงข้อมูลลูกค้า;
            $pagination = ReportSeller::select(DB::raw('DISTINCT(customer_id)'))
                                        // ->whereBetween('date_purchase', [$request->from, $request->to])
                                        ->get();
            $count_page = count($pagination);

            $perpage = 10;
            $total_page = ceil($count_page / $perpage);
            $start = ($perpage * $page) - $perpage;

            $report_seller = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name')
                                            ->join('customers', function (JoinClause $join) {
                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                            })
                                            ->groupBy('report_sellers.customer_id', 'customers.customer_name')
                                            ->havingBetween('total_sales', [$request->min_seller, $request->max_seller])
                                            ->offset($start)
                                            ->limit($perpage)
                                            ->get();
        } else {
      
            date_default_timezone_set("Asia/Bangkok");
            // $keyword_date =  date('Y-m-d');
            $keyword_date_from = date('Y-m-d');
            $keyword_date_to =  date('Y-m-d');
            // dd($keyword_date);
            //แสดงข้อมูลลูกค้า;
            $pagination = ReportSeller::select(DB::raw('DISTINCT(customer_id)'))
                                        // ->whereBetween('date_purchase', [$keyword_date_from, $keyword_date_to])
                                        ->get();
            $count_page = count($pagination);

            $perpage = 10;
            $total_page = ceil($count_page / $perpage);
            $start = ($perpage * $page) - $perpage;

           $report_seller = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price * quantity) as total_sales'), 'customers.customer_name')
                                            ->join('customers', function (JoinClause $join) {
                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                            })
                                            ->groupBy('report_sellers.customer_id', 'customers.customer_name')
                                            ->havingBetween('total_sales', [$request->min_seller, $request->max_seller])
                                            ->offset($start)
                                            ->limit($perpage)
                                            ->get();
/* 
                    $report_seller = ReportSeller::select('customer_id' , DB::raw('SUM(price * quantity) as total_sales'))
                                                ->groupBy('customer_id')
                                                ->havingBetween('total_sales', [5000, 10000])
                                                ->get();
                                                // dd($report_seller); */
        }

        //Dashborad;
        $total_customer = Customer::whereNotIn('customer_code', ['0000','4494'])->count();
        $total_status_waiting = Customer::where('status', 'รอดำเนินการ')->whereNotIn('customer_code', ['0000','4494'])->count();
        $total_status_action = Customer::where('status', 'ต้องดำเนินการ')->whereNotIn('customer_code', ['0000','4494'])->count();
        $total_status_completed = Customer::where('status', 'ดำเนินการแล้ว')->whereNotIn('customer_code', ['0000','4494'])->count();
        $total_status_updated = Customer::where('status_update', 'updated')->whereNotIn('customer_code', ['0000','4494'])->count();
        $customer_status_inactive = Customer::where('customer_status', 'inactive')->whereNotIn('customer_code', ['0000','4494'])->count();

        //เพิ่มลูกค้า;
        // $admin_area_list = User::select('admin_area', 'name', 'rights_area', 'user_code')->get();

        $status_waiting = Customer::where('status', 'รอดำเนินการ')
                                    ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->count();

        $status_updated = Customer::where('status_update', 'updated')
                                    ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->count();

        $status_alert = $status_waiting + $status_updated;

        //dropdown admin_area;
        $admin_area =  User::where('admin_area', '!=', '')->where('rights_area', '!=', '')->get();
        ////////////////////////////////////////////////////////

        $keyword_search = $request->keyword;
        // dd($keyword);

        if($keyword_search != '') {

            $count_page = Customer::where('customer_id', 'Like', "%{$keyword_search}%")->count();
            // dd($count_page);

            $perpage = 10;
            $total_page = ceil($count_page / $perpage);
            $start = ($perpage * $page) - $perpage;

            $customer = Customer::whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->where('customer_id', 'Like', "%{$keyword_search}%")
                                    ->orWhere('customer_name', 'Like', "%{$keyword_search}%")
                                    ->offset($start)
                                    ->limit($perpage)
                                    ->get();

            $check_keyword = Customer::whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                        ->where('customer_id', 'Like', "%{$keyword_search}%")
                                        ->orWhere('customer_name', 'Like', "%{$keyword_search}%")
                                        ->get();

            // dd($check_customer_code);

            // dd($check_search->admin_area);
            if(!$check_keyword  == null) {
                return view('report/seller', compact('check_from','check_to', 'check_keyword', 'admin_area', 'customer', 'start', 'total_page', 'page', 'total_customer', 'total_status_waiting',
                            'total_status_action', 'total_status_completed', 'total_status_updated', 'customer_status_inactive', 'status_alert', 'status_waiting', 'status_updated'));
        
            }
            

                // return back();
        }

        return view('report/seller', compact('check_from','check_to', 'admin_area', 'report_seller', 'start', 'total_page', 'page', 'total_customer', 'total_status_waiting',
                'total_status_action', 'total_status_completed', 'total_status_updated', 'customer_status_inactive', 'status_alert', 'status_waiting', 'status_updated'));

    }
}
