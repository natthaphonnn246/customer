<!DOCTYPE html>
<html lang="en">
    @section ('title', 'customer')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">



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
            min-width: 1600px;
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
        #protected {
        position: relative;
        }

        #protected::after {
                    content: "© cms.vmdrug";
                    position: fixed; /* เปลี่ยนจาก absolute → fixed */
                    top: 55%;
                    left: 60%;
                    font-size: 120px;
                    color: rgba(170, 170, 170, 0.111);
                    pointer-events: none;
                    padding-top: 30px;
                    /* transform: translate(-50%, -50%) rotate(-45deg); */
                    transform: translate(-50%, -50%);
                    white-space: nowrap;
                    z-index: 9999; /* กันโดนซ่อนโดย content อื่น */
        }
        .disabled-link {
            pointer-events: none;   /* กดไม่ได้ */
            opacity: 0.4;           /* ทำให้ปุ่มจางลง */
            cursor: not-allowed;    /* เมาส์เป็นรูปห้าม */
            text-decoration: none;  /* เอาเส้นใต้ลิงก์ออก (ถ้าอยากให้ดูเหมือนปุ่ม) */
        }
        .modal-body {
        max-height: 60vh;
        overflow-y: auto;
        }
        #khoryor {
            background-color: #3399ff;
            color: rgb(102, 102, 102);
            
        }
        #khoryor:hover {
            background-color:#3399ff;
            color: white;
        }
        #somphor {
            background-color: #3399ff;
            color: rgb(102, 102, 102);
            
        }
        #somphor:hover {
            background-color:#3399ff;
            color: white;
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


    </style>

    {{-- <div class="contentArea"> --}}
       
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



    <div class="contentArea w-full max-w-full break-words py-4" >

        {{-- <div class="py-2"></div> --}}
        <span class="ms-6" style="color: #8E8E8E;">ประเภทร้านค้า : ข.ย.2/สมุนไพร</span>
        <hr class="my-3" style="color: #8E8E8E; width: 100%; border:solid 3px;">

        <hr class="my-4" style="color: #8E8E8E; width: 100%;">

        <div class="ms-6 mr-6 mb-6" style="text-align: left;" id=protected>

            <div style="text-align: left;">
                <span class="ms-6" style="color: #363636; font-size:20px; font-weight:500;">
                    ประเภทร้านค้า (ข.ย.2)
                </span>
            </div>

            <table class="table table-striped table-bordered table-hover mt-4" style="width: 100%;">
                <thead>
                    <tr>
                        <th style="color:#838383; text-align:center; vertical-align:middle; font-weight:500; width:2%;">#</th>
                        <th style="color:#838383; text-align:center; vertical-align:middle; font-weight:500; width:5%;">รหัสร้านค้า</th>
                        <th style="color:#838383; text-align:center; vertical-align:middle; font-weight:500; width:15%;">ชื่อร้านค้า</th>
                        <th style="color:#838383; text-align:center; vertical-align:middle; font-weight:500; width:5%;">แบบอนุญาต</th>
                        <th style="color:#838383; text-align:center; vertical-align:middle; font-weight:500; width:5%;">แอดมิน</th>
                        <th style="color:#838383; text-align:center; vertical-align:middle; font-weight:500; width:5%;">เขตการขาย</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($customer_type) && count($customer_type) > 0) 
                    @php 
                        $start = 1;
                    @endphp
                    
                    @foreach($customer_type as $row)
                        <tr class="tr-hover">

                            <td style="text-align: center; color:#6b6b6b;">{{ $start++ }}</td>
                            <td style="text-align: center; color:#6b6b6b;">{{ $row->customer_id }}</td>
                            <td style="text-align: left; color:#4aa1ff;">{{ $row->customer_name }}</td>
                            <td style="text-align: center; color:#6b6b6b;">{{ $row->type }}</td>
                            <td style="text-align: center; color:#6b6b6b;">{{ $row->admin_area }}</td>
                            <td style="text-align: center; color:#6b6b6b;">{{ $row->sale_area }}</td>
                        </tr>
                    @endforeach
                    @else
                        <td colspan="5" style="text-align: center; color:#6b6b6b;">ไม่พบประเภทร้านค้า: สมุนไพร</td>
                    @endif
                </tbody>
                    
            </table>
        
        </div>

        <!-- somphor -->
        <div class="ms-6 mr-6 mb-6" style="text-align: left;" id=protected>
        <div style="text-align: left;">
            <span class="ms-6" style="color: #363636; font-size:20px; font-weight:500;">
                ประเภทร้านค้า (สมุนไพร)
            </span>
        </div>

        <table class="table table-striped table-bordered table-hover mt-4" style="width: 100%;">
            <thead>
                <tr>
                    <th style="color:#838383; text-align:center; vertical-align:middle; font-weight:500; width:2%;">#</th>
                    <th style="color:#838383; text-align:center; vertical-align:middle; font-weight:500; width:5%;">รหัสร้านค้า</th>
                    <th style="color:#838383; text-align:center; vertical-align:middle; font-weight:500; width:15%;">ชื่อร้านค้า</th>
                    <th style="color:#838383; text-align:center; vertical-align:middle; font-weight:500; width:5%;">แบบอนุญาต</th>
                    <th style="color:#838383; text-align:center; vertical-align:middle; font-weight:500; width:5%;">แอดมิน</th>
                    <th style="color:#838383; text-align:center; vertical-align:middle; font-weight:500; width:5%;">เขตการขาย</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($customer_type_somphor) && count($customer_type_somphor) > 0) 
                @php 
                    $start = 1;
                @endphp
                
                @foreach($customer_type_somphor as $row_somphor)
                    <tr class="tr-hover">

                        <td style="text-align: center; color:#6b6b6b;">{{ $start++ }}</td>
                            <td style="text-align: center; color:#6b6b6b;">{{ $row_somphor->customer_id }}</td>
                            <td style="text-align: left; color:#01b24e;">{{ $row_somphor->customer_name }}</td>
                            <td style="text-align: center; color:#6b6b6b;">{{ $row_somphor->type }}</td>
                            <td style="text-align: center; color:#6b6b6b;">{{ $row_somphor->admin_area }}</td>
                            <td style="text-align: center; color:#6b6b6b;">{{ $row_somphor->sale_area }}</td>
                    </tr>
                @endforeach
                @else
                    <td colspan="5" style="text-align: center; color:#6b6b6b;">ไม่พบประเภทร้านค้า: สมุนไพร</td>
                @endif
            </tbody>
                
        </table>
    </div>
    </div>
    </div>
       
@endsection

</div>
</body>
</html>
