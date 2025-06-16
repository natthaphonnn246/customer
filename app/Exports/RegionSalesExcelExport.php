<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\JoinClause;
use App\Models\ReportSeller;
use App\Models\Customer;
use App\Models\Category;
use App\Models\Product;

class RegionSalesExcelExport
{
    use Exportable;
    /**
    
    */
    public function exportViewRegionExcel (Request $request)
    {

        // dd('test');
        date_default_timezone_set("Asia/Bangkok");

        $categories_id = $request->category;
        $region = $request->region;
        $from = $request->from;
        $to = $request->to;

        $date = $from.'_'.'to'.'_'.$to;
        $filename = 'Product_value_'.$region.'_'.$categories_id.'_'. $date;
            // Start the output buffer.

        $category_name = Category::where('categories_id', $categories_id)->first();

                $filters_time = [
                    'from' => $request->from ?? date('Y-m-d'),
                    'to' => $request->to ?? date('Y-m-d'),

        /*            'from' => $request->from ?? '2025-05-20',
                    'to' => $request->to ?? '2025-05-22', */

                ];
                return ReportSeller::where('products.product_name', 'NOT LIKE', '%ดีล%')
                                        ->select(
                                        'report_sellers.product_id',
                                        'report_sellers.product_name',
                                        'products.unit',
                                        DB::raw('SUM(report_sellers.quantity) as quantity_by'),
                                        DB::raw('AVG(report_sellers.price) as average_price'),
                                        DB::raw('SUM(report_sellers.price * report_sellers.quantity) as total_sales'),
                                        'categories.categories_name',
                                        'categories.categories_id',
                                        'customers.geography',
/*                                         DB::raw('AVG(report_sellers.cost) as average_cost'),
                                      
                                        DB::raw('SUM(report_sellers.cost * report_sellers.quantity) as total_sales_cost'), */
                                      
                                /*       'customers.customer_id',
                                        'customers.customer_name', */
                                     
                                    
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
                                        ->downloadExcel('Product_value'.'_'.$filename.'.'.'xlsx',\Maatwebsite\Excel\Excel::XLSX, true);



    }
}
