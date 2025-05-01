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
            background-color:  #dd3e5e;
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
        #backLink {
            color: #3b25ff;
            text-decoration: none;
            cursor: pointer;
        }
        #backLink:hover {
            color: #4330f3;
            text-decoration: underline;
        }
        #backTo {
            background-color: #4355ff;
            color:white;
            padding:10px;
            width: 100px;
            border-radius: 8px;
        }
        #backTo:hover {
            padding:10px;
            width: 100px;
            background-color: #2a3de4;
            border-radius: 8px;
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
        <button class="ms-6" id="backTo" onclick="goBack()">ย้อนกลับ</button>
        {{-- <span  class="ms-6" style="color: #8E8E8E;"><a href="/webpanel/report/seller" id="backLink">การขายสินค้า (Selling merchandise)</a> / รายละเอียด</span> --}}
        <hr class="my-3" style="color: #8E8E8E; width: 100%; border:solid 3px;">

        <script>
        function goBack() {
            window.history.back();
        }
        </script>

        <span class="ms-6" style="color: #747474; font-weight:400;"> รหัสลูกค้า : {{$customer_id ?? 'ไม่ระบุ'}} | {{$customer_name->customer_name ?? 'ไม่พบข้อมูล'}}
             | ขายโดย : {{$customer_name->sale_area ?? 'ไม่มี'}} | แอดมิน : {{$customer_name->admin_area ?? 'ไม่มี'}} | ภูมิศาสตร์ : {{$customer_name->geography ?? 'ไม่มี'}}</span>
        <div class="row ms-6 mr-10 py-2">


                <hr class="my-2" style="color: #8E8E8E; width: 100%;">

                @if(!empty($purchase_order))

                @foreach($purchase_order as $row_po)

                <?php 
                $sum_order = 0;
                ?>
                    <table class="table table-striped ms-2">
                      <thead>
                            <tr>
                                <td scope="col" style="font-weight:500; font-size:16px; color:#7d7d7d; text-align: left; padding: 20px 8px 20px; width:65%;">รายการ</td>
                                <td scope="col" style="font-weight:500; font-size:16px; color:#7d7d7d; text-align: center; padding: 20px 8px 20px; width:100px;">หน่วย</td>
                                <td scope="col" style="font-weight:500; font-size:16px; color:#7d7d7d; text-align: center; padding: 20px 8px 20px; width:100px;">จำนวน</td>
                                <td scope="col" style="font-weight:500; font-size:16px; color:#7d7d7d; text-align: center; padding: 20px 8px 20px; width:100px;">ราคา</td>
                                <td scope="col" style="font-weight:500; font-size:16px; color:#7d7d7d; text-align: center; padding: 20px 8px 20px; width:100px;">รวมเป็นเงิน</td>
                              </tr>
                        </thead>
                        <tbody>

                          {{--   @if($row_po->purchase_order == $order_selling_date->purchase_order)
                            {{$order_selling_date->date_purchase}}
                            @endif --}}
                           {{--  @foreach($order_selling as $row)
                                {{$row->date_purchase}}
                            @endforeach --}}
                                
                            
                          <ul class="py-2 mb-2">
                            <span style="font-weight:500; color:#f33e3e; border:solid; padding:5px; border-radius:5px;">{{$row_po->purchase_order ?? 'ไม่ระบุ'}}</span>
                            <span style="color:#666666;">สั่งซื้อวันที่ : {{$row_po->date_purchase ?? 'ไม่ระบุ'}}</span>
                          </ul>
                         
                            <hr class="my-2" style="color: #8E8E8E; width: 100%;">
       
                            @foreach($order_selling as $row_order)
                            @if($row_po->purchase_order == $row_order->purchase_order)
                            <?php 
                                // $sum_price = $row_order->quantity * number_format($row_order->price,2);
                                $sum_price = $row_order->quantity * $row_order->price;

                                // echo gettype((int)number_format($row_order->price,2));
                            ?>
                    
                          <tr>
                            <td scope="col" style="color:#7d7d7d; text-align: left; padding: 20px 8px 20px; width:65%;">{{$row_order->product_id}} {{$row_order->product_name}}</td>
                            <td scope="col" style="color:#7d7d7d; text-align: center; padding: 20px 8px 20px; width:100px;">{{$row_order->unit}}</td>
                            <td scope="col" style="color:#7d7d7d; text-align: center; padding: 20px 8px 20px; width:100px;">{{$row_order->quantity}}</td>
                            <td scope="col" style="color:#7d7d7d; text-align: center; padding: 20px 8px 20px; width:100px;">{{$row_order->price}}</td>
                            <td scope="col" style="color:#7d7d7d; text-align: center; padding: 20px 8px 20px; width:100px;">{{ number_format($sum_price,2) }}</td>
                          </tr>
                     
                            <?php 
                            // $sum_order = 0;
                            $sum_order += $sum_price;
                            
                            ?>
                            @endif
                            @endforeach
                          <tr>
                           
                            <td colspan="4" style="background-color:rgb(227, 227, 227); color:#7d7d7d; text-align: right; font-weight:500; padding: 20px 8px 20px; width:200px;">ยอดรวม (บาท)</td>
                            <td colspan="1" style="background-color:rgb(227, 227, 227); color:#7d7d7d; text-align: center; font-weight:500; padding: 20px 8px 20px; width:200px;">{{ number_format($sum_order,2) }}</td>
                            {{-- <td colspan="1" style="color:#7d7d7d; text-align: center; padding: 20px 8px 20px; width:200px;">บาท</td> --}}
    
                          </tr>
                      @endforeach
             
                        </tbody>
                      </table>
               
                @endif
           

    </div>
</div>
@endsection
</body>
</html>
