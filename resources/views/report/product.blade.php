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
            background-color: #555eff;
            color: #ffffff;
            border: none;
            cursor: pointer;
            padding: 8px 16px;
            font-size: 16px;
            border-radius: 4px;
            text-align: center;
        }
        #importProduct:hover {
            background-color: #434cf9;
            color: #ffffff;
        }
        #byCategory {
            background-color: #ff68c5;
            color: #ffffff;
            border: none;
            cursor: pointer;
            padding: 8px 16px;
            font-size: 16px;
            border-radius: 4px;
            text-align: center;
        }
        #byCategory:hover {
            background-color: #fa46c7;
            color: #ffffff;
        }
        #byRegion {
            background-color: #727aff;
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
            background-color: #e0923e;
            color: #ffffff;
            border: none;
            cursor: pointer;
            padding: 8px 16px;
            font-size: 16px;
            border-radius: 4px;
            text-align: center;
        }
        #importCate:hover {
            background-color: #dd790e;
            color: #ffffff;
        }
        #importsubCate {
            background-color: #1c79d1;
            color: #ffffff;
            border: none;
            cursor: pointer;
            padding: 8px 16px;
            font-size: 16px;
            border-radius: 4px;
            text-align: center;
        }
        #importsubCate:hover {
            background-color: #075fb2;
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
            color: #656565;
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
            color: #656565;
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
    <div class="contentArea w-full max-w-full break-words">

        <div class="py-2">
            {{-- <span style="color: #8E8E8E;"><a href="/webpanel/admin" id="backLink">ข้อมูลแอดมิน (Admin)</a> / แบบฟอร์ม</span> --}}
        </div>
        <span class="ms-6" style="color: #8E8E8E;">รายงานสินค้าขายดี</span>
        <hr class="my-3" style="color: #8E8E8E; width: 100%; border:solid 3px;">

        <div class="ms-6" style="text-align: left;">
            {{-- <a href="/webpanel/customer/customer-create"  id="admin" class="btn" type="submit"  name="" style="width: 180px; padding: 8px;">เพิ่มลูกค้าใหม่</a> --}}
            <a href="/webpanel/report/product/importproduct"  id="importProduct" class="btn" type="submit"  name="" style="width: 150px; padding: 8px;">Product</a>
            <a href="/webpanel/report/product/importcategory"  id="importCate" class="btn" type="submit"  name="" style="width: 150px; padding: 8px;">Category</a>
            <a href="/webpanel/report/product/importsubcategory"  id="importsubCate" class="btn" type="submit"  name="" style="width: 150px; padding: 8px;">Sub-category</a>
            {{-- @php
                if($_GET['min_seller'])
            @endphp --}}
            <a href="/webpanel/report/product/exportcsv/check?from={{ request('from') ?? ''}}&to={{ request('to') ?? ''}}&category={{ request('category') ?? ''}}&region={{ request('region') ?? ''}}"  id="exportcsv" class="btn" type="submit"  name="" style="width: 150px; padding: 8px;">Export CSV</a>
            <a href="/webpanel/report/product/exportexcel/check?from={{ request('from') ?? ''}}&to={{ request('to') ?? ''}}&category={{ request('category') ?? ''}}&region={{ request('region') ?? ''}}"  id="exportexcel" class="btn" type="submit"  name="" style="width: 150px; padding: 8px;">Export Excel</a>
    
        </div>

        <hr class="my-4" style="color: #8E8E8E; width: 100%;">

        <div class="row ms-6" style="justify-content: left;">
            
            <div class="textbox" style="width: 240px; height: 90px; background-color: #3399ff; border-radius: 10px; text-align: center; margin: 20px 10px; padding: 20px;">
                <span style="color: white; text-align: center;">
                    <span style="font-size:14px;">จำนวนสินค้า</span><br/>
                    {{-- @if (isset($count_purchase_range) || isset($count_customer_range)) --}}
                    <span>{{$total_quantity ?? 0}}</span>
                </span>
            </div>
              

            <div class="textbox" style="width: 240px; height: 90px; background-color: #3399ff; border-radius: 10px; text-align: center; margin: 20px 10px; padding: 20px;">
                <span style="color: white; text-align: center;">
                    <a href="" style="text-decoration: none; color:white; font-size:14px;">มูลค่า</a><br/>
                    <span>{{number_format($product_value,2) ?? 0}}</span>
                </span>
            </div>

     {{--        <div class="textbox" style="width: 240px; height: 90px; background-color: #3399ff; border-radius: 10px; text-align: center; margin: 20px 10px; padding: 20px;">
                <span style="color: white; text-align: center;">
                    <a href="" style="text-decoration: none; color:white; font-size:14px;">ยอดรวม</a><br/>
                    <span>{{0}}</span>
                </span>
            </div> --}}


        </div>
        <hr class="my-3" style="color: #8E8E8E; width: 100%;">
        <!--- search --->
  
        <div class="ms-4"  style="width: 95%;">

            <div class="row ms-2">
                {{-- <form method="get" action="/webpanel/report/product/search"> --}}
                <form method="get" action="/webpanel/report/product">
                    @csrf
                    <div class="row">
                        <div class="row mt-2">
                            <div class="col-sm-5">
                                <label class="py-2" for="from">หมวดหมู่ยา : </label>
                                <select name="category" style="border:solid 1px rgb(208, 208, 208); padding: 10px; border-radius:7px; width:98%; color:#9d9d9d; font-size:14px;">
                                    <option value=""> -- เลือกหมวดหมู่ยา -- </option>
                                    @foreach($categories as $category)
                                        <option {{(request('category') ?? '') == $category->categories_id ? 'selected': ''}}  value="{{ $category->categories_id }}">{{ $category->categories_name.' '.'('.$category->categories_id.')' }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-5">
                                <label class="py-2" for="to">ภูมิศาสตร์ : </label>
                                <select name="region" style="border:solid 1px rgb(208, 208, 208); padding: 10px; border-radius:7px; width:96%; color:#9d9d9d; font-size:14px;">
                                    <option value=""> -- เลือกภูมิศาตร์ -- </option>
                                    <option {{(request('region') ?? '') == "ภาคเหนือ" ? 'selected': ''}}  value="ภาคเหนือ">ภาคเหนือ</option>
                                    <option {{(request('region') ?? '') == "ภาคกลาง" ? 'selected': ''}}  value="ภาคกลาง">ภาคกลาง</option>
                                    <option {{(request('region') ?? '') == "ภาคตะวันออก" ? 'selected': ''}}  value="ภาคตะวันออก">ภาคตะวันออก</option>
                                    <option {{(request('region') ?? '') == "ภาคตะวันออกเฉียงเหนือ" ? 'selected': ''}}  value="ภาคตะวันออกเฉียงเหนือ">ภาคตะวันออกเฉียงเหนือ</option>
                                    <option {{(request('region') ?? '') == "ภาคตะวันตก" ? 'selected': ''}}  value="ภาคตะวันตก">ภาคตะวันตก</option>
                                    <option {{(request('region') ?? '') == "ภาคใต้" ? 'selected': ''}}  value="ภาคใต้">ภาคใต้</option>
                                </select>
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

            <div class="mt-6" style="text-align: left;">
                {{-- <a href="/webpanel/customer/customer-create"  id="admin" class="btn" type="submit"  name="" style="width: 180px; padding: 8px;">เพิ่มลูกค้าใหม่</a> --}}
                <a href="/webpanel/report/product/sales/category"  id="byCategory" class="btn" type="submit"  name="" style="width: 200px; padding: 8px;">ขายตามหมวดหมู่ยา</a>
                <a href="/webpanel/report/product/sales/region"  id="byRegion" class="btn" type="submit"  name="" style="width: 200px; padding: 8px;">ขายตามภูมิศาสตร์</a>
        
            </div>


        </div>

            <div class="ms-3 mr-4 mb-2 mt-10">

                <span class="ms-2" style="font-size:18px; color:#202020;">สินค้าขายดี :</span>
                <hr class="my-3" style="color: #8E8E8E; width: 100%;">
                <table class="table table-striped">
                    <thead>
                        
                    <tr>
                        <td scope="col" style="color:#838383; text-align: center; font-weight: 500;">#</td>
                        <td scope="col" style="color:#838383; text-align: left; font-weight: 500;">รหัสสินค้า</td>
                        <td scope="col" style="color:#838383; text-align: left; font-weight: 500;">สินค้า</td>
                        <td scope="col" style="color:#838383; text-align: left; font-weight: 500;">หมวดหมู่</td>
                        <td scope="col" style="color:#838383; text-align: left; font-weight: 500;">หมวดหมู่ย่อย</td>
                        <td scope="col" style="color:#838383; text-align: center; font-weight: 500;">หน่วยสินค้า</td>
                        <td scope="col" style="color:#838383; text-align: center; font-weight: 500;">จำนวน</td>
                        <td scope="col" style="color:#838383; text-align: center; font-weight: 500;">ยอดรวม</td>
                        <td scope="col" style="color:#838383; text-align: center; font-weight: 500;">เฉลี่ยต่อหน่วย</td>
                        <td scope="col" style="color:#838383; text-align: center; font-weight: 500;">ต้นทุน</td>
                        <td scope="col" style="color:#838383; text-align: center; font-weight: 500;">กำไร</td>
                        <td scope="col" style="color:#838383; text-align: center; font-weight: 500;">จัดการ</td>
                    </tr>
                    </thead>
                    <tbody>

                @if(!empty($report_product))

                        @php $start = ($start ?? 0) + 1; @endphp

                        @foreach ($report_product as $row)
                    <tr>
                            <?php
                                
                                $id = $row->id;
                                // $user_name = $row->customer_name;
                                $product_code = $row->product_id;
                                $product_name = $row->product_name;
                                $category = $row->category;
                                $sub_category = $row->sub_category;
                                $quantity = $row->quantity_by;
                                $total_sales = $row->total_sales;
                                $avg_cost = $row->average_cost;
                                $purchase_order = $row->purchase_order;
                                $category_name = $row->categories_name;
                                $subcategory_name = $row->subcategories_name;
                                $unit = $row->unit;
                                
                                $region = $row->geography;

                                $price_unit = (int)$total_sales/$quantity;

                              /*   if($price_unit < 1) {
                                    echo $product_code;
                                } */

                                if($price_unit > 0) {
                                    $margin = (($price_unit - $avg_cost)/$price_unit) * 100;

                                } else {
                                    $margin = 0;
                                }
                                
                            ?>
                        
                        <td scope="row" style="color:#9C9C9C; text-align: center; padding: 20px 8px 20px;">{{$start++}}</td>
                        <td scope="row" style="color:#9C9C9C; text-align: center; padding: 20px 8px 20px;">{{$product_code}}</td>
                        <td scope="row" style="color:#9C9C9C; text-align: left; padding: 20px 8px 20px;">{{$product_name ??= 'ไม่พบข้อมูล'}}</td>
                        <td scope="row" style="color:#9C9C9C; text-align: left; padding: 20px 8px 20px;">{{ $category_name && $category ? $category_name . ' (' . $category . ')' : 'ไม่พบข้อมูล' }}</td>
                        <td scope="row" style="color:#9C9C9C; text-align: left; padding: 20px 8px 20px;">{{ $subcategory_name && $sub_category ? $subcategory_name . ' (' . $sub_category . ')' : 'ไม่พบข้อมูล' }}</td>
                        <td scope="row" style="color:#9C9C9C; text-align: center; padding: 20px 8px 20px;">{{$unit ??= 'ไม่พบข้อมูล'}}</td>
                        <td scope="row" style="color:#9C9C9C; text-align: center; padding: 20px 8px 20px;">{{$quantity ??= 'ไม่พบข้อมูล'}}</td>
                        <td scope="row" style="color:#9C9C9C; text-align: center; padding: 20px 8px 20px;">{{$total_sales ??= 'ไม่พบข้อมูล'}}</td>
                        <td scope="row" style="color:#9C9C9C; text-align: center; padding: 20px 8px 20px;">{{number_format($price_unit,2)}}</td>
                        <td scope="row" style="color:#9C9C9C; text-align: center; padding: 20px 8px 20px;">{{number_format($avg_cost,2)}}</td>
                        <td scope="row" style="color:#9C9C9C; text-align: center; padding: 20px 8px 20px;">{{number_format($margin,2)}}</td>
                        <td scope="row" style="color:#9C9C9C; text-align: center; padding: 20px 8px 20px; width: 10%;">
                            <a href="/webpanel/product/product-detail/{{$product_code}}?from={{ request('from') ?? ''}}&to={{ request('to') ?? ''}}&category={{ request('category') ?? ''  }}&region={{ request('region') ?? '' }}" id="edit"><i class="fa-regular fa-eye"></i></a>

                        </td>
                        </tr>

    
                    @endforeach
                    @endif
                    
                    </tbody>

                </table>
            </div>
    
        @if($total_page > 0)
                @if(request()->filled('from') && request()->filled('to')) <!-- ปลอดภัยกว่า -->
                    <div class="ms-6">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                            <li class="page-item">

                            @if ($page == 1)
                                <a class="page-link" href="/webpanel/report/product?_token={{ request('_token') }}&from={{ request('from') }}&to={{ request('to')}}&category={{ request('category') }}&region={{ request('region') }}&page={{ 1 }}" aria-label="Previous">
                                <span aria-hidden="true">Previous</span>
                                </a>
                            @else
                            <a class="page-link" href="/webpanel/report/product?_token={{ request('_token') }}&from={{ request('from') }}&to={{ request('to')}}&category={{ request('category') }}&region={{ request('region') }}&page={{ $page - 1 }}" aria-label="Previous">
                                <span aria-hidden="true">Previous</span>
                                </a>
                            @endif
                            </li>

                            @if($total_page > 14)

                                @for ($i= 1; $i <= 10 ; $i++)
                                <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>" ><a class="page-link" href="/webpanel/report/product?_token={{ request('_token') }}&from={{ request('from') }}&to={{ request('to')}}&category={{ request('category') }}&region={{ request('region') }}&page={{ $i }}">{{ $i }}</a></a></li>
                                @endfor
                                <li class="page-item"><a class="page-link">...</a></li>
                                @for ($i= $total_page-1; $i <= $total_page ; $i++)
                                    <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>"><a class="page-link" href="/webpanel/report/product?_token={{ request('_token') }}&from={{ request('from') }}&to={{ request('to')}}&category={{ request('category') }}&region={{ request('region') }}&page={{ $i }}">{{ $i }}</a></a></li>
                                @endfor

                            @else
                                @for ($i= 1; $i <= $total_page ; $i++)
                                <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>" ><a class="page-link" href="/webpanel/report/product?_token={{ request('_token') }}&from={{ request('from') }}&to={{ request('to')}}&category={{ request('category') }}&region={{ request('region') }}&page={{ $i }}">{{ $i }}</a></li>
                                @endfor
                            
                            @endif

                            <li class="page-item">
                            
                            @if ($page == $total_page)
                                <a class="page-link" href="/webpanel/report/product?_token={{ request('_token') }}&from={{ request('from') }}&to={{ request('to')}}&category={{ request('category') }}&region={{ request('region') }}&page={{ $page }}" aria-label="Next">
                                <span aria-hidden="true">next</span>
                                </a>
                            @else
                            <a class="page-link" href="/webpanel/report/product?_token={{ request('_token') }}&from={{ request('from') }}&to={{ request('to')}}&category={{ request('category') }}&region={{ request('region') }}&page={{ $page + 1 }}" aria-label="Next">
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
                                <a class="page-link" href="/webpanel/report/product?page={{ 1 }}" aria-label="Previous">
                                <span aria-hidden="true">Previous</span>
                                </a>
                            @else
                                <a class="page-link" href="/webpanel/report/product?page={{ $page - 1 }}" aria-label="Previous">
                                <span aria-hidden="true">Previous</span>
                                </a>
                            @endif
                            </li>

                            @if($total_page > 14)

                                @for ($i= 1; $i <= 10 ; $i++)
                                <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>" ><a class="page-link" href="/webpanel/report/product?page={{ $i }}">{{ $i }}</a></li>
                                @endfor
                                <li class="page-item"><a class="page-link">...</a></li>
                                @for ($i= $total_page-1; $i <= $total_page ; $i++)
                                    <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>"><a class="page-link" href="/webpanel/report/product?page={{ $i }}">{{ $i }}</a></li>
                                @endfor

                            @else
                                @for ($i= 1; $i <= $total_page ; $i++)
                                <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>" ><a class="page-link" href="/webpanel/report/product?page={{ $i }}">{{ $i }}</a></li>
                                @endfor
                            
                            @endif

                            <li class="page-item">
                            
                            @if ($page == $total_page)
                                <a class="page-link" href="/webpanel/report/product?page={{ $page }}" aria-label="Next">
                                <span aria-hidden="true">next</span>
                                </a>
                            @else
                                <a class="page-link" href="/webpanel/report/product?page={{ $page + 1 }}" aria-label="Next">
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
