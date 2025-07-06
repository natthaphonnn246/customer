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
<div id="bg">
    @extends ('webpanel/menuwebpanel-tailwind')
    @section('content')
    @csrf


    <style>
        .contentArea {
            /* padding: 10px; */
            background-color: #FFFFFF;
            border-radius: 2px;
            text-align: left;
            min-width: 1400px;
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
            background-color: #e0e0e0;
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
        #backLink {
            color: #3b25ff;
            text-decoration: none;
            cursor: pointer;
        }
        #backLink:hover {
            color: #3b25ff;
            text-decoration: underline;
        }
        #copy {
            background-color: #80ec98;
            color:rgb(2, 55, 20);
            border-radius: 5px;
        }
        #copy:hover {
            width: auto;
            height: auto;
            background-color: #34cb55;
            border-radius: 5px;
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

        @section('status_updated')
        <h6 class="justifiy-content:center;" style="">{{$status_updated}}</h6>
        @endsection

        @section('status_registration')
        <h6 class="justifiy-content:center;" style="">{{number_format($status_registration)}}</h6>
        @endsection
        
        @section('text_alert')
        <h6 class="justifiy-content:center; mt-2 ms-4 mr-6" style="background-color:#cb4d4d; border-radius:20px; padding: 5px; color:#ffffff; font-weight:500;">{{$status_updated}}</h6>
        @endsection

    <div class="contentArea w-full max-w-full break-words" id="bg">
        <div class="py-2">
        </div>
        <span class="ms-6" style="color: #8E8E8E;"><a href="/webpanel/admin" id="backLink">แอดมิน (Admin)</a> / รายละเอียด</span>
        <hr class="my-3" style="color: #8E8E8E; width: 100%; border:solid 3px;">

        <ul class="text-title my-2 ms-6" style="text-align: start;">
            <span style="font-size: 15px; color:#00a6ff;">ล็อกอินทั้งหมด : {{$count_check_login->check_login != '' ? $count_check_login->check_login : '0'}} ครั้ง</span> 
        </ul>
        <ul class="text-title my-3 ms-6" style="text-align: start;">
            <span style="font-size: 18px; font-weight: 500;">ข้อมูลแอดมิน</span>
        </ul>
        <hr class="my-3" style="color: #8E8E8E; width: 100%;">
    @if (isset($admin_master))
    {{-- @foreach ($admin_row as $row_edit) --}}
        <form action="/webpanel/admin-detail/update/{{$admin_master->id}}" method="post" id="form" enctype="multipart/form-data">
            {{-- action="/webpanel/admin-detail/update/{{$row_edit->user_code}}" enctype="multipart/form-data" --}}
            @csrf
            <div class="row ms-6 mr-6">
                <div class="col-sm-6">
    
                    <div class="row text-muted">
                        <div class="col-sm-12">
                            <ul>
                                <li style="width: 100%;">
                                    <span>ชื่อแอดมิน</span>
                                    <input style="margin-top:10px; color: rgb(171, 171, 171);" type="text" class="form-control" name="admin_name" value="{{$admin_master->name}}">
                                </li>
                                <li class="my-4" style="width: 100%;">
                                    <span>CODE</span> <span style="font-size: 12px; color:red;">*จำเป็นต้องระบุ</span>
                                    <input style="margin-top:10px; color: rgb(171, 171, 171);" type="text" class="form-control" name="code" value="{{$admin_master->user_code}}">
                                </li>
                                <li class="my-4" style="width: 100%;">
                                    <span>Admin area</span> <span style="font-size: 12px; color:red;">*เขตรับผิดชอบ</span>
                                    <input style="margin-top:10px; color: rgb(171, 171, 171);" type="text" class="form-control" id="adminarea" name="admin_area" value="{{$admin_master->admin_area}}">
                                </li>
                                <li class="my-4" style="width: 100%;">
                                    <ul style="width: 100%;">
                                        <span>สิทธิ์แสดงสถานะการสั่งซื้อ</span> <span style="font-size: 12px; color:red;">*มี = เห็นสถานะการสั่งซื้อ</span>
                                        <select class="form-select" style="margin-top:10px; color: rgb(171, 171, 171);" aria-label="Default select example" name="purchase_status" id="rolemain">
                                
                                            {{-- @if(($admin_master->user_code) == 0000)
                                            <option value="2" selected>มี</option>
                                            @else --}}
                                            <option {{$admin_master->purchase_status == 0 ? 'selected': '' }} value="0">ไม่มี</option>
                                            <option {{$admin_master->purchase_status == 1 ? 'selected': '' }} value="1">มี</option>
                                          {{--   @endif --}}
        
                                        </select>
                                    </ul>
                                </li>
                                <li class="my-4" style="width: 100%;">
                                    <ul style="width: 100%;">
                                        <span>สิทธิ์แอดมิน</span> <span style="font-size: 12px; color:red;">*มีสิทธิ์ = ทดสอบได้ทุกประเภทแอดมิน</span>
                                        <select class="form-select" style="margin-top:10px; color: rgb(171, 171, 171);" aria-label="Default select example" name="admin_role" id="rolemain">
                                
                                            {{-- @if(($admin_master->user_code) == 0000)
                                            <option value="2" selected>มี</option>
                                            @else --}}
                                            <option {{$admin_master->admin_role == 0 ? 'selected': '' }} value="0">ไม่มีสิทธิ์</option>
                                            <option {{$admin_master->admin_role == 1 ? 'selected': '' }} value="1">มีสิทธิ์</option>
                                          {{--   @endif --}}
        
                                        </select>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="col-sm-6 my-1">
                            <ul style="width: 100%;">
                                <span>ประเภทแอดมิน</span>
                                <select class="form-select" style="margin-top:10px; color: rgb(171, 171, 171);" aria-label="Default select example" name="role" id="rightsrole">
                        
                                    {{-- @if(($admin_master->user_code) == 0000)
                                    <option value="2" selected>มี</option>
                                    @else --}}
                                    <option {{$admin_master->role == 0 ? 'selected': '' }} value="0">ไม่ระบุ</option>
                                    <option {{$admin_master->role == 1 ? 'selected': '' }} value="1">ดูรายงาน</option>
                                    @if ($admin_master->user_id == '0000' || $admin_master->user_id == '4494' || $admin_master->user_id == '9000')
                                    <option {{$admin_master->role == 2 ? 'selected': '' }} value="2">แอดมินหลัก</option>
                                    @endif
                                  {{--   @endif --}}

                                </select>
                            </ul>
                        </div>
                        <div class="col-sm-6 my-1">
                            <ul style="width: 100%;">
                                <span>สิทธิ์รับผิดชอบ</span>
                                <select class="form-select" style="margin-top:10px; color: rgb(171, 171, 171);" aria-label="Default select example" name="rights_area" id="rights_area_role">

                                    <option {{$admin_master->rights_area == 0 ? 'selected' : '' }} value="0">ไม่ระบุ</option>
                                    <option {{$admin_master->rights_area == 1 ? 'selected' : '' }} value="1">ระบุ</option>
                                    
                                </select>
                            </ul>
                        </div>

                     {{--    <div class="col-sm-12">
                            <ul style="width: 100%;">
                                <li class="mt-4">
                                    @if($admin_master->role == '0')
                                    <span style="font-size: 14px; color:red;">*ลิงก์ทดสอบ (ไม่ระบุ) : </span> <a href="" style="background-color:#a3cfff; padding:10px;">{{ asset('/portal') }} </a>
                                    @elseif($admin_master->role == '1')
                                    <span style="font-size: 14px; color:red;">*ลิงก์ทดสอบ (ดูรายงาน) : </span> <a href="" style="background-color:#a3cfff; padding:10px;">{{ asset('/admin') }} </a>
                                    @else
                                    <span style="font-size: 14px; color:red;">*ลิงก์ทดสอบ (แอดมินหลัก) : </span> <a href="" style="background-color:#a3cfff; padding:10px;">{{ asset('/webpanel') }} </a>
                                    @endif
                                </li>
                            </ul>
        
                        </div> --}}

                        <div class="col-sm-12">
                            <ul style="width: 100%;">
                                <li class="mt-2">
                                    @if($admin_master->admin_role == '1')
                                        @if($admin_master->role == '0')

                                            @if($admin_master->rights_area == '0')
                                                <span style="font-size: 14px; color:red; width: 100%;">*ลิงก์ทดสอบ (ไม่ระบุ, สิทธิ์รับผิดชอบ = ไม่ระบุ) :
                                                <input  style="margin-top:5px; width:100%; border: solid 1px #c8c8c8; padding:6px; border-radius:5px; color: rgb(171, 171, 171);" type="text" value="{{ asset('/signin') }}" id="myInput">
                                                <button type="button" id="copy" onclick="myFunction()" style="font-size: 14px; padding:7px; width:80px; margin-top:10px;">Copy</button>
                                            @else
                                                <span style="font-size: 14px; color:red; width: 100%;">*ลิงก์ทดสอบ (ไม่ระบุ, สิทธิ์รับผิดชอบ = ระบุ) :
                                                <input  style="margin-top:5px; width:100%; border: solid 1px #c8c8c8; padding:6px; border-radius:5px; color: rgb(171, 171, 171);" type="text" value="{{ asset('/portal/dashboard') }}" id="myInput">
                                                <button type="button" id="copy" onclick="myFunction()" style="font-size: 14px; padding:7px; width:80px; margin-top:10px;">Copy</button>
                                            @endif

                                        @elseif($admin_master->role == '1')

                                        <span style="font-size: 14px; color:red; width: 100%;">*ลิงก์ทดสอบ (ดูรายงาน) :
                                        <input  style="margin-top:5px; width:100%; border: solid 1px #c8c8c8; padding:6px; border-radius:5px; color: rgb(171, 171, 171);" type="text" value="{{ asset('/admin') }}" id="myInput">
                                        <button type="button" id="copy" onclick="myFunction()" style="font-size: 14px; padding:7px; width:80px; margin-top:10px;">Copy</button>

                                        @else
                         
                                        <span style="font-size: 14px; color:red; width: 100%;">*ลิงก์ทดสอบ (แอดมินหลัก) :
                                        <input  style="margin-top:5px; width: 100%; border: solid 1px #c8c8c8; padding:6px; border-radius:5px; color: rgb(171, 171, 171);" type="text" value="{{ asset('/webpanel') }}" id="myInput">
                                        <button type="button" id="copy" onclick="myFunction()" style="font-size: 14px; padding:7px; width:80px; margin-top:10px;">Copy</button>
                                        
                                        @endif
                                    @endif
                                </li>
                            </ul>
                        </div>

                        <script>

                                function myFunction() {
                                // Get the text field
                                var copyText = document.getElementById("myInput");

                                // Select the text field
                                copyText.select();
                                copyText.setSelectionRange(0, 99999); // For mobile devices

                                // Copy the text inside the text field
                                navigator.clipboard.writeText(copyText.value);
                                }

                        </script>
                        <script text="type/javascript">
                             $(document).ready(function() {
                                $("#rightsrole").on('change',function (){
                                   const rights = $(this).val();
                                   const rights_main = $(this).val();
                                   console.log(rights);

                                   if(rights == '1' || rights_main == '2') {
                                    console.log('pass');
                                    $("#adminarea").val(''); //เขตรับผิดชอบ;
                                    $("#rights_area_role").val('0'); //เขตรับผิดชอบ;
                                   }

                                });

                                $("#adminarea").keyup(function() {
                                    console.log('keyup');
                                    $("#rightsrole").val(0);
                                });
                             });
                        </script>
                        <div class="col-sm-12">
                            <ul style="width: 100%;">
                                <li class="mt-4">
                                    <span>สิทธิ์ในการทดสอบระบบ</span> <span style="font-size: 12px; color:red;">*เมื่ออยู่ระหว่างปรับปรุงระบบ</span>
                                    <select class="form-select" style="margin-top:10px; color: rgb(171, 171, 171);" aria-label="Default select example" name="allowed_user_status">

                                        <option {{$admin_master->allowed_user_status == 0 ? 'selected' : '' }} value="0">ไม่ระบุ</option>
                                        <option  {{$admin_master->allowed_user_status == 1 ? 'selected' : '' }} value="1">ระบุ</option>
                                        
                                    </select>
                                </li>
                                <li class="mt-4">
                                    <span>อีเมล</span>
                                    <input style="margin-top:10px; color: rgb(171, 171, 171);" type="email" class="form-control" name="email" value="{{$admin_master->email}}" disabled>
                                </li>
                                <li class="mt-4">
                                    <span>เบอร์ติดต่อ</span> <span style="font-size: 12px; color:gery;">(ตัวอย่าง: 0904545555)</span>
                                    <input style="margin-top:10px; color: rgb(171, 171, 171);" type="text" class="form-control" name="telephone" value="{{$admin_master->telephone}}">
                                </li>
                                <li class="mt-4">
                                    <span>ที่อยู่</span>
                                    <input style="margin-top:10px; color: rgb(171, 171, 171);" type="text" class="form-control" name="address" value="{{$admin_master->address}}">   
                                </li>                           
                            </ul>
                        </div>
                        <div class="col-sm-6">
                            <ul class="mt-4" style="width: 100%;">
                                <span>จังหวัด</span>
                                {{-- <input style="margin-top:10px; color: grey;" type="text" class="form-control" name="province"> --}}

                                <select class="form-select" style="margin-top:10px; color: rgb(171, 171, 171);" aria-label="Default select example" name="province" id="province">
                                    @if(isset($province))
                                        @foreach($province as $row)
                        
                                            <option value="{{$row->id}}" {{$row->name_th == $admin_master->province ? 'selected' : '' }}>{{$row->name_th}}</option>
                                        
                                        @endforeach
                                    @endif
                                </select>
                            </ul>
                        </div>
                        <div class="col-sm-6">
                            <ul class="mt-4" style="width: 100%;">
                                <span>อำเภอ/เขต</span>
                                <select class="form-select" style="margin-top:10px; color: rgb(171, 171, 171);" aria-label="Default select example" id="amphures" name="amphur">

                                    @if(isset($amphur) && $amphur == '')
                                        @foreach($amphur as $row)
                                            <option value="{{$row->province_id}}" {{$row->name_th == $admin_master->amphur ? 'selected' : '' }}>{{$row->name_th}}</option>
                                        @endforeach

                                    @else
                                    <option>{{$admin_master->amphur}}</option>
                                    @endif
                                </select>
                            </ul>
                        </div>
                        <div class="col-sm-6">
                            <ul class="mt-3" style="width: 100%;">
                                <span>ตำบล/แขวง</span>
                                <select class="form-select" style="margin-top:10px; color: rgb(171, 171, 171);" aria-label="Default select example" name="district" id="districts">
                                    @if(isset($district) && $district == '')
                                        @foreach($district as $row)
                                            <option value="{{$row->amphure_id}}" {{$row->name_th == $admin_master->district ? 'selected' : '' }}>{{$row->name_th}}</option>
                                        @endforeach

                                    @else
                                    <option>{{$admin_master->district}}</option>
                                    @endif
                                </select>
                            </ul>
                        </div>
                        <div class="col-sm-6">
                            <ul class="mt-3" style="width: 100%;">
                                <span>รหัสไปรษณีย์</span> <span style="font-size: 12px; color:red;">*กรุณาตรวจสอบ</span>
                                <input style="margin-top:10px; color: rgb(171, 171, 171);" type="text" class="form-control" name="zipcode" id="zipcode" value="{{$admin_master->zipcode}}">
                            </ul>
                        </div>
                    </div>
                </div>
                <!--form login-->
                    <div class="col-sm-6" style="padding-top:40px;">
                        <div class="form-control">
                            <ul class="text-title" style="text-align: start; margin-top: 10px;">
                                <span class="ms-3" style="font-size: 18px; font-weight: 500;">ข้อมูล Login</span>
                                <hr class="my-3" style="color: #8E8E8E; width: 100%;">
                            </ul>
                            <ul class="text-muted" style="padding-top: 6px;">

                                <li class="ms-6">
                                    <span>อีเมล</span> <span style="font-size: 12px; color:red;">*จำเป็นต้องระบุ</span>
                                    <input style="margin-top:10px; color:rgb(171, 171, 171);" type="text" class="form-control" name="email_login" value="{{$admin_master->email}}">
                                </li>
                                <li class="ms-6 mt-4 mb-3">
                                    <span>รหัสผ่าน</span> <span style="font-size: 12px; color:red;">*จำเป็นต้องระบุ</span>
                                    <input style="margin-top:10px;" type="text" class="form-control" name="password" disabled>
                                </li>

                            </ul>
                
                        </div>
                    
                        <div class="mb-3 my-4 ms-2">
                            <label for="exampleFormControlTextarea1" class="form-label" style="font-size: 18px; font-weight: 500;">เพิ่มเติม</label></label>
                            <textarea class="form-control" style=" color:rgb(171, 171, 171);" id="exampleFormControlTextarea1" rows="3" name="text_add">{{$admin_master->text_add}}</textarea>
                        </div>

                        <div style="text-align:right;">
                            <button type="submit" id="updateForm" name="submit_update" class="btn my-2" style="border:none; width: 100px; color: white; padding: 10px;">บันทึก</button>
                            {{-- <a href="" type="button" id="exportCsv" class="btn my-2" style="border:none; width: 120px; color: rgb(67, 67, 67); padding: 10px;">Export CSV</a> --}}

                        </div>
                        </div>
                    </div>
        </form>

        @if (session('status') == 'updated_success')
            <script> 
                    $('#bg').css('display', 'none');
                    Swal.fire({
                        title: "สำเร็จ",
                        text: "อัปเดตข้อมูลเรียบร้อย",
                        icon: "success",
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

        @if (session('status') == 'updated_fail')
            <script> 
                    $('#bg').css('display', 'none');
                    Swal.fire({
                        title: "ล้มเหลว",
                        text: "เกิดข้อผิดพลาด",
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

                    <!--- update user information-->
                  {{--   <script>
                         
                            $('#updateForm').click(function() {
                                $('#bg').css('display', 'none');
                                let user = $('#form').serialize();
               
                                $.ajax({
                                    url: '/webpanel/admin-detail/update/{{$admin_master->id}}',
                                    type: 'post',
                                    data: user,
                                    // dataType: 'text',
                                    success: function(data) {

                                        if (data == 'success') {
                                            Swal.fire({
                                            title: 'สำเร็จ',
                                            text: 'อัปเดตข้อมูลเรียบร้อย',
                                            icon:'success',
                                            confirmButtonText: 'ตกลง'

                                            }).then((data)=>{
                                                $('#bg').css('display', '');
                                                window.location.reload();

                                            });

                                        } else {
                                            Swal.fire({
                                            title: 'เกิดข้อผิดพลาด',
                                            text: 'ไม่สามารถอัปเดตข้อมูลได้',
                                            icon: 'error',
                                            confirmButtonText: 'ตกลง'

                                            });
                                        }

                                        console.log(data);
                                    }
                                });

                            });
                            
                    </script> --}}

    {{-- @endforeach --}}
    @endif

        <hr class="my-4" style="color: #8E8E8E; width: 100%; border:solid 3px;">

        @if (Session::has('success'))
        <div class="alert alert-success ms-6 mr-6"><i class="fa-solid fa-circle-check" style="color:green;"></i> {{ Session::get('success') }}</div>
        @endif

        @if (Session::has('error'))
        <div class="alert alert-danger ms-6 mr-6"><i class="fa-solid fa-circle-xmark" style="color: rgb(172, 27, 27);"></i> {{ Session::get('error') }}</div>
        
        @endif

                    <form action="/webpanel/admin-detail/reset/{{$admin_master->id}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <ul class="text-title ms-8 mr-8" style="text-align: start; margin-top: 10px;">
                            <li>
                                <span style="font-size: 16px; font-weight: 500;">เปลี่ยนรหัสผ่าน</span>
                            </li>
                            <hr class="my-2" style="color:#8E8E8E;">
                            <li class="my-3">
                                <span style="font-size: 16px; color: #8E8E8E; font-weight: 400;">รหัสผ่านใหม่</span>
                                <input style="margin-top:5px; opacity:0.5;" type="password" class="form-control my-2" name="reset_password" required>
                            </li>
                            <hr class="my-3" style="color:#8E8E8E;">
                            <button type="submit" name="submit_reset" id="reset" class="btn mb-4" style="border:none; width:150px; color: white; padding: 10px;">เปลี่ยนรหัสผ่าน</button>
                        </ul>
                    </form>

                    
    </div>
    <script>
             
        $('#province').change(function(e) {
            e.preventDefault();
            let province_id = $(this).val();
            console.log(province_id);
            
                $.ajax({
                    url: '/webpanel/admin-create/update-amphure',
                    type: 'get',
                    data: {province_id: province_id},
                    success: function(data) {

                        $('#amphures').html(data);

                    }
                });
            });

            $('#amphures').change(function(e) {
            e.preventDefault();
            let amphure_id = $(this).val();
            console.log(amphure_id + 'checked');
            
                $.ajax({
                    url: '/webpanel/admin-create/update-district',
                    type: 'get',
                    data: {amphure_id: amphure_id},
                    success: function(data) {

                        $('#districts').html(data);
                    
                    }
                });
            });

            $('#province').click(function() {
 
            let province_id = $(this).val();
            
            console.log(province_id);
            
            $.ajax({
                url: '/webpanel/admin-create/update-amphure',
                type: 'get',
                data: {province_id: province_id},
                success: function(data) {

                    $('#amphures').html(data);

                }
            });
            });

            $('#amphures').click(function(e) {
            e.preventDefault();
            let amphure_id = $(this).val();
            console.log(amphure_id);
            
                $.ajax({
                    url: '/webpanel/admin-create/update-district',
                    type: 'get',
                    data: {amphure_id: amphure_id},
                    success: function(data) {

                        $('#districts').html(data);
                    
                    }
                });
            });

            $('#districts').change(function(e) {
            e.preventDefault();
            let amphure_id = $(this).val();
            console.log(amphure_id);
            
                $.ajax({
                    url: '/webpanel/admin-create/update-zipcode',
                    type: 'get',
                    data: {amphure_id: amphure_id},
                    success: function(data) {

                        $('#zipcode').val(data);
                        console.log(data);
                    
                    }
                });
            });

            $('#districts').click(function(e) {
            e.preventDefault();
            let amphure_id = $(this).val();
            console.log(amphure_id);
            
                $.ajax({
                    url: '/webpanel/admin-create/update-zipcode',
                    type: 'get',
                    data: {amphure_id: amphure_id},
                    success: function(data) {

                        $('#zipcode').val(data);
                        console.log(data);
                    
                    }
                });
            });

    </script>

        <!--- php upload ใบอนุญาตขายยาสถานพยาบาล--->
    <script>

                $(document).ready(function(){
                    $('#cert_store').click(function(){
                        // e.preventDefault(); ปิดใช้งาน submit ปกติ
                        Swal.fire ({
                            html:
                            '<p style="text-align: start;">แก้ไขใบอนุญาตขายยา/สถานพยาบาล <?php echo 1 ;?></p>'
                            +'<hr>'
                            +'<form action="update-swal.php" method="post" enctype="multipart/form-data">'
                            +'<img src="./upload_store/<?php echo 1 ; ?>" id="fileImage" style="width: 100%";/>'
                            +'<hr>'
                            +'<input type="file" id="image" class="form-control" name="certStore[<?php echo 1 ;?>]" style="margin-top: 10px;"; accept="image/png, image/jpg, image/jpeg"/>'
                            +'<hr>'
                            +'<div style="margin-top: 10px; text-align: end;">'
                            +'<button type="submit" class="btn btn-primary" style="margin: 5px;">บันทึก</button>'
                            +'<button onclick="closeWin()" type="button" onclick="closeOpenedWindow()" class="btn btn-danger" data-dismiss="modal">ยกเลิก</button>'
                            +'</div>'
                            + '</form>',
                            showConfirmButton: false, 

                            // confirmButtonText: 'บันทึก',
                            // showCancelButton: true,
                        
                        })

                /// preview image swal filre;
                    let image = document.querySelector('#image');
                    let fileImage = document.querySelector('#fileImage');

                    image.onchange = evt => {
                    const [file] = image.files;
                    if(file) {
                    fileImage.src = URL.createObjectURL(file);
                    }
                    }
            });
        });
        //close window reload window;
            function closeWin() {
            Swal.close();
            // window.location.reload();
            }
</script>
</div>
@endsection
</body>
</html>
