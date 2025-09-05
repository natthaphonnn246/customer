<!DOCTYPE html>
<html lang="en">
    @section ('title', 'customer')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" conten="{{ csrf_token() }}">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- <script src="https://unpkg.com/flowbite@1.6.5/dist/flowbite.min.js"></script> --}}

    <title>CMS VMDRUG System</title>
</head>
<body>

    @extends ('webpanel/menuwebpanel-tailwind')
    @section('content')
    @csrf


    <style>
        .contentArea {
            /* padding: 10px; */
            background-color: #FFFFFF;
            border-radius: 2px;
            min-width: 1500px;
            /* text-align: left; */
        }
        #admin {
            background-color: #007bff;
            color: #FFFFFF;
            border: none;
            cursor: pointer;
            padding: 8px 16px;
            font-size: 16px;
            border-radius: 4px;
            text-align: center;
        }
        #admin:hover {
            background-color: #0b59f6;
        }
        #importMaster {
            background-color: #4e5dff;
            color: #ffffff;
            border: none;
            cursor: pointer;
            padding: 8px 16px;
            font-size: 16px;
            border-radius: 4px;
            text-align: center;
        }
        #importMaster:hover {
            background-color: #3848fb;
            color: #ffffff;
        }
        #updateMaster {
            background-color: #f86060;
            color: #ffffff;
            border: none;
            cursor: pointer;
            padding: 8px 16px;
            font-size: 16px;
            border-radius: 4px;
            text-align: center;
        }
        #updateMaster:hover {
            background-color: #ff4242;
            color: #ffffff;
        }
        #groupsCustomer {
            background-color: #ffd500;
            color: #272727;
            border: none;
            cursor: pointer;
            padding: 8px 16px;
            font-size: 16px;
            border-radius: 4px;
            text-align: center;
        }
        #groupsCustomer:hover {
            background-color: #ffc800;
            color: #272727;
        }
        #edit {
            background-color: #007bff;
            color: #FFFFFF;
            border: none;
            cursor: pointer;
            padding: 8px 16px;
            font-size: 16px;
            border-radius: 4px;
            text-align: center;
        }
        .trash-customer {
            background-color: #e12e49;
            color: #FFFFFF;
            border: none;
            cursor: pointer;
            padding: 8px 16px;
            font-size: 16px;
            border-radius: 4px;
            text-align: center;
        }
        /* toggle off */
        .switch {
            position: relative;
            display: inline-block;
            width: 55px;
            height: 28px;
            
        }

        /* Hide default HTML checkbox */
        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
            
        }

        /* The slider */
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
            
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 22px;
            width: 22px;
            left: 1.5px;
            right: 3px;
            bottom: 3px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
            
        }

        input:checked + .slider {
            background-color: #03ae3f;
    
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }
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

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }

         /* toggle off */
        .switchs {
            position: relative;
            display: inline-block;
            width: 55px;
            height: 28px;
            
        }

        /* Hide default HTML checkbox */
        .switchs input {
            opacity: 0;
            width: 0;
            height: 0;
            
        }

        .sliders {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
            
        }
        .sliders:before {
            position: absolute;
            content: "";
            height: 22px;
            width: 22px;
            left: 1.5px;
            right: 3px;
            bottom: 3px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
            
        }

        input:checked + .sliders {
            background-color: #f63d3d;
    
        }

        input:focus + .sliders {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked + .sliders:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .sliders.round {
            border-radius: 34px;
        }

        .sliders.round:before {
            border-radius: 50%;
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
/*         #protected {
                    position: relative;
                    }

                    #protected::after {
                    content: "© ห้ามบันทึกภาพหน้าจอ";
                    position: absolute;
                    top: 50%;
                    left: 50%;
                    font-size: 120px;
                    color: rgba(234, 43, 43, 0.111);
                    pointer-events: none;
                    transform: translate(-50%, -50%) rotate(-45deg);
                    white-space: nowrap;
                }
 */


    </style>
    
        @if($user_id_admin == '0000')
            @section('profile_img')
            <img class="w-8 h-8 rounded-full me-3" src="/profile/profiles-2 copy.jpg" alt="user photo">
            @endsection
        @else
            @section('profile_img')
            <img class="w-8 h-8 rounded-full me-3" src="/profile/user.png" alt="user photo">
            @endsection
        @endif

        @section('status_alert')
        <h6 class="justifiy-content:center;" style="">{{number_format($status_alert)}}</h6>
        @endsection

        @section('status_waiting')
        <h6 class="justifiy-content:center;" style="">{{number_format($status_waiting)}}</h6>
        @endsection

        @section('status_registration')
        <h6 class="justifiy-content:center;" style="">{{number_format($status_registration)}}</h6>
        @endsection

        @section('status_updated')
        <h6 class="justifiy-content:center;" style="">{{$status_updated}}</h6>
        @endsection

        @section('text_alert')
        <h6 class="justifiy-content:center; mt-2 ms-4 mr-6" style="background-color:#cb4d4d; border-radius:20px; padding: 5px; color:#ffffff; font-weight:500;">{{$status_updated}}</h6>
        @endsection
        {{-- <img src="{{ url('/') }}/storage/certificates/img_certstore/1dcV3LQvU5DbAW2hVAMAwHyYLLng85K9aGq4TX47.jpg"> --}}

        {{-- {{$_SERVER['REMOTE_ADDR'];}} --}}

    


    <div class="contentArea w-full max-w-full break-words">

        <div class="py-2">
            {{-- <span style="color: #8E8E8E;"><a href="/webpanel/admin" id="backLink">ข้อมูลแอดมิน (Admin)</a> / แบบฟอร์ม</span> --}}
        </div>
        <span class="ms-6" style="color: #8E8E8E;">ตรวจสอบอัปเดตใบอนุญาต (Check for license updates)</span>
        <hr class="my-3" style="color: #8E8E8E; width: 100%; border:solid 3px;">

       {{--  <div class="ms-6" style="text-align: left;">

            <a href="/webpanel/report/count-pur/exportcsv/check?from={{ request('from') }}&to={{ request('to') }}"  id="exportcsv" class="btn" type="submit"  name="" style="width: 150px; padding: 8px;">Export CSV</a>
            <a href="/webpanel/report/count-pur/exportexcel/check?from={{ request('from') }}&to={{ request('to') }}"  id="exportexcel" class="btn" type="submit"  name="" style="width: 150px; padding: 8px;">Export Excel</a>
    
        </div>  --}}

        <div class="ms-6">
            <ul class="ms-2 my-2">
                <span style="color:#6f6f6f;">ส่งออกไฟล์ : </span>
            </ul>
        
            {{-- Export CSV --}}
            <div class="relative inline-block mr-4">
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

        <div class="row ms-6" style="justify-content: left;">
            
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
{{-- 
                @php
                    if($result_check) {
                        foreach ($result_check as $row) {
                            if(($row?->status) == 'ดำเนินการแล้ว') {
                                dump($row->customer_id.' '.$row?->customer_name);
                            }

                        }
                    }
                @endphp --}}

                {{-- <table class="table table-striped table-bordered mt-4" style="table-layout: auto; width:100%;"> --}}
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
                                        <span style="color:#03ae3f; border:1px solid #03ae3f; padding:2px 6px; border-radius:4px;">
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
                                        <span style="color:#fa9806; border:1px solid #fa9806; padding:2px 6px; border-radius:4px;">
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
                                        <span style="color:#f12323; border:1px solid #f12323; padding:2px 6px; border-radius:4px;">
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
</body>
</html>
