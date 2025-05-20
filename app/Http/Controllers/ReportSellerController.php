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
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use Illuminate\Support\Collection;
// use Illuminate\Http\JsonResponse;


class ReportSellerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {

        // dd('test');

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
          //notin code;
          $code_notin = ['0000', '4494', '7787', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];

          $status_waiting = Customer::where('status', 'รอดำเนินการ')
                                      ->whereNotIn('customer_id', $code_notin)
                                      ->count();
  
          $status_updated = Customer::where('status_update', 'updated')
                                      ->whereNotIn('customer_id', $code_notin)
                                      ->count();
  
          $status_registration = Customer::where('status', 'ลงทะเบียนใหม่')
                                      // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                      ->whereNotIn('customer_id', $code_notin)
                                      ->count();
  
          $status_alert = $status_waiting + $status_updated;
  
          $user_id_admin = $request->user()->user_id;
  
          //dropdown admin_area;
          $admin_area =  User::where('admin_area', '!=', '')->where('rights_area', '!=', '')->get();

          //dropdown sale_area;
          $sale_area =  Salearea::select('sale_area', 'sale_name')->get();

        if(!empty($check_from) && !empty($check_to))
        {

            $range_min = $request->min_seller;
            $range_max = $request->max_seller;

            $salearea_seller = $request->salearea_seller;
            $adminarea_seller = $request->adminarea_seller;

            $delivery = $request->delivery;
            $region = $request->region;

            // dd($range_min);
            
            // if($range_min == null AND $range_max == null) {

                    if (!empty($range_min) && !empty($range_max)) 
                    {
        
                            if(!empty($region) && !empty($delivery)) 
                            {
                                //code check region and delivery;
                                if(!empty($salearea_seller && !empty($adminarea_seller))) {

                                    $filters_page = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'salearea_seller' => $salearea_seller,
                                        'adminarea_seller' => $adminarea_seller,
                                        'region' => $region,
                                        'delivery' => $delivery,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key_page = 'sales_page_' . md5(json_encode($filters_page));

                                    $pagination = Cache::remember($key_page, 1800, function () use ($filters_page) {

                                    return ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', 'report_sellers.customer_id')
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.purchase_order', 'report_sellers.customer_id')
                                                        ->where('customers.sale_area', $filters_page['salearea_seller'])
                                                        ->where('customers.admin_area', $filters_page['adminarea_seller'])
                                                        ->where('customers.geography', $filters_page['region'])
                                                        ->where('customers.delivery_by', $filters_page['delivery'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters_page['from'], $filters_page['to']])
                                                        ->havingBetween('total_sales', [$filters_page['range_min'], $filters_page['range_max']])
                                                        ->get();
                                                    });

                                    $count_page = count($pagination);
                                    // dd($count_page);

                                    $perpage = 10;
                                    $total_page = ceil($count_page / $perpage);
                                    $start = ($perpage * $page) - $perpage;

                                    $filters_customer = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'salearea_seller' => $salearea_seller,
                                        'adminarea_seller' => $adminarea_seller,
                                        'region' => $region,
                                        'delivery' => $delivery,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key_customer = 'sales_customer_' . md5(json_encode($filters_customer));

                                    $count_report_customer = Cache::remember($key_customer, 1800, function () use ($filters_customer) {

                                    return ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', DB::raw('COUNT(report_sellers.customer_id) as count_id'))
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.customer_id', 'report_sellers.purchase_order')
                                                        ->where('customers.sale_area', $filters_customer['salearea_seller'])
                                                        ->where('customers.admin_area', $filters_customer['adminarea_seller'])
                                                        ->where('customers.geography', $filters_customer['region'])
                                                        ->where('customers.delivery_by', $filters_customer['delivery'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters_customer['from'], $filters_customer['to']])
                                                        ->havingBetween('total_sales', [$filters_customer['range_min'], $filters_customer['range_max']])
                                                        ->get();
                                                    });
                                        
                                                            //dd($count_report_customer);
                                                            //นับจำนวนร้านค้าแบบไม่ซ้ำ;
                                                            foreach($count_report_customer as $row_id) {
                                                
                                                                $arr_id[] = $row_id->customer_id;
                                                            } 

                                                            //นำตัวที่ซ้ำออก;
                                                            if(isset($arr_id)) {
                                                                $unique = array_unique($arr_id);
                                                                $count_customer_range = count($unique);

                                                            } else {
                                                                $count_customer_range = 0;
                                                            }
                                        
                                        // dd($count_customer_range);

                                    //dashboard;
                                    $filters_po = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'salearea_seller' => $salearea_seller,
                                        'adminarea_seller' => $adminarea_seller,
                                        'region' => $region,
                                        'delivery' => $delivery,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key_po = 'sales_po_' . md5(json_encode($filters_po));

                                    $count_po_range = Cache::remember($key_po, 1800, function () use ($filters_po) {

                                    return ReportSeller::select('purchase_order', DB::raw('SUM(price*quantity) as total_sales'))
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.purchase_order')
                                                        ->where('customers.sale_area', $filters_po['salearea_seller'])
                                                        ->where('customers.admin_area', $filters_po['adminarea_seller'])
                                                        ->where('customers.geography', $filters_po['region'])
                                                        ->where('customers.delivery_by', $filters_po['delivery'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters_po['from'], $filters_po['to']])
                                                        ->havingBetween('total_sales', [$filters_po['range_min'], $filters_po['range_max']])
                                                        ->get();
                                                    });

                                    $count_purchase_range = count($count_po_range);
                                    // dd($count_purchase_range);
                                    $filters_selling = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'salearea_seller' => $salearea_seller,
                                        'adminarea_seller' => $adminarea_seller,
                                        'region' => $region,
                                        'delivery' => $delivery,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key_selling = 'sales_selling_' . md5(json_encode($filters_selling));

                                    $total_report_selling = Cache::remember($key_selling, 1800, function () use ($filters_selling) {

                                    return ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order')
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.purchase_order')
                                                        ->where('customers.sale_area', $filters_selling['salearea_seller'])
                                                        ->where('customers.admin_area', $filters_selling['adminarea_seller'])
                                                        ->where('customers.geography', $filters_selling['region'])
                                                        ->where('customers.delivery_by', $filters_selling['delivery'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters_selling['from'], $filters_selling['to']])
                                                        ->havingBetween('total_sales', [$filters_selling['range_min'], $filters_selling['range_max']])
                                                        ->get();
                                                    });

                                    // dd($total_report_selling);
                                    $filters = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'page' => $page,
                                        'perpage' => $perpage,
                                        'salearea_seller' => $salearea_seller,
                                        'adminarea_seller' => $adminarea_seller,
                                        'region' => $region,
                                        'delivery' => $delivery,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key = 'sales_report_' . md5(json_encode($filters));

                                    $report_seller = Cache::remember($key, 1800, function () use ($filters) {

                                    return ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name', 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.customer_id', 'customers.customer_name' , 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                        ->where('customers.sale_area', $filters['salearea_seller'])
                                                        ->where('customers.admin_area', $filters['adminarea_seller'])
                                                        ->where('customers.geography', $filters['region'])
                                                        ->where('customers.delivery_by', $filters['delivery'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters['from'], $filters['to']])
                                                        ->havingBetween('total_sales', [$filters['range_min'], $filters['range_max']])
                                                        /* ->offset($start)
                                                        ->limit($perpage)
                                                        ->get(); */
                                                        ->paginate($filters['perpage'], ['*'], 'page', $filters['page']);
                                                    });
                            
                                } else if(!empty($salearea_seller)) {

                                    $filters_page = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'salearea_seller' => $salearea_seller,
                                        'region' => $region,
                                        'delivery' => $delivery,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key_page = 'sales_customer_' . md5(json_encode($filters_page));

                                    $pagination = Cache::remember($key_page, 1800, function () use ($filters_page) {

                                    return ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->join('customers', function (JoinClause $join) {
                                                    $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                })
                                                ->groupBy('report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->where('customers.sale_area', $filters_page['salearea_seller'])
                                                ->where('customers.geography', $filters_page['region'])
                                                ->where('customers.delivery_by', $filters_page['delivery'])
                                                ->whereBetween('report_sellers.date_purchase', [$filters_page['from'], $filters_page['to']])
                                                ->havingBetween('total_sales', [$filters_page['range_min'], $filters_page['range_max']])
                                                ->get();
                                            });

                                    $count_page = count($pagination);
                                    // dd($count_page);

                                    $perpage = 10;
                                    $total_page = ceil($count_page / $perpage);
                                    $start = ($perpage * $page) - $perpage;

                                    $filters_customer = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'salearea_seller' => $salearea_seller,
                                        'region' => $region,
                                        'delivery' => $delivery,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key_customer = 'sales_customer_' . md5(json_encode($filters_customer));

                                    $count_report_customer = Cache::remember($key_customer, 1800, function () use ($filters_customer) {

                                    return ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', DB::raw('COUNT(report_sellers.customer_id) as count_id'))
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.customer_id', 'report_sellers.purchase_order')
                                                        ->where('customers.sale_area', $filters_customer['salearea_seller'])
                                                        ->where('customers.geography', $filters_customer['region'])
                                                        ->where('customers.delivery_by', $filters_customer['delivery'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters_customer['from'], $filters_customer['to']])
                                                        ->havingBetween('total_sales', [$filters_customer['range_min'], $filters_customer['range_max']])
                                                        ->get();
                                                    });
                                        
                                                            //dd($count_report_customer);
                                                            //นับจำนวนร้านค้าแบบไม่ซ้ำ;
                                                            foreach($count_report_customer as $row_id) {
                                                
                                                                $arr_id[] = $row_id->customer_id;
                                                            } 

                                                            //นำตัวที่ซ้ำออก;
                                                            if(isset($arr_id)) {
                                                                $unique = array_unique($arr_id);
                                                                $count_customer_range = count($unique);

                                                            } else {
                                                                $count_customer_range = 0;
                                                            }
                                        
                                        // dd($count_customer_range);

                                    //dashboard;
                                    $filters_po = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'salearea_seller' => $salearea_seller,
                                        'region' => $region,
                                        'delivery' => $delivery,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key_po = 'sales_po_' . md5(json_encode($filters_po));

                                    $count_po_range = Cache::remember($key_po, 1800, function () use ($filters_po) {

                                    return ReportSeller::select('purchase_order', DB::raw('SUM(price*quantity) as total_sales'))
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.purchase_order')
                                                        ->where('customers.sale_area', $filters_po['salearea_seller'])
                                                        ->where('customers.geography', $filters_po['region'])
                                                        ->where('customers.delivery_by', $filters_po['delivery'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters_po['from'], $filters_po['to']])
                                                        ->havingBetween('total_sales', [$filters_po['range_min'], $filters_po['range_max']])
                                                        ->get();
                                                    });

                                    $count_purchase_range = count($count_po_range);
                                    // dd($count_purchase_range);

                                    $filters_selling = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'salearea_seller' => $salearea_seller,
                                        'region' => $region,
                                        'delivery' => $delivery,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key_selling = 'sales_selling_' . md5(json_encode($filters_selling));

                                    $total_report_selling = Cache::remember($key_selling, 1800, function () use ($filters_selling) {

                                    return ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order')
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.purchase_order')
                                                        ->where('customers.sale_area', $filters_selling['salearea_seller'])
                                                        ->where('customers.geography', $filters_selling['region'])
                                                        ->where('customers.delivery_by', $filters_selling['delivery'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters_selling['from'], $filters_selling['to']])
                                                        ->havingBetween('total_sales', [$filters_selling['range_min'], $filters_selling['range_max']])
                                                        ->get();
                                                    });

                                    $filters = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'page' => $page,
                                        'perpage' => $perpage,
                                        'salearea_seller' => $salearea_seller,
                                        'region' => $region,
                                        'delivery' => $delivery,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key = 'sales_report_' . md5(json_encode($filters));

                                    $report_seller = Cache::remember($key, 1800, function () use ($filters) {

                                    return ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name', 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.customer_id', 'customers.customer_name' , 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                        ->where('customers.sale_area', $filters['salearea_seller'])
                                                        ->where('customers.geography', $filters['region'])
                                                        ->where('customers.delivery_by', $filters['delivery'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters['from'], $filters['to']])
                                                        ->havingBetween('total_sales', [$filters['range_min'], $filters['range_max']])
                                                    /*   ->offset($start)
                                                        ->limit($perpage)
                                                        ->get(); */
                                                        ->paginate($filters['perpage'], ['*'], 'page', $filters['page']);
                                                    });

                                } else if(!empty($adminarea_seller)) {

                                    $filters_page = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'adminarea_seller' => $adminarea_seller,
                                        'region' => $region,
                                        'delivery' => $delivery,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key_page = 'sales_page_' . md5(json_encode($filters_page));

                                    $pagination = Cache::remember($key_page, 1800, function () use ($filters_page) {

                                    return ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', 'report_sellers.customer_id')
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.purchase_order', 'report_sellers.customer_id')
                                                        ->where('customers.admin_area', $filters_page['adminarea_seller'])
                                                        ->where('customers.geography', $filters_page['region'])
                                                        ->where('customers.delivery_by', $filters_page['delivery'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters_page['from'], $filters_page['to']])
                                                        ->havingBetween('total_sales', [$filters_page['range_min'], $filters_page['range_max']])
                                                        ->get();
                                                    });

                                    $count_page = count($pagination);
                                    // dd($count_page);

                                    $perpage = 10;
                                    $total_page = ceil($count_page / $perpage);
                                    $start = ($perpage * $page) - $perpage;

                                    $filters_customer = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'adminarea_seller' => $adminarea_seller,
                                        'region' => $region,
                                        'delivery' => $delivery,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key_customer = 'sales_customer_' . md5(json_encode($filters_customer));

                                    $count_report_customer = Cache::remember($key_customer, 1800, function () use ($filters_customer) {

                                    return ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', DB::raw('COUNT(report_sellers.customer_id) as count_id'))
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.customer_id', 'report_sellers.purchase_order')
                                                        ->where('customers.admin_area', $filters_customer['adminarea_seller'])
                                                        ->where('customers.geography', $filters_customer['region'])
                                                        ->where('customers.delivery_by', $filters_customer['delivery'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters_customer['from'], $filters_customer['to']])
                                                        ->havingBetween('total_sales', [$filters_customer['range_min'], $filters_customer['range_max']])
                                                        ->get();
                                                    });
                                        
                                                            //dd($count_report_customer);
                                                            //นับจำนวนร้านค้าแบบไม่ซ้ำ;
                                                            foreach($count_report_customer as $row_id) {
                                                
                                                                $arr_id[] = $row_id->customer_id;
                                                            } 

                                                            //นำตัวที่ซ้ำออก;
                                                            if(isset($arr_id)) {
                                                                $unique = array_unique($arr_id);
                                                                $count_customer_range = count($unique);

                                                            } else {
                                                                $count_customer_range = 0;
                                                            }
                                        
                                        // dd($count_customer_range);

                                    //dashboard;
                                    $filters_po = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'adminarea_seller' => $adminarea_seller,
                                        'region' => $region,
                                        'delivery' => $delivery,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key_po = 'sales_po_' . md5(json_encode($filters_po));

                                    $count_po_range =Cache::remember($key_po, 1800, function () use ($filters_po) {

                                    return ReportSeller::select('purchase_order', DB::raw('SUM(price*quantity) as total_sales'))
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.purchase_order')
                                                        ->where('customers.admin_area', $filters_po['adminarea_seller'])
                                                        ->where('customers.geography', $filters_po['region'])
                                                        ->where('customers.delivery_by', $filters_po['delivery'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters_po['from'], $filters_po['to']])
                                                        ->havingBetween('total_sales', [$filters_po['range_min'], $filters_po['range_max']])
                                                        ->get();
                                                    });

                                    $count_purchase_range = count($count_po_range);
                                    // dd($count_purchase_range);

                                    $filters_selling = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'adminarea_seller' => $adminarea_seller,
                                        'region' => $region,
                                        'delivery' => $delivery,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key_selling = 'sales_selling_' . md5(json_encode($filters_selling));

                                    $total_report_selling = Cache::remember($key_selling, 1800, function () use ($filters_selling) {

                                    return ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order')
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.purchase_order')
                                                        ->where('customers.admin_area', $filters_selling['adminarea_seller'])
                                                        ->where('customers.geography', $filters_selling['region'])
                                                        ->where('customers.delivery_by', $filters_selling['delivery'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters_selling['from'], $filters_selling['to']])
                                                        ->havingBetween('total_sales', [$filters_selling['range_min'], $filters_selling['range_max']])
                                                        ->get();
                                                    });

                                    $filters = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'page' => $page,
                                        'perpage' => $perpage,
                                        'adminarea_seller' => $adminarea_seller,
                                        'region' => $region,
                                        'delivery' => $delivery,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key = 'sales_report_' . md5(json_encode($filters));

                                    $report_seller = Cache::remember($key, 1800, function () use ($filters) {

                                    return ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name', 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.customer_id', 'customers.customer_name' , 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                        ->where('customers.admin_area', $filters['adminarea_seller'])
                                                        ->where('customers.geography', $filters['region'])
                                                        ->where('customers.delivery_by', $filters['delivery'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters['from'], $filters['to']])
                                                        ->havingBetween('total_sales', [$filters['range_min'], $filters['range_max']])
                                                /*      ->offset($start)
                                                        ->limit($perpage)
                                                        ->get(); */
                                                        ->paginate($filters['perpage'], ['*'], 'page', $filters['page']);

                                                    });
                                
                                } else {

                                    $filters_page = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'region' => $region,
                                        'delivery' => $delivery,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key_page = 'sales_page_' . md5(json_encode($filters_page));

                                    $pagination = Cache::remember($key_page, 1800, function () use ($filters_page) {

                                    return ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', 'report_sellers.customer_id')
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('purchase_order', 'customer_id')
                                                        ->where('customers.geography', $filters_page['region'])
                                                        ->where('customers.delivery_by', $filters_page['delivery'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters_page['from'], $filters_page['to']])
                                                        ->havingBetween('total_sales', [$filters_page['range_min'], $filters_page['range_max']])
                                                        ->get();
                                                    });

                                    $count_page = count($pagination);
                                    // dd($count_page);

                                    $perpage = 10;
                                    $total_page = ceil($count_page / $perpage);
                                    $start = ($perpage * $page) - $perpage;

                                    $filters_customer = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'region' => $region,
                                        'delivery' => $delivery,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key_customer = 'sales_customer_' . md5(json_encode($filters_customer));

                                    $count_report_customer = Cache::remember($key_customer, 1800, function () use ($filters_customer) {

                                    return ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', DB::raw('COUNT(report_sellers.customer_id) as count_id'))
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.customer_id', 'report_sellers.purchase_order')
                                                        ->where('customers.geography', $filters_customer['region'])
                                                        ->where('customers.delivery_by', $filters_customer['delivery'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters_customer['from'], $filters_customer['to']])
                                                        ->havingBetween('total_sales', [$filters_customer['range_min'], $filters_customer['range_max']])
                                                        ->get();
                                                    });
                                        
                                                            //dd($count_report_customer);
                                                            //นับจำนวนร้านค้าแบบไม่ซ้ำ;
                                                            foreach($count_report_customer as $row_id) {
                                                
                                                                $arr_id[] = $row_id->customer_id;
                                                            } 

                                                            //นำตัวที่ซ้ำออก;
                                                            if(isset($arr_id)) {
                                                                $unique = array_unique($arr_id);
                                                                $count_customer_range = count($unique);

                                                            } else {
                                                                $count_customer_range = 0;
                                                            }
                                        
                                        // dd($count_customer_range);

                                    //dashboard;

                                    $filters_po = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'region' => $region,
                                        'delivery' => $delivery,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key_po = 'sales_po_' . md5(json_encode($filters_po));

                                    $count_po_range = Cache::remember($key_po, 1800, function () use ($filters_po) {

                                    return ReportSeller::select('purchase_order', DB::raw('SUM(price*quantity) as total_sales'))
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.purchase_order')
                                                        ->where('customers.geography', $filters_po['region'])
                                                        ->where('customers.delivery_by', $filters_po['delivery'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters_po['from'], $filters_po['to']])
                                                        ->havingBetween('total_sales', [$filters_po['range_min'], $filters_po['range_max']])
                                                        ->get();
                                                    });

                                    $count_purchase_range = count($count_po_range);
                                    // dd($count_purchase_range);


                                    $filters_selling = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'region' => $region,
                                        'delivery' => $delivery,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key_selling = 'sales_selling_' . md5(json_encode($filters_selling));

                                    $total_report_selling = Cache::remember($key_selling, 1800, function () use ($filters_selling) {
                
                                    return ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order')
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.purchase_order')
                                                        ->where('customers.geography', $filters_selling['region'])
                                                        ->where('customers.delivery_by', $filters_selling['delivery'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters_selling['from'], $filters_selling['to']])
                                                        ->havingBetween('total_sales', [$filters_selling['range_min'], $filters_selling['range_max']])
                                                        ->get();
                                                    });

                                    $filters = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'page' => $page,
                                        'perpage' => $perpage,
                                        'region' => $region,
                                        'delivery' => $delivery,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key = 'sales_report_' . md5(json_encode($filters));

                                    $report_seller = Cache::remember($key, 1800, function () use ($filters) {

                                    return ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name', 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.customer_id', 'customers.customer_name' , 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                        ->where('customers.geography', $filters['region'])
                                                        ->where('customers.delivery_by', $filters['delivery'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters['from'], $filters['to']])
                                                        ->havingBetween('total_sales', [$filters['range_min'], $filters['range_max']])
                                                    /*   ->offset($start)
                                                        ->limit($perpage)
                                                        ->get(); */
                                                        ->paginate($filters['perpage'], ['*'], 'page', $filters['page']);
                                                    });
                                }

                            } else if (!empty($region)) {
                                //code check region;
                                if(!empty($salearea_seller && !empty($adminarea_seller))) {

                                    $filters_page = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'salearea_seller' => $salearea_seller,
                                        'adminarea_seller' => $adminarea_seller,
                                        'region' => $region,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key_page = 'sales_page_' . md5(json_encode($filters_page));

                                    $pagination = Cache::remember($key_page, 1800, function () use ($filters_page) {

                                    return ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', 'report_sellers.customer_id')
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.purchase_order', 'report_sellers.customer_id')
                                                        ->where('customers.sale_area', $filters_page['salearea_seller'])
                                                        ->where('customers.admin_area', $filters_page['adminarea_seller'])
                                                        ->where('customers.geography', $filters_page['region'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters_page['from'], $filters_page['to']])
                                                        ->havingBetween('total_sales', [$filters_page['range_min'], $filters_page['range_max']])
                                                        ->get();
                                                    });

                                    $count_page = count($pagination);
                                    // dd($count_page);

                                    $perpage = 10;
                                    $total_page = ceil($count_page / $perpage);
                                    $start = ($perpage * $page) - $perpage;

                                    $filters_customer = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'salearea_seller' => $salearea_seller,
                                        'adminarea_seller' => $adminarea_seller,
                                        'region' => $region,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key_customer = 'sales_customer_' . md5(json_encode($filters_customer));

                                    $count_report_customer = Cache::remember($key_customer, 1800, function () use ($filters_customer) {

                                    return ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', DB::raw('COUNT(report_sellers.customer_id) as count_id'))
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.customer_id', 'report_sellers.purchase_order')
                                                        ->where('customers.sale_area', $filters_customer['salearea_seller'])
                                                        ->where('customers.admin_area', $filters_customer['adminarea_seller'])
                                                        ->where('customers.geography', $filters_customer['region'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters_customer['from'], $filters_customer['to']])
                                                        ->havingBetween('total_sales', [$filters_customer['range_min'], $filters_customer['range_max']])
                                                        ->get();
                                                    });
                                        
                                                            //dd($count_report_customer);
                                                            //นับจำนวนร้านค้าแบบไม่ซ้ำ;
                                                            foreach($count_report_customer as $row_id) {
                                                
                                                                $arr_id[] = $row_id->customer_id;
                                                            } 

                                                            //นำตัวที่ซ้ำออก;
                                                            if(isset($arr_id)) {
                                                                $unique = array_unique($arr_id);
                                                                $count_customer_range = count($unique);

                                                            } else {
                                                                $count_customer_range = 0;
                                                            }
                                        
                                        // dd($count_customer_range);

                                    //dashboard;
                                    $filters_po = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'salearea_seller' => $salearea_seller,
                                        'adminarea_seller' => $adminarea_seller,
                                        'region' => $region,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key_po = 'sales_po_' . md5(json_encode($filters_po));

                                    $count_po_range = Cache::remember($key_po, 1800, function () use ($filters_po) {

                                    return ReportSeller::select('purchase_order', DB::raw('SUM(price*quantity) as total_sales'))
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.purchase_order')
                                                        ->where('customers.sale_area', $filters_po['salearea_seller'])
                                                        ->where('customers.admin_area', $filters_po['adminarea_seller'])
                                                        ->where('customers.geography', $filters_po['region'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters_po['from'], $filters_po['to']])
                                                        ->havingBetween('total_sales', [$filters_po['range_min'], $filters_po['range_max']])
                                                        ->get();
                                                    });

                                    $count_purchase_range = count($count_po_range);
                                    // dd($count_purchase_range);

                                    $filters_selling = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'salearea_seller' => $salearea_seller,
                                        'adminarea_seller' => $adminarea_seller,
                                        'region' => $region,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key_selling = 'sales_selling_' . md5(json_encode($filters_selling));

                                    $total_report_selling = Cache::remember($key_selling, 1800, function () use ($filters_selling) {

                                    return ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order')
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.purchase_order')
                                                        ->where('customers.sale_area', $filters_selling['salearea_seller'])
                                                        ->where('customers.admin_area', $filters_selling['adminarea_seller'])
                                                        ->where('customers.geography', $filters_selling['region'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters_selling['from'], $filters_selling['to']])
                                                        ->havingBetween('total_sales', [$filters_selling['range_min'], $filters_selling['range_max']])
                                                        ->get();
                                                    });

                                    $filters = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'page' => $page,
                                        'perpage' => $perpage,
                                        'salearea_seller' => $salearea_seller,
                                        'adminarea_seller' => $adminarea_seller,
                                        'region' => $region,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key = 'sales_report_' . md5(json_encode($filters));

                                    $report_seller = Cache::remember($key, 1800, function () use ($filters) {

                                    return ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name', 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.customer_id', 'customers.customer_name' , 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->where('customers.sale_area', $filters['salearea_seller'])
                                                    ->where('customers.admin_area', $filters['adminarea_seller'])
                                                    ->where('customers.geography', $filters['region'])
                                                    ->whereBetween('report_sellers.date_purchase', [$filters['from'], $filters['to']])
                                                    ->havingBetween('total_sales', [$filters['range_min'], $filters['range_max']])
                                                    /* ->offset($start)
                                                    ->limit($perpage)
                                                    ->get(); */
                                                    ->paginate($filters['perpage'], ['*'], 'page', $filters['page']);
                                                });
                        
                                } else if(!empty($salearea_seller)) {

                                    $filters_page = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'salearea_seller' => $salearea_seller,
                                        'region' => $region,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key_page = 'sales_page_' . md5(json_encode($filters_page));

                                    $pagination = Cache::remember($key_page, 1800, function () use ($filters_page) {

                                    return ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', 'report_sellers.customer_id')
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.purchase_order', 'report_sellers.customer_id')
                                                        ->where('customers.sale_area', $filters_page['salearea_seller'])
                                                        ->where('customers.geography', $filters_page['region'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters_page['from'], $filters_page['to']])
                                                        ->havingBetween('total_sales', [$filters_page['range_min'], $filters_page['range_max']])
                                                        ->get();
                                                    });

                                    $count_page = count($pagination);
                                    // dd($count_page);

                                    $perpage = 10;
                                    $total_page = ceil($count_page / $perpage);
                                    $start = ($perpage * $page) - $perpage;

                                    $filters_customer = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'salearea_seller' => $salearea_seller,
                                        'region' => $region,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key_customer = 'sales_customer_' . md5(json_encode($filters_customer));

                                    $count_report_customer = Cache::remember($key_customer, 1800, function () use ($filters_customer) {

                                    return ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', DB::raw('COUNT(report_sellers.customer_id) as count_id'))
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.customer_id', 'report_sellers.purchase_order')
                                                        ->where('customers.sale_area', $filters_customer['salearea_seller'])
                                                        ->where('customers.geography', $filters_customer['region'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters_customer['from'], $filters_customer['to']])
                                                        ->havingBetween('total_sales', [$filters_customer['range_min'], $filters_customer['range_max']])
                                                        ->get();
                                                    });

                                    //dd($count_report_customer);
                                    //นับจำนวนร้านค้าแบบไม่ซ้ำ;
                                    foreach($count_report_customer as $row_id) {

                                        $arr_id[] = $row_id->customer_id;
                                    } 

                                    //นำตัวที่ซ้ำออก;
                                    if(isset($arr_id)) {
                                        $unique = array_unique($arr_id);
                                        $count_customer_range = count($unique);

                                    } else {
                                        $count_customer_range = 0;
                                    }

                                    // dd($count_customer_range);

                                    //dashboard;
                                    $filters_po = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'salearea_seller' => $salearea_seller,
                                        'region' => $region,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key_po = 'sales_po_' . md5(json_encode($filters_po));

                                    $count_po_range = Cache::remember($key_po, 1800, function () use ($filters_po) {

                                    return ReportSeller::select('purchase_order', DB::raw('SUM(price*quantity) as total_sales'))
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.purchase_order')
                                                        ->where('customers.sale_area', $filters_po['salearea_seller'])
                                                        ->where('customers.geography', $filters_po['region'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters_po['from'], $filters_po['to']])
                                                        ->havingBetween('total_sales', [$filters_po['range_min'], $filters_po['range_max']])
                                                        ->get();
                                                    });

                                    $count_purchase_range = count($count_po_range);
                                    // dd($count_purchase_range);


                                    $filters_selling = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'salearea_seller' => $salearea_seller,
                                        'region' => $region,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key_selling = 'sales_selling_' . md5(json_encode($filters_selling));

                                    $total_report_selling = Cache::remember($key_selling, 1800, function () use ($filters_selling) {

                                    return ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order')
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.purchase_order')
                                                        ->where('customers.sale_area', $filters_selling['salearea_seller'])
                                                        ->where('customers.geography', $filters_selling['region'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters_selling['from'], $filters_selling['to']])
                                                        ->havingBetween('total_sales', [$filters_selling['range_min'], $filters_selling['range_max']])
                                                        ->get();
                                                    });


                                    $filters = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'page' => $page,
                                        'perpage' => $perpage,
                                        'salearea_seller' => $salearea_seller,
                                        'region' => $region,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key = 'sales_report_' . md5(json_encode($filters));

                                    $report_seller = Cache::remember($key, 1800, function () use ($filters) {

                                    return ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name', 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.customer_id', 'customers.customer_name' , 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                        ->where('customers.sale_area', $filters['salearea_seller'])
                                                        ->where('customers.geography', $filters['region'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters['from'], $filters['to']])
                                                        ->havingBetween('total_sales', [$filters['range_min'], $filters['range_max']])
                                                    /*  ->offset($start)
                                                        ->limit($perpage)
                                                        ->get(); */
                                                        ->paginate($filters['perpage'], ['*'], 'page', $filters['page']);
                                                    });

                                } else if(!empty($adminarea_seller)) {

                                    $filters_page = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'adminarea_seller' => $adminarea_seller,
                                        'region' => $region,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key_page = 'sales_page_' . md5(json_encode($filters_page));

                                    $pagination = Cache::remember($key_page, 1800, function () use ($filters_page) {

                                    return ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', 'report_sellers.customer_id')
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.purchase_order', 'report_sellers.customer_id')
                                                        ->where('customers.admin_area', $filters_page['adminarea_seller'])
                                                        ->where('customers.geography', $filters_page['region'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters_page['from'], $filters_page['to']])
                                                        ->havingBetween('total_sales', [$filters_page['range_min'], $filters_page['range_max']])
                                                        ->get();
                                                    });

                                    $count_page = count($pagination);
                                    // dd($count_page);

                                    $perpage = 10;
                                    $total_page = ceil($count_page / $perpage);
                                    $start = ($perpage * $page) - $perpage;

                                    $filters_customer = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'adminarea_seller' => $adminarea_seller,
                                        'region' => $region,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key_customer = 'sales_customer_' . md5(json_encode($filters_customer));

                                    $count_report_customer = Cache::remember($key_customer, 1800, function () use ($filters_customer) {

                                    return ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', DB::raw('COUNT(report_sellers.customer_id) as count_id'))
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.customer_id', 'report_sellers.purchase_order')
                                                        ->where('customers.admin_area', $filters_customer['adminarea_seller'])
                                                        ->where('customers.geography', $filters_customer['region'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters_customer['from'], $filters_customer['to']])
                                                        ->havingBetween('total_sales', [$filters_customer['range_min'], $filters_customer['range_max']])
                                                        ->get();
                                                    });

                                    //dd($count_report_customer);
                                    //นับจำนวนร้านค้าแบบไม่ซ้ำ;
                                    foreach($count_report_customer as $row_id) {

                                        $arr_id[] = $row_id->customer_id;
                                    } 

                                    //นำตัวที่ซ้ำออก;
                                    if(isset($arr_id)) {
                                        $unique = array_unique($arr_id);
                                        $count_customer_range = count($unique);

                                    } else {
                                        $count_customer_range = 0;
                                    }

                                    // dd($count_customer_range);

                                    //dashboard;
                                    $filters_po = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'adminarea_seller' => $adminarea_seller,
                                        'region' => $region,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key_po = 'sales_po_' . md5(json_encode($filters_po));

                                    $count_po_range = Cache::remember($key_po, 1800, function () use ($filters_po) {

                                    return ReportSeller::select('purchase_order', DB::raw('SUM(price*quantity) as total_sales'))
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.purchase_order')
                                                        ->where('customers.admin_area', $filters_po['adminarea_seller'])
                                                        ->where('customers.geography', $filters_po['region'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters_po['from'], $filters_po['to']])
                                                        ->havingBetween('total_sales', [$filters_po['range_min'], $filters_po['range_max']])
                                                        ->get();
                                                    });

                                    $count_purchase_range = count($count_po_range);
                                    // dd($count_purchase_range);

                                    $filters_selling = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'adminarea_seller' => $adminarea_seller,
                                        'region' => $region,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key_selling = 'sales_selling_' . md5(json_encode($filters_selling));

                                    $total_report_selling = Cache::remember($key_selling, 1800, function () use ($filters_selling) {

                                    return ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order')
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.purchase_order')
                                                        ->where('customers.admin_area', $filters_selling['adminarea_seller'])
                                                        ->where('customers.geography', $filters_selling['region'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters_selling['from'], $filters_selling['to']])
                                                        ->havingBetween('total_sales', [$filters_selling['range_min'], $filters_selling['range_max']])
                                                        ->get();
                                                    });

                                    $filters = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'page' => $page,
                                        'perpage' => $perpage,
                                        'adminarea_seller' => $adminarea_seller,
                                        'region' => $region,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key = 'sales_report_' . md5(json_encode($filters));

                                    $report_seller = Cache::remember($key, 1800, function () use ($filters) {

                                    return ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name', 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.customer_id', 'customers.customer_name' , 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                        ->where('customers.admin_area', $filters['adminarea_seller'])
                                                        ->where('customers.geography', $filters['region'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters['from'], $filters['to']])
                                                        ->havingBetween('total_sales', [$filters['range_min'], $filters['range_max']])
                                                        /* ->offset($start)
                                                        ->limit($perpage)
                                                        ->get(); */
                                                        ->paginate($filters['perpage'], ['*'], 'page', $filters['page']);
                                                    });
                                
                                } else {

                                    $filters_page = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'region' => $region,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key_page = 'sales_page_' . md5(json_encode($filters_page));

                                    $pagination = Cache::remember($key_page, 1800, function () use ($filters_page) {

                                    return ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', 'report_sellers.customer_id')
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.purchase_order', 'report_sellers.customer_id')
                                                        ->where('customers.geography', $filters_page['region'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters_page['from'], $filters_page['to']])
                                                        ->havingBetween('total_sales', [$filters_page['range_min'], $filters_page['range_max']])
                                                        ->get();
                                                    });

                                    $count_page = count($pagination);
                                    // dd($count_page);

                                    $perpage = 10;
                                    $total_page = ceil($count_page / $perpage);
                                    $start = ($perpage * $page) - $perpage;

                                    $filters_customer = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'region' => $region,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key_customer = 'sales_customer_' . md5(json_encode($filters_customer));

                                    $count_report_customer = Cache::remember($key_customer, 1800, function () use ($filters_customer) {

                                    return ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', DB::raw('COUNT(report_sellers.customer_id) as count_id'))
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.customer_id', 'report_sellers.purchase_order')
                                                            ->where('customers.geography', $filters_customer['region'])
                                                            ->whereBetween('report_sellers.date_purchase', [$filters_customer['from'], $filters_customer['to']])
                                                            ->havingBetween('total_sales', [$filters_customer['range_min'], $filters_customer['range_max']])
                                                            ->get();
                                                        });

                                    //dd($count_report_customer);
                                    //นับจำนวนร้านค้าแบบไม่ซ้ำ;
                                    foreach($count_report_customer as $row_id) {

                                        $arr_id[] = $row_id->customer_id;
                                    } 

                                    //นำตัวที่ซ้ำออก;
                                    if(isset($arr_id)) {
                                        $unique = array_unique($arr_id);
                                        $count_customer_range = count($unique);

                                    } else {
                                        $count_customer_range = 0;
                                    }

                                    // dd($count_customer_range);

                                    //dashboard;
                                    $filters_po = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'region' => $region,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key_po = 'sales_po_' . md5(json_encode($filters_po));

                                    $count_po_range = Cache::remember($key_po, 1800, function () use ($filters_po) {

                                    return ReportSeller::select('purchase_order', DB::raw('SUM(price*quantity) as total_sales'))
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.purchase_order')
                                                        ->where('customers.geography', $filters_po['region'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters_po['from'], $filters_po['to']])
                                                        ->havingBetween('total_sales', [$filters_po['range_min'], $filters_po['range_max']])
                                                        ->get();
                                                    });

                                    $count_purchase_range = count($count_po_range);
                                    // dd($count_purchase_range);

                                    $filters_selling = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'region' => $region,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key_selling = 'sales_selling_' . md5(json_encode($filters_selling));

                                    $total_report_selling = Cache::remember($key_selling, 1800, function () use ($filters_selling) {

                                    return ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order')
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.purchase_order')
                                                        ->where('customers.geography', $filters_selling['region'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters_selling['from'], $filters_selling['to']])
                                                        ->havingBetween('total_sales', [$filters_selling['range_min'], $filters_selling['range_max']])
                                                        ->get();
                                                    });

                                    $filters = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'page' => $page,
                                        'perpage' => $perpage,
                                        'region' => $region,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key = 'sales_report_' . md5(json_encode($filters));

                                    $report_seller = Cache::remember($key, 1800, function () use ($filters) {

                                    return ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name', 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.customer_id', 'customers.customer_name' , 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                        ->where('customers.geography', $filters['region'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters['from'], $filters['to']])
                                                        ->havingBetween('total_sales', [$filters['range_min'], $filters['range_max']])
                                                    /*  ->offset($start)
                                                        ->limit($perpage)
                                                        ->get(); */
                                                        ->paginate($filters['perpage'], ['*'], 'page', $filters['page']);
                                                    });
                                }

                            } else if (!empty($delivery)) {
                                //code check delivery;
                                if(!empty($salearea_seller && !empty($adminarea_seller))) {

                                    $filters_page = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'salearea_seller' => $salearea_seller,
                                        'adminarea_seller' => $adminarea_seller,
                                        'delivery' => $delivery,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key_page = 'sales_page_' . md5(json_encode($filters_page));

                                    $pagination = Cache::remember($key_page, 1800, function () use ($filters_page) {

                                    return ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->join('customers', function (JoinClause $join) {
                                                    $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                })
                                                ->groupBy('report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->where('customers.sale_area', $filters_page['salearea_seller'])
                                                ->where('customers.admin_area', $filters_page['adminarea_seller'])
                                                ->where('customers.delivery_by', $filters_page['delivery'])
                                                ->whereBetween('report_sellers.date_purchase', [$filters_page['from'], $filters_page['to']])
                                                ->havingBetween('total_sales', [$filters_page['range_min'], $filters_page['range_max']])
                                                ->get();
                                            });

                                    $count_page = count($pagination);
                                    // dd($count_page);

                                    $perpage = 10;
                                    $total_page = ceil($count_page / $perpage);
                                    $start = ($perpage * $page) - $perpage;

                                    $filters_customer = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'salearea_seller' => $salearea_seller,
                                        'adminarea_seller' => $adminarea_seller,
                                        'delivery' => $delivery,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key_customer = 'sales_customer_' . md5(json_encode($filters_customer));

                                    $count_report_customer =  Cache::remember($key_customer, 1800, function () use ($filters_customer) {

                                    return ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', DB::raw('COUNT(report_sellers.customer_id) as count_id'))
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.customer_id', 'report_sellers.purchase_order')
                                                        ->where('customers.sale_area', $filters_customer['salearea_seller'])
                                                        ->where('customers.admin_area', $filters_customer['adminarea_seller'])
                                                        ->where('customers.delivery_by', $filters_customer['delivery'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters_customer['from'], $filters_customer['to']])
                                                        ->havingBetween('total_sales', [$filters_customer['range_min'], $filters_customer['range_max']])
                                                        ->get();
                                                    });
                                        
                                                            //dd($count_report_customer);
                                                            //นับจำนวนร้านค้าแบบไม่ซ้ำ;
                                                            foreach($count_report_customer as $row_id) {
                                                
                                                                $arr_id[] = $row_id->customer_id;
                                                            } 

                                                            //นำตัวที่ซ้ำออก;
                                                            if(isset($arr_id)) {
                                                                $unique = array_unique($arr_id);
                                                                $count_customer_range = count($unique);

                                                            } else {
                                                                $count_customer_range = 0;
                                                            }
                                        
                                        // dd($count_customer_range);

                                    //dashboard;
                                    $filters_po = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'salearea_seller' => $salearea_seller,
                                        'adminarea_seller' => $adminarea_seller,
                                        'delivery' => $delivery,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key_po = 'sales_po_' . md5(json_encode($filters_po));

                                    $count_po_range = Cache::remember($key_po, 1800, function () use ($filters_po) {

                                    return ReportSeller::select('purchase_order', DB::raw('SUM(price*quantity) as total_sales'))
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.purchase_order')
                                                        ->where('customers.sale_area', $filters_po['salearea_seller'])
                                                        ->where('customers.admin_area', $filters_po['adminarea_seller'])
                                                        ->where('customers.delivery_by', $filters_po['delivery'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters_po['from'], $filters_po['to']])
                                                        ->havingBetween('total_sales', [$filters_po['range_min'], $filters_po['range_max']])
                                                        ->get();
                                                    });

                                    $count_purchase_range = count($count_po_range);
                                    // dd($count_purchase_range);

                                    $filters_selling = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'salearea_seller' => $salearea_seller,
                                        'adminarea_seller' => $adminarea_seller,
                                        'delivery' => $delivery,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key_selling = 'sales_selling_' . md5(json_encode($filters_selling));

                                    $total_report_selling = Cache::remember($key_selling, 1800, function () use ($filters_selling) {

                                    return ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'purchase_order')
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('purchase_order')
                                                        ->where('customers.sale_area', $filters_selling['salearea_seller'])
                                                        ->where('customers.admin_area', $filters_selling['adminarea_seller'])
                                                        ->where('customers.delivery_by', $filters_selling['delivery'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters_selling['from'], $filters_selling['to']])
                                                        ->havingBetween('total_sales', [$filters_selling['range_min'], $filters_selling['range_max']])
                                                        ->get();
                                                    });

                                    $filters = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'page' => $page,
                                        'perpage' => $perpage,
                                        'salearea_seller' => $salearea_seller,
                                        'adminarea_seller' => $adminarea_seller,
                                        'delivery' => $delivery,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key = 'sales_report_' . md5(json_encode($filters));

                                    $report_seller = Cache::remember($key, 1800, function () use ($filters) {

                                    return ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name', 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.customer_id', 'customers.customer_name' , 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                        ->where('customers.sale_area', $filters['salearea_seller'])
                                                        ->where('customers.admin_area', $filters['adminarea_seller'])
                                                        ->where('customers.delivery_by', $filters['delivery'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters['from'], $filters['to']])
                                                        ->havingBetween('total_sales', [$filters['range_min'], $filters['range_max']])
                                                    /*  ->offset($start)
                                                        ->limit($perpage)
                                                        ->get(); */
                                                        ->paginate($filters['perpage'], ['*'], 'page', $filters['page']);
                                                    });
                        
                                } else if(!empty($salearea_seller)) {

                                    $filters_page = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'salearea_seller' => $salearea_seller,
                                        'delivery' => $delivery,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key_page = 'sales_page_' . md5(json_encode($filters_page));

                                    $pagination = Cache::remember($key_page, 1800, function () use ($filters_page) {

                                    return ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->join('customers', function (JoinClause $join) {
                                                    $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                })
                                                ->groupBy('report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->where('customers.sale_area', $filters_page['salearea_seller'])
                                                ->where('customers.delivery_by', $filters_page['delivery'])
                                                ->whereBetween('report_sellers.date_purchase', [$filters_page['from'], $filters_page['to']])
                                                ->havingBetween('total_sales', [$filters_page['range_min'], $filters_page['range_max']])
                                                ->get();
                                            });

                                    $count_page = count($pagination);
                                    // dd($count_page);

                                    $perpage = 10;
                                    $total_page = ceil($count_page / $perpage);
                                    $start = ($perpage * $page) - $perpage;

                                    $filters_customer = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'salearea_seller' => $salearea_seller,
                                        'delivery' => $delivery,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key_customer = 'sales_customer_' . md5(json_encode($filters_customer));

                                    $count_report_customer = Cache::remember($key_customer, 1800, function () use ($filters_customer) {

                                    return ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', DB::raw('COUNT(report_sellers.customer_id) as count_id'))
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.customer_id', 'report_sellers.purchase_order')
                                                        ->where('customers.sale_area', $filters_customer['salearea_seller'])
                                                        ->where('customers.delivery_by', $filters_customer['delivery'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters_customer['from'], $filters_customer['to']])
                                                        ->havingBetween('total_sales', [$filters_customer['range_min'], $filters_customer['range_max']])
                                                        ->get();
                                                    });
                
                                    //dd($count_report_customer);
                                    //นับจำนวนร้านค้าแบบไม่ซ้ำ;
                                    foreach($count_report_customer as $row_id) {
                        
                                        $arr_id[] = $row_id->customer_id;
                                    } 

                                    //นำตัวที่ซ้ำออก;
                                    if(isset($arr_id)) {
                                        $unique = array_unique($arr_id);
                                        $count_customer_range = count($unique);

                                    } else {
                                        $count_customer_range = 0;
                                    }
                
                                    // dd($count_customer_range);

                                    //dashboard;
                                    $filters_po = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'salearea_seller' => $salearea_seller,
                                        'delivery' => $delivery,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key_po = 'sales_po_' . md5(json_encode($filters_po));

                                    $count_po_range = Cache::remember($key_po, 1800, function () use ($filters_po) {

                                    return ReportSeller::select('purchase_order', DB::raw('SUM(price*quantity) as total_sales'))
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.purchase_order')
                                                        ->where('customers.sale_area', $filters_po['salearea_seller'])
                                                        ->where('customers.delivery_by', $filters_po['delivery'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters_po['from'], $filters_po['to']])
                                                        ->havingBetween('total_sales', [$filters_po['range_min'], $filters_po['range_max']])
                                                        ->get();
                                                    });

                                    $count_purchase_range = count($count_po_range);
                                    // dd($count_purchase_range);

                                    $filters_selling = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'salearea_seller' => $salearea_seller,
                                        'delivery' => $delivery,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key_selling = 'sales_selling_' . md5(json_encode($filters_selling));

                                    $total_report_selling = Cache::remember($key_selling, 1800, function () use ($filters_selling) {

                                    return ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order')
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.purchase_order')
                                                        ->where('customers.sale_area', $filters_selling['salearea_seller'])
                                                        ->where('customers.delivery_by', $filters_selling['delivery'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters_selling['from'], $filters_selling['to']])
                                                        ->havingBetween('total_sales', [$filters_selling['range_min'], $filters_selling['range_max']])
                                                        ->get();
                                                    });

                                    $filters = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'page' => $page,
                                        'perpage' => $perpage,
                                        'salearea_seller' => $salearea_seller,
                                        'delivery' => $delivery,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key = 'sales_report_' . md5(json_encode($filters));

                                    $report_seller = Cache::remember($key, 1800, function () use ($filters) {

                                    return ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name', 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.customer_id', 'customers.customer_name' , 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                        ->where('customers.sale_area', $filters['salearea_seller'])
                                                        ->where('customers.delivery_by', $filters['delivery'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters['from'], $filters['to']])
                                                        ->havingBetween('total_sales', [$filters['range_min'], $filters['range_max']])
                                                    /*  ->offset($start)
                                                        ->limit($perpage)
                                                        ->get(); */
                                                        ->paginate($filters['perpage'], ['*'], 'page', $filters['page']);
                                                    });

                                } else if(!empty($adminarea_seller)) {

                                    $filters_page = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'adminarea_seller' => $adminarea_seller,
                                        'delivery' => $delivery,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key_page = 'sales_page_' . md5(json_encode($filters_page));

                                    $pagination = Cache::remember($key_page, 1800, function () use ($filters_page) { 

                                    return ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', 'report_sellers.customer_id')
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.purchase_order', 'report_sellers.customer_id')
                                                        ->where('customers.admin_area', $filters_page['adminarea_seller'])
                                                        ->where('customers.delivery_by', $filters_page['delivery'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters_page['from'], $filters_page['to']])
                                                        ->havingBetween('total_sales', [$filters_page['range_min'], $filters_page['range_max']])
                                                        ->get();
                                                    });

                                    $count_page = count($pagination);
                                    // dd($count_page);

                                    $perpage = 10;
                                    $total_page = ceil($count_page / $perpage);
                                    $start = ($perpage * $page) - $perpage;

                                    $filters_customer = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'adminarea_seller' => $adminarea_seller,
                                        'delivery' => $delivery,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key_customer = 'sales_customer_' . md5(json_encode($filters_customer));

                                    $count_report_customer = Cache::remember($key_customer, 1800, function () use ($filters_customer) { 

                                    return ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', DB::raw('COUNT(report_sellers.customer_id) as count_id'))
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.customer_id', 'report_sellers.purchase_order')
                                                            ->where('customers.admin_area', $filters_customer['adminarea_seller'])
                                                            ->where('customers.delivery_by', $filters_customer['delivery'])
                                                            ->whereBetween('report_sellers.date_purchase', [$filters_customer['from'], $filters_customer['to']])
                                                            ->havingBetween('total_sales', [$filters_customer['range_min'], $filters_customer['range_max']])
                                                            ->get();
                                                        });
                
                                    //dd($count_report_customer);
                                    //นับจำนวนร้านค้าแบบไม่ซ้ำ;
                                    foreach($count_report_customer as $row_id) {
                        
                                        $arr_id[] = $row_id->customer_id;
                                    } 

                                    //นำตัวที่ซ้ำออก;
                                    if(isset($arr_id)) {
                                        $unique = array_unique($arr_id);
                                        $count_customer_range = count($unique);

                                    } else {
                                        $count_customer_range = 0;
                                    }
                
                                    // dd($count_customer_range);

                                    //dashboard;
                                    $filters_po = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'adminarea_seller' => $adminarea_seller,
                                        'delivery' => $delivery,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key_po = 'sales_po_' . md5(json_encode($filters_po));

                                    $count_po_range = Cache::remember($key_po, 1800, function () use ($filters_po) { 

                                    return ReportSeller::select('purchase_order', DB::raw('SUM(price*quantity) as total_sales'))
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.purchase_order')
                                                        ->where('customers.admin_area', $filters_po['adminarea_seller'])
                                                        ->where('customers.delivery_by', $filters_po['delivery'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters_po['from'], $filters_po['to']])
                                                        ->havingBetween('total_sales', [$filters_po['range_min'], $filters_po['range_max']])
                                                        ->get();
                                                    });

                                    $count_purchase_range = count($count_po_range);
                                    // dd($count_purchase_range);

                                    $filters_selling = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'adminarea_seller' => $adminarea_seller,
                                        'delivery' => $delivery,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key_selling = 'sales_selling_' . md5(json_encode($filters_selling));

                                    $total_report_selling =  Cache::remember($key_selling, 1800, function () use ($filters_selling) { 

                                    return ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order')
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.purchase_order')
                                                        ->where('customers.admin_area', $filters_selling['adminarea_seller'])
                                                        ->where('customers.delivery_by', $filters_selling['delivery'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters_selling['from'], $filters_selling['to']])
                                                        ->havingBetween('total_sales', [$filters_selling['range_min'], $filters_selling['range_max']])
                                                        ->get();
                                                    });

                                    $filters = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'page' => $page,
                                        'perpage' => $perpage,
                                        'adminarea_seller' => $adminarea_seller,
                                        'delivery' => $delivery,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key = 'sales_report_' . md5(json_encode($filters));

                                    $report_seller = Cache::remember($key, 1800, function () use ($filters) { 

                                    return ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name', 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.customer_id', 'customers.customer_name' , 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->where('customers.admin_area', $filters['adminarea_seller'])
                                                    ->where('customers.delivery_by', $filters['delivery'])
                                                    ->whereBetween('report_sellers.date_purchase', [$filters['from'], $filters['to']])
                                                    ->havingBetween('total_sales', [$filters['range_min'], $filters['range_max']])
                                                  /*   ->offset($start)
                                                    ->limit($perpage)
                                                    ->get(); */
                                                    ->paginate($filters['perpage'], ['*'], 'page', $filters['page']);
                                                });
                                
                                } else {

                                    $filters_page = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'delivery' => $delivery,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key_page = 'sales_page_' . md5(json_encode($filters_page));

                                    $pagination = Cache::remember($key_page, 1800, function () use ($filters_page) {

                                    return ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', 'report_sellers.customer_id')
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('purchase_order', 'customer_id')
                                                        ->where('customers.delivery_by', $filters_page['delivery'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters_page['from'], $filters_page['to']])
                                                        ->havingBetween('total_sales', [$filters_page['range_min'], $filters_page['range_max']])
                                                        ->get();
                                                    });

                                    $count_page = count($pagination);
                                    // dd($count_page);

                                    $perpage = 10;
                                    $total_page = ceil($count_page / $perpage);
                                    $start = ($perpage * $page) - $perpage;

                                    $filters_customer = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'delivery' => $delivery,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key_customer = 'sales_customer_' . md5(json_encode($filters_customer));

                                    $count_report_customer = Cache::remember($key_customer, 1800, function () use ($filters_customer) {

                                    return ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', DB::raw('COUNT(report_sellers.customer_id) as count_id'))
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.customer_id', 'report_sellers.purchase_order')
                                                        ->where('customers.delivery_by', $filters_customer['delivery'])
                                                        ->whereBetween('date_purchase', [$filters_customer['from'], $filters_customer['to']])
                                                        ->havingBetween('total_sales', [$filters_customer['range_min'], $filters_customer['range_max']])
                                                        ->get();
                                                    });
                
                                    //dd($count_report_customer);
                                    //นับจำนวนร้านค้าแบบไม่ซ้ำ;
                                    foreach($count_report_customer as $row_id) {
                        
                                        $arr_id[] = $row_id->customer_id;
                                    } 

                                    //นำตัวที่ซ้ำออก;
                                    if(isset($arr_id)) {
                                        $unique = array_unique($arr_id);
                                        $count_customer_range = count($unique);

                                    } else {
                                        $count_customer_range = 0;
                                    }
                
                                    // dd($count_customer_range);

                                    //dashboard;
                                    $filters_po = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'delivery' => $delivery,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key_po = 'sales_po_' . md5(json_encode($filters_po));

                                    $count_po_range = Cache::remember($key_po, 1800, function () use ($filters_po) {

                                    return ReportSeller::select('purchase_order', DB::raw('SUM(price*quantity) as total_sales'))
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.purchase_order')
                                                        ->where('customers.delivery_by', $filters_po['delivery'])
                                                        ->whereBetween('date_purchase', [$filters_po['from'], $filters_po['to']])
                                                        ->havingBetween('total_sales', [$filters_po['range_min'], $filters_po['range_max']])
                                                        ->get();
                                                    });

                                    $count_purchase_range = count($count_po_range);
                                    // dd($count_purchase_range);

                                    $filters_selling = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'delivery' => $delivery,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key_selling = 'sales_selling_' . md5(json_encode($filters_selling));

                                    $total_report_selling = Cache::remember($key_selling, 1800, function () use ($filters_selling) {

                                    return ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order')
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.purchase_order')
                                                        ->where('customers.delivery_by', $filters_selling['delivery'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters_selling['from'], $filters_selling['to']])
                                                        ->havingBetween('total_sales', [$filters_selling['range_min'], $filters_selling['range_max']])
                                                        ->get();
                                                    });

                                    $filters = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'page' => $page,
                                        'perpage' => $perpage,
                                        'delivery' => $delivery,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key = 'sales_report_' . md5(json_encode($filters));

                                    $report_seller = Cache::remember($key, 1800, function () use ($filters) {

                                    return ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name', 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.customer_id', 'customers.customer_name' , 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                        ->where('customers.delivery_by', $filters['delivery'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters['from'], $filters['to']])
                                                        ->havingBetween('total_sales', [$filters['range_min'], $filters['range_max']])
                                                    /*  ->offset($start)
                                                        ->limit($perpage)
                                                        ->get(); */
                                                        ->paginate($filters['perpage'], ['*'], 'page', $filters['page']);
                                                    });
                                }

                            } else {

                                //not delivery and region;
                                if(!empty($salearea_seller && !empty($adminarea_seller))) {

                                    $filters_page = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'adminarea_seller' => $adminarea_seller,
                                        'salearea_seller' => $salearea_seller,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key_page = 'sales_page_' . md5(json_encode($filters_page));

                                    $pagination = Cache::remember($key_page, 1800, function () use ($filters_page) {

                                    return ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', 'report_sellers.customer_id')
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.purchase_order', 'report_sellers.customer_id')
                                                        ->where('customers.sale_area', $filters_page['salearea_seller'])
                                                        ->where('customers.admin_area', $filters_page['adminarea_seller'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters_page['from'], $filters_page['to']])
                                                        ->havingBetween('total_sales', [$filters_page['range_min'], $filters_page['range_max']])
                                                        // ->where('customers.delivery_by', $delivery)
                                                        /*  ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                        ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                        ->get();
                                                    });

                                    $count_page = count($pagination);
                                    // dd($count_page);

                                    $perpage = 10;
                                    $total_page = ceil($count_page / $perpage);
                                    $start = ($perpage * $page) - $perpage;

                                    $filters_customer = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'adminarea_seller' => $adminarea_seller,
                                        'salearea_seller' => $salearea_seller,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key_customer = 'sales_customer_' . md5(json_encode($filters_customer));

                                    $count_report_customer = Cache::remember($key_customer, 1800, function () use ($filters_customer) {

                                    return ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', DB::raw('COUNT(report_sellers.customer_id) as count_id'))
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.customer_id', 'report_sellers.purchase_order')
                                                        ->where('customers.sale_area', $filters_customer['salearea_seller'])
                                                        ->where('customers.admin_area', $filters_customer['adminarea_seller'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters_customer['from'], $filters_customer['to']])
                                                        ->havingBetween('total_sales', [$filters_customer['range_min'], $filters_customer['range_max']])
                                                        // ->where('customers.delivery_by', $delivery)
                                                        /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                        ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                        ->get();
                                                    });
                                        
                                                            //dd($count_report_customer);
                                                            //นับจำนวนร้านค้าแบบไม่ซ้ำ;
                                                            foreach($count_report_customer as $row_id) {
                                                
                                                                $arr_id[] = $row_id->customer_id;
                                                            } 

                                                            //นำตัวที่ซ้ำออก;
                                                            if(isset($arr_id)) {
                                                                $unique = array_unique($arr_id);
                                                                $count_customer_range = count($unique);

                                                            } else {
                                                                $count_customer_range = 0;
                                                            }
                                        
                                    // dd($count_customer_range);

                                    //dashboard;
                                    $filters_po = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'adminarea_seller' => $adminarea_seller,
                                        'salearea_seller' => $salearea_seller,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key_po = 'sales_po_' . md5(json_encode($filters_po));

                                    $count_po_range = Cache::remember($key_po, 1800, function () use ($filters_po) {

                                    return ReportSeller::select('purchase_order', DB::raw('SUM(price*quantity) as total_sales'))
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.purchase_order')
                                                        ->where('customers.sale_area', $filters_po['salearea_seller'])
                                                        ->where('customers.admin_area', $filters_po['adminarea_seller'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters_po['from'], $filters_po['to']])
                                                        ->havingBetween('total_sales', [$filters_po['range_min'], $filters_po['range_max']])
                                                        // ->where('customers.delivery_by', $delivery)
                                                        /*  ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                        ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                        ->get();
                                                    });

                                    $count_purchase_range = count($count_po_range);
                                    // dd($count_purchase_range);

                                    $filters_selling = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'adminarea_seller' => $adminarea_seller,
                                        'salearea_seller' => $salearea_seller,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key_selling = 'sales_selling_' . md5(json_encode($filters_selling));

                                    $total_report_selling = Cache::remember($key_selling, 1800, function () use ($filters_selling) {

                                    return ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'purchase_order')
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('purchase_order')
                                                        ->where('customers.sale_area', $filters_selling['salearea_seller'])
                                                        ->where('customers.admin_area', $filters_selling['adminarea_seller'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters_selling['from'], $filters_selling['to']])
                                                        ->havingBetween('total_sales', [$filters_selling['range_min'], $filters_selling['range_max']])
                                                        // ->where('customers.delivery_by', $delivery)
                                                        /*  ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                        ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                        ->get();
                                                    });

                                    $filters = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'page' => $page,
                                        'perpage' => $perpage,
                                        'adminarea_seller' => $adminarea_seller,
                                        'salearea_seller' => $salearea_seller,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key = 'sales_report_' . md5(json_encode($filters));

                                    $report_seller = Cache::remember($key, 1800, function () use ($filters) {

                                    return ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name', 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.customer_id', 'customers.customer_name' , 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                        ->where('customers.sale_area', $filters['salearea_seller'])
                                                        ->where('customers.admin_area', $filters['adminarea_seller'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters['from'], $filters['to']])
                                                        ->havingBetween('total_sales', [$filters['range_min'], $filters['range_max']])
                                                        // ->where('customers.delivery_by', $delivery)
                                                        /*  ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                        ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                    /*  ->offset($start)
                                                        ->limit($perpage)
                                                        ->get(); */
                                                        ->paginate($filters['perpage'], ['*'], 'page', $filters['page']);
                                                    });
                        
                                } else if(!empty($salearea_seller)) {

                                    $filters_page = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'salearea_seller' => $salearea_seller,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key_page = 'sales_page_' . md5(json_encode($filters_page));

                                    $pagination = Cache::remember($key_page, 1800, function () use ($filters_page) {

                                    return ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', 'report_sellers.customer_id')
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.purchase_order', 'report_sellers.customer_id')
                                                        ->where('customers.sale_area', $filters_page['salearea_seller'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters_page['from'], $filters_page['to']])
                                                        ->havingBetween('total_sales', [$filters_page['range_min'], $filters_page['range_max']])
                                                        // ->where('customers.delivery_by', $delivery)
                                                        /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                        ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                        ->get();
                                                    });

                                    $count_page = count($pagination);
                                    // dd($count_page);

                                    $perpage = 10;
                                    $total_page = ceil($count_page / $perpage);
                                    $start = ($perpage * $page) - $perpage;

                                    $filters_customer = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'salearea_seller' => $salearea_seller,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key_customer = 'sales_customer_' . md5(json_encode($filters_customer));

                                    $count_report_customer = Cache::remember($key_customer, 1800, function () use ($filters_customer) {

                                    return ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', DB::raw('COUNT(report_sellers.customer_id) as count_id'))
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.customer_id', 'report_sellers.purchase_order')
                                                        ->where('customers.sale_area', $filters_customer['salearea_seller'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters_customer['from'], $filters_customer['to']])
                                                        ->havingBetween('total_sales', [$filters_customer['range_min'], $filters_customer['range_max']])
                                                        // ->where('customers.delivery_by', $delivery)
                                                        /*  ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                        ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                        ->get();
                                                    });
                
                                    //dd($count_report_customer);
                                    //นับจำนวนร้านค้าแบบไม่ซ้ำ;
                                    foreach($count_report_customer as $row_id) {
                        
                                        $arr_id[] = $row_id->customer_id;
                                    } 

                                    //นำตัวที่ซ้ำออก;
                                    if(isset($arr_id)) {
                                        $unique = array_unique($arr_id);
                                        $count_customer_range = count($unique);

                                    } else {
                                        $count_customer_range = 0;
                                    }
                
                                    // dd($count_customer_range);

                                    //dashboard;
                                    $filters_po = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'salearea_seller' => $salearea_seller,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key_po = 'sales_po_' . md5(json_encode($filters_po));

                                    $count_po_range = Cache::remember($key_po, 1800, function () use ($filters_po) {

                                    return ReportSeller::select('purchase_order', DB::raw('SUM(price*quantity) as total_sales'))
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.purchase_order')
                                                        ->where('customers.sale_area', $filters_po['salearea_seller'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters_po['from'], $filters_po['to']])
                                                        ->havingBetween('total_sales', [$filters_po['range_min'], $filters_po['range_max']])
                                                        // ->where('customers.delivery_by', $delivery)
                                                        /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                        ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                        ->get();
                                                    });

                                    $count_purchase_range = count($count_po_range);
                                    // dd($count_purchase_range);
                                    $filters_selling = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'salearea_seller' => $salearea_seller,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key_selling = 'sales_selling_' . md5(json_encode($filters_selling));

                                    $total_report_selling = Cache::remember($key_selling, 1800, function () use ($filters_selling) {

                                    return ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order')
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.purchase_order')
                                                        ->where('customers.sale_area', $filters_selling['salearea_seller'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters_selling['from'], $filters_selling['to']])
                                                        ->havingBetween('total_sales', [$filters_selling['range_min'], $filters_selling['range_max']]) 
                                                        // ->where('customers.delivery_by', $delivery)
                                                        /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                        ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                        ->get();
                                                    });


                                    $filters = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'page' => $page,
                                        'perpage' => $perpage,
                                        'salearea_seller' => $salearea_seller,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key = 'sales_report_' . md5(json_encode($filters));

                                    $report_seller = Cache::remember($key, 1800, function () use ($filters) {

                                    return ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name', 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.customer_id', 'customers.customer_name' , 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->where('customers.sale_area', $filters['salearea_seller'])
                                                    ->whereBetween('report_sellers.date_purchase', [$filters['from'], $filters['to']])
                                                    ->havingBetween('total_sales', [$filters['range_min'], $filters['range_max']])
                                                    // ->where('customers.delivery_by', $delivery)
                                                    /*  ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                   /*  ->offset($start)
                                                    ->limit($perpage)
                                                    ->get(); */
                                                    ->paginate($filters['perpage'], ['*'], 'page', $filters['page']);
                                                });

                                } else if(!empty($adminarea_seller)) {

                                    $filters_page = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'adminarea_seller' => $adminarea_seller,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key_page = 'sales_page_' . md5(json_encode($filters_page));

                                    $pagination = Cache::remember($key_page, 1800, function () use ($filters_page) {

                                    return ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', 'report_sellers.customer_id')
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.purchase_order', 'report_sellers.customer_id')
                                                        ->where('customers.admin_area', $filters_page['adminarea_seller'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters_page['from'], $filters_page['to']])
                                                        ->havingBetween('total_sales', [$filters_page['range_min'], $filters_page['range_max']])
                                                        // ->where('customers.delivery_by', $delivery)
                                                        /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                        ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                        ->get();
                                                    });

                                    $count_page = count($pagination);
                                    // dd($count_page);

                                    $perpage = 10;
                                    $total_page = ceil($count_page / $perpage);
                                    $start = ($perpage * $page) - $perpage;

                                    $filters_customer = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'adminarea_seller' => $adminarea_seller,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key_customer = 'sales_customer_' . md5(json_encode($filters_customer));

                                    $count_report_customer = Cache::remember($key_customer, 1800, function () use ($filters_customer) {

                                    return ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', DB::raw('COUNT(report_sellers.customer_id) as count_id'))
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.customer_id', 'report_sellers.purchase_order')
                                                            ->where('customers.admin_area', $filters_customer['adminarea_seller'])
                                                            ->whereBetween('report_sellers.date_purchase', [$filters_customer['from'], $filters_customer['to']])
                                                            ->havingBetween('total_sales', [$filters_customer['range_min'], $filters_customer['range_max']])
                                                            // ->where('customers.delivery_by', $delivery)
                                                            /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                            ->get();
                                                        });
                
                                    //dd($count_report_customer);
                                    //นับจำนวนร้านค้าแบบไม่ซ้ำ;
                                    foreach($count_report_customer as $row_id) {
                        
                                        $arr_id[] = $row_id->customer_id;
                                    } 

                                    //นำตัวที่ซ้ำออก;
                                    if(isset($arr_id)) {
                                        $unique = array_unique($arr_id);
                                        $count_customer_range = count($unique);

                                    } else {
                                        $count_customer_range = 0;
                                    }
                
                                    // dd($count_customer_range);

                                    //dashboard;
                                    $filters_po = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'adminarea_seller' => $adminarea_seller,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key_po = 'sales_po_' . md5(json_encode($filters_po));

                                    $count_po_range = Cache::remember($key_po, 1800, function () use ($filters_po) {

                                    return ReportSeller::select('purchase_order', DB::raw('SUM(price*quantity) as total_sales'))
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.purchase_order')
                                                    ->where('customers.admin_area', $filters_po['adminarea_seller'])
                                                    ->whereBetween('report_sellers.date_purchase', [$filters_po['from'], $filters_po['to']])
                                                    ->havingBetween('total_sales', [$filters_po['range_min'], $filters_po['range_max']])
                                                    // ->where('customers.delivery_by', $delivery)
                                                    /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                    ->get();
                                                });

                                    $count_purchase_range = count($count_po_range);
                                    // dd($count_purchase_range);

                                    $filters_selling = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'adminarea_seller' => $adminarea_seller,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key_selling = 'sales_selling_' . md5(json_encode($filters_selling));

                                    $total_report_selling = Cache::remember($key_selling, 1800, function () use ($filters_selling) {

                                    return ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order')
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.purchase_order')
                                                            ->where('customers.admin_area', $filters_selling['adminarea_seller'])
                                                            ->whereBetween('report_sellers.date_purchase', [$filters_selling['from'], $filters_selling['to']])
                                                            ->havingBetween('total_sales', [$filters_selling['range_min'], $filters_selling['range_max']]) 
                                                            // ->where('customers.delivery_by', $delivery)
                                                            /*  ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                            ->get();
                                                        });

                                    $filters = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'page' => $page,
                                        'perpage' => $perpage,
                                        'adminarea_seller' => $adminarea_seller,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key = 'sales_report_' . md5(json_encode($filters));

                                    $report_seller = Cache::remember($key, 1800, function () use ($filters) {

                                    return ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name', 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.customer_id', 'customers.customer_name' , 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->where('customers.admin_area', $filters['adminarea_seller'])
                                                    ->whereBetween('report_sellers.date_purchase', [$filters['from'], $filters['to']])
                                                    ->havingBetween('total_sales', [$filters['range_min'], $filters['range_max']])
                                                    // ->where('customers.delivery_by', $delivery)
                                                    /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                  /*   ->offset($start)
                                                    ->limit($perpage)
                                                    ->get(); */
                                                    ->paginate($filters['perpage'], ['*'], 'page', $filters['page']);
                                                });
                                
                                } else {

                                    // dd('dd');
                                    $filters_page = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key_page = 'sales_page_' . md5(json_encode($filters_page));

                                    $pagination = Cache::remember($key_page, 1800, function () use ($filters_page) {

                                    return ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->join('customers', function (JoinClause $join) {
                                                    $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                })
                                                ->groupBy('purchase_order', 'customer_id')
                                                ->whereBetween('report_sellers.date_purchase', [$filters_page['from'], $filters_page['to']])
                                                ->havingBetween('total_sales', [$filters_page['range_min'], $filters_page['range_max']])
                                                // ->where('customers.delivery_by', $delivery)
                                                /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                ->get();
                                            });

                                    $count_page = count($pagination);
                                    // dd($count_page);

                                    $perpage = 10;
                                    $total_page = ceil($count_page / $perpage);
                                    $start = ($perpage * $page) - $perpage;

                                    $filters_customer = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key_customer = 'sales_customer_' . md5(json_encode($filters_customer));

                                    $count_report_customer = Cache::remember($key_customer, 1800, function () use ($filters_customer) {

                                    return ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', DB::raw('COUNT(report_sellers.customer_id) as count_id'))
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.customer_id', 'report_sellers.purchase_order')
                                                            ->whereBetween('date_purchase', [$filters_customer['from'], $filters_customer['to']])
                                                            ->havingBetween('total_sales', [$filters_customer['range_min'], $filters_customer['range_max']])
                                                            // ->where('customers.delivery_by', $delivery)
                                                            /* ->whereBetween('date_purchase', [$request->from, $request->to])
                                                            ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                            ->get();
                                                        });
                
                                    //dd($count_report_customer);
                                    //นับจำนวนร้านค้าแบบไม่ซ้ำ;
                                    foreach($count_report_customer as $row_id) {
                        
                                        $arr_id[] = $row_id->customer_id;
                                    } 

                                    //นำตัวที่ซ้ำออก;
                                    if(isset($arr_id)) {
                                        $unique = array_unique($arr_id);
                                        $count_customer_range = count($unique);

                                    } else {
                                        $count_customer_range = 0;
                                    }
                
                                    // dd($count_customer_range);

                                    //dashboard;
                                    $filters_po = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key_po = 'sales_po_' . md5(json_encode($filters_po));

                                    $count_po_range = Cache::remember($key_po, 1800, function () use ($filters_po) {

                                    return ReportSeller::select('purchase_order', DB::raw('SUM(price*quantity) as total_sales'))
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.purchase_order')
                                                    ->whereBetween('date_purchase', [$filters_po['from'], $filters_po['to']])
                                                    ->havingBetween('total_sales', [$filters_po['range_min'], $filters_po['range_max']])
                                                    // ->where('customers.delivery_by', $delivery)
                                                    /* ->whereBetween('date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                    ->get();
                                                });

                                    $count_purchase_range = count($count_po_range);
                                    // dd($count_purchase_range);

                                    $filters_selling = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key_selling = 'sales_selling_' . md5(json_encode($filters_selling));

                                    $total_report_selling = Cache::remember($key_selling, 1800, function () use ($filters_selling) {

                                    return ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order')
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.purchase_order')
                                                            ->whereBetween('report_sellers.date_purchase', [$filters_selling['from'], $filters_selling['to']])
                                                            ->havingBetween('total_sales', [$filters_selling['range_min'], $filters_selling['range_max']])
                                                            // ->where('customers.delivery_by', $delivery)
                                                            /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                            ->get();
                                                        });

                                    $filters = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'page' => $page,
                                        'perpage' => $perpage,
                                        'range_min' => $range_min,
                                        'range_max' => $range_max,
                                        ];

                                    $key = 'sales_report_' . md5(json_encode($filters));

                                    $report_seller = Cache::remember($key, 1800, function () use ($filters) {

                                    return ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name', 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.customer_id', 'customers.customer_name' , 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                        ->whereBetween('report_sellers.date_purchase', [$filters['from'], $filters['to']])
                                                        ->havingBetween('total_sales', [$filters['range_min'], $filters['range_max']])
                                                        // ->where('customers.delivery_by', $delivery)
                                                        /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                        ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                    /*  ->offset($start)
                                                        ->limit($perpage)
                                                        ->get(); */
                                                        ->paginate($filters['perpage'], ['*'], 'page', $filters['page']);
                                                    });
                                }
                            }

                        
                        
                        $customers_data = Customer::select('customer_id', 'sale_area', 'admin_area')->get();
                        $customers_customer_name = Customer::select('customer_id', 'customer_name')->get();

                        return view('report/seller', compact('check_from','check_to', 'admin_area', 'report_seller', 'start', 'total_page', 'page', 'status_alert', 'status_waiting','status_registration', 'status_updated', 'user_id_admin',
                        'count_customer_range', 'count_purchase_range', 'customers_customer_name', 'total_report_selling', 'customers_data','sale_area'));
                   
                    } else {

                        //แสดงข้อมูลลูกค้า;
                        // dd('no sale');
      
                            if(!empty($region) && !empty($delivery)) 
                            {
                                //code check region and delivery;
                                if(!empty($salearea_seller && !empty($adminarea_seller))) {

                                    $filters_page = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'salearea_seller' => $salearea_seller,
                                        'adminarea_seller' => $adminarea_seller,
                                        'region' => $region,
                                        'delivery' => $delivery,
                                        ];

                                    $key_page = 'sales_page_' . md5(json_encode($filters_page));

                                    $pagination = Cache::remember($key_page, 1800, function () use ($filters_page) {

                                    return ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->join('customers', function (JoinClause $join) {
                                                    $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                })
                                                ->groupBy('report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->where('customers.sale_area', $filters_page['salearea_seller'])
                                                ->where('customers.admin_area', $filters_page['adminarea_seller'])
                                                ->where('customers.geography', $filters_page['region'])
                                                ->where('customers.delivery_by', $filters_page['delivery'])
                                                ->whereBetween('report_sellers.date_purchase', [$filters_page['from'], $filters_page['to']])
                                                // ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                // ->havingBetween('total_sales', [$range_min, $range_max])
                                                ->get();
                                            });

                                    $count_page = count($pagination);
                                    // dd($count_page);

                                    $perpage = 10;
                                    $total_page = ceil($count_page / $perpage);
                                    $start = ($perpage * $page) - $perpage;

                                    $filters_customer = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'salearea_seller' => $salearea_seller,
                                        'adminarea_seller' => $adminarea_seller,
                                        'region' => $region,
                                        'delivery' => $delivery,
                                        ];

                                    $key_customer = 'sales_customer_' . md5(json_encode($filters_customer));

                                    $count_report_customer = Cache::remember($key_customer, 1800, function () use ($filters_customer) {

                                    return ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', DB::raw('COUNT(report_sellers.customer_id) as count_id'))
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.customer_id', 'report_sellers.purchase_order')
                                                            ->where('customers.sale_area', $filters_customer['salearea_seller'])
                                                            ->where('customers.admin_area', $filters_customer['adminarea_seller'])
                                                            ->where('customers.geography', $filters_customer['region'])
                                                            ->where('customers.delivery_by', $filters_customer['delivery'])
                                                            ->whereBetween('report_sellers.date_purchase', [$filters_customer['from'], $filters_customer['to']])
                                                            // ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            // ->havingBetween('total_sales', [$range_min, $range_max])
                                                            ->get();
                                                        });
                                        
                                                            //dd($count_report_customer);
                                                            //นับจำนวนร้านค้าแบบไม่ซ้ำ;
                                                            foreach($count_report_customer as $row_id) {
                                                
                                                                $arr_id[] = $row_id->customer_id;
                                                            } 

                                                            //นำตัวที่ซ้ำออก;
                                                            if(isset($arr_id)) {
                                                                $unique = array_unique($arr_id);
                                                                $count_customer_range = count($unique);

                                                            } else {
                                                                $count_customer_range = 0;
                                                            }
                                        
                                        // dd($count_customer_range);

                                    //dashboard;
                                    $filters_po = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'salearea_seller' => $salearea_seller,
                                        'adminarea_seller' => $adminarea_seller,
                                        'region' => $region,
                                        'delivery' => $delivery,
                                        ];

                                    $key_po = 'sales_po_' . md5(json_encode($filters_po));

                                    $count_po_range = Cache::remember($key_po, 1800, function () use ($filters_po) {

                                    return ReportSeller::select('purchase_order', DB::raw('SUM(price*quantity) as total_sales'))
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.purchase_order')
                                                    ->where('customers.sale_area', $filters_po['salearea_seller'])
                                                    ->where('customers.admin_area', $filters_po['adminarea_seller'])
                                                    ->where('customers.geography', $filters_po['region'])
                                                    ->where('customers.delivery_by', $filters_po['delivery'])
                                                    ->whereBetween('report_sellers.date_purchase', [$filters_po['from'], $filters_po['to']])
                                                    // ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    // ->havingBetween('total_sales', [$range_min, $range_max])
                                                    ->get();
                                                });

                                    $count_purchase_range = count($count_po_range);
                                    // dd($count_purchase_range);

                                    $filters_selling = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'salearea_seller' => $salearea_seller,
                                        'adminarea_seller' => $adminarea_seller,
                                        'region' => $region,
                                        'delivery' => $delivery,
                                        ];

                                    $key_selling = 'sales_selling_' . md5(json_encode($filters_selling));

                                    $total_report_selling = Cache::remember($key_selling, 1800, function () use ($filters_selling) {

                                    return ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order')
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.purchase_order')
                                                        ->where('customers.sale_area', $filters_selling['salearea_seller'])
                                                        ->where('customers.admin_area', $filters_selling['adminarea_seller'])
                                                        ->where('customers.geography', $filters_selling['region'])
                                                        ->where('customers.delivery_by', $filters_selling['delivery'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters_selling['from'], $filters_selling['to']])
                                                        // ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                        // ->havingBetween('total_sales', [$range_min, $range_max])
                                                        ->get();
                                                    });

                                    // dd($total_report_selling);
                                    $filters = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'page' => $page,
                                        'perpage' => $perpage,
                                        'salearea_seller' => $salearea_seller,
                                        'adminarea_seller' => $adminarea_seller,
                                        'region' => $region,
                                        'delivery' => $delivery,
                                        ];

                                    $key = 'sales_report_' . md5(json_encode($filters));

                                    $report_seller = Cache::remember($key, 1800, function () use ($filters) {

                                    return ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name', 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.customer_id', 'customers.customer_name' , 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->where('customers.sale_area', $filters['salearea_seller'])
                                                    ->where('customers.admin_area', $filters['adminarea_seller'])
                                                    ->where('customers.geography', $filters['region'])
                                                    ->where('customers.delivery_by', $filters['delivery'])
                                                    ->whereBetween('report_sellers.date_purchase', [$filters['from'], $filters['to']])
                                                    // ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    // ->havingBetween('total_sales', [$range_min, $range_max])
                                                   /*  ->offset($start)
                                                    ->limit($perpage)
                                                    ->get(); */
                                                    ->paginate($filters['perpage'], ['*'], 'page', $filters['page']);
                                                });
                        
                                } else if(!empty($salearea_seller)) {

                                    $filters_page = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'salearea_seller' => $salearea_seller,
                                        'region' => $region,
                                        'delivery' => $delivery,
                                        ];

                                    $key_page = 'sales_page_' . md5(json_encode($filters_page));

                                    $pagination = Cache::remember($key_page, 1800, function () use ($filters_page) {

                                    return ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', 'report_sellers.customer_id')
                                                                ->join('customers', function (JoinClause $join) {
                                                                    $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                                })
                                                                ->groupBy('report_sellers.purchase_order', 'report_sellers.customer_id')
                                                                ->where('customers.sale_area', $filters_page['salearea_seller'])
                                                                ->where('customers.geography', $filters_page['region'])
                                                                ->where('customers.delivery_by', $filters_page['delivery'])
                                                                ->whereBetween('report_sellers.date_purchase', [$filters_page['from'], $filters_page['to']])
                                                                ->get();
                                                            });

                                    $count_page = count($pagination);
                                    // dd($count_page);

                                    $perpage = 10;
                                    $total_page = ceil($count_page / $perpage);
                                    $start = ($perpage * $page) - $perpage;

                                    $filters_customer = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'salearea_seller' => $salearea_seller,
                                        'region' => $region,
                                        'delivery' => $delivery,
                                        ];

