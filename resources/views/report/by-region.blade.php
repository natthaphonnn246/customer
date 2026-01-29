@extends ('layouts.webpanel')
@section('content')
    
    <div class="contentArea w-full max-w-full break-words">

        <div class="py-2"></div>
        <h5 class="!text-gray-600 font-semibold mx-4"><a href="/webpanel/report/product" class="!no-underline">ย้อนกลับ</a> | ขายตามภูมิศาสตร์</h5>
        <hr class="my-3 !text-gray-400 !border">

        {{-- <hr class="my-4" style="color: #8E8E8E; width: 100%;"> --}}
        <!--- search --->
  
        <div class="mx-8">
                {{-- <form method="get" action="/webpanel/report/product/search"> --}}
                <form method="get" action="/webpanel/report/product/sales/region">
                    @csrf
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-3 items-end">
                            <div>
                                <label class="py-2" for="from">วันที่เริ่ม : </label>
                                <input type="text" class="block w-full" id="from" style="border:solid 1px rgb(208, 208, 208); padding: 10px; border-radius:7px; width:100%; color:#9d9d9d; font-size:14px;" name="from" value="{{ request('from') == '' ? date('Y-m-d') : request('from') }}">
                            </div>
                            <div>
                                <label class="py-2" for="to">ถึงวันที่ : </label>
                                <input type="text" class="block w-full" id="to" style="border:solid 1px rgb(208, 208, 208); padding:10px; border-radius:7px; width:100%; color:#9d9d9d; font-size:14px;" name="to" value="{{ request('to') == '' ? date('Y-m-d') : request('to') }}">
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary" style="width:80px; font-size:15px; font-weight:500; padding:8px;">ค้นหา</button>
                            </div>
                        </div>
                </form>
        </div>

        @php
             $grouped = $sales->groupBy(function ($item) {
                return $item->categories_name . '|' . $item->categories_id;
            });
            $regions = ['ภาคเหนือ', 'ภาคกลาง','ภาคตะวันออก', 'ภาคตะวันตก', 'ภาคอีสาน', 'ภาคใต้']; // เพิ่มภาคตามจริง
        @endphp
            
            <div class="mx-8 mt-4">

                <span class="ms-2" style="font-size:18px; color:#202020;">ภูมิศาสตร์ :</span>
                <hr class="my-3" style="color: #8E8E8E; width: 100%;">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <td scope="col" style="color:#838383; text-align: left; font-weight: 500; width:5px;">#</td>
                            <td scope="col" style="color:#838383; text-align: left; font-weight: 500;">หมวดหมู่</td>
                            <td scope="col" style="color:#838383; text-align: left; font-weight: 500;">ชื่อหมวดหมู่</td>
                            @foreach ($regions as $region)
                            <td scope="col" style="color:#838383; text-align: right; font-weight: 500;"> {{ $region }}</td>
                            @endforeach
                            <td scope="col" style="color:#838383; text-align: right; font-weight: 500;"> รวม </td>
                        </tr>
                    </thead>
                    <tbody>
                        @php 
                        
                            // $start = ($start ?? 0) + 1; 
                            $start = 0;

                         /*    $category_col = $sales->groupBy(function ($item) {
                            return $item->categories_name . '|' . $item->categories_id;
                            }); */

                            $category_cols = $sales->unique('categories_id');
                            
                            $summary = 0;
                            
                        @endphp
            
                        @php 
                            $start = ($start ?? 0) + 1; 
                            $total = 0;
                            $count = 0;
                            $counts = 0;

                        @endphp
                            @foreach ($grouped as $category => $rows)

                        @php 
                            [$name, $id] = explode('|', $category);
                       /*      $region_totals = [];
                            $grand_total = 0; */

                        @endphp

     
                    @php
                        $row_north = $sales->where('geography', 'ภาคเหนือ')->where('categories_id', $id);
                        $row_central = $sales->where('geography', 'ภาคกลาง')->where('categories_id', $id);
                        $row_east = $sales->where('geography', 'ภาคตะวันออก')->where('categories_id', $id);
                        $row_west = $sales->where('geography', 'ภาคตะวันตก')->where('categories_id', $id);
                        $row_northeast = $sales->where('geography', 'ภาคตะวันออกเฉียงเหนือ')->where('categories_id', $id);
                        $row_south = $sales->where('geography', 'ภาคใต้')->where('categories_id', $id);
                    
                        $north = $row_north->first()?->total_sales ?? '0.00';
                        $central = $row_central->first()?->total_sales ?? '0.00';
                        $east = $row_east->first()?->total_sales ?? '0.00';
                        $west =  $row_west->first()?->total_sales ?? '0.00';
                        $northeast = $row_northeast->first()?->total_sales ?? '0.00';
                        $south = $row_south->first()?->total_sales ?? '0.00';

                        $sum_north = ($sum_north ?? 0) + $north;
                        $sum_central = ($sum_central ?? 0) + $central;
                        $sum_east = ($sum_east ?? 0) + $east;
                        $sum_west = ($sum_west ?? 0) + $west;
                        $sum_northeast = ($sum_northeast ?? 0) + $northeast;
                        $sum_south = ($sum_south ?? 0) + $south;
                       /*  $sum_central    += $central;
                        $sum_east       += $east;
                        $sum_west       += $west;
                        $sum_northeast  += $northeast;
                        $sum_south      += $south; */

                        $regions = ['ภาคเหนือ', 'ภาคกลาง', 'ภาคตะวันออก', 'ภาคตะวันตก', 'ภาคตะวันออกเฉียงเหนือ', 'ภาคใต้'];

                        $total_by_region = [];

                        foreach ($regions as $region) {
                            $total_by_region[] = $sales
                                                ->where('geography', $region)
                                                ->where('categories_id', $id)
                                                ->first()?->total_sales ?? 0;
                        }

                        // รวมทั้งหมด
                        $count = array_sum($total_by_region);

                        // dd($count);

                    @endphp

                        
                            <tr>
                                <td scope="row" style="color:#9C9C9C; text-align: left; padding: 20px 8px 20px; width:5%;">{{ $start++ }}</td>
                                <td scope="row" style="color:#9C9C9C; text-align: left; padding: 20px 8px 20px; width:10%;">{{ $id }}</td>
                                <td scope="row" style="color:#9C9C9C; text-align: left; padding: 20px 8px 20px; width:30%;">{{ $name }}</td>
                                @foreach ($regions as $region)
                                    @php
                                        $match = $rows->firstWhere('geography', $region);
                                        $amount = $match ? $match->total_sales : 0;
                                        $total += $amount;
     
                                    @endphp

                                    <td scope="row" style="color:#9C9C9C; text-align: right; padding: 20px 8px 20px; width:10%;"><a href="/webpanel/report/product/sales/region/view?category={{ $id }}&region={{ $region }}&from={{ request('from') }}&to={{ request('to') }}">{{ number_format($amount,2) }}</a></td>

                                @endforeach
                                    <td scope="row" style="color:#9C9C9C; text-align: right; padding: 20px 8px 20px; width:10%;">{{ number_format($count,2) }}</td>
                            </tr>
                        @endforeach

                        <tr>
                           
                            <td colspan="3" style="background-color:rgb(227, 227, 227); color:#7d7d7d; text-align: center; font-weight:500; padding: 20px 8px 20px; width:200px;">ยอดรวม (บาท)</td>
                            <td colspan="1" style="background-color:rgb(227, 227, 227); color:#7d7d7d; text-align: right; font-weight:500; padding: 20px 8px 20px; width:200px;">{{ number_format($sum_north ?? 0,2) }}</td>
                            <td colspan="1" style="background-color:rgb(227, 227, 227); color:#7d7d7d; text-align: right; font-weight:500; padding: 20px 8px 20px; width:200px;">{{ number_format($sum_central ?? 0,2) }}</td>
                            <td colspan="1" style="background-color:rgb(227, 227, 227); color:#7d7d7d; text-align: right; font-weight:500; padding: 20px 8px 20px; width:200px;">{{ number_format($sum_east ?? 0,2) }}</td>
                            <td colspan="1" style="background-color:rgb(227, 227, 227); color:#7d7d7d; text-align: right; font-weight:500; padding: 20px 8px 20px; width:200px;">{{ number_format($sum_west ?? 0,2) }}</td>
                            <td colspan="1" style="background-color:rgb(227, 227, 227); color:#7d7d7d; text-align: right; font-weight:500; padding: 20px 8px 20px; width:200px;">{{ number_format($sum_northeast ?? 0,2) }}</td>
                            <td colspan="1" style="background-color:rgb(227, 227, 227); color:#7d7d7d; text-align: right; font-weight:500; padding: 20px 8px 20px; width:200px;">{{ number_format($sum_south ?? 0,2) }}</td>
                            <td colspan="1" style="background-color:rgb(227, 227, 227); color:#7d7d7d; text-align: right; font-weight:500; padding: 20px 8px 20px; width:200px;">{{ number_format($total,2) }}</td>
    
                          </tr> 
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
