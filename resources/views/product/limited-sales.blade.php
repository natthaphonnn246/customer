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
        #alertMenu {
            background-color: none;
            color: rgb(102, 102, 102);
        }
        #alertMenu:hover {
            background-color: rgb(16, 100, 89);
            color: white;
        }
        .tr-hover:hover {
            background-color: rgb(8, 123, 110);
            color: white;
            border-radius: 5px;
        }
  
        .table tbody tr:hover {
            background-color: #f0f0f0; /* สีเมื่อ hover */
            cursor: pointer; /* เปลี่ยน cursor */
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

                <div class="py-2"></div>
                <span class="ms-6" style="color: #8E8E8E;">สินค้าจำกัดขายต่อเดือน | ข.ย.13</span>
                <hr class="my-3" style="color: #8E8E8E; width: 100%; border:solid 3px;">

                <hr class="my-4" style="color: #8E8E8E; width: 100%;">

                <div class="ms-6 mr-6 mb-6" style="text-align: left;">
        
                    <div style="text-align: left;">
                        <span class="ms-6" style="color: #363636; font-size:20px;">สูตร 
                            <span style="text-decoration:underline;">Dextromethorphan</span>
                            ตำรับยาเม็ด สูตรเดี่ยวและผสม ขายรวมกัน 
                            <span style="color:red;">ไม่เกิน 2,000 เม็ด/ร้านค้า/เดือน</span>
                        </span>
                    </div>
        
                    <table class="table table-striped table-bordered table-hover mt-4" style="width: 100%;">
                        <thead>
                            <tr>
                                <th style="color:#838383; text-align:center; vertical-align:middle; font-weight:500; width:2%;">#</th>
                                <th style="color:#838383; text-align:center; vertical-align:middle; font-weight:500; width:5%;">รหัสสินค้า</th>
                                <th style="color:#838383; text-align:center; vertical-align:middle; font-weight:500; width:20%;">ชื่อสินค้า</th>
                                <th style="color:#838383; text-align:center; vertical-align:middle; font-weight:500; width:10%;">ชื่อสามัญทางยา</th>
                                <th style="color:#838383; text-align:center; vertical-align:middle; font-weight:500; width:10%;">หน่วยสินค้า</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($product_dextro) && count($product_dextro) > 0) 
                            @php 
                                $start = 1;
                            @endphp
                            
                            @foreach($product_dextro as $row)
                                <tr class="tr-hover">
        
                                    <td style="text-align: center; color:#6b6b6b;">{{ $start++ }}</td>
                                    <td style="text-align: center; color:#6b6b6b;">{{ $row->product_id }}</td>
                                    <td style="text-align: left; color:#fa5454;">{{ $row->product_name }}</td>
                                    <td style="text-align: left; color:#6b6b6b;">{{ $row->generic_name }}</td>
                                    <td style="text-align: center; color:#6b6b6b;">{{ $row->unit }}</td>
                                </tr>
                            @endforeach
                            @else
                                <td colspan="5" style="text-align: center; color:#6b6b6b;">ไม่พบสินค้าประเภท ร้านค้า: สมุนไพร</td>
                            @endif
                        </tbody>
                            
                    </table>
                
        
                    <!-- viagra -->
                    <div style="text-align: left;">
                        <span class="ms-6" style="color: #363636; font-size:20px;">สูตร 
                            <span style="text-decoration:underline;">Sildenafil, Tadalafil</span>
                            ตำรับยาเม็ด สูตรเดี่ยวและผสม ขายรวมกัน 
                            <span style="color:red;">ไม่เกิน 1,000 เม็ด/ร้านค้า/เดือน</span>
                        </span>
                    </div>
            
                    <table class="table table-striped table-bordered table-hover mt-4" style="width: 100%;">
                        <thead>
                            <tr>
                                <th style="color:#838383; text-align:center; vertical-align:middle; font-weight:500; width:2%;">#</th>
                                <th style="color:#838383; text-align:center; vertical-align:middle; font-weight:500; width:5%;">รหัสสินค้า</th>
                                <th style="color:#838383; text-align:center; vertical-align:middle; font-weight:500; width:20%;">ชื่อสินค้า</th>
                                <th style="color:#838383; text-align:center; vertical-align:middle; font-weight:500; width:10%;">ชื่อสามัญทางยา</th>
                                <th style="color:#838383; text-align:center; vertical-align:middle; font-weight:500; width:10%;">หน่วยสินค้า</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($product_viagra) && count($product_viagra) > 0) 
                            @php 
                                $start = 1;
                            @endphp
                            
                            @foreach($product_viagra as $row_viagra)
                                <tr class="tr-hover">
            
                                    <td style="text-align: center; color:#6b6b6b;">{{ $start++ }}</td>
                                    <td style="text-align: center; color:#6b6b6b;">{{ $row_viagra->product_id }}</td>
                                    <td style="text-align: left; color:#fa5454;">{{ $row_viagra->product_name }}</td>
                                    <td style="text-align: left; color:#6b6b6b;">{{ $row_viagra->generic_name }}</td>
                                    <td style="text-align: center; color:#6b6b6b;">{{ $row_viagra->unit }}</td>
                                </tr>
                            @endforeach
                            @else
                                <td colspan="5" style="text-align: center; color:#6b6b6b;">ไม่พบสินค้าประเภท ร้านค้า: สมุนไพร</td>
                            @endif
                        </tbody>
                            
                    </table>
            </div>
        </div>
@endsection
</body>
</html>
