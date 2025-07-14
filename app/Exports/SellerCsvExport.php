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

// class SellerCsvExport implements FromCollection
class SellerCsvExport
{
    
    use Exportable;
    public function exportSellerCsv(Request $request)
    {
       
        set_time_limit(300); 
        date_default_timezone_set("Asia/Bangkok");

        $code_notin = ['0000', '4494', '7787', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];

        $from_date = $request->from;
        $to_date = $request->to;
        $max_selling = $request->max_seller;
        $min_selling = $request->min_seller;
        // dd($min_selling);

        if(!empty($from_date) && !empty($to_date))
        {
           
            // $range_min = $request->min_seller;
            // $range_max = $request->max_seller;

            // dd($range_min);
            
            // if($range_min == null AND $range_max == null) {
            if (!empty($min_selling) && !empty($max_selling)) {
                //แสดงข้อมูลลูกค้า;

                $date = $to_date.'_'.'to'.'_'.$from_date;
                $filename = 'Seller_'. $date.'.csv';
                    // Start the output buffer.
                ob_start();

                // Set PHP headers for CSV output.
                header('Content-Type: text/csv; charset=utf-8');
                header('Content-Disposition: attachment; filename= '.$filename);

                $customers_customer_name = Customer::select('customer_id', 'customer_name')->get();
                
                $report_seller = ReportSeller::select(
                                                        'report_sellers.customer_id',
                                                        'customers.sale_area',
                                                        'customers.admin_area', 
                                                        'report_sellers.customer_name', 
                                                        'report_sellers.purchase_order', 
                                                        DB::raw('SUM(price*quantity) as total_sales'), 
                                                        'customers.province',
                                                        'customers.geography', 
                                                        'customers.delivery_by'
                                                    )
                                ->join('customers', function (JoinClause $join) {
                                    $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                })
                                ->groupBy(
                                            'report_sellers.customer_id', 
                                            'report_sellers.customer_name', 
                                            'report_sellers.purchase_order', 
                                            'customers.sale_area', 
                                            'customers.admin_area', 
                                            'customers.province',
                                            'customers.geography', 
                                            'customers.delivery_by'
                                        )
                                ->whereBetween('report_sellers.date_purchase', [$from_date, $to_date])
                                ->havingBetween('total_sales', [$min_selling, $max_selling])
                                ->whereNotIn('report_sellers.customer_id', $code_notin)
                                ->orderBy('customer_id', 'asc')
                                ->cursor(); 

                $data = $report_seller->toArray();
                // dd('dd');
                ob_end_clean();

            } else {

                 //แสดงข้อมูลลูกค้า;

                // dd('export');
                        $date = $to_date.'_'.'to'.'_'.$from_date;
                        $filename = 'Seller_'. $date.'.csv';
                            // Start the output buffer.
                        ob_start();
        
                        // Set PHP headers for CSV output.
                        header('Content-Type: text/csv; charset=utf-8');
                        header('Content-Disposition: attachment; filename= '.$filename);

                        $report_seller = ReportSeller::select(
                                                                'report_sellers.customer_id',
                                                                'customers.sale_area', 
                                                                'customers.admin_area', 
                                                                'report_sellers.customer_name', 
                                                                'report_sellers.purchase_order', 
                                                                DB::raw('SUM(price*quantity) as total_sales'), 
                                                                'customers.province',
                                                                'customers.geography', 
                                                                'customers.delivery_by'
                                                            )
                                        ->join('customers', function (JoinClause $join) {
                                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                        })
                                        ->groupBy(
                                                    'report_sellers.customer_id', 
                                                    'report_sellers.customer_name', 
                                                    'report_sellers.purchase_order', 
                                                    'customers.sale_area', 
                                                    'customers.admin_area', 
                                                    'customers.geography', 
                                                    'customers.province',
                                                    'customers.delivery_by'
                                                )
                                        ->whereBetween('report_sellers.date_purchase', [$from_date, $to_date])
                                        ->whereNotIn('report_sellers.customer_id', $code_notin)
                                        ->orderBy('customer_id', 'asc')
                                        ->cursor(); 

                        $data = $report_seller->toArray();

                        ob_end_clean();
            }
            
        } else {
      
            // dd($request);

            date_default_timezone_set("Asia/Bangkok");
            // $keyword_date =  date('Y-m-d');
            /* $keyword_date_from = date('Y-m-d');
            $keyword_date_to =  date('Y-m-d');
            // dd($keyword_date); */
            //แสดงข้อมูลลูกค้า;

            $date = date('d-m-Y');
            $filename = 'Seller_all'.'_'. $date.'.csv';
             // Start the output buffer.
            ob_start();

            // Set PHP headers for CSV output.
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename= '.$filename);

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

            $report_seller = ReportSeller::select(
                                                    'report_sellers.customer_id',
                                                    'customers.sale_area', 
                                                    'customers.admin_area', 
                                                    'report_sellers.customer_name', 
                                                    'report_sellers.purchase_order', 
                                                    DB::raw('SUM(price * quantity) as total_sales'), 
                                                    'customers.province',
                                                    'customers.geography', 
                                                    'customers.delivery_by'
                                                )
                                            ->join('customers', function (JoinClause $join) {
                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                            })
                                            ->groupBy(
                                                        'report_sellers.customer_id',
                                                        'report_sellers.customer_name', 
                                                        'report_sellers.purchase_order', 
                                                        'customers.sale_area', 
                                                        'customers.admin_area', 
                                                        'customers.province',
                                                        'customers.geography', 
                                                        'customers.delivery_by'
                                                    )
                                            ->whereNotIn('report_sellers.customer_id', $code_notin)
                                            ->orderBy('customer_id', 'asc')
                                            ->cursor(); 
         
            $data = $report_seller->toArray();

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
}
