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
            color: #787878;
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
            color: #787878;
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
            color: #3b25ff;
            text-decoration: underline;
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
    <div class="contentArea w-full max-w-full break-words">

        <div class="py-2">
            {{-- <span style="color: #8E8E8E;"><a href="/webpanel/admin" id="backLink">ข้อมูลแอดมิน (Admin)</a> / แบบฟอร์ม</span> --}}
        </div>
        <span class="ms-6" style="color: #8E8E8E;"><a href="/webpanel/report/product/sales/region?_token={{ request('_token') }}&from={{ request('from') }}&to={{ request('to') }}" id="backLink">ย้อนกลับ</a> / ขายตามภูมิศาสตร์</span>
        {{-- <span class="ms-6" style="color: #8E8E8E;">ขายตามหมวดหมู่สินค้า</span> --}}
        <hr class="my-3" style="color: #8E8E8E; width: 100%; border:solid 3px;">

        <div class="mr-6" style="text-align: right;">

            <a href="/webpanel/report/product/sales/region/exportcsv/view?from={{ request('from') ?? ''}}&to={{ request('to') ?? ''}}&category={{ request('category') ?? ''}}&region={{ request('region') ?? ''}}"  id="exportcsv" class="btn" type="submit"  name="" style="width: 150px; padding: 8px;">Export CSV</a>
            <a href="/webpanel/report/product/sales/region/exportexcel/view?from={{ request('from') ?? ''}}&to={{ request('to') ?? ''}}&category={{ request('category') ?? ''}}&region={{ request('region') ?? ''}}"  id="exportexcel" class="btn" type="submit"  name="" style="width: 150px; padding: 8px;">Export Excel</a>
    
        </div>
        <hr class="my-4" style="color: #8E8E8E; width: 100%;">
        <div class="container"  style="width: 95%;">

            <div class="row ms-2">
 
            </div>

        </div>

            <div class="ms-3 mr-4 mb-2 mt-2">

                <span class="ms-2" style="font-size:16px; padding:5px 10px; border-radius:8px; color:#8a8a8a;"> {{ $category_name?->categories_name ?? '' }} ({{ request('category') }}) | <span style="color:rgb(255, 30, 30);">{{ request('region') }} </span>| {{ request('from') }} ถึง {{ request('to') }}</span>
                <hr class="my-4" style="color: #8E8E8E; width: 100%;">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <td scope="col" style="color:#838383; text-align: center; font-weight: 500; width:5px;">#</td>
                        {{--     <td scope="col" style="color:#838383; text-align: left; font-weight: 500;">CODE</td>
                            <td scope="col" style="color:#838383; text-align: left; font-weight: 500;">ร้านค้า</td> --}}
                            <td scope="col" style="color:#838383; text-align: left; font-weight: 500;">รหัสสินค้า</td>
                            <td scope="col" style="color:#838383; text-align: left; font-weight: 500;">ชื่อสินค้า</td>
                            <td scope="col" style="color:#838383; text-align: right; font-weight: 500;">หน่วย</td>
                            <td scope="col" style="color:#838383; text-align: right; font-weight: 500;">จำนวน</td>
                            <td scope="col" style="color:#838383; text-align: right; font-weight: 500;">ราคา</td>
                            <td scope="col" style="color:#838383; text-align: right; font-weight: 500;">รวมเป็นเงิน</td>
                        </tr>
                        </tr>
                        </tr>
                        </tr>
                    </thead>
                    <tbody>
                        
                        @if(!@empty($sales))
                        @php 
                        
                            $start = 1; 
                            $total = 0;
                        
                        @endphp

                        @foreach ($sales as $row_product)
                        <tr>
                           
                            <td scope="row" style="color:#9C9C9C; text-align: center; padding: 20px 8px 20px; width:5%;">{{ $start++ }}</td>
                          {{--   <td scope="row" style="color:#9C9C9C; text-align: left; padding: 20px 8px 20px; width:10%;">{{ $row_product->customer_id }}</td>
                            <td scope="row" style="color:#9C9C9C; text-align: left; padding: 20px 8px 20px; width:10%;">{{ $row_product->customer_name }}</td> --}}
                            <td scope="row" style="color:#9C9C9C; text-align: left; padding: 20px 8px 20px; width:5%;">{{ $row_product->product_id }}</td>
                            <td scope="row" style="color:#9C9C9C; text-align: left; padding: 20px 8px 20px; width:25%;"><a href="/webpanel/report/product/sales/region/view/item?product={{ $row_product->product_id }}&category={{ request('category') }}&region={{ request('region') }}&from={{ request('from') }}&to={{ request('to') }}">{{ $row_product->product_name }}</a></td>
                            <td scope="row" style="color:#9C9C9C; text-align: right; padding: 20px 8px 20px; width:10%;">{{ $row_product->unit }}</td>
                            <td scope="row" style="color:#9C9C9C; text-align: right; padding: 20px 8px 20px; width:10%;">{{ $row_product->quantity_by }}</td>
                            <td scope="row" style="color:#9C9C9C; text-align: right; padding: 20px 8px 20px; width:10%;">{{ number_format($row_product->average_price,2) }}</td>
                            <td scope="row" style="color:#9C9C9C; text-align: right; padding: 20px 8px 20px; width:10%;">{{ number_format($row_product->total_sales,2) }}</td>

                        </tr>

                        @php 
                            $total += $row_product->total_sales;
                        @endphp
                        @endforeach

                        <tr>
                           
                            <td colspan="6" style="background-color:rgb(227, 227, 227); color:#7d7d7d; text-align: right; font-weight:500; padding: 20px 8px 20px; width:200px;">ยอดรวม (บาท)</td>
                            <td colspan="1" style="background-color:rgb(227, 227, 227); color:#7d7d7d; text-align: right; font-weight:500; padding: 20px 8px 20px; width:200px;">{{ number_format($total,2) }}</td>
    
                        </tr>
                        @endif
                    </tbody>

                </table>
            </div>
    
       
            <hr class="my-3" style="color: #8E8E8E; width: 100%;">

    </div>
@endsection

</body>
</html>
