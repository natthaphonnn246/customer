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
    <div class="contentArea">

        <div class="py-2">
            {{-- <span style="color: #8E8E8E;"><a href="/webpanel/admin" id="backLink">ข้อมูลแอดมิน (Admin)</a> / แบบฟอร์ม</span> --}}
        </div>
        <span class="ms-6" style="color: #8E8E8E;"><a href="/webpanel/report/product" id="backLink">ย้อนกลับ</a> / ขายตามภูมิศาสตร์</span>
        {{-- <span class="ms-6" style="color: #8E8E8E;">ขายตามหมวดหมู่สินค้า</span> --}}
        <hr class="my-3" style="color: #8E8E8E; width: 100%; border:solid 3px;">

        {{-- <hr class="my-4" style="color: #8E8E8E; width: 100%;"> --}}
        <!--- search --->
  
        <div class="ms-4"  style="width: 95%;">

            <div class="row ms-2">
                {{-- <form method="get" action="/webpanel/report/product/search"> --}}
                <form method="get" action="/webpanel/report/product/sales/region">
                    @csrf
                    <div class="row">
                        <div class="row mt-2">
                            <div class="col-sm-5">
                                <label class="py-2" for="from">วันที่เริ่ม : </label>
                                <input type="text" class="block w-full" id="from" style="border:solid 1px rgb(208, 208, 208); padding: 10px; border-radius:7px; width:100%; color:#9d9d9d; font-size:14px;" name="from" value="{{ request('from') == '' ? date('Y-m-d') : request('from') }}">
                            </div>
                            <div class="col-sm-5">
                                <label class="py-2" for="to">ถึงวันที่ : </label>
                                <input type="text" class="block w-full" id="to" style="border:solid 1px rgb(208, 208, 208); padding:10px; border-radius:7px; width:100%; color:#9d9d9d; font-size:14px;" name="to" value="{{ request('to') == '' ? date('Y-m-d') : request('to') }}">
                            </div>
                            <div class="col-sm-2 mt-10">
                                <button type="submit" class="btn btn-primary" style="width:80px; font-size:15px; font-weight:500; padding:8px;">ค้นหา</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>

        @php
             $grouped = $sales->groupBy(function ($item) {
                return $item->categories_name . '|' . $item->categories_id;
            });
            $regions = ['ภาคเหนือ', 'ภาคกลาง','ภาคตะวันออก', 'ภาคตะวันตก', 'ภาคอีสาน', 'ภาคใต้']; // เพิ่มภาคตามจริง
        @endphp
            <div class="ms-3 mr-4 mb-2 mt-10">

                <span class="ms-2" style="font-size:18px; color:#202020;">ภูมิศาสตร์ :</span>
                <hr class="my-3" style="color: #8E8E8E; width: 100%;">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <td scope="col" style="color:#838383; text-align: left; font-weight: 500; width:5px;">#</td>
                            <td scope="col" style="color:#838383; text-align: left; font-weight: 500;">หมวดหมู่</td>
                            <td scope="col" style="color:#838383; text-align: left; font-weight: 500;">ชื่อหมวดหมู่</td>
                            @foreach ($regions as $region)
                            <td scope="col" style="color:#838383; text-align: right; font-weight: 500;"> {{ $region }}</td>
                            @endforeach
                            <td scope="col" style="color:#838383; text-align: right; font-weight: 500;"> รวม </td>
                        </tr>
                    </thead>
                    <tbody>
                        @php 
                        
                            // $start = ($start ?? 0) + 1; 
                            $start = 0;

                         /*    $category_col = $sales->groupBy(function ($item) {
                            return $item->categories_name . '|' . $item->categories_id;
                            }); */

                            $category_cols = $sales->unique('categories_id');
                            
                            $summary = 0;
                            
                        @endphp
                    
               {{--      @foreach ($category_cols as $cols)

                    @php 
                       $cate_id = $cols->categories_id;
                       $cate_name = $cols->categories_name;
                    @endphp

                    @php 

                        // [$name, $id] = explode('|', $key); 

                        $row_north = $sales->where('geography', 'ภาคเหนือ')->where('categories_id', $cate_id);
                        $row_central = $sales->where('geography', 'ภาคกลาง')->where('categories_id', $cate_id);
                        $row_east = $sales->where('geography', 'ภาคตะวันออก')->where('categories_id', $cate_id);
                        $row_west = $sales->where('geography', 'ภาคตะวันตก')->where('categories_id', $cate_id);
                        $row_northeast = $sales->where('geography', 'ภาคตะวันออกเฉียงเหนือ')->where('categories_id', $cate_id);
                        $row_south = $sales->where('geography', 'ภาคใต้')->where('categories_id', $cate_id);
                    
                        $north = $row_north->first()?->total_sales ?? '0.00';
                        $central = $row_central->first()?->total_sales ?? '0.00';
                        $east = $row_east->first()?->total_sales ?? '0.00';
                        $west =  $row_west->first()?->total_sales ?? '0.00';
                        $northeast = $row_northeast->first()?->total_sales ?? '0.00';
                        $south = $row_south->first()?->total_sales ?? '0.00';

                        $total = $north + $central + $east + $west + $northeast + $south;

                        $summary += $total;


                    @endphp

                       <tr>
                            <td scope="row" style="color:#9C9C9C; text-align: left; padding: 20px 8px 20px; width:5%;">{{ $start++ }}</td>
                            <td scope="row" style="color:#9C9C9C; text-align: left; padding: 20px 8px 20px; width:10%;">{{ $cate_id }}</td>
                            <td scope="row" style="color:#9C9C9C; text-align: left; padding: 20px 8px 20px; width:20%;">{{ $cate_name }}</td>

                            <td scope="row" style="color:#9C9C9C; text-align: right; padding: 20px 8px 20px; width:10%;"><a href="/webpanel/report/product/sales/region/view?category={{ $cate_id }}&region={{ 'ภาคเหนือ' }}&from={{ request('from') }}&to={{ request('to') }}">{{ number_format($north,2) }}</a></td>
                            <td scope="row" style="color:#9C9C9C; text-align: right; padding: 20px 8px 20px; width:10%;"><a href="/webpanel/report/product/sales/region/view?category={{ $cate_id }}&region={{ 'ภาคกลาง' }}&from={{ request('from') }}&to={{ request('to') }}">{{ number_format($central,2) }}</a></td>
                            <td scope="row" style="color:#9C9C9C; text-align: right; padding: 20px 8px 20px; width:10%;"><a href="/webpanel/report/product/sales/region/view?category={{ $cate_id }}&region={{ 'ภาคตะวันออก' }}&from={{ request('from') }}&to={{ request('to') }}">{{ number_format($east,2) }}</a></td>
                            <td scope="row" style="color:#9C9C9C; text-align: right; padding: 20px 8px 20px; width:10%;"><a href="/webpanel/report/product/sales/region/view?category={{ $cate_id }}&region={{ 'ภาคตะวันตก' }}&from={{ request('from') }}&to={{ request('to') }}">{{ number_format($west,2) }}</a></td>
                            <td scope="row" style="color:#9C9C9C; text-align: right; padding: 20px 8px 20px; width:10%;"><a href="/webpanel/report/product/sales/region/view?category={{ $cate_id }}&region={{ 'ภาคตะวันออกเฉียงเหนือ' }}&from={{ request('from') }}&to={{ request('to') }}">{{ number_format($northeast,2) }}</a></td>
                            <td scope="row" style="color:#9C9C9C; text-align: right; padding: 20px 8px 20px; width:10%;"><a href="/webpanel/report/product/sales/region/view?category={{ $cate_id }}&region={{ 'ภาคใต้' }}&from={{ request('from') }}&to={{ request('to') }}">{{ number_format($south,2) }}</a></td>

                            <td scope="row" style="color:#9C9C9C; text-align: right; padding: 20px 8px 20px; width:10%;">{{ number_format($total,2) }}</td>
                           
                       </tr>

                    @endforeach

                     <tr>
                           
                        <td colspan="9" style="background-color:rgb(227, 227, 227); color:#7d7d7d; text-align: right; font-weight:500; padding: 20px 8px 20px; width:200px;">ยอดรวม (บาท)</td>
                        <td colspan="1" style="background-color:rgb(227, 227, 227); color:#7d7d7d; text-align: right; font-weight:500; padding: 20px 8px 20px; width:200px;">{{ number_format($summary,2) }}</td>

                      </tr> --}}
                
                    @php 
                        $start = ($start ?? 0) + 1; 
                        $total = 0;
                        $count = 0;
                        $counts = 0;
                   /*      $sum_north     = 0;
                        $sum_central   = 0;
                        $sum_east      = 0;
                        $sum_west      = 0;
                        $sum_northeast = 0;
                        $sum_south     = 0;  */
                    @endphp
                        @foreach ($grouped as $category => $rows)

                        @php 
                            [$name, $id] = explode('|', $category);
                       /*      $region_totals = [];
                            $grand_total = 0; */

                        @endphp

     
                    @php
                        $row_north = $sales->where('geography', 'ภาคเหนือ')->where('categories_id', $id);
                        $row_central = $sales->where('geography', 'ภาคกลาง')->where('categories_id', $id);
                        $row_east = $sales->where('geography', 'ภาคตะวันออก')->where('categories_id', $id);
                        $row_west = $sales->where('geography', 'ภาคตะวันตก')->where('categories_id', $id);
                        $row_northeast = $sales->where('geography', 'ภาคตะวันออกเฉียงเหนือ')->where('categories_id', $id);
                        $row_south = $sales->where('geography', 'ภาคใต้')->where('categories_id', $id);
                    
                        $north = $row_north->first()?->total_sales ?? '0.00';
                        $central = $row_central->first()?->total_sales ?? '0.00';
                        $east = $row_east->first()?->total_sales ?? '0.00';
                        $west =  $row_west->first()?->total_sales ?? '0.00';
                        $northeast = $row_northeast->first()?->total_sales ?? '0.00';
                        $south = $row_south->first()?->total_sales ?? '0.00';

                        $sum_north = ($sum_north ?? 0) + $north;
                        $sum_central = ($sum_central ?? 0) + $central;
                        $sum_east = ($sum_east ?? 0) + $east;
                        $sum_west = ($sum_west ?? 0) + $west;
                        $sum_northeast = ($sum_northeast ?? 0) + $northeast;
                        $sum_south = ($sum_south ?? 0) + $south;
                       /*  $sum_central    += $central;
                        $sum_east       += $east;
                        $sum_west       += $west;
                        $sum_northeast  += $northeast;
                        $sum_south      += $south; */

                        $regions = ['ภาคเหนือ', 'ภาคกลาง', 'ภาคตะวันออก', 'ภาคตะวันตก', 'ภาคตะวันออกเฉียงเหนือ', 'ภาคใต้'];

                        $total_by_region = [];

                        foreach ($regions as $region) {
                            $total_by_region[] = $sales
                                                ->where('geography', $region)
                                                ->where('categories_id', $id)
                                                ->first()?->total_sales ?? 0;
                        }

                        // รวมทั้งหมด
                        $count = array_sum($total_by_region);

                        // dd($count);

                    @endphp

                        
                            <tr>
                                <td scope="row" style="color:#9C9C9C; text-align: left; padding: 20px 8px 20px; width:5%;">{{ $start++ }}</td>
                                <td scope="row" style="color:#9C9C9C; text-align: left; padding: 20px 8px 20px; width:10%;">{{ $id }}</td>
                                <td scope="row" style="color:#9C9C9C; text-align: left; padding: 20px 8px 20px; width:30%;">{{ $name }}</td>
                                @foreach ($regions as $region)
                                    @php
                                        $match = $rows->firstWhere('geography', $region);
                                        $amount = $match ? $match->total_sales : 0;
                                        $total += $amount;
     
                                    @endphp

                                    <td scope="row" style="color:#9C9C9C; text-align: right; padding: 20px 8px 20px; width:10%;"><a href="/webpanel/report/product/sales/region/view?category={{ $id }}&region={{ $region }}&from={{ request('from') }}&to={{ request('to') }}">{{ number_format($amount,2) }}</a></td>

                                @endforeach
                                    <td scope="row" style="color:#9C9C9C; text-align: right; padding: 20px 8px 20px; width:10%;">{{ number_format($count,2) }}</td>
                            </tr>
                        @endforeach

                        <tr>
                           
                            <td colspan="3" style="background-color:rgb(227, 227, 227); color:#7d7d7d; text-align: center; font-weight:500; padding: 20px 8px 20px; width:200px;">ยอดรวม (บาท)</td>
                            <td colspan="1" style="background-color:rgb(227, 227, 227); color:#7d7d7d; text-align: right; font-weight:500; padding: 20px 8px 20px; width:200px;">{{ number_format($sum_north ?? 0,2) }}</td>
                            <td colspan="1" style="background-color:rgb(227, 227, 227); color:#7d7d7d; text-align: right; font-weight:500; padding: 20px 8px 20px; width:200px;">{{ number_format($sum_central ?? 0,2) }}</td>
                            <td colspan="1" style="background-color:rgb(227, 227, 227); color:#7d7d7d; text-align: right; font-weight:500; padding: 20px 8px 20px; width:200px;">{{ number_format($sum_east ?? 0,2) }}</td>
                            <td colspan="1" style="background-color:rgb(227, 227, 227); color:#7d7d7d; text-align: right; font-weight:500; padding: 20px 8px 20px; width:200px;">{{ number_format($sum_west ?? 0,2) }}</td>
                            <td colspan="1" style="background-color:rgb(227, 227, 227); color:#7d7d7d; text-align: right; font-weight:500; padding: 20px 8px 20px; width:200px;">{{ number_format($sum_northeast ?? 0,2) }}</td>
                            <td colspan="1" style="background-color:rgb(227, 227, 227); color:#7d7d7d; text-align: right; font-weight:500; padding: 20px 8px 20px; width:200px;">{{ number_format($sum_south ?? 0,2) }}</td>
                            <td colspan="1" style="background-color:rgb(227, 227, 227); color:#7d7d7d; text-align: right; font-weight:500; padding: 20px 8px 20px; width:200px;">{{ number_format($total,2) }}</td>
    
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
