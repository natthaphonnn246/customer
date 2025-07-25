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

    <title>cms.vmdrug</title>
</head>
<body>

    @extends ('portal/menuportal-tailwind')
    @section('content')
    @csrf


    <style>
        .contentArea {
            padding: 10px;
            background-color: #FFFFFF;
            border-radius: 2px;
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
        #protected {
        position: relative;
        }

        #protected::after {
                    content: "© cms.vmdrug";
                    position: fixed; /* เปลี่ยนจาก absolute → fixed */
                    top: 50%;
                    left: 50%;
                    font-size: 120px;
                    /* color: rgba(234, 43, 43, 0.111); */
                    color: rgba(170, 170, 170, 0.111);
                    pointer-events: none;
                    padding-top: 30px;
                    /* transform: translate(-50%, -50%) rotate(-35deg); */
                     transform: translate(-50%, -50%);
                    white-space: nowrap;
                    z-index: 9999; /* กันโดนซ่อนโดย content อื่น */
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
    
        {{-- @section('col-2')

        @if(isset($user_name))
            <h6 class="mt-1" style="">{{$user_name->name}}</h6>
            @endif
        @endsection --}}

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
    
            <div class="row" id="protected">
                <div class="col-9 py-2">
                    <div style="text-align: left; padding:5px; margin-top:5px;">
                        <span style="color: #8E8E8E;">ข้อมูลลูกค้า (Customer)</span>
                    </div>
                </div>
            
                <hr style="color: #8E8E8E; width: 100%; margin-top: 25px;">

                <!--- search --->
                <form class="max-w-md mx-auto py-3" method="get" action="/portal/customer/search/code">
                    {{-- <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-black">Search</label> --}}
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                           <!---icon -->
                        </div>
                        <input type="search" id="default-search" name="keyword" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-white-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Code/ชื่อร้านค้า" />
                        <button type="submit" class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 my-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">ค้นหา</button>
                    </div>
                    <p id="keyword_search"></p>
                    @csrf   
                </form>

                <script>
                    $(document).ready(function() {
                        $('#default-search').keyup(function() {

                            $.ajax({
                                url: '/portal/customer/area/{{$user_name->admin_area}}/search',
                                method: 'GET',
                                data: {
                                    keyword: $(this).val(),

                                },
                                success: function(data) {
                                    $('#keyword_search').html(data);
                                }
                            });
                           /*  let keyword = $(this).val();
                            console.log(keyword ); */
                        });
                    });
                </script>
              
            </div>

     
        <hr class="py-3" style="color: #8E8E8E; width: 100%;">

        <table class="table table-striped">
            <thead>
              <tr>
                <td scope="col" style="color:#838383; text-align: left; font-weight:500;">#</td>
                <td scope="col" style="color:#838383; text-align: left; font-weight:500;">CODE</td>
                <td scope="col" style="color:#838383; text-align: left; font-weight:500;">อีเมล</td>
                <td scope="col" style="color:#838383; text-align: left; font-weight:500;">Sale area</td>
                <td scope="col" style="color:#838383; text-align: left; font-weight:500;">ชื่อร้านค้า</td>
                <td scope="col" style="color:#838383; text-align: center; font-weight:500;">สถานะ</td>
                <td scope="col" style="color:#838383; text-align: center; font-weight:500;">วันที่ลงทะเบียน</td>
                <td scope="col" style="color:#838383; text-align: center; font-weight:500;">จัดการ</td>
              </tr>
            </thead>
            <tbody>
                @if(isset($admin_area))
                <?php 
                    @$start += 1;
                ?>
                @foreach ($admin_area as $row_area)
              <tr>
                    <?php
                        
                        $customer_name = $row_area->customer_name;
                        $customer_code = $row_area->customer_code;
                        $sale_area = $row_area->sale_area;
                        $status_admin = $row_area->sale_area;
                        $email = $row_area->email;
                        $status = $row_area->status;
                        $created_at = $row_area->created_at;
                        $customer_status = $row_area->customer_status;
                    ?>
                
                @if($customer_status == 'active')
                    <td scope="row" style="color:#9C9C9C; text-align: left; padding:20px; ">{{@$start++}}</td>
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

                    <td scope="row" style="color:#9C9C9C; text-align: center; padding:20px; ">{{$created_at}}</td>

                    <td scope="row" style="color:#9C9C9C; text-align: center; padding:15px;"><a href="/portal/customer/{{$customer_code}}" id="edit"><i class="fa-regular fa-eye"></i></a>
                    {{-- <button id="trash"><i class="fa-regular fa-trash-can"></i></button> --}}
                    </td>
                @endif
              </tr>
    
              @endforeach
              @endif
            </tbody>
          </table>


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
