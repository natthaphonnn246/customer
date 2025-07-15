<?php

namespace App\Console;

use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \App\Console\Commands\DeleteReportsellers::class,
        \App\Console\Commands\Mycommands::class
    ];
    

    protected function schedule(Schedule $schedule): void
    {
        //ลบก่อนเที่ยงคืน;
        $schedule->command('app:delete-reportsellers')->dailyAt('23:59');

        // $schedule->command('app:delete-reportsellers')->daily(); ลบตอนเวลา 00.00 น.
        // $schedule->command('app:delete-reportsellers')->everyMinute();
        // $schedule->command('app:mycommands')->everyMinute();

    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}



/* crontab -e
// * * * * * cd /Users/natthaphon/Herd/customer && php artisan schedule:run >> /dev/null 2>&1 */
