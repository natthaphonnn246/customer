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
<div id="bg">
    @section('content')
    @csrf


    <style>
        .contentArea {
            /* padding: 10px; */
            background-color: #FFFFFF;
            border-radius: 2px;
            /* min-width: 1200px; */
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
        #importCustomer {
            background-color: #007bff;
            color: #ffffff;
            border: none;
            cursor: pointer;
            padding: 8px 16px;
            font-size: 16px;
            border-radius: 4px;
            text-align: center;
        }
        #importCustomer:hover {
            background-color: #0b59f6;
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
        #backLink {
            color: #3b25ff;
            text-decoration: none;
            cursor: pointer;
        }
        #backLink:hover {
            color: #3b25ff;
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
        #updateForm {
            background-color: #4355ff;
            color:white;
        }
        #updateForm:hover {
            width: auto;
            height: auto;
            background-color: #0f21cb;
        }
        #exportCsv {
            background-color: #e7e7e7;
            color:white;
        }
        #exportCsv:hover {
            width: auto;
            height: auto;
            background-color: #b9b9b9;
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
            </div>
         {{--    <button class="ms-6" id="backTo" onclick="goBack()">ย้อนกลับ</button>
    
            <script>
            function goBack() {
                window.history.back();
            }
            </script> --}}

            <span class="ms-6" style="color: #8E8E8E;"><a href="/webpanel/report/product/importproduct" id="backLink">ย้อนกลับ</a> / รายละเอียดสินค้า</span>

            {{-- <span class="ms-6" style="color: #8E8E8E;">รายงานการขายสินค้า</span> --}}
            <hr class="my-3" style="color: #8E8E8E; width: 100%; border:solid 3px;">

            <div class="ms-6" style="text-align: left; margin-top: 10px;">
                <span style="color: #373737; font-size:18px; font-weight:400;">เพิ่มสินค้า</span>
            </div>

            <hr class="my-3" style="color: #8E8E8E; width: 100%;">

        <form action="/webpanel/report/product/new-product/created" method="post" enctype="multipart/form-data">
            @csrf
            <div class="container" style="width:95%;">
                <div class="row">
                    <div class="col-sm-6">
                        <ul class="mt-2">
                            <span class="mt-4" style="color:#717171;">รหัสสินค้า</span>
                            <input class="form-control mt-2" style="color:#8E8E8E;" type="text" name="product_id" value="" required>
                        </ul>

                        <ul class="mt-2 py-2">
                            <span class="mt-4" style="color:#717171;">ชื่อสินค้า</span>
                            <input class="form-control mt-2" style="color:#8E8E8E;" type="text" name="product_name" value="">
                        </ul>

                        <ul class="mt-2 py-2">
                            <span class="mt-4" style="color:#717171;">ชื่อสามัญทางยา</span>
                            <input class="form-control mt-2" style="color:#8E8E8E;" type="text" name="generic_name" value="">
                        </ul>

                        <ul class="mt-2 py-2">
                            <span class="mt-4" style="color:#717171;">หน่วยสินค้า</span>
                            <input class="form-control mt-2" style="color:#8E8E8E;" type="text" name="unit" value="">
                        </ul>

                        <div class="" style="text-align: left; margin-top: 10px;">
                            <span style="color: #373737; font-size:18px; font-weight:400;">สต็อกสินค้า</span>
                        </div>
            
                        <ul class="mt-2">
                            <span class="mt-4" style="color:#717171;">จำนวน</span>
                            <input class="form-control mt-2" style="color:#8E8E8E;" type="text" name="quantity" value="">
                        </ul>

                        <div class="" style="text-align: left; margin-top: 10px;">
                            <span style="color: #373737; font-size:18px; font-weight:400;">ต้นทุนสินค้า</span>
                        </div>

                        <ul class="mt-2 py-2">
                            <span class="mt-4" style="color:#717171;">ต้นทุน</span>
                            <input class="form-control mt-2" style="color:#8E8E8E;" type="text" name="cost" value="">
                        </ul>

                        <div class="" style="text-align: left; margin-top: 10px;">
                            <span style="color: #373737; font-size:18px; font-weight:400;">ระดับราคาสินค้า</span>
                        </div>
            
                        <ul class="mt-2 py-2">
                            <span class="mt-4" style="color:#717171;">ระดับราคา 1</span>
                            <input class="form-control mt-2" style="color:#8E8E8E;" type="text" name="price_1" value="">
                        </ul>

                        <ul class="mt-2">
                            <span class="mt-4" style="color:#717171;">ระดับราคา 2</span>
                            <input class="form-control mt-2" style="color:#8E8E8E;" type="text" name="price_2" value="">
                        </ul>

                        <ul class="mt-2">
                            <span class="mt-4" style="color:#717171;">ระดับราคา 3</span>
                            <input class="form-control mt-2" style="color:#8E8E8E;" type="text" name="price_3" value="">
                        </ul>

                        <ul class="mt-2">
                            <span class="mt-4" style="color:#717171;">ระดับราคา 4</span>
                            <input class="form-control mt-2" style="color:#8E8E8E;" type="text" name="price_4" value="">
                        </ul>

                        <ul class="mt-2 mb-4">
                            <span class="mt-4" style="color:#717171;">ระดับราคา 5</span>
                            <input class="form-control mt-2" style="color:#8E8E8E;" type="text" name="price_5" value="">
                        </ul>

                    </div>

                    <div class="col-sm-6">
                        <ul class="mt-1" ">
                            <span style="color:#717171;">หมวดหมู่ยา</span><span style="font-size: 12px; color:red;"></span>
                            <select class="form-select" style="margin-top:10px; color: rgb(171, 171, 171);" aria-label="Default select example" name="category">
                                
                                @if(!empty($category))
                                    @foreach($category as $row_cate)
                                        <option value="{{ $row_cate->categories_id }}">{{ $row_cate?->categories_name .' '. '('. $row_cate?->categories_id .')' }}</option>
                                    @endforeach
                                @endif
                               

                            </select>
                        </ul>

                        <ul class="mt-3" ">
                            <span style="color:#717171;">หมวดหมู่ยาย่อย</span><span style="font-size: 12px; color:red;"></span>
                            <select class="form-select" style="margin-top:10px; color: rgb(171, 171, 171);" aria-label="Default select example" name="sub_category">
                            
                                @if(!empty($subcategory))
                                    @foreach($subcategory as $row_sub)
                                        <option value="{{ $row_sub->subcategories_id }}">{{ $row_sub?->subcategories_name .' '. '('. $row_sub?->subcategories_id .')' }}</option>
                                    @endforeach
                                @endif

                            </select>
                        </ul>

                        <ul class="mt-3" ">
                            <span style="color:#717171;">สถานะสินค้า</span><span style="font-size: 12px; color:red;"></span>
                            <select class="form-select" style="margin-top:16px; color: rgb(171, 171, 171);" aria-label="Default select example" name="status">
                            
                                <option value="ปิด">ปิด</option>
                                <option value="เปิด">เปิด</option>

                            </select>
                        </ul>

                        <hr class="mt-4" style="color:#8E8E8E;">
                        <div style="text-align:right;">
                            <button type="submit" id="updateForm" name="submit_form" class="btn my-4" style="border:none; width: 100px; color: white; padding: 10px;">บันทึก</button>
                            {{-- <a href="/webpanel/customer/getcsv/{{$product_all?->id}}" type="button" id="exportCsv" class="btn my-2" style="border:none; width: 120px; color: rgb(67, 67, 67); padding: 10px;">Export CSV</a> --}}
                        </div>

                    </div>
                </div>
            </div>
        </form>

    </div>

            @if (session('success') == 'create-success')
                <script> 
                        $('#bg').css('display', 'none');
                        Swal.fire({
                            title: "สำเร็จ",
                            text: "เพิ่มสินค้าเรียบร้อย",
                            icon: "success",
                            // showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            // cancelButtonColor: "#d33",
                            confirmButtonText: "ตกลง"
                            }).then((result) => {
                            if (result.isConfirmed) {
                                // window.location.reload();
                                window.location.href = '/webpanel/report/product/importproduct';

                            }
                        });
                </script>
            @endif

            @if (session('error') == 'create-error')
                <script> 
                        $('#bg').css('display', 'none');
                        Swal.fire({
                            title: "เกิดข้อผิดพลา",
                            text: "เพิ่มสินค้าไม่สำเร็จ",
                            icon: "error",
                            // showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            // cancelButtonColor: "#d33",
                            confirmButtonText: "ตกลง"
                            }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        });
                </script>
            @endif

            @if (session('fail') == 'create-fail')
                <script> 
                        $('#bg').css('display', 'none');
                        Swal.fire({
                            title: "เกิดข้อผิดพลา",
                            text: "สินค้ามีอยู่แล้ว",
                            icon: "warning",
                            // showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            // cancelButtonColor: "#d33",
                            confirmButtonText: "ตกลง"
                            }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        });
                </script>
        @endif

</div>
    @endsection

</body>
</html>
