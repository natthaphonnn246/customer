<?php

namespace App\Jobs;

use App\Imports\SalesImport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ImportSalesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;
    protected $importStatus;
    
    public function __construct($filePath, $importStatus)
    {
        $this->filePath = $filePath;
        $this->importStatus = $importStatus;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // ใช้ path เต็ม (จำเป็น)
        Excel::queueImport(
            new SalesImport($this->importStatus->id),
            $this->filePath
        );
    }
}
