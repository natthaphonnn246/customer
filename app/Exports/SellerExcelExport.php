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

class SellerExcelExport
{
    /**

    */
    use Exportable;
    public function exportSellerExcel(Request $request)
    {

        // dd('export');
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
                $filename = $date;
                    // Start the output buffer.

                // Customer::select('customer_id', 'customer_name')->get();
                
                return ReportSeller::select(
                                            'report_sellers.customer_id',
                                            'customers.sale_area', 
                                            'customers.admin_area', 
                                            'report_sellers.customer_name', 
                                            'report_sellers.purchase_order', 
                                            DB::raw('SUM(price*quantity) as total_sales'), 
                                            'customers.province', 
                                            'customers.geography', 
                                            'customers.delivery_by',
                                            'report_sellers.date_purchase',
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
                                                'customers.delivery_by',
                                                'report_sellers.date_purchase'
                                            )
                                    ->whereBetween('report_sellers.date_purchase', [$from_date, $to_date])
                                    ->havingBetween('total_sales', [$min_selling, $max_selling])
                                    ->whereNotIn('report_sellers.customer_id', $code_notin)
                                    ->orderBy('customer_id', 'asc')
                                    ->downloadExcel('Seller'.'_'.$filename.'.'.'xlsx',\Maatwebsite\Excel\Excel::XLSX, true);


            } else {

                //แสดงข้อมูลลูกค้า;

                //  dd('export');
                        $date = $to_date.'_'.'to'.'_'.$from_date;
                        $filename = $date;
        
    

                        return ReportSeller::select(
                                                    'report_sellers.customer_id',
                                                    'customers.sale_area', 
                                                    'customers.admin_area', 
                                                    'report_sellers.customer_name', 
                                                    'report_sellers.purchase_order', 
                                                    DB::raw('SUM(price*quantity) as total_sales'), 
                                                    'customers.province', 
                                                    'customers.geography', 
                                                    'customers.delivery_by',
                                                    'report_sellers.date_purchase',
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
                                                    'customers.delivery_by',
                                                    'report_sellers.date_purchase',
                                                )
                                        ->whereBetween('report_sellers.date_purchase', [$from_date, $to_date])
                                        ->whereNotIn('report_sellers.customer_id', $code_notin)
                                        ->orderBy('customer_id', 'asc')
                                        ->downloadExcel('Seller'.'_'.$filename.'.'.'xlsx',\Maatwebsite\Excel\Excel::XLSX, true);

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
            $filename = $date;
            // dd($filename);
            // $customers_customer_name = Customer::select('customer_id', 'customer_name')->get();
            // dd($customers_customer_name);

    /*      $report_seller = ReportSeller::select('report_sellers.customer_id', DB::raw('SUM(price * quantity) as total_sales'))
                                            ->join('customers', function (JoinClause $join) {
                                                $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                                            })
                                            ->groupBy('report_sellers.customer_id', 'customers.customer_name')
                                            ->offset($start)
                                            ->limit($perpage)
                                            ->get(); */

                        return ReportSeller::select(
                                                    'report_sellers.customer_id',
                                                    'customers.sale_area', 
                                                    'customers.admin_area', 
                                                    'report_sellers.customer_name', 
                                                    'report_sellers.purchase_order', 
                                                    DB::raw('SUM(price * quantity) as total_sales'), 
                                                    'customers.province', 
                                                    'customers.geography', 
                                                    'customers.delivery_by',
                                                    'report_sellers.date_purchase',
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
                                                        'customers.delivery_by',
                                                        'report_sellers.date_purchase',
                                                    )
                                            ->whereNotIn('report_sellers.customer_id', $code_notin)
                                            ->orderBy('customer_id', 'asc')
                                            ->downloadExcel('Seller_all'.'_'.$filename.'.'.'xlsx',\Maatwebsite\Excel\Excel::XLSX, true);
        
        }
    }

    public function exportNumPurExcel(Request $request)
    {
        $from_check = $request->from ?? date('Y-m-d');
        $to_check   = $request->to ?? date('Y-m-d');

        // dd($from_check);

        $code_notin = ['0000', '4494', '7787', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];

        $date = date('d-m-Y');
        $filename = $date;

        return ReportSeller::select(
                                'report_sellers.customer_id',
                                'customers.customer_name',
                                DB::raw('COUNT(DISTINCT report_sellers.date_purchase) AS unique_purchase_days'),
                                // DB::raw("GROUP_CONCAT(DISTINCT report_sellers.date_purchase ORDER BY report_sellers.date_purchase ASC) AS purchase_dates")
                                // DB::raw("GROUP_CONCAT(DISTINCT report_sellers.date_purchase ORDER BY report_sellers.date_purchase ASC SEPARATOR ' | ') AS purchase_dates"),
                                DB::raw('SUM(report_sellers.quantity*report_sellers.price) AS total_orders'),
                                'customers.delivery_by',
                                'customers.geography',
                                'customers.province',
                        )
                        ->join('customers', function (JoinClause $join) {
                            $join->on('customers.customer_id', '=', 'report_sellers.customer_id');
                        })
                        ->whereBetween('report_sellers.date_purchase', [$from_check, $to_check])
                        ->whereNotIn('report_sellers.customer_id', $code_notin)
                        ->groupBy(
                            'report_sellers.customer_id', 
                            'customers.customer_name', 
                            'customers.geography', 
                            'customers.province', 
                            'customers.delivery_by'
                        )
                        ->orderBy('customer_id', 'asc')
                        // ->havingRaw('COUNT(DISTINCT report_sellers.date_purchase) >= 4')
                        ->downloadExcel('Numberof_Pur'.'_'.$filename.'.'.'xlsx',\Maatwebsite\Excel\Excel::XLSX, true);
    }

}
