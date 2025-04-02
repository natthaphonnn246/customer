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
            /* min-width: 1200px; */
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
            background-color: #ce9af4;
            color: #ffffff;
            border: none;
            cursor: pointer;
            padding: 8px 16px;
            font-size: 16px;
            border-radius: 4px;
            text-align: center;
        }
        #importMaster:hover {
            background-color:  #ae66e0;
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
    </style>
    
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

    


    <div class="contentArea">
   {{--  --}}
    
   
        <div class="py-2">
            {{-- <span style="color: #8E8E8E;"><a href="/webpanel/admin" id="backLink">ข้อมูลแอดมิน (Admin)</a> / แบบฟอร์ม</span> --}}
        </div>
        <span class="ms-6" style="color: #8E8E8E;">สถานะการออนไลน์แอดมิน (Admin Status Online)</span>
        <hr class="my-3" style="color: #8E8E8E; width: 100%; border:solid 3px;">

        <div class="ms-6 mr-6 mb-2">
            <hr class="mt-4 py-2" style="color: #8E8E8E; width: 100%;">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <td scope="col" style="color:#838383; text-align: center; font-weight: 500;">#</td>
                        <td scope="col" style="color:#838383; text-align: center; font-weight: 500;">CODE</td>
                        <td scope="col" style="color:#838383; text-align: left;  font-weight: 500;">อีเมล</td>
                        <td scope="col" style="color:#838383; text-align: left; font-weight: 500;">ชื่อร้านค้า</td>
                        <td scope="col" style="color:#838383; text-align: left; font-weight: 500;">เข้าระบบล่าสุด</td>
                        <td scope="col" style="color:#838383; text-align: left; font-weight: 500;">สถานะ</td>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        @$start += 1;
                    ?>

                    @if(isset($check_row))
                    @foreach($check_row as $row)

                    <?php
                    
                        $count_time = (time() - (intval($row->last_activity)))/60;
                    ?>

        

                    @if((time() - (intval($row->last_activity))) < 300)
                    <tr>
                        <td scope="row" style="color:#9C9C9C; text-align: center; width: 5%; padding:20px;">{{$start++}}</td>
                        <td scope="row" style="color:#9C9C9C; text-align: center; width: 15%; padding:20px;">{{$row->user_id}}</td>
                        <td scope="row" style="color:#9C9C9C; text-align: left; width: 15%; padding: 20px 8px 20px;">{{$row->email}}</td>
                        <td scope="row" style="color:#9C9C9C; text-align: left; width: 20%; padding: 20px 8px 20px;">{{$row->name}}</td>
                        <td scope="row" style="color:#9C9C9C; text-align: left; width: 20%; padding: 20px 8px 20px">{{$row->login_date}}</td>
                        <td scope="row" style="color:#9C9C9C; text-align: left; width: 20%; padding: 20px 8px 20px"><i class="fa-solid fa-circle" style="color: #03ae3f; font-size:18px;"></i> ออนไลน์ </td>
                    </tr>
                    @elseif ($count_time < 59)
          
                    <tr>
                        <td scope="row" id="offline" style="color:#9C9C9C; text-align: center; width: 5%; padding:20px;">{{$start++}}</td>
                        <td scope="row" id="offline"  style="color:#9C9C9C; text-align: center; width: 15%; padding:20px;">{{$row->user_id}}</td>
                        <td scope="row" id="offline"  style="color:#9C9C9C; text-align: left; width: 15%; padding: 20px 8px 20px;">{{$row->email}}</td>
                        <td scope="row" id="offline"  style="color:#9C9C9C; text-align: left; width: 20%; padding: 20px 8px 20px;">{{$row->name}}</td>
                        <td scope="row" style="color:#9C9C9C; text-align: left; width: 20%; padding: 20px 8px 20px">{{$row->login_date}}</td>
                        <td scope="row" id="offline"  style="color:#9C9C9C; text-align: left; width: 20%; padding: 20px 8px 20px;"><i class="fa-solid fa-circle" style="color: #ee2c2c; font-size:18px;"></i> ออฟไลน์เมื่อ <span>{{number_format($count_time,0)}} นาทีที่แล้ว</span></td>
                    </tr>
                    
                    @else

                    <tr>
                        <td scope="row" id="offline" style="color:#9C9C9C; text-align: center; width: 5%; padding:20px;">{{$start++}}</td>
                        <td scope="row" id="offline"  style="color:#9C9C9C; text-align: center; width: 15%; padding:20px;">{{$row->user_id}}</td>
                        <td scope="row" id="offline"  style="color:#9C9C9C; text-align: left; width: 15%; padding: 20px 8px 20px;">{{$row->email}}</td>
                        <td scope="row" id="offline"  style="color:#9C9C9C; text-align: left; width: 20%; padding: 20px 8px 20px;">{{$row->name}}</td>
                        <td scope="row" style="color:#9C9C9C; text-align: left; width: 20%; padding: 20px 8px 20px">{{$row->login_date}}</td>
                        <td scope="row" id="offline"  style="color:#9C9C9C; text-align: left; width: 20%; padding: 20px 8px 20px;"><i class="fa-solid fa-circle" style="color: rgb(193, 193, 193); font-size:18px;"></i> ออฟไลน์ </td>
                    </tr>

                    @endif
                    @endforeach
                    @endif

                </tbody>
            </table>
        </div>

        <div class="py-2"></div>
    </div>
@endsection


<script>


        $(document).ready(function() {
            setInterval(()=>{
                let count = {{time()}};
                console.log(count);
            },5000);
        });
        // location.reload();
  
</script>
               
</body>
</html>
