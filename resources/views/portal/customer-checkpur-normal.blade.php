<!DOCTYPE html>
<html lang="en">
    @section ('title', 'purchase')
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

    <title>cms.vmdrug</title>
</head>
<body>

    @extends ('portal/menuportal-tailwind')
    @section('content')
    @csrf


    <style>
        .contentArea {
            /* padding: 12px; */
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
        #adminRole {
            background-color: #007bff;
            color: #FFFFFF;
            border: none;
            cursor: pointer;
            padding: 8px 16px;
            font-size: 16px;
            border-radius: 4px;
            text-align: center;
        }
        #adminRole:hover {
            background-color: #0b59f6;
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
        #trash {
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
     /*    span:hover {
            color: #f7ff1b;
            text-decoration: none;
        }
        ul a {
            color:rgb(255, 255, 255);
        }
        ul a:hover {
            color:rgb(255, 196, 17);
        } */ 
    </style>

            <div class="contentArea">
            
                @section('col-2')

                @if(isset($user_name))
                    <h6 class="mt-1" style="">{{$user_name->name}}</h6>
                    @endif
                @endsection

                @section('status_alert')
                @if($user_name->rights_area != '0')
                    <h6 class="justifiy-content:center;" style="">{{$status_alert}}</h6>
                    @endif
                @endsection

                @section('status_all')
                @if($user_name->rights_area != '0')
                    <h6 class="justifiy-content:center;" style="">{{$status_all}}</h6>
                    @endif
                @endsection

                @section('status_waiting')
                @if($user_name->rights_area != '0')
                    <h6 class="justifiy-content:center;" style="">{{$status_waiting}}</h6>
                    @endif
                @endsection

                @section('status_action')
                @if($user_name->rights_area != '0')
                    <h6 class="justifiy-content:center;" style="">{{$status_action}}</h6>
                    @endif
                @endsection

                @section('status_completed')
                @if($user_name->rights_area != '0')
                    <h6 class="justifiy-content:center;" style="">{{$status_completed}}</h6>
                    @endif
                @endsection
                    {{-- <span style="color: #8E8E8E;"><a href="/webpanel/admin" id="backLink">ข้อมูลแอดมิน (Admin)</a> / แบบฟอร์ม</span> --}}

                    <div class="py-2">
                        {{-- <span style="color: #8E8E8E;">ข้อมูลลูกค้า (Customer)</span> --}}
                    </div>
                
                    <span class="ms-6" style="color: #8E8E8E;">ข้อมูลลูกค้า : <span style="background-color: #09be0f; color:white; border-radius:5px; padding:3px 10px;">สั่งซื้อตามปกติ</span></span>
                    <hr class="my-3" style="color: #8E8E8E; width: 100%; border:solid 2px;">
                    
                    <div class="ms-6 mr-6">
                        <div class="row">
                        
                            @if(!empty($pur_report) && $pur_report->purchase_status === 1)
                            <div class="col-sm-2 py-3">

                                        {{-- <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-black">Search</label> --}}
                            
                                    <button id="dropdownDividerButton" data-dropdown-toggle="dropdownDivider" class="" style="background-color:rgb(1, 183, 52); width: 100%; border-radius:8px; color:#ffffff; height:70px;" type="button">
                                        
                                        เลือกวันสั่งซื้อ
                                        
                                    </button> 
                    
                                    <!-- Dropdown menu -->
                                    <div id="dropdownDivider" class="z-10 hidden divide-y divide-gray-100 shadow-sm w-44" style="text-align: left;">
                    
                                        <div class="py-2">
                                            <a href="/portal/customer/purchase/morethan" id="dropdownlist" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white text-center">ไม่สั่งเกิน 7 วัน</a>
                                        </div>
                                        <div class="py-2">
                                            <a href="/portal/customer/purchase/coming" id="dropdownlist" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white text-center">ใกล้ครบกำหนด</a>
                                        </div>
                                        <div class="py-2">
                                            <a href="/portal/customer/purchase/normal" id="dropdownlist" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white text-center">สั่งซื้อตามปกติ</a>
                                        </div>
                                        <div class="py-2">
                                            <a href="/portal/customer/purchase/no-purchase" id="dropdownlist" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white text-center">ไม่มีการสั่งซื้อ</a>
                                        </div>
                                    
                                    </div>

                            </div>
                            @endif
                            <div class="col-sm-10">
                              
                            </div>
                        
                        
                        
                        </div>

            {{--    <script>
                        $(document).ready(function () {

                            $("#noti_status").change(function () {

                                let all = $(this).val();
                                
                                switch ($(this).val())
                                {
                                    case "1":
                                        window.location.href ="/portal/customer";
                                        console.log('ทั้งหมด');
                                        break;
                                    case "2":
                                        window.location.href ="/portal/customer/status/waiting";
                                        console.log('รอดำเนินการ');
                                        break;
                                    case "3":
                                        window.location.href ="/portal/customer/status/action";
                                        console.log('ต้องดำเนินการ');
                                        break;
                                    case "4":
                                        window.location.href ="/portal/customer/status/completed";
                                        console.log('ดำเนินการแล้ว');
                                        break;
                                    default:
                                        window.location.href ="/portal/customer";
                                        console.log('ไม่ระบุ');
                                        break;
                                }
                            
                                // alert("Change Status");
                            });
                        });
                </script> --}}
                
            {{--  <hr style="color: #8E8E8E; width: 100%;">

                <div style="text-align: left;">
                    <a href="/webpanel/customer-create"  id="admin" class="btn" type="submit"  name="" style="width: 180px; padding: 8px;">เพิ่มลูกค้าใหม่</a>
                    <a href="/webpanel/admin-role"  id="adminRole" class="btn" type="submit"  name="" style="width: 180px; padding: 8px;">จัดการสิทธิ์</a>
            
                </div> --}}
                <hr class="my-1" style="color: #8E8E8E; width: 100%;">

                <div class="py-2">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <td scope="col" style="color:#838383; text-align: left; font-weight:500; padding:20px;">#</td>
                        <td scope="col" style="color:#838383; text-align: left; font-weight:500; padding:20px;">CODE</td>
                        <td scope="col" style="color:#838383; text-align: left; font-weight:500; padding:20px;">อีเมล</td>
                        <td scope="col" style="color:#838383; text-align: left; font-weight:500; padding:20px;">Sale area</td>
                        <td scope="col" style="color:#838383; text-align: left; font-weight:500; padding:20px;">ชื่อร้านค้า</td>
                        <td scope="col" style="color:#838383; text-align: center; font-weight:500; padding:20px;">สถานะ</td>
                        <td scope="col" style="color:#838383; text-align: center; font-weight:500; padding:20px;">การสั่งซื้อ</td>
                        <td scope="col" style="color:#838383; text-align: center; font-weight:500; padding:20px;">วันที่ลงทะเบียน</td>
                        <td scope="col" style="color:#838383; text-align: center; font-weight:500; padding:20px;">จัดการ</td>
                    </tr>
                    </thead>
                    <tbody>
                        {{-- {{ $customer_list }} --}}
                        @if(!empty($customer_list))
                        <?php 
                            $start += 1;
                        ?>
                        @foreach ($customer_list as $row_list)
                    <tr>
                            <?php
                                
                                $id = $row_list->id;
                                $customer_name = $row_list->customer_name;
                                $customer_code = $row_list->customer_id;
                                $sale_area = $row_list->sale_area;
                                $status_admin = $row_list->sale_area;
                                $email = $row_list->email;
                                $status = $row_list->status;
                                $created_at = $row_list->created_at;
                                $customer_status = $row_list->customer_status;
                            ?>
                        
                        @if($customer_status == 'active')
                            <td scope="row" style="color:#9C9C9C; text-align: left; padding:20px; ">{{$start++}}</td>
                            <td scope="row" style="color:#9C9C9C; text-align: left; padding:20px; ">{{$customer_code}}</td>
                            <td scope="row" style="color:#9C9C9C; text-align: left; padding:20px; ">{{$email}}</td>
                            <td scope="row" style="color:#9C9C9C; text-align: left; padding:20px; ">{{$sale_area}}</td>
                            <td scope="row" style="color:#9C9C9C; text-align: left; padding:20px; width: 20%;">{{$customer_name}}</td>

                                @if ($status == 'รอดำเนินการ')
                                <td scope="row" style="color:#9C9C9C; text-align: center; padding:20px;"> <span style="border: solid 2px; padding: 10px; border-radius: 10px; color:rgb(255, 70, 70);">รอดำเนินการ</span></td>
                                {{-- <td scope="row" style="color:#9C9C9C; text-align: left; padding:20px;"><i class="fa-solid fa-circle" style="color: rgb(255, 70, 70);"></i> รอดำเนินการ</td> --}}
                                @elseif ($status == 'ต้องดำเนินการ')
                                <td scope="row" style="color:#9C9C9C; text-align: center; padding:20px;"><span style="border: solid 2px; padding:10px; border-radius: 10px; color:rgb(255, 182, 11);">ต้องดำเนินการ</span></td>
                                {{-- <td scope="row" style="color:#9C9C9C; text-align: left; padding:20px;"><i class="fa-solid fa-circle" style="color: rgb(251, 183, 23);"></i> ต้องดำเนินการ</td> --}}
                                @elseif ($status == 'ดำเนินการแล้ว')
                                {{-- <td scope="row" style="color:#9C9C9C; text-align: left;"><i class="fa-solid fa-circle" style="color: rgb(4, 181, 30);"></i> ดำเนินการแล้ว</td> --}}
                                <td scope="row" style="color:#9C9C9C; text-align: center; padding:20px;"> <span style="border: solid 2px; padding:10px; border-radius: 10px; color:rgb(58, 174, 19);">ดำเนินการแล้ว</span></td>
                                @else
                                <td scope="row" style="color:#9C9C9C; text-align: center; padding:20px;"> </td>
                                @endif

                                @if(!empty($check_id))
                                @php 
                                $id_purchase = $check_id->firstWhere('customer_id', $customer_code)?->customer_id;
                                @endphp
    
                                @if ($id_purchase == $customer_code)
    
                                @php 
                                $item = $check_purchase->firstWhere('customer_id', $customer_code);
                                @endphp
                                
                                    @if ($item)
                                        @php
                                            $check_over_5 = \Carbon\Carbon::parse($item->date_purchase)->addDays(5)->lessThan(now());
                                            $check_over_7 = \Carbon\Carbon::parse($item->date_purchase)->addDays(7)->lessThan(now());
                                        @endphp
                                    
                                        <td scope="row" style="color:#9C9C9C; text-align: center; padding:20px; width:20%;">
                                            @if ($check_over_7)
                                            <span id="less{{ $customer_code }}" style="cursor: pointer; border: solid 2px; padding: 10px; border-radius: 10px; color:rgb(255, 70, 70);">
                                                ไม่สั่งเกิน 7 วัน
                                            </span>
                                            
                                            <div class="modal fade" style="margin-top:40px;" id="staticBackdrop_normal{{ $customer_code }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <span class="modal-title" id="staticBackdropLabel">ร้านค้า : {{ $customer_code }} | {{ $customer_name }}</span>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        
                                                        <div class="modal-body">
                                                            <div class="mb-2" style="text-align: left;">
                                                                เลขที่: <span id="order-number{{ $customer_code }}"></span> |
                                                                <span style="background-color: #e04b30; color:white; border-radius:5px; padding:3px;" id="date-number{{ $customer_code }}"></span>
                                                            </div>
                                                            <div class="relative overflow-x-auto">
                                                                <table class="w-full text-left">
                                                                    <thead style="background-color:#222222; color:rgb(255, 255, 255);">
                                                                        <tr>
                                                                            <td class="px-6 py-3 text-center">รหัสสินค้า</td>
                                                                            <td class="px-6 py-3">ชื่อสินค้า</td>
                                                                            <td class="px-6 py-3 text-center">หน่วย</td>
                                                                            <td class="px-6 py-3 text-center">จำนวน</td>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="result-area{{ $customer_code }}">
                                                                        <tr>
                                                                            <td colspan="4" class="text-center py-4">กำลังโหลดข้อมูล...</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    
                                                    </div>
                                                </div>
                                            </div>
    
                                                
                                            @elseif ($check_over_5)
                                                <span id="less{{ $customer_code }}" style="cursor: pointer; border: solid 2px; padding: 10px; border-radius: 10px; color:#ffa51d;">
                                                    ใกล้ครบกำหนด
                                                </span>
    
                                                <div class="modal fade" style="margin-top:40px;" id="staticBackdrop_normal{{ $customer_code }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <span class="modal-title" id="staticBackdropLabel">ร้านค้า : {{ $customer_code }} | {{ $customer_name }}</span>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            
                                                            <div class="modal-body">
                                                                <div class="mb-2" style="text-align: left;">
                                                                    เลขที่: <span id="order-number{{ $customer_code }}"></span> |
                                                                    <span style="background-color: #ffa51d; color:white; border-radius:5px; padding:3px;" id="date-number{{ $customer_code }}"></span>
                                                                </div>
                                                                <div class="relative overflow-x-auto">
                                                                    <table class="w-full text-left">
                                                                        <thead style="background-color:#222222; color:rgb(255, 255, 255);">
                                                                            <tr>
                                                                                <td class="px-6 py-3 text-center">รหัสสินค้า</td>
                                                                                <td class="px-6 py-3">ชื่อสินค้า</td>
                                                                                <td class="px-6 py-3 text-center">หน่วย</td>
                                                                                <td class="px-6 py-3 text-center">จำนวน</td>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody id="result-area{{ $customer_code }}">
                                                                            <tr>
                                                                                <td colspan="4" class="text-center py-4">กำลังโหลดข้อมูล...</td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
    
                                                <span id="less{{ $customer_code }}" style="cursor: pointer; border: solid 2px; padding: 10px; border-radius: 10px; color:rgb(51, 197, 14);">
                                                    สั่งซื้อตามปกติ
                                                </span>
    
                                                <div class="modal fade" style="margin-top:40px;" id="staticBackdrop_normal{{ $customer_code }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <span class="modal-title" id="staticBackdropLabel">ร้านค้า : {{ $customer_code }} | {{ $customer_name }}</span>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            
                                                            <div class="modal-body">
                                                                <div class="mb-2" style="text-align: left;">
                                                                    เลขที่: <span id="order-number{{ $customer_code }}"></span> |
                                                                    <span style="background-color: #09be0f; color:white; border-radius:5px; padding:3px;" id="date-number{{ $customer_code }}"></span>
                                                                </div>
                                                                <div class="relative overflow-x-auto">
                                                                    <table class="w-full text-left">
                                                                        <thead style="background-color:#222222; color:rgb(255, 255, 255);">
                                                                            <tr>
                                                                                <td class="px-6 py-3 text-center">รหัสสินค้า</td>
                                                                                <td class="px-6 py-3">ชื่อสินค้า</td>
                                                                                <td class="px-6 py-3 text-center">หน่วย</td>
                                                                                <td class="px-6 py-3 text-center">จำนวน</td>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody id="result-area{{ $customer_code }}">
                                                                            <tr>
                                                                                <td colspan="4" class="text-center py-4">กำลังโหลดข้อมูล...</td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                    @endif
    
                                    <!-- แสดงรายการสินค้าสุดท้าย -->
                                    <script>
                                        $(document).ready(function() {
                                            const use_id = "{{ $customer_code }}";
                                            const modalId = '#staticBackdrop_normal{{ $customer_code }}';
                                    
                                            $('#less{{ $customer_code }}').click(function(e) {
                                                e.preventDefault();
                                    
                                                fetch('/portal/customer/purchase', {
                                                    method: 'POST',
                                                    headers: {
                                                        'Content-Type': 'application/json',
                                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                                    },
                                                    body: JSON.stringify({ use_id: use_id })
                                                })
                                                .then(response => response.json())
                                                .then(data => {
                                                    const resultArea  = document.getElementById('result-area{{ $customer_code }}');
                                                    const orderNumber = document.getElementById('order-number{{ $customer_code }}');
                                                    const datePur     = document.getElementById('date-number{{ $customer_code }}');
                                    
                                                    if (Array.isArray(data.use_id) && data.use_id.length > 0) {
                                                        let rows  = '' ;
                                                        let total = 0 ;
                                                        data.use_id.forEach(item => {
                                                            rows += `
                                                                <tr>
                                                                    <td class="border border-gray-300 px-4 py-2 text-center">${item.product_id}</td>
                                                                    <td class="border border-gray-300 px-4 py-2">${item.product_name}</td>
                                                                    <td class="border border-gray-300 px-4 py-2 text-center">${item.unit}</td>
                                                                    <td class="border border-gray-300 px-4 py-2 text-center">${item.quantity}</td>
                                        
                                                                </tr>
                                                            `;
                                                            po_number     = `${item.purchase_order}`;
                                                            date_purchase = `${item.date_purchase}`;
    
                                                            total += Number(item.total_sale ?? 0);
                                                            
                                                        });
    
                                                            
                                                        rows += `
                                                            <tr>
                                                                <td class="border border-gray-300 px-4 py-2 text-center" colspan="2">รวมเป็นเงิน</td>
                                                                <td class="border border-gray-300 px-4 py-2 text-center" colspan="2">฿${total.toLocaleString('th-TH', { minimumFractionDigits: 2 })}</td>
                                                            </tr>
                                                        `;
                                                                                            
                                                        resultArea.innerHTML  = rows;
                                                        orderNumber.innerHTML = po_number ?? '';
                                                        datePur.innerHTML     = date_purchase ?? '';
                                                    } else {
                                                        resultArea.innerHTML = `
                                                            <tr>
                                                                <td colspan="4" class="text-center text-red-500 py-4">ไม่พบข้อมูล</td>
                                                            </tr>
                                                        `;
                                                        orderNumber.innerHTML = '';
                                                    }
                                    
                                                    // เปิด Modal
                                                    const myModal = new bootstrap.Modal(document.querySelector(modalId));
                                                    myModal.show();
                                                })
                                                .catch(error => {
                                                    console.error('Error:', error);
                                                    const resultArea = document.getElementById('result-area{{ $customer_code }}');
                                                    resultArea.innerHTML = `
                                                        <tr>
                                                            <td colspan="4" class="text-center text-red-500 py-4">เกิดข้อผิดพลาดในการโหลดข้อมูล</td>
                                                        </tr>
                                                    `;
                                                });
                                            });
                                        });
                                    </script>
                                @else
                                    <td scope="row" style="color:#9C9C9C; text-align: center; padding:30px; width:20%;">
                                        <span style="border: solid 2px; padding: 10px; border-radius: 10px; color:rgb(144, 209, 245);">
                                            ไม่มีการสั่งซื้อ
                                        </span>
                                    </td>
                                @endif
                            
                            @endif
                            <td scope="row" style="color:#9C9C9C; text-align: center; padding:20px; ">{{$created_at}}</td>

                            <td scope="row" style="color:#9C9C9C; text-align: center; padding:15px;"><a href="/portal/customer/{{$id}}" id="edit"><i class="fa-regular fa-eye"></i></a>
                            {{-- <button id="trash"><i class="fa-regular fa-trash-can"></i></button> --}}
                            </td>
                        @endif
                    </tr>
            
                    @endforeach
                    @endif
                    </tbody>
                </table>
                </div>
        {{-- {{dd($total_page);}} --}}
                @if($total_page > 1)
                <nav aria-label="Page navigation example">
                    <ul class="pagination py-4">
                    <li class="page-item">

                    @if ($page == 1)
                        <a class="page-link" href="/portal/customer/purchase/normal?page={{ 1 }}" aria-label="Previous">
                        <span aria-hidden="true">Previous</span>
                        </a>
                    @else
                        <a class="page-link" href="/portal/customer/purchase/normal?page={{ $page-1 }}" aria-label="Previous">
                        <span aria-hidden="true">Previous</span>
                        </a>
                    @endif
                    </li>

                    @if($total_page > 14)

                        @for ($i= 1; $i <= 10 ; $i++)
                        <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>" ><a class="page-link" href="/portal/customer/purchase/normal?page={{ $i }}">{{ $i }}</a></li>
                        @endfor
                        <li class="page-item"><a class="page-link">...</a></li>
                        @for ($i= $total_page-1; $i <= $total_page ; $i++)
                            <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>"><a class="page-link" href="/portal/customer/purchase/normal?page={{ $i }}">{{ $i }}</a></li>
                        @endfor

                    @else
                        @for ($i= 1; $i <= $total_page ; $i++)
                        <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>" ><a class="page-link" href="/portal/customer/purchase/normal?page={{ $i }}">{{ $i }}</a></li>
                        @endfor
                    
                    @endif

                    <li class="page-item">
                    
                    @if ($page == $total_page)
                        <a class="page-link" href="/portal/customer/purchase/normal?page={{ $page }}" aria-label="Next">
                        <span aria-hidden="true">next</span>
                        </a>
                    @else
                        <a class="page-link" href="/portal/customer/purchase/normal?page={{ $page + 1 }}" aria-label="Next">
                        <span aria-hidden="true">next</span>
                        </a>
                    @endif
                    </li>
                    </ul>
                </nav>
                @else
                <hr>
                @endif

            </div>
        </div>

        @endsection

        <script>

                $(document).ready(function () {

                    $("#reports").click(function () {
                        console.log("Report");
                        $(this).next('.sub-menus').slideToggle();
                        $(this).find('.dropdown').toggleClass('rotate');
                        $(this).toggleClass("submenu"); // toggle เปิดปิดแถบสีเมนู;
                        // $('.sub-menus').css("background-color", "black", "text-align", "left");
                    

                    });
                
                });

        </script>
</body>
</html>
