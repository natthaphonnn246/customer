<?php

namespace App\Imports;

use App\Models\ReportSeller;
use App\Models\ImportStatus;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Concerns\WithEvents;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;


class SalesImport implements  WithChunkReading, ShouldQueue, WithEvents, ToCollection, WithHeadingRow, WithCustomCsvSettings
{

    public int $rowCount = 0;
    protected int $importStatus;

    public function __construct(int $importStatus)
    {
        $this->importStatus = $importStatus;
        HeadingRowFormatter::default('none');
    }

    // public function model(array $row)
    public function collection(Collection $rows)
    {

        foreach ($rows as $row) {

        // if (!empty($row[0])) {
        if (!empty($row['PO'])) {

            DB::statement("UPDATE import_statuses SET success_count = success_count + 1 WHERE id = ?", [$this->importStatus]);

            // if (isset($row[8]) && $row[8] === 'โค้ด') {
            if (isset($row['หน่วยสินค้า']) && $row['หน่วยสินค้า'] === 'โค้ด') {
                $price = 0;
                $cost  = 0;
            } else {
                // $price = $row[5];
                // $cost  = empty($row[6]) ? 0 : $row[6];
                $price = $row['ราคา'];
                $cost  = empty($row['ต้นทุน']) ? 0 : $row['ต้นทุน'];
            }

            // if (preg_match('/\bดีลพิเศษ\b/u', $row[4])) {
            if (preg_match('/\bดีลพิเศษ\b/u', $row['ชื่อสินค้า'])) {
                $qty = 1;
            } else {
                // $qty = $row[7];
                $qty = $row['จำนวน'];
                
            }

            // $this->rowCount++;

         /*    return new ReportSeller([

                'purchase_order'      => $row[0],
                'report_sellers_id'   => $row[1],
                'customer_id'         => $row[1],
                'customer_name'       => $row[2],
                'product_id'          => $row[3],
                'product_name'        => $row[4],
                'price'               => $price,
                'cost'                => $cost,
                'quantity'            => $qty,
                'unit'                => $row[8],
                'date_purchase'       => $row[9],

            ]); */

            ReportSeller::create([

                'purchase_order'      => $row['PO'],
                'report_sellers_id'   => $row['รหัสลูกค้า'],
                'customer_id'         => $row['รหัสลูกค้า'],
                'customer_name'       => $row['ชื่อร้านค้า'],
                'product_id'          => $row['รหัสสินค้า'],
                'product_name'        => $row['ชื่อสินค้า'],
                'price'               => $price,
                'cost'                => $cost,
                'quantity'            => $qty,
                'unit'                => $row['หน่วยสินค้า'],
                'date_purchase'       => $row['วันที่ทำรายการ'],

            ]);
        }
    }
        
    return null; // ถ้าไม่มี PO → return null ป้องกัน error

    }

    public function getCsvSettings(): array
    {
        return [
            'delimiter'        => '|',   // <== สำคัญมาก!!
            'enclosure'        => '"',
            'escape_character' => '\\',
            'input_encoding'   => 'UTF-8',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterImport::class => function () {
                ImportStatus::where('id', $this->importStatus)->update([
                    'status' => 'completed',
                ]);
            },
        ];
    }
    

    public function chunkSize(): int
    {
        return 5000;
    }

    public function batchSize(): int
    {
        return 1000;
    }

}
