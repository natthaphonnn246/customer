@extends ('layouts.webpanel')
@section('content')

    <div class="contentArea w-full max-w-full break-words">

        <div class="py-2"></div>
        <h5 class="!text-gray-600 font-semibold mx-4"><a href="/webpanel/report/product" class="!no-underline">ย้อนกลับ</a> | ขายตามหมวดหมู่</h5>
        <hr class="my-3 !text-gray-400 !border">

            {{-- <hr class="my-4" style="color: #8E8E8E; width: 100%;"> --}}
            <!--- search --->
    
            <div class="mx-8">
                    {{-- <form method="get" action="/webpanel/report/product/search"> --}}
                    <form method="get" action="/webpanel/report/product/sales/category">
                        @csrf
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-3 items-end">
                                <div>
                                    <label class="py-2" for="from">วันที่เริ่ม : </label>
                                    <input type="text" class="block w-full" id="from" style="border:solid 1px rgb(208, 208, 208); padding: 10px; border-radius:7px; width:100%; color:#9d9d9d; font-size:14px;" name="from" value="{{(isset($_GET['from'])) == '' ? date('Y-m-d') : $_GET['from'] ;}}">
                                </div>
                                <div>
                                    <label class="py-2" for="to">ถึงวันที่ : </label>
                                    <input type="text" class="block w-full" id="to" style="border:solid 1px rgb(208, 208, 208); padding:10px; border-radius:7px; width:100%; color:#9d9d9d; font-size:14px;" name="to" value="{{(isset($_GET['to'])) == '' ? date('Y-m-d') : $_GET['to'] ;}}">
                                </div>
                                
                                <div>
                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white !rounded-md px-3 py-2">ค้นหา</button>
                                </div>
                            </div>
                    </form>
                </div>

         

            <div class="mx-8 mt-4">

                <span class="ms-2" style="font-size:18px; color:#202020;">หมวดหมู่ :</span>
                <hr class="my-3" style="color: #8E8E8E; width: 100%;">
                <table class="table table-striped">
                    <thead>
                        
                    <tr>
                        <td scope="col" style="color:#838383; text-align: center; font-weight: 500; width:5px;">#</td>
                        <td scope="col" style="color:#838383; text-align: left; font-weight: 500;">หมวดหมู่</td>
                        <td scope="col" style="color:#838383; text-align: left; font-weight: 500;">ชื่อหมวดหมู่</td>
                        <td scope="col" style="color:#838383; text-align: right; font-weight: 500;">ยอดขาย (บาท)</td>
                        <td scope="col" style="color:#838383; text-align: right; font-weight: 500;">ยอดขาย (%)</td>
                        <td scope="col" style="color:#838383; text-align: right; font-weight: 500;">กำไร (%)</td>
                    </tr>
                    </thead>
                    <tbody>

                @if(!empty($sales_category))

                        @php 
                            $start = ($start ?? 0) + 1;
                            $total_percent = 0;
                            $total_margin = 0;
                        @endphp

                        @foreach ($sales_category as $row)
                    <tr>
                            <?php
                                
                                // $id = $row->id;
                                // $user_name = $row->customer_name;
                                $category_code = $row->categories_id;
                                $category_name = $row->categories_name;
                                $sales = $row->total_sales;
                                $total_sales_cost = $row->total_sales_cost;
                                $average_cost = $row->average_cost;
                                $average_price = $row->average_price;
                                $percent_sales = ($sales/$total_sales)*100;
                                $total_percent += $percent_sales;

                                if($total_sales_cost > 0) {
                                    // $margin = (($sales - $total_sales_cost)/$total_sales_cost ) * 100;
                                    $margin = (($average_price - $average_cost)/$average_cost) * 100;

                                } else {
                                    $margin = 0;
                                }
                        
                                $total_margin += $margin;
                                
                            ?>
                        
    
                        <td scope="row" style="color:#9C9C9C; text-align: center; padding: 20px 8px 20px; width:10%;">{{$start++}}</td>
                        <td scope="row" style="color:#9C9C9C; text-align: left; padding: 20px 8px 20px; width:10%;">{{$category_code}}</td>
                        <td scope="row" style="color:#9C9C9C; text-align: left; padding: 20px 8px 20px;">{{$category_name ??= 'ไม่พบข้อมูล'}}</td>
                        <td scope="row" style="color:#9C9C9C; text-align: right; padding: 20px 8px 20px;">{{ number_format($sales,2) }}</td>
                        <td scope="row" style="color:#9C9C9C; text-align: right; padding: 20px 8px 20px;">{{ number_format($percent_sales,2) }}</td>
                        <td scope="row" style="color:#9C9C9C; text-align: right; padding: 20px 8px 20px;">{{ number_format($margin,2) }}</td>
            
                        </tr>

                    @endforeach

                        <tr>
                            <td colspan="1" style="background-color:rgb(225, 225, 225); color:#161616; text-align: center; font-weight:400; padding: 20px 8px 20px;"></td>
                            <td colspan="2" style="background-color:rgb(225, 225, 225); color:#161616; text-align: center; font-weight:400; padding: 20px 8px 20px;"></td>
                            <td colspan="1" style="background-color:rgb(225, 225, 225); color:#161616; text-align: right; font-weight:400; padding: 20px 8px 20px;">{{ number_format($total_sales,2) }}</td>
                            <td colspan="1" style="background-color:rgb(225, 225, 225); color:#161616; text-align: right; font-weight:400; padding: 20px 8px 20px;">{{ number_format($total_percent,2) }}</td>
                            <td colspan="2" style="background-color:rgb(225, 225, 225); color:#161616; text-align: right; font-weight:400; padding: 20px 8px 20px;">{{ number_format($total_margin/21, 2) }}</td>

                        </tr>
                    @endif

                    </tbody>

                </table>
            </div>
    
       
            <hr class="my-3" style="color: #8E8E8E; width: 100%;">

    </div>

    <script>
        $( function() {
            var dateFormat = 'dd/mm/yy',
                from = $( "#from" )
                .datepicker({
                    defaultDate: "+1w",
                    changeMonth: true,
                    numberOfMonths: 1,
                    dateFormat: 'yy-mm-dd',
                })
                .on( "change", function() {
                    to.datepicker( "option", "minDate", getDate( this ) );
                }),
                to = $( "#to" ).datepicker({
                defaultDate: "+1w",
                changeMonth: true,
                dateFormat: 'yy-mm-dd',
                numberOfMonths: 1 //จำนวนปฎิืิทิน;
                })
                .on( "change", function() {
                from.datepicker( "option", "maxDate", getDate( this ) );
                });
        
            function getDate( element ) {
                var date;
                try {
                date = $.datepicker.parseDate( dateFormat, element.value );
                } catch( error ) {
                date = null;
                }
        
                return date;
            }
        });
    </script>
@endsection