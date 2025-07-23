<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ReportSeller;
use App\Models\Setting;
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
        $setting = Setting::where('setting_id', 'WS01')->first();

        if (!$setting) {
            $this->warn('ไม่พบการตั้งค่าการลบ (del_reportseller = 1) ในตาราง settings');
            return;
        }

        $status_del = $setting?->del_reportseller;
        
        if($status_del === '1') {

            $threeMonthsAgo = Carbon::now()->subMonths(3);

            // ลบข้อมูลที่เก่ากว่า 3 เดือน
            $deleted = ReportSeller::where('date_purchase', '<=', $threeMonthsAgo)->delete();
    
            $this->info("ลบข้อมูล Order เก่ากว่า 3 เดือนจำนวน: {$deleted} รายการ");
    
            $message = "ลบข้อมูล Order เก่ากว่า 3 เดือนจำนวน: {$deleted} รายการ";
    
             // แสดงใน console
             $this->info($message);
    
             // บันทึกลง laravel.log
             Log::info($message);

        } else {
            
            $this->info('ปิดการลบอัตโนมัติชั่วคราว');
        }
       
    }
}

