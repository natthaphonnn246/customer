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

                                    $pagination = ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->join('customers', function (JoinClause $join) {
                                                    $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                })
                                                ->groupBy('report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->where('customers.sale_area', $salearea_seller)
                                                ->where('customers.admin_area', $adminarea_seller)
                                                ->where('customers.geography', $region)
                                                ->where('customers.delivery_by', $delivery)
                                                ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                ->havingBetween('total_sales', [$range_min, $range_max])
                                                ->get();
                                    $count_page = count($pagination);
                                    // dd($count_page);

                                    $perpage = 10;
                                    $total_page = ceil($count_page / $perpage);
                                    $start = ($perpage * $page) - $perpage;

                                    $count_report_customer = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', DB::raw('COUNT(report_sellers.customer_id) as count_id'))
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.customer_id', 'report_sellers.purchase_order')
                                                            ->where('customers.sale_area', $salearea_seller)
                                                            ->where('customers.admin_area', $adminarea_seller)
                                                            ->where('customers.geography', $region)
                                                            ->where('customers.delivery_by', $delivery)
                                                            ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            ->havingBetween('total_sales', [$range_min, $range_max])
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
                                    $count_po_range = ReportSeller::select('purchase_order', DB::raw('SUM(price*quantity) as total_sales'))
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.purchase_order')
                                                    ->where('customers.sale_area', $salearea_seller)
                                                    ->where('customers.admin_area', $adminarea_seller)
                                                    ->where('customers.geography', $region)
                                                    ->where('customers.delivery_by', $delivery)
                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max])
                                                    ->get();

                                    $count_purchase_range = count($count_po_range);
                                    // dd($count_purchase_range);

                                    $total_report_selling = ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order')
                                                                    ->join('customers', function (JoinClause $join) {
                                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                                    })
                                                                    ->groupBy('report_sellers.purchase_order')
                                                                    ->where('customers.sale_area', $salearea_seller)
                                                                    ->where('customers.admin_area', $adminarea_seller)
                                                                    ->where('customers.geography', $region)
                                                                    ->where('customers.delivery_by', $delivery)
                                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                                    ->havingBetween('total_sales', [$range_min, $range_max])
                                                                    ->get();

                                    // dd($total_report_selling);
                                    $report_seller = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name', 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.customer_id', 'customers.customer_name' , 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->where('customers.sale_area', $salearea_seller)
                                                    ->where('customers.admin_area', $adminarea_seller)
                                                    ->where('customers.geography', $region)
                                                    ->where('customers.delivery_by', $delivery)
                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max])
                                                    ->offset($start)
                                                    ->limit($perpage)
                                                    ->get();
                        
                                } else if(!empty($salearea_seller)) {

                                    $pagination = ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->join('customers', function (JoinClause $join) {
                                                    $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                })
                                                ->groupBy('report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->where('customers.sale_area', $salearea_seller)
                                                ->where('customers.geography', $region)
                                                ->where('customers.delivery_by', $delivery)
                                                ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                ->havingBetween('total_sales', [$range_min, $range_max])
                                                ->get();

                                    $count_page = count($pagination);
                                    // dd($count_page);

                                    $perpage = 10;
                                    $total_page = ceil($count_page / $perpage);
                                    $start = ($perpage * $page) - $perpage;

                                    $count_report_customer = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', DB::raw('COUNT(report_sellers.customer_id) as count_id'))
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.customer_id', 'report_sellers.purchase_order')
                                                            ->where('customers.sale_area', $salearea_seller)
                                                            ->where('customers.geography', $region)
                                                            ->where('customers.delivery_by', $delivery)
                                                            ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            ->havingBetween('total_sales', [$range_min, $range_max])
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
                                    $count_po_range = ReportSeller::select('purchase_order', DB::raw('SUM(price*quantity) as total_sales'))
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.purchase_order')
                                                    ->where('customers.sale_area', $salearea_seller)
                                                    ->where('customers.geography', $region)
                                                    ->where('customers.delivery_by', $delivery)
                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max])
                                                    ->get();

                                    $count_purchase_range = count($count_po_range);
                                    // dd($count_purchase_range);

                                    $total_report_selling = ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order')
                                                                    ->join('customers', function (JoinClause $join) {
                                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                                    })
                                                                    ->groupBy('report_sellers.purchase_order')
                                                                    ->where('customers.sale_area', $salearea_seller)
                                                                    ->where('customers.geography', $region)
                                                                    ->where('customers.delivery_by', $delivery)
                                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                                    ->havingBetween('total_sales', [$range_min, $range_max])
                                                                    ->get();

                                    $report_seller = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name', 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.customer_id', 'customers.customer_name' , 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->where('customers.sale_area', $salearea_seller)
                                                    ->where('customers.geography', $region)
                                                    ->where('customers.delivery_by', $delivery)
                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max])
                                                    ->offset($start)
                                                    ->limit($perpage)
                                                    ->get();

                                } else if(!empty($adminarea_seller)) {

                                    $pagination = ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->join('customers', function (JoinClause $join) {
                                                    $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                })
                                                ->groupBy('report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->where('customers.admin_area', $adminarea_seller)
                                                ->where('customers.geography', $region)
                                                ->where('customers.delivery_by', $delivery)
                                                ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                ->havingBetween('total_sales', [$range_min, $range_max])
                                                ->get();

                                    $count_page = count($pagination);
                                    // dd($count_page);

                                    $perpage = 10;
                                    $total_page = ceil($count_page / $perpage);
                                    $start = ($perpage * $page) - $perpage;

                                    $count_report_customer = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', DB::raw('COUNT(report_sellers.customer_id) as count_id'))
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.customer_id', 'report_sellers.purchase_order')
                                                            ->where('customers.admin_area', $adminarea_seller)
                                                            ->where('customers.geography', $region)
                                                            ->where('customers.delivery_by', $delivery)
                                                            ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            ->havingBetween('total_sales', [$range_min, $range_max])
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
                                    $count_po_range = ReportSeller::select('purchase_order', DB::raw('SUM(price*quantity) as total_sales'))
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.purchase_order')
                                                    ->where('customers.admin_area', $adminarea_seller)
                                                    ->where('customers.geography', $region)
                                                    ->where('customers.delivery_by', $delivery)
                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max])
                                                    ->get();

                                    $count_purchase_range = count($count_po_range);
                                    // dd($count_purchase_range);

                                    $total_report_selling = ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order')
                                                                    ->join('customers', function (JoinClause $join) {
                                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                                    })
                                                                    ->groupBy('report_sellers.purchase_order')
                                                                    ->where('customers.admin_area', $adminarea_seller)
                                                                    ->where('customers.geography', $region)
                                                                    ->where('customers.delivery_by', $delivery)
                                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                                    ->havingBetween('total_sales', [$range_min, $range_max])
                                                                    ->get();

                                    $report_seller = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name', 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.customer_id', 'customers.customer_name' , 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->where('customers.admin_area', $adminarea_seller)
                                                    ->where('customers.geography', $region)
                                                    ->where('customers.delivery_by', $delivery)
                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max])
                                                    ->offset($start)
                                                    ->limit($perpage)
                                                    ->get();
                                
                                } else {

                                    $pagination = ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->join('customers', function (JoinClause $join) {
                                                    $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                })
                                                ->groupBy('purchase_order', 'customer_id')
                                                ->where('customers.geography', $region)
                                                ->where('customers.delivery_by', $delivery)
                                                ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                ->havingBetween('total_sales', [$range_min, $range_max])
                                                ->get();

                                    $count_page = count($pagination);
                                    // dd($count_page);

                                    $perpage = 10;
                                    $total_page = ceil($count_page / $perpage);
                                    $start = ($perpage * $page) - $perpage;

                                    $count_report_customer = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', DB::raw('COUNT(report_sellers.customer_id) as count_id'))
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.customer_id', 'report_sellers.purchase_order')
                                                            ->where('customers.geography', $region)
                                                            ->where('customers.delivery_by', $delivery)
                                                            ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            ->havingBetween('total_sales', [$range_min, $range_max])
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
                                    $count_po_range = ReportSeller::select('purchase_order', DB::raw('SUM(price*quantity) as total_sales'))
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.purchase_order')
                                                    ->where('customers.geography', $region)
                                                    ->where('customers.delivery_by', $delivery)
                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max])
                                                    ->get();

                                    $count_purchase_range = count($count_po_range);
                                    // dd($count_purchase_range);

                                    $total_report_selling = ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order')
                                                                    ->join('customers', function (JoinClause $join) {
                                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                                    })
                                                                    ->groupBy('report_sellers.purchase_order')
                                                                    ->where('customers.geography', $region)
                                                                    ->where('customers.delivery_by', $delivery)
                                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                                    ->havingBetween('total_sales', [$range_min, $range_max])
                                                                    ->get();

                                    $report_seller = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name', 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.customer_id', 'customers.customer_name' , 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->where('customers.geography', $region)
                                                    ->where('customers.delivery_by', $delivery)
                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max])
                                                    ->offset($start)
                                                    ->limit($perpage)
                                                    ->get();
                                }

                            } else if (!empty($region)) {
                                //code check region;
                                if(!empty($salearea_seller && !empty($adminarea_seller))) {

                                    $pagination = ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->join('customers', function (JoinClause $join) {
                                                    $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                })
                                                ->groupBy('report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->where('customers.sale_area', $salearea_seller)
                                                ->where('customers.admin_area', $adminarea_seller)
                                                ->where('customers.geography', $region)
                                                ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                ->havingBetween('total_sales', [$range_min, $range_max])
                                                ->get();
                                    $count_page = count($pagination);
                                    // dd($count_page);

                                    $perpage = 10;
                                    $total_page = ceil($count_page / $perpage);
                                    $start = ($perpage * $page) - $perpage;

                                    $count_report_customer = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', DB::raw('COUNT(report_sellers.customer_id) as count_id'))
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.customer_id', 'report_sellers.purchase_order')
                                                            ->where('customers.sale_area', $salearea_seller)
                                                            ->where('customers.admin_area', $adminarea_seller)
                                                            ->where('customers.geography', $region)
                                                            ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            ->havingBetween('total_sales', [$range_min, $range_max])
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
                                    $count_po_range = ReportSeller::select('purchase_order', DB::raw('SUM(price*quantity) as total_sales'))
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.purchase_order')
                                                    ->where('customers.sale_area', $salearea_seller)
                                                    ->where('customers.admin_area', $adminarea_seller)
                                                    ->where('customers.geography', $region)
                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max])
                                                    ->get();

                                    $count_purchase_range = count($count_po_range);
                                    // dd($count_purchase_range);

                                    $total_report_selling = ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order')
                                                                    ->join('customers', function (JoinClause $join) {
                                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                                    })
                                                                    ->groupBy('report_sellers.purchase_order')
                                                                    ->where('customers.sale_area', $salearea_seller)
                                                                    ->where('customers.admin_area', $adminarea_seller)
                                                                    ->where('customers.geography', $region)
                                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                                    ->havingBetween('total_sales', [$range_min, $range_max])
                                                                    ->get();

                                    $report_seller = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name', 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.customer_id', 'customers.customer_name' , 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->where('customers.sale_area', $salearea_seller)
                                                    ->where('customers.admin_area', $adminarea_seller)
                                                    ->where('customers.geography', $region)
                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max])
                                                    ->offset($start)
                                                    ->limit($perpage)
                                                    ->get();
                        
                                } else if(!empty($salearea_seller)) {

                                    $pagination = ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->join('customers', function (JoinClause $join) {
                                                    $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                })
                                                ->groupBy('report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->where('customers.sale_area', $salearea_seller)
                                                ->where('customers.geography', $region)
                                                ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                ->havingBetween('total_sales', [$range_min, $range_max])
                                                ->get();

                                    $count_page = count($pagination);
                                    // dd($count_page);

                                    $perpage = 10;
                                    $total_page = ceil($count_page / $perpage);
                                    $start = ($perpage * $page) - $perpage;

                                    $count_report_customer = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', DB::raw('COUNT(report_sellers.customer_id) as count_id'))
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.customer_id', 'report_sellers.purchase_order')
                                                            ->where('customers.sale_area', $salearea_seller)
                                                            ->where('customers.geography', $region)
                                                            ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            ->havingBetween('total_sales', [$range_min, $range_max])
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
                                    $count_po_range = ReportSeller::select('purchase_order', DB::raw('SUM(price*quantity) as total_sales'))
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.purchase_order')
                                                    ->where('customers.sale_area', $salearea_seller)
                                                    ->where('customers.geography', $region)
                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max])
                                                    ->get();

                                    $count_purchase_range = count($count_po_range);
                                    // dd($count_purchase_range);

                                    $total_report_selling = ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order')
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.purchase_order')
                                                            ->where('customers.sale_area', $salearea_seller)
                                                            ->where('customers.geography', $region)
                                                            ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            ->havingBetween('total_sales', [$range_min, $range_max])
                                                            ->get();

                                    $report_seller = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name', 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.customer_id', 'customers.customer_name' , 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->where('customers.sale_area', $salearea_seller)
                                                    ->where('customers.geography', $region)
                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max])
                                                    ->offset($start)
                                                    ->limit($perpage)
                                                    ->get();
                                } else if(!empty($adminarea_seller)) {

                                    $pagination = ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->join('customers', function (JoinClause $join) {
                                                    $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                })
                                                ->groupBy('report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->where('customers.admin_area', $adminarea_seller)
                                                ->where('customers.geography', $region)
                                                ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                ->havingBetween('total_sales', [$range_min, $range_max])
                                                ->get();
                                    $count_page = count($pagination);
                                    // dd($count_page);

                                    $perpage = 10;
                                    $total_page = ceil($count_page / $perpage);
                                    $start = ($perpage * $page) - $perpage;

                                    $count_report_customer = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', DB::raw('COUNT(report_sellers.customer_id) as count_id'))
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.customer_id', 'report_sellers.purchase_order')
                                                            ->where('customers.admin_area', $adminarea_seller)
                                                            ->where('customers.geography', $region)
                                                            ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            ->havingBetween('total_sales', [$range_min, $range_max])
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
                                    $count_po_range = ReportSeller::select('purchase_order', DB::raw('SUM(price*quantity) as total_sales'))
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.purchase_order')
                                                    ->where('customers.admin_area', $adminarea_seller)
                                                    ->where('customers.geography', $region)
                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max])
                                                    ->get();

                                    $count_purchase_range = count($count_po_range);
                                    // dd($count_purchase_range);

                                    $total_report_selling = ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order')
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.purchase_order')
                                                            ->where('customers.admin_area', $adminarea_seller)
                                                            ->where('customers.geography', $region)
                                                            ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            ->havingBetween('total_sales', [$range_min, $range_max])
                                                            ->get();


                                    $report_seller = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name', 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.customer_id', 'customers.customer_name' , 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->where('customers.admin_area', $adminarea_seller)
                                                    ->where('customers.geography', $region)
                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max])
                                                    ->offset($start)
                                                    ->limit($perpage)
                                                    ->get();
                                
                                } else {

                                    $pagination = ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->join('customers', function (JoinClause $join) {
                                                    $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                })
                                                ->groupBy('report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->where('customers.geography', $region)
                                                ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                ->havingBetween('total_sales', [$range_min, $range_max])
                                                ->get();
                                    $count_page = count($pagination);
                                    // dd($count_page);

                                    $perpage = 10;
                                    $total_page = ceil($count_page / $perpage);
                                    $start = ($perpage * $page) - $perpage;

                                    $count_report_customer = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', DB::raw('COUNT(report_sellers.customer_id) as count_id'))
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.customer_id', 'report_sellers.purchase_order')
                                                            ->where('customers.geography', $region)
                                                            ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            ->havingBetween('total_sales', [$range_min, $range_max])
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
                                    $count_po_range = ReportSeller::select('purchase_order', DB::raw('SUM(price*quantity) as total_sales'))
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.purchase_order')
                                                    ->where('customers.geography', $region)
                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max])
                                                    ->get();

                                    $count_purchase_range = count($count_po_range);
                                    // dd($count_purchase_range);

                                    $total_report_selling = ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order')
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.purchase_order')
                                                            ->where('customers.geography', $region)
                                                            ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            ->havingBetween('total_sales', [$range_min, $range_max])
                                                            ->get();

                                    $report_seller = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name', 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.customer_id', 'customers.customer_name' , 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->where('customers.geography', $region)
                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max])
                                                    ->offset($start)
                                                    ->limit($perpage)
                                                    ->get();
                                }

                            } else if (!empty($delivery)) {
                                //code check delivery;
                                if(!empty($salearea_seller && !empty($adminarea_seller))) {

                                    $pagination = ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->join('customers', function (JoinClause $join) {
                                                    $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                })
                                                ->groupBy('report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->where('customers.sale_area', $salearea_seller)
                                                ->where('customers.admin_area', $adminarea_seller)
                                                ->where('customers.delivery_by', $delivery)
                                                ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                ->havingBetween('total_sales', [$range_min, $range_max])
                                                ->get();
                                    $count_page = count($pagination);
                                    // dd($count_page);

                                    $perpage = 10;
                                    $total_page = ceil($count_page / $perpage);
                                    $start = ($perpage * $page) - $perpage;

                                    $count_report_customer = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', DB::raw('COUNT(report_sellers.customer_id) as count_id'))
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.customer_id', 'report_sellers.purchase_order')
                                                            ->where('customers.sale_area', $salearea_seller)
                                                            ->where('customers.admin_area', $adminarea_seller)
                                                            ->where('customers.delivery_by', $delivery)
                                                            ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            ->havingBetween('total_sales', [$range_min, $range_max])
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
                                    $count_po_range = ReportSeller::select('purchase_order', DB::raw('SUM(price*quantity) as total_sales'))
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.purchase_order')
                                                    ->where('customers.sale_area', $salearea_seller)
                                                    ->where('customers.admin_area', $adminarea_seller)
                                                    ->where('customers.delivery_by', $delivery)
                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max])
                                                    ->get();

                                    $count_purchase_range = count($count_po_range);
                                    // dd($count_purchase_range);

                                    $total_report_selling = ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'purchase_order')
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('purchase_order')
                                                            ->where('customers.sale_area', $salearea_seller)
                                                            ->where('customers.admin_area', $adminarea_seller)
                                                            ->where('customers.delivery_by', $delivery)
                                                            ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            ->havingBetween('total_sales', [$range_min, $range_max])
                                                            ->get();

                                    $report_seller = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name', 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.customer_id', 'customers.customer_name' , 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->where('customers.sale_area', $salearea_seller)
                                                    ->where('customers.admin_area', $adminarea_seller)
                                                    ->where('customers.delivery_by', $delivery)
                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max])
                                                    ->offset($start)
                                                    ->limit($perpage)
                                                    ->get();
                        
                                } else if(!empty($salearea_seller)) {

                                    $pagination = ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->join('customers', function (JoinClause $join) {
                                                    $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                })
                                                ->groupBy('report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->where('customers.sale_area', $salearea_seller)
                                                ->where('customers.delivery_by', $delivery)
                                                ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                ->havingBetween('total_sales', [$range_min, $range_max])
                                                ->get();

                                    $count_page = count($pagination);
                                    // dd($count_page);

                                    $perpage = 10;
                                    $total_page = ceil($count_page / $perpage);
                                    $start = ($perpage * $page) - $perpage;

                                    $count_report_customer = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', DB::raw('COUNT(report_sellers.customer_id) as count_id'))
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.customer_id', 'report_sellers.purchase_order')
                                                            ->where('customers.sale_area', $salearea_seller)
                                                            ->where('customers.delivery_by', $delivery)
                                                            ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            ->havingBetween('total_sales', [$range_min, $range_max])
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
                                    $count_po_range = ReportSeller::select('purchase_order', DB::raw('SUM(price*quantity) as total_sales'))
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.purchase_order')
                                                    ->where('customers.sale_area', $salearea_seller)
                                                    ->where('customers.delivery_by', $delivery)
                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max])
                                                    ->get();

                                    $count_purchase_range = count($count_po_range);
                                    // dd($count_purchase_range);

                                    $total_report_selling = ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order')
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.purchase_order')
                                                            ->where('customers.sale_area', $salearea_seller)
                                                            ->where('customers.delivery_by', $delivery)
                                                            ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            ->havingBetween('total_sales', [$range_min, $range_max])
                                                            ->get();

                                    $report_seller = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name', 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.customer_id', 'customers.customer_name' , 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->where('customers.sale_area', $salearea_seller)
                                                    ->where('customers.delivery_by', $delivery)
                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max])
                                                    ->offset($start)
                                                    ->limit($perpage)
                                                    ->get();

                                } else if(!empty($adminarea_seller)) {

                                    $pagination = ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->join('customers', function (JoinClause $join) {
                                                    $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                })
                                                ->groupBy('report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->where('customers.admin_area', $adminarea_seller)
                                                ->where('customers.delivery_by', $delivery)
                                                ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                ->havingBetween('total_sales', [$range_min, $range_max])
                                                ->get();

                                    $count_page = count($pagination);
                                    // dd($count_page);

                                    $perpage = 10;
                                    $total_page = ceil($count_page / $perpage);
                                    $start = ($perpage * $page) - $perpage;

                                    $count_report_customer = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', DB::raw('COUNT(report_sellers.customer_id) as count_id'))
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.customer_id', 'report_sellers.purchase_order')
                                                            ->where('customers.admin_area', $adminarea_seller)
                                                            ->where('customers.delivery_by', $delivery)
                                                            ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            ->havingBetween('total_sales', [$range_min, $range_max])
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
                                    $count_po_range = ReportSeller::select('purchase_order', DB::raw('SUM(price*quantity) as total_sales'))
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.purchase_order')
                                                    ->where('customers.admin_area', $adminarea_seller)
                                                    ->where('customers.delivery_by', $delivery)
                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max])
                                                    ->get();

                                    $count_purchase_range = count($count_po_range);
                                    // dd($count_purchase_range);

                                    $total_report_selling = ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order')
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.purchase_order')
                                                            ->where('customers.admin_area', $adminarea_seller)
                                                            ->where('customers.delivery_by', $delivery)
                                                            ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            ->havingBetween('total_sales', [$range_min, $range_max])
                                                            ->get();

                                    $report_seller = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name', 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.customer_id', 'customers.customer_name' , 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->where('customers.admin_area', $adminarea_seller)
                                                    ->where('customers.delivery_by', $delivery)
                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max])
                                                    ->offset($start)
                                                    ->limit($perpage)
                                                    ->get();
                                
                                } else {

                                    $pagination = ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->join('customers', function (JoinClause $join) {
                                                    $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                })
                                                ->groupBy('purchase_order', 'customer_id')
                                                ->where('customers.delivery_by', $delivery)
                                                ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                ->havingBetween('total_sales', [$range_min, $range_max])
                                                ->get();
                                    $count_page = count($pagination);
                                    // dd($count_page);

                                    $perpage = 10;
                                    $total_page = ceil($count_page / $perpage);
                                    $start = ($perpage * $page) - $perpage;

                                    $count_report_customer = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', DB::raw('COUNT(report_sellers.customer_id) as count_id'))
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.customer_id', 'report_sellers.purchase_order')
                                                            ->where('customers.delivery_by', $delivery)
                                                            ->whereBetween('date_purchase', [$request->from, $request->to])
                                                            ->havingBetween('total_sales', [$range_min, $range_max])
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
                                    $count_po_range = ReportSeller::select('purchase_order', DB::raw('SUM(price*quantity) as total_sales'))
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.purchase_order')
                                                    ->where('customers.delivery_by', $delivery)
                                                    ->whereBetween('date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max])
                                                    ->get();

                                    $count_purchase_range = count($count_po_range);
                                    // dd($count_purchase_range);

                                    $total_report_selling = ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order')
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.purchase_order')
                                                            ->where('customers.delivery_by', $delivery)
                                                            ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            ->havingBetween('total_sales', [$range_min, $range_max])
                                                            ->get();

                                    $report_seller = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name', 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.customer_id', 'customers.customer_name' , 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->where('customers.delivery_by', $delivery)
                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max])
                                                    ->offset($start)
                                                    ->limit($perpage)
                                                    ->get();
                                }

                            } else {

                                //not delivery and region;
                                if(!empty($salearea_seller && !empty($adminarea_seller))) {

                                    $pagination = ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', 'report_sellers.customer_id')
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.purchase_order', 'report_sellers.customer_id')
                                                    ->where('customers.sale_area', $salearea_seller)
                                                    ->where('customers.admin_area', $adminarea_seller)
                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max])
                                                    // ->where('customers.delivery_by', $delivery)
                                                    /*  ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                    ->get();

                                    $count_page = count($pagination);
                                    // dd($count_page);

                                    $perpage = 10;
                                    $total_page = ceil($count_page / $perpage);
                                    $start = ($perpage * $page) - $perpage;

                                    $count_report_customer = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', DB::raw('COUNT(report_sellers.customer_id) as count_id'))
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.customer_id', 'report_sellers.purchase_order')
                                                            ->where('customers.sale_area', $salearea_seller)
                                                            ->where('customers.admin_area', $adminarea_seller)
                                                            ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            ->havingBetween('total_sales', [$range_min, $range_max])
                                                            // ->where('customers.delivery_by', $delivery)
                                                            /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
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
                                    $count_po_range = ReportSeller::select('purchase_order', DB::raw('SUM(price*quantity) as total_sales'))
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.purchase_order')
                                                    ->where('customers.sale_area', $salearea_seller)
                                                    ->where('customers.admin_area', $adminarea_seller)
                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max])
                                                    // ->where('customers.delivery_by', $delivery)
                                                    /*  ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                    ->get();

                                    $count_purchase_range = count($count_po_range);
                                    // dd($count_purchase_range);

                                    $total_report_selling = ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'purchase_order')
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('purchase_order')
                                                            ->where('customers.sale_area', $salearea_seller)
                                                            ->where('customers.admin_area', $adminarea_seller)
                                                            ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            ->havingBetween('total_sales', [$range_min, $range_max])
                                                            // ->where('customers.delivery_by', $delivery)
                                                            /*  ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                            ->get();

                                    $report_seller = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name', 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.customer_id', 'customers.customer_name' , 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->where('customers.sale_area', $salearea_seller)
                                                    ->where('customers.admin_area', $adminarea_seller)
                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max])
                                                    // ->where('customers.delivery_by', $delivery)
                                                    /*  ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                    ->offset($start)
                                                    ->limit($perpage)
                                                    ->get();
                        
                                } else if(!empty($salearea_seller)) {

                                    $pagination = ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->join('customers', function (JoinClause $join) {
                                                    $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                })
                                                ->groupBy('report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->where('customers.sale_area', $salearea_seller)
                                                ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                ->havingBetween('total_sales', [$range_min, $range_max])
                                                // ->where('customers.delivery_by', $delivery)
                                                /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                ->get();

                                    $count_page = count($pagination);
                                    // dd($count_page);

                                    $perpage = 10;
                                    $total_page = ceil($count_page / $perpage);
                                    $start = ($perpage * $page) - $perpage;

                                    $count_report_customer = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', DB::raw('COUNT(report_sellers.customer_id) as count_id'))
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.customer_id', 'report_sellers.purchase_order')
                                                            ->where('customers.sale_area', $salearea_seller)
                                                            ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            ->havingBetween('total_sales', [$range_min, $range_max])
                                                            // ->where('customers.delivery_by', $delivery)
                                                            /*  ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
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
                                    $count_po_range = ReportSeller::select('purchase_order', DB::raw('SUM(price*quantity) as total_sales'))
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.purchase_order')
                                                    ->where('customers.sale_area', $salearea_seller)
                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max])
                                                    // ->where('customers.delivery_by', $delivery)
                                                    /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                    ->get();

                                    $count_purchase_range = count($count_po_range);
                                    // dd($count_purchase_range);

                                    $total_report_selling = ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order')
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.purchase_order')
                                                            ->where('customers.sale_area', $salearea_seller)
                                                            ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            ->havingBetween('total_sales', [$range_min, $range_max]) 
                                                            // ->where('customers.delivery_by', $delivery)
                                                            /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                            ->get();

                                    $report_seller = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name', 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.customer_id', 'customers.customer_name' , 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->where('customers.sale_area', $salearea_seller)
                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max])
                                                    // ->where('customers.delivery_by', $delivery)
                                                    /*  ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                    ->offset($start)
                                                    ->limit($perpage)
                                                    ->get();

                                } else if(!empty($adminarea_seller)) {

                                    $pagination = ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->join('customers', function (JoinClause $join) {
                                                    $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                })
                                                ->groupBy('report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->where('customers.admin_area', $adminarea_seller)
                                                ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                ->havingBetween('total_sales', [$range_min, $range_max])
                                                // ->where('customers.delivery_by', $delivery)
                                                /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                ->get();

                                    $count_page = count($pagination);
                                    // dd($count_page);

                                    $perpage = 10;
                                    $total_page = ceil($count_page / $perpage);
                                    $start = ($perpage * $page) - $perpage;

                                    $count_report_customer = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', DB::raw('COUNT(report_sellers.customer_id) as count_id'))
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.customer_id', 'report_sellers.purchase_order')
                                                            ->where('customers.admin_area', $adminarea_seller)
                                                            ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            ->havingBetween('total_sales', [$range_min, $range_max])
                                                            // ->where('customers.delivery_by', $delivery)
                                                            /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
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
                                    $count_po_range = ReportSeller::select('purchase_order', DB::raw('SUM(price*quantity) as total_sales'))
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.purchase_order')
                                                    ->where('customers.admin_area', $adminarea_seller)
                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max])
                                                    // ->where('customers.delivery_by', $delivery)
                                                    /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                    ->get();

                                    $count_purchase_range = count($count_po_range);
                                    // dd($count_purchase_range);

                                    $total_report_selling = ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order')
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.purchase_order')
                                                            ->where('customers.admin_area', $adminarea_seller)
                                                            ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            ->havingBetween('total_sales', [$range_min, $range_max]) 
                                                            // ->where('customers.delivery_by', $delivery)
                                                            /*  ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                            ->get();

                                    $report_seller = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name', 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.customer_id', 'customers.customer_name' , 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->where('customers.admin_area', $adminarea_seller)
                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max])
                                                    // ->where('customers.delivery_by', $delivery)
                                                    /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                    ->offset($start)
                                                    ->limit($perpage)
                                                    ->get();
                                
                                } else {

                                    // dd('dd');
                                    $pagination = ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->join('customers', function (JoinClause $join) {
                                                    $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                })
                                                ->groupBy('purchase_order', 'customer_id')
                                                ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                ->havingBetween('total_sales', [$range_min, $range_max])
                                                // ->where('customers.delivery_by', $delivery)
                                                /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                ->get();
                                    $count_page = count($pagination);
                                    // dd($count_page);

                                    $perpage = 10;
                                    $total_page = ceil($count_page / $perpage);
                                    $start = ($perpage * $page) - $perpage;

                                    $count_report_customer = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', DB::raw('COUNT(report_sellers.customer_id) as count_id'))
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.customer_id', 'report_sellers.purchase_order')
                                                            ->whereBetween('date_purchase', [$request->from, $request->to])
                                                            ->havingBetween('total_sales', [$range_min, $range_max])
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
                                    $count_po_range = ReportSeller::select('purchase_order', DB::raw('SUM(price*quantity) as total_sales'))
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.purchase_order')
                                                    ->whereBetween('date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max])
                                                    // ->where('customers.delivery_by', $delivery)
                                                    /* ->whereBetween('date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                    ->get();

                                    $count_purchase_range = count($count_po_range);
                                    // dd($count_purchase_range);

                                    $total_report_selling = ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order')
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.purchase_order')
                                                            ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            ->havingBetween('total_sales', [$range_min, $range_max])
                                                            // ->where('customers.delivery_by', $delivery)
                                                            /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                            ->get();

                                    $report_seller = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name', 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.customer_id', 'customers.customer_name' , 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max])
                                                    // ->where('customers.delivery_by', $delivery)
                                                    /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                    ->offset($start)
                                                    ->limit($perpage)
                                                    ->get();
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

                                    $pagination = ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->join('customers', function (JoinClause $join) {
                                                    $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                })
                                                ->groupBy('report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->where('customers.sale_area', $salearea_seller)
                                                ->where('customers.admin_area', $adminarea_seller)
                                                ->where('customers.geography', $region)
                                                ->where('customers.delivery_by', $delivery)
                                                ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                // ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                // ->havingBetween('total_sales', [$range_min, $range_max])
                                                ->get();
                                    $count_page = count($pagination);
                                    // dd($count_page);

                                    $perpage = 10;
                                    $total_page = ceil($count_page / $perpage);
                                    $start = ($perpage * $page) - $perpage;

                                    $count_report_customer = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', DB::raw('COUNT(report_sellers.customer_id) as count_id'))
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.customer_id', 'report_sellers.purchase_order')
                                                            ->where('customers.sale_area', $salearea_seller)
                                                            ->where('customers.admin_area', $adminarea_seller)
                                                            ->where('customers.geography', $region)
                                                            ->where('customers.delivery_by', $delivery)
                                                            ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            // ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            // ->havingBetween('total_sales', [$range_min, $range_max])
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
                                    $count_po_range = ReportSeller::select('purchase_order', DB::raw('SUM(price*quantity) as total_sales'))
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.purchase_order')
                                                    ->where('customers.sale_area', $salearea_seller)
                                                    ->where('customers.admin_area', $adminarea_seller)
                                                    ->where('customers.geography', $region)
                                                    ->where('customers.delivery_by', $delivery)
                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    // ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    // ->havingBetween('total_sales', [$range_min, $range_max])
                                                    ->get();

                                    $count_purchase_range = count($count_po_range);
                                    // dd($count_purchase_range);

                                    $total_report_selling = ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order')
                                                                    ->join('customers', function (JoinClause $join) {
                                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                                    })
                                                                    ->groupBy('report_sellers.purchase_order')
                                                                    ->where('customers.sale_area', $salearea_seller)
                                                                    ->where('customers.admin_area', $adminarea_seller)
                                                                    ->where('customers.geography', $region)
                                                                    ->where('customers.delivery_by', $delivery)
                                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                                    // ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                                    // ->havingBetween('total_sales', [$range_min, $range_max])
                                                                    ->get();

                                    // dd($total_report_selling);
                                    $report_seller = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name', 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.customer_id', 'customers.customer_name' , 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->where('customers.sale_area', $salearea_seller)
                                                    ->where('customers.admin_area', $adminarea_seller)
                                                    ->where('customers.geography', $region)
                                                    ->where('customers.delivery_by', $delivery)
                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    // ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    // ->havingBetween('total_sales', [$range_min, $range_max])
                                                    ->offset($start)
                                                    ->limit($perpage)
                                                    ->get();
                        
                                } else if(!empty($salearea_seller)) {

                                    $pagination = ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->join('customers', function (JoinClause $join) {
                                                    $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                })
                                                ->groupBy('report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->where('customers.sale_area', $salearea_seller)
                                                ->where('customers.geography', $region)
                                                ->where('customers.delivery_by', $delivery)
                                                ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                ->get();

                                    $count_page = count($pagination);
                                    // dd($count_page);

                                    $perpage = 10;
                                    $total_page = ceil($count_page / $perpage);
                                    $start = ($perpage * $page) - $perpage;

                                    $count_report_customer = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', DB::raw('COUNT(report_sellers.customer_id) as count_id'))
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.customer_id', 'report_sellers.purchase_order')
                                                            ->where('customers.sale_area', $salearea_seller)
                                                            ->where('customers.geography', $region)
                                                            ->where('customers.delivery_by', $delivery)
                                                            ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
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
                                    $count_po_range = ReportSeller::select('purchase_order', DB::raw('SUM(price*quantity) as total_sales'))
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.purchase_order')
                                                    ->where('customers.sale_area', $salearea_seller)
                                                    ->where('customers.geography', $region)
                                                    ->where('customers.delivery_by', $delivery)
                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->get();

                                    $count_purchase_range = count($count_po_range);
                                    // dd($count_purchase_range);

                                    $total_report_selling = ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order')
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.purchase_order')
                                                            ->where('customers.sale_area', $salearea_seller)
                                                            ->where('customers.geography', $region)
                                                            ->where('customers.delivery_by', $delivery)
                                                            ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            ->get();

                                    $report_seller = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name', 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.customer_id', 'customers.customer_name' , 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->where('customers.sale_area', $salearea_seller)
                                                    ->where('customers.geography', $region)
                                                    ->where('customers.delivery_by', $delivery)
                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->offset($start)
                                                    ->limit($perpage)
                                                    ->get();

                                } else if(!empty($adminarea_seller)) {

                                    // dd('dd');
                                    $pagination = ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->join('customers', function (JoinClause $join) {
                                                    $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                })
                                                ->groupBy('report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->where('customers.admin_area', $adminarea_seller)
                                                ->where('customers.geography', $region)
                                                ->where('customers.delivery_by', $delivery)
                                                ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                ->get();

                                    $count_page = count($pagination);
                                    // dd($count_page);

                                    $perpage = 10;
                                    $total_page = ceil($count_page / $perpage);
                                    $start = ($perpage * $page) - $perpage;

                                    $count_report_customer = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', DB::raw('COUNT(report_sellers.customer_id) as count_id'))
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.customer_id', 'report_sellers.purchase_order')
                                                            ->where('customers.admin_area', $adminarea_seller)
                                                            ->where('customers.geography', $region)
                                                            ->where('customers.delivery_by', $delivery)
                                                            ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
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
                                    $count_po_range = ReportSeller::select('purchase_order', DB::raw('SUM(price*quantity) as total_sales'))
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.purchase_order')
                                                    ->where('customers.admin_area', $adminarea_seller)
                                                    ->where('customers.geography', $region)
                                                    ->where('customers.delivery_by', $delivery)
                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->get();

                                    $count_purchase_range = count($count_po_range);
                                    // dd($count_purchase_range);

                                    $total_report_selling = ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order')
                                                                    ->join('customers', function (JoinClause $join) {
                                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                                    })
                                                                    ->groupBy('report_sellers.purchase_order')
                                                                    ->where('customers.admin_area', $adminarea_seller)
                                                                    ->where('customers.geography', $region)
                                                                    ->where('customers.delivery_by', $delivery)
                                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                                    ->get();

                                    $report_seller = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name', 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.customer_id', 'customers.customer_name' , 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->where('customers.admin_area', $adminarea_seller)
                                                    ->where('customers.geography', $region)
                                                    ->where('customers.delivery_by', $delivery)
                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->offset($start)
                                                    ->limit($perpage)
                                                    ->get();
                                
                                } else {

                                    $pagination = ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->join('customers', function (JoinClause $join) {
                                                    $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                })
                                                ->groupBy('report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->where('customers.geography', $region)
                                                ->where('customers.delivery_by', $delivery)
                                                ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                ->get();
                                    $count_page = count($pagination);
                                    // dd($count_page);

                                    $perpage = 10;
                                    $total_page = ceil($count_page / $perpage);
                                    $start = ($perpage * $page) - $perpage;

                                    $count_report_customer = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', DB::raw('COUNT(report_sellers.customer_id) as count_id'))
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.customer_id', 'report_sellers.purchase_order')
                                                            ->where('customers.geography', $region)
                                                            ->where('customers.delivery_by', $delivery)
                                                            ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
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
                                    $count_po_range = ReportSeller::select('purchase_order', DB::raw('SUM(price*quantity) as total_sales'))
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.purchase_order')
                                                    ->where('customers.geography', $region)
                                                    ->where('customers.delivery_by', $delivery)
                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->get();

                                    $count_purchase_range = count($count_po_range);
                                    // dd($count_purchase_range);

                                    $total_report_selling = ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order')
                                                                    ->join('customers', function (JoinClause $join) {
                                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                                    })
                                                                    ->groupBy('report_sellers.purchase_order')
                                                                    ->where('customers.geography', $region)
                                                                    ->where('customers.delivery_by', $delivery)
                                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                                    ->get();

                                    $report_seller = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name', 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.customer_id', 'customers.customer_name' , 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->where('customers.geography', $region)
                                                    ->where('customers.delivery_by', $delivery)
                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->offset($start)
                                                    ->limit($perpage)
                                                    ->get();
                                }

                            } else if (!empty($region)) {
                                //code check region;

                                // dd('region');
                                if(!empty($salearea_seller && !empty($adminarea_seller))) {

                                    $pagination = ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->join('customers', function (JoinClause $join) {
                                                    $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                })
                                                ->groupBy('report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->where('customers.sale_area', $salearea_seller)
                                                ->where('customers.admin_area', $adminarea_seller)
                                                ->where('customers.geography', $region)
                                                ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                               /*  ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                ->get();
                                    $count_page = count($pagination);
                                    // dd($count_page);

                                    $perpage = 10;
                                    $total_page = ceil($count_page / $perpage);
                                    $start = ($perpage * $page) - $perpage;

                                    $count_report_customer = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', DB::raw('COUNT(report_sellers.customer_id) as count_id'))
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.customer_id', 'report_sellers.purchase_order')
                                                            ->where('customers.sale_area', $salearea_seller)
                                                            ->where('customers.admin_area', $adminarea_seller)
                                                            ->where('customers.geography', $region)
                                                            ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                           /*  ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
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
                                    $count_po_range = ReportSeller::select('purchase_order', DB::raw('SUM(price*quantity) as total_sales'))
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.purchase_order')
                                                    ->where('customers.sale_area', $salearea_seller)
                                                    ->where('customers.admin_area', $adminarea_seller)
                                                    ->where('customers.geography', $region)
                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                   /*  ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                    ->get();

                                    $count_purchase_range = count($count_po_range);
                                    // dd($count_purchase_range);

                                    $total_report_selling = ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order')
                                                                    ->join('customers', function (JoinClause $join) {
                                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                                    })
                                                                    ->groupBy('report_sellers.purchase_order')
                                                                    ->where('customers.sale_area', $salearea_seller)
                                                                    ->where('customers.admin_area', $adminarea_seller)
                                                                    ->where('customers.geography', $region)
                                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                                    /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                                    ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                                    ->get();

                                    $report_seller = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name', 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.customer_id', 'customers.customer_name' , 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->where('customers.sale_area', $salearea_seller)
                                                    ->where('customers.admin_area', $adminarea_seller)
                                                    ->where('customers.geography', $region)
                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                   /*  ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                    ->offset($start)
                                                    ->limit($perpage)
                                                    ->get();
                        
                                } else if(!empty($salearea_seller)) {

                                    $pagination = ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->join('customers', function (JoinClause $join) {
                                                    $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                })
                                                ->groupBy('report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->where('customers.sale_area', $salearea_seller)
                                                ->where('customers.geography', $region)
                                                ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                               /*  ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                ->get();

                                    $count_page = count($pagination);
                                    // dd($count_page);

                                    $perpage = 10;
                                    $total_page = ceil($count_page / $perpage);
                                    $start = ($perpage * $page) - $perpage;

                                    $count_report_customer = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', DB::raw('COUNT(report_sellers.customer_id) as count_id'))
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.customer_id', 'report_sellers.purchase_order')
                                                            ->where('customers.sale_area', $salearea_seller)
                                                            ->where('customers.geography', $region)
                                                            ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                           /*  ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
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
                                    $count_po_range = ReportSeller::select('purchase_order', DB::raw('SUM(price*quantity) as total_sales'))
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.purchase_order')
                                                    ->where('customers.sale_area', $salearea_seller)
                                                    ->where('customers.geography', $region)
                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                   /*  ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                    ->get();

                                    $count_purchase_range = count($count_po_range);
                                    // dd($count_purchase_range);

                                    $total_report_selling = ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order')
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.purchase_order')
                                                            ->where('customers.sale_area', $salearea_seller)
                                                            ->where('customers.geography', $region)
                                                            ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                            ->get();

                                    $report_seller = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name', 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.customer_id', 'customers.customer_name' , 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->where('customers.sale_area', $salearea_seller)
                                                    ->where('customers.geography', $region)
                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                   /*  ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                    ->offset($start)
                                                    ->limit($perpage)
                                                    ->get();
                                } else if(!empty($adminarea_seller)) {

                                    $pagination = ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->join('customers', function (JoinClause $join) {
                                                    $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                })
                                                ->groupBy('report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->where('customers.admin_area', $adminarea_seller)
                                                ->where('customers.geography', $region)
                                                ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                ->get();
                                    $count_page = count($pagination);
                                    // dd($count_page);

                                    $perpage = 10;
                                    $total_page = ceil($count_page / $perpage);
                                    $start = ($perpage * $page) - $perpage;

                                    $count_report_customer = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', DB::raw('COUNT(report_sellers.customer_id) as count_id'))
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.customer_id', 'report_sellers.purchase_order')
                                                            ->where('customers.admin_area', $adminarea_seller)
                                                            ->where('customers.geography', $region)
                                                            ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
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
                                    $count_po_range = ReportSeller::select('purchase_order', DB::raw('SUM(price*quantity) as total_sales'))
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.purchase_order')
                                                    ->where('customers.admin_area', $adminarea_seller)
                                                    ->where('customers.geography', $region)
                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                   /*  ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                    ->get();

                                    $count_purchase_range = count($count_po_range);
                                    // dd($count_purchase_range);

                                    $total_report_selling = ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order')
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.purchase_order')
                                                            ->where('customers.admin_area', $adminarea_seller)
                                                            ->where('customers.geography', $region)
                                                            ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                            ->get();


                                    $report_seller = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name', 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.customer_id', 'customers.customer_name' , 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->where('customers.admin_area', $adminarea_seller)
                                                    ->where('customers.geography', $region)
                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                   /*  ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                    ->offset($start)
                                                    ->limit($perpage)
                                                    ->get();
                                
                                } else {

                                    // dd('region');
                                    $pagination = ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->join('customers', function (JoinClause $join) {
                                                    $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                })
                                                ->groupBy('report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->where('customers.geography', $region)
                                                ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                ->get();
                                    $count_page = count($pagination);
                                    // dd($count_page);

                                    $perpage = 10;
                                    $total_page = ceil($count_page / $perpage);
                                    $start = ($perpage * $page) - $perpage;

                                    $count_report_customer = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', DB::raw('COUNT(report_sellers.customer_id) as count_id'))
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.customer_id', 'report_sellers.purchase_order')
                                                            ->where('customers.geography', $region)
                                                            ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
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
                                    $count_po_range = ReportSeller::select('purchase_order', DB::raw('SUM(price*quantity) as total_sales'))
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.purchase_order')
                                                    ->where('customers.geography', $region)
                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                    ->get();

                                    $count_purchase_range = count($count_po_range);
                                    // dd($count_purchase_range);

                                    $total_report_selling = ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order')
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.purchase_order')
                                                            ->where('customers.geography', $region)
                                                            ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                           /*  ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                            ->get();

                                    $report_seller = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name', 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.customer_id', 'customers.customer_name' , 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->where('customers.geography', $region)
                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                    ->offset($start)
                                                    ->limit($perpage)
                                                    ->get();
                                }

                            } else if (!empty($delivery)) {
                                //code check delivery;
                                if(!empty($salearea_seller && !empty($adminarea_seller))) {

                                    $pagination = ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->join('customers', function (JoinClause $join) {
                                                    $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                })
                                                ->groupBy('report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->where('customers.sale_area', $salearea_seller)
                                                ->where('customers.admin_area', $adminarea_seller)
                                                ->where('customers.delivery_by', $delivery)
                                                ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                               /*  ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                ->get();
                                    $count_page = count($pagination);
                                    // dd($count_page);

                                    $perpage = 10;
                                    $total_page = ceil($count_page / $perpage);
                                    $start = ($perpage * $page) - $perpage;

                                    $count_report_customer = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', DB::raw('COUNT(report_sellers.customer_id) as count_id'))
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.customer_id', 'report_sellers.purchase_order')
                                                            ->where('customers.sale_area', $salearea_seller)
                                                            ->where('customers.admin_area', $adminarea_seller)
                                                            ->where('customers.delivery_by', $delivery)
                                                            ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
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
                                    $count_po_range = ReportSeller::select('purchase_order', DB::raw('SUM(price*quantity) as total_sales'))
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.purchase_order')
                                                    ->where('customers.sale_area', $salearea_seller)
                                                    ->where('customers.admin_area', $adminarea_seller)
                                                    ->where('customers.delivery_by', $delivery)
                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                   /*  ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                    ->get();

                                    $count_purchase_range = count($count_po_range);
                                    // dd($count_purchase_range);

                                    $total_report_selling = ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'purchase_order')
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('purchase_order')
                                                            ->where('customers.sale_area', $salearea_seller)
                                                            ->where('customers.admin_area', $adminarea_seller)
                                                            ->where('customers.delivery_by', $delivery)
                                                            ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                           /*  ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                            ->get();

                                    $report_seller = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name', 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.customer_id', 'customers.customer_name' , 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->where('customers.sale_area', $salearea_seller)
                                                    ->where('customers.admin_area', $adminarea_seller)
                                                    ->where('customers.delivery_by', $delivery)
                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                   /*  ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                    ->offset($start)
                                                    ->limit($perpage)
                                                    ->get();
                        
                                } else if(!empty($salearea_seller)) {

                                    $pagination = ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->join('customers', function (JoinClause $join) {
                                                    $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                })
                                                ->groupBy('report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->where('customers.sale_area', $salearea_seller)
                                                ->where('customers.delivery_by', $delivery)
                                                ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                ->get();

                                    $count_page = count($pagination);
                                    // dd($count_page);

                                    $perpage = 10;
                                    $total_page = ceil($count_page / $perpage);
                                    $start = ($perpage * $page) - $perpage;

                                    $count_report_customer = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', DB::raw('COUNT(report_sellers.customer_id) as count_id'))
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.customer_id', 'report_sellers.purchase_order')
                                                            ->where('customers.sale_area', $salearea_seller)
                                                            ->where('customers.delivery_by', $delivery)
                                                            ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                           /*  ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
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
                                    $count_po_range = ReportSeller::select('purchase_order', DB::raw('SUM(price*quantity) as total_sales'))
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.purchase_order')
                                                    ->where('customers.sale_area', $salearea_seller)
                                                    ->where('customers.delivery_by', $delivery)
                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                    ->get();

                                    $count_purchase_range = count($count_po_range);
                                    // dd($count_purchase_range);

                                    $total_report_selling = ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order')
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.purchase_order')
                                                            ->where('customers.sale_area', $salearea_seller)
                                                            ->where('customers.delivery_by', $delivery)
                                                            ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                            ->get();

                                    $report_seller = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name', 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.customer_id', 'customers.customer_name' , 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->where('customers.sale_area', $salearea_seller)
                                                    ->where('customers.delivery_by', $delivery)
                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                   /*  ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                    ->offset($start)
                                                    ->limit($perpage)
                                                    ->get();

                                } else if(!empty($adminarea_seller)) {

                                    $pagination = ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->join('customers', function (JoinClause $join) {
                                                    $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                })
                                                ->groupBy('report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->where('customers.admin_area', $adminarea_seller)
                                                ->where('customers.delivery_by', $delivery)
                                                ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                ->get();

                                    $count_page = count($pagination);
                                    // dd($count_page);

                                    $perpage = 10;
                                    $total_page = ceil($count_page / $perpage);
                                    $start = ($perpage * $page) - $perpage;

                                    $count_report_customer = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', DB::raw('COUNT(report_sellers.customer_id) as count_id'))
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.customer_id', 'report_sellers.purchase_order')
                                                            ->where('customers.admin_area', $adminarea_seller)
                                                            ->where('customers.delivery_by', $delivery)
                                                            ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
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
                                    $count_po_range = ReportSeller::select('purchase_order', DB::raw('SUM(price*quantity) as total_sales'))
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.purchase_order')
                                                    ->where('customers.admin_area', $adminarea_seller)
                                                    ->where('customers.delivery_by', $delivery)
                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                    ->get();

                                    $count_purchase_range = count($count_po_range);
                                    // dd($count_purchase_range);

                                    $total_report_selling = ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order')
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.purchase_order')
                                                            ->where('customers.admin_area', $adminarea_seller)
                                                            ->where('customers.delivery_by', $delivery)
                                                            ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                           /*  ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                            ->get();

                                    $report_seller = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name', 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.customer_id', 'customers.customer_name' , 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->where('customers.admin_area', $adminarea_seller)
                                                    ->where('customers.delivery_by', $delivery)
                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                    ->offset($start)
                                                    ->limit($perpage)
                                                    ->get();
                                
                                } else {

                                    $pagination = ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->join('customers', function (JoinClause $join) {
                                                    $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                })
                                                ->groupBy('purchase_order', 'customer_id')
                                                ->where('customers.delivery_by', $delivery)
                                                ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                ->get();
                                    $count_page = count($pagination);
                                    // dd($count_page);

                                    $perpage = 10;
                                    $total_page = ceil($count_page / $perpage);
                                    $start = ($perpage * $page) - $perpage;

                                    $count_report_customer = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', DB::raw('COUNT(report_sellers.customer_id) as count_id'))
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.customer_id', 'report_sellers.purchase_order')
                                                            ->where('customers.delivery_by', $delivery)
                                                            ->whereBetween('date_purchase', [$request->from, $request->to])
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
                                    $count_po_range = ReportSeller::select('purchase_order', DB::raw('SUM(price*quantity) as total_sales'))
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.purchase_order')
                                                    ->where('customers.delivery_by', $delivery)
                                                    ->whereBetween('date_purchase', [$request->from, $request->to])
                                                    /* ->whereBetween('date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                    ->get();

                                    $count_purchase_range = count($count_po_range);
                                    // dd($count_purchase_range);

                                    $total_report_selling = ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order')
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.purchase_order')
                                                            ->where('customers.delivery_by', $delivery)
                                                            ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                            ->get();

                                    $report_seller = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name', 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.customer_id', 'customers.customer_name' , 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->where('customers.delivery_by', $delivery)
                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                    ->offset($start)
                                                    ->limit($perpage)
                                                    ->get();
                                }

                            } else {

                                // dd('test');
                                //not delivery and region;
                                if(!empty($salearea_seller && !empty($adminarea_seller))) {

                                    $pagination = ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->join('customers', function (JoinClause $join) {
                                                    $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                })
                                                ->groupBy('report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->where('customers.sale_area', $salearea_seller)
                                                ->where('customers.admin_area', $adminarea_seller)
                                                ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                // ->where('customers.delivery_by', $delivery)
                                               /*  ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                ->get();
                                    $count_page = count($pagination);
                                    // dd($count_page);

                                    $perpage = 10;
                                    $total_page = ceil($count_page / $perpage);
                                    $start = ($perpage * $page) - $perpage;

                                    $count_report_customer = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', DB::raw('COUNT(report_sellers.customer_id) as count_id'))
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.customer_id', 'report_sellers.purchase_order')
                                                            ->where('customers.sale_area', $salearea_seller)
                                                            ->where('customers.admin_area', $adminarea_seller)
                                                            ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            // ->where('customers.delivery_by', $delivery)
                                                            /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
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
                                    $count_po_range = ReportSeller::select('purchase_order', DB::raw('SUM(price*quantity) as total_sales'))
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.purchase_order')
                                                    ->where('customers.sale_area', $salearea_seller)
                                                    ->where('customers.admin_area', $adminarea_seller)
                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    // ->where('customers.delivery_by', $delivery)
                                                   /*  ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                    ->get();

                                    $count_purchase_range = count($count_po_range);
                                    // dd($count_purchase_range);

                                    $total_report_selling = ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'purchase_order')
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('purchase_order')
                                                            ->where('customers.sale_area', $salearea_seller)
                                                            ->where('customers.admin_area', $adminarea_seller)
                                                            ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            // ->where('customers.delivery_by', $delivery)
                                                           /*  ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                            ->get();

                                    $report_seller = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name', 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.customer_id', 'customers.customer_name' , 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->where('customers.sale_area', $salearea_seller)
                                                    ->where('customers.admin_area', $adminarea_seller)
                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    // ->where('customers.delivery_by', $delivery)
                                                   /*  ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                    ->offset($start)
                                                    ->limit($perpage)
                                                    ->get();
                        
                                } else if(!empty($salearea_seller)) {

                                    $pagination = ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->join('customers', function (JoinClause $join) {
                                                    $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                })
                                                ->groupBy('report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->where('customers.sale_area', $salearea_seller)
                                                ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                // ->where('customers.delivery_by', $delivery)
                                                /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                ->get();

                                    $count_page = count($pagination);
                                    // dd($count_page);

                                    $perpage = 10;
                                    $total_page = ceil($count_page / $perpage);
                                    $start = ($perpage * $page) - $perpage;

                                    $count_report_customer = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', DB::raw('COUNT(report_sellers.customer_id) as count_id'))
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.customer_id', 'report_sellers.purchase_order')
                                                            ->where('customers.sale_area', $salearea_seller)
                                                            ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            // ->where('customers.delivery_by', $delivery)
                                                           /*  ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
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
                                    $count_po_range = ReportSeller::select('purchase_order', DB::raw('SUM(price*quantity) as total_sales'))
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.purchase_order')
                                                    ->where('customers.sale_area', $salearea_seller)
                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    // ->where('customers.delivery_by', $delivery)
                                                    /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                    ->get();

                                    $count_purchase_range = count($count_po_range);
                                    // dd($count_purchase_range);

                                    $total_report_selling = ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order')
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.purchase_order')
                                                            ->where('customers.sale_area', $salearea_seller)
                                                            ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            // ->where('customers.delivery_by', $delivery)
                                                            /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                            ->get();

                                    $report_seller = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name', 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.customer_id', 'customers.customer_name' , 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->where('customers.sale_area', $salearea_seller)
                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    // ->where('customers.delivery_by', $delivery)
                                                   /*  ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                    ->offset($start)
                                                    ->limit($perpage)
                                                    ->get();

                                } else if(!empty($adminarea_seller)) {

                                    $pagination = ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->join('customers', function (JoinClause $join) {
                                                    $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                })
                                                ->groupBy('report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->where('customers.admin_area', $adminarea_seller)
                                                ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                // ->where('customers.delivery_by', $delivery)
                                                /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                ->get();

                                    $count_page = count($pagination);
                                    // dd($count_page);

                                    $perpage = 10;
                                    $total_page = ceil($count_page / $perpage);
                                    $start = ($perpage * $page) - $perpage;

                                    $count_report_customer = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', DB::raw('COUNT(report_sellers.customer_id) as count_id'))
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.customer_id', 'report_sellers.purchase_order')
                                                            ->where('customers.admin_area', $adminarea_seller)
                                                            ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            // ->where('customers.delivery_by', $delivery)
                                                            /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
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
                                    $count_po_range = ReportSeller::select('purchase_order', DB::raw('SUM(price*quantity) as total_sales'))
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.purchase_order')
                                                    ->where('customers.admin_area', $adminarea_seller)
                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    // ->where('customers.delivery_by', $delivery)
                                                    /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                    ->get();

                                    $count_purchase_range = count($count_po_range);
                                    // dd($count_purchase_range);

                                    $total_report_selling = ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order')
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.purchase_order')
                                                            ->where('customers.admin_area', $adminarea_seller)
                                                            ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            // ->where('customers.delivery_by', $delivery)
                                                           /*  ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                            ->get();

                                    $report_seller = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name', 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.customer_id', 'customers.customer_name' , 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->where('customers.admin_area', $adminarea_seller)
                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    // ->where('customers.delivery_by', $delivery)
                                                    /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                    ->offset($start)
                                                    ->limit($perpage)
                                                    ->get();
                                
                                } else {

                                    // dd('dd');
                                    $pagination = ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', 'report_sellers.customer_id')
                                                ->join('customers', function (JoinClause $join) {
                                                    $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                })
                                                ->groupBy('purchase_order', 'customer_id')
                                                ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                // ->where('customers.delivery_by', $delivery)
                                                /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                ->get();
                                    $count_page = count($pagination);
                                    // dd($count_page);

                                    $perpage = 10;
                                    $total_page = ceil($count_page / $perpage);
                                    $start = ($perpage * $page) - $perpage;

                                    $count_report_customer = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', DB::raw('COUNT(report_sellers.customer_id) as count_id'))
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.customer_id', 'report_sellers.purchase_order')
                                                            ->whereBetween('date_purchase', [$request->from, $request->to])
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
                                    $count_po_range = ReportSeller::select('purchase_order', DB::raw('SUM(price*quantity) as total_sales'))
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.purchase_order')
                                                    ->whereBetween('date_purchase', [$request->from, $request->to])
                                                    // ->where('customers.delivery_by', $delivery)
                                                    /* ->whereBetween('date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                    ->get();

                                    $count_purchase_range = count($count_po_range);
                                    // dd($count_purchase_range);

                                    $total_report_selling = ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order')
                                                            ->join('customers', function (JoinClause $join) {
                                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                            })
                                                            ->groupBy('report_sellers.purchase_order')
                                                            ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            // ->where('customers.delivery_by', $delivery)
                                                            /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                            ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                            ->get();

                                    $report_seller = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name', 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->join('customers', function (JoinClause $join) {
                                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                                    })
                                                    ->groupBy('report_sellers.customer_id', 'customers.customer_name' , 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                                    ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    // ->where('customers.delivery_by', $delivery)
                                                    /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                                    ->havingBetween('total_sales', [$range_min, $range_max]) */
                                                    ->offset($start)
                                                    ->limit($perpage)
                                                    ->get();
                                }
                             
                            }


                                $customers_data = Customer::select('customer_id', 'sale_area', 'admin_area')->get();
                                $customers_customer_name = Customer::select('customer_id', 'customer_name')->get();

                                return view('report/seller', compact('check_from','check_to', 'admin_area', 'report_seller', 'start', 'total_page', 'page', 'status_alert', 'status_waiting','status_registration', 'status_updated', 'user_id_admin',
                                'count_customer_range', 'count_purchase_range', 'customers_customer_name', 'total_report_selling', 'customers_data','sale_area'));
                    }
            
        } else {
      
            // dd('hello');

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

            $customers_data = Customer::select('customer_id', 'sale_area', 'admin_area')->get();
            $customers_customer_name = Customer::select('customer_id', 'customer_name')->get();
            // dd($customers_customer_name);

       /*      $report_seller = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price * quantity) as total_sales'))
                                            ->join('customers', function (JoinClause $join) {
                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                            })
                                            ->groupBy('report_sellers.customer_id', 'customers.customer_name')
                                            ->offset($start)
                                            ->limit($perpage)
                                            ->get(); */

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
                                    ->get();
         
            return view('report/seller', compact('check_from','check_to', 'admin_area', 'report_seller', 'start', 'total_page', 'page', 'status_alert', 'status_waiting','status_registration', 'status_updated', 'user_id_admin',
            'count_customer_all', 'customers_customer_name', 'total_report_selling', 'sale_area'));
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

            $pagination = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order', DB::raw('COUNT(report_sellers.customer_id) as count_id'))
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
                    $count_po_range = ReportSeller::select('purchase_order', DB::raw('SUM(price*quantity) as total_sales'))
                                    ->join('customers', function (JoinClause $join) {
                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                    })
                                    ->groupBy('report_sellers.purchase_order')
                                    ->whereNotIn('report_sellers.customer_id', ['0000', '4494', '7787', '9000'])
                                    ->where('report_sellers.customer_id', 'Like', "%{$keyword_search}%")
                                    ->orWhere('customers.customer_name', 'Like', "%{$keyword_search}%")
                                    // ->whereBetween('date_purchase', [$request->from, $request->to])
                                    // ->where('customers.delivery_by', $delivery)
                                    /* ->whereBetween('date_purchase', [$request->from, $request->to])
                                    ->havingBetween('total_sales', [$range_min, $range_max]) */
                                    ->get();

                    $count_purchase_range = count($count_po_range);
                    // dd($count_purchase_range);

                    $total_report_selling = ReportSeller::select(DB::raw('SUM(price*quantity) as total_sales'), 'report_sellers.purchase_order')
                                            ->join('customers', function (JoinClause $join) {
                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                            })
                                            ->groupBy('report_sellers.purchase_order')
                                            ->whereNotIn('report_sellers.customer_id', ['0000', '4494', '7787', '9000'])
                                            ->where('report_sellers.customer_id', 'Like', "%{$keyword_search}%")
                                            ->orWhere('customers.customer_name', 'Like', "%{$keyword_search}%")
                                            // ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                            // ->where('customers.delivery_by', $delivery)
                                            /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                            ->havingBetween('total_sales', [$range_min, $range_max]) */
                                            ->get();

                    $report_seller = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price*quantity) as total_sales'), 'customers.customer_name', 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                    ->join('customers', function (JoinClause $join) {
                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                    })
                                    ->groupBy('report_sellers.customer_id', 'customers.customer_name' , 'report_sellers.purchase_order', 'customers.admin_area', 'customers.sale_area')
                                    ->whereNotIn('report_sellers.customer_id', ['0000', '4494', '7787', '9000'])
                                    ->where('report_sellers.customer_id', 'Like', "%{$keyword_search}%")
                                    ->orWhere('customers.customer_name', 'Like', "%{$keyword_search}%")
                                    ->offset($start)
                                    ->limit($perpage)
                                    // ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                    // ->where('customers.delivery_by', $delivery)
                                    /* ->whereBetween('report_sellers.date_purchase', [$request->from, $request->to])
                                    ->havingBetween('total_sales', [$range_min, $range_max]) */
                     
                                    ->get();
                
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

                    $rename = 'Customer_all'.'_'.date("l jS \of F Y h:i:s A").'.csv';
                    $directory = $request->file('import_csv')->storeAs('importcsv',$rename,'importfiles'); //importfiles filesystem.php->disk;
                    $fileStream = fopen(storage_path('app/public/importcsv/'.$rename),'r');
                    // fgetcsv($fileStream); // skip header
                    
                    while (!feof($fileStream)) 
                            {

                                $row = fgetcsv($fileStream , 1000 , "|");
                                // dd($row[0]);
                                if(!empty($row[0])) {
                            
                            
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
