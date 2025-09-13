<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use App\Models\ReportSeller;
use Illuminate\Support\Facades\DB;

class RebuildCheckPurchaseCache implements ShouldQueue
{
        use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

        public $timeout = 300; // วินาที กำหนดตามต้องการ

        public function handle()
        {
            $code_notin = ['0000','4494','7787','8118','9000','9001','9002','9003','9004','9005','9006','9007','9008','9009','9010','9011'];

            // Subquery: หาค่า date_purchase ล่าสุด
            $subQuery = ReportSeller::select('customer_id')
                            ->selectRaw('MAX(date_purchase) as max_date')
                            ->whereNotIn('customer_id', $code_notin)
                            ->groupBy('customer_id');

            $check_purchase = ReportSeller::from('report_sellers as rs')
                                ->joinSub($subQuery, 't', function ($join) {
                                    $join->on('rs.customer_id', '=', 't.customer_id')
                                        ->on('rs.date_purchase', '=', 't.max_date');
                                })
                                ->select('rs.customer_id', 'rs.date_purchase')
                                ->orderByDesc('rs.date_purchase')
                                ->get();

            // เก็บ cache
            // Cache::put('check_purchase', $check_purchase, now()->addHours(1)); // เก็บ 1 ชั่วโมง หรือปรับตามต้องการ
            Cache::put('check_purchase', $check_purchase, now()->addMinutes(30));

        }
}
