<?php

namespace App\Http\Controllers;

use App\Models\Salearea;
use Illuminate\Http\Request;

class SaleareaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $salearea = Salearea::all();
        // dd($salearea);
        return view('/webpanel/sale', compact('salearea'));
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

            $check_submit = Salearea::select('salearea_id')->where('salearea_id', $sale_area)->first();

            // dd($check_submit);
            if($check_submit == null) {
               
                Salearea::create([
              
                    'salearea_id' => $sale_area,
                    'sale_area' => $sale_area,
                    'sale_name' => $sale_name,
                    'text_add' => $text_add,
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
        return view('/webpanel/sale-detail', compact('salearea'));
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

                $salearea->where('salearea_id', $id)->update([

                            'salearea_id' => $sale_area,
                            'sale_area' => $sale_area,
                            'sale_name' => $sale_name,
                            'text_add' => $text_add,
                        ]);

           
                return redirect('/webpanel/sale/'.$id)->with('success', 'อัปเดตข้อมูลสำเร็จ');
        }
        
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
