<!DOCTYPE html>
<html lang="en">
    @section ('title', 'importcustomer')
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
            /* min-width: 1300px; */
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
        #importProductUpdate {
            background-color: #007bff;
            color: #ffffff;
            border: none;
            cursor: pointer;
            padding: 8px 16px;
            font-size: 16px;
            border-radius: 4px;
            text-align: center;
        }
        #importProductUpdate:hover {
            background-color: #0b59f6;
            color: #ffffff;
        }
        #importProductMaster {
            background-color: #f9a723;
            color: #ffffff;
            border: none;
            cursor: pointer;
            padding: 8px 16px;
            font-size: 16px;
            border-radius: 4px;
            text-align: center;
        }
        #importProductMaster:hover {
            background-color: #f19603;
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
        #createProduct {
            background-color: #6ccf5b;
            color: #ffffff;
            border: none;
            cursor: pointer;
            padding: 8px 16px;
            font-size: 16px;
            border-radius: 4px;
            text-align: center;
        }
        #createProduct:hover {
            background-color:  #3ec027;
            color: #ffffff;
        }
        #updateProduct {
            background-color: #9f9f9f;
            color: #ffffff;
            border: none;
            cursor: pointer;
            padding: 8px 16px;
            font-size: 16px;
            border-radius: 4px;
            text-align: center;
        }
        #updateProduct:hover {
            background-color:  #878787;
            color: #ffffff;
        }
        #updateStatus {
            background-color: #bf49ff;
            color: #ffffff;
            border: none;
            cursor: pointer;
            padding: 8px 16px;
            font-size: 16px;
            border-radius: 4px;
            text-align: center;
        }
        #updateStatus:hover {
            background-color:  #a510f6;
            color: #ffffff;
        }
        #updateType {
            background-color: #4998ff;
            color: #ffffff;
            border: none;
            cursor: pointer;
            padding: 8px 16px;
            font-size: 16px;
            border-radius: 4px;
            text-align: center;
        }
        #updateType:hover {
            background-color:  #1375f5;
            color: #ffffff;
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
            </div>
            <span class="ms-6" style="color: #8E8E8E;"><a href="/webpanel/report/product" id="backLink">ย้อนกลับ</a> / นำเข้าไฟล์สินค้า</span>
            {{-- <span class="ms-6" style="color: #8E8E8E;">รายงานการขายสินค้า</span> --}}
            <hr class="my-3" style="color: #8E8E8E; width: 100%; border:solid 3px;">

            <div class="ms-6" style="text-align: left; margin-top: 10px;">
                <span style="color: #e84545;">**นำเข้าไฟล์สินค้า <span style="font-weight: 700; color:#007bff;">Master</span> (Product from db:vmdrug) tb: Products</span>
            </div>

            @error('import_csv')

            <div class="alert alert-danger my-2" role="alert">
                {{ $message ?? '' }}
            </div>
        
            @enderror

            @if (isset($check_import))

                <div class="alert alert-success my-2" role="alert">
                    {{$check_import}}
                </div>

            @endif

            {{-- {{$check_provinces}} --}}
            <div class="ms-6 mr-6" style="text-align: left;">

                <form method="post" id="import" action="/webpanel/report/product/importcsv" enctype="multipart/form-data" style="margin-top: 10px;">
                    @csrf
                    <input type="file"  id="import_csv" name="import_csv" class="form-control text-muted"><br/>
                    <input type="submit" id="importProductUpdate" name="submit_csv" class="btn btn-primary mb-4" value="นำเข้าไฟล์">
                
                </form>
                
                {{-- <hr class="my-3" style="color: #8E8E8E; width: 100%;"> --}}

                @if(Session::get('success_import'))
                <div class="py-4">
                    <ul class="alert alert-success"><i class="fa-solid fa-circle-check" style="color:green;"></i> {{ Session::get('success_import') }}</ul>
                </div>
                @endif
            
            </div>

            <hr class="my-3" style="color: #8E8E8E; width: 100%;">


            <div class="ms-6" style="text-align: left; margin-top: 10px;">
                <span style="color: #e84545;">**นำเข้าไฟล์สินค้า <span style="font-weight: 700; color:#007bff;">Update สินค้าใหม่</span> (Product from db:vmdrug) tb: Products</span>
            </div>

            <div class="ms-6 mr-6" style="text-align: left;">

                <form method="post" id="import" action="/webpanel/report/product/importcsv-updated" enctype="multipart/form-data" style="margin-top: 10px;">
                    @csrf
                    <input type="file"  id="import_csv" name="import_csv" class="form-control text-muted"><br/>
                    <input type="submit" id="importProductMaster" name="submit_csv" class="btn btn-primary mb-4" value="นำเข้าไฟล์">
                
                </form>

                @if(Session::get('success_import_updated'))
                <div class="py-4">
                    <ul class="alert alert-success"><i class="fa-solid fa-circle-check" style="color:green;"></i> {{ Session::get('success_import_updated') }}</ul>
                </div>
                @endif

            </div>
               
            <hr class="my-3" style="color: #8E8E8E; width: 100%;">

            <div class="ms-6 mr-6" style="text-align: left;">
                <a href="/webpanel/report/product/new-product"  id="createProduct" class="btn" type="submit"  name="" style="width: 150px; padding: 8px;">เพิ่มสินค้าใหม่</a>
                <a href="/webpanel/report/product/update-cost"  id="updateProduct" class="btn" type="submit"  name="" style="width: 150px; padding: 8px;">อัปเดตต้นทุน</a>
                <a href="/webpanel/report/product/update-status"  id="updateStatus" class="btn" type="submit"  name="" style="width: 150px; padding: 8px;">สถานะสินค้า</a>
                <a href="/webpanel/report/product/update-type"  id="updateType" class="btn" type="submit"  name="" style="width: 150px; padding: 8px;">แบบอนุญาตขายยา</a>

            </div>
            <hr class="my-3" style="color: #8E8E8E; width: 100%;">

            <div class="container"  style="width: 95%;">

                    {{-- <form method="get" action="/webpanel/report/product/search"> --}}
                    <form method="get" action="/webpanel/report/product/importproduct">
                        @csrf
                        <div class="row">
                            <form class="max-w-100 mx-auto mt-2" method="get" action="/webpanel/customer">
                                <ul class="ms-2 my-2">
                                    <span>ค้นหาสินค้า : </span>
                                </ul>
                                {{-- <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-black">Search</label> --}}
                                <div class="relative">
                                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <!---icon -->
                                    </div>
                                    <input type="search" id="default-search" name="keyword" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-white-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="รหัสสินค้า /ชื่อสินค้า" />
                                    <button type="submit" class="mr-4 text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 my-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">ค้นหา</button>
                                
                                </div>
                                <p class="py-2" id="keyword_search"></p>
                            </form>
                        </div>
                    </form>

            </div>

            <div class="ms-3 mr-4 mb-2 mt-10">

                <span class="ms-2" style="font-size:18px; color:#202020;">สินค้าทั้งหมด :</span>
                <hr class="my-3" style="color: #8E8E8E; width: 100%;">
                <table class="table table-striped">
                    <thead>
                        
                    <tr>
                        <td scope="col" style="color:#838383; text-align: center; font-weight: 500;">#</td>
                        <td scope="col" style="color:#838383; text-align: center; font-weight: 500;">รหัสสินค้า</td>
                        <td scope="col" style="color:#838383; text-align: left; font-weight: 500;">สินค้า</td>
                        {{-- <td scope="col" style="color:#838383; text-align: right; font-weight: 500;">หน่วยสินค้า</td> --}}
                        <td scope="col" style="color:#838383; text-align: center; font-weight: 500;">จำนวน</td>
                        <td scope="col" style="color:#838383; text-align: center; font-weight: 500;">ระดับราคา 4</td>
                        <td scope="col" style="color:#838383; text-align: center; font-weight: 500;">ระดับราคา 5</td>
                        <td scope="col" style="color:#838383; text-align: center; font-weight: 500;">ระดับราคา 6</td>
                        <td scope="col" style="color:#838383; text-align: center; font-weight: 500;">ต้นทุน</td>
                        <td scope="col" style="color:#838383; text-align: center; font-weight: 500;">สถานะ</td>
                        <td scope="col" style="color:#838383; text-align: center; font-weight: 500;">จัดการ</td>
                    </tr>
                    </thead>
                    <tbody>

                @if(!empty($product_all))

                        @php $start = ($start ?? 0) + 1; @endphp

                        @foreach ($product_all as $row)
                    <tr>
                            <?php
                                
                                $id = $row->id;
                                // $user_name = $row->customer_name;
                                $product_code = $row->product_id;
                                $product_name = $row->product_name;
                                $unit = $row->unit;
                                $quantity = $row->quantity;
                                $price_1 = $row->price_1;
                                $price_2 = $row->price_2;
                                $price_3 = $row->price_3;
                                $price_4 = $row->price_4;
                                $price_5 = $row->price_5;
                                $cost = $row->cost;
                                $status = $row->status;
                                $category_name = $row->category;
                                $subcategory_name = $row->sub_category;
                                $unit = $row->unit;
                                
                                
                            ?>
                        
    
                        <td scope="row" style="color:#9C9C9C; text-align: center; padding: 20px 8px 20px;">{{$start++}}</td>
                        <td scope="row" style="color:#9C9C9C; text-align: center; padding: 20px 8px 20px; width:5%;">{{$product_code}}</td>
                        <td scope="row" style="color:#9C9C9C; text-align: left; padding: 20px 8px 20px; width:35%;">{{$product_name ??= 'ไม่พบข้อมูล'}}</td>
                        {{-- <td scope="row" style="color:#9C9C9C; text-align: right; padding: 20px 8px 20px;">{{$unit ??= 'ไม่พบข้อมูล'}}</td> --}}
                        <td scope="row" style="color:#9C9C9C; text-align: center; padding: 20px 8px 20px;">{{$quantity}}</td>
                        <td scope="row" style="color:#9C9C9C; text-align: center; padding: 20px 8px 20px;">{{$price_4}}</td>
                        <td scope="row" style="color:#9C9C9C; text-align: center; padding: 20px 8px 20px;">{{$price_5}}</td>
                        <td scope="row" style="color:#9C9C9C; text-align: center; padding: 20px 8px 20px;">{{$price_1}}</td>
                        <td scope="row" style="color:#9C9C9C; text-align: center; padding: 20px 8px 20px;">{{ $cost ?? '0.00' }}</td>
                        <td scope="row" style="color:#9C9C9C; text-align: center; padding: 20px 8px 20px;">{{$status}}</td>
                        <td scope="row" style="color:#9C9C9C; text-align: center; padding: 20px 8px 20px; width: 5%;">
              
                                <a href="/webpanel/report/product/importproduct/{{$id}}" id="edit"><i class="fa-regular fa-eye"></i></a>
   
                                <button class="trash-customer mt-3" style="width:50px;" type="submit" id="trash{{$id}}"><i class="fa-regular fa-trash-can"></i></button>
                      
                        </td>
       
                        </tr>

                        <script>
                                $(document).ready(function() {
        
                                        $('#trash{{$id}}').click(function(e) {

                                            // console.log({{ $id }});
                                            e.preventDefault();
                
                                            let code_del = '{{ $id }}';
        
                                                swal.fire({
                                                    icon: "warning",
                                                    title: "คุณต้องการลบข้อมูลหรือไม่",
                                                    text: '{{$product_code.' '.'('. $product_name.')'}}',
                                                    showCancelButton: true,
                                                    confirmButtonText: "ลบข้อมูล",
                                                    cancelButtonText: "ยกเลิก"
                                                }).then(function(result) {
                                    
                                                if(result.isConfirmed) {
                                                    $.ajax({
                                                    url: '/webpanel/report/product/importproduct/deleted/{{ $id }}',
                                                    type: 'GET',
                                                    success: function(data) {
        
                                                        let check_id = JSON.parse(data);
                                                        console.log(check_id.checkcode);
        
                                                        if(check_id.checkcode == code_del) 
                                                        {
                                                            swal.fire({
                                                                icon: "success",
                                                                title: "ลบข้อมูลสำเร็จ",
                                                                showConfirmButton: true,
                                                            
                                                            }).then (function(result) {
                                                                window.location.reload();
                                                            });
                                                            
                                                        } else {
                                                            Swal.fire({
                                                                icon: "error",
                                                                title: "เกิดข้อผิดพลาด",
                                                                text: 'ไม่พบข้อมูล {{$product_code.' '.'('. $product_name.')'}}',
                                                                showConfirmButton: true,
                                                            });
                                                        }
        
                                                    },
        
                                                });
        
                                            } //iscomfirmed;
                                
                                        });   
        
                                    });
                                
                                });
        
                    </script>
                    @endforeach
                    @endif
                    
                    </tbody>

                </table>
            </div>

            @if($total_page > 0)
                @if(request()->filled('keyword')) <!-- ปลอดภัยกว่า -->
                    <div class="ms-6">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                            <li class="page-item">

                            @if ($page == 1)
                                <a class="page-link" href="/webpanel/report/product/importproduct?_token={{ request('_token') }}&keyword={{ request('keyword') }}&page={{ 1 }}" aria-label="Previous">
                                <span aria-hidden="true">Previous</span>
                                </a>
                            @else
                            <a class="page-link" href="/webpanel/report/product/importproduct?_token={{ request('_token') }}&keyword={{ request('keyword') }}&page={{ $page - 1 }}" aria-label="Previous">
                                <span aria-hidden="true">Previous</span>
                                </a>
                            @endif
                            </li>

                            @if($total_page > 14)

                                @for ($i= 1; $i <= 10 ; $i++)
                                <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>" ><a class="page-link" href="/webpanel/report/product/importproduct?_token={{ request('_token') }}&keyword={{ request('keyword') }}&page={{ $i }}">{{ $i }}</a></a></li>
                                @endfor
                                <li class="page-item"><a class="page-link">...</a></li>
                                @for ($i= $total_page-1; $i <= $total_page ; $i++)
                                    <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>"><a class="page-link" href="/webpanel/report/product/importproduct?_token={{ request('_token') }}&keyword={{ request('keyword') }}&page={{ $i }}">{{ $i }}</a></a></li>
                                @endfor

                            @else
                                @for ($i= 1; $i <= $total_page ; $i++)
                                <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>" ><a class="page-link" href="/webpanel/report/product/importproduct?_token={{ request('_token') }}&keyword={{ request('keyword') }}&page={{ $i }}">{{ $i }}</a></li>
                                @endfor
                            
                            @endif

                            <li class="page-item">
                            
                            @if ($page == $total_page)
                                <a class="page-link" href="/webpanel/report/product/importproduct?_token={{ request('_token') }}&keyword={{ request('keyword') }}&page={{ $page }}" aria-label="Next">
                                <span aria-hidden="true">next</span>
                                </a>
                            @else
                            <a class="page-link" href="/webpanel/report/product/importproduct?_token={{ request('_token') }}&keyword={{ request('keyword') }}&page={{ $page + 1 }}" aria-label="Next">
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
                                <a class="page-link" href="/webpanel/report/product/importproduct?page={{ 1 }}" aria-label="Previous">
                                <span aria-hidden="true">Previous</span>
                                </a>
                            @else
                                <a class="page-link" href="/webpanel/report/product/importproduct?page={{ $page - 1 }}" aria-label="Previous">
                                <span aria-hidden="true">Previous</span>
                                </a>
                            @endif
                            </li>

                            @if($total_page > 14)

                                @for ($i= 1; $i <= 10 ; $i++)
                                <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>" ><a class="page-link" href="/webpanel/report/product/importproduct?page={{ $i }}">{{ $i }}</a></li>
                                @endfor
                                <li class="page-item"><a class="page-link">...</a></li>
                                @for ($i= $total_page-1; $i <= $total_page ; $i++)
                                    <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>"><a class="page-link" href="/webpanel/report/product/importproduct?page={{ $i }}">{{ $i }}</a></li>
                                @endfor

                            @else
                                @for ($i= 1; $i <= $total_page ; $i++)
                                <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>" ><a class="page-link" href="/webpanel/report/product/importproduct?page={{ $i }}">{{ $i }}</a></li>
                                @endfor
                            
                            @endif

                            <li class="page-item">
                            
                            @if ($page == $total_page)
                                <a class="page-link" href="/webpanel/report/product/importproduct?page={{ $page }}" aria-label="Next">
                                <span aria-hidden="true">next</span>
                                </a>
                            @else
                                <a class="page-link" href="/webpanel/report/product/importproduct?page={{ $page + 1 }}" aria-label="Next">
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
</body>
</html>
