<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }

    public function import(Request $request)
    {
        
        //notin code;
        $code_notin = ['0000', '4494', '7787', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];

         //menu alert;
         $status_waiting        = DB::table('customers')->where('status', 'รอดำเนินการ')
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();

        $status_updated         = DB::table('customers')->where('status_update', 'updated')
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();

        $status_registration    = DB::table('customers')->where('status', 'ลงทะเบียนใหม่')
                                    // ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->whereNotIn('customer_id', $code_notin)
                                    ->count();

        $status_alert = $status_waiting + $status_updated;


        $user_id_admin = $request->user()->user_id;

        return view('/report/importcategory', compact('status_alert', 'status_waiting', 'status_updated', 'status_registration', 'user_id_admin'));

    }
    public function importFile(Request $request)
    {

        date_default_timezone_set("Asia/Bangkok");

        if($request->has('submit_csv') == true) 
        {
            // dd('test');
            
                $path = $request->file('import_csv');
                if($path == null) {
                    $path == '';
    
                } else {

                    $rename = 'Category_all'.'_'.date("l jS \of F Y h:i:s A").'.csv';
                    $directory = $request->file('import_csv')->storeAs('importcsv',$rename,'importfiles'); //importfiles filesystem.php->disk;
                    $fileStream = fopen(storage_path('app/public/importcsv/'.$rename),'r');
                    // fgetcsv($fileStream); // skip header
                    
                    while (($row = fgetcsv($fileStream , 1000 , "|")) !== false) 
                    {
                        // ตรวจสอบว่ามีข้อมูลครบทั้งคอลัมน์ 0 และ 1
                        if (isset($row[0], $row[1]) && !empty($row[0])) {
                            Category::create([
                                'categories_id' => $row[0],
                                'categories_name' => $row[1],
                            ]);
                        }
                    }


                            fclose($fileStream);

                }

        }
        $count = Category::all()->count();
        
        return redirect('/webpanel/report/product/importcategory')->with('success_import', 'นำเข้าข้อมูลสำเร็จ :'.' '.$count);
    }
}
