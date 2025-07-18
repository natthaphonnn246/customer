<?php

namespace App\Http\Controllers;

use App\Models\ReportSeller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Imports\SellersImport;
use App\Models\Category;
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

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        date_default_timezone_set("Asia/Bangkok");

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

        
          $page = $request->page;
          if ($page) {
              $page = $request->page;
          } else {
              $page = 1;
          }

          $from = $request->from;
          $to = $request->to;

          $category = $request->category;
          $region = $request->region;

          if(!empty($category) && empty($region))
          {

            // dd('test');
            $filters_page = [
                'from' => $request->from ?? date('Y-m-d'),
                'to'   => $request->to   ?? date('Y-m-d'),
                'category' => $request->category,
                ];
            
                $key_page = 'report_page_' . md5(json_encode($filters_page));
    
                $pagination = Cache::remember($key_page, 1800, function () use ($filters_page) {
                    
                return ReportSeller::select(
                                    'report_sellers.product_id',
                                    DB::raw('SUM(report_sellers.price * report_sellers.quantity) as total_sales'),
                                    DB::raw('SUM(report_sellers.quantity) as quantity_by'),
                                    DB::raw('AVG(report_sellers.cost) as average_cost'),
                                    'products.category',
                                    'products.sub_category',
                                    'products.product_name',
                                    'categories.categories_name',
                                    'subcategories.subcategories_name',
                                    'products.unit',
                                    )
                                    ->join('products', function (JoinClause $join) {
                                        $join->on('products.product_id', '=', 'report_sellers.product_id');
                                    })
                                    ->join('categories', function (JoinClause $join) {
                                        $join->on('categories.categories_id', '=', 'products.category');
                                    })
                                    ->join('subcategories', function (JoinClause $join) {
                                        $join->on('subcategories.subcategories_id', '=', 'products.sub_category');
                                    })
                                    ->whereRaw("report_sellers.product_name NOT LIKE BINARY '%ดีลพิเศษ%'")
                                    ->where('products.category', $filters_page['category'])
                                    ->whereBetween('report_sellers.date_purchase', [$filters_page['from'], $filters_page['to']])
                                    ->groupBy(
                                    'report_sellers.product_id',
                                    'products.category',
                                    'products.product_name',
                                    'products.sub_category',
                                    'categories.categories_name',
                                    'subcategories.subcategories_name',
                                    'products.unit'
                                    )
                                    ->orderBy('quantity_by', 'desc')
                                    ->get();
                                });
    
                    $count_page = count($pagination);
                    // dd($count_page);
    
                    $perpage = 10;
                    $total_page = ceil($count_page / $perpage);
                    $start = ($perpage * $page) - $perpage;
    
                $from = $request->from;
                $to = $request->to;
    
                $filters = [
                    'from' => $request->from ?? date('Y-m-d'),
                    'to'   => $request->to   ?? date('Y-m-d'),
            /*      'from' => $request->from ?? '2025-01-05',
                    'to'   => $request->to   ?? '2025-01-30', */
                    'perpage' => $perpage,
                    'page' => $page,
                    'category' => $request->category,
                    ];
                
    
                    $key = 'product_' . md5(json_encode($filters));
                    
                    $report_product  = Cache::remember($key, 1800, function () use ($filters) {
    
                    return ReportSeller::select(
                                        'report_sellers.product_id',
                                        DB::raw('SUM(report_sellers.price * report_sellers.quantity) as total_sales'),
                                        DB::raw('SUM(report_sellers.quantity) as quantity_by'),
                                        DB::raw('AVG(report_sellers.cost) as average_cost'),
                                        'products.category',
                                        'products.sub_category',
                                        'products.product_name',
                                        'categories.categories_name',
                                        'subcategories.subcategories_name',
                                        'products.unit',
                                        )
                                        ->join('products', function (JoinClause $join) {
                                            $join->on('products.product_id', '=', 'report_sellers.product_id');
                                        })
                                        ->join('categories', function (JoinClause $join) {
                                            $join->on('categories.categories_id', '=', 'products.category');
                                        })
                                        ->join('subcategories', function (JoinClause $join) {
                                            $join->on('subcategories.subcategories_id', '=', 'products.sub_category');
                                        })
                                        ->whereRaw("report_sellers.product_name NOT LIKE BINARY '%ดีลพิเศษ%'")
                                        ->where('products.category', $filters['category'])
                                        ->whereBetween('report_sellers.date_purchase', [$filters['from'], $filters['to']])
                                        ->groupBy(
                                        'report_sellers.product_id',
                                        'products.category',
                                        'products.product_name',
                                        'products.sub_category',
                                        'categories.categories_name',
                                        'subcategories.subcategories_name',
                                        'products.unit'
                                        )
                                        ->orderBy('quantity_by', 'desc')
                                        // ->get();
                                        ->paginate($filters['perpage'], ['*'], 'page', $filters['page']);
                                    });


                    //count_product;
                    $filters_totalProduct = [
                        'from' => $request->from ?? date('Y-m-d'),
                        'to'   => $request->to   ?? date('Y-m-d'),
                        'category' => $request->category,

                    ];

                    $key_totalProduct = 'total_product_' . md5(json_encode( $filters_totalProduct));
                    $count_products = Cache::remember($key_totalProduct, 1800, function () use ( $filters_totalProduct) {

                                    return ReportSeller::join('products', 'products.product_id', '=', 'report_sellers.product_id')
                                                        // ->join('customers', 'customers.customer_id', '=', 'report_sellers.customer_id')
                                                        ->whereRaw("report_sellers.product_name NOT LIKE BINARY '%ดีลพิเศษ%'")
                                                        ->where('products.category',  $filters_totalProduct['category'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters_totalProduct['from'],  $filters_totalProduct['to']])
                                                        ->select('report_sellers.product_id')
                                                        ->distinct()
                                                        ->get();
                                                    });
                /*     $count_products = ReportSeller::join('products', 'products.product_id', '=', 'report_sellers.product_id')
                                    // ->join('customers', 'customers.customer_id', '=', 'report_sellers.customer_id')
                                    ->where('products.category',  $filters_totalProduct['category'])
                                    ->whereBetween('report_sellers.date_purchase', [$filters_totalProduct['from'],  $filters_totalProduct['to']])
                                    ->select('report_sellers.product_id')
                                    ->distinct()
                                    ->get(); */
                
                    $total_quantity = $count_products?->count() ?? 0;
                    // dd($total_quantity);

                    $filters_productValue = [
                            'from' => $request->from ?? date('Y-m-d'),
                            'to'   => $request->to   ?? date('Y-m-d'),
                            'category' => $request->category,

                        ];

                    $key_productValue = 'product_value_' . md5(json_encode($filters_productValue));
                    $count_sum = Cache::remember($key_productValue, 1800, function () use ($filters_productValue) {

                                return ReportSeller::join('products', 'products.product_id', '=', 'report_sellers.product_id')
                                                    ->join('customers', 'customers.customer_id', '=', 'report_sellers.customer_id')
                                                    ->whereRaw("report_sellers.product_name NOT LIKE BINARY '%ดีลพิเศษ%'")
                                                    ->where('products.category',  $filters_productValue['category'])
                                                    ->whereBetween('report_sellers.date_purchase', [$filters_productValue['from'],  $filters_productValue['to']])
                                                    ->select(
                                                        DB::raw('SUM(report_sellers.price * report_sellers.quantity) as total_sales'),
                                                    )
                                                    ->get();
                                                });

                    $product_value = 0;
                    foreach($count_sum as $row_sum) {
                        $product_value += $row_sum?->total_sales ?? 0;
                    }
                    // dd($product_value);
    
        } elseif (!empty($region) && empty($category)) {

            // dd('test');
            $filters_page = [
                'from' => $request->from ?? date('Y-m-d'),
                'to'   => $request->to   ?? date('Y-m-d'),
                'region' => $request->region,
                ];
            
                $key_page = 'report_page_' . md5(json_encode($filters_page));
    
                $pagination = Cache::remember($key_page, 1800, function () use ($filters_page) {
    
                return ReportSeller::select(
                                    'report_sellers.product_id',
                                    DB::raw('SUM(report_sellers.price * report_sellers.quantity) as total_sales'),
                                    DB::raw('SUM(report_sellers.quantity) as quantity_by'),
                                    DB::raw('AVG(report_sellers.cost) as average_cost'),
                                    'products.category',
                                    'products.sub_category',
                                    'products.product_name',
                                    'categories.categories_name',
                                    'subcategories.subcategories_name',
                                    'products.unit',
                                    'customers.geography',
                                    )
                                    ->join('products', function (JoinClause $join) {
                                        $join->on('products.product_id', '=', 'report_sellers.product_id');
                                    })
                                    ->join('categories', function (JoinClause $join) {
                                        $join->on('categories.categories_id', '=', 'products.category');
                                    })
                                    ->join('subcategories', function (JoinClause $join) {
                                        $join->on('subcategories.subcategories_id', '=', 'products.sub_category');
                                    })
                                    ->join('customers', function (JoinClause $join) {
                                        $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                    })
                                    ->whereRaw("report_sellers.product_name NOT LIKE BINARY '%ดีลพิเศษ%'")
                                    ->where('customers.geography', $filters_page['region'])
                                    ->whereBetween('report_sellers.date_purchase', [$filters_page['from'], $filters_page['to']])
                                    ->groupBy(
                                    'report_sellers.product_id',
                                    'products.category',
                                    'products.product_name',
                                    'products.sub_category',
                                    'categories.categories_name',
                                    'subcategories.subcategories_name',
                                    'products.unit',
                                    'customers.geography',
                                    )
                                    ->orderBy('quantity_by', 'desc')
                                    ->get();
                                });
    
                    $count_page = count($pagination);
                    // dd($count_page);
    
                    $perpage = 10;
                    $total_page = ceil($count_page / $perpage);
                    $start = ($perpage * $page) - $perpage;
    
                $from = $request->from;
                $to = $request->to;
    
                $filters = [
                    'from' => $request->from ?? date('Y-m-d'),
                    'to'   => $request->to   ?? date('Y-m-d'),
            /*      'from' => $request->from ?? '2025-01-05',
                    'to'   => $request->to   ?? '2025-01-30', */
                    'perpage' => $perpage,
                    'page' => $page,
                    'region' => $request->region,
                    ];
                
    
                    $key = 'product_' . md5(json_encode($filters));
                    
                    $report_product  = Cache::remember($key, 1800, function () use ($filters) {
                    // $allReports = Cache::remember($key, 1800, function () use ($filters) {
    
                    return ReportSeller::select(
                                        'report_sellers.product_id',
                                        DB::raw('SUM(report_sellers.price * report_sellers.quantity) as total_sales'),
                                        DB::raw('SUM(report_sellers.quantity) as quantity_by'),
                                        DB::raw('AVG(report_sellers.cost) as average_cost'),
                                        'products.category',
                                        'products.sub_category',
                                        'products.product_name',
                                        'categories.categories_name',
                                        'subcategories.subcategories_name',
                                        'products.unit',
                                        'customers.geography',
                                        )
                                        ->join('products', function (JoinClause $join) {
                                            $join->on('products.product_id', '=', 'report_sellers.product_id');
                                        })
                                        ->join('categories', function (JoinClause $join) {
                                            $join->on('categories.categories_id', '=', 'products.category');
                                        })
                                        ->join('subcategories', function (JoinClause $join) {
                                            $join->on('subcategories.subcategories_id', '=', 'products.sub_category');
                                        })
                                        ->join('customers', function (JoinClause $join) {
                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                        })
                                        ->whereRaw("report_sellers.product_name NOT LIKE BINARY '%ดีลพิเศษ%'")
                                        ->where('customers.geography', $filters['region'])
                                        ->whereBetween('report_sellers.date_purchase', [$filters['from'], $filters['to']])
                                        ->groupBy(
                                        'report_sellers.product_id',
                                        'products.category',
                                        'products.product_name',
                                        'products.sub_category',
                                        'categories.categories_name',
                                        'subcategories.subcategories_name',
                                        'products.unit',
                                        'customers.geography',
                                        )
                                        ->orderBy('quantity_by', 'desc')
                                        // ->get();
                                        ->paginate($filters['perpage'], ['*'], 'page', $filters['page']);
                                    });

                    //count_product;
                    $filters_totalProduct = [
                        'from' => $request->from ?? date('Y-m-d'),
                        'to'   => $request->to   ?? date('Y-m-d'),
                        'region' => $request->region,

                    ];
                    $key_totalProduct = 'total_product_' . md5(json_encode( $filters_totalProduct));
                    $count_products = Cache::remember($key_totalProduct, 1800, function () use ( $filters_totalProduct) {
                                    return ReportSeller::join('products', 'products.product_id', '=', 'report_sellers.product_id')
                                                        ->join('customers', 'customers.customer_id', '=', 'report_sellers.customer_id')
                                                        ->whereRaw("report_sellers.product_name NOT LIKE BINARY '%ดีลพิเศษ%'")
                                                        ->where('customers.geography',  $filters_totalProduct['region'])
                                                        ->whereBetween('report_sellers.date_purchase', [$filters_totalProduct['from'],  $filters_totalProduct['to']])
                                                        ->select('report_sellers.product_id')
                                                        ->distinct()
                                                        ->get();
                                                    });
                
                    $total_quantity = $count_products?->count() ?? 0;

                    $filters_productValue = [
                            'from' => $request->from ?? date('Y-m-d'),
                            'to'   => $request->to   ?? date('Y-m-d'),
                            'region' => $request->region,
    
                        ];

                    $key_productValue = 'product_value_' . md5(json_encode($filters_productValue));
                    $count_sum = Cache::remember($key_productValue, 1800, function () use ($filters_productValue) {

                                return ReportSeller::join('products', 'products.product_id', '=', 'report_sellers.product_id')
                                                    ->join('customers', 'customers.customer_id', '=', 'report_sellers.customer_id')
                                                    ->whereRaw("report_sellers.product_name NOT LIKE BINARY '%ดีลพิเศษ%'")
                                                    ->where('customers.geography',  $filters_productValue['region'])
                                                    ->whereBetween('report_sellers.date_purchase', [$filters_productValue['from'],  $filters_productValue['to']])
                                                    ->select(
                                                        DB::raw('SUM(report_sellers.price * report_sellers.quantity) as total_sales'),
                                                    )
                                                    ->get();
                                                });

                    $product_value = 0;
                    foreach($count_sum as $row_sum) {
                        $product_value += $row_sum?->total_sales ?? 0;
                    }
                    // dd($product_value);
                    

        } elseif (!empty($category) && !empty($region)) {

            // dd('test');
            $filters_page = [
                'from' => $request->from ?? date('Y-m-d'),
                'to' => $request->to   ?? date('Y-m-d'),
                'category' => $request->category,
                'region' => $request->region,
                /*  'from' => $request->from ?? '2025-01-05',
                 'to'   => $request->to   ?? '2025-01-30', */
                 ];
             
                 $key_page = 'report_page_' . md5(json_encode($filters_page));
     
                 $pagination = Cache::remember($key_page, 1800, function () use ($filters_page) {
     
                 return ReportSeller::select(
                                            'report_sellers.product_id',
                                            DB::raw('SUM(report_sellers.price * report_sellers.quantity) as total_sales'),
                                            DB::raw('SUM(report_sellers.quantity) as quantity_by'),
                                            DB::raw('AVG(report_sellers.cost) as average_cost'),
                                            'products.category',
                                            'products.sub_category',
                                            'products.product_name',
                                            'categories.categories_name',
                                            'subcategories.subcategories_name',
                                            'products.unit',
                                            'customers.geography',
                                        )
                                        ->join('products', function (JoinClause $join) {
                                            $join->on('products.product_id', '=', 'report_sellers.product_id');
                                        })
                                        ->join('categories', function (JoinClause $join) {
                                            $join->on('categories.categories_id', '=', 'products.category');
                                        })
                                        ->join('subcategories', function (JoinClause $join) {
                                            $join->on('subcategories.subcategories_id', '=', 'products.sub_category');
                                        })
                                        ->join('customers', function (JoinClause $join) {
                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                        })
                    
                                        ->whereRaw("report_sellers.product_name NOT LIKE BINARY '%ดีลพิเศษ%'")
                                        ->where('products.category', $filters_page['category'])
                                        ->where('customers.geography', $filters_page['region'])
                                        ->whereBetween('report_sellers.date_purchase', [$filters_page['from'], $filters_page['to']])
                                        ->groupBy(
                                            'report_sellers.product_id',
                                            'products.category',
                                            'products.product_name',
                                            'products.sub_category',
                                            'categories.categories_name',
                                            'subcategories.subcategories_name',
                                            'products.unit',
                                            'customers.geography',
                                        )
                                        ->orderBy('quantity_by', 'desc')
                                        ->get();
                
                                 });
     
                     $count_page = count($pagination);
                    //  dd($count_page);
     
                     $perpage = 10;
                     $total_page = ceil($count_page / $perpage);
                     $start = ($perpage * $page) - $perpage;
     
                 $from = $request->from;
                 $to = $request->to;
     
                 $filters = [
                        'from' => $request->from ?? date('Y-m-d'),
                        'to'   => $request->to   ?? date('Y-m-d'),
                        /*   'from' => $request->from ?? '2025-01-05',
                        'to'   => $request->to   ?? '2025-01-30', */
                        'category' => $request->category,
                        'region' => $request->region,
                        'perpage' => $perpage,
                        'page' => $page,
                     ];
                 
     
                     $key = 'product_' . md5(json_encode($filters));
                     
                     $report_product  = Cache::remember($key, 1800, function () use ($filters) {
     
                        return ReportSeller::select(
                                            'report_sellers.product_id',
                                            DB::raw('SUM(report_sellers.price * report_sellers.quantity) as total_sales'),
                                            DB::raw('SUM(report_sellers.quantity) as quantity_by'),
                                            DB::raw('AVG(report_sellers.cost) as average_cost'),
                                            'products.category',
                                            'products.sub_category',
                                            'products.product_name',
                                            'categories.categories_name',
                                            'subcategories.subcategories_name',
                                            'products.unit',
                                            'customers.geography',
                                            )
                                            ->join('products', function (JoinClause $join) {
                                                $join->on('products.product_id', '=', 'report_sellers.product_id');
                                            })
                                            ->join('categories', function (JoinClause $join) {
                                                $join->on('categories.categories_id', '=', 'products.category');
                                            })
                                            ->join('subcategories', function (JoinClause $join) {
                                                $join->on('subcategories.subcategories_id', '=', 'products.sub_category');
                                            })
                                            ->join('customers', function (JoinClause $join) {
                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                            })
                                            ->whereRaw("report_sellers.product_name NOT LIKE BINARY '%ดีลพิเศษ%'")
                                            ->where('products.category', $filters['category'])
                                            ->where('customers.geography', $filters['region'])
                                            ->whereBetween('report_sellers.date_purchase', [$filters['from'], $filters['to']])
                                            ->groupBy(
                                            'report_sellers.product_id',
                                            'products.category',
                                            'products.product_name',
                                            'products.sub_category',
                                            'categories.categories_name',
                                            'subcategories.subcategories_name',
                                            'products.unit',
                                            'customers.geography',
                                            )
                                            ->orderBy('quantity_by', 'desc')
                                            // ->get();
                                            ->paginate($filters['perpage'], ['*'], 'page', $filters['page']);
    
                                        });

                                        //count_product;
                                        $filters_totalProduct = [
                                            'from' => $request->from ?? date('Y-m-d'),
                                            'to'   => $request->to   ?? date('Y-m-d'),
                                            /*   'from' => $request->from ?? '2025-01-05',
                                            'to'   => $request->to   ?? '2025-01-30', */
                                            'category' => $request->category,
                                            'region' => $request->region,

                                        ];

                                        $key_totalProduct = 'total_product_' . md5(json_encode( $filters_totalProduct));
                                        $count_products = Cache::remember($key_totalProduct, 1800, function () use ( $filters_totalProduct) {

                                                        return ReportSeller::join('products', 'products.product_id', '=', 'report_sellers.product_id')
                                                                            ->join('customers', 'customers.customer_id', '=', 'report_sellers.customer_id')
                                                                            ->whereRaw("report_sellers.product_name NOT LIKE BINARY '%ดีลพิเศษ%'")
                                                                            ->where('products.category',  $filters_totalProduct['category'])
                                                                            ->where('customers.geography',  $filters_totalProduct['region'])
                                                                            ->whereBetween('report_sellers.date_purchase', [ $filters_totalProduct['from'],  $filters_totalProduct['to']])
                                                                            // ->select(DB::raw('SUM(report_sellers.quantity) as quantity_by'))
                                                                            ->select('report_sellers.product_id')
                                                                            ->distinct()
                                                                            ->get();
                                                                        });
                                    
                                        $total_quantity = $count_products?->count() ?? 0;

                                        $filters_productValue = [
                                                    'from' => $request->from ?? date('Y-m-d'),
                                                    'to'   => $request->to   ?? date('Y-m-d'),
                                                    'category' => $request->category,
                                                    'region' => $request->region,
                                
                                                ];

                                        $key_productValue = 'product_value_' . md5(json_encode($filters_productValue));
                                        $count_sum = Cache::remember($key_productValue, 1800, function () use ($filters_productValue) {

                                                    return ReportSeller::join('products', 'products.product_id', '=', 'report_sellers.product_id')
                                                                        ->join('customers', 'customers.customer_id', '=', 'report_sellers.customer_id')
                                                                        ->whereRaw("report_sellers.product_name NOT LIKE BINARY '%ดีลพิเศษ%'")
                                                                        ->where('products.category',  $filters_productValue['category'])
                                                                        ->where('customers.geography',  $filters_productValue['region'])
                                                                        ->whereBetween('report_sellers.date_purchase', [$filters_productValue['from'],  $filters_productValue['to']])
                                                                        // ->select(DB::raw('SUM(report_sellers.quantity) as quantity_by'))
                                                                        ->select(
                                                                            DB::raw('SUM(report_sellers.price * report_sellers.quantity) as total_sales'),
                                                                        )
                                                                        ->get();
                                                                    });
                
                                        $product_value = 0;
                                        foreach($count_sum as $row_sum) {
                                            $product_value += $row_sum?->total_sales ?? 0;
                                        }
                                        // dd($product_value);
                                    


     
        } else {
          $filters_page = [
            'from' => $request->from ?? date('Y-m-d'),
            'to'   => $request->to   ?? date('Y-m-d'),
          /*   'from' => $request->from ?? '2025-01-05',
            'to'   => $request->to   ?? '2025-01-30', */
            ];
        // dd('test');
            $key_page = 'report_page_' . md5(json_encode($filters_page));

            $pagination = Cache::remember($key_page, 1800, function () use ($filters_page) {

            return ReportSeller::select(
                                'report_sellers.product_id',
                                DB::raw('SUM(report_sellers.price * report_sellers.quantity) as total_sales'),
                                DB::raw('SUM(report_sellers.quantity) as quantity_by'),
                                DB::raw('AVG(report_sellers.cost) as average_cost'),
                                'products.category',
                                'products.sub_category',
                                'products.product_name',
                                'categories.categories_name',
                                'subcategories.subcategories_name',
                                'products.unit',
                                )
                                ->join('products', function (JoinClause $join) {
                                    $join->on('products.product_id', '=', 'report_sellers.product_id');
                                })
                                ->join('categories', function (JoinClause $join) {
                                    $join->on('categories.categories_id', '=', 'products.category');
                                })
                                ->join('subcategories', function (JoinClause $join) {
                                    $join->on('subcategories.subcategories_id', '=', 'products.sub_category');
                                })
                                ->whereRaw("report_sellers.product_name NOT LIKE BINARY '%ดีลพิเศษ%'")
                                ->whereBetween('report_sellers.date_purchase', [$filters_page['from'], $filters_page['to']])
                                ->groupBy(
                                'report_sellers.product_id',
                                'products.category',
                                'products.product_name',
                                'products.sub_category',
                                'categories.categories_name',
                                'subcategories.subcategories_name',
                                'products.unit'
                                )
                                // ->where('customers.admin_area', $filters_customer['adminarea_seller'])
                                ->orderBy('quantity_by', 'desc')
                                ->get();
                            });

                $count_page = count($pagination);
                // dd($count_page);

                $perpage = 10;
                $total_page = ceil($count_page / $perpage);
                $start = ($perpage * $page) - $perpage;

                // dd($total_page);
            $from = $request->from;
            $to = $request->to;

            $filters = [
                'from' => $request->from ?? date('Y-m-d'),
                'to'   => $request->to   ?? date('Y-m-d'),
               /*  'from' => $request->from ?? '2025-01-05',
                'to'   => $request->to   ?? '2025-01-30', */
                'perpage' => $perpage,
                'page' => $page,
                ];
            

                $key = 'product_' . md5(json_encode($filters));
                
                $report_product  = Cache::remember($key, 1800, function () use ($filters) {

                return ReportSeller::select(
                                    'report_sellers.product_id',
                                    DB::raw('SUM(report_sellers.price * report_sellers.quantity) as total_sales'),
                                    DB::raw('SUM(report_sellers.quantity) as quantity_by'),
                                    DB::raw('AVG(report_sellers.cost) as average_cost'),
                                    'products.category',
                                    'products.sub_category',
                                    'products.product_name',
                                    'categories.categories_name',
                                    'subcategories.subcategories_name',
                                    'products.unit',
                                    )
                                    ->join('products', function (JoinClause $join) {
                                        $join->on('products.product_id', '=', 'report_sellers.product_id');
                                    })
                                    ->join('categories', function (JoinClause $join) {
                                        $join->on('categories.categories_id', '=', 'products.category');
                                    })
                                    ->join('subcategories', function (JoinClause $join) {
                                        $join->on('subcategories.subcategories_id', '=', 'products.sub_category');
                                    })
                                    ->whereRaw("report_sellers.product_name NOT LIKE BINARY '%ดีลพิเศษ%'")
                                    ->whereBetween('report_sellers.date_purchase', [$filters['from'], $filters['to']])
                                    ->groupBy(
                                    'report_sellers.product_id',
                                    'products.category',
                                    'products.product_name',
                                    'products.sub_category', 
                                    'categories.categories_name',
                                    'subcategories.subcategories_name',
                                    'products.unit'
                                    )
                                    // ->where('customers.admin_area', $filters_customer['adminarea_seller'])
                                    ->orderBy('quantity_by', 'desc')
                                    // ->get();
                                    ->paginate($filters['perpage'], ['*'], 'page', $filters['page']);
                                });

                //count_product;
                $filters_totalProduct = [
                    'from' => $request->from ?? date('Y-m-d'),
                    'to'   => $request->to   ?? date('Y-m-d'),
                   /*  'from' => $request->from ?? '2025-01-05',
                    'to'   => $request->to   ?? '2025-01-30', */

                ];

                $key_totalProduct = 'total_product_' . md5(json_encode( $filters_totalProduct));
                $count_products = Cache::remember($key_totalProduct, 1800, function () use ( $filters_totalProduct) {

                                return ReportSeller::join('products', 'products.product_id', '=', 'report_sellers.product_id')
                                                    // ->join('customers', 'customers.customer_id', '=', 'report_sellers.customer_id')
                                                    ->whereRaw("report_sellers.product_name NOT LIKE BINARY '%ดีลพิเศษ%'")
                                                    ->whereBetween('report_sellers.date_purchase', [$filters_totalProduct['from'],  $filters_totalProduct['to']])
                                                    ->select('report_sellers.product_id')
                                                    ->distinct()
                                                    ->get();
                                                });

                $total_quantity = $count_products?->count() ?? 0;

                $filters_productValue = [
                    'from' => $request->from ?? date('Y-m-d'),
                    'to'   => $request->to   ?? date('Y-m-d'),
                /*     'from' => $request->from ?? '2025-01-05',
                    'to'   => $request->to   ?? '2025-01-30', */

                ];

                $key_productValue = 'product_value_' . md5(json_encode($filters_productValue));
                $count_sum = Cache::remember($key_productValue, 1800, function () use ($filters_productValue) {

                            return ReportSeller::join('products', 'products.product_id', '=', 'report_sellers.product_id')
                                                // ->join('customers', 'customers.customer_id', '=', 'report_sellers.customer_id')
                                                ->whereRaw("report_sellers.product_name NOT LIKE BINARY '%ดีลพิเศษ%'")
                                                ->whereBetween('report_sellers.date_purchase', [$filters_productValue['from'],  $filters_productValue['to']])
                                                ->select(
                                                    DB::raw('SUM(report_sellers.price * report_sellers.quantity) as total_sales'),
                                                )
                                                ->get();
                                            });

                $product_value = 0;
                foreach($count_sum as $row_sum) {
                    $product_value += $row_sum?->total_sales ?? 0;
                }
                // dd($product_value);

                    // dd($report_product);
        }
                    $categories = Category::get();

                    return view('report/product', compact(
                                                        'status_waiting', 'status_updated', 'status_registration', 'status_alert', 'user_id_admin', 'admin_area', 'sale_area',
                                                        'report_product',
                                                        'total_page',
                                                        'page',
                                                        'start',
                                                        'categories',
                                                        'total_quantity',
                                                        'product_value',
                                                    ));

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
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }

    public function import(Request $request)
    {
        //notin code;

        $keyword = $request->keyword;
        // dd($keyword);

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

        $page = $request->page;
        if ($page) {
            $page = $request->page;
        } else {
            $page = 1;
        }

        if(!empty($keyword)) {

            $pagination = Product::where('product_id', 'Like', "%{$keyword}%")
                                    ->orWhere('product_name', 'Like', "%{$keyword}%")
                                    ->get();

            $count_page = count($pagination);
            // dd($count_page);
    
            $perpage = 10;
            $total_page = ceil($count_page / $perpage);
            $start = ($perpage * $page) - $perpage;

            $product_all = Product::where('product_id', 'Like', "%{$keyword}%")
                                    ->orWhere('product_name', 'Like', "%{$keyword}%")
                                    ->offset($start)
                                    ->limit($perpage)
                                    ->get();

        } else {

            $pagination = Product::get();
            $count_page = count($pagination);
            // dd($count_page);
    
            $perpage = 10;
            $total_page = ceil($count_page / $perpage);
            $start = ($perpage * $page) - $perpage;

            $product_all = Product::offset($start)
                                    ->limit($perpage)
                                    ->get();
        }

        return view('/report/importproduct', compact(
                                                    'status_alert', 
                                                    'status_waiting', 
                                                    'status_updated', 
                                                    'status_registration', 
                                                    'user_id_admin',
                                                    'product_all',
                                                    'total_page',
                                                    'page',
                                                    'start',
                                                ));
    }

    public function productInfo (Request $request)
    {
     
        $id = $request->id;
        // dd($id);

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

        if(!empty($id)) {

            $product_all = Product::where('id', $id)->first();
            $category = DB::table('categories')->orderBy('categories_id', 'asc')->get();
            $subcategory = DB::table('subcategories')->orderBy('subcategories_id', 'asc')->get();
        }

        return view('/report/product-info', compact(
                                                    'status_alert', 
                                                    'status_waiting', 
                                                    'status_updated', 
                                                    'status_registration', 
                                                    'user_id_admin',
                                                    'product_all',
                                                    'category',
                                                    'subcategory'
                                                ));
    }

    public function newInfo (Request $request)
    {
     
        $id = $request->id;
        // dd($id);

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

        $product_all = Product::where('id', $id)->first();
        $category = DB::table('categories')->orderBy('categories_id', 'asc')->get();
        $subcategory = DB::table('subcategories')->orderBy('subcategories_id', 'asc')->get();
   

        return view('/report/new-product', compact(
                                                    'status_alert', 
                                                    'status_waiting', 
                                                    'status_updated', 
                                                    'status_registration', 
                                                    'user_id_admin',
                                                    'category',
                                                    'subcategory'
                                                ));
    }

    public function createInfo(Request $request) {
        date_default_timezone_set("Asia/Bangkok");

        $product_id = $request->product_id;
        $product_name = $request->product_name;
        $generic_name = $request->generic_name ?? '';
        $unit = $request->unit ?? '';
        $qty = $request->quantity ?? 0;
        $cost = floatval($request->cost ?? 0.00);
        $price_1 = floatval($request->price_1 ?? 0.00);
        $price_2 = floatval($request->price_2 ?? 0.00);
        $price_3 = floatval($request->price_3 ?? 0.00);
        $price_4 = floatval($request->price_4 ?? 0.00);
        $price_5 = floatval($request->price_5 ?? 0.00);
        $category = $request->category;
        $sub_category = $request->sub_category;
        $status = $request->status;

        $check_id = Product::where('product_id', $product_id)->first();

        if($request->has('submit_form')) {

            if($product_id != $check_id?->product_id) {
                // dd('submit_form');

                    $create = Product::create([
                                        'product_id'   => $product_id,
                                        'product_name' => $product_name,
                                        'generic_name' => $generic_name,
                                        'category' => $category,
                                        'sub_category' => $sub_category,
                                        'type' => '',
                                        'unit' => $unit,
                                        'quantity' => $qty,
                                        'cost' => $cost,
                                        'price_1' => $price_1,
                                        'price_2' => $price_2,
                                        'price_3' => $price_3,
                                        'price_4' => $price_4,
                                        'price_5' => $price_5,
                                        'status' => $status,
                                    ]);

                    $check_create = $create->firstWhere('product_id', $product_id)->product_id;

                    // dd($check_create);
                    if($product_id == $check_create) {
                        return redirect('/webpanel/report/product/new-product')->with('success', 'create-success');

                    } else {
                        return back()->with('error', 'create-error');
                    }

            } else {

                return back()->with('fail', 'create-fail');
            }

        }
    }

    public function updateCost (Request $request)
    {
     
        $id = $request->id;
        // dd($id);

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
   

        return view('/report/update-cost', compact(
                                                    'status_alert', 
                                                    'status_waiting', 
                                                    'status_updated', 
                                                    'status_registration', 
                                                    'user_id_admin',
 
                                                ));
    }

    public function importCostProduct(Request $request)
    {
        date_default_timezone_set("Asia/Bangkok");

        if($request->has('submit_csv') == true) 
        {
            
                $path = $request->file('import_cost');
                if($path == null) {
                    $path == '';
    
                } else {

                    // dd('dd');
                    $count = 0;
                    $rename = 'Product_update' . '_' . date("l jS \of F Y h:i:s A") . '.csv';

                    // เปิดไฟล์จาก path ที่คุณเก็บไว้
                    $request->file('import_cost')->storeAs('importcsv',$rename,'importfiles'); //importfiles filesystem.php->disk;
                    $fileStream = fopen(storage_path('app/public/importcsv/' . $rename), 'r');

                    if ($fileStream) {

                        // อ่านทีละบรรทัดแบบปลอดภัย
                        while (($row = fgetcsv($fileStream, 1000, "|")) !== false) {

                        if (!empty($row[0])) {
                        $updated =  Product::where('product_id', $row[0])->update([
/*                                             'product_id'    => $row[0],
                                            'product_name'  => $row[1],
                                            'generic_name'  => $row[2],
                                            'category'      => $row[3],
                                            'sub_category'  => $row[4],
                                            'type'          => $row[5],
                                            'unit'          => $row[6],
                                            'cost'          => '5',
                                            'price_1'       => $row[7],
                                            'price_2'       => $row[8],
                                            'price_3'       => $row[9],
                                            'price_4'       => $row[10],
                                            'price_5'       => $row[11],
                                            'quantity'      => $row[12],
                                            'status'        => $row[13], */

                                            'product_id' => $row[0],
                                            'product_name' => $row[1],
                                            'generic_name' => $row[2],
                                            'category' => $row[3],
                                            'sub_category' => $row[4],
                                            'type' => $row[5],
                                            'unit' => $row[6],
                                            'cost' => $row[7],
                                            'price_1' => $row[8],
                                            'price_2' => $row[9],
                                            'price_3' => $row[10],
                                            'price_4' => $row[11],
                                            'price_5' => $row[12],
                                            'quantity' => $row[13],
                                            'status' => $row[14],
                                            
                                        ]);

                                        $count += $updated;
                            }

                        }

                        // ปิดไฟล์หลังจากอ่านจบ
                        fclose($fileStream);
                    }


            }
            
            // $count = Product::all()->count();
            
            return redirect('/webpanel/report/product/update-cost')->with('success_import', 'นำเข้าข้อมูลสำเร็จ :'.' '.$count);
        }
            
   }


    public function updateInfo (Request $request) {

        date_default_timezone_set("Asia/Bangkok");

        $id = $request->id;
        
        if(!empty($id)) {

            $product_id = $request->product_id;
            $product_name = $request->product_name;
            $generic_name = $request->generic_name ?? '';
            $unit = $request->unit ?? '';
            $qty = $request->quantity ?? 0;
            $cost = floatval($request->cost ?? 0.00);
            $price_1 = floatval($request->price_1 ?? 0.00);
            $price_2 = floatval($request->price_2 ?? 0.00);
            $price_3 = floatval($request->price_3 ?? 0.00);
            $price_4 = floatval($request->price_4 ?? 0.00);
            $price_5 = floatval($request->price_5 ?? 0.00);
            $category = $request->category;
            $sub_category = $request->sub_category;
            $status = $request->status;

            Product::where('id', $id)->update([
                        'product_id' => $product_id,
                        'product_name' => $product_name,
                        'generic_name' => $generic_name,
                        'unit' => $unit,
                        'quantity' => $qty,
                        'cost' => $cost,
                        'price_1' => $price_1,
                        'price_2' => $price_2,
                        'price_3' => $price_3,
                        'price_4' => $price_4,
                        'price_5' => $price_5,
                        'category' => $category,
                        'sub_category' => $sub_category,
                        'status' => $status,
                    ]);

            // $check_id = Product::select('id')->where('id', $id)->first();
            $check_id = Product::find($id);

            if($id == $check_id?->id) {

                return redirect ('/webpanel/report/product/importproduct/'.$id)->with('updated_id', 'updated_success');

            } else {
                return redirect ('/webpanel/report/product/importproduct/'.$id)->with('fail_id', 'error');
            }
        }
    }

    public function importFile(Request $request)
    {
        date_default_timezone_set("Asia/Bangkok");

        if($request->has('submit_csv') == true) 
        {
            
                $path = $request->file('import_csv');
                if($path == null) {
                    $path == '';
    
                } else {

                    $rename = 'Product_all'.'_'.date("l jS \of F Y h:i:s A").'.csv';
                    $request->file('import_csv')->storeAs('importcsv',$rename,'importfiles'); //importfiles filesystem.php->disk;
                    $fileStream = fopen(storage_path('app/public/importcsv/'.$rename),'r');
                    // fgetcsv($fileStream); // skip header
                    
            /*         while (!feof($fileStream)) 
                            {

                                $row = fgetcsv($fileStream , 1000 , "|");
                                // dd($row[0]);
                                if(!empty($row[0])) {
                            
                                    Product::create([

                                        'product_id' => $row[0],
                                        'product_name' => $row[1],
                                        'generic_name' => $row[2],
                                        'category' => $row[3],
                                        'sub_category' => $row[4],
                                        'type' => $row[5],
                                        'unit' => $row[6],
                                        'cost' => $row[7],
                                        'price_1' => $row[8],
                                        'price_2' => $row[9],
                                        'price_3' => $row[10],
                                        'price_4' => $row[11],
                                        'price_5' => $row[12],
                                        'quantity' => $row[13],
                                        'status' => $row[14],
                
                                        ]);

                                }


                            } */

                            $batchSize = 500;
                            $dataBatch = [];

                            $header = fgetcsv($fileStream, 1000, "|");

                            while (!feof($fileStream)) {
                                $row = fgetcsv($fileStream, 1000, "|");

                                // ตรวจสอบว่า row ว่างหรือมีจำนวน column ไม่เพียงพอ //ข้ามแถวนี้ไปเลย ไม่ทำอะไรกับมัน;
                                if ($row === false || count($row) < 15 || empty($row[0])) {
                                    continue;
                                }

                                    $dataBatch[] = [
                                                        'product_id'    => $row[0],
                                                        'product_name'  => $row[1],
                                                        'generic_name'  => $row[2],
                                                        'category'      => $row[3],
                                                        'sub_category'  => $row[4],
                                                        'type'          => $row[5],
                                                        'unit'          => $row[6],
                                                        'cost'          => $row[7],
                                                        'price_1'       => $row[8],
                                                        'price_2'       => $row[9],
                                                        'price_3'       => $row[10],
                                                        'price_4'       => $row[11],
                                                        'price_5'       => $row[12],
                                                        'quantity'      => $row[13],
                                                        'status'        => $row[14],
                                                    ];

                                // ทำ bulk insert ทีละชุด
                                if (count($dataBatch) >= $batchSize) {
                                    Product::insert($dataBatch); // ใส่ข้อมูลทั้งหมดใน $dataBatch ลง DB ทีเดียว
                                    $dataBatch = [];             // เคลียร์ $dataBatch เพื่อเก็บข้อมูลชุดใหม่
                                }

                            }

                            // insert ข้อมูลที่เหลือ
                            if (!empty($dataBatch)) {
                                Product::insert($dataBatch);
                            }

                            fclose($fileStream);

                }

        }
        $count = Product::all()->count();
        
        return redirect('/webpanel/report/product/importproduct')->with('success_import', 'นำเข้าข้อมูลสำเร็จ :'.' '.$count);
            
   }

   public function show(Request $request)
   {

    // dd('show');

        $product_id = $request->id;
        $product_name = ReportSeller::where('product_id',$product_id)->first();
        $category_id = $request->category;
        $category_name = Category::where('categories_id', $category_id)->first();

        $from_purchase = $request->from;
        $to_purchase = $request->to;

        $filters_time = [
               /*  'from' => $request->from ?? date('Y-m-d'),
                'to' => $request->to ?? date('Y-m-d'), */
                'from' => $request->from ?? "2025-01-01",
                'to' => $request->to ?? "2025-01-30",
            ];

       $region = $request->region;
       $category = $request->category;
       // dd($purchase_check);
       // dd($to_purchase);

       if(!empty($region) && !empty($category)) {
           
                $product_list = ReportSeller::select(
                                'report_sellers.product_id',
                                DB::raw('SUM(report_sellers.price * report_sellers.quantity) as total_sales'),
                                DB::raw('SUM(report_sellers.quantity) as quantity_by'),
                                DB::raw('AVG(report_sellers.cost) as average_cost'),
                                'products.category',
                                'products.sub_category',
                                'products.product_name',
                                'categories.categories_name',
                                'subcategories.subcategories_name',
                                'products.unit',
                                'customers.geography',
                               /*  'customers.customer_id',
                                'customers.customer_name', */
                                'report_sellers.customer_id',
                                
                                )
                                ->join('products', function (JoinClause $join) {
                                    $join->on('products.product_id', '=', 'report_sellers.product_id');
                                })
                                ->join('categories', function (JoinClause $join) {
                                    $join->on('categories.categories_id', '=', 'products.category');
                                })
                                ->join('subcategories', function (JoinClause $join) {
                                    $join->on('subcategories.subcategories_id', '=', 'products.sub_category');
                                })
                                ->join('customers', function (JoinClause $join) {
                                    $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                })
                                ->groupBy(
                                'report_sellers.product_id',
                                'products.category',
                                'products.product_name',
                                'products.sub_category',
                                'categories.categories_name',
                                'subcategories.subcategories_name',
                                'products.unit',
                                'customers.geography',
                                /* 'customers.customer_id',
                                'customers.customer_name', */
                                'report_sellers.customer_id',
                                )
                                ->where('report_sellers.product_id', $product_id)
                                ->where('products.category', $category)
                                ->where('customers.geography', $region)
                                ->whereBetween('report_sellers.date_purchase', [$filters_time['from'], $filters_time['to']])
                                ->orderBy('quantity_by', 'desc')
                                ->get();

                                $count_customer = $product_list->count();

                              

       } else {

        
                $product_list = ReportSeller::select(
                                'report_sellers.product_id',
                                DB::raw('SUM(report_sellers.price * report_sellers.quantity) as total_sales'),
                                DB::raw('SUM(report_sellers.quantity) as quantity_by'),
                                DB::raw('AVG(report_sellers.cost) as average_cost'),
                                'products.category',
                                'products.sub_category',
                                'products.product_name',
                                'categories.categories_name',
                                'subcategories.subcategories_name',
                                'products.unit',
                                'report_sellers.customer_id',
                                // 'customers.customer_id',
                                // 'report_sellers.customer_name',
                                )
                                ->join('products', function (JoinClause $join) {
                                    $join->on('products.product_id', '=', 'report_sellers.product_id');
                                })
                                ->join('categories', function (JoinClause $join) {
                                    $join->on('categories.categories_id', '=', 'products.category');
                                })
                                ->join('subcategories', function (JoinClause $join) {
                                    $join->on('subcategories.subcategories_id', '=', 'products.sub_category');
                                })
                             /*    ->join('customers', function (JoinClause $join) {
                                    $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                }) */
                                ->groupBy(
                                'report_sellers.product_id',
                                'products.category',
                                'products.product_name',
                                'products.sub_category',
                                'categories.categories_name',
                                'subcategories.subcategories_name',
                                'products.unit',
                                'report_sellers.customer_id',

                                // 'customers.customer_id',
                                // 'report_sellers.customer_name',

                                )
                                ->where('report_sellers.product_id', $product_id)
                                ->whereBetween('report_sellers.date_purchase', [$filters_time['from'], $filters_time['to']])
                                ->orderBy('quantity_by', 'desc')
                                ->get();

                $count_customer = $product_list->count();
                // dd($count_customer);
                                // dd(gettype($product_list));
       }

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
       $start = 1;

       $customer_name = Customer::select('customer_id', 'customer_name')->first();

       return view('report/product-detail', compact(
                                            'total_customer', 
                                            'total_status_waiting', 
                                            'product_id', 
                                            'product_name', 
                                            'product_list', 
                                            'total_status_action', 
                                            'total_status_completed', 
                                            'total_status_updated', 
                                            'customer_status_inactive', 
                                            'status_alert',
                                            'status_registration', 
                                            'status_waiting', 
                                            'status_updated',
                                            'user_id_admin',
                                            'category_name',
                                            'count_customer',
                                            'start',
                                            'customer_name',
                                        ));
       
   }
   public function salesCategory(Request $request)
   {

        // dd('test');
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

            $filters_time = [
                'from' => $request->from ?? date('Y-m-d'),
                'to' => $request->to ?? date('Y-m-d'),

            ];
            $sales_category =  ReportSeller::where('report_sellers.product_name', 'NOT LIKE', '%ดีลพิเศษ%')
                                ->select(
                                DB::raw('SUM(report_sellers.price * report_sellers.quantity) as total_sales'),
                                DB::raw('SUM(report_sellers.quantity) as quantity_by'),
                                DB::raw('AVG(report_sellers.cost) as average_cost'),
                                DB::raw('AVG(report_sellers.price) as average_price'),
                                DB::raw('SUM(report_sellers.cost * report_sellers.quantity) as total_sales_cost'),
                                'categories.categories_name',
                                'categories.categories_id',
                                )
                                ->join('products', function (JoinClause $join) {
                                    $join->on('products.product_id', '=', 'report_sellers.product_id');
                                })
                                ->join('categories', function (JoinClause $join) {
                                    $join->on('categories.categories_id', '=', 'products.category');
                                })
                              /*   ->join('subcategories', function (JoinClause $join) {
                                    $join->on('subcategories.subcategories_id', '=', 'products.sub_category');
                                }) */
                                ->groupBy(
                                'categories.categories_name',
                                'categories.categories_id',
                                // 'report_sellers.customer_id',
                                )
                                // ->where('report_sellers.product_name', 'NOT LIKE', '%ดีลพิเศษ%')
                                ->whereBetween('report_sellers.date_purchase', [$filters_time['from'], $filters_time['to']])
                                ->orderBy('total_sales', 'desc')
                                ->get();

                                // dd($sales_category);
                                $total_sales = 0;
                                foreach($sales_category as $row) {
                                    $total_sales += $row->total_sales;
                                }

                                // dd($total_sales);

       return view('/report/by-category', compact(
                                                'status_alert',
                                                'status_waiting',
                                                'status_updated',
                                                'status_registration',
                                                'user_id_admin',
                                                'sales_category',
                                                'total_sales',
                                            ));
   }

   public function salesRegion(Request $request)
   {

    //    dd('test');
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

            $filters_region = [
                'from' => $request->from ?? date('Y-m-d'),
                'to' => $request->to ?? date('Y-m-d'),

     /*            'from' => $request->from ?? '2025-05-20',
                'to' => $request->to ?? '2025-05-22', */

            ];

            $key_region = 'sales_region_' . md5(json_encode($filters_region));

            $sales = Cache::remember($key_region, 1800, function () use ($filters_region) {

            return  ReportSeller::where('report_sellers.product_name', 'NOT LIKE', '%ดีลพิเศษ%')
                                ->select(
                                DB::raw('SUM(report_sellers.price * report_sellers.quantity) as total_sales'),
                                // DB::raw('SUM(report_sellers.quantity) as quantity_by'),
                                // DB::raw('AVG(report_sellers.cost) as average_cost'),
                                // DB::raw('AVG(report_sellers.price) as average_price'),
                              /*   DB::raw('SUM(report_sellers.cost * report_sellers.quantity) as total_sales_cost'), */
                                'categories.categories_name',
                                'categories.categories_id',
                                'customers.geography'
                               
                                )
                                ->join('products', function (JoinClause $join) {
                                    $join->on('products.product_id', '=', 'report_sellers.product_id');
                                })
                                ->join('categories', function (JoinClause $join) {
                                    $join->on('categories.categories_id', '=', 'products.category');
                                })
                                ->join('subcategories', function (JoinClause $join) {
                                    $join->on('subcategories.subcategories_id', '=', 'products.sub_category');
                                })
                                ->join('customers', function (JoinClause $join) {
                                    $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                })
                                ->groupBy(
                                'categories.categories_name',
                                'categories.categories_id',
                                'customers.geography'

                                )
                                // ->where('geography', 'ภาคตะวันออกเฉียงเหนือ') 
                                ->whereBetween('report_sellers.date_purchase', [$filters_region['from'], $filters_region['to']])
                                ->orderBy('categories.categories_id', 'asc')
                                ->get();

                        });

                                $total_sales = 0;
                                foreach($sales as $row) {
                                    $total_sales += $row->total_sales;
                                }
                                // dd($total_sales);


        // dd($sales->where('geography', 'ภาคใต้'));
       return view('/report/by-region', compact(
                                                'status_alert',
                                                'status_waiting',
                                                'status_updated',
                                                'status_registration',
                                                'user_id_admin',
                                                'sales',
                                                'total_sales',
                                            ));
   }

   public function viewRegion(Request $request)
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

       //parameter;
       $categories_id = $request->category;
       $region = $request->region;


       $category_name = Category::where('categories_id', $categories_id)->first();

            $filters_time = [
                'from' => $request->from ?? date('Y-m-d'),
                'to' => $request->to ?? date('Y-m-d'),

     /*            'from' => $request->from ?? '2025-05-20',
                'to' => $request->to ?? '2025-05-22', */

            ];
            $sales =  ReportSeller::where('report_sellers.product_name', 'NOT LIKE', '%ดีลพิเศษ%')
                                ->select(
                                DB::raw('SUM(report_sellers.price * report_sellers.quantity) as total_sales'),
                                DB::raw('SUM(report_sellers.quantity) as quantity_by'),
                                DB::raw('AVG(report_sellers.cost) as average_cost'),
                                DB::raw('AVG(report_sellers.price) as average_price'),
                                DB::raw('SUM(report_sellers.cost * report_sellers.quantity) as total_sales_cost'),
                                'categories.categories_name',
                                'categories.categories_id',
                                'customers.geography',
                          /*       'customers.customer_id',
                                'customers.customer_name', */
                                'report_sellers.product_id',
                                'report_sellers.product_name',
                                'products.unit',
                               
                                )
                                ->join('products', function (JoinClause $join) {
                                    $join->on('products.product_id', '=', 'report_sellers.product_id');
                                })
                                ->join('categories', function (JoinClause $join) {
                                    $join->on('categories.categories_id', '=', 'products.category');
                                })
                                ->join('subcategories', function (JoinClause $join) {
                                    $join->on('subcategories.subcategories_id', '=', 'products.sub_category');
                                })
                                ->join('customers', function (JoinClause $join) {
                                    $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                })
                                ->groupBy(
                                'categories.categories_name',
                                'categories.categories_id',
                                'customers.geography',
                         /*        'customers.customer_id',
                                'customers.customer_name', */
                                'report_sellers.product_id',
                                'report_sellers.product_name',
                                'products.unit',

                                )
                                ->where('geography', $region) 
                                ->where('categories_id', $categories_id) 
                                ->whereBetween('report_sellers.date_purchase', [$filters_time['from'], $filters_time['to']])
                                ->orderBy('quantity_by', 'desc')
                                ->get();

                                $total_sales = 0;
                                foreach($sales as $row) {
                                    $total_sales += $row->total_sales;
                                }
                        
                                // dd($sales);


        // dd($sales->where('geography', 'ภาคใต้'));
       return view('/report/region-detail', compact(
                                                'status_alert',
                                                'status_waiting',
                                                'status_updated',
                                                'status_registration',
                                                'user_id_admin',
                                                'category_name',
                                                'sales',
                                            ));
   }

   public function productRegion(Request $request)
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

        //parameter;
        $categories_id = $request->category;
        $region = $request->region;
        $product_id = $request->product;

        $product = Product::select('product_id', 'product_name')->firstWhere('product_id', $product_id);
        // dd($product->product_name);
        $category_name = Category::where('categories_id', $categories_id)->first();

            $filters_time = [
                'from' => $request->from ?? date('Y-m-d'),
                'to' => $request->to ?? date('Y-m-d'),

     /*            'from' => $request->from ?? '2025-05-20',
                'to' => $request->to ?? '2025-05-22', */

            ];
            $sales =  ReportSeller::where('report_sellers.product_name', 'NOT LIKE', '%ดีลพิเศษ%')
                                ->select(
                                DB::raw('SUM(report_sellers.price * report_sellers.quantity) as total_sales'),
                                DB::raw('SUM(report_sellers.quantity) as quantity_by'),
                                DB::raw('AVG(report_sellers.cost) as average_cost'),
                                DB::raw('AVG(report_sellers.price) as average_price'),
                                DB::raw('SUM(report_sellers.cost * report_sellers.quantity) as total_sales_cost'),
                                'categories.categories_name',
                                'categories.categories_id',
                                'customers.geography',
                                'customers.customer_id',
                                'customers.customer_name',
                                'report_sellers.product_id',
                                'report_sellers.product_name',
                                'products.unit',
                               
                                )
                                ->join('products', function (JoinClause $join) {
                                    $join->on('products.product_id', '=', 'report_sellers.product_id');
                                })
                                ->join('categories', function (JoinClause $join) {
                                    $join->on('categories.categories_id', '=', 'products.category');
                                })
                                ->join('subcategories', function (JoinClause $join) {
                                    $join->on('subcategories.subcategories_id', '=', 'products.sub_category');
                                })
                                ->join('customers', function (JoinClause $join) {
                                    $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                })
                                ->groupBy(
                                'categories.categories_name',
                                'categories.categories_id',
                                'customers.geography',
                                'customers.customer_id',
                                'customers.customer_name',
                                'report_sellers.product_id',
                                'report_sellers.product_name',
                                'products.unit',

                                )
                                ->where('report_sellers.product_id', $product_id)
                                ->where('geography', $region) 
                                ->where('categories_id', $categories_id) 
                                ->whereBetween('report_sellers.date_purchase', [$filters_time['from'], $filters_time['to']])
                                ->orderBy('quantity_by', 'desc')
                                ->get();

                                $total_sales = 0;
                                foreach($sales as $row) {
                                    $total_sales += $row->total_sales;
                                }
                        
                                // dd($sales);


        // dd($sales->where('geography', 'ภาคใต้'));
       return view('/report/region-product', compact(
                                                'status_alert',
                                                'status_waiting',
                                                'status_updated',
                                                'status_registration',
                                                'user_id_admin',
                                                'category_name',
                                                'sales',
                                                'product',
                                            ));
   }

   public function deleteProduct(Request $request)
   {

        $id = $request->id;
        // dd($request->id);
        if(!empty($request->id)) {

            // echo json_encode(array('checkcode'=> $request->user_code));

            $product = Product::where('id', $id)->first();

            $product->delete();

            echo json_encode(array('checkcode'=> $request->id));

        }
    
   }

   //preload cache;
  /*  public function preload(Request $request)
    {
        date_default_timezone_set("Asia/Bangkok");

        $code_notin = ['0000', '4494', '7787', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];

        $status_waiting = Customer::where('status', 'รอดำเนินการ')
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();

        $status_updated = Customer::where('status_update', 'updated')
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();

        $status_registration = Customer::where('status', 'ลงทะเบียนใหม่')
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();

        $status_alert = $status_waiting + $status_updated;

        $user_id_admin = $request->user()->user_id;

        //dropdown admin_area;
        $admin_area =  User::where('admin_area', '!=', '')->where('rights_area', '!=', '')->get();

        //dropdown sale_area;
        $sale_area =  Salearea::select('sale_area', 'sale_name')->get();

        $user_id_admin = $request->user()->user_id;

        $filters_s = [
            'from' => $request->from ?? '2025-01-01',
            'to'   => $request->to ?? '2025-01-25',
        ];

        $key = 'report_all_data';

        $perpage = 10;
        $page = $request->get('page', 1);
        $start = ($perpage * $page) - $perpage;

        $data = Cache::get($key);

        $count_page = $data->count();

        $total_page = ceil($count_page / $perpage);

        if (!$data) {
            return response()->json(['message' => 'Data not preloaded'], 404);
        }

        $report_product = collect($data)->forPage($page, $perpage);

        $categories = Category::get();

        return view('report/product', compact(
                                            'status_waiting', 'status_updated', 'status_registration', 'status_alert', 'user_id_admin', 'admin_area', 'sale_area',
                                            'report_product',
                                            'total_page',
                                            'page',
                                            'start',
                                            'categories',
                                        ));
    }
 */
}
