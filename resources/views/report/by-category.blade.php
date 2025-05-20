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
            min-width: 1200px;
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
        #importProduct {
            background-color: #767dff;
            color: #ffffff;
            border: none;
            cursor: pointer;
            padding: 8px 16px;
            font-size: 16px;
            border-radius: 4px;
            text-align: center;
        }
        #importProduct:hover {
            background-color: #5b63fa;
            color: #ffffff;
        }
        #byCategory {
            background-color: #fe95d6;
            color: #ffffff;
            border: none;
            cursor: pointer;
            padding: 8px 16px;
            font-size: 16px;
            border-radius: 4px;
            text-align: center;
        }
        #byCategory:hover {
            background-color: #fa5bcd;
            color: #ffffff;
        }
        #byRegion {
            background-color: #989df9;
            color: #ffffff;
            border: none;
            cursor: pointer;
            padding: 8px 16px;
            font-size: 16px;
            border-radius: 4px;
            text-align: center;
        }
        #byRegion:hover {
            background-color: #5b63fa;
            color: #ffffff;
        }
        #importCate {
            background-color: #eeb272;
            color: #ffffff;
            border: none;
            cursor: pointer;
            padding: 8px 16px;
            font-size: 16px;
            border-radius: 4px;
            text-align: center;
        }
        #importCate:hover {
            background-color: #f0a658;
            color: #ffffff;
        }
        #importsubCate {
            background-color: #a4db3e;
            color: #ffffff;
            border: none;
            cursor: pointer;
            padding: 8px 16px;
            font-size: 16px;
            border-radius: 4px;
            text-align: center;
        }
        #importsubCate:hover {
            background-color: #94d122;
            color: #ffffff;
        }
        #groupsCustomer {
            background-color: #ff5cc1;
            color: #ffffff;
            border: none;
            cursor: pointer;
            padding: 8px 16px;
            font-size: 16px;
            border-radius: 4px;
            text-align: center;
        }
        #groupsCustomer:hover {
            background-color: #ed1199;
            color: #ffffff;
        }
        #edit {
            background-color: #ffa602;
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
        <h6 class="justifiy-content:center;" style="">{{$status_registration}}</h6>
        @endsection

        @section('status_updated')
        <h6 class="justifiy-content:center;" style="">{{$status_updated}}</h6>
        @endsection

        @section('text_alert')
        <h6 class="justifiy-content:center; mt-2 ms-4 mr-6" style="background-color:#cb4d4d; border-radius:20px; padding: 5px; color:#ffffff; font-weight:500;">{{$status_updated}}</h6>
        @endsection
        {{-- <img src="{{ url('/') }}/storage/certificates/img_certstore/1dcV3LQvU5DbAW2hVAMAwHyYLLng85K9aGq4TX47.jpg"> --}}
    <div class="contentArea">

        <div class="py-2">
            {{-- <span style="color: #8E8E8E;"><a href="/webpanel/admin" id="backLink">ข้อมูลแอดมิน (Admin)</a> / แบบฟอร์ม</span> --}}
        </div>
        <span class="ms-6" style="color: #8E8E8E;">ขายตามหมวดหมู่สินค้า</span>
        <hr class="my-3" style="color: #8E8E8E; width: 100%; border:solid 3px;">

        <hr class="my-4" style="color: #8E8E8E; width: 100%;">
        <!--- search --->
  
        <div class="container"  style="width: 95%;">

            <div class="row ms-2">
                {{-- <form method="get" action="/webpanel/report/product/search"> --}}
                <form method="get" action="/webpanel/report/product/sales/category">
                    @csrf
                    <div class="row">
                        <div class="row mt-2">
                            <div class="col-sm-5">
                                <label class="py-2" for="from">วันที่เริ่ม : </label>
                                <input type="text" class="block w-full" id="from" style="border:solid 1px rgb(208, 208, 208); padding: 10px; border-radius:7px; width:100%; color:#9d9d9d; font-size:14px;" name="from" value="{{(isset($_GET['from'])) == '' ? date('Y-m-d') : $_GET['from'] ;}}">
                            </div>
                            <div class="col-sm-5">
                                <label class="py-2" for="to">ถึงวันที่ : </label>
                                <input type="text" class="block w-full" id="to" style="border:solid 1px rgb(208, 208, 208); padding:10px; border-radius:7px; width:100%; color:#9d9d9d; font-size:14px;" name="to" value="{{(isset($_GET['to'])) == '' ? date('Y-m-d') : $_GET['to'] ;}}">
                            </div>
                            <div class="col-sm-2 mt-10">
                                <button type="submit" class="btn btn-primary" style="width:80px; font-size:15px; font-weight:500; padding:8px;">ค้นหา</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>

            <div class="ms-3 mr-4 mb-2 mt-10">

                <span class="ms-2" style="font-size:18px; color:#202020;">หมวดหมู่ :</span>
                <hr class="my-3" style="color: #8E8E8E; width: 100%;">
                <table class="table table-striped">
                    <thead>
                        
                    <tr>
                        <td scope="col" style="color:#838383; text-align: center; font-weight: 500; width:5px;">#</td>
                        <td scope="col" style="color:#838383; text-align: left; font-weight: 500;">รหัสหมวดหมู่</td>
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
                                
                                $id = $row->id;
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

                    @endif

                    <tr>
                        <td colspan="1" style="background-color:rgb(204, 204, 204); color:#161616; text-align: center; font-weight:400; padding: 20px 8px 20px;">ทั้งหมด</td>
                        <td colspan="2" style="background-color:rgb(204, 204, 204); color:#161616; text-align: center; font-weight:400; padding: 20px 8px 20px;"></td>
                        <td colspan="1" style="background-color:rgb(204, 204, 204); color:#161616; text-align: right; font-weight:400; padding: 20px 8px 20px;">{{ number_format($total_sales,2) }}</td>
                        <td colspan="1" style="background-color:rgb(204, 204, 204); color:#161616; text-align: right; font-weight:400; padding: 20px 8px 20px;">{{ number_format($total_percent,2) }}</td>
                        <td colspan="2" style="background-color:rgb(204, 204, 204); color:#161616; text-align: right; font-weight:400; padding: 20px 8px 20px;">{{ number_format($total_margin/21, 2) }}</td>

                      </tr>
                    </tbody>

                </table>
            </div>
    
       
            <hr class="my-3" style="color: #8E8E8E; width: 100%;">

    </div>
@endsection

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
</body>
</html>
