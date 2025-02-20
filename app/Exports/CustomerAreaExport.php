<?php

namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class CustomerAreaExport 
{
    use Exportable;
    public function exportCustomerAreaExcel($status, $admin_id)
    {
        $date = date('d-m-Y');

        switch ($status)
        {
            case ($status == 'getexcel_customer'):
                return Customer::select('customer_code', 'customer_name', 'province', 'geography', 'admin_area', 'sale_area','status')
                                ->whereNotIn('customer_code', ['0000','4494'])
                                ->where('admin_area', $admin_id)
                                ->downloadExcel('Customer_all'.'_'.$date.'.'.'xlsx',\Maatwebsite\Excel\Excel::XLSX, true);
            break;

            case ($status == 'getexcel_waiting'):
                return Customer::select('customer_code', 'customer_name', 'province', 'geography', 'admin_area', 'sale_area','status')
                                ->whereNotIn('customer_code', ['0000','4494'])
                                ->where('admin_area', $admin_id)
                                ->where('status', 'รอดำเนินการ')
                                ->downloadExcel('Customer_waiting'.'_'.$date.'.'.'xlsx',\Maatwebsite\Excel\Excel::XLSX, true);
            break;

            case ($status == 'getexcel_action'):
                return Customer::select('customer_code', 'customer_name', 'province', 'geography', 'admin_area', 'sale_area','status')
                                ->whereNotIn('customer_code', ['0000','4494'])
                                ->where('admin_area', $admin_id)
                                ->where('status', 'ต้องดำเนินการ')
                                ->downloadExcel('Customer_action'.'_'.$date.'.'.'xlsx',\Maatwebsite\Excel\Excel::XLSX, true);
            break;

            case ($status == 'getexcel_completed'):
                return Customer::select('customer_code', 'customer_name', 'province', 'geography', 'admin_area', 'sale_area','status')
                                ->whereNotIn('customer_code', ['0000','4494'])
                                ->where('admin_area', $admin_id)
                                ->where('status', 'ดำเนินการแล้ว')
                                ->downloadExcel('Customer_completed'.'_'.$date.'.'.'xlsx',\Maatwebsite\Excel\Excel::XLSX, true);
            break;

            default:
                return abort('403', 'ERROR EXPORT');
        }
    }

    //export_csv customer_adminarea;
   public function exportCustomerAreaCsv($status, $admin_id)
   {
        // dd($admin_id);

        switch ($status && $admin_id) 
        {

            case $status == 'getcsv_customer' && $admin_id != '':
                $date = date('Y-m-d');
                $filename = 'Customer_completed_'. $date.'.csv';
                 // Start the output buffer.
                ob_start();

                // Set PHP headers for CSV output.
                header('Content-Type: text/csv; charset=utf-8');
                header('Content-Disposition: attachment; filename= '.$filename);

                $query = Customer::select('customer_code', 'customer_name', 'province', 'geography', 'admin_area', 'sale_area', 'status')
                                    ->whereNotIn('customer_code', ['0000','4494'])
                                    ->where('admin_area', $admin_id)
                                    ->get();

                $data = $query->toArray();
                // Clean up output buffer before writing anything to CSV file.
                ob_end_clean();
            break;

            case $status == 'getcsv_waiting' && $admin_id != '':
                $date = date('Y-m-d');
                $filename = 'Customer_waiting_'. $date. '.csv';
                 // Start the output buffer.
                ob_start();

                // Set PHP headers for CSV output.
                header('Content-Type: text/csv; charset=utf-8');
                header('Content-Disposition: attachment; filename= '.$filename);
                
                $query = Customer::select('customer_code', 'customer_name', 'province', 'geography', 'admin_area', 'sale_area', 'status')
                                    ->whereNotIn('customer_code', ['0000','4494'])
                                    ->where('admin_area', $admin_id)
                                    ->where('status', 'รอดำเนินการ')
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
                
                $query = Customer::select('customer_code', 'customer_name', 'province', 'geography', 'admin_area', 'sale_area', 'status')
                                    ->whereNotIn('customer_code', ['0000','4494'])
                                    ->where('admin_area', $admin_id)
                                    ->where('status', 'ต้องดำเนินการ')
                                    ->get();

                $data = $query->toArray();
                // Clean up output buffer before writing anything to CSV file.
                ob_end_clean();
            break;

            case $status == 'getcsv_completed':
                $date = date('Y-m-d');
                $filename = 'Customer_completed_'. $date. '.csv';
                 // Start the output buffer.
                ob_start();

                // Set PHP headers for CSV output.
                header('Content-Type: text/csv; charset=utf-8');
                header('Content-Disposition: attachment; filename= '.$filename);
                
                $query = Customer::select('customer_code', 'customer_name', 'province', 'geography', 'admin_area', 'sale_area', 'status')
                                    ->whereNotIn('customer_code', ['0000','4494'])
                                    ->where('admin_area', $admin_id)
                                    ->where('status', 'ดำเนินการแล้ว')
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
                                    ->whereNotIn('customer_code', ['0000','4494'])
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
                
                $query = Customer::select('customer_code', 'customer_name', 'province', 'geography', 'admin_area', 'sale_area', 'status', 'customer_status')
                                    ->whereNotIn('customer_code', ['0000','4494'])
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
                                    ->whereNotIn('customer_code', ['0000','4494'])
                                    ->where('status_user', "กำลังติดตาม")
                                    ->get();

                $data = $query->toArray();
                // Clean up output buffer before writing anything to CSV file.
                ob_end_clean();
            break;


            default:
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
