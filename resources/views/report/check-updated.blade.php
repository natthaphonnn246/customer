@extends ('layouts.webpanel')
@section('content')
    
    <div class="contentArea w-full max-w-full break-words">

        <div class="py-2"></div>
        <h5 class="!text-gray-600 font-semibold ms-6"><a href="/webpanel/customer" class="!no-underline">ย้อนกลับ</a> | ตรวจสอบใบอนุญาต</h5>
        <hr class="my-3 !text-gray-400 !border">

       {{--  <div class="ms-6" style="text-align: left;">

            <a href="/webpanel/report/count-pur/exportcsv/check?from={{ request('from') }}&to={{ request('to') }}"  id="exportcsv" class="btn" type="submit"  name="" style="width: 150px; padding: 8px;">Export CSV</a>
            <a href="/webpanel/report/count-pur/exportexcel/check?from={{ request('from') }}&to={{ request('to') }}"  id="exportexcel" class="btn" type="submit"  name="" style="width: 150px; padding: 8px;">Export Excel</a>
    
        </div>  --}}

        <div class="ms-8">
            <div class="ms-2 my-2">
                <span style="color:#6f6f6f;">ส่งออกไฟล์ : </span>
            </div>
        
            {{-- Export CSV --}}
            <div class="relative inline-block">
                <button id="dropdownCsvBtn" data-dropdown-toggle="dropdownCsv" style="background-color: rgb(22, 175, 98); width: 220px; border-radius:5px; color:#ffffff; height:40px;">
                    Export CSV
                </button>
        
                <div id="dropdownCsv" class="z-10 hidden divide-y divide-gray-100 rounded-lg shadow w-44 absolute">
                    <a href="/webpanel/check-updated/export/license/getcsv/customerall" class="block px-4 py-2 text-sm" id="listCsv"">ทั้งหมด</a>
                    <a href="/webpanel/check-updated/export/license/getcsv/ดำเนินการแล้ว" class="block px-4 py-2 text-sm" id="listCsv">ดำเนินการแล้ว</a>
                    <a href="/webpanel/check-updated/export/license/getcsv/ต้องดำเนินการ" class="block px-4 py-2 text-sm" id="listCsv">ต้องดำเนินการ</a>
                    <a href="/webpanel/check-updated/export/license/getcsv/รอดำเนินการ" class="block px-4 py-2 text-sm" id="listCsv">รอดำเนินการ</a>
                </div>
            </div>
        
            {{-- Export Excel --}}
            <div class="relative inline-block">
                <button id="dropdownExcelBtn" data-dropdown-toggle="dropdownExcel" style="background-color: rgb(22, 175, 98); width: 220px; border-radius:5px; color:#ffffff; height:40px;">
                    Export Excel
                </button>
        
                <div id="dropdownExcel" class="z-10 hidden divide-y divide-gray-100 rounded-lg shadow w-44 absolute">
                    <a href="/webpanel/check-updated/export/license/getexcel/customerall" class="block px-4 py-2 text-sm" id="listExcel">ทั้งหมด</a>
                    <a href="/webpanel/check-updated/export/license/getexcel/ดำเนินการแล้ว" class="block px-4 py-2 text-sm" id="listExcel">ดำเนินการแล้ว</a>
                    <a href="/webpanel/check-updated/export/license/getexcel/ต้องดำเนินการ" class="block px-4 py-2 text-sm" id="listExcel">ต้องดำเนินการ</a>
                    <a href="/webpanel/check-updated/export/license/getexcel/รอดำเนินการ" class="block px-4 py-2 text-sm" id="listExcel">รอดำเนินการ</a>
                </div>
            </div>
        </div>

        <hr class="my-4" style="color: #8E8E8E; width: 100%;">

        <div class="row" style="justify-content: left; margin-left: 20px;">
            
            <div class="textbox" style="width: 240px; height: 80px; background-color: #3399ff; border-radius: 10px; text-align: center; margin: 20px 10px; padding: 20px;">
                <span style="color: white; text-align: center;">
                    <a href="/webpanel/check-updated" style="text-decoration: none; color:white;">ทั้งหมด</a><br/>
                    @if (isset($count_customer))
                    <span>{{!empty($count_customer) ? $count_customer['ทั้งหมด'] : '0'}}</span>
                    @else
                    <span>error</span>
                    @endif
                </span>
            </div>     
            
            <div class="textbox" style="width: 240px; height: 80px; background-color: #3399ff; border-radius: 10px; text-align: center; margin: 20px 10px; padding: 20px;">
                <span style="color: white; text-align: center;">
                    <a href="/webpanel/check-updated/ดำเนินการแล้ว" style="text-decoration: none; color:white;">ดำเนินการแล้ว</a><br/>
                    @if (isset($count_customer))
                    <span>{{!empty($count_customer) ? $count_customer['ดำเนินการแล้ว'] : '0'}}</span>
                    @else
                    <span>error</span>
                    @endif
                </span>
            </div>


            <div class="textbox" style="width: 240px; height: 80px; background-color: #3399ff; border-radius: 10px; text-align: center; margin: 20px 10px; padding: 20px;">
                <span style="color: white; text-align: center;">
                    <a href="/webpanel/check-updated/ต้องดำเนินการ" style="text-decoration: none; color:white;">ต้องดำเนินการ</a><br/>
                    @if (isset($count_customer))
                    <span>{{!empty($count_customer['ต้องดำเนินการ']) ? $count_customer['ต้องดำเนินการ'] : '0'}}</span>
                    @else
                    <span>error</span>
                    @endif
                </span>
            </div>
              
            <div class="textbox" style="width: 240px; height: 80px; background-color: #3399ff; border-radius: 10px; text-align: center; margin: 20px 10px; padding: 20px;">
                <span style="color: white; text-align: center;">
                    <a href="/webpanel/check-updated/รอดำเนินการ" style="text-decoration: none; color:white;">รอดำเนินการ</a><br/>
                    @if (isset($count_customer))
                    <span>{{!empty($count_customer['รอดำเนินการ']) ? $count_customer['รอดำเนินการ'] : '0'}}</span>
                    @else
                    <span>error</span>
                    @endif
                </span>
            </div>

        </div>
        <hr class="my-3" style="color: #8E8E8E; width: 100%;">

        <div class="ms-6 mr-6 mb-6" style="text-align: left;">
{{-- 
            <form method="get" action="/webpanel/report/sumpur-dates">
                <div class="row mt-2 ms-2" style="width: 80%">
                
                        <div class="col-sm-5">
                            <label class="py-2" for="from">วันที่เริ่ม : </label>
                            <input type="text" class="block w-full" id="fromcheck" style="border:solid 1px rgb(208, 208, 208); padding: 10px; border-radius:7px; width:100%; color:#9d9d9d; font-size:14px;" name="from" value="{{ request('from') == '' ? date('Y-m-d') : request('from') }}">
                        </div>
                        <div class="col-sm-5">
                            <label class="py-2" for="to">ถึงวันที่ : </label>
                            <input type="text" class="block w-full" id="tocheck" style="border:solid 1px rgb(208, 208, 208); padding:10px; border-radius:7px; width:100%; color:#9d9d9d; font-size:14px;" name="to" value="{{ request('to') == '' ? date('Y-m-d') : request('to') }}">
                        </div>
                        <div class="col-sm-2 mt-10">
                            <button type="submit" class="btn btn-primary" style="width:80px; font-size:15px; font-weight:500; padding:8px;">ค้นหา</button>
                        </div>
                
                </div>
            </form> --}}
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

                <span style="color:#545454;">ข้อมูลที่แสดงคือ ลูกค้าที่มีการสั่งซื้อในปีนั้นๆ พร้อมสถานะใบอนุญาตขายยา !!</span>
                <hr class="my-3 mt-4" style="color: #8E8E8E; width: 100%;">

                    <table class="table table-striped mt-4" style="table-layout: auto; width:100%;">
                    <thead>
                        <tr>
                            <th style="color:#838383; text-align: center; font-weight: 500; padding: 8px; width:10px;">ลำดับ</th>
                            <th style="color:#838383; text-align: center; font-weight: 500; padding: 8px; width:10%;">รหัสร้านค้า</th>
                            <th style="color:#838383; text-align: center; font-weight: 500; padding: 8px; width:8%;">เขตการขาย</th>
                            <th style="color:#838383; text-align: center; font-weight: 500; padding: 8px; width:8%;">แอดมิน</th>
                            <th style="color:#838383; text-align: left; font-weight: 500; padding: 8px; width:30%;">ชื่อร้านค้า</th>
                            <th style="color:#838383; text-align: center; font-weight: 500; padding: 8px; width:15%;">สถานะอัปเดตใบอนุญาต</th>
                            <th style="color:#838383; text-align: center; font-weight: 500; padding: 8px; width:40%;">วันที่อัปเดตใบอนุญาต</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $start += 1; @endphp

                    @if(isset($result_status) && !empty($result_status))
                        @foreach ($result_status as $row)
                            @if(($row?->status) == 'ดำเนินการแล้ว')
                                <tr>
                                    <td style="color:#9a9a9a; text-align: center;">{{ $start++ }}</td>
                                    <td style="color:#9a9a9a; text-align: center;">{{ $row?->customer_id }}</td>
                                    <td style="color:#9a9a9a; text-align: center;">{{ $row?->sale_area }}</td>
                                    <td style="color:#9a9a9a; text-align: center;">{{ $row?->admin_area }}</td>
                                    <td style="color:#9a9a9a; text-align: left;">{{ $row?->customer_name }}</td>
                                    <td style="color:#9a9a9a; text-align: center;">
                                        <span class="inline-block border-2 border-green-500 text-green-500 px-3 py-2 rounded-lg text-sm">
                                            {{ $row?->status }}
                                        </span>
                                    </td>                             
                                    <td style="color:#9a9a9a; text-align: center;">{{ $row?->updated_at }}</td>
                                </tr>

                            @elseif (($row?->status) == 'ต้องดำเนินการ')

                                <tr>
                                    <td style="color:#9a9a9a; text-align: center;">{{ $start++ }}</td>
                                    <td style="color:#9a9a9a; text-align: center;">{{ $row?->customer_id }}</td>
                                    <td style="color:#9a9a9a; text-align: center;">{{ $row?->sale_area }}</td>
                                    <td style="color:#9a9a9a; text-align: center;">{{ $row?->admin_area }}</td>
                                    <td style="color:#9a9a9a; text-align: left;">{{ $row?->customer_name }}</td>
                                    <td style="color:#9a9a9a; text-align: center;">
                                        <span class="inline-block border-2 border-amber-400 text-amber-400 px-3 py-2 rounded-lg text-sm">
                                            {{ $row?->status }}
                                        </span>
                                    </td>
                                    <td style="color:#9a9a9a; text-align: center;">{{ $row?->updated_at }}</td>
                                </tr>

                            @else

                                <tr>
                                    <td style="color:#9a9a9a; text-align: center;">{{ $start++ }}</td>
                                    <td style="color:#9a9a9a; text-align: center;">{{ $row?->customer_id }}</td>
                                    <td style="color:#9a9a9a; text-align: center;">{{ $row?->sale_area }}</td>
                                    <td style="color:#9a9a9a; text-align: center;">{{ $row?->admin_area }}</td>
                                    <td style="color:#9a9a9a; text-align: left;">{{ $row?->customer_name }}</td>
                                    <td style="color:#9a9a9a; text-align: center;">
                                        <span class="inline-block border-2 border-red-400 text-red-400 px-3 py-2 rounded-lg text-sm">
                                            {{ $row?->status }}
                                        </span>
                                    </td>
                                    <td style="color:#9a9a9a; text-align: center;">{{ $row?->updated_at }}</td>
                                </tr>

                            @endif
                        @endforeach

                    @else

                        @foreach ($result_status as $row)
                            @if(($row?->status) == 'ดำเนินการแล้ว')
                                <tr>
                                    <td style="color:#9a9a9a; text-align: center;">{{ $loop->iteration }}</td>
                                    <td style="color:#9a9a9a; text-align: center;">{{ $row?->customer_id }}</td>
                                    <td style="color:#9a9a9a; text-align: left;">{{ $row?->customer_name }}</td>
                                    <td style="color:#9a9a9a; text-align: center;">
                                        <span style="color:#03ae3f; border:1px solid #03ae3f; padding:2px 6px; border-radius:4px;">
                                            {{ $row?->status }}
                                        </span>
                                    </td>                             
                                    <td style="color:#9a9a9a; text-align: center;">{{ $row?->updated_at }}</td>
                                </tr>

                            @elseif (($row?->status) == 'ต้องดำเนินการ')

                                <tr>
                                    <td style="color:#9a9a9a; text-align: center;">{{ $loop->iteration }}</td>
                                    <td style="color:#9a9a9a; text-align: center;">{{ $row?->customer_id }}</td>
                                    <td style="color:#9a9a9a; text-align: left;">{{ $row?->customer_name }}</td>
                                    <td style="color:#9a9a9a; text-align: center;">
                                        <span style="color:#fa9806; border:1px solid #fa9806; padding:2px 6px; border-radius:4px;">
                                            {{ $row?->status }}
                                        </span>
                                    </td>
                                    <td style="color:#9a9a9a; text-align: center;">{{ $row?->updated_at }}</td>
                                </tr>
                            @else

                                <tr>
                                    <td style="color:#9a9a9a; text-align: center;">{{ $loop->iteration }}</td>
                                    <td style="color:#9a9a9a; text-align: center;">{{ $row?->customer_id }}</td>
                                    <td style="color:#9a9a9a; text-align: left;">{{ $row?->customer_name }}</td>
                                    <td style="color:#9a9a9a; text-align: center;">
                                        <span style="color:#f12323; border:1px solid #f12323; padding:2px 6px; border-radius:4px;">
                                            {{ $row?->status }}
                                        </span>
                                    </td>
                                    <td style="color:#9a9a9a; text-align: center;">{{ $row?->updated_at }}</td>
                                </tr>

                            @endif

                        @endforeach
                    @endif
                    
                    </tbody>
                </table>

          
            </div>
            
        </div>

            @if($total_page != 0)
                <div class="ms-6">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
            
                            {{-- ปุ่ม Previous --}}
                            <li class="page-item">
                                <a class="page-link" 
                                href="/webpanel/check-updated?page={{ $page == 1 ? 1 : $page - 1 }}" 
                                aria-label="Previous">
                                    <span aria-hidden="true">Previous</span>
                                </a>
                            </li>
            
                            {{-- ถ้า total_page > 14 ให้ย่อ --}}
                            @if($total_page > 14)
                                @for ($i = 1; $i <= 10; $i++)
                                    <li class="page-item @if($i == $page) active @endif">
                                        <a class="page-link" href="/webpanel/check-updated?page={{ $i }}">{{ $i }}</a>
                                    </li>
                                @endfor
            
                                <li class="page-item"><a class="page-link">...</a></li>
            
                                @for ($i = $total_page - 1; $i <= $total_page; $i++)
                                    <li class="page-item @if($i == $page) active @endif">
                                        <a class="page-link" href="/webpanel/check-updated?page={{ $i }}">{{ $i }}</a>
                                    </li>
                                @endfor
                            @else
                                @for ($i = 1; $i <= $total_page; $i++)
                                    <li class="page-item @if($i == $page) active @endif">
                                        <a class="page-link" href="/webpanel/check-updated?page={{ $i }}">{{ $i }}</a>
                                    </li>
                                @endfor
                            @endif
            
                            {{-- ปุ่ม Next --}}
                            <li class="page-item">
                                <a class="page-link" 
                                href="/webpanel/check-updated?page={{ $page == $total_page ? $page : $page + 1 }}" 
                                aria-label="Next">
                                    <span aria-hidden="true">Next</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            
                <hr class="mt-3" style="color: #8E8E8E; width: 100%;">
                <div class="py-3">
                    <p class="ms-8 text-sm" style="color:#898989;">
                        ทั้งหมด {{ $total_page }} หน้า : จาก {{ $page }} - {{ $total_page }}
                    </p>
                </div>
            @endif
    
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
    #dropdownDivider {
        background-color: rgb(67, 68, 68);
        color: white;
        border-radius: 5px;
        
    }
    #dropdownlist:hover {
        background-color: rgba(8, 123, 110, 0.544);
        color: white;
        border-radius: 5px;
        
    }
    #dropdownDividerExport {
        background-color: rgb(67, 68, 68);
        color: white;
        border-radius: 5px;
        
    }
    #listCsv {
        background-color: rgb(67, 68, 68);
        color: white;
        border-radius: 5px;
        
    }
    #listCsv:hover {
        background-color: rgb(8, 123, 110);
        color: white;
        border-radius: 5px;
        
    }
    #listExcel {
        background-color: rgb(67, 68, 68);
        color: white;
        border-radius: 5px;
        
    }
    #listExcel:hover {
        background-color: rgb(8, 123, 110);
        color: white;
        border-radius: 5px;
        
    }

</style>
@endpush
