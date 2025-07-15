<?php 

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Imports\SalesImport;
use App\Models\Customer;
use App\Jobs\ProcessSalesImport;
use App\Models\ImportStatus;
use App\Models\ReportSeller;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Storage;


class ImportController extends Controller
{
    
    public function import(Request $request)
    {
        $request->validate([
            'import_csv' => 'required|mimes:csv,txt,xlsx,xls',
        ]);
    
        // สร้าง ImportStatus record
        $importStatus = ImportStatus::create([
            'status' => 'processing',
            'success_count' => 0,
        ]);
    
        $rename = 'Seller_all_' . now()->format('Ymd_His') . '.csv';
        $path = $request->file('import_csv')->storeAs('', $rename, 'importseller');
        $filePath = Storage::disk('importseller')->path($path);
    
        // ใช้ queue import พร้อมส่ง ID เข้าไป
        // Excel::queueImport(new SalesImport($importStatus->id), $filePath);
        Bus::chain([
            fn () => Excel::queueImport(new SalesImport($importStatus->id), $filePath),
        ])->dispatch();
    
        return back()->with('import', 'เริ่มนำเข้าข้อมูลแล้ว');
        // return response()->json(['id' => $importStatus->id]);
    }
     
    public function partial()
    {
        $imports = ImportStatus::latest()->take(10)->get();
        $user_id_admin = '1';

        // คืนเฉพาะ tr เท่านั้น
        return view('report/import-rows', compact('imports', 'user_id_admin'));
    }

    // ImportController.php
    public function checkStatus(Request $request, $id)
    {
        $status = ImportStatus::where('id', $id)->first();
        $user_id_admin = '1';
        $importStatus = ImportStatus::latest()->first();
    
        return view('/report/checked-status',compact('status', 'importStatus'));
    
    }

    
    

}



