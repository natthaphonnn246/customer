<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Customer;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;

class CustomerCsvExport
{
    use Exportable;
    public function exportCustomerCsv($status)
    {
         // dd($status);
 
        //notin code;
        $code_notin = ['0000', '4494', '7787', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];

         switch ($status)
         {
 
             case $status == 'getcsv_completed':
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
 
             case $status == 'getcsv_action':
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
 
             case $status == 'getcsv_waiting':
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
 
             case $status == 'getcsv_update':
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
 
             case $status == 'getcsv_inactive':
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
 
             case $status == 'getcsv_customerall':
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
 
 
             case $status == 'getcsv_following':
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
}
