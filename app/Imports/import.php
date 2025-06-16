<?php

namespace App\Imports;

use App\Models\ReportSeller;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class import implements WithHeadingRow, WithCustomCsvSettings, ToCollection
{
    /**
    */

    public function __construct()
    {
        // สำคัญมาก: ป้องกัน headingRowFormatter auto lowercase → เราจะได้ 'PO' ไม่ใช่ 'po'
        HeadingRowFormatter::default('none');
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            $rowData = $row->toArray();

            dd($rowData);
      /*   if (!empty($row[0])) { */
            ReportSeller::create([

                'purchase_order'      => $row['PO'],
                'report_sellers_id'   => $row['รหัสลูกค้า'],
                'customer_id'         => $row['รหัสลูกค้า'],
                'customer_name'       => $row['ชื่อร้านค้า'],
                'product_id'          => $row['รหัสสินค้า'],
                'product_name'        => $row['ชื่อสินค้า'],
                'price'               => $row['ราคา'],
                'cost'                => $row['ต้นทุน'],
                'quantity'            => $row['จำนวน'],
                'unit'                => $row['หน่วยสินค้า'],
                'date_purchase'       => $row['วันที่ทำรายการ'],
            ]);
     }
        return null;
        
    }

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => '|',   // <== สำคัญมาก!!
            'enclosure' => '"',
            'escape_character' => '\\',
            'input_encoding' => 'UTF-8',
        ];
    }
}
