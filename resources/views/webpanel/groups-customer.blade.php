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
            background-color: #efefef;
            color: #909090;
            border: none;
            cursor: pointer;
            padding: 8px 16px;
            font-size: 16px;
            border-radius: 4px;
            text-align: center;
        }
        #importMaster:hover {
            background-color: #cccccc;
            color: #3c3c3c;
        }
        #updateForm {
            background-color:  #925ff9;
            color: #ffffff;
            border: none;
            cursor: pointer;
            padding: 8px 16px;
            font-size: 16px;
            border-radius: 4px;
            text-align: center;
        }
        #updateForm:hover {
            background-color:#7a4dd3;
            color: #ffffff;
        }
        #refreshForm {
            background-color: #e9e9e9;
            color: #ffffff;
            border: none;
            cursor: pointer;
            padding: 8px 16px;
            font-size: 16px;
            border-radius: 4px;
            text-align: center;
        }
        #refreshForm:hover {
            background-color: #cbcbcb;
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
    <div class="contentArea">
        <div class="py-2">
        </div>
        <span class="ms-6" style="color: #8E8E8E;"><a href="/webpanel/customer" id="backLink">ลูกค้าทั้งหมด (Customer)</a> / จัดกลุ่มลูกค้า</span>
        <hr class="my-3" style="color: #8E8E8E; width: 100%; border:solid 3px;">

        {{-- <div class="py-3 my-4 ms-6 mr-6 text-center" style="border-radius: 8px; background-color:#ffffff;">
            <span style="color: rgb(255, 255, 255); font-size: 16px;">กำหนดลูกค้าให้แอดมิน โดยอ้างอิงจากเขตการขาย</span>
        </div> --}}
        <div class="py-3 my-4 ms-6 mr-6 p-4 mb-4 text-center text-red-800 rounded-lg bg-red-50 dark:bg-white-800 dark:text-red-400 border-1 border-red-600" role="alert">
            <span class="font-medium">คำเตือน !</span> กำหนดลูกค้าให้แอดมิน โดยอ้างอิงจากเขตการขาย
        </div>

        <hr class="my-3" style="color: #8E8E8E; width: 100%;">

            <div class="row ms-6 mr-6">

                <?php
                foreach($row_salearea as $row_sale) {

                ?>
                <div class="col-sm-6 my-2">
                    <form action="/webpanel/customer/groups-customer/updatadmin/{{$row_sale->sale_area}}" method="post" enctype="multipart/form-data">
                        @csrf

                                    <div class="form-control my-3" style="width: 100%; text-align: left;">
                                        <label for="sale_area" style="color:#838383; margin-top:10px; font-weight:500;">เขตการขาย : {{$row_sale->sale_area}}</label>
                                        <input class="form-control my-2" type="text" name="sale_area" style="color:#838383;" value="{{$row_sale->sale_area}}">
                                        <label for="sale_area" style="color:#838383; font-weight:500;">Admin area</label>
                                        <select class="form-select" style="margin-top:10px; color: grey;" aria-label="Default select example" name="admin_area">                  
                                            <option value="">ไม่ระบุ</option>
                                            @if(isset($customer_area_list) != '')
                                                 
                                                @foreach($admin_area_list as $row)
                                                
                                                    @if($row->rights_area != '0'  && $row->user_code != '0000') <!-- 0 == ไม่มีสิทธิ์ดูแลลูกค้า -->
                                                    {{-- <option {{($row->admin_area == $row_sale->admin_area) && ($row->admin_area == $customer_area_list->admin_area) ? 'selected' : '' ;}} value="{{$row->admin_area}}">{{$row->admin_area.' '. '('. $row->name. ')'}}</option> --}}
                                                    <option {{($row->admin_area == $row_sale->admin_area) ? 'selected' : '' ;}} value="{{$row->admin_area}}">{{$row->admin_area.' '. '('. $row->name. ')'}}</option>

                                                    @endif

                                                @endforeach
                                            @endif
                                        
                                        </select>

                                        <div style="text-align:right;">
                                            <button type="submit" id="updateForm" name="submit_update" class="btn my-2" style="border:none; width: 80px; color: white; padding: 8px;">บันทึก</button>
                                            <a href="" type="button" id="refreshForm" name="submit_update" class="btn my-3" style="border:none; width: 80px; color: rgb(111, 111, 111); padding: 8px;">ยกเลิก</a>
                                        </div>

                                        @if(@$row_sale->updated_at != '')
                                        <div class="my-3" style="text-align: right;">
                                            <span style="color:#a4a2a2;">อัปเดตข้อมูล : </span> <span style="color:#939393; border:solid 1px #404147; width: 50%; padding: 10px; border-radius: 5px;">{{$row_sale->updated_at}}</span></span></br>
                                        </div>
                                        @endif

                                    </div>

                            <script>
                                    $('#updateForm').click(function() {
                                        
                                        $('#bg').css('display', 'none');
                                        let user = $('#form').serialize();

                                        $.ajax({
                                            url: '/webpanel/customer/groups-customer/updatadmin',
                                            type: 'post',
                                            data: user,
                                            success: function(data) {

                                                if (data == 'success') {
                                                    Swal.fire({
                                                    title: 'สำเร็จ',
                                                    text: 'อัปเดตข้อมูลเรียบร้อย',
                                                    icon:'success',
                                                    confirmButtonText: 'ตกลง'

                                                    }).then((data)=>{
                                                        $('#bg').css('display', '');

                                                    });

                                                } else {
                                                    Swal.fire({
                                                    title: 'เกิดข้อผิดพลาด',
                                                    text: 'ไม่สามารถอัปเดตข้อมูลได้',
                                                    icon: 'error',
                                                    confirmButtonText: 'ตกลง'

                                                    }).then ((data)=>{  
                                                        if(data.isConfirmed) {
                                                            window.location.reload();
                                                        }
                                                    })
                                                }

                                                console.log(data);
                                            }
                                        });
                                    });
                            </script>


                    </form>
                </div>

                <?php  } ?>
            </div>
   
            @if(Session::get('success') == 'อัปเดตข้อมูลเรียบร้อย')
                <script>
                        Swal.fire({
                            title: 'สำเร็จ',
                            text: 'อัปเดตข้อมูลเรียบร้อย',
                            icon:'success',
                            confirmButtonText: 'ตกลง'
                        }).then((data)=>{
                            if(data.isConfirmed) {
                                // window.location.reload();
                            }
                        });
                </script>
            @endif

    </div>

@endsection
</body>
</html>