                                    $key_customer = 'sales_customer_' . md5(json_encode($filters_customer));

                                    $count_report_customer = Cache::remember($key_customer, 1800, function () use ($filters_customer) {

                                    return ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', DB::raw('COUNT(report_sellers.customer_id) as count_id'))
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.customer_id', 'report_sellers.purchase_order')
                                                            ->where('customers.sale_area', $filters_customer['salearea_seller'])
                                                            ->where('customers.geography', $filters_customer['region'])
                                                            ->where('customers.delivery_by', $filters_customer['delivery'])
                                                            ->whereBetween('report_sellers.date_purchase', [$filters_customer['from'], $filters_customer['to']])
                                                            ->get();
                                                        });
                
                                    //dd($count_report_customer);
                                    //นับจำนวนร้านค้าแบบไม่ซ้ำ;
                                    foreach($count_report_customer as $row_id) {
                        
                                        $arr_id[] = $row_id->customer_id;
                                    } 

                                    //นำตัวที่ซ้ำออก;
                                    if(isset($arr_id)) {
                                        $unique = array_unique($arr_id);
                                        $count_customer_range = count($unique);

                                    } else {
                                        $count_customer_range = 0;
                                    }
                
                                        // dd($count_customer_range);

                                    //dashboard;
                                    $filters_po = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'salearea_seller' => $salearea_seller,
                                        'region' => $region,
                                        'delivery' => $delivery,
                                        ];

                                    $key_po = 'sales_po_' . md5(json_encode($filters_po));

                                    $count_po_range = Cache::remember($key_po, 1800, function () use ($filters_po) {

                                    return ReportSeller::select('purchase_order', DB::raw('SUM(price*quantity) as total_sales'))
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.purchase_order')
                                                    ->where('customers.sale_area', $filters_po['salearea_seller'])
                                                    ->where('customers.geography', $filters_po['region'])
                                                    ->where('customers.delivery_by', $filters_po['delivery'])
                                                    ->whereBetween('report_sellers.date_purchase', [$filters_po['from'], $filters_po['to']])
                                                    ->get();
                                                });

                                    $count_purchase_range = count($count_po_range);
                                    // dd($count_purchase_range);

                                    $filters_selling = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'salearea_seller' => $salearea_seller,
                                        'region' => $region,
                                        'delivery' => $delivery,
                                        ];

                                    $key_selling = 'sales_selling_' . md5(json_encode($filters_selling));

                                    $total_report_selling = Cache::remember($key_selling, 1800, function () use ($filters_selling) {

                                    return ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order')
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.purchase_order')
                                                            ->where('customers.sale_area', $filters_selling['salearea_seller'])
                                                            ->where('customers.geography', $filters_selling['region'])
                                                            ->where('customers.delivery_by', $filters_selling['delivery'])
                                                            ->whereBetween('report_sellers.date_purchase', [$filters_selling['from'], $filters_selling['to']])
                                                            ->get();
                                                        });

                                    $filters = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'page' => $page,
                                        'perpage' => $perpage,
                                        'salearea_seller' => $salearea_seller,
                                        'region' => $region,
                                        'delivery' => $delivery,
                                        ];

                                    $key = 'sales_report_' . md5(json_encode($filters));

                                    $report_seller = Cache::remember($key, 1800, function () use ($filters) {

                                    return ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name', 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.customer_id', 'customers.customer_name' , 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->where('customers.sale_area', $filters['salearea_seller'])
                                                    ->where('customers.geography', $filters['region'])
                                                    ->where('customers.delivery_by', $filters['delivery'])
                                                    ->whereBetween('report_sellers.date_purchase', [$filters['from'], $filters['to']])
                                                    /* ->offset($start)
                                                    ->limit($perpage)
                                                    ->get(); */
                                                    ->paginate($filters['perpage'], ['*'], 'page', $filters['page']);
                                                });

                                } else if(!empty($adminarea_seller)) {

                                    // dd('dd');
                                    $filters_page = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'adminarea_seller' => $adminarea_seller,
                                        'region' => $region,
                                        'delivery' => $delivery,
                                        ];

                                    $key_page = 'sales_page_' . md5(json_encode($filters_page));

                                    $pagination = Cache::remember($key_page, 1800, function () use ($filters_page) {

                                    return ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', 'report_sellers.customer_id')
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.purchase_order', 'report_sellers.customer_id')
                                                        ->where('customers.admin_area', $filters_page['adminarea_seller'])
                                                        ->where('customers.geography', $filters_page['region'])
                                                        ->where('customers.delivery_by', $filters_page['delivery'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters_page['from'], $filters_page['to']])
                                                        ->get();
                                                    });

                                    $count_page = count($pagination);
                                    // dd($count_page);

                                    $perpage = 10;
                                    $total_page = ceil($count_page / $perpage);
                                    $start = ($perpage * $page) - $perpage;

                                    $filters_customer = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'adminarea_seller' => $adminarea_seller,
                                        'region' => $region,
                                        'delivery' => $delivery,
                                        ];

                                    $key_customer = 'sales_customer_' . md5(json_encode($filters_customer));

                                    $count_report_customer = Cache::remember($key_customer, 1800, function () use ($filters_customer) {

                                    return ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', DB::raw('COUNT(report_sellers.customer_id) as count_id'))
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.customer_id', 'report_sellers.purchase_order')
                                                        ->where('customers.admin_area', $filters_customer['adminarea_seller'])
                                                        ->where('customers.geography', $filters_customer['region'])
                                                        ->where('customers.delivery_by', $filters_customer['delivery'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters_customer['from'], $filters_customer['to']])
                                                        ->get();
                                                    });
                
                                    //dd($count_report_customer);
                                    //นับจำนวนร้านค้าแบบไม่ซ้ำ;
                                    foreach($count_report_customer as $row_id) {
                        
                                        $arr_id[] = $row_id->customer_id;
                                    } 

                                    //นำตัวที่ซ้ำออก;
                                    if(isset($arr_id)) {
                                        $unique = array_unique($arr_id);
                                        $count_customer_range = count($unique);

                                    } else {
                                        $count_customer_range = 0;
                                    }
                
                                        // dd($count_customer_range);

                                    //dashboard;
                                    $filters_po = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'adminarea_seller' => $adminarea_seller,
                                        'region' => $region,
                                        'delivery' => $delivery,
                                        ];

                                    $key_po = 'sales_po_' . md5(json_encode($filters_po));

                                    $count_po_range = Cache::remember($key_po, 1800, function () use ($filters_po) {

                                    return ReportSeller::select('purchase_order', DB::raw('SUM(price*quantity) as total_sales'))
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.purchase_order')
                                                    ->where('customers.admin_area', $filters_po['adminarea_seller'])
                                                    ->where('customers.geography', $filters_po['region'])
                                                    ->where('customers.delivery_by', $filters_po['delivery'])
                                                    ->whereBetween('report_sellers.date_purchase', [$filters_po['from'], $filters_po['to']])
                                                    ->get();
                                                });

                                    $count_purchase_range = count($count_po_range);
                                    // dd($count_purchase_range);

                                    $filters_selling = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'adminarea_seller' => $adminarea_seller,
                                        'region' => $region,
                                        'delivery' => $delivery,
                                        ];

                                    $key_selling = 'sales_selling_' . md5(json_encode($filters_selling));

                                    $total_report_selling = Cache::remember($key_selling, 1800, function () use ($filters_selling) {

                                    return ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order')
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.purchase_order')
                                                        ->where('customers.admin_area', $filters_selling['adminarea_seller'])
                                                        ->where('customers.geography', $filters_selling['region'])
                                                        ->where('customers.delivery_by', $filters_selling['delivery'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters_selling['from'], $filters_selling['to']])
                                                        ->get();
                                                    });

                                    $filters = [
                                        'from' => $request->from,
                                        'to' => $request->to,
                                        'page' => $page,
                                        'perpage' => $perpage,
                                        'adminarea_seller' => $adminarea_seller,
                                        'region' => $region,
                                        'delivery' => $delivery,
                                        ];

                                    $key = 'sales_report_' . md5(json_encode($filters));

                                    $report_seller = Cache::remember($key, 1800, function () use ($filters) {

                                    return ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name', 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.customer_id', 'customers.customer_name' , 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                        ->where('customers.admin_area', $filters['adminarea_seller'])
                                                        ->where('customers.geography', $filters['region'])
                                                        ->where('customers.delivery_by', $filters['delivery'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters['from'], $filters['to']])
                                                        /* ->offset($start)
                                                        ->limit($perpage)
                                                        ->get(); */
                                                        ->paginate($filters['perpage'], ['*'], 'page', $filters['page']);
                                                    });
                                
                                } else {

                                    $filters_page = [
                                        'from'=>$request->from,
                                        'to'=>$request->to,
                                        'delivery' => $delivery,
                                        'region' => $region,
                                        ];

                                    $key_page = 'sales_page_' . md5(json_encode($filters_page));

                                    $pagination = Cache::remember($key_page, 1800, function () use ($filters_page) {

                                    return ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->join('customers', function (JoinClause $join) {
                                                    $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                })
                                                ->groupBy('report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->where('customers.geography', $filters_page['region'])
                                                ->where('customers.delivery_by', $filters_page['delivery'])
                                                ->whereBetween('report_sellers.date_purchase', [$filters_page['from'], $filters_page['to']])
                                                ->get();
                                            });

                                    $count_page = count($pagination);
                                    // dd($count_page);

                                    $perpage = 10;
                                    $total_page = ceil($count_page / $perpage);
                                    $start = ($perpage * $page) - $perpage;

                                    $filters_customer = [
                                        'from'=>$request->from,
                                        'to'=>$request->to,
                                        'delivery' => $delivery,
                                        'region' => $region,
                                        ];

                                    $key_customer = 'sales_customer_' . md5(json_encode($filters_customer));

                                    $count_report_customer = Cache::remember($key_customer, 1800, function () use ($filters_customer) {

                                    return ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', DB::raw('COUNT(report_sellers.customer_id) as count_id'))
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.customer_id', 'report_sellers.purchase_order')
                                                            ->where('customers.geography', $filters_customer['region'])
                                                            ->where('customers.delivery_by', $filters_customer['delivery'])
                                                            ->whereBetween('report_sellers.date_purchase', [$filters_customer['from'], $filters_customer['to']])
                                                            ->get();
                                                        });
                                        
                                                            //dd($count_report_customer);
                                                            //นับจำนวนร้านค้าแบบไม่ซ้ำ;
                                                            foreach($count_report_customer as $row_id) {
                                                
                                                                $arr_id[] = $row_id->customer_id;
                                                            } 

                                                            //นำตัวที่ซ้ำออก;
                                                            if(isset($arr_id)) {
                                                                $unique = array_unique($arr_id);
                                                                $count_customer_range = count($unique);

                                                            } else {
                                                                $count_customer_range = 0;
                                                            }
                                        
                                        // dd($count_customer_range);

                                    //dashboard;
                                    $filters_po = [
                                        'from'=>$request->from,
                                        'to'=>$request->to,
                                        'delivery' => $delivery,
                                        'region' => $region,
                                        ];

                                    $key_po = 'sales_po_' . md5(json_encode($filters_po));

                                    $count_po_range = Cache::remember($key_po, 1800, function () use ($filters_po) {

                                    return ReportSeller::select('purchase_order', DB::raw('SUM(price*quantity) as total_sales'))
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.purchase_order')
                                                        ->where('customers.geography', $filters_po['region'])
                                                        ->where('customers.delivery_by', $filters_po['delivery'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters_po['from'], $filters_po['to']])
                                                        ->get();
                                                    });

                                    $count_purchase_range = count($count_po_range);
                                    // dd($count_purchase_range);

                                    $filters_selling = [
                                        'from'=>$request->from,
                                        'to'=>$request->to,
                                        'delivery' => $delivery,
                                        'region' => $region,
                                        ];

                                    $key_selling = 'sales_selling_' . md5(json_encode($filters_selling));

                                    $total_report_selling = Cache::remember($key_selling, 1800, function () use ($filters_selling) {

                                    return ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order')
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.purchase_order')
                                                        ->where('customers.geography', $filters_selling['region'])
                                                        ->where('customers.delivery_by', $filters_selling['delivery'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters_selling['from'], $filters_selling['to']])
                                                        ->get();
                                                    });

                                    $filters = [
                                        'from'=>$request->from,
                                        'to'=>$request->to,
                                        'page' => $page,
                                        'perpage'=>$perpage,
                                        'delivery' => $delivery,
                                        'region' => $region,
                                        ];

                                    $key = 'sales_report_' . md5(json_encode($filters));

                                    $report_seller = Cache::remember($key, 1800, function () use ($filters) {

                                    return ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name', 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.customer_id', 'customers.customer_name' , 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->where('customers.geography', $filters['region'])
                                                    ->where('customers.delivery_by', $filters['delivery'])
                                                    ->whereBetween('report_sellers.date_purchase', [$filters['from'], $filters['to']])
                                                   /*  ->offset($start)
                                                    ->limit($perpage)
                                                    ->get(); */
                                                    ->paginate($filters['perpage'], ['*'], 'page', $filters['page']);
                                                });
                                }

                            } else if (!empty($region)) {
                                //code check region;

                                // dd('region');
                                if(!empty($salearea_seller && !empty($adminarea_seller))) {

                                    $filters_page = [
                                        'from'=>$request->from,
                                        'to'=>$request->to,
                                        'salearea_seller' => $salearea_seller,
                                        'adminarea_seller' => $adminarea_seller,
                                        'region' => $region,
                                        ];

                                    $key_page = 'sales_page_' . md5(json_encode($filters_page));

                                    $pagination = Cache::remember($key_page, 1800, function () use ($filters_page) {

                                    return ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->join('customers', function (JoinClause $join) {
                                                    $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                })
                                                ->groupBy('report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->where('customers.sale_area', $filters_page['salearea_seller'])
                                                ->where('customers.admin_area', $filters_page['adminarea_seller'])
                                                ->where('customers.geography', $filters_page['region'])
                                                ->whereBetween('report_sellers.date_purchase', [$filters_page['from'], $filters_page['to']])
                                               /*  ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                ->get();
                                            });

                                    $count_page = count($pagination);
                                    // dd($count_page);

                                    $perpage = 10;
                                    $total_page = ceil($count_page / $perpage);
                                    $start = ($perpage * $page) - $perpage;

                                    $filters_customer = [
                                        'from'=>$request->from,
                                        'to'=>$request->to,
                                        'salearea_seller' => $salearea_seller,
                                        'adminarea_seller' => $adminarea_seller,
                                        'region' => $region,
                                        ];

                                    $key_customer = 'sales_customer_' . md5(json_encode($filters_customer));

                                    $count_report_customer = Cache::remember($key_customer, 1800, function () use ($filters_customer) {

                                    return ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', DB::raw('COUNT(report_sellers.customer_id) as count_id'))
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.customer_id', 'report_sellers.purchase_order')
                                                            ->where('customers.sale_area', $filters_customer['salearea_seller'])
                                                            ->where('customers.admin_area', $filters_customer['adminarea_seller'])
                                                            ->where('customers.geography', $filters_customer['region'])
                                                            ->whereBetween('report_sellers.date_purchase', [$filters_customer['from'], $filters_customer['to']])
                                                           /*  ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                            ->get();
                                                        });
                                        
                                                            //dd($count_report_customer);
                                                            //นับจำนวนร้านค้าแบบไม่ซ้ำ;
                                                            foreach($count_report_customer as $row_id) {
                                                
                                                                $arr_id[] = $row_id->customer_id;
                                                            } 

                                                            //นำตัวที่ซ้ำออก;
                                                            if(isset($arr_id)) {
                                                                $unique = array_unique($arr_id);
                                                                $count_customer_range = count($unique);

                                                            } else {
                                                                $count_customer_range = 0;
                                                            }
                                        
                                        // dd($count_customer_range);

                                    //dashboard;
                                    $filters_po = [
                                        'from'=>$request->from,
                                        'to'=>$request->to,
                                        'salearea_seller' => $salearea_seller,
                                        'adminarea_seller' => $adminarea_seller,
                                        'region' => $region,
                                        ];

                                    $key_po = 'sales_po_' . md5(json_encode($filters_po));

                                    $count_po_range = Cache::remember($key_po, 1800, function () use ($filters_po) {

                                    return ReportSeller::select('purchase_order', DB::raw('SUM(price*quantity) as total_sales'))
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.purchase_order')
                                                    ->where('customers.sale_area', $filters_po['salearea_seller'])
                                                    ->where('customers.admin_area', $filters_po['adminarea_seller'])
                                                    ->where('customers.geography', $filters_po['region'])
                                                    ->whereBetween('report_sellers.date_purchase', [$filters_po['from'], $filters_po['to']])
                                                   /*  ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                    ->get();
                                                });

                                    $count_purchase_range = count($count_po_range);
                                    // dd($count_purchase_range);

                                    $filters_selling = [
                                        'from'=>$request->from,
                                        'to'=>$request->to,
                                        'salearea_seller' => $salearea_seller,
                                        'adminarea_seller' => $adminarea_seller,
                                        'region' => $region,
                                        ];

                                    $key_selling = 'sales_selling_' . md5(json_encode($filters_selling));

                                    $total_report_selling = Cache::remember($key_selling, 1800, function () use ($filters_selling) {

                                    return ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order')
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.purchase_order')
                                                        ->where('customers.sale_area', $filters_selling['salearea_seller'])
                                                        ->where('customers.admin_area', $filters_selling['adminarea_seller'])
                                                        ->where('customers.geography', $filters_selling['region'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters_selling['from'], $filters_selling['to']])
                                                        /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                        ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                        ->get();
                                                    });

                                    $filters = [
                                        'from'=>$request->from,
                                        'to'=>$request->to,
                                        'page' => $page,
                                        'perpage'=>$perpage,
                                        'salearea_seller' => $salearea_seller,
                                        'adminarea_seller' => $adminarea_seller,
                                        'region' => $region,
                                        ];

                                    $key = 'sales_report_' . md5(json_encode($filters));

                                    $report_seller =  Cache::remember($key, 1800, function () use ($filters) {
                                
                                    return ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name', 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.customer_id', 'customers.customer_name' , 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->where('customers.sale_area', $filters['salearea_seller'])
                                                    ->where('customers.admin_area', $filters['adminarea_seller'])
                                                    ->where('customers.geography', $filters['region'])
                                                    ->whereBetween('report_sellers.date_purchase', [$filters['from'], $filters['to']])
                                                   /*  ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                    /* ->offset($start)
                                                    ->limit($perpage)
                                                    ->get(); */
                                                    ->paginate($filters['perpage'], ['*'], 'page', $filters['page']);
                                                });
                        
                                } else if(!empty($salearea_seller)) {

                                    $filters_page = [
                                        'from'=>$request->from,
                                        'to'=>$request->to,
                                        'salearea_seller' => $salearea_seller,
                                        'region' => $region,
                                        ];

                                    $key_page = 'sales_page_' . md5(json_encode($filters_page));

                                    $pagination = Cache::remember($key_page, 1800, function () use ($filters_page) {

                                    return ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', 'report_sellers.customer_id')
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.purchase_order', 'report_sellers.customer_id')
                                                        ->where('customers.sale_area', $filters_page['salearea_seller'])
                                                        ->where('customers.geography', $filters_page['region'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters_page['from'], $filters_page['to']])
                                                    /*  ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                        ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                        ->get();
                                                    });

                                    $count_page = count($pagination);
                                    // dd($count_page);

                                    $perpage = 10;
                                    $total_page = ceil($count_page / $perpage);
                                    $start = ($perpage * $page) - $perpage;

                                    $filters_customer = [
                                        'from'=>$request->from,
                                        'to'=>$request->to,
                                        'salearea_seller' => $salearea_seller,
                                        'region' => $region,
                                        ];

                                    $key_customer = 'sales_customer_' . md5(json_encode($filters_customer));

                                    $count_report_customer = Cache::remember($key_customer, 1800, function () use ($filters_customer) {

                                    return ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', DB::raw('COUNT(report_sellers.customer_id) as count_id'))
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.customer_id', 'report_sellers.purchase_order')
                                                            ->where('customers.sale_area', $filters_customer['salearea_seller'])
                                                            ->where('customers.geography', $filters_customer['region'])
                                                            ->whereBetween('report_sellers.date_purchase', [$filters_customer['from'], $filters_customer['to']])
                                                           /*  ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                            ->get();
                                                        });

                                    //dd($count_report_customer);
                                    //นับจำนวนร้านค้าแบบไม่ซ้ำ;
                                    foreach($count_report_customer as $row_id) {

                                        $arr_id[] = $row_id->customer_id;
                                    } 

                                    //นำตัวที่ซ้ำออก;
                                    if(isset($arr_id)) {
                                        $unique = array_unique($arr_id);
                                        $count_customer_range = count($unique);

                                    } else {
                                        $count_customer_range = 0;
                                    }

                                    // dd($count_customer_range);

                                    //dashboard;
                                    $filters_po = [
                                        'from'=>$request->from,
                                        'to'=>$request->to,
                                        'salearea_seller' => $salearea_seller,
                                        'region' => $region,
                                        ];

                                    $key_po = 'sales_po_' . md5(json_encode($filters_po));

                                    $count_po_range = Cache::remember($key_po, 1800, function () use ($filters_po) {

                                    return ReportSeller::select('purchase_order', DB::raw('SUM(price*quantity) as total_sales'))
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.purchase_order')
                                                    ->where('customers.sale_area', $filters_po['salearea_seller'])
                                                    ->where('customers.geography', $filters_po['region'])
                                                    ->whereBetween('report_sellers.date_purchase', [$filters_po['from'], $filters_po['to']])
                                                   /*  ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                    ->get();
                                                });

                                    $count_purchase_range = count($count_po_range);
                                    // dd($count_purchase_range);

                                    $filters_selling = [
                                        'from'=>$request->from,
                                        'to'=>$request->to,
                                        'salearea_seller' => $salearea_seller,
                                        'region' => $region,
                                        ];

                                    $key_selling = 'sales_selling_' . md5(json_encode($filters_selling));

                                    $total_report_selling = Cache::remember($key_selling, 1800, function () use ($filters_selling) {

                                    return ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order')
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.purchase_order')
                                                            ->where('customers.sale_area', $filters_selling['salearea_seller'])
                                                            ->where('customers.geography', $filters_selling['region'])
                                                            ->whereBetween('report_sellers.date_purchase', [$filters_selling['from'], $filters_selling['to']])
                                                            /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                            ->get();
                                                        });

                                    $filters = [
                                        'from'=>$request->from,
                                        'to'=>$request->to,
                                        'page' => $page,
                                        'perpage'=>$perpage,
                                        'salearea_seller' => $salearea_seller,
                                        'region' => $region,
                                        ];

                                    $key = 'sales_report_' . md5(json_encode($filters));

                                    $report_seller =  Cache::remember($key, 1800, function () use ($filters) {

                                    return ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name', 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.customer_id', 'customers.customer_name' , 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                        ->where('customers.sale_area', $filters['salearea_seller'])
                                                        ->where('customers.geography', $filters['region'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters['from'], $filters['to']])
                                                    /*  ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                        ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                        /* ->offset($start)
                                                        ->limit($perpage)
                                                        ->get(); */
                                                        ->paginate($filters['perpage'], ['*'], 'page', $filters['page']);

                                                    });

                                } else if(!empty($adminarea_seller)) {

                                    $filters_page = [
                                        'from'=>$request->from,
                                        'to'=>$request->to,
                                        'adminarea_seller' => $adminarea_seller,
                                        'region' => $region,
                                        ];

                                    $key_page = 'sales_page_' . md5(json_encode($filters_page));

                                    $pagination = Cache::remember($key_page, 1800, function () use ($filters_page) {

                                    return ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->join('customers', function (JoinClause $join) {
                                                    $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                })
                                                ->groupBy('report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->where('customers.admin_area', $filters_page['adminarea_seller'])
                                                ->where('customers.geography', $filters_page['region'])
                                                ->whereBetween('report_sellers.date_purchase', [$filters_page['from'], $filters_page['to']])
                                                /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                ->get();
                                            });

                                    $count_page = count($pagination);
                                    // dd($count_page);

                                    $perpage = 10;
                                    $total_page = ceil($count_page / $perpage);
                                    $start = ($perpage * $page) - $perpage;

                                    $filters_customer = [
                                        'from'=>$request->from,
                                        'to'=>$request->to,
                                        'adminarea_seller' => $adminarea_seller,
                                        'region' => $region,
                                        ];

                                    $key_customer = 'sales_customer_' . md5(json_encode($filters_customer));

                                    $count_report_customer = Cache::remember($key_customer, 1800, function () use ($filters_customer) {

                                    return ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', DB::raw('COUNT(report_sellers.customer_id) as count_id'))
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.customer_id', 'report_sellers.purchase_order')
                                                            ->where('customers.admin_area', $filters_customer['adminarea_seller'])
                                                            ->where('customers.geography', $filters_customer['region'])
                                                            ->whereBetween('report_sellers.date_purchase', [$filters_customer['from'], $filters_customer['to']])
                                                            /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                            ->get();
                                                        });

                                    //dd($count_report_customer);
                                    //นับจำนวนร้านค้าแบบไม่ซ้ำ;
                                    foreach($count_report_customer as $row_id) {

                                        $arr_id[] = $row_id->customer_id;
                                    } 

                                    //นำตัวที่ซ้ำออก;
                                    if(isset($arr_id)) {
                                        $unique = array_unique($arr_id);
                                        $count_customer_range = count($unique);

                                    } else {
                                        $count_customer_range = 0;
                                    }

                                    // dd($count_customer_range);

                                    //dashboard;
                                    $filters_po = [
                                        'from'=>$request->from,
                                        'to'=>$request->to,
                                        'adminarea_seller' => $adminarea_seller,
                                        'region' => $region,
                                        ];

                                    $key_po = 'sales_po_' . md5(json_encode($filters_po));

                                    $count_po_range = Cache::remember($key_po, 1800, function () use ($filters_po) {

                                    return ReportSeller::select('purchase_order', DB::raw('SUM(price*quantity) as total_sales'))
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.purchase_order')
                                                    ->where('customers.admin_area', $filters_po['adminarea_seller'])
                                                    ->where('customers.geography', $filters_po['region'])
                                                    ->whereBetween('report_sellers.date_purchase', [$filters_po['from'], $filters_po['to']])
                                                   /*  ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                    ->get();
                                                });

                                    $count_purchase_range = count($count_po_range);
                                    // dd($count_purchase_range);
                                    $filters_selling = [
                                        'from'=>$request->from,
                                        'to'=>$request->to,
                                        'adminarea_seller' => $adminarea_seller,
                                        'region' => $region,
                                        ];

                                    $key_selling = 'sales_selling_' . md5(json_encode($filters_selling));

                                    $total_report_selling = Cache::remember($key_selling, 1800, function () use ($filters_selling) {

                                    return ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order')
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.purchase_order')
                                                            ->where('customers.admin_area', $filters_selling['adminarea_seller'])
                                                            ->where('customers.geography', $filters_selling['region'])
                                                            ->whereBetween('report_sellers.date_purchase', [$filters_selling['from'], $filters_selling['to']])
                                                            /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                            ->get();
                                                        });

                                    $filters = [
                                        'from'=>$request->from,
                                        'to'=>$request->to,
                                        'page' => $page,
                                        'perpage'=>$perpage,
                                        'adminarea_seller' => $adminarea_seller,
                                        'region' => $region,
                                        ];

                                    $key = 'sales_report_' . md5(json_encode($filters));

                                    $report_seller =  Cache::remember($key, 1800, function () use ($filters) {
                        
                                    return ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name', 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.customer_id', 'customers.customer_name' , 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                        ->where('customers.admin_area', $filters['adminarea_seller'])
                                                        ->where('customers.geography', $filters['region'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters['from'], $filters['to']])
                                                    /*  ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                        ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                        /* ->offset($start)
                                                        ->limit($perpage)
                                                        ->get(); */
                                                        ->paginate($filters['perpage'], ['*'], 'page', $filters['page']);
                                                    });
                                
                                } else {

                                    // dd('region');
                                    $filters_page = [
                                        'from'=>$request->from,
                                        'to'=>$request->to,
                                        'region' => $region,
                                        ];

                                    $key_customer = 'sales_page_' . md5(json_encode($filters_page));

                                    $pagination = Cache::remember($key_customer, 1800, function () use ($filters_page) {

                                    return ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->join('customers', function (JoinClause $join) {
                                                    $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                })
                                                ->groupBy('report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->where('customers.geography', $filters_page['region'])
                                                ->whereBetween('report_sellers.date_purchase', [$filters_page['from'], $filters_page['to']])
                                                /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                ->get();
                                            });

                                    $count_page = count($pagination);
                                    // dd($count_page);

                                    $perpage = 10;
                                    $total_page = ceil($count_page / $perpage);
                                    $start = ($perpage * $page) - $perpage;

                                    $filters_customer = [
                                        'from'=>$request->from,
                                        'to'=>$request->to,
                                        'region' => $region,
                                        ];

                                    $key_customer = 'sales_customer_' . md5(json_encode($filters_customer));

                                    $count_report_customer = Cache::remember($key_customer, 1800, function () use ($filters_customer) {

                                    return ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', DB::raw('COUNT(report_sellers.customer_id) as count_id'))
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.customer_id', 'report_sellers.purchase_order')
                                                            ->where('customers.geography', $filters_customer['region'])
                                                            ->whereBetween('report_sellers.date_purchase', [$filters_customer['from'], $filters_customer['to']])
                                                            /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                            ->get();
                                                        });

                                    //dd($count_report_customer);
                                    //นับจำนวนร้านค้าแบบไม่ซ้ำ;
                                    foreach($count_report_customer as $row_id) {

                                        $arr_id[] = $row_id->customer_id;
                                    } 

                                    //นำตัวที่ซ้ำออก;
                                    if(isset($arr_id)) {
                                        $unique = array_unique($arr_id);
                                        $count_customer_range = count($unique);

                                    } else {
                                        $count_customer_range = 0;
                                    }

                                    // dd($count_customer_range);

                                    //dashboard;
                                    $filters_po = [
                                        'from'=>$request->from,
                                        'to'=>$request->to,
                                        'region' => $region,
                                        ];

                                    $key_po = 'sales_po_' . md5(json_encode($filters_po));

                                    $count_po_range = Cache::remember($key_po, 1800, function () use ($filters_po) {

                                    return ReportSeller::select('purchase_order', DB::raw('SUM(price*quantity) as total_sales'))
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.purchase_order')
                                                    ->where('customers.geography', $filters_po['region'])
                                                    ->whereBetween('report_sellers.date_purchase', [$filters_po['from'], $filters_po['to']])
                                                    /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                    ->get();
                                                });

                                    $count_purchase_range = count($count_po_range);
                                    // dd($count_purchase_range);

                                    $filters_selling = [
                                        'from'=>$request->from,
                                        'to'=>$request->to,
                                        'region' => $region,
                                        ];

                                    $key_selling = 'sales_selling_' . md5(json_encode($filters_selling));

                                    $total_report_selling = Cache::remember($key_selling, 1800, function () use ($filters_selling) {

                                    return ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order')
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.purchase_order')
                                                            ->where('customers.geography', $filters_selling['region'])
                                                            ->whereBetween('report_sellers.date_purchase', [$filters_selling['from'], $filters_selling['to']])
                                                           /*  ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                            ->get();
                                                        });

                                    $filters = [
                                        'from'=>$request->from,
                                        'to'=>$request->to,
                                        'page' => $page,
                                        'perpage'=>$perpage,
                                        'region' => $region,
                                        ];

                                    $key = 'sales_report_' . md5(json_encode($filters));

                                    $report_seller = Cache::remember($key, 1800, function () use ($filters) {

                                    return ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name', 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.customer_id', 'customers.customer_name' , 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->where('customers.geography', $filters['region'])
                                                    ->whereBetween('report_sellers.date_purchase', [$filters['from'], $filters['to']])
                                                    /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                    /* ->offset($start)
                                                    ->limit($perpage)
                                                    ->get(); */
                                                    ->paginate($filters['perpage'], ['*'], 'page', $filters['page']);
                                                });
                                }

                            } else if (!empty($delivery)) {
                                //code check delivery;
                                if(!empty($salearea_seller && !empty($adminarea_seller))) {

                                    $filters_page = [
                                        'from'=>$request->from,
                                        'to'=>$request->to,
                                        'salearea_seller' => $salearea_seller,
                                        'adminarea_seller' => $adminarea_seller,
                                        'delivery' => $delivery,
                                        ];

                                    $key_page = 'sales_page_' . md5(json_encode($filters_page));

                                    $pagination = Cache::remember($key_page, 1800, function () use ($filters_page) {

                                    return ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', 'report_sellers.customer_id')
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.purchase_order', 'report_sellers.customer_id')
                                                        ->where('customers.sale_area', $filters_page['salearea_seller'])
                                                        ->where('customers.admin_area', $filters_page['adminarea_seller'])
                                                        ->where('customers.delivery_by', $filters_page['delivery'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters_page['from'], $filters_page['to']])
                                                    /*  ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                        ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                        ->get();
                                                    });

                                    $count_page = count($pagination);
                                    // dd($count_page);

                                    $perpage = 10;
                                    $total_page = ceil($count_page / $perpage);
                                    $start = ($perpage * $page) - $perpage;

                                    $filters_customer = [
                                        'from'=>$request->from,
                                        'to'=>$request->to,
                                        'salearea_seller' => $salearea_seller,
                                        'adminarea_seller' => $adminarea_seller,
                                        'delivery' => $delivery,
                                        ];

                                    $key_customer = 'sales_customer_' . md5(json_encode($filters_customer));

                                    $count_report_customer = Cache::remember($key_customer, 1800, function () use ($filters_customer) {

                                    return ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', DB::raw('COUNT(report_sellers.customer_id) as count_id'))
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.customer_id', 'report_sellers.purchase_order')
                                                        ->where('customers.sale_area', $filters_customer['salearea_seller'])
                                                        ->where('customers.admin_area', $filters_customer['adminarea_seller'])
                                                        ->where('customers.delivery_by', $filters_customer['delivery'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters_customer['from'], $filters_customer['to']])
                                                        /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                        ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                        ->get();
                                                    });
                                        
                                                            //dd($count_report_customer);
                                                            //นับจำนวนร้านค้าแบบไม่ซ้ำ;
                                                            foreach($count_report_customer as $row_id) {
                                                
                                                                $arr_id[] = $row_id->customer_id;
                                                            } 

                                                            //นำตัวที่ซ้ำออก;
                                                            if(isset($arr_id)) {
                                                                $unique = array_unique($arr_id);
                                                                $count_customer_range = count($unique);

                                                            } else {
                                                                $count_customer_range = 0;
                                                            }
                                        
                                        // dd($count_customer_range);

                                    //dashboard;
                                    $filters_po = [
                                        'from'=>$request->from,
                                        'to'=>$request->to,
                                        'salearea_seller' => $salearea_seller,
                                        'adminarea_seller' => $adminarea_seller,
                                        'delivery' => $delivery,
                                        ];

                                    $key_po = 'sales_po_' . md5(json_encode($filters_po));

                                    $count_po_range = Cache::remember($key_po, 1800, function () use ($filters_po) {

                                    return ReportSeller::select('purchase_order', DB::raw('SUM(price*quantity) as total_sales'))
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.purchase_order')
                                                        ->where('customers.sale_area', $filters_po['salearea_seller'])
                                                        ->where('customers.admin_area', $filters_po['adminarea_seller'])
                                                        ->where('customers.delivery_by', $filters_po['delivery'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters_po['from'], $filters_po['to']])
                                                    /*  ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                        ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                        ->get();
                                                    });

                                    $count_purchase_range = count($count_po_range);
                                    // dd($count_purchase_range);

                                    $filters_selling = [
                                        'from'=>$request->from,
                                        'to'=>$request->to,
                                        'salearea_seller' => $salearea_seller,
                                        'adminarea_seller' => $adminarea_seller,
                                        'delivery' => $delivery,
                                        ];

                                    $key_selling = 'sales_selling_' . md5(json_encode($filters_selling));

                                    $total_report_selling = Cache::remember($key_selling, 1800, function () use ($filters_selling) {

                                    return ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'purchase_order')
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('purchase_order')
                                                            ->where('customers.sale_area', $filters_selling['salearea_seller'])
                                                            ->where('customers.admin_area', $filters_selling['adminarea_seller'])
                                                            ->where('customers.delivery_by', $filters_selling['delivery'])
                                                            ->whereBetween('report_sellers.date_purchase', [$filters_selling['from'], $filters_selling['to']])
                                                           /*  ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                            ->get();
                                                        });

                                    $filters = [
                                        'from'=>$request->from,
                                        'to'=>$request->to,
                                        // 'start'=>$start,
                                        'page' => $page,
                                        'perpage'=>$perpage,
                                        'salearea_seller' => $salearea_seller,
                                        'adminarea_seller' => $adminarea_seller,
                                        'delivery' => $delivery,
                                        ];

                                    $key = 'sales_report_' . md5(json_encode($filters));

                                    $report_seller =  Cache::remember($key, 1800, function () use ($filters) {

                                    return ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name', 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.customer_id', 'customers.customer_name' , 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                        ->where('customers.sale_area', $filters['salearea_seller'])
                                                        ->where('customers.admin_area', $filters['adminarea_seller'])
                                                        ->where('customers.delivery_by', $filters['delivery'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters['from'], $filters['to']])
                                                    /*  ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                        ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                        /* ->offset($start)
                                                        ->limit($perpage)
                                                        ->get(); */
                                                        ->paginate($filters['perpage'], ['*'], 'page', $filters['page']);
                                                    });
                        
                                } else if(!empty($salearea_seller)) {

                                    $filters_page = [
                                        'from'=>$request->from,
                                        'to'=>$request->to,
                                        'salearea_seller' => $salearea_seller,
                                        'delivery' => $delivery,
                                        ];

                                    $key_page = 'sales_page_' . md5(json_encode($filters_page));
                
                                    $pagination = Cache::remember($key_page, 1800, function () use ($filters_page) {

                                    return ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', 'report_sellers.customer_id')
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.purchase_order', 'report_sellers.customer_id')
                                                        ->where('customers.sale_area', $filters_page['salearea_seller'])
                                                        ->where('customers.delivery_by', $filters_page['delivery'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters_page['from'], $filters_page['to']])
                                                        /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                        ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                        ->get();
                                                    });

                                    $count_page = count($pagination);
                                    // dd($count_page);

                                    $perpage = 10;
                                    $total_page = ceil($count_page / $perpage);
                                    $start = ($perpage * $page) - $perpage;

                                    $filters_customer = [
                                        'from'=>$request->from,
                                        'to'=>$request->to,
                                        'salearea_seller' => $salearea_seller,
                                        'delivery' => $delivery,
                                        ];

                                    $key_customer = 'sales_customer_' . md5(json_encode($filters_customer));
                
                                    $count_report_customer = Cache::remember($key_customer, 1800, function () use ($filters_customer) {

                                    return ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', DB::raw('COUNT(report_sellers.customer_id) as count_id'))
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.customer_id', 'report_sellers.purchase_order')
                                                            ->where('customers.sale_area', $filters_customer['salearea_seller'])
                                                            ->where('customers.delivery_by', $filters_customer['delivery'])
                                                            ->whereBetween('report_sellers.date_purchase', [$filters_customer['from'], $filters_customer['to']])
                                                           /*  ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                            ->get();
                                                        });
                
                                    //dd($count_report_customer);
                                    //นับจำนวนร้านค้าแบบไม่ซ้ำ;
                                    foreach($count_report_customer as $row_id) {
                        
                                        $arr_id[] = $row_id->customer_id;
                                    } 

                                    //นำตัวที่ซ้ำออก;
                                    if(isset($arr_id)) {
                                        $unique = array_unique($arr_id);
                                        $count_customer_range = count($unique);

                                    } else {
                                        $count_customer_range = 0;
                                    }
                
                                    // dd($count_customer_range);

                                    //dashboard;
                                    $filters_po = [
                                        'from'=>$request->from,
                                        'to'=>$request->to,
                                        'salearea_seller' => $salearea_seller,
                                        'delivery' => $delivery,
                                        ];

                                    $key_po = 'sales_po_' . md5(json_encode($filters_po));
                
                                    $count_po_range = Cache::remember($key_po, 1800, function () use ($filters_po) {

                                    return ReportSeller::select('purchase_order', DB::raw('SUM(price*quantity) as total_sales'))
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.purchase_order')
                                                    ->where('customers.sale_area', $filters_po['salearea_seller'])
                                                    ->where('customers.delivery_by', $filters_po['delivery'])
                                                    ->whereBetween('report_sellers.date_purchase', [$filters_po['from'], $filters_po['to']])
                                                    /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                    ->get();
                                                });

                                    $count_purchase_range = count($count_po_range);
                                    // dd($count_purchase_range);

                                    $filters_selling = [
                                        'from'=>$request->from,
                                        'to'=>$request->to,
                                        'salearea_seller' => $salearea_seller,
                                        'delivery' => $delivery,
                                        ];

                                    $key_selling = 'sales_selling_' . md5(json_encode($filters_selling));
                
                                    $total_report_selling  =  Cache::remember($key_selling, 1800, function () use ($filters_selling) {

                                    return ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order')
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.purchase_order')
                                                            ->where('customers.sale_area', $filters_selling['salearea_seller'])
                                                            ->where('customers.delivery_by', $filters_selling['delivery'])
                                                            ->whereBetween('report_sellers.date_purchase', [$filters_selling['from'], $filters_selling['to']])
                                                            /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                            ->get();

                                                        });

                                    $filters = [
                                        'from'=>$request->from,
                                        'to'=>$request->to,
                                        // 'start'=>$start,
                                        'page' => $page,
                                        'perpage'=>$perpage,
                                        'salearea_seller' => $salearea_seller,
                                        'delivery' => $delivery,
                                        ];

                                    $key = 'sales_report_' . md5(json_encode($filters));
                                    // dd($key);

                                    $report_seller =  Cache::remember($key, 1800, function () use ($filters) {

                                    return ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name', 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.customer_id', 'customers.customer_name' , 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                        ->where('customers.sale_area', $filters['salearea_seller'])
                                                        ->where('customers.delivery_by', $filters['delivery'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters['from'], $filters['to']])
                                                    /*  ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                        ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                    /*   ->offset($start)
                                                        ->limit($perpage)
                                                        ->get(); */
                                                        ->paginate($filters['perpage'], ['*'], 'page', $filters['page']);
                                                });

                                } else if(!empty($adminarea_seller)) {

                                    $filters_page = [
                                        'from'=>$request->from,
                                        'to'=>$request->to,
                                        'adminarea_seller' => $adminarea_seller,
                                        'delivery' => $delivery,
                                        ];

                                    $key_page = 'sales_page_' . md5(json_encode($filters_page));
                                    // dd($key);

                                    $pagination = Cache::remember($key_page, 1800, function () use ($filters_page) {

                                    return ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', 'report_sellers.customer_id')
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.purchase_order', 'report_sellers.customer_id')
                                                        ->where('customers.admin_area', $filters_page['adminarea_seller'])
                                                        ->where('customers.delivery_by', $filters_page['delivery'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters_page['from'], $filters_page['to']])
                                                        /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                        ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                        ->get();
                                                    });

                                    $count_page = count($pagination);
                                    // dd($count_page);

                                    $perpage = 10;
                                    $total_page = ceil($count_page / $perpage);
                                    $start = ($perpage * $page) - $perpage;

                                    $filters_customer = [
                                        'from'=>$request->from,
                                        'to'=>$request->to,
                                        'adminarea_seller' => $adminarea_seller,
                                        'delivery' => $delivery,
                                        ];

                                    $key_customer = 'sales_customer_' . md5(json_encode($filters_customer));
                                    // dd($key);

                                    $count_report_customer = Cache::remember($key_customer, 1800, function () use ($filters_customer) {

                                    return ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', DB::raw('COUNT(report_sellers.customer_id) as count_id'))
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.customer_id', 'report_sellers.purchase_order')
                                                        ->where('customers.admin_area', $filters_customer['adminarea_seller'])
                                                        ->where('customers.delivery_by', $filters_customer['delivery'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters_customer['from'], $filters_customer['to']])
                                                        /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                        ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                        ->get();
                                                    });
                
                                    //dd($count_report_customer);
                                    //นับจำนวนร้านค้าแบบไม่ซ้ำ;
                                    foreach($count_report_customer as $row_id) {
                        
                                        $arr_id[] = $row_id->customer_id;
                                    } 

                                    //นำตัวที่ซ้ำออก;
                                    if(isset($arr_id)) {
                                        $unique = array_unique($arr_id);
                                        $count_customer_range = count($unique);

                                    } else {
                                        $count_customer_range = 0;
                                    }
                
                                    // dd($count_customer_range);

                                    //dashboard;
                                    $filters_po = [
                                        'from'=>$request->from,
                                        'to'=>$request->to,
                                        'adminarea_seller' => $adminarea_seller,
                                        'delivery' => $delivery,
                                        ];

                                    $key_po = 'sales_po_' . md5(json_encode($filters_po));
                                    // dd($key);

                                    $count_po_range = Cache::remember($key_po, 1800, function () use ($filters_po) {

                                    return ReportSeller::select('purchase_order', DB::raw('SUM(price*quantity) as total_sales'))
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.purchase_order')
                                                    ->where('customers.admin_area', $filters_po['adminarea_seller'])
                                                    ->where('customers.delivery_by', $filters_po['delivery'])
                                                    ->whereBetween('report_sellers.date_purchase', [$filters_po['from'], $filters_po['to']])
                                                    /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                    ->get();
                                                });

                                    $count_purchase_range = count($count_po_range);
                                    // dd($count_purchase_range);

                                    $filters_selling = [
                                        'from'=>$request->from,
                                        'to'=>$request->to,
                                        'adminarea_seller' => $adminarea_seller,
                                        'delivery' => $delivery,
                                        ];

                                    $key_selling = 'sales_selling_' . md5(json_encode($filters_selling));
                                    // dd($key);

                                    $total_report_selling = Cache::remember($key_selling, 1800, function () use ($filters_selling) {

                                    return ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order')
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.purchase_order')
                                                            ->where('customers.admin_area', $filters_selling['adminarea_seller'])
                                                            ->where('customers.delivery_by', $filters_selling['delivery'])
                                                            ->whereBetween('report_sellers.date_purchase', [$filters_selling['from'], $filters_selling['to']])
                                                           /*  ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                            ->get();
                                                        });

                                    $filters = [
                                        'from'=>$request->from,
                                        'to'=>$request->to,
                                        // 'start'=>$start,
                                        'page' => $page,
                                        'perpage'=>$perpage,
                                        'adminarea_seller' => $adminarea_seller,
                                        'delivery' => $delivery,
                                        ];

                                    $key = 'sales_report_' . md5(json_encode($filters));
                                    // dd($key);

                                    $report_seller  = Cache::remember($key, 1800, function () use ($filters) {

                                    return ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name', 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.customer_id', 'customers.customer_name' , 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->where('customers.admin_area', $filters['adminarea_seller'])
                                                    ->where('customers.delivery_by', $filters['delivery'])
                                                    ->whereBetween('report_sellers.date_purchase', [$filters['from'], $filters['to']])
                                                    /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                  /*   ->offset($start)
                                                    ->limit($perpage)
                                                    ->get(); */
                                                    ->paginate($filters['perpage'], ['*'], 'page', $filters['page']);
                                            });
                                            
                                
                                } else {

                                    $filters_page = [
                                        'from'=>$request->from,
                                        'to'=>$request->to,
                                        'delivery'=> $delivery,
                                        ];

                                    $key_page = 'sales_page_' . md5(json_encode($filters_page));
                                    // dd($key);

                                    $pagination = Cache::remember($key_page, 1800, function () use ($filters_page) {

                                    return ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->join('customers', function (JoinClause $join) {
                                                    $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                })
                                                ->groupBy('purchase_order', 'customer_id')
                                                ->where('customers.delivery_by', $filters_page['delivery'])
                                                ->whereBetween('report_sellers.date_purchase', [$filters_page['from'], $filters_page['to']])
                                                /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                ->get();
                                            });

                                    $count_page = count($pagination);
                                    // dd($count_page);

                                    $perpage = 10;
                                    $total_page = ceil($count_page / $perpage);
                                    $start = ($perpage * $page) - $perpage;

                                    $filters_customer = [
                                        'from'=>$request->from,
                                        'to'=>$request->to,
                                        'delivery'=> $delivery,
                                        ];

                                    $key_customer = 'sales_customer_' . md5(json_encode($filters_customer));
                                    // dd($key);

                                    $count_report_customer = Cache::remember($key_customer, 1800, function () use ($filters_customer) {

                                    return ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', DB::raw('COUNT(report_sellers.customer_id) as count_id'))
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.customer_id', 'report_sellers.purchase_order')
                                                            ->where('customers.delivery_by', $filters_customer['delivery'])
                                                            ->whereBetween('date_purchase', [$filters_customer['from'], $filters_customer['to']])
                                                            /* ->whereBetween('date_purchase', [$request->from, $request->to])
                                                            ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                            ->get();
                                                        });
                
                                    //dd($count_report_customer);
                                    //นับจำนวนร้านค้าแบบไม่ซ้ำ;
                                    foreach($count_report_customer as $row_id) {
                        
                                        $arr_id[] = $row_id->customer_id;
                                    } 

                                    //นำตัวที่ซ้ำออก;
                                    if(isset($arr_id)) {
                                        $unique = array_unique($arr_id);
                                        $count_customer_range = count($unique);

                                    } else {
                                        $count_customer_range = 0;
                                    }
                
                                    // dd($count_customer_range);

                                    //dashboard;
                                    $filters_po = [
                                        'from'=>$request->from,
                                        'to'=>$request->to,
                                        'delivery'=> $delivery,
                                        ];

                                    $key_po = 'sales_po_' . md5(json_encode($filters_po));
                                    // dd($key);

                                    $count_po_range = Cache::remember($key_po, 1800, function () use ($filters_po) {

                                    return ReportSeller::select('purchase_order', DB::raw('SUM(price*quantity) as total_sales'))
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.purchase_order')
                                                    ->where('customers.delivery_by', $filters_po['delivery'])
                                                    ->whereBetween('date_purchase', [$filters_po['from'], $filters_po['to']])
                                                    /* ->whereBetween('date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                    ->get();
                                                });

                                    $count_purchase_range = count($count_po_range);
                                    // dd($count_purchase_range);

                                    $filters_selling = [
                                        'from'=>$request->from,
                                        'to'=>$request->to,
                                        'delivery'=> $delivery,
                                        ];

                                    $key_selling = 'sales_selling_' . md5(json_encode($filters_selling));
                                    // dd($key);

                                    $total_report_selling = Cache::remember($key_selling, 1800, function () use ($filters_selling) {

                                    return ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order')
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.purchase_order')
                                                            ->where('customers.delivery_by', $filters_selling['delivery'])
                                                            ->whereBetween('report_sellers.date_purchase', [$filters_selling['from'], $filters_selling['to']])
                                                            /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                            ->get();
                                                        });

                                    $filters = [
                                        'from'=>$request->from,
                                        'to'=>$request->to,
                                        'start'=>$start,
                                        'page' => $page,
                                        'perpage'=>$perpage,
                                        'delivery'=> $delivery,
                                        ];

                                    $key = 'sales_report_' . md5(json_encode($filters));
                                    // dd($key);

                                    $report_seller  = Cache::remember($key, 1800, function () use ($filters) {

                                    return ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name', 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.customer_id', 'customers.customer_name' , 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->where('customers.delivery_by', $filters['delivery'])
                                                    ->whereBetween('report_sellers.date_purchase', [$filters['from'], $filters['to']])
                                                    /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                    /* ->offset($start)
                                                    ->limit($perpage)
                                                    ->get(); */
                                                    ->paginate($filters['perpage'], ['*'], 'page', $filters['page']);
                                                });
                                                // dd($key);
                                }

                            } else {

                                // dd('test');
                                //not delivery and region;
                                if(!empty($salearea_seller && !empty($adminarea_seller))) {

                                    $filters_page = [
                                        'from'=>$request->from,
                                        'to'=>$request->to,
                                        'salearea_seller' => $salearea_seller,
                                        'adminarea_seller'=>$adminarea_seller,
                                    ];

                                    $key_page = 'sales_page_' . md5(json_encode($filters_page));

                                    $pagination = Cache::remember($key_page, 1800, function () use ($filters_page) {

                                    return ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->join('customers', function (JoinClause $join) {
                                                    $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                })
                                                ->groupBy('report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->where('customers.sale_area', $filters_page['salearea_seller'])
                                                ->where('customers.admin_area', $filters_page['adminarea_seller'])
                                                ->whereBetween('report_sellers.date_purchase', [$filters_page['from'], $filters_page['to']])
                                                // ->where('customers.delivery_by', $delivery)
                                               /*  ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                ->get();
                                            });

                                    $count_page = count($pagination);
                                    // dd($count_page);

                                    $perpage = 10;
                                    $total_page = ceil($count_page / $perpage);
                                    $start = ($perpage * $page) - $perpage;

                                    $filters_customer = [
                                        'from'=>$request->from,
                                        'to'=>$request->to,
                                        'salearea_seller' => $salearea_seller,
                                        'adminarea_seller'=>$adminarea_seller,
                                    ];

                                    $key_customer = 'sales_customer_' . md5(json_encode($filters_customer));

                                    $count_report_customer = Cache::remember($key_customer, 1800, function () use ($filters_customer) {

                                    return ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', DB::raw('COUNT(report_sellers.customer_id) as count_id'))
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.customer_id', 'report_sellers.purchase_order')
                                                            ->where('customers.sale_area', $filters_customer['salearea_seller'])
                                                            ->where('customers.admin_area', $filters_customer['adminarea_seller'])
                                                            ->whereBetween('report_sellers.date_purchase', [$filters_customer['from'], $filters_customer['to']])
                                                            // ->where('customers.delivery_by', $delivery)
                                                            /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                            ->get();
                                                        });
                                        
                                                            //dd($count_report_customer);
                                                            //นับจำนวนร้านค้าแบบไม่ซ้ำ;
                                                            foreach($count_report_customer as $row_id) {
                                                
                                                                $arr_id[] = $row_id->customer_id;
                                                            } 

                                                            //นำตัวที่ซ้ำออก;
                                                            if(isset($arr_id)) {
                                                                $unique = array_unique($arr_id);
                                                                $count_customer_range = count($unique);

                                                            } else {
                                                                $count_customer_range = 0;
                                                            }
                                        
                                        // dd($count_customer_range);

                                    //dashboard;
                                    $filters_po = [
                                        'from'=>$request->from,
                                        'to'=>$request->to,
                                        'salearea_seller' => $salearea_seller,
                                        'adminarea_seller'=>$adminarea_seller,
                                    ];

                                    $key_po = 'sales_po_' . md5(json_encode($filters_po));

                                    $count_po_range = Cache::remember($key_po, 1800, function () use ($filters_po) {

                                    return ReportSeller::select('purchase_order', DB::raw('SUM(price*quantity) as total_sales'))
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.purchase_order')
                                                    ->where('customers.sale_area', $filters_po['salearea_seller'])
                                                    ->where('customers.admin_area', $filters_po['adminarea_seller'])
                                                    ->whereBetween('report_sellers.date_purchase', [$filters_po['from'], $filters_po['to']])
                                                    // ->where('customers.delivery_by', $delivery)
                                                   /*  ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                    ->get();
                                                });

                                    $count_purchase_range = count($count_po_range);
                                    // dd($count_purchase_range);

                                    $filters_selling = [
                                        'from'=>$request->from,
                                        'to'=>$request->to,
                                        'salearea_seller' => $salearea_seller,
                                        'adminarea_seller'=>$adminarea_seller,
                                    ];

                                    $key_selling = 'sales_selling_' . md5(json_encode($filters_selling));

                                    $total_report_selling = Cache::remember($key_selling, 1800, function () use ($filters_selling) {

                                    return ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'purchase_order')
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('purchase_order')
                                                            ->where('customers.sale_area', $filters_selling['salearea_seller'])
                                                            ->where('customers.admin_area', $filters_selling['adminarea_seller'])
                                                            ->whereBetween('report_sellers.date_purchase', [$filters_selling['from'], $filters_selling['to']])
                                                            // ->where('customers.delivery_by', $delivery)
                                                           /*  ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                            ->get();
                                                        });

                                    $filters = [
                                        'from'=>$request->from,
                                        'to'=>$request->to,
                                        // 'start'=>$start,
                                        'page' => $page,
                                        'perpage'=>$perpage,
                                        'salearea_seller' => $salearea_seller,
                                        'adminarea_seller'=>$adminarea_seller,
                                    ];

                                    $startDate = $request->from;
                                    $endDate = $request->to;

                                    $key = 'sales_report_' . md5(json_encode($filters));

                                    $report_seller  = Cache::remember($key, 1800, function () use ($filters) {

                                    return ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name', 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                        ->join('customers', function (JoinClause $join) {
                                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                        })
                                                        ->groupBy('report_sellers.customer_id', 'customers.customer_name' , 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                        ->where('customers.sale_area', $filters['salearea_seller'])
                                                        ->where('customers.admin_area', $filters['adminarea_seller'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters['from'], $filters['to']])
                                                        ->paginate($filters['perpage'], ['*'], 'page', $filters['page']);
                                                        // ->where('customers.delivery_by', $delivery)
                                                    /*  ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                        ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                    /*   ->offset($start)
                                                        ->limit($perpage)
                                                        ->get(); */
                                                    });
                        
                                } else if(!empty($salearea_seller)) {

                                    $filters_page = [
                                        'from'=>$request->from,
                                        'to'=>$request->to,
                                        'salearea_seller'=> $salearea_seller,
                                        ];

                                    $key_page = 'sales_page_' . md5(json_encode($filters_page));

                                    $pagination = Cache::remember($key_page, 1800, function () use ($filters_page) {

                                    return ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->join('customers', function (JoinClause $join) {
                                                    $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                })
                                                ->groupBy('report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->where('customers.sale_area', $filters_page['salearea_seller'])
                                                ->whereBetween('report_sellers.date_purchase', [$filters_page['from'], $filters_page['to']])
                                                // ->where('customers.delivery_by', $delivery)
                                                /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                ->get();
                                            });

                                    $count_page = count($pagination);
                                    // dd($count_page);

                                    $perpage = 10;
                                    $total_page = ceil($count_page / $perpage);
                                    $start = ($perpage * $page) - $perpage;

                                    $filters_customer = [
                                        'from'=>$request->from,
                                        'to'=>$request->to,
                                        'salearea_seller'=> $salearea_seller,
                                        ];

                                    $key_customer = 'sales_customer_' . md5(json_encode($filters_customer));

                                    $count_report_customer = Cache::remember($key_customer, 1800, function () use ($filters_customer) {

                                    return ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', DB::raw('COUNT(report_sellers.customer_id) as count_id'))
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.customer_id', 'report_sellers.purchase_order')
                                                            ->where('customers.sale_area', $filters_customer['salearea_seller'])
                                                            ->whereBetween('report_sellers.date_purchase', [$filters_customer['from'], $filters_customer['to']])
                                                            // ->where('customers.delivery_by', $delivery)
                                                           /*  ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                            ->get();
                                                        });
                
                                    //dd($count_report_customer);
                                    //นับจำนวนร้านค้าแบบไม่ซ้ำ;
                                    foreach($count_report_customer as $row_id) {
                        
                                        $arr_id[] = $row_id->customer_id;
                                    } 

                                    //นำตัวที่ซ้ำออก;
                                    if(isset($arr_id)) {
                                        $unique = array_unique($arr_id);
                                        $count_customer_range = count($unique);

                                    } else {
                                        $count_customer_range = 0;
                                    }
                
                                    // dd($count_customer_range);

                                    //dashboard;
                                    $filters_po = [
                                        'from'=>$request->from,
                                        'to'=>$request->to,
                                        'salearea_seller'=> $salearea_seller,
                                        ];

                                    $key_po = 'sales_po_' . md5(json_encode($filters_po));

                                    $count_po_range = Cache::remember($key_po, 1800, function () use ($filters_po) {

                                    return ReportSeller::select('purchase_order', DB::raw('SUM(price*quantity) as total_sales'))
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.purchase_order')
                                                    ->where('customers.sale_area', $filters_po['salearea_seller'])
                                                    ->whereBetween('report_sellers.date_purchase', [$filters_po['from'], $filters_po['to']])
                                                    // ->where('customers.delivery_by', $delivery)
                                                    /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                    ->get();
                                                });

                                    $count_purchase_range = count($count_po_range);
                                    // dd($count_purchase_range);

                                    $filters_selling = [
                                        'from'=>$request->from,
                                        'to'=>$request->to,
                                        'salearea_seller'=> $salearea_seller,
                                        ];

                                    $key_selling = 'sales_selling_' . md5(json_encode($filters_selling));

                                    $total_report_selling = Cache::remember($key_selling, 1800, function () use ($filters_selling) {

                                    return ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order')
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.purchase_order')
                                                            ->where('customers.sale_area', $filters_selling['salearea_seller'])
                                                            ->whereBetween('report_sellers.date_purchase', [$filters_selling['from'], $filters_selling['to']])
                                                            // ->where('customers.delivery_by', $delivery)
                                                            /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                            ->get();
                                                        });

                                    $filters = [
                                        'from'=>$request->from,
                                        'to'=>$request->to,
                                        'start'=>$start,
                                        'page' => $page,
                                        'perpage'=>$perpage,
                                        'salearea_seller'=> $salearea_seller,
                                        ];

                                    $key = 'sales_report_' . md5(json_encode($filters));

                                    $report_seller  = Cache::remember($key, 1800, function () use ($filters) {

                                    return ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name', 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.customer_id', 'customers.customer_name' , 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->where('customers.sale_area', $filters['salearea_seller'])
                                                    ->whereBetween('report_sellers.date_purchase', [$filters['from'], $filters['to']])
                                                    // ->where('customers.delivery_by', $delivery)
                                                   /*  ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                  /*   ->offset($start)
                                                    ->limit($perpage)
                                                    ->get(); */
                                                    ->paginate($filters['perpage'], ['*'], 'page', $filters['page']);
                                                });

                                } else if(!empty($adminarea_seller)) {

                                    $filters_page = [
                                        'from'=>$request->from,
                                        'to'=>$request->to,
                                        'adminarea_seller'=> $adminarea_seller,
                                        ];

                                    $key_page = 'sales_page_' . md5(json_encode($filters_page));
                                    // dd('test');
                                    $pagination  = Cache::remember($key_page, 1800, function () use ($filters_page) {

                                    return ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->join('customers', function (JoinClause $join) {
                                                    $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                })
                                                ->groupBy('report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->where('customers.admin_area', $filters_page['adminarea_seller'])
                                                ->whereBetween('report_sellers.date_purchase', [$filters_page['from'], $filters_page['to']])
                                                // ->where('customers.delivery_by', $delivery)
                                                /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                ->get();
                                            });
                                            // dd('test');
                                    $count_page = count($pagination);
                                    // dd($count_page);

                                    $perpage = 10;
                                    $total_page = ceil($count_page / $perpage);
                                    $start = ($perpage * $page) - $perpage;

                                    $filters_customer = [
                                        'from'=>$request->from,
                                        'to'=>$request->to,
                                        'adminarea_seller'=> $adminarea_seller,
                                        ];

                                    $key_customer = 'sales_customer_' . md5(json_encode($filters_customer));
                                    // dd('test');
                                    $count_report_customer  = Cache::remember($key_customer, 1800, function () use ($filters_customer) {

                                    return ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', DB::raw('COUNT(report_sellers.customer_id) as count_id'))
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.customer_id', 'report_sellers.purchase_order')
                                                            ->where('customers.admin_area', $filters_customer['adminarea_seller'])
                                                            ->whereBetween('report_sellers.date_purchase', [$filters_customer['from'], $filters_customer['to']])
                                                            // ->where('customers.delivery_by', $delivery)
                                                            /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                            ->get();
                                                        });
                
                                    //dd($count_report_customer);
                                    //นับจำนวนร้านค้าแบบไม่ซ้ำ;
                                    foreach($count_report_customer as $row_id) {
                        
                                        $arr_id[] = $row_id->customer_id;
                                    } 

                                    //นำตัวที่ซ้ำออก;
                                    if(isset($arr_id)) {
                                        $unique = array_unique($arr_id);
                                        $count_customer_range = count($unique);

                                    } else {
                                        $count_customer_range = 0;
                                    }
                
                                    // dd($count_customer_range);

                                    //dashboard;
                                    $filters_po = [
                                        'from'=>$request->from,
                                        'to'=>$request->to,
                                        'adminarea_seller'=> $adminarea_seller,
                                        ];

                                    $key_po = 'sales_po_' . md5(json_encode($filters_po));

                                    $count_po_range = Cache::remember($key_po, 1800, function () use ($filters_po) {

                                    return ReportSeller::select('purchase_order', DB::raw('SUM(price*quantity) as total_sales'))
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.purchase_order')
                                                    ->where('customers.admin_area', $filters_po['adminarea_seller'])
                                                    ->whereBetween('report_sellers.date_purchase', [$filters_po['from'], $filters_po['to']])
                                                    // ->where('customers.delivery_by', $delivery)
                                                    /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                    ->get();
                                                });

                                    $count_purchase_range = count($count_po_range);
                                    // dd($count_purchase_range);

                                    $filters_selling = [
                                        'from'=>$request->from,
                                        'to'=>$request->to,
                                        'adminarea_seller'=> $adminarea_seller,
                                        ];

                                    $key_selling = 'sales_selling_' . md5(json_encode($filters_selling));

                                    $total_report_selling = Cache::remember($key_selling, 1800, function () use ($filters_selling) {

                                    return ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order')
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.purchase_order')
                                                            ->where('customers.admin_area', $filters_selling['adminarea_seller'])
                                                            ->whereBetween('report_sellers.date_purchase', [$filters_selling['from'], $filters_selling['to']])
                                                            // ->where('customers.delivery_by', $delivery)
                                                           /*  ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                            ->get();
                                                        });

                                    $filters = [
                                        'from'=>$request->from,
                                        'to'=>$request->to,
                                        'start'=>$start,
                                        'page' => $page,
                                        'perpage'=>$perpage,
                                        'adminarea_seller'=> $adminarea_seller,
                                        ];

                                    $key = 'sales_report_' . md5(json_encode($filters));

                                    $report_seller  = Cache::remember($key, 1800, function () use ($filters) {

                                    return ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name', 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.customer_id', 'customers.customer_name' , 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->where('customers.admin_area', $filters['adminarea_seller'])
                                                    ->whereBetween('report_sellers.date_purchase', [$filters['from'], $filters['to']])
                                                    // ->where('customers.delivery_by', $delivery)
                                                    /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                    /* ->offset($start)
                                                    ->limit($perpage)
                                                    ->get(); */
                                                    ->paginate($filters['perpage'], ['*'], 'page', $filters['page']);

                                                });
                                
                                } else {

                                    // dd('dd');

                                    $filters_page = [
                                        'from'=>$request->from,
                                        'to'=>$request->to,
                                        ];

                                    $key_page = 'search_report_' . md5(json_encode($filters_page));

                                    $pagination = Cache::remember($key_page, 1800, function () use ($filters_page) {

                                    return ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->join('customers', function (JoinClause $join) {
                                                    $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                })
                                                ->groupBy('purchase_order', 'customer_id')
                                                ->whereBetween('report_sellers.date_purchase', [$filters_page['from'], $filters_page['to']])
                                                // ->where('customers.delivery_by', $delivery)
                                                /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                ->get();

                                            });
                                            
                                    $count_page = count($pagination);
                                    // dd($count_page);

                                    $perpage = 10;
                                    $total_page = ceil($count_page / $perpage);
                                    $start = ($perpage * $page) - $perpage;

                                    $filters_customer = [
                                        'from'=>$request->from,
                                        'to'=>$request->to,
                                        ];

                                    $key_customer = 'count_customer_' . md5(json_encode($filters_customer));

                                    $count_report_customer = Cache::remember($key_customer, 1800, function () use ($filters_customer) {

                                    return ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', DB::raw('COUNT(report_sellers.customer_id) as count_id'))
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.customer_id', 'report_sellers.purchase_order')
                                                            ->whereBetween('date_purchase', [$filters_customer['from'], $filters_customer['to']])
                                                            // ->where('customers.delivery_by', $delivery)
                                                            /* ->whereBetween('date_purchase', [$request->from, $request->to])
                                                            ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                            ->get();
                                                        });
                
                                    //dd($count_report_customer);
                                    //นับจำนวนร้านค้าแบบไม่ซ้ำ;
                                    foreach($count_report_customer as $row_id) {
                        
                                        $arr_id[] = $row_id->customer_id;
                                    } 

                                    //นำตัวที่ซ้ำออก;
                                    if(isset($arr_id)) {
                                        $unique = array_unique($arr_id);
                                        $count_customer_range = count($unique);

                                    } else {
                                        $count_customer_range = 0;
                                    }
                
                                    // dd($count_customer_range);

                                    //dashboard;

                                    $filters_po = [
                                        'from'=>$request->from,
                                        'to'=>$request->to,
                                        ];

                                    $key_po = 'count_po_' . md5(json_encode($filters_po));

                                    $count_po_range = Cache::remember($key_po, 1800, function () use ($filters_po) {

                                    return ReportSeller::select('purchase_order', DB::raw('SUM(price*quantity) as total_sales'))
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.purchase_order')
                                                    ->whereBetween('date_purchase', [$filters_po['from'], $filters_po['to']])
                                                    // ->where('customers.delivery_by', $delivery)
                                                    /* ->whereBetween('date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                    ->get();
                                                });

                                    $count_purchase_range = count($count_po_range);
                                    // dd($count_purchase_range);

                                    $filters_selling = [
                                        'from'=>$request->from,
                                        'to'=>$request->to,
                                        ];

                                    $key_selling = 'count_selling_' . md5(json_encode($filters_selling));

                                    $total_report_selling = Cache::remember($key_selling, 1800, function () use ($filters_selling) {

                                    return ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order')
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.purchase_order')
                                                            ->whereBetween('report_sellers.date_purchase', [$filters_selling['from'], $filters_selling['to']])
                                                            // ->where('customers.delivery_by', $delivery)
                                                            /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                            ->get();
                                                        });

                                    //แบบเดิม;
                                /*     $report_seller = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name', 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.customer_id', 'customers.customer_name' , 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to]) */
                                                    // ->where('customers.delivery_by', $delivery)
                                                    /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])*/
                                                    // ->havingBetween('total_sales', [$range_min, $range_max])
                                                  /*   ->offset($start)
                                                    ->limit($perpage)
                                                    ->get(); */

                                                    $filters = [
                                                        'from' => $request->from,
                                                        'to' => $request->to,
                                                        'page' => $page,
                                                        'perpage' => $perpage,
                                                        ];
                
                                                    $key = 'sale_report_' . md5(json_encode($filters));

                                                    $report_seller  = Cache::remember($key, 1800, function () use ($filters) {

                                                    return $report_seller  = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name', 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                                            ->join('customers', function (JoinClause $join) {
                                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                                            })
                                                                            ->groupBy('report_sellers.customer_id', 'customers.customer_name' , 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                                            ->whereBetween('report_sellers.date_purchase', [$filters['from'], $filters['to']])
                                                                            /* ->offset($filters['start'])
                                                                            ->limit($filters['perpage'])
                                                                            ->get(); */
                                                                            ->paginate($filters['perpage'], ['*'], 'page', $filters['page']);

                                                                        });
// dd($start);
/*                                                     // filter ย่อยเฉพาะช่วงวันที่ที่ต้องการ
                                 
                                                    $filtered = $report_seller->filter(function ($item) use ($startDate, $endDate) {

                                                        return $item->from >= $startDate && $item->to <= $endDate;
                                                        })->values();
 */
                                                        // return response()->json($filtered);          
       
                                }
                             
                            }
                            // dd(config('cache.default'));


                                $customers_data = Customer::select('customer_id', 'sale_area', 'admin_area')->get();
                                $customers_customer_name = Customer::select('customer_id', 'customer_name')->get();

                                return view('report/seller', compact('check_from','check_to', 'admin_area', 'report_seller', 'start', 'total_page', 'page', 'status_alert', 'status_waiting','status_registration', 'status_updated', 'user_id_admin',
                                'count_customer_range', 'count_purchase_range', 'customers_customer_name', 'total_report_selling', 'customers_data','sale_area'));
                    }
            
        } else {
      
            // dd('hello');

           /*  date_default_timezone_set("Asia/Bangkok");
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

            $customers_data = Customer::select('customer_id', 'sale_area', 'admin_area')->get();
            $customers_customer_name = Customer::select('customer_id', 'customer_name')->get();
            // dd($customers_customer_name);

           $filters_last = [
            'from' => $request->from ?? date('Y-m-d'),
            'to'   => $request->to   ?? date('Y-m-d'),
           ];

            $report_seller = ReportSeller::select('customer_id', 'customer_name', DB::raw('SUM(price * quantity) as total_sales', 'purchase_order'))
                                            ->groupBy('customer_id', 'customer_name', 'purchase_order')
                                            ->offset($start)
                                            ->limit($perpage)
                                            ->orderBy('customer_id', 'asc')
                                            ->get();

            $count_customer = ReportSeller::select('customer_id')->whereBetween('date_purchase', [$request->from, $request->to])
                                            ->distinct()
                                            ->get();
            
            $count_customer_all = count($count_customer);

            $total_report_selling = ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'purchase_order')
                                    ->groupBy('purchase_order')
                                    ->whereBetween('date_purchase', [$request->from, $request->to])
                                    ->get(); */
                                 /*    $filters_page = [
                                        'from' => $request->from ?? date('Y-m-d'),
                                        'to'   => $request->to   ?? date('Y-m-d'),
                                       ]; */

                                    $filters_page = [
                                    'from' => $request->from ?? date('Y-m-d'),
                                    'to'   => $request->to   ?? date('Y-m-d'),
    
                                        ];


                                    $key_page = 'sales_page_' . md5(json_encode($filters_page));

                                    $pagination = Cache::remember($key_page, 1800, function () use ($filters_page) {

                                    return ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->join('customers', function (JoinClause $join) {
                                                    $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                })
                                                ->groupBy('report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->whereBetween('report_sellers.date_purchase', [$filters_page['from'], $filters_page['to']])
                                                // ->where('customers.delivery_by', $delivery)
                                                /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                ->get();
                                            });

                                    $count_page = count($pagination);
                                    // dd($count_page);

                                    $perpage = 10;
                                    $total_page = ceil($count_page / $perpage);
                                    $start = ($perpage * $page) - $perpage;

                                    $filters_customer = [
                                        'from' => $request->from ?? date('Y-m-d'),
                                        'to'   => $request->to   ?? date('Y-m-d'),
                                        ];

                                    $key_customer = 'sales_customer_' . md5(json_encode($filters_customer));

                                    $count_report_customer = Cache::remember($key_customer, 1800, function () use ($filters_customer) {

                                    return ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', DB::raw('COUNT(report_sellers.customer_id) as count_id'))
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.customer_id', 'report_sellers.purchase_order')
                                                            ->whereBetween('report_sellers.date_purchase', [$filters_customer['from'], $filters_customer['to']])
                                                            // ->where('customers.delivery_by', $delivery)
                                                           /*  ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                            ->get();
                                                        });
                
                                    //dd($count_report_customer);
                                    //นับจำนวนร้านค้าแบบไม่ซ้ำ;
                                    foreach($count_report_customer as $row_id) {
                        
                                        $arr_id[] = $row_id->customer_id;
                                    } 

                                    //นำตัวที่ซ้ำออก;
                                    if(isset($arr_id)) {
                                        $unique = array_unique($arr_id);
                                        $count_customer_range = count($unique);

                                    } else {
                                        $count_customer_range = 0;
                                    }
                
                                    // dd($count_customer_range);

                                    //dashboard;
                                    $filters_po = [
                                        'from' => $request->from ?? date('Y-m-d'),
                                        'to'   => $request->to   ?? date('Y-m-d'),
         
                                         ];

                                    $key_po = 'sales_po_' . md5(json_encode($filters_po));

                                    $count_po_range = Cache::remember($key_po, 1800, function () use ($filters_po) {

                                    return ReportSeller::select('purchase_order', DB::raw('SUM(price*quantity) as total_sales'))
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.purchase_order')
                                                    ->whereBetween('report_sellers.date_purchase', [$filters_po['from'], $filters_po['to']])
                                                    // ->where('customers.delivery_by', $delivery)
                                                    /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                    ->get();
                                                });

                                    $count_purchase_range = count($count_po_range);
                                    // dd($count_purchase_range);

                                    $filters_selling = [
                                        'from' => $request->from ?? date('Y-m-d'),
                                        'to'   => $request->to   ?? date('Y-m-d'),
         
                                         ];

                                    $key_selling = 'sales_selling_' . md5(json_encode($filters_selling));

                                    $total_report_selling = Cache::remember($key_selling, 1800, function () use ($filters_selling) {

                                    return ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order')
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.purchase_order')
                                                            ->whereBetween('report_sellers.date_purchase', [$filters_selling['from'], $filters_selling['to']])
                                                            // ->where('customers.delivery_by', $delivery)
                                                            /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                            ->get();
                                                        });

                                    $filters = [
                                        'from' => $request->from ?? date('Y-m-d'),
                                        'to'   => $request->to   ?? date('Y-m-d'),
                                        'start'=>$start,
                                        'page' => $page,
                                        'perpage'=>$perpage,
                                        ];

                                    $key = 'sales_report_' . md5(json_encode($filters));

                                    $report_seller  = Cache::remember($key, 1800, function () use ($filters) {

                                    return ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name', 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.customer_id', 'customers.customer_name' , 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->whereBetween('report_sellers.date_purchase', [$filters['from'], $filters['to']])
                                                    // ->where('customers.delivery_by', $delivery)
                                                   /*  ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                  /*   ->offset($start)
                                                    ->limit($perpage)
                                                    ->get(); */
                                                    ->paginate($filters['perpage'], ['*'], 'page', $filters['page']);
                                                });

                                                $customers_data = Customer::select('customer_id', 'sale_area', 'admin_area')->get();
                                                $customers_customer_name = Customer::select('customer_id', 'customer_name')->get();
         
                                                return view('report/seller', compact('check_from','check_to', 'admin_area', 'report_seller', 'start', 'total_page', 'page', 'status_alert', 'status_waiting','status_registration', 'status_updated', 'user_id_admin',
                                                'count_customer_range', 'count_purchase_range', 'customers_customer_name', 'total_report_selling', 'customers_data','sale_area'));
        }

        //Dashborad;
        /* $total_customer = Customer::whereNotIn('customer_code', ['0000','4494'])->count();
        $total_status_waiting = Customer::where('status', 'รอดำเนินการ')->whereNotIn('customer_code', ['0000','4494'])->count();
        $total_status_action = Customer::where('status', 'ต้องดำเนินการ')->whereNotIn('customer_code', ['0000','4494'])->count();
        $total_status_completed = Customer::where('status', 'ดำเนินการแล้ว')->whereNotIn('customer_code', ['0000','4494'])->count();
        $total_status_updated = Customer::where('status_update', 'updated')->whereNotIn('customer_code', ['0000','4494'])->count();
        $customer_status_inactive = Customer::where('customer_status', 'inactive')->whereNotIn('customer_code', ['0000','4494'])->count(); */

        //เพิ่มลูกค้า;
        // $admin_area_list = User::select('admin_area', 'name', 'rights_area', 'user_code')->get();

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
         /*    if(!empty($check_keyword)) {
                return view('report/seller', compact('check_from','check_to', 'check_keyword', 'admin_area', 'customer', 'start', 'total_page', 'page', 'total_customer', 'total_status_waiting',
                            'total_status_action', 'total_status_completed', 'total_status_updated', 'customer_status_inactive', 'status_alert','status_registration', 'status_waiting', 'status_updated','user_id_admin',
                            'count_customer_all'));
        
            } */
            

                // return back();
        }

       /*  return view('report/seller', compact('check_from','check_to', 'admin_area', 'report_seller', 'start', 'total_page', 'page', 'total_customer', 'total_status_waiting',
                'total_status_action', 'total_status_completed', 'total_status_updated', 'customer_status_inactive', 'status_alert', 'status_waiting','status_registration', 'status_updated', 'user_id_admin',
                'count_customer_range')); */

    }

    public function search(Request $request) 
    {

            $check_from = $request->from;
            $check_to = $request->to;

            $page = $request->page;
            if ($page) {
                $page = $request->page;
            } else {
                $page = 1;
            }

            $keyword_search = $request->keyword;
            // dd( $keyword_search);

            $code_notin = ['0000', '4494', '7787', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];

            $status_waiting = Customer::where('status', 'รอดำเนินการ')
                                        ->whereNotIn('customer_id', $code_notin)
                                        ->count();
    
            $status_updated = Customer::where('status_update', 'updated')
                                        ->whereNotIn('customer_id', $code_notin)
                                        ->count();
    
            $status_registration = Customer::where('status', 'ลงทะเบียนใหม่')
                                        // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                        ->whereNotIn('customer_id', $code_notin)
                                        ->count();
    
            $status_alert = $status_waiting + $status_updated;
    
            $user_id_admin = $request->user()->user_id;
    
            //dropdown admin_area;
            $admin_area =  User::where('admin_area', '!=', '')->where('rights_area', '!=', '')->get();
  
            //dropdown sale_area;
            $sale_area =  Salearea::select('sale_area', 'sale_name')->get();

            $filters = [
                'keyword_search' => $keyword_search,
                ];

            $key = 'search_report_' . md5(json_encode($filters));

            $pagination = Cache::remember($key, 1800, function () use ($filters) {

            return ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', DB::raw('COUNT(report_sellers.customer_id) as count_id'))
                                ->join('customers', function (JoinClause $join) {
                                    $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                })
                                ->groupBy('report_sellers.customer_id', 'report_sellers.purchase_order')
                                ->whereNotIn('report_sellers.customer_id', ['0000', '4494', '7787', '9000'])
                                ->where('report_sellers.customer_id', 'Like', "%{$filters['keyword_search']}%")
                                ->orWhere('report_sellers.customer_name', 'Like', "%{$filters['keyword_search']}%")
                                // ->whereBetween('date_purchase', [$request->from, $request->to])
                                // ->where('customers.delivery_by', $delivery)
                                /* ->whereBetween('date_purchase', [$request->from, $request->to])
                                ->havingBetween('total_sales', [$range_min, $range_max]) */
                                ->get();
                            });

            $count_page = count($pagination);

            $perpage = 10;
            $total_page = ceil($count_page / $perpage);
            $start = ($perpage * $page) - $perpage;

            if(isset($keyword_search)) {

                $count_report_customer = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', DB::raw('COUNT(report_sellers.customer_id) as count_id'))
                                        ->join('customers', function (JoinClause $join) {
                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                        })
                                        ->groupBy('report_sellers.customer_id', 'report_sellers.purchase_order')
                                        ->whereNotIn('report_sellers.customer_id', ['0000', '4494', '7787', '9000'])
                                        ->where('report_sellers.customer_id', 'Like', "%{$keyword_search}%")
                                        ->orWhere('report_sellers.customer_name', 'Like', "%{$keyword_search}%")
                                        // ->whereBetween('date_purchase', [$request->from, $request->to])
                                        // ->where('customers.delivery_by', $delivery)
                                        /* ->whereBetween('date_purchase', [$request->from, $request->to])
                                        ->havingBetween('total_sales', [$range_min, $range_max]) */
                                        ->get();

                    //dd($count_report_customer);
                    //นับจำนวนร้านค้าแบบไม่ซ้ำ;
                    foreach($count_report_customer as $row_id) {
        
                        $arr_id[] = $row_id->customer_id;
                    } 

                    //นำตัวที่ซ้ำออก;
                    if(isset($arr_id)) {
                        $unique = array_unique($arr_id);
                        $count_customer_range = count($unique);

                    } else {
                        $count_customer_range = 0;
                    }

                    // dd($count_customer_range);

                    //dashboard;
                    $filters_search_po = [
                        'keyword_search' => $keyword_search,
                        ];
        
                    $key_search_po = 'search_po_' . md5(json_encode($filters_search_po));
        
                    $count_po_range = Cache::remember($key_search_po, 1800, function () use ($filters_search_po) {

                    return ReportSeller::select('purchase_order', DB::raw('SUM(price*quantity) as total_sales'))
                                        ->join('customers', function (JoinClause $join) {
                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                        })
                                        ->groupBy('report_sellers.purchase_order')
                                        ->whereNotIn('report_sellers.customer_id', ['0000', '4494', '7787', '9000'])
                                        ->where('report_sellers.customer_id', 'Like', "%{$filters_search_po['keyword_search']}%")
                                        ->orWhere('customers.customer_name', 'Like', "%{$filters_search_po['keyword_search']}%")
                                        // ->whereBetween('date_purchase', [$request->from, $request->to])
                                        // ->where('customers.delivery_by', $delivery)
                                        /* ->whereBetween('date_purchase', [$request->from, $request->to])
                                        ->havingBetween('total_sales', [$range_min, $range_max]) */
                                        ->get();
                                    });

                    $count_purchase_range = count($count_po_range);
                    // dd($count_purchase_range);

                    $filters_search_selling = [
                        'keyword_search' => $keyword_search,
                        ];
        
                    $key_search_selling = 'search_selling_' . md5(json_encode($filters_search_selling));
        
                    $total_report_selling = Cache::remember($key_search_selling, 1800, function () use ($filters_search_selling) {
                        
                    return ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order')
                                        ->join('customers', function (JoinClause $join) {
                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                        })
                                        ->groupBy('report_sellers.purchase_order')
                                        ->whereNotIn('report_sellers.customer_id', ['0000', '4494', '7787', '9000'])
                                        ->where('report_sellers.customer_id', 'Like', "%{$filters_search_selling['keyword_search']}%")
                                        ->orWhere('customers.customer_name', 'Like', "%{$filters_search_selling['keyword_search']}%")
                                        // ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                        // ->where('customers.delivery_by', $delivery)
                                        /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                        ->havingBetween('total_sales', [$range_min, $range_max]) */
                                        ->get();
                                    });

                    $filters_search_report = [
                        'keyword_search' => $keyword_search,
                        'page' => $page,
                        'perpage' => $perpage,
                        ];
        
                    $key_search_report = 'search_report_' . md5(json_encode( $filters_search_report));
        
                    $report_seller = Cache::remember($key_search_report, 1800, function () use ( $filters_search_report) {

                    return ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name', 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                        ->join('customers', function (JoinClause $join) {
                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                        })
                                        ->groupBy('report_sellers.customer_id', 'customers.customer_name' , 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                        ->whereNotIn('report_sellers.customer_id', ['0000', '4494', '7787', '9000'])
                                        ->where('report_sellers.customer_id', 'Like', "%{$filters_search_report['keyword_search']}%")
                                        ->orWhere('customers.customer_name', 'Like', "%{$filters_search_report['keyword_search']}%")
                                    /*  ->offset($start)
                                        ->limit($perpage) */
                                        // ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                        // ->where('customers.delivery_by', $delivery)
                                        /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                        ->havingBetween('total_sales', [$range_min, $range_max]) */
                        
                                    /*   ->get(); */
                                    ->paginate($filters_search_report['perpage'], ['*'], 'page', $filters_search_report['page']);
                                    });
                
                    $count_customer = ReportSeller::select('customer_id')->whereBetween('date_purchase', [$request->from, $request->to])
                                    ->distinct()
                                    ->get();
    
                    $count_customer_all = count($count_customer);

                    $customers_data = Customer::select('customer_id', 'sale_area', 'admin_area')->get();
                    $customers_customer_name = Customer::select('customer_id', 'customer_name')->get();

                    return view('report/seller', compact('admin_area', 'report_seller', 'status_alert', 'total_page', 'page', 'start', 'status_waiting','status_registration', 'status_updated', 'user_id_admin',
                                'count_customer_range', 'count_purchase_range', 'customers_customer_name', 'total_report_selling', 'customers_data','sale_area'));
            } else {
                 
                return redirect()->back();
            }
    }
    

    public function import(Request $request)
    {
        //notin code;
        $code_notin = ['0000', '4494', '7787', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];

         //menu alert;
         $status_waiting = Customer::where('status', 'รอดำเนินการ')
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();

        $status_updated = Customer::where('status_update', 'updated')
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();

        $status_registration = Customer::where('status', 'ลงทะเบียนใหม่')
                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();

        $status_alert = $status_waiting + $status_updated;


        $user_id_admin = $request->user()->user_id;

        return view('/report/importseller', compact('status_alert', 'status_waiting', 'status_updated', 'status_registration', 'user_id_admin'));
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

                    $rename = 'Seller_all'.'_'.date("l jS \of F Y h:i:s A").'.csv';
                    $directory = $request->file('import_csv')->storeAs('importcsv',$rename,'importfiles'); //importfiles filesystem.php->disk;
                    $fileStream = fopen(storage_path('app/public/importcsv/'.$rename),'r');
                    // fgetcsv($fileStream); // skip header
                    
                    while (!feof($fileStream)) 
                            {

                                $row = fgetcsv($fileStream , 1000 , "|");
                                // dd($row[0]);
                                if(!empty($row[0])) {
                            
                                    if (isset($row[8]) && $row[8] === 'โค้ด') {
                                        $price = 0;
                                        $cost = 0;

                                    } else {
                                        $price = $row[5];
                                        $cost = empty($row[6]) ? 0 : $row[6];
                                    }
                                    
                                    
                            
                                    ReportSeller::create([

                                        'purchase_order' => $row[0],
                                        'report_sellers_id' => $row[1],
                                        'customer_id' => $row[1],
                                        'customer_name' => $row[2],
                                        'product_id' => $row[3],
                                        'product_name' => $row[4],
                                        'price' => $price,
                                        'cost' => $cost,
                                        'quantity' => $row[7],
                                        'unit' => $row[8],
                                        'date_purchase' => $row[9],
                
                                        ]);
                                }

                        }

                       /*  while (($row = fgetcsv($fileStream , 1000 , "|")) !== false) {

                            // dd($row[0]);
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

                        } */

                        fclose($fileStream);

                }

        }
        $count = ReportSeller::all()->count();
        
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
    public function show(Request $request)
    {

        $customer_id = $request->id;
        $customer_name = Customer::where('customer_id',$customer_id)->first();

        $from_purchase = $request->from;
        $to_purchase = $request->to;
        $purchase_check = $request->po;
        // dd($purchase_check);
        // dd($to_purchase);

        if(!empty($from_purchase) && !empty($to_purchase)) {
            
            $order_selling = ReportSeller::where('customer_id',$customer_id)
                            ->where('purchase_order', $purchase_check)
                            ->whereBetween('date_purchase', [$from_purchase, $to_purchase])
                            // ->distinct()
                            ->get();

            $purchase_order = ReportSeller::select('purchase_order','date_purchase')->where('customer_id',$customer_id)
                            ->where('purchase_order', $purchase_check)
                            ->whereBetween('date_purchase', [$from_purchase, $to_purchase])
                            ->distinct()
                            ->get();

        } else {

            $order_selling = ReportSeller::where('customer_id',$customer_id)
                            ->where('purchase_order', $purchase_check)
                            ->get();

            $purchase_order = ReportSeller::select('purchase_order','date_purchase')->where('customer_id',$customer_id)
                            ->where('purchase_order', $purchase_check)
                            ->distinct()
                            ->get();
        }
           

     /*    foreach($purchase_order as $row_po) {
            $order_selling_date = ReportSeller::where('purchase_order', $row_po->purchase_order)->first();
            // dd($order_selling_date->purchase_order);
        } */
       
       /*  $date_purchase = ReportSeller::select('date_purchase')->where('purchase_order', $purchase_order->purchase_order)->first();
        dd($date_purchase->date_purchase); */

        // dd($order_selling->product_id);
        //Dashborad;
        $total_customer = Customer::whereNotIn('customer_code', ['0000','4494'])->count();
        $total_status_waiting = Customer::where('status', 'รอดำเนินการ')->whereNotIn('customer_code', ['0000','4494'])->count();
        $total_status_action = Customer::where('status', 'ต้องดำเนินการ')->whereNotIn('customer_code', ['0000','4494'])->count();
        $total_status_completed = Customer::where('status', 'ดำเนินการแล้ว')->whereNotIn('customer_code', ['0000','4494'])->count();
        $total_status_updated = Customer::where('status_update', 'updated')->whereNotIn('customer_code', ['0000','4494'])->count();
        $customer_status_inactive = Customer::where('customer_status', 'inactive')->whereNotIn('customer_code', ['0000','4494'])->count();

        //เพิ่มลูกค้า;
        // $admin_area_list = User::select('admin_area', 'name', 'rights_area', 'user_code')->get();

        //notin code;
        $code_notin = ['0000', '4494', '7787', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];

        $status_waiting = Customer::where('status', 'รอดำเนินการ')
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();

        $status_updated = Customer::where('status_update', 'updated')
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();

        $status_registration = Customer::where('status', 'ลงทะเบียนใหม่')
                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();

        $status_alert = $status_waiting + $status_updated;

        $user_id_admin = $request->user()->user_id;

        return view('report/seller-detail', compact('total_customer', 'total_status_waiting', 'customer_id', 'customer_name', 'order_selling', 'purchase_order', 
                        'total_status_action', 'total_status_completed', 'total_status_updated', 'customer_status_inactive', 'status_alert','status_registration', 'status_waiting', 'status_updated','user_id_admin'));
        
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

        $user_id_admin = $request->user()->user_id;
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
                            'total_status_action', 'total_status_completed', 'total_status_updated', 'customer_status_inactive', 'status_alert', 'status_waiting', 'status_updated', 'user_id_admin'));
        
            }
            

                // return back();
        }

        return view('report/seller', compact('check_from','check_to', 'admin_area', 'report_seller', 'start', 'total_page', 'page', 'total_customer', 'total_status_waiting',
                'total_status_action', 'total_status_completed', 'total_status_updated', 'customer_status_inactive', 'status_alert', 'status_waiting', 'status_updated', 'user_id_admin'));

    }
}
