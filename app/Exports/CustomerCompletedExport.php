<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Customer;
use Illuminate\Http\Response;

class CustomerCompletedExport implements FromCollection, WithHeadings
// class CustomerCompletedExport
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {

        return Customer::select('customer_code', 'customer_name', 'province', 'geography', 'admin_area', 'sale_area')
                        ->whereNotIn('customer_code', ['0000','4494'])
                        ->where('status', 'ดำเนินการแล้ว')
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
        ];
    }
}
