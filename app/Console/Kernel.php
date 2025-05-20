<?php

namespace App\Console;

use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{

  /*   protected $commands = [
        \App\Console\Commands\ReportPreload::class,
    ]; */ //ลงทะเบียนไม่จำเป็น
    
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('report:preload')
            ->everyfiveMinutes() 
            ->appendOutputTo(storage_path('logs/preload.log'));

        $schedule->call(function () {
            file_put_contents(storage_path('logs/test-cron.txt'), now() . " => Cron ran\n", FILE_APPEND);
        })->everyfiveMinutes();
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
