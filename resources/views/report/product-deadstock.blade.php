@extends ('layouts.webpanel')
@section('content')

    <div class="contentArea w-full max-w-full break-words">


        <div class="py-2"></div>
        <h5 class="!text-gray-600 font-semibold mx-4"><a href="/webpanel/report/product" class="!no-underline">ย้อนกลับ</a> | สินค้าไม่เคลื่อนไหว</h5>
        <hr class="my-3 !text-gray-400 !border">

        <div class="mx-4">

            <a href="/webpanel/report/product/deadstock/exportcsv/check?from={{ request('from') }}&to={{ request('to') }}"  id="exportcsv" class="btn" type="submit"  name="" style="width: 150px; padding: 8px;">Export CSV</a>
            <a href="/webpanel/report/product/deadstock/exportexcel/check?from={{ request('from') }}&to={{ request('to') }}"  id="exportexcel" class="btn" type="submit"  name="" style="width: 150px; padding: 8px;">Export Excel</a>
    
            <div class="py-2 mt-2">
                @php
                    $date_from = request('from') ?: date('d/m/y');
                    $from = date("d/m/Y", strtotime($date_from));
                    $date_to = request('to') ?: date('d/m/y');
                    $to = date("d/m/Y", strtotime($date_to));
                @endphp

                <span style="color:#fb3131; font-size:14px;">* Export : สินค้าไม่เคลื่อนไหว (เปิด)
                    <span style="font-weight: 600; border:solid 1px rgb(240, 32, 32); padding:5px 10px 5px; border-radius:5px;">วันที่: {{ $from.' '.'ถึง'.' '.$to }}</span>
                </span>
            </div>

        </div> 

        <hr class="my-4" style="color: #8E8E8E; width: 100%;">

        <div class="mx-4">

            <form method="get" action="/webpanel/report/product/deadstock/search">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end mx-2">
                
                        <div>
                            <p class="mt-2 mb-1" for="from">วันที่เริ่ม : </p>
                            <input type="text" class="block w-full mb-2" id="fromcheck" style="border:solid 1px rgb(208, 208, 208); padding: 10px; border-radius:7px; width:100%; color:#9d9d9d; font-size:14px;" name="from" value="{{ request('from') == '' ? date('Y-m-d') : request('from') }}">
                        </div>
                        <div>
                            <p class="mt-2 mb-1" for="to">ถึงวันที่ : </p>
                            <input type="text" class="block w-full mb-2" id="tocheck" style="border:solid 1px rgb(208, 208, 208); padding:10px; border-radius:7px; width:100%; color:#9d9d9d; font-size:14px;" name="to" value="{{ request('to') == '' ? date('Y-m-d') : request('to') }}">
                        </div>
                        <div>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white !rounded-md px-3 py-2.5 mb-2">ค้นหา</button>
                        </div>

                </div>
            </form>
            
            <hr class="my-3 mt-4" style="color: #8E8E8E; width: 100%;">

            <div class="row mx-1" style="justify-content: left;">
                <div class="textbox" style="width: 240px; height: 80px; background-color: #3399ff; border-radius: 10px; text-align: center; margin: 20px 10px; padding: 20px;">
                    <span style="color: white; text-align: center;">
                        <a href="" style="text-decoration: none; color:white;">สินค้าทั้งหมด</a><br/>
                        @if (isset($count_productall ))
                        <span>{{$count_productall  != '' ? $count_productall  : '0'}}</span>
                        @else
                        <span>error</span>
                        @endif
                    </span>
                </div>

                <div class="textbox" style="width: 240px; height: 80px; background-color: #3399ff; border-radius: 10px; text-align: center; margin: 20px 10px; padding: 20px;">
                    <span style="color: white; text-align: center;">
                        <a href="" style="text-decoration: none; color:white;">สินค้ายกเลิกขาย</a><br/>
                        @if (isset($count_productall_notmove ))
                        <span>{{$count_productall_notmove  != '' ? $count_productall_notmove  : '0'}}</span>
                        @else
                        <span>error</span>
                        @endif
                    </span>
                </div>

                <div class="textbox" style="width: 240px; height: 80px; background-color: #3399ff; border-radius: 10px; text-align: center; margin: 20px 10px; padding: 20px;">
                    <span style="color: white; text-align: center;">
                        <a href="" style="text-decoration: none; color:white;">สินค้าที่ยังคงขาย</a><br/>
                        @if (isset($count_productall_notmove ))
                        <span>{{$count_productall_notmove  != '' ? ($count_productall - $count_productall_notmove)  : '0'}}</span>
                        @else
                        <span>error</span>
                        @endif
                    </span>
                </div>

            </div>

            <hr class="my-3 mt-4" style="color: #8E8E8E; width: 100%;">

            <div class="row mx-1" style="justify-content: left;">

                @php
                    $date_from = request('from') ?: date('d/m/y');
                    $from = date("d/m/Y", strtotime($date_from));
                    $date_to = request('to') ?: date('d/m/y');
                    $to = date("d/m/Y", strtotime($date_to));
                @endphp
                <span style="color:#424242;">Dashboard : สถานะสินค้าตามช่วงเวลา
                    <span style="font-weight: 600; color:#484848; border:solid 1px rgb(63, 63, 63); padding:5px 10px 5px; border-radius:5px;">วันที่: {{ $from.' '.'ถึง'.' '.$to }}</span>
                </span>

                <div class="textbox" style="width: 240px; height: 80px; background-color: #0fb80c; border-radius: 10px; text-align: center; margin: 20px 10px; padding: 20px;">
                    <span style="color: white; text-align: center;">
                        <a href="" style="text-decoration: none; color:white;">สินค้าที่เคลื่อนไหว</a><br/>
                        @if (isset($count_dead_stock_on))
                        <span>{{$count_dead_stock_on != '' ? ($count_productall - $count_dead_stock) : '0'}}</span>
                        @else
                        <span>error</span>
                        @endif
                    </span>
                </div>

                <div class="textbox" style="width: 240px; height: 80px; background-color: #8b8b8b; border-radius: 10px; text-align: center; margin: 20px 10px; padding: 20px;">
                    <span style="color: white; text-align: center;">
                        <a href="" style="text-decoration: none; color:white;">สินค้าไม่เคลื่อนไหว</a><br/>
                        @if (isset($count_dead_stock))
                        <span>{{$count_dead_stock != '' ? $count_dead_stock : '0'}}</span>
                        @else
                        <span>error</span>
                        @endif
                    </span>
                </div>

                <div class="textbox" style="width: 240px; height: 80px; background-color: #f6ae05; border-radius: 10px; text-align: center; margin: 20px 10px; padding: 20px;">
                    <span style="color: white; text-align: center;">
                        <a href="" style="text-decoration: none; color:white;">สินค้าไม่เคลื่อนไหว (เปิด)</a><br/>
                        @if (isset($count_dead_stock_on))
                        <span>{{$count_dead_stock_on != '' ? $count_dead_stock_on : '0'}}</span>
                        @else
                        <span>error</span>
                        @endif
                    </span>
                </div>

                <div class="textbox" style="width: 240px; height: 80px; background-color: #fe3a3a; border-radius: 10px; text-align: center; margin: 20px 10px; padding: 20px;">
                    <span style="color: white; text-align: center;">
                        <a href="" style="text-decoration: none; color:white;">สินค้าไม่เคลื่อนไหว (ปิด)</a><br/>
                        @if (isset($count_dead_stock_close))
                        <span>{{$count_dead_stock_close != '' ? $count_dead_stock_close : '0'}}</span>
                        @else
                        <span>error</span>
                        @endif
                    </span>
                </div>

            </div>

            <script>
                $( function() {
                    var dateFormat = 'dd/mm/yy',
                        from = $( "#fromcheck" )
                        .datepicker({
                            defaultDate: "+1w",
                            changeMonth: true,
                            numberOfMonths: 1,
                            dateFormat: 'yy-mm-dd',
                        })
                        .on( "change", function() {
                            to.datepicker( "option", "minDate", getDate( this ) );
                        }),
                        to = $( "#tocheck" ).datepicker({
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

            <div class="ms-6 mr-6 mb-2" id="protected">
                <hr class="my-3 mt-4" style="color: #8E8E8E; width: 100%;">
                <table class="table table-hover align-middle shadow-sm rounded" 
                style="width:100%; border: 1px solid #e9ecef; border-collapse: collapse;">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center border-end" style="width: 4%; color:#3d3d3d;">#</th>
                            <th class="text-center border-end" style="width: 8%; color:#3d3d3d;">รหัสสินค้า</th>
                            <th class="border-end" style="width: 28%; color:#3d3d3d; text-align:center;">ชื่อสินค้า</th>
                            <th class="border-end" style="width: 15%; color:#3d3d3d; text-align:center;">ชื่อสามัญทางยา</th>
                            <th class="text-center border-end" style="width: 8%; color:#3d3d3d;">คงเหลือ</th>
                            <th class="text-center border-end" style="width: 8%; color:#3d3d3d;">หน่วย</th>
                            <th class="text-center">สถานะสินค้า</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $start = 1; @endphp
                        @foreach ($dead_stock as $row_ds)
                            <tr>
                                <td class="text-center border-end" style="color:#5e5e5e;">{{ $start++ }}</td>
                                <td class="text-center border-end" style="color:#5e5e5e;">{{ $row_ds->product_id }}</td>
                                <td class="border-end" style="color:#5e5e5e;">{{ $row_ds->product_name }}</td>
                                <td class="border-end" style="color:#5e5e5e;">{{ $row_ds->generic_name }}</td>
                                <td class="text-center border-end" style="color:#5e5e5e;">{{ $row_ds->quantity }}</td>
                                <td class="text-center border-end" style="color:#5e5e5e;">{{ $row_ds->unit }}</td>
                                <td class="text-center">
                                    @if ($row_ds->status === 'เปิด')
                                        <span class="badge bg-success px-3 py-2">เปิด</span>
                                    @else
                                        <span class="badge bg-danger px-3 py-2">ปิด</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="py-2"></div>
            </div>
            
        </div>

    </div>
@endsection
@push('styles')
    <style>
        #exportcsv {
            background-color: #dddddd;
            color: #3d3d3d;
            border: none;
            cursor: pointer;
            padding: 8px 16px;
            font-size: 16px;
            border-radius: 4px;
            text-align: center;
        }
        #exportcsv:hover {
            background-color: #cccccc;
            color: #3c3c3c;
        }
        #exportexcel {
            background-color: #dddddd;
            color: #3d3d3d;
            border: none;
            cursor: pointer;
            padding: 8px 16px;
            font-size: 16px;
            border-radius: 4px;
            text-align: center;
        }
        #exportexcel:hover {
            background-color: #cccccc;
            color: #3c3c3c;
        }

    </style>
@endpush