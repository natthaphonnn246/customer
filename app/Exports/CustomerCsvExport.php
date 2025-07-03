<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use Carbon\Carbon;

class CustomerCsvExport
{
    use Exportable;
    public function exportCustomerCsv($status)
    {
         // dd($status);
 
        //notin code;
        $code_notin = ['0000', '4494', '7787', '8118', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];

         switch ($status)
         {
 
            // case $status == 'getcsv_completed': ผิด laravel;
             case 'getcsv_completed':
                 $date = date('Y-m-d');
                 $filename = 'Customer_completed_'. $date.'.csv';
                  // Start the output buffer.
                 ob_start();
 
                 // Set PHP headers for CSV output.
                 header('Content-Type: text/csv; charset=utf-8');
                 header('Content-Disposition: attachment; filename= '.$filename);
                 
                 $query = Customer::select('customer_code', 'customer_name', 'province', 'geography', 'admin_area', 'sale_area')
                                    //  ->whereNotIn('customer_code', ['0000','4494'])
                                    ->whereNotIn('customer_code', $code_notin)
                                    ->where('status', 'ดำเนินการแล้ว')
                                    ->get();
 
                 $data = $query->toArray();
                 // Clean up output buffer before writing anything to CSV file.
                 ob_end_clean();
             break;
 
             case 'getcsv_action':
                 $date = date('Y-m-d');
                 $filename = 'Customer_action_'. $date. '.csv';
                  // Start the output buffer.
                 ob_start();
 
                 // Set PHP headers for CSV output.
                 header('Content-Type: text/csv; charset=utf-8');
                 header('Content-Disposition: attachment; filename= '.$filename);
                 
                 $query = Customer::select('customer_code', 'customer_name', 'province', 'geography', 'admin_area', 'sale_area')
                                    // ->whereNotIn('customer_code', ['0000','4494'])
                                    ->whereNotIn('customer_code', $code_notin)
                                    ->where('status', 'ต้องดำเนินการ')
                                    ->get();
 
                 $data = $query->toArray();
                 // Clean up output buffer before writing anything to CSV file.
                 ob_end_clean();
             break;
 
             case 'getcsv_waiting':
                 $date = date('Y-m-d');
                 $filename = 'Customer_waiting_'. $date. '.csv';
                  // Start the output buffer.
                 ob_start();
 
                 // Set PHP headers for CSV output.
                 header('Content-Type: text/csv; charset=utf-8');
                 header('Content-Disposition: attachment; filename= '.$filename);
                 
                 $query = Customer::select('customer_code', 'customer_name', 'province', 'geography', 'admin_area', 'sale_area')
                                    //  ->whereNotIn('customer_code', ['0000','4494'])
                                    ->whereNotIn('customer_code', $code_notin)
                                    ->where('status', 'รอดำเนินการ')
                                    ->get();
 
                 $data = $query->toArray();
                 // Clean up output buffer before writing anything to CSV file.
                 ob_end_clean();
             break;
 
             case 'getcsv_update':
                 $date = date('Y-m-d');
                 $filename = 'Customer_update_'. $date. '.csv';
                  // Start the output buffer.
                 ob_start();
 
                 // Set PHP headers for CSV output.
                 header('Content-Type: text/csv; charset=utf-8');
                 header('Content-Disposition: attachment; filename= '.$filename);
                 
                 $query = Customer::select('customer_code', 'customer_name', 'province', 'geography', 'admin_area', 'sale_area')
                                    //  ->whereNotIn('customer_code', ['0000','4494'])
                                    ->whereNotIn('customer_code', $code_notin)
                                    ->where('status_update', "updated")
                                    ->get();
 
                 $data = $query->toArray();
                 // Clean up output buffer before writing anything to CSV file.
                 ob_end_clean();
             break;
 
             case 'getcsv_inactive':
                 $date = date('Y-m-d');
                 $filename = 'Customer_inactive_'. $date. '.csv';
                  // Start the output buffer.
                 ob_start();
 
                 // Set PHP headers for CSV output.
                 header('Content-Type: text/csv; charset=utf-8');
                 header('Content-Disposition: attachment; filename= '.$filename);
                 
                 $query = Customer::select('customer_code', 'customer_name', 'province', 'geography', 'admin_area', 'sale_area')
                                    //  ->whereNotIn('customer_code', ['0000','4494'])
                                    ->whereNotIn('customer_code', $code_notin)
                                    ->where('customer_status', "inactive")
                                    ->get();
 
                 $data = $query->toArray();
                 // Clean up output buffer before writing anything to CSV file.
                 ob_end_clean();
             break;
 
             case 'getcsv_customerall':
                 $date = date('Y-m-d');
                 $filename = 'Customer_all_'. $date. '.csv';
                  // Start the output buffer.
                 ob_start();
 
                 // Set PHP headers for CSV output.
                 header('Content-Type: text/csv; charset=utf-8');
                 header('Content-Disposition: attachment; filename= '.$filename);
                 
                 $query = Customer::select('customer_code', 'customer_name', 'province', 'geography', 'admin_area', 'sale_area', 'status', 'customer_status', 'delivery_by')
                                    //  ->whereNotIn('customer_code', ['0000','4494'])
                                    ->whereNotIn('customer_code', $code_notin)
                                    ->get();
 
                 $data = $query->toArray();
                 // Clean up output buffer before writing anything to CSV file.
                 ob_end_clean();
             break;
 
 
             case 'getcsv_following':
                 $date = date('Y-m-d');
                 $filename = 'Customer_following_'. $date. '.csv';
                  // Start the output buffer.
                 ob_start();
 
                 // Set PHP headers for CSV output.
                 header('Content-Type: text/csv; charset=utf-8');
                 header('Content-Disposition: attachment; filename= '.$filename);
                 
                 $query = Customer::select('customer_code', 'customer_name', 'province', 'geography', 'admin_area', 'sale_area', 'status', 'status_user')
                                    //  ->whereNotIn('customer_code', ['0000','4494'])
                                    ->whereNotIn('customer_code', $code_notin)
                                    ->where('status_user', "กำลังติดตาม")
                                    ->get();
 
                 $data = $query->toArray();
                 // Clean up output buffer before writing anything to CSV file.
                 ob_end_clean();
             break;
 
 
             default:
                 // return back()->with('error_export', 'เกิดข้อผิดพลาด');
                 return abort('403', 'ERROR EXPORT');
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

    public function PurchaseExoportCsv($status_pur)
    {
        $code_notin = ['0000', '4494', '7787', '8118', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];
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

        // dd($status_pur);

        switch ($status_pur) 
        {
            
            case 'morethan';
            $date = date('Y-m-d');
            $filename = 'Purchase_morethan_'. $date. '.csv';

            // ob_start();
 
            // Set PHP headers for CSV output.
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename= '.$filename);
            
            $query_customer = Customer::select(
                                                'customers.customer_id',
                                                'customers.customer_name',
                                                'customers.status',
                                                'customers.admin_area',
                                                'customers.sale_area',
                                                'customers.customer_status',
                                                DB::raw('MAX(report_sellers.date_purchase) as last_purchase_date'),
                                                DB::raw('"ไม่สั่งเกิน 7 วัน" as status_pur')


                                            )
                                            ->join('report_sellers', 'customers.customer_id', '=', 'report_sellers.customer_id')
                                            ->groupBy(
                                                'customers.customer_id',
                                                'customers.customer_name',
                                                'customers.status',
                                                'customers.admin_area',
                                                'customers.sale_area',
                                                'customers.customer_status',

                                            )
                                            ->having('last_purchase_date', '<=', $from_7)
                                            ->whereNotIn('customers.customer_id', $code_notin)
                                            ->orderBydesc('last_purchase_date')
                                            ->get();

            $data = $query_customer->toArray();
            // Clean up output buffer before writing anything to CSV file.
            // ob_end_clean();

            break;

            case 'coming';
            $date = date('Y-m-d');
            $filename = 'Purchase_coming_'. $date. '.csv';

            // ob_start();
 
            // Set PHP headers for CSV output.
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename= '.$filename);
            
            $query_customer = Customer::select(
                                                'customers.customer_id',
                                                'customers.customer_name',
                                                'customers.status',
                                                'customers.admin_area',
                                                'customers.sale_area',
                                                'customers.customer_status',
                                                DB::raw('MAX(report_sellers.date_purchase) as last_purchase_date'),
                                                DB::raw('"ใกล้ครบกำหนด" as status_pur')



                                            )
                                            ->join('report_sellers', 'customers.customer_id', '=', 'report_sellers.customer_id')
                                            ->groupBy(
                                                'customers.customer_id',
                                                'customers.customer_name',
                                                'customers.status',
                                                'customers.admin_area',
                                                'customers.sale_area',
                                                'customers.customer_status',

                                            )
                                            ->havingRaw('last_purchase_date BETWEEN ? AND ?', [$from_6, $from_5])
                                            ->whereNotIn('customers.customer_id', $code_notin)
                                            ->orderBydesc('last_purchase_date')
                                            ->get();

            $data = $query_customer->toArray();
            // Clean up output buffer before writing anything to CSV file.
            // ob_end_clean();

            break;

            case 'normal';
            $date = date('Y-m-d');
            $filename = 'Purchase_normal_'. $date. '.csv';

            // ob_start();
 
            // Set PHP headers for CSV output.
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename= '.$filename);
            
            $query_customer = Customer::select(
                                                'customers.customer_id',
                                                'customers.customer_name',
                                                'customers.status',
                                                'customers.admin_area',
                                                'customers.sale_area',
                                                'customers.customer_status',
                                                DB::raw('MAX(report_sellers.date_purchase) as last_purchase_date'),
                                                DB::raw('"สั่งตามปกติ" as status_pur')


                                            )
                                            ->join('report_sellers', 'customers.customer_id', '=', 'report_sellers.customer_id')
                                            ->groupBy(
                                                'customers.customer_id',
                                                'customers.customer_name',
                                                'customers.status',
                                                'customers.admin_area',
                                                'customers.sale_area',
                                                'customers.customer_status',

                                            )
                                            ->havingRaw('last_purchase_date BETWEEN ? AND ?', [$from_4, $from_3])
                                            ->whereNotIn('customers.customer_id', $code_notin)
                                            ->orderBydesc('last_purchase_date')
                                            ->get();

            $data = $query_customer->toArray();
            // Clean up output buffer before writing anything to CSV file.
            // ob_end_clean();

            break;

            case 'no-purchase';
            $date = date('Y-m-d');
            $filename = 'Purchase_no-purchase_'. $date. '.csv';

            // ob_start();
 
            // Set PHP headers for CSV output.
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename= '.$filename);
            
            $query_customer = Customer::select(
                                                'customers.customer_id',
                                                'customers.customer_name',
                                                'customers.status',
                                                'customers.admin_area',
                                                'customers.sale_area',
                                                'customers.email',
                                                'customers.customer_status',
                                                'customers.created_at',
                                                DB::raw('COUNT(report_sellers.purchase_order) as count_po'),
                                                DB::raw('"ไม่สั่ง" as status_pur')
                                            )
                                            ->leftjoin('report_sellers', 'customers.customer_id', '=', 'report_sellers.customer_id')
                                            ->groupBy(
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
                                            ->whereNotIn('customers.customer_id', $code_notin)
                                            ->orderBydesc('customers.customer_id')
                                            ->get();

            $data = $query_customer->toArray();
            // Clean up output buffer before writing anything to CSV file.
            // ob_end_clean();

            break;

            default:
                 // return back()->with('error_export', 'เกิดข้อผิดพลาด');
                 return abort('403', 'ERROR EXPORT');

            
        }
           // Create a file pointer with PHP.
           $output = fopen( 'php://output', 'w' );

            // ใส่ Header Column
            fputcsv($output, [
                'Customer ID',
                'Customer Name',
                'Status',
                'Admin Area',
                'Sale Area',
                'Customer Status',
                'Last Purchase Date',
                'Status Purchase'
            ], '|');
 
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
