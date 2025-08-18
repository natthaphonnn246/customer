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
        <span class="ms-6" style="color: #8E8E8E;">จำนวนครั้งสั่งซื้อ (Number of orders)</span>
        <hr class="my-3" style="color: #8E8E8E; width: 100%; border:solid 3px;">

        <div class="ms-6" style="text-align: left;">

            <a href="/webpanel/report/count-pur/exportcsv/check?from={{ request('from') }}&to={{ request('to') }}"  id="exportcsv" class="btn" type="submit"  name="" style="width: 150px; padding: 8px;">Export CSV</a>
            <a href="/webpanel/report/count-pur/exportexcel/check?from={{ request('from') }}&to={{ request('to') }}"  id="exportexcel" class="btn" type="submit"  name="" style="width: 150px; padding: 8px;">Export Excel</a>
    
        </div>

        <hr class="my-4" style="color: #8E8E8E; width: 100%;">

        <div class="ms-6" style="text-align: left;">


    
        </div>

        <div class="ms-6">

        <div class="row ms-6" style="justify-content: left;">
            
            <div class="textbox" style="width: 240px; height: 100%; background-color: #3399ff; border-radius: 10px; text-align: center; margin: 20px 10px; padding: 20px;">
                <span style="color: white; text-align: center;">
                    <a href="/webpanel/report/purchase-dates/customer_all?from={{ request('from') }}&to={{ request('to') }}">รวมทั้งหมด</a><br/>
                    @if (isset($count_all))
                    <span>{{ $count_all ?? 0 }}</span>
                    @else
                    <span>error</span>
                    @endif
                </span>
                <hr class="my-2" style="color:white;">
                <div class="row mt-2">
                    <span style="color: white; text-align: center;">การจัดส่ง</span>
                    <div class="col-sm-6 mt-2">
                        <span style="color:white;">{{ $count_number_all_standard ?? 0 }} <sup style="background-color:#2284e6; padding:5px 10px; border-radius:50px;">ปกติ</sup></span>
                    </div>
                    <div class="col-sm-6 mt-2">
                        <span style="color:white;">{{ $count_number_all_owner ?? 0 }} <sup style="background-color:#2284e6; padding:5px 5px; border-radius:50px;">เอกชน</sup></span>
                    </div>
                </div>
            </div>

            <div class="textbox" style="width: 240px; height: 100%; background-color: #3399ff; border-radius: 10px; text-align: center; margin: 20px 10px; padding: 20px;">
                <span style="color: white; text-align: center;">
                    <a href="/webpanel/report/purchase-dates/number_1?from={{ request('from') }}&to={{ request('to') }}">สั่งซื้อ 1 ครั้ง</a><br/>
                    @if (isset($count_number_1))
                    <span>{{ $count_number_1 ?? 0 }}</span>
                    @else
                    <span>error</span>
                    @endif
                </span>
                <hr class="my-2" style="color:white;">
                <div class="row mt-2">
                    <span style="color: white; text-align: center;">การจัดส่ง</span>
                    <div class="col-sm-6 mt-2">
                        <span style="color:white;">{{ $count_number_1_standard ?? 0 }} <sup style="background-color:#2284e6; padding:5px 10px; border-radius:50px;">ปกติ</sup></span>
                    </div>
                    <div class="col-sm-6 mt-2">
                        <span style="color:white;">{{ $count_number_1_owner ?? 0 }} <sup style="background-color:#2284e6; padding:5px 5px; border-radius:50px;">เอกชน</sup></span>
                    </div>
                </div>
            </div>
              
            <div class="textbox" style="width: 240px; height: 100%; background-color: #3399ff; border-radius: 10px; text-align: center; margin: 20px 10px; padding: 20px;">
                <span style="color: white; text-align: center;">
                    <a href="/webpanel/report/purchase-dates/number_2?from={{ request('from') }}&to={{ request('to') }}" style="text-decoration: none; color:white;">สั่งซื้อ 2 ครั้ง</a><br/>
                    @if (isset($count_number_2))
                    <span>{{ $count_number_2 ?? 0 }}</span>
                    @else
                    <span>error</span>
                    @endif
                </span>
                <hr class="my-2" style="color:white;">
                <div class="row mt-2">
                    <span style="color: white; text-align: center;">การจัดส่ง</span>
                    <div class="col-sm-6 mt-2">
                        <span style="color:white;">{{ $count_number_2_standard ?? 0 }} <sup style="background-color:#2284e6; padding:5px 10px; border-radius:50px;">ปกติ</sup></span>
                    </div>
                    <div class="col-sm-6 mt-2">
                        <span style="color:white;">{{ $count_number_2_owner ?? 0 }} <sup style="background-color:#2284e6; padding:5px 5px; border-radius:50px;">เอกชน</sup></span>
                    </div>
                </div>
            </div>

            <div class="textbox" style="width: 240px; height: 100%; background-color: #3399ff; border-radius: 10px; text-align: center; margin: 20px 10px; padding: 20px;">
                <span style="color: white; text-align: center;">
                    <a href="/webpanel/report/purchase-dates/number_3?from={{ request('from') }}&to={{ request('to') }}" style="text-decoration: none; color:white;">สั่งซื้อ 3 ครั้ง</a><br/>
                    @if (isset($count_number_3))
                    <span>{{ $count_number_3 ?? 0 }}</span>
                    @else
                    <span>error</span>
                    @endif
                </span>
                <hr class="my-2" style="color:white;">
                <div class="row mt-2">
                    <span style="color: white; text-align: center;">การจัดส่ง</span>
                    <div class="col-sm-6 mt-2">
                        <span style="color:white;">{{ $count_number_3_standard ?? 0 }} <sup style="background-color:#2284e6; padding:5px 10px; border-radius:50px;">ปกติ</sup></span>
                    </div>
                    <div class="col-sm-6 mt-2">
                        <span style="color:white;">{{ $count_number_3_owner ?? 0 }} <sup style="background-color:#2284e6; padding:5px 5px; border-radius:50px;">เอกชน</sup></span>
                    </div>
                </div>
            </div>

            <div class="textbox" style="width: 240px; height: 100%; background-color: #3399ff; border-radius: 10px; text-align: center; margin: 20px 10px; padding: 20px;">
                <span style="color: white; text-align: center;">
                    <a href="/webpanel/report/purchase-dates/morethan_4?from={{ request('from') }}&to={{ request('to') }}" style="text-decoration: none; color:white;">สั่งซื้อ 4 ครั้งขึ้นไป</a><br/>
                    @if (isset($count_morethan_4))
                    <span>{{ $count_morethan_4 ?? 0 }}</span>
                    @else
                    <span>error</span>
                    @endif
                </span>
                <hr class="my-2" style="color:white;">
                <div class="row mt-2">
                    <span style="color: white; text-align: center;">การจัดส่ง</span>
                    <div class="col-sm-6 mt-2">
                        <span style="color:white;">{{ $count_morethan_4_standard ?? 0 }} <sup style="background-color:#2284e6; padding:5px 10px; border-radius:50px;">ปกติ</sup></span>
                    </div>
                    <div class="col-sm-6 mt-2">
                        <span style="color:white;">{{ $count_morethan_4_owner ?? 0 }} <sup style="background-color:#2284e6; padding:5px 5px; border-radius:50px;">เอกชน</sup></span>
                    </div>
                </div>
            </div>

        </div>

        <form method="get" action="/webpanel/report/purchase-dates">
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
        </form>

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
        {{-- <hr class="my-3" style="color: #8E8E8E; width: 100%;"> --}}
        <!--- search --->
        <div class="ms-6 mr-6 mb-2" id="protected">
            <hr class="my-3" style="color: #8E8E8E; width: 100%;">
            <table class="table table-striped">
                <thead>

                <tr>
                    <td scope="col" style="color:#838383; text-align: left; font-weight: 500;">#</td>
                    <td scope="col" style="color:#838383; text-align: left; font-weight: 500;">CODE</td>
                    <td scope="col" style="color:#838383; text-align: left; font-weight: 500;">ชื่อร้านค้า</td>
                    <td scope="col" style="color:#838383; text-align: center; font-weight: 500;">จำนวนครั้งสั่งซื้อ</td>
                    <td scope="col" style="color:#838383; text-align: center; font-weight: 500;">รวมเป็นเงิน(บาท)</td>
                    @if(isset($number_orders) && $number_orders == 'morethan_4' || $number_orders == 'customer_all' || $number_orders == 'number_3' )
                    <td scope="col" style="color:#838383; text-align: center; font-weight: 500;">วันที่สั่งซื้อ</td>
                    @elseif (isset($number_orders) && $number_orders == 'number_1' || $number_orders == 'number_2')
                    <td scope="col" style="color:#838383; text-align: center; font-weight: 500;">วันที่สั่งซื้อ</td>
                    @else
                    <td scope="col" style="color:#838383; text-align: center; font-weight: 500;">วันที่สั่งซื้อ</td>
                    @endif
                    <td scope="col" style="color:#838383; text-align: right; font-weight: 500;">ภูมิศาสตร์</td>
                    <td scope="col" style="color:#838383; text-align: right; font-weight: 500;">จังหวัด</td>
                    <td scope="col" style="color:#838383; text-align: right; font-weight: 500;">จัดส่ง</td>
                    <td scope="col" style="color:#838383; text-align: center; font-weight: 500;">เพิ่มเติม</td>
                </tr>
                </thead>
                <tbody>
                    @if(!empty($result))
                    <?php 
                        @$start += 1;
                    ?>
                    @foreach ($result as $row)
                <tr>
                        <?php
                            
                            $id = $row->id ?? 'null';
                            $user_code = $row->customer_id;
                            $user_name = $row->customer_name ?? 'null';
                            $region    = $row->geography ?? 'null';
                            $province  = $row->province ?? 'null';
                            $delivery  = $row->delivery_by ?? 'null';
                            $count_pur = $row->unique_purchase_days;
                            $total_orders = $row->total_orders;
                            $purchase_dates = $row->purchase_dates;

                        ?>
                    
                    <td scope="row" style="color:#9C9C9C; text-align:left; padding:8px 12px; width:2%; vertical-align: middle;">{{ $start++ }}</td>
                    <td scope="row" style="color:#9C9C9C; text-align:left; padding:8px 12px; width:5%; vertical-align: middle;">{{ $user_code }}</td>
                    <td scope="row" style="color:#9C9C9C; text-align:left; padding:8px 12px; width:10%; vertical-align: middle;">{{ $user_name }}</td>
                    <td scope="row" style="color:#9C9C9C; text-align:center; padding:8px 12px; width:5%; vertical-align: middle;">{{ $count_pur }}</td>
                    <td scope="row" style="color:#9C9C9C; text-align:center; padding:8px 12px; width:15%; vertical-align: middle;">{{ number_format($total_orders,2) }}</td>

                    @if(isset($number_orders) && $number_orders == 'morethan_4' || $number_orders == 'customer_all')
                    <td scope="row" style="color:#9C9C9C; text-align:left; padding:8px 12px; width:25%; vertical-align: middle;">{{ $purchase_dates }}</td>
                    @elseif (isset($number_orders) && $number_orders == 'number_1' || $number_orders == 'number_2')
                    <td scope="row" style="color:#9C9C9C; text-align:center; padding:8px 12px; width:15%; vertical-align: middle;">{{ $purchase_dates }}</td>
                    @elseif (isset($number_orders) && $number_orders == 'number_3')
                    <td scope="row" style="color:#9C9C9C; text-align:center; padding:8px 12px; width:15%; vertical-align: middle;">{{ $purchase_dates }}</td>
                    @else
                    <td scope="row" style="color:#9C9C9C; text-align:left; padding:8px 12px; width:25%; vertical-align: middle;">{{ $purchase_dates }}</td>
                    @endif

                    <td scope="row" style="color:#9C9C9C; text-align:right; padding:8px 12px; width:10%; vertical-align: middle;">{{ $region }}</td>
                    <td scope="row" style="color:#9C9C9C; text-align:right; padding:8px 12px; width:10%; vertical-align: middle;">{{ $province }}</td>
                    <td scope="row" style="color:#9C9C9C; text-align:right; padding:8px 12px; width:5%; vertical-align: middle;">{{ $delivery == 'standard' ? 'ปกติ' : ($delivery == 'owner' ? 'เอกชน' : 'ไม่ระบุ') }}</td>

                    <td scope="row" style="color:#9C9C9C; text-align: center; padding:15px 12px; width:5%; vertical-align: middle;">
                        <a href="/webpanel/report/count-purchase/{{$id}}?from={{ request('from') }}&to={{ request('to') }}" id="edit"><i class="fa-regular fa-eye"></i></a>
                    </td>
                    



                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>

  
       
    </div>
@endsection
</body>
</html>
