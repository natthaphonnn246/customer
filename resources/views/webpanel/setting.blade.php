<!DOCTYPE html>
<html lang="en">
    @section ('title', 'admin-create')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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
            text-align: left;
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
            background-color: #c9c9c9;
            color:white;
        }
        #exportCsv:hover {
            width: auto;
            height: auto;
            background-color: #b9b9b9;
        }

        #reset {
            background-color: #4355ff;
            color:white;
        }
        #reset:hover {
            width: auto;
            height: auto;
            background-color: #0f21cb;
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

    <div class="contentArea w-full max-w-full break-words">
        {{-- <div id="bg"> --}}
        <div class="py-2">
            {{-- <span style="color: #8E8E8E;"><a href="/webpanel/admin" id="backLink">แอดมินทั้งหมด (Admin)</a> / รายละเอียด</span> --}}
            {{-- <span style="color: #8E8E8E;">ตั้งค่าระบบ (Settings)</span> --}}
        </div>
        <span class="ms-6" style="color: #8E8E8E;">ตั้งค่าระบบ (Settings)</span>
        <hr class="my-3" style="color: #8E8E8E; width: 100%; border:solid 3px;">
        <ul class="text-title ms-6" style="text-align: start; margin-top: 30px;">
            <span style="font-size: 18px; font-weight: 500; color:#464646;">ตั้งค่าเว็บไซต์</span>
            <hr class="my-3" style="color: #8E8E8E; width: 100%;">
        </ul>

        <form method="post" action="/webpanel/setting/update-setting" enctype="multipart/form-data">
            @csrf
            @if(!empty($setting_view))
                <div class="row ms-6 mr-6 mt-4">
                    <div class="col-sm-6">
                        <ul style="width: 100%;">
                            <span style="color:#8E8E8E;">สถานะของเว็บไซต์</span>
                            <select class="form-select" style="margin-top:10px; color: rgb(171, 171, 171);" aria-label="Default select example" name="maintenance_status">

                                <option {{$setting_view->web_status == '0' ? 'selected': ''}} value="0">ปกติ</option>
                                <option {{$setting_view->web_status == '1' ? 'selected': ''}} value="1">อยู่ระหว่างการปรับปรุง</option>
                                
                            </select>
                        </ul>

                    </div>
                    <div class="col-sm-6">
                        <ul style="width: 100%;">
                            <span style="color:#8E8E8E;">สิทธิ์ในการทดสอบระบบ</span> <span style="font-size: 12px; color:red;">*เมื่ออยู่ระหว่างปรับปรุงระบบ</span>
                            <select class="form-select" style="margin-top:10px; color: rgb(171, 171, 171);" aria-label="Default select example" name="allowed_maintenance_status">

                                <option {{$setting_view->allowed_web_status == '0' ? 'selected': ''}} value="0">ไม่ระบุ</option>
                                <option {{$setting_view->allowed_web_status == '1' ? 'selected': ''}} value="1">ระบุ</option>
                                
                            </select>
                        </ul>
                    </div>
                    {{-- <hr class="mt-8" style="color: #8E8E8E; width: 100%;"> --}}
                </div>

                <div class="row ms-6 mr-6 mt-4">
                    <div class="col-sm-6">
                        <ul style="width: 100%;">
                            <span style="color:#8E8E8E;">ลบรายงานขายอัตโนมัติ</span>
                            <select class="form-select" style="margin-top:10px; color: rgb(171, 171, 171);" aria-label="Default select example" name="del_reportseller">

                                <option {{$setting_view->del_reportseller == '0' ? 'selected': ''}} value="0">ปิด</option>
                                <option {{$setting_view->del_reportseller == '1' ? 'selected': ''}} value="1">เปิด</option>
                                
                            </select>
                        </ul>

                    </div>
                    <hr class="mt-8" style="color: #8E8E8E; width: 100%;">
                </div>

                <div class="row ms-6 mr-6 mt-4">
                    <span class="mb-4" style="font-weight: 400; font-size:18px; color:#656565;">อัปเดตข้อมูลร้านค้า</span>
                    <div class="col-sm-6">
                        <ul style="width: 100%;">
                            <span style="color:#8E8E8E;">สถานะเปิดให้แอดมินแก้ไขลูกค้า</span> <span style="font-size: 12px; color:red;">*เปิดเท่ากับแก้ไขลูกค้าได้</span>
                            <select class="form-select" style="margin-top:10px; color: rgb(171, 171, 171);" aria-label="Default select example" name="check_edit">

                                <option {{$setting_view->check_edit == '1' ? 'selected': ''}} value="1">ปิด</option>
                                <option {{$setting_view->check_edit == '0' ? 'selected': ''}} value="0">เปิด</option>                           
                                
                            </select>
                        </ul>

                    </div>
                    <hr class="mt-8" style="color: #8E8E8E; width: 100%;">
                </div>

                <div class="row ms-6 mr-6 mt-4">
                    <span class="mb-4" style="font-weight: 400; font-size:18px; color:#656565;">ประเภทร้านค้า</span>
                    <div class="col-sm-6">
                        <ul style="width: 100%;">
                            <span style="color:#8E8E8E;">สถานะเปิดให้แอดมินเข้าถึงประเภทร้านค้า (ข.ย.2 / สมพ2)</span> <span style="font-size: 12px; color:red;">*เปิดเท่ากับเข้าใช้งานได้</span>
                            <select class="form-select" style="margin-top:10px; color: rgb(171, 171, 171);" aria-label="Default select example" name="check_type">

                                <option {{$setting_view->check_type == '1' ? 'selected': ''}} value="1">ปิด</option>
                                <option {{$setting_view->check_type == '0' ? 'selected': ''}} value="0">เปิด</option>                           
                                
                            </select>
                        </ul>

                    </div>

                    <div class="col-sm-6">
                        <ul style="width: 100%;">
                            <span style="color:#8E8E8E;">กำหนดเวลาเข้าใช้งานประเภทร้านค้า (ข.ย.2/สมุนไพร)</span> <span style="font-size: 12px; color:red;">*หน่วยเป็นนาที</span>
                            <select class="form-select" style="margin-top:10px; color: rgb(171, 171, 171);" aria-label="Default select example" name="check_time_type">

                                <option {{$setting_view->check_time_type === 300 ? 'selected': ''}} value="300">5</option>
                                <option {{$setting_view->check_time_type === 900 ? 'selected': ''}} value="900">15</option>
                                <option {{$setting_view->check_time_type === 1800 ? 'selected': ''}} value="1800">30</option>                              
                                
                            </select>
                        </ul>

                    </div>
                    <hr class="mt-8" style="color: #8E8E8E; width: 100%;">
                </div>
            @endif
            <div style="text-align:left; margin-left:30px;">
                <button type="submit" id="updateForm" name="submit_setting" class="btn my-4" style="border:none; width: 100px; color: white; padding: 10px;">บันทึก</button>
            </div>
        </form>
    {{-- </div> --}}
    @if(Session::has('settings'))

        <script>

                $(document).ready(function () {

                    $('#bg').css('display', 'none');
                    Swal.fire({
                    icon:'success',
                    title: 'สำเร็จ',
                    text: 'อัปเดตสถานะเว็บไซต์เรียบร้อย',
                    showConfirmButton: true,
                    confirmButtonText: 'รับทราบ'

                }).then(function() {
                    $('#bg').css('display', '');
                });

            });
           
        </script>
    @endif
    @endsection
</div>
</body>
</html>
