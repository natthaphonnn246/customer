<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;

class OrderingService
{
    public function generate(): string
    {
        return DB::transaction(function () {

            $today = today();
            $dateFormat = now()->format('YmdHis');

            // lock row ของวันนี้
            $seq = DB::table('order_sequences')
                ->where('date', $today)
                ->lockForUpdate()
                ->first();

            if (!$seq) {
                // ยังไม่มี → เริ่มที่ 1
                DB::table('order_sequences')->insert([
                    'date' => $today,
                    'last_number' => 1,
                ]);
                $run = 1;
            } else {
                // มีแล้ว → +1
                $run = $seq->last_number + 1;

                DB::table('order_sequences')
                    ->where('date', $today)
                    ->update([
                        'last_number' => $run
                    ]);
            }

            return "PO{$dateFormat}" . str_pad($run, 3, '0', STR_PAD_LEFT);
        });
    }
}