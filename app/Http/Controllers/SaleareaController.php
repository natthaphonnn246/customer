<?php

namespace App\Http\Controllers;

use App\Models\Salearea;
use App\Models\Customer;
use Illuminate\Http\Request;

class SaleareaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function viewCreate()
    {
         //menu alert;
         $status_waiting = Customer::where('status', '0')
                                    ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->count();

        $status_updated = Customer::where('status_update', 'updated')
                                    ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->count();

        $status_alert = $status_waiting + $status_updated;
        // dd($salearea);
        return view('/webpanel/sale-create', compact('status_alert', 'status_waiting', 'status_updated'));
    }

    public function index()
    {
        $salearea = Salearea::orderBy('sale_area', 'asc')->get();

         //menu alert;
         $status_waiting = Customer::where('status', '0')
                                    ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->count();

        $status_updated = Customer::where('status_update', 'updated')
                                    ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->count();

        $status_alert = $status_waiting + $status_updated;
        // dd($salearea);
        return view('/webpanel/sale', compact('salearea', 'status_alert', 'status_waiting', 'status_updated'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

        date_default_timezone_set("Asia/Bangkok");

        if($request->has('submit_form') == true) {

            $sale_area = $request->sale_area;
            $sale_name = $request->sale_name;
            $text_add = $request->text_add;
            if($request->text_add == null) {
                $text_add = '';
            }
            $admin_area = '';

            $check_submit = Salearea::select('salearea_id')->where('salearea_id', $sale_area)->first();

            // dd($check_submit);
            if($check_submit == null) {
               
                Salearea::create([
              
                    'salearea_id' => $sale_area,
                    'sale_area' => $sale_area,
                    'sale_name' => $sale_name,
                    'text_add' => $text_add,
                    'admin_area' => $admin_area,
                ]);
    
                    return redirect()->back()->with('success', 'เพิ่มข้อมูลสำเร็จ');

            } else {

                    return redirect()->back()->with('error', 'เกิดข้อผิดพลาด');

            }
        }

    }

    public function viewSale($id)
    {
        $salearea = Salearea::where('salearea_id', $id)->first();

                 //menu alert;
                 $status_waiting = Customer::where('status', '0')
                                            ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                            ->count();

                $status_updated = Customer::where('status_update', 'updated')
                                            ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                            ->count();

                $status_alert = $status_waiting + $status_updated;

        return view('/webpanel/sale-detail', compact('salearea', 'status_alert', 'status_waiting','status_updated'));
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
    public function show(Salearea $salearea)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Salearea $salearea, Request $request, $id)
    {
        date_default_timezone_set("Asia/Bangkok");

        if($request->has('submit_update') == true) {


                $sale_area = $request->sale_area;
                $sale_name = $request->sale_name;
                $text_add = $request->text_add;
                if($request->text_add == null) {
                    $text_add = '';
                }

                $admin_area = $request->admin_area;
                if($request->admin_area == null) {
                    $text_add = '';
                }

                $salearea->where('salearea_id', $id)->update([

                            'salearea_id' => $sale_area,
                            'sale_area' => $sale_area,
                            'sale_name' => $sale_name,
                            'text_add' => $text_add,
                            // 'admin_area' => $admin_area,
                        ]);

           
                return redirect('/webpanel/sale/'.$id)->with('success', 'อัปเดตข้อมูลสำเร็จ');
        }
        
    }

    public function importsale()
    {
         //menu alert;
         $status_waiting = Customer::where('status', '0')
                                    ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->count();

        $status_updated = Customer::where('status_update', 'updated')
                                    ->whereNotIn('customer_id', ['0000', '4494', '7787', '9000'])
                                    ->count();

        $status_alert = $status_waiting + $status_updated;

        return view('/webpanel/importsale', compact('status_alert', 'status_waiting', 'status_updated'));
    }

    public function importFile(Request $request)
    {
        date_default_timezone_set("Asia/Bangkok");
        if($request->has('submit_csv') == true)
        {

            if($request->file('import_csv') == '') {
                return redirect()->back()->with('error_import', 'กรุณาเลือกไฟล์ CSV');
            }

            $rename = 'Sale_area'.'_'.date("l jS \of F Y h:i:s A").'.csv';
            $request->file('import_csv')->storeAs('importcsv',$rename,'importfiles'); //importfiles filesystem.php->disk;
            $fileStream = fopen(storage_path('app/public/importcsv/'.$rename),'r');

            while(!feof($fileStream)) {

                $row = fgetcsv($fileStream, 1000, "|");
                if($row[0] ??= '') {

                    Salearea::create([

                       'salearea_id' => $row[0],
                       'sale_area' => $row[0],
                       'sale_name' => 'ไม่ระบุ',
                       'text_add' => '',
                       'admin_area' => '',

                    ]);
                }
            }
            fclose($fileStream);
           
        }
        $count = Salearea::count();
        // dd($count);
        return redirect('/webpanel/sale/importsale')->with('success_import', 'นำเข้าข้อมูลสำเร็จ :'.' '.$count);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Salearea $salearea)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Salearea $salearea)
    {
        //
    }
}
