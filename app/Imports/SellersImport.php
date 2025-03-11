<?php

namespace App\Imports;

use App\Models\ReportSeller;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;

class SellersImport implements ToModel
{

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        
        return new ReportSeller ([
            
                'purchase_order' => $row[0],
                'report_sellers_id' => $row[1],
                'customer_id' => $row[1],
                'customer_name' => $row[2],
                'product_id' => $row[3],
                'product_name' => $row[4],
                'price' => $row[5],
                'quantity' => $row[6],
                'unit' => $row[7],
                'date_purchase' => $row[8],

        ]);

    }
    
}