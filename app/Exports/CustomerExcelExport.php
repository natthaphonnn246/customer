<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Customer;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;

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

     switch ($status) 
        {
            //get excel;
            case $status == 'getexcel_customerall':
                $date = date('d-m-Y');
                return Customer::select('customer_code', 'customer_name', 'province', 'geography', 'admin_area', 'sale_area','status', 'delivery_by')
                                ->whereNotIn('customer_code', ['0000','4494'])
                                ->downloadExcel('Customer_all'.'_'.$date.'.'.'xlsx',\Maatwebsite\Excel\Excel::XLSX, true);
                break;

            case $status == 'getexcel_completed':
                $date = date('d-m-Y');
                return Customer::select('customer_code', 'customer_name', 'province', 'geography', 'admin_area', 'sale_area','status', 'delivery_by')
                                ->whereNotIn('customer_code', ['0000','4494'])
                                ->where('status', 'ดำเนินการแล้ว')
                                ->downloadExcel('Customer_completed'.'_'.$date.'.'.'xlsx',\Maatwebsite\Excel\Excel::XLSX, true);
                break;

            case $status == 'getexcel_action':
                $date = date('d-m-Y');
                return Customer::select('customer_code', 'customer_name', 'province', 'geography', 'admin_area', 'sale_area','status', 'delivery_by')
                                ->whereNotIn('customer_code', ['0000','4494'])
                                ->where('status', 'ต้องดำเนินการ')
                                ->downloadExcel('Customer_action'.'_'.$date.'.'.'xlsx',\Maatwebsite\Excel\Excel::XLSX, true);
                break;

            case $status == 'getexcel_waiting':
                $date = date('d-m-Y');
                return Customer::select('customer_code', 'customer_name', 'province', 'geography', 'admin_area', 'sale_area','status', 'delivery_by')
                                ->whereNotIn('customer_code', ['0000','4494'])
                                ->where('status', 'รอดำเนินการ')
                                ->downloadExcel('Customer_waiting'.'_'.$date.'.'.'xlsx',\Maatwebsite\Excel\Excel::XLSX, true);
                break;

            case $status == 'getexcel_update':
                $date = date('d-m-Y');
                return Customer::select('customer_code', 'customer_name', 'province', 'geography', 'admin_area', 'sale_area','status', 'delivery_by')
                                ->whereNotIn('customer_code', ['0000','4494'])
                                ->where('status_update', 'updated')
                                ->downloadExcel('Customer_update'.'_'.$date.'.'.'xlsx',\Maatwebsite\Excel\Excel::XLSX, true);
                break;

            case $status == 'getexcel_inactive':
                $date = date('d-m-Y');
                return Customer::select('customer_code', 'customer_name', 'province', 'geography', 'admin_area', 'sale_area','status', 'delivery_by')
                                ->whereNotIn('customer_code', ['0000','4494'])
                                ->where('customer_status', 'inactive')
                                ->downloadExcel('Customer_inactive'.'_'.$date.'.'.'xlsx',\Maatwebsite\Excel\Excel::XLSX, true);
                break;

            case $status == 'getexcel_following':
                $date = date('d-m-Y');
                return Customer::select('customer_code', 'customer_name', 'province', 'geography', 'admin_area', 'sale_area','status','status_user', 'delivery_by')
                                ->whereNotIn('customer_code', ['0000','4494'])
                                ->where('status_user', 'กำลังติดตาม')
                                ->downloadExcel('Customer_following'.'_'.$date.'.'.'xlsx',\Maatwebsite\Excel\Excel::XLSX, true);
                break;
                

            default:
                return abort('403', 'ERROR EXPORT');
        }
        
   }

}
