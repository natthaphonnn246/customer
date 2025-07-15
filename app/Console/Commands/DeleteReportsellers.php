<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ReportSeller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;


class DeleteReportsellers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-reportsellers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ลบข้อมูล ReportSeller ที่เก่ากว่า 3 เดือน';


    /**
     * Execute the console command.
     */

    public function handle()
    {
        $threeMonthsAgo = Carbon::now()->subMonths(3);

        // ลบข้อมูลที่เก่ากว่า 3 เดือน
        $deleted = ReportSeller::where('date_purchase', '<=', $threeMonthsAgo)->delete();

        $this->info("ลบข้อมูล Order เก่ากว่า 3 เดือนจำนวน: {$deleted} รายการ");

        $message = "ลบข้อมูล Order เก่ากว่า 3 เดือนจำนวน: {$deleted} รายการ";

         // แสดงใน console
         $this->info($message);

         // บันทึกลง laravel.log
         Log::info($message);
    }
}

