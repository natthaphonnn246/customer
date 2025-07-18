<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Customer;
use App\Models\ReportSeller;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\JoinClause;
class ProductCsvExport
{
    use Exportable;
    public function exportProductCsv(Request $request)
    {

        // dd('test');

        date_default_timezone_set("Asia/Bangkok");

        $from = $request->from;
        $to = $request->to;
        $category = $request->category;
        $region = $request->region;

        // dd($category);
        // dd($min_selling);

        if(!empty($from) && !empty($to))
        {
        //    dd('test');
            if (!empty($region) && empty($category)) {

                        $date = $from.'_'.'to'.'_'.$to;
                        $filename = 'Product_value_'.$region.'_'. $date.'.csv';
                            // Start the output buffer.
                        ob_start();

                        // Set PHP headers for CSV output.
                        header('Content-Type: text/csv; charset=utf-8');
                        header('Content-Disposition: attachment; filename= '.$filename);
                        
                        $report_product = ReportSeller::select(
                                            'report_sellers.product_id',
                                            'products.product_name',
                                            'products.unit',
                                            DB::raw('SUM(report_sellers.quantity) as quantity_by'),
                                            DB::raw('AVG(report_sellers.price) as average_price'),
                                            DB::raw('AVG(report_sellers.cost) as average_cost'),
                                            DB::raw('SUM(report_sellers.price * report_sellers.quantity) as total_sales'),
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
                                            ->where('customers.geography', $region)
                                            ->whereBetween('report_sellers.date_purchase', [$from, $to])
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

                                $data = $report_product->toArray();
                                // dd('dd');
                                ob_end_clean();

                } elseif (!empty($category) && empty($region)) {

                    // dd('test');
                        $date = $from.'_'.'to'.'_'.$to;
                        $filename = 'Product_value_'.$category.'_'. $date.'.csv';
                            // Start the output buffer.
                        ob_start();

                        // Set PHP headers for CSV output.
                        header('Content-Type: text/csv; charset=utf-8');
                        header('Content-Disposition: attachment; filename= '.$filename);
                        
                        $report_product = ReportSeller::select(
                                            'report_sellers.product_id',
                                            'products.product_name',
                                            'products.unit',
                                            DB::raw('SUM(report_sellers.quantity) as quantity_by'),
                                            DB::raw('AVG(report_sellers.price) as average_price'),
                                            DB::raw('AVG(report_sellers.cost) as average_cost'),
                                            DB::raw('SUM(report_sellers.price * report_sellers.quantity) as total_sales'),
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
                                            ->where('products.category', $category)
                                            ->whereBetween('report_sellers.date_purchase', [$from, $to])
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

                                $data = $report_product->toArray();
                                // dd('dd');
                                ob_end_clean();

                    } elseif(!empty($region) && !empty($category)) {

                        $date = $from.'_'.'to'.'_'.$to;
                        $filename = 'Product_value_'.$region.'_'.$category.'_'. $date.'.csv';
                            // Start the output buffer.
                        ob_start();

                        // Set PHP headers for CSV output.
                        header('Content-Type: text/csv; charset=utf-8');
                        header('Content-Disposition: attachment; filename= '.$filename);

                        $report_product = ReportSeller::select(
                                            'report_sellers.product_id',
                                            'products.product_name',
                                            'products.unit',
                                            DB::raw('SUM(report_sellers.quantity) as quantity_by'),
                                            DB::raw('AVG(report_sellers.price) as average_price'),
                                            DB::raw('AVG(report_sellers.cost) as average_cost'),
                                            DB::raw('SUM(report_sellers.price * report_sellers.quantity) as total_sales'),
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
                                            ->where('products.category', $category)
                                            ->where('customers.geography', $region)
                                            ->whereBetween('report_sellers.date_purchase', [$from, $to])
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
                                            
                                $data = $report_product->toArray();
                                // dd('dd');
                                ob_end_clean();

                    } else {

                        // dd('test');
                        $date = $from.'_'.'to'.'_'.$to;
                        $filename = 'Product_value_'. $date.'.csv';
                            // Start the output buffer.
                        ob_start();

                        // Set PHP headers for CSV output.
                        header('Content-Type: text/csv; charset=utf-8');
                        header('Content-Disposition: attachment; filename= '.$filename);

                        $report_product = ReportSeller::select(
                                            'report_sellers.product_id',
                                            'products.product_name',
                                            'products.unit',
                                            DB::raw('SUM(report_sellers.quantity) as quantity_by'),
                                            DB::raw('AVG(report_sellers.price) as average_price'),
                                            DB::raw('AVG(report_sellers.cost) as average_cost'),
                                            DB::raw('SUM(report_sellers.price * report_sellers.quantity) as total_sales'),
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
                                            ->whereBetween('report_sellers.date_purchase', [$from, $to])
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

                                $data = $report_product->toArray();
                                // dd('dd');
                                ob_end_clean();

                        }

            } else {

                        $date = $from.'_'.'to'.'_'.$to;
                        $filename = 'Product_value_all_'. $date.'.csv';
                            // Start the output buffer.
                        ob_start();

                        // Set PHP headers for CSV output.
                        header('Content-Type: text/csv; charset=utf-8');
                        header('Content-Disposition: attachment; filename= '.$filename);

                        $report_product = ReportSeller::select(
                                            'report_sellers.product_id',
                                            'products.product_name',
                                            'products.unit',
                                            DB::raw('SUM(report_sellers.quantity) as quantity_by'),
                                            DB::raw('AVG(report_sellers.price) as average_price'),
                                            DB::raw('AVG(report_sellers.cost) as average_cost'),
                                            DB::raw('SUM(report_sellers.price * report_sellers.quantity) as total_sales'),
/*                                             'products.category',
                                            'products.sub_category', */
                                            'categories.categories_name',
                                            'subcategories.subcategories_name',
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
          
                            $data = $report_product->toArray();
                            // dd('dd');
                            ob_end_clean();
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

        public function exportItemCsv(Request $request)
        {
            // dd('item');
            date_default_timezone_set("Asia/Bangkok");

            $from = $request->from;
            $to = $request->to;
            $category = $request->category;
            $region = $request->region;
            $product_id = $request->id;

            if(!empty($from) && !empty($to))
            {
                if(!empty($category) && !empty($region)) {
                    // dd('dd');
                    $date = $from.'_'.'to'.'_'.$to;
                    $filename = 'Product_item_'. $date.'.csv';
                        // Start the output buffer.
                    ob_start();
                    // Set PHP headers for CSV output.
                    header('Content-Type: text/csv; charset=utf-8');
                    header('Content-Disposition: attachment; filename= '.$filename);

                    $report_product = ReportSeller::select(
                                        'report_sellers.customer_id',
                                        'customers.customer_name',
                                        'products.unit',
                                        DB::raw('SUM(report_sellers.quantity) as quantity_by'),
                                        )
                                        ->join('products', function (JoinClause $join) {
                                            $join->on('products.product_id', '=', 'report_sellers.product_id');
                                        })
                                        ->join('customers', function (JoinClause $join) {
                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                        })
                                        ->join('categories', function (JoinClause $join) {
                                            $join->on('categories.categories_id', '=', 'products.category');
                                        })
                          
                                        ->groupBy(
                                        'report_sellers.customer_id',
                                        'customers.customer_name',
                                        'products.unit'
                            /*             'products.category',
                                        'customers.geography', */
                                        )
                                        ->where('report_sellers.product_id', $product_id)
                                        ->where('products.category', $category)
                                        ->where('customers.geography', $region) 
                                        ->whereBetween('report_sellers.date_purchase', [$from, $to])
                                        ->orderBy('quantity_by', 'desc')
                                        ->cursor();
                                        
                            $data = $report_product->toArray();
                         
                            ob_end_clean();
                
                } else {

                    // dd('dd');
                    $date = $from.'_'.'to'.'_'.$to;
                    $filename = 'Product_item_'.$date.'.csv';
                        // Start the output buffer.
                    ob_start();

                    // Set PHP headers for CSV output.
                    header('Content-Type: text/csv; charset=utf-8');
                    header('Content-Disposition: attachment; filename= '.$filename);

                    $report_product = ReportSeller::select(
                                        'report_sellers.customer_id',
                                        'customers.customer_name',
                                        'products.unit',
                                        DB::raw('SUM(report_sellers.quantity) as quantity_by'),
/*                                         DB::raw('AVG(report_sellers.cost) as average_cost'),
                                        DB::raw('SUM(report_sellers.price * report_sellers.quantity) as total_sales'), */
                                        )
                                        ->join('products', function (JoinClause $join) {
                                            $join->on('products.product_id', '=', 'report_sellers.product_id');
                                        })
                                        ->join('customers', function (JoinClause $join) {
                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                        })
                                 /*   */
                                        ->groupBy(
                                        'report_sellers.customer_id',
                                        'customers.customer_name',
                                        'products.unit'
                                        )
                                        ->where('report_sellers.product_id', $product_id)
                                        ->whereBetween('report_sellers.date_purchase', [$from, $to])
                                        ->orderBy('quantity_by', 'desc')
                                        ->cursor();

                            $data = $report_product->toArray();
                            // dd('dd');
                            ob_end_clean();

                }

            } else {

                $date = $from.'_'.'to'.'_'.$to;
                $filename = 'Product_item_'. $date.'.csv';
                    // Start the output buffer.
                ob_start();

                // Set PHP headers for CSV output.
                header('Content-Type: text/csv; charset=utf-8');
                header('Content-Disposition: attachment; filename= '.$filename);

                $report_product = ReportSeller::select(
                                        'report_sellers.customer_id',
                                        'customers.customer_name',
                                        'products.unit',
                                        DB::raw('SUM(report_sellers.quantity) as quantity_by'),
/*                                         DB::raw('AVG(report_sellers.cost) as average_cost'),
                                        DB::raw('SUM(report_sellers.price * report_sellers.quantity) as total_sales'), */
                                        )
                                        ->join('products', function (JoinClause $join) {
                                            $join->on('products.product_id', '=', 'report_sellers.product_id');
                                        })
                                        ->join('customers', function (JoinClause $join) {
                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                        })
                                 /*   */
                                        ->groupBy(
                                        'report_sellers.customer_id',
                                        'customers.customer_name',
                                        'products.unit'
                                        )
                                        ->where('report_sellers.product_id', $product_id)
                                        ->orderBy('quantity_by', 'desc')
                                        ->cursor();

                        $data = $report_product->toArray();
                        // dd('dd');
                        ob_end_clean();

            }

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
    }

