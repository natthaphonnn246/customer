<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use Carbon\Carbon;

class CustomerExcelExport 
{
    /**
   
    */
  /*   public function collection()
    {
        return Customer::select('customer_code', 'customer_name', 'province', 'geography', 'admin_area', 'sale_area', 'status', 'customer_status', 'status_user', 'delivery_by')
                        ->whereNotIn('customer_code', ['0000','4494'])
                        ->get();
    }
    public function headings(): array
    {
        return [

            'CUSTOMER_CODE',
            'CUSTOMER_NAME',
            'PROVINCE',
            'GEOGRAPHY',
            'ADMIN_AREA',
            'SALE_AREA',
            'STATUS',
            'CUSTOMER_STATUS',
            'STATUS_USER',
            "DELIVERY_BY"
        ];
    } */
    use Exportable;
    public function exportCustomerExcel($status)
    {
        // dd($status);

        //notin code;
        $code_notin = ['0000', '4494', '7787', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];

        //type;
        switch ($status) 
            {
                //get excel;
                // case $status == 'getexcel_customerall': ผิด
                case 'getexcel_customerall':
                    $date = date('d-m-Y');
                    return Customer::select('customer_code', 'customer_name', 'type', 'province', 'geography', 'admin_area', 'sale_area','status', 'delivery_by')
                                    // ->whereNotIn('customer_code', ['0000','4494'])
                                    ->whereNotIn('customer_code', $code_notin)
                                    ->downloadExcel('Customer_all'.'_'.$date.'.'.'xlsx',\Maatwebsite\Excel\Excel::XLSX, true);
                    break;

                case 'getexcel_completed':
                    $date = date('d-m-Y');
                    return Customer::select('customer_code', 'customer_name', 'type', 'province', 'geography', 'admin_area', 'sale_area','status', 'delivery_by')
                                    // ->whereNotIn('customer_code', ['0000','4494'])
                                    ->whereNotIn('customer_code', $code_notin)
                                    ->where('status', 'ดำเนินการแล้ว')
                                    ->downloadExcel('Customer_completed'.'_'.$date.'.'.'xlsx',\Maatwebsite\Excel\Excel::XLSX, true);
                    break;

                case 'getexcel_action':
                    $date = date('d-m-Y');
                    return Customer::select('customer_code', 'customer_name', 'type', 'province', 'geography', 'admin_area', 'sale_area','status', 'delivery_by')
                                    // ->whereNotIn('customer_code', ['0000','4494'])
                                    ->whereNotIn('customer_code', $code_notin)
                                    ->where('status', 'ต้องดำเนินการ')
                                    ->downloadExcel('Customer_action'.'_'.$date.'.'.'xlsx',\Maatwebsite\Excel\Excel::XLSX, true);
                    break;

                case 'getexcel_waiting':
                    $date = date('d-m-Y');
                    return Customer::select('customer_code', 'customer_name', 'type', 'province', 'geography', 'admin_area', 'sale_area','status', 'delivery_by')
                                    // ->whereNotIn('customer_code', ['0000','4494'])
                                    ->whereNotIn('customer_code', $code_notin)
                                    ->where('status', 'รอดำเนินการ')
                                    ->downloadExcel('Customer_waiting'.'_'.$date.'.'.'xlsx',\Maatwebsite\Excel\Excel::XLSX, true);
                    break;

                case 'getexcel_update':
                    $date = date('d-m-Y');
                    return Customer::select('customer_code', 'customer_name', 'type', 'province', 'geography', 'admin_area', 'sale_area','status', 'delivery_by')
                                    // ->whereNotIn('customer_code', ['0000','4494'])
                                    ->whereNotIn('customer_code', $code_notin)
                                    ->where('status_update', 'updated')
                                    ->downloadExcel('Customer_update'.'_'.$date.'.'.'xlsx',\Maatwebsite\Excel\Excel::XLSX, true);
                    break;

                case 'getexcel_inactive':
                    $date = date('d-m-Y');
                    return Customer::select('customer_code', 'customer_name', 'type', 'province', 'geography', 'admin_area', 'sale_area','status', 'delivery_by')
                                    // ->whereNotIn('customer_code', ['0000','4494'])
                                    ->whereNotIn('customer_code', $code_notin)
                                    ->where('customer_status', 'inactive')
                                    ->downloadExcel('Customer_inactive'.'_'.$date.'.'.'xlsx',\Maatwebsite\Excel\Excel::XLSX, true);
                    break;

                case 'getexcel_following':
                    $date = date('d-m-Y');
                    return Customer::select('customer_code', 'customer_name', 'type', 'province', 'geography', 'admin_area', 'sale_area','status','status_user', 'delivery_by')
                                    // ->whereNotIn('customer_code', ['0000','4494'])
                                    ->whereNotIn('customer_code', $code_notin)
                                    ->where('status_user', 'กำลังติดตาม')
                                    ->downloadExcel('Customer_following'.'_'.$date.'.'.'xlsx',\Maatwebsite\Excel\Excel::XLSX, true);
                    break;
                    

                default:
                    return abort('403', 'ERROR EXPORT');
            }
            
    }

    public function PurchaseCustomerExcel ($status_pur)
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
            
            return Customer::select(
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
                                ->downloadExcel('Purchase_more'.'_'.$date.'.'.'xlsx',\Maatwebsite\Excel\Excel::XLSX, true);

            break;

            case 'coming';
            $date = date('Y-m-d');

            return Customer::select(
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
                                ->downloadExcel('Purchase_coming'.'_'.$date.'.'.'xlsx',\Maatwebsite\Excel\Excel::XLSX, true);


            break;

            case 'normal';
            $date = date('Y-m-d');

            return Customer::select(
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
                                ->downloadExcel('Purchase_normal'.'_'.$date.'.'.'xlsx',\Maatwebsite\Excel\Excel::XLSX, true);

            break;

            case 'no-purchase';
            $date = date('Y-m-d');

            return Customer::select(
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
                                ->downloadExcel('Purchase_no-purchase'.'_'.$date.'.'.'xlsx',\Maatwebsite\Excel\Excel::XLSX, true);

            break;

            default:
                 // return back()->with('error_export', 'เกิดข้อผิดพลาด');
                 return abort('403', 'ERROR EXPORT');

            
        }
        
    }

}
