<?php

namespace App\Http\Controllers;

use App\Jobs\ImportSalesJob;
use App\Models\ImportStatus;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

use App\Imports\import;
use Maatwebsite\Excel\Facades\Excel;

class ImportCsvController extends Controller
{

    public function importCsv(Request $request)
    {
        
        $request->validate([
            'import_csv' => 'required|mimes:csv,txt,xlsx,xls',
        ]);

        $importStatus = ImportStatus::create([
            'status' => 'processing',
            'success_count' => 0,
        ]);

        // $path = $request->file('file')->store('imports');
        $rename = 'Seller_all_' . now()->format('Ymd_His') . '.csv';
        $path = $request->file('import_csv')->storeAs('', $rename, 'importseller');
        $filePath = Storage::disk('importseller')->path($path);

        // $importStatus = ImportStatus::latest()->first();

        // ส่งเข้า queue
        ImportSalesJob::dispatch($filePath, $importStatus);

        return back();
    }

  /*   public function import (Request $request) 
    {

        $request->validate([
            'import_csv' => 'required|mimes:csv,txt,xlsx,xls',
        ]);

        // $path = $request->file('file')->store('imports');
        $rename = 'Seller_all_' . now()->format('Ymd_His') . '.csv';
        $path = $request->file('import_csv')->storeAs('', $rename, 'importseller');
        $filePath = Storage::disk('importseller')->path($path);

        Excel::import(new import, $filePath);
    } */
}
