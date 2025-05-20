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
        #importSeller {
            background-color: #ff7692;
            color: #ffffff;
            border: none;
            cursor: pointer;
            padding: 8px 16px;
            font-size: 16px;
            border-radius: 4px;
            text-align: center;
        }
        #importSeller:hover {
            background-color:  #e44b69;
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
            background-color: #04a752;
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
        <span class="ms-6" style="color: #8E8E8E;">รายงานการขายสินค้า</span>
        <hr class="my-3" style="color: #8E8E8E; width: 100%; border:solid 3px;">

        <div class="ms-6" style="text-align: left;">
            {{-- <a href="/webpanel/customer/customer-create"  id="admin" class="btn" type="submit"  name="" style="width: 180px; padding: 8px;">เพิ่มลูกค้าใหม่</a> --}}
            <a href="/webpanel/report/seller/importseller"  id="importSeller" class="btn" type="submit"  name="" style="width: 200px; padding: 8px;">Import CSV (vmdrug)</a>
            {{-- @php
                if($_GET['min_seller'])
            @endphp --}}
            <a href="/webpanel/report/seller/exportcsv/check?min_seller={{ request('min_seller') ?? ''}}&max_seller={{ request('max_seller') ?? ''}}&from={{ request('from') ?? ''}}&to={{ request('to') ?? ''}}"  id="exportcsv" class="btn" type="submit"  name="" style="width: 180px; padding: 8px;">Export ALL CSV</a>
            <a href="/webpanel/report/seller/exportexcel/check?min_seller={{ request('min_seller') ?? ''}}&max_seller={{ request('max_seller') ?? ''}}&from={{ request('from') ?? ''}}&to={{ request('to') ?? ''}}"  id="exportexcel" class="btn" type="submit"  name="" style="width: 180px; padding: 8px;">Export ALL Excel</a>
    
        </div>

        <hr class="my-4" style="color: #8E8E8E; width: 100%;">

        <div class="row ms-6" style="justify-content: left;">
            
            <div class="textbox" style="width: 240px; height: 90px; background-color: #3399ff; border-radius: 10px; text-align: center; margin: 20px 10px; padding: 20px;">
                <span style="color: white; text-align: center;">
                    <span style="font-size:14px;">ใบสั่งซื้อ</span><br/>
                    {{-- @if (isset($count_purchase_range) || isset($count_customer_range)) --}}
                    @if (!empty($count_purchase_range) || !empty($count_customer_range))
                    <span>{{$count_purchase_range ?? $count_customer_range}}</span>
                    @else
                    <span>{{$count_purchase_all ?? 0}}</span>
                    @endif
                </span>
            </div>
              
            @php
                $total_sellings = 0;
                foreach ($total_report_selling as $row_selling) {
                    $total_sellings += $row_selling->total_sales;
                }

            @endphp

            <div class="textbox" style="width: 240px; height: 90px; background-color: #3399ff; border-radius: 10px; text-align: center; margin: 20px 10px; padding: 20px;">
                <span style="color: white; text-align: center;">
                    <a href="" style="text-decoration: none; color:white; font-size:14px;">ร้านค้า</a><br/>
                    @if (isset($count_customer_range))
                    <span>{{$count_customer_range}}</span>
                    @else
                    <span>{{$count_customer_all}}</span>
                    @endif
                </span>
            </div>

            <div class="textbox" style="width: 240px; height: 90px; background-color: #3399ff; border-radius: 10px; text-align: center; margin: 20px 10px; padding: 20px;">
                <span style="color: white; text-align: center;">
                    <a href="" style="text-decoration: none; color:white; font-size:14px;">ยอดรวม</a><br/>
                    <span>{{number_format($total_sellings,2) ?? 0}}</span>
                </span>
            </div>

           
    {{--         <div class="textbox" style="width: 240px; height: 80px; background-color: #3399ff; border-radius: 10px; text-align: center; margin: 20px 10px; padding: 20px;">
                <span style="color: white; text-align: center;">
                    <a href="/webpanel/customer/status/action" style="text-decoration: none; color:white;">ต้องดำเนินการ</a><br/>
                    @if (isset($total_status_action))
                    <span>{{$total_status_action != '' ? $total_status_action : '0' ;}}</span>
                    @else
                    <span>error</span>
                    @endif
                </span>
            </div>

            <div class="textbox" style="width: 240px; height: 80px; background-color: #3399ff; border-radius: 10px; text-align: center; margin: 20px 10px; padding: 20px;">
                <span style="color: white; text-align: center;">
                    <a href="/webpanel/customer/status/latest_update" style="text-decoration: none; color:white;">UPDATE</a> <sup style="background-color:#80bdf3; padding:5px; width: 10px; color:#ffffff; border-radius: 20px;">New</sup><br/>
                    @if (isset($total_status_updated))
                    <span>{{$total_status_updated != '' ? $total_status_updated : '0' ;}}</span>
                    @else
                    <span>error</span>
                    @endif
                </span>
            </div>

            <div class="textbox" style="width: 240px; height: 80px; background-color: #3399ff; border-radius: 10px; text-align: center; margin: 20px 10px; padding: 20px;">
                <span style="color: white; text-align: center;">
                    <a href="/webpanel/customer/status/inactive" style="text-decoration: none; color:white;">ปิดบัญชี</a><br/>
                    @if (isset($customer_status_inactive))
                    <span>{{$customer_status_inactive != '' ? $customer_status_inactive : '0' ;}}</span>
                    @else
                    <span>error</span>
                    @endif
                </span>
            </div> --}}

        </div>
        <hr class="my-3" style="color: #8E8E8E; width: 100%;">
        <!--- search --->
  
        <div class="container"  style="width: 95%;">

            <div class="row mb-2">
                <form class="max-w-100 mx-auto mt-2" method="get" action="/webpanel/report/seller/search/keyword">
                    <ul class="ms-2 my-2">
                        <span>ค้นหาร้านค้า : </span>
                    </ul>
                    {{-- <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-black">Search</label> --}}
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <!---icon -->
                        </div>
                        <input type="search" id="default-search" name="keyword" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-white-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="CODE /ชื่อร้านค้า" />
                        <button type="submit" class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 my-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">ค้นหา</button>
                    
                    </div>
                    <p class="py-2" id="keyword_search"></p>
                    @csrf   
                </form>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                $('#default-search').keyup(function(e) {
                    e.preventDefault();  // Prevent form from submitting

                    $.ajax({
                        url: '/webpanel/customer/search/code',
                        method: 'GET',
                        data: {
                            keyword: $(this).val(),

                        },
                        catch:false,
                        success: function(data) {
                            
                            $('#keyword_search').html(data);

                        }
                    });
                   /*  let keyword = $(this).val();
                    console.log(keyword ); */
                });
            });
        </script>
        <div class="row ms-6 mr-10">
  
     {{--        <div class="col-sm-2">
                <button id="dropdownDividerCategory" data-dropdown-toggle="dropdownDivider" class="mt-9" style="background-color:rgb(227, 227, 227); width: 100%; border-radius:8px; color:#313131; height:70px; height:60%;" type="button">
                
                    การขายสินค้า
                    
                </button> 

                <!-- Dropdown menu -->
                <form action="/webpanel/report/seller/range" method="get">
                <div id="dropdownDivider" class="z-10 hidden bg-gray divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700 dark:divide-gray-600">

                    <div class="py-2 text-center">
                        <span style="color:white;">ต่ำสุด</span>
                        <input type="text" name="min_price" value="0" style="width:80%; border-radius:2px; text-align:center; margin-top:5px; padding:5px;">
                        <span style="color:white; font-size:12px; color:rgb(250, 62, 52);">*ตัวอย่าง 0, 1000</span>
                    </div>
                    <div class="py-2 text-center">
                        <span style="color:white;">สูงสุด</span>
                        <input type="text" name="max_price" value="5000" style="width:80%; border-radius:2px; text-align:center; margin-top:5px; padding:5px;">
                        <span style="color:white; font-size:12px; color:rgb(250, 62, 52);">*ตัวอย่าง 0, 1000</span>
                    </div>
                    <div class="py-2 text-center">
                        <button class="btn btn-primary" type="submit">ค้นหา</button>
                    </div>
                </div>
                </form>
            </div> --}}

            <div class="row ms-2">
                <form method="get" action="/webpanel/report/seller">
                    @csrf
                    <div class="row">

                    <div class="row">

                        <!-- เขตการขาย-->
                        <div class="col-sm-5">
                            <label class="" for="from">เขตการขาย : </label>
                            <select class="form-select mb-2" style="margin-top:10px; color: rgb(171, 171, 171);" aria-label="Default select example" name="salearea_seller">

                                <option selected value="">ไม่ระบุ</option>
                                @foreach ($sale_area as $salearea_seller)
                                <option {{(request('salearea_seller') ?? '') == $salearea_seller->sale_area ? 'selected': ''}} value="{{$salearea_seller->sale_area}}">{{$salearea_seller->sale_area}} ({{$salearea_seller->sale_name}})</option>
                                @endforeach  
                                
                            </select>
                        </div>
                        <!-- admin-->
                        <div class="col-sm-5">
                            <label class="" for="from">แอดมิน : </label>
                            <select class="form-select mb-2" style="margin-top:10px; color: rgb(171, 171, 171);" aria-label="Default select example" name="adminarea_seller">

                                <option selected value="">ไม่ระบุ</option>
                                @foreach ($admin_area as $rowarea_seller)
                                <option {{(request('adminarea_seller') ?? '') == $rowarea_seller->admin_area ? 'selected': ''}} value="{{$rowarea_seller->admin_area}}">{{$rowarea_seller->admin_area}}</option>
                                @endforeach  

                            </select>                      
                        </div>

                        <!-- region-->
                        <div class="col-sm-5 mt-2">
                            <label class="" for="from">ภูมิศาสตร์ : </label>
                            <select class="form-select mb-2" style="margin-top:10px; color: rgb(171, 171, 171);" aria-label="Default select example" name="region">

                                <option selected value="">ไม่ระบุ</option>
                                <option {{(request('region') ?? '') == "ภาคเหนือ" ? 'selected': ''}}  value="ภาคเหนือ">ภาคเหนือ</option>
                                <option {{(request('region') ?? '') == "ภาคกลาง" ? 'selected': ''}}  value="ภาคกลาง">ภาคกลาง</option>
                                <option {{(request('region') ?? '') == "ภาคตะวันออก" ? 'selected': ''}}  value="ภาคตะวันออก">ภาคตะวันออก</option>
                                <option {{(request('region') ?? '') == "ภาคตะวันออกเฉียงเหนือ" ? 'selected': ''}}  value="ภาคตะวันออกเฉียงเหนือ">ภาคตะวันออกเฉียงเหนือ</option>
                                <option {{(request('region') ?? '') == "ภาคตะวันตก" ? 'selected': ''}}  value="ภาคตะวันตก">ภาคตะวันตก</option>
                                <option {{(request('region') ?? '') == "ภาคใต้" ? 'selected': ''}}  value="ภาคใต้">ภาคใต้</option>
                                {{-- {{($_GET['salearea_seller'] ?? '') == $salearea_seller->sale_area ? 'selected': '' ;}} --}}

                            </select>
                        </div>

                        <!-- delivery-->
                        <div class="col-sm-5 mt-2">
                            <label class="" for="from">การจัดส่ง : </label>
                            <select class="form-select mb-2" style="margin-top:10px; color: rgb(171, 171, 171);" aria-label="Default select example" name="delivery">

                                <option selected value="">ไม่ระบุ</option>
                                <option {{(request('delivery') ?? '') == "standard" ? 'selected': ''}}  value="standard">ปกติ</option>
                                <option {{(request('delivery') ?? '') == "owner" ? 'selected': ''}}  value="owner">เอกชน</option>


                            </select>                      
                        </div>
                          
                        <div class="col-sm-5">
                            <label class="py-2" for="from">ต่ำสุด : </label>
                            <input type="text" class="block w-full" style="border:solid 1px rgb(208, 208, 208); padding: 10px; border-radius:7px; width:100%; color:#9d9d9d; font-size:14px;" name="min_seller" value="{{(isset($_GET['min_seller'])) == '' ? '' : $_GET['min_seller'] ;}}" placeholder="การขายต่ำสุด">
                        </div>
                        <div class="col-sm-5">
                            <label class="py-2" for="to">สูงสุด : </label>
                            <input type="text" class="block w-full" style="border:solid 1px rgb(208, 208, 208); padding:10px; border-radius:7px; width:100%; color:#9d9d9d; font-size:14px;" name="max_seller" value="{{(isset($_GET['max_seller'])) == '' ? '' : $_GET['max_seller'] ;}}" placeholder="การขายสูงสุด">
                        </div>
                    </div>
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

        <div class="ms-6 mr-6 mb-2 mt-10">

            <span class="ms-2" style="font-size:18px; color:#202020;">แสดงใบสั่งซื้อ :</span>
            <hr class="my-3" style="color: #8E8E8E; width: 100%;">
            <table class="table table-striped">
                <thead>
                    
                <tr>
                    <td scope="col" style="color:#838383; text-align: left; font-weight: 500;">#</td>
                    <td scope="col" style="color:#838383; text-align: center; font-weight: 500;">CODE</td>
                    <td scope="col" style="color:#838383; text-align: center; font-weight: 500;">Sale</td>
                    <td scope="col" style="color:#838383; text-align: center; font-weight: 500;">Admin</td>
                    <td scope="col" style="color:#838383; text-align: left; font-weight: 500;">ชื่อร้านค้า</td>
                    <td scope="col" style="color:#838383; text-align: left; font-weight: 500;">ใบสั่งซื้อ</td>
                    <td scope="col" style="color:#838383; text-align: center; font-weight: 500;">รวมเป็นเงิน</td>
                    <td scope="col" style="color:#838383; text-align: center; font-weight: 500;">จัดการ</td>
                </tr>
                </thead>
                <tbody>
                    @if($total_page > 0)
                    
                    @php $start = ($start ?? 0) + 1; @endphp

                    @foreach ($report_seller as $row)
                <tr>
                        <?php
                            
                            $id = $row->id;
                            // $user_name = $row->customer_name;
                            $user_code = $row->customer_id;
                            $total_sales = $row->total_sales;
                            $purchase_order = $row->purchase_order;
                        ?>
                    
                    @foreach ($customers_customer_name as $row_name)

                    <?php
                        if($user_code == $row_name->customer_id) {
                            $user_name = $row_name->customer_name; 

                        }
                       
                    ?>
                         {{--  --}}
                           
                    @endforeach
                    <td scope="row" style="color:#9C9C9C; text-align: left; padding: 20px 8px 20px;">{{$start++}}</td>
                    <td scope="row" style="color:#9C9C9C; text-align: center; width:10%; padding: 20px 8px 20px;">{{$user_code}}</td>

                    @foreach ($customers_data as $row_customers)

                    <?php
                        if($row_customers->customer_id == $user_code) {
                            $sale = $row_customers->sale_area;
                            $admin_area_seller = $row_customers->admin_area;
                        }
                    ?>
                
                    @endforeach
            
                    <td scope="row" style="color:#9C9C9C; text-align: center; padding: 20px 8px 20px; width: 10%;">{{$sale ??= 'ไม่พบข้อมูล'}}</td>
                    <td scope="row" style="color:#9C9C9C; text-align: center; padding: 20px 8px 20px; width: 15%;">{{$admin_area_seller ??= 'ไม่พบข้อมูล'}}</td>
                    <td scope="row" style="color:#9C9C9C; text-align: left; padding: 20px 8px 20px; width:35%;">{{$user_name ??= 'ไม่พบข้อมูล'}}</td>

                    <td scope="row" style="color:#9C9C9C; text-align: left; padding: 20px 8px 20px; width:10%;"><span style="border: solid 2px; padding:10px; border-radius: 10px; color:rgb(243, 103, 110);">{{$purchase_order}}</span></td>

                    {{-- {{gettype((int)$total_sales);}} --}}
                        @if ($total_sales <= 5000)
                        <td scope="row" style="color:#9C9C9C; text-align: center; padding: 20px 8px 20px; width: 20%"> <span style="border: solid 2px; padding: 10px; border-radius: 10px; color:rgb(237, 59, 59);">{{number_format($total_sales,2)}}</span></td>
                        {{-- <td scope="row" style="color:#9C9C9C; text-align: left; padding:20px;"><i class="fa-solid fa-circle" style="color: rgb(255, 70, 70);"></i> รอดำเนินการ</td> --}}
                        @elseif ($total_sales > 5000 AND $total_sales <= 10000)
                        <td scope="row" style="color:#9C9C9C; text-align: center; padding: 20px 8px 20px; width: 20%"><span style="border: solid 2px; padding:10px; border-radius: 10px; color:rgb(251, 169, 46);">{{number_format($total_sales,2)}}</span></td>
                        {{-- <td scope="row" style="color:#9C9C9C; text-align: left; padding:20px;"><i class="fa-solid fa-circle" style="color: rgb(251, 183, 23);"></i> ต้องดำเนินการ</td> --}}
                        @elseif ($total_sales > 10000 AND $total_sales <= 15000)
                        {{-- <td scope="row" style="color:#9C9C9C; text-align: left;"><i class="fa-solid fa-circle" style="color: rgb(4, 181, 30);"></i> ดำเนินการแล้ว</td> --}}
                        <td scope="row" style="color:#9C9C9C; text-align: center; padding: 20px 8px 20px; width: 20%"> <span style="border: solid 2px; padding:10px; border-radius: 10px; color:rgb(58, 174, 19);">{{number_format($total_sales,2)}}</span></td>
                        @else
                        <td scope="row" style="color:#9C9C9C; text-align: center; padding: 20px 8px 20px; width: 20%"> <span style="border: solid 2px; padding:10px; border-radius: 10px; color:rgb(17, 196, 255);">{{number_format($total_sales,2)}}</span></td>
                        @endif

                        {{-- <td scope="row" style="color:#9C9C9C; text-align: center; padding:20px;">{{$created_at}}</td> --}}

                        <td scope="row" style="color:#9C9C9C; text-align: center; padding: 20px 8px 20px; width: 10%;">
                            <a href="/webpanel/report/seller/{{$user_code}}?from={{ request('from') ?? ''}}&to={{ request('to') ?? ''}}&po={{ $purchase_order ?? ''  }}" id="edit"><i class="fa-regular fa-eye"></i></a>
                            {{-- <a href="/webpanel/customer/delete/{{$user_code}}" id="trash"><i class="fa-regular fa-trash-can"></i></a> --}}
                            {{-- <button class="trash-customer" type="submit" id="trash{{$id}}"><i class="fa-regular fa-trash-can"></i></button> --}}

                        </td>
                </tr>

                <!-- delete customer table -->

                    <script>
                            $(document).ready(function() {

                                    $('#trash{{$id}}').click(function(e) {
                                        e.preventDefault();
                                        // console.log('delete{{$user_code}}');
                                        let code_del = '{{$id}}';
                                        // console.log('{{$user_code}}');

                                            swal.fire({
                                                icon: "warning",
                                                title: "คุณต้องการลบข้อมูลหรือไม่",
                                                // text: '<?= $user_code .' '.'('. $user_name.')' ; ?>',
                                                text: '{{$user_code.' '.'('. $user_name.')'}}',
                                                showCancelButton: true,
                                                confirmButtonText: "ลบข้อมูล",
                                                cancelButtonText: "ยกเลิก"
                                            }).then(function(result) {
                                
                                            if(result.isConfirmed) {
                                                $.ajax({
                                                url: '/webpanel/customer/delete/{{$id}}',
                                                type: 'GET',
                                                success: function(data) {

                                                    let check_id = JSON.parse(data);
                                                    console.log(check_id.checkcode);

                                                    if(check_id.checkcode == code_del) 
                                                    {
                                                        swal.fire({
                                                            icon: "success",
                                                            title: "ลบข้อมูลสำเร็จ",
                                                            showConfirmButton: true,
                                                        
                                                        }).then (function(result) {
                                                            window.location.reload();
                                                        });
                                                        
                                                    } else {
                                                        Swal.fire({
                                                            icon: "error",
                                                            title: "เกิดข้อผิดพลาด",
                                                            text: 'ไม่พบข้อมูล {{$user_code.' '.'('. $user_name.')'}}',
                                                            showConfirmButton: true,
                                                        });
                                                    }

                                                },

                                            });

                                        } //iscomfirmed;
                            
                                    });   

                                });
                            
                            });

                    </script>

                    <script text="type/javascript">
                            $(document).ready(function() {
                                // $('#status_on').prop('checked', false);
                                $('#status_on{{$id}}').change(function() {
                    
                                    if($(this).is(':checked')) 
                                    {
                                        $('#status_on{{$id}}').prop('checked', true);
                                        console.log('ON');
                                        // var admin_code = $(this).val();
                                        let user_code = '{{$id}}';
                                        console.log(user_code);
                    
                                        $.ajaxSetup({
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            }
                                        });
                                        $.ajax({
                                            url: '/webpanel/customer/status-active',
                                            type: 'POST',
                                            data: {
                                                id_act: 2,
                                                status: 'active',
                                                code_id: user_code,
                                                _token: "{{ csrf_token() }}",
                                            },
                                            success: function(response) {
                    
                                                if(response == 'success') {
                                                    console.log('success');
    
                                                }
                        
                                            },
                                            error: function(xhr, status, error) {
                                                console.log(xhr);
                                                console.log(status);
                                                console.log(error);
                                            }
                                        });
                    
                                    } else {

                                        const user_code = '{{$id}}';
                                        console.log(user_code);

                                        $.ajaxSetup({
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            }
                                        });
                                        $.ajax({
                                            url: '/webpanel/customer/status-inactive',
                                            type: 'POST',
                                            data: {
                                                id_inact: 1,
                                                status_in: 'inactive',
                                                code_id: user_code,
                                                _token: "{{ csrf_token() }}",
                                            },
                                            success: function(response) {
                    
                                                if(response == 'inactive') {
                                                    console.log('inactive');

                                                }
                        
                                            },
                                            error: function(xhr, status, error) {
                                                console.log(xhr);
                                                console.log(status);
                                                console.log(error);
                                            }
                                        });
                                    }
                                });
                            });
                    </script>

                {{--   <script>
                        $(document).ready(function() {
                            $('#trash').click(function() {
                                console.log('trash');
                            });
                        });
                    </script> --}}

                @endforeach
                @endif
                </tbody>
            </table>
        </div>

        @if($total_page > 0)
            {{-- @if(isset($_GET['from']) == '' || isset($_GET['to']) == '' || isset($_GET['min_seller']) == '' || isset($_GET['max_seller']) == '') --}}
            {{-- @if(!empty($_GET['keyword']))  --}}
           @if(request()->filled('from') && request()->filled('to')) <!-- ปลอดภัยกว่า -->
            <div class="ms-6">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                    <li class="page-item">

                    @if ($page == 1)
                        <a class="page-link" href="/webpanel/report/seller?_token={{ request('_token') }}&salearea_seller={{ request('salearea_seller') }}&adminarea_seller={{ request('adminarea_seller') }}&region={{ request('region') }}&delivery={{ request('delivery') }}&min_seller={{ request('min_seller') }}&max_seller={{ request('max_seller') }}&from={{ request('from') }}&to={{ request('to')}}&page={{ 1 }}" aria-label="Previous">
                        <span aria-hidden="true">Previous</span>
                        </a>
                    @else
                        <a class="page-link" href="/webpanel/report/seller?_token={{ request('_token') }}&salearea_seller={{ request('salearea_seller') }}&adminarea_seller={{ request('adminarea_seller') }}&region={{ request('region') }}&delivery={{ request('delivery') }}&min_seller={{ request('min_seller') }}&max_seller={{ request('max_seller') }}&from={{ request('from') }}&to={{ request('to')}}&page={{ $page - 1 }}" aria-label="Previous">
                        <span aria-hidden="true">Previous</span>
                        </a>
                    @endif
                    </li>

                    @if($total_page > 14)

                        @for ($i= 1; $i <= 10 ; $i++)
                        <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>" ><a class="page-link" href="/webpanel/report/seller?_token={{ request('_token') }}&salearea_seller={{ request('salearea_seller') }}&adminarea_seller={{ request('adminarea_seller') }}&region={{ request('region') }}&delivery={{ request('delivery') }}&min_seller={{ request('min_seller') }}&max_seller={{ request('max_seller') }}&from={{ request('from') }}&to={{ request('to')}}&page={{ $i }}">{{ $i }}</a></li>
                        @endfor
                        <li class="page-item"><a class="page-link">...</a></li>
                        @for ($i= $total_page-1; $i <= $total_page ; $i++)
                            <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>"><a class="page-link" href="/webpanel/report/seller?_token={{ request('_token') }}&salearea_seller={{ request('salearea_seller') }}&adminarea_seller={{ request('adminarea_seller') }}&region={{ request('region') }}&delivery={{ request('delivery') }}&min_seller={{ request('min_seller') }}&max_seller={{ request('max_seller') }}&from={{ request('from') }}&to={{ request('to')}}&page={{ $i }}">{{ $i }}</a></li>
                        @endfor

                    @else
                        @for ($i= 1; $i <= $total_page ; $i++)
                        <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>" ><a class="page-link" href="/webpanel/report/seller?_token={{ request('_token') }}&salearea_seller={{ request('salearea_seller') }}&adminarea_seller={{ request('adminarea_seller') }}&region={{ request('region') }}&delivery={{ request('delivery') }}&min_seller={{ request('min_seller') }}&max_seller={{ request('max_seller') }}&from={{ request('from') }}&to={{ request('to')}}&page={{ $i }}">{{ $i }}</a></li>
                        @endfor
                    
                    @endif

                    <li class="page-item">
                    
                    @if ($page == $total_page)
                        <a class="page-link" href="/webpanel/report/seller?_token={{ request('_token') }}&salearea_seller={{ request('salearea_seller') }}&adminarea_seller={{ request('adminarea_seller') }}&region={{ request('region') }}&delivery={{ request('delivery') }}&min_seller={{ request('min_seller') }}&max_seller={{ request('max_seller') }}&from={{ request('from') }}&to={{ request('to')}}&page={{ $page }}" aria-label="Next">
                        <span aria-hidden="true">next</span>
                        </a>
                    @else
                        <a class="page-link" href="/webpanel/report/seller?_token={{ request('_token') }}&salearea_seller={{ request('salearea_seller') }}&adminarea_seller={{ request('adminarea_seller') }}&region={{ request('region') }}&delivery={{ request('delivery') }}&min_seller={{ request('min_seller') }}&max_seller={{ request('max_seller') }}&from={{ request('from') }}&to={{ request('to')}}&page={{ $page + 1 }}" aria-label="Next">
                        <span aria-hidden="true">next</span>
                        </a>
                    @endif
                    </li>
                    </ul>
                </nav>
            </div>
            <hr class="mt-3" style="color: #8E8E8E; width: 100%;">
            <div class="py-3">
                <p class="ms-8 text-sm" style="color:#898989;"> ทั้งหมด {{$total_page}} : จาก {{$page}} - {{$total_page}} </p>
            </div>
            <!--- search not keyword -->
            @else
            <div class="ms-6">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                    <li class="page-item">

                    @if ($page == 1)
                        <a class="page-link" href="/webpanel/report/seller?}page={{ 1 }}" aria-label="Previous">
                        <span aria-hidden="true">Previous</span>
                        </a>
                    @else
                    <a class="page-link" href="/webpanel/report/seller?page={{ $page - 1 }}" aria-label="Previous">
                        <span aria-hidden="true">Previous</span>
                        </a>
                    @endif
                    </li>

                    @if($total_page > 14)

                        @for ($i= 1; $i <= 10 ; $i++)
                        <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>" ><a class="page-link" href="/webpanel/report/seller?page={{ $i }}">{{ $i }}</a></a></li>
                        @endfor
                        <li class="page-item"><a class="page-link">...</a></li>
                        @for ($i= $total_page-1; $i <= $total_page ; $i++)
                            <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>"><a class="page-link" href="/webpanel/report/seller?page={{ $i }}">{{ $i }}</a></a></li>
                        @endfor

                    @else
                        @for ($i= 1; $i <= $total_page ; $i++)
                        <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>" ><a class="page-link" href="/webpanel/report/seller?page={{ $i }}">{{ $i }}</a></li>
                        @endfor
                    
                    @endif

                    <li class="page-item">
                    
                    @if ($page == $total_page)
                        <a class="page-link" href="/webpanel/report/seller?page={{ $page }}" aria-label="Next">
                        <span aria-hidden="true">next</span>
                        </a>
                    @else
                    <a class="page-link" href="/webpanel/report/seller?page={{ $page + 1 }}" aria-label="Next">
                        <span aria-hidden="true">next</span>
                        </a>
                    @endif
                    </li>
                    </ul>
                </nav>
            </div>

            <hr class="mt-3" style="color: #8E8E8E; width: 100%;">
            <div class="py-3">
                <p class="ms-8 text-sm" style="color:#898989;"> ทั้งหมด {{$total_page}} : จาก {{$page}} - {{$total_page}} </p>
            </div>
            @endif
        @else
            <div class="text-center py-8">
                <span style="background-color: #ffc637; padding:15px;">
                    ไม่พบข้อมูล
                </span>
            </div>
        @endif

    </div>
@endsection
</body>
</html>
