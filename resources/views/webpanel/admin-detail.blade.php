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

    <title>customer</title>
</head>
<body>

    @extends ('webpanel/menuwebpanel')
    @section('content')
    @csrf


    <style>
        .contentArea {
            padding: 10px;
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
    <div class="contentArea" id="bg">
        <div style="text-align: left; margin-top: 10px;">
            <span style="color: #8E8E8E;"><a href="/webpanel/admin" id="backLink">แอดมินทั้งหมด (Admin)</a> / รายละเอียด</span>
        </div>
        
    @if (isset($admin_row) != '')
    @foreach ($admin_row as $row_edit)
        <form id="form">
            {{-- action="/webpanel/admin-detail/update/{{$row_edit->user_code}}" enctype="multipart/form-data" --}}
            @csrf
            <div class="row">
                <div class="col-sm-6">
                    <ul class="text-title" style="text-align: start; margin-top: 30px;">
                        <span style="font-size: 18px; font-weight: 500;">ข้อมูลแอดมิน</span>
                        <hr>
                    </ul>
    
                    <div class="row text-muted">
                        <div class="col-sm-12">
                            <ul style="width: 100%;">
                                <span>ชื่อแอดมิน</span>
                                <input style="margin-top:10px; color: rgb(171, 171, 171);" type="text" class="form-control" name="admin_name" value="{{$row_edit->name}}">
                            </ul>
                            <ul style="width: 100%;">
                                <span>CODE</span> <span style="font-size: 12px; color:red;">*จำเป็นต้องระบุ</span>
                                <input style="margin-top:10px; color: rgb(171, 171, 171);" type="text" class="form-control" name="code" value="{{$row_edit->user_code;}}" disabled>
                            </ul>
                            <ul style="width: 100%;">
                                <span>Admin area</span> <span style="font-size: 12px; color:red;">*เขตรับผิดชอบ</span>
                                <input style="margin-top:10px; color: rgb(171, 171, 171);" type="text" class="form-control" name="admin_area" value="{{$row_edit->admin_area;}}">
                            </ul>
                        </div>
                        <div class="col-sm-6">
                            <ul style="width: 100%;">
                                <span>สิทธิ์แอดมิน</span>
                                <select class="form-select" style="margin-top:10px; color: rgb(171, 171, 171);" aria-label="Default select example" name="role">
                        
                                    @if(($row_edit->user_code) == 0000)
                                    <option value="1" selected>มี</option>
                                    @else
                                    <option value="0">ไม่ระบุ</option>
                                    @endif

                                </select>
                            </ul>
                        </div>
                        <div class="col-sm-6">
                            <ul style="width: 100%;">
                                <span>สิทธิ์รับผิดชอบ</span>
                                <select class="form-select" style="margin-top:10px; color: rgb(171, 171, 171);" aria-label="Default select example" name="admin-role">

                                    <option value="0">ไม่ระบุ</option>
                                    <option value="1">ระบุ</option>
                                    
                                </select>
                            </ul>
                        </div>
                        <div class="col-sm-12">
                            <ul style="width: 100%;">
                                <span>อีเมล</span>
                                <input style="margin-top:10px; color: rgb(171, 171, 171);" name="email" type="email" class="form-control" name="email" value="{{$row_edit->email}}"><br>
                                <span>เบอร์ติดต่อ</span> <span style="font-size: 12px; color:gery;">(ตัวอย่าง: 0904545555)</span>
                                <input style="margin-top:10px; color: rgb(171, 171, 171);" type="text" class="form-control" name="telephone" value="{{$row_edit->telephone}}"><br>
                                <span>ที่อยู่</span>
                                <input style="margin-top:10px; color: rgb(171, 171, 171);" type="text" class="form-control" name="address" value="{{$row_edit->address}}">                              
                            </ul>
                        </div>
                        <div class="col-sm-6">
                            <ul style="width: 100%;">
                                <span>จังหวัด</span>
                                {{-- <input style="margin-top:10px; color: grey;" type="text" class="form-control" name="province"> --}}

                                <select class="form-select" style="margin-top:10px; color: rgb(171, 171, 171);" aria-label="Default select example" name="province" id="province">
                                    @if(isset($province) != '')
                                        @foreach($province as $row)
                        
                                            <option value="{{$row->id}}" {{$row->name_th == $row_edit->province ? 'selected' : '' ;}}>{{$row->name_th}}</option>
                                        
                                        @endforeach
                                    @endif
                                </select>
                            </ul>
                        </div>
                        <div class="col-sm-6">
                            <ul style="width: 100%;">
                                <span>อำเภอ/เขต</span>
                                <select class="form-select" style="margin-top:10px; color: rgb(171, 171, 171);" aria-label="Default select example" id="amphures" name="amphur">

                                    @if(isset($amphur) == '')
                                        @foreach($amphur as $row)
                                            <option value="{{$row->province_id}}" {{$row->name_th == $row_edit->amphur ? 'selected' : '' ;}}>{{$row->name_th}}</option>
                                        @endforeach

                                    @else
                                    <option>{{$row_edit->amphur}}</option>
                                    @endif
                                </select>
                            </ul>
                        </div>
                        <div class="col-sm-6">
                            <ul style="width: 100%;">
                                <span>ตำบล/แขวง</span>
                                <select class="form-select" style="margin-top:10px; color: rgb(171, 171, 171);" aria-label="Default select example" name="district" id="districts">
                                    @if(isset($district) == '')
                                        @foreach($district as $row)
                                            <option value="{{$row->amphure_id}}" {{$row->name_th == $row_edit->district ? 'selected' : '' ;}}>{{$row->name_th}}</option>
                                        @endforeach

                                    @else
                                    <option>{{$row_edit->district}}</option>
                                    @endif
                                </select>
                            </ul>
                        </div>
                        <div class="col-sm-6">
                            <ul style="width: 100%;">
                                <span>รหัสไปรษณีย์</span> <span style="font-size: 12px; color:red;">*กรุณาตรวจสอบ</span>
                                <input style="margin-top:10px; color: rgb(171, 171, 171);" type="text" class="form-control" name="zipcode" id="zipcode" value="{{$row_edit->zipcode}}">
                            </ul>
                        </div>
                    </div>
                </div>
                <!--form login-->
                    <div class="col-sm-6" style="padding-top:40px;">
                        <div class="form-control">
                            <ul class="text-title" style="text-align: start; margin-top: 10px;">
                                <span style="font-size: 18px; font-weight: 500;">ข้อมูล Login</span>
                                <hr>
                            </ul>
                            <ul class="text-muted" style="padding-top: 10px;">
                            <label></label>
                                <span>อีเมล</span> <span style="font-size: 12px; color:red;">*จำเป็นต้องระบุ</span>
                                <input style="margin-top:10px; color:rgb(171, 171, 171);" type="text" class="form-control" name="email_login" value="{{$row_edit->email_login}}"><br>
                                
                                <span>รหัสผ่าน</span> <span style="font-size: 12px; color:red;">*จำเป็นต้องระบุ</span>
                                <input style="margin-top:10px;" type="text" class="form-control" name="password" disabled><br>

                            </ul>
                
                        </div>
                    
                        <div class="mb-3 my-4">
                            <label for="exampleFormControlTextarea1" class="form-label" style="font-size: 18px; font-weight: 500;">เพิ่มเติม</label></label>
                            <textarea class="form-control" style=" color:rgb(171, 171, 171);" id="exampleFormControlTextarea1" rows="3" name="text_add">{{$row_edit->text_add}}</textarea>
                        </div>

                        <div style="text-align:right;">
                            <button type="button" id="updateForm" name="submit_update" class="btn my-2" style="border:none; width: 100px; color: white; padding: 10px;">บันทึก</button>
                            <a href="" type="button" id="exportCsv" class="btn my-2" style="border:none; width: 120px; color: rgb(67, 67, 67); padding: 10px;">Export CSV</a>

                        </div>
                        </div>
                    </div>
        </form>

                    <!--- update user information-->
                    <script>
                            $('#updateForm').click(function() {
                                
                                $('#bg').css('display', 'none');
                                let user = $('#form').serialize();

                                $.ajax({
                                    url: '/webpanel/admin-detail/update/{{$row_edit->user_code}}',
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

                                            });
                                        }

                                        console.log(data);
                                    }
                                });
                            });
                    </script>

    @endforeach
    @endif

        <hr style="color:#828282;">

        @if (Session::has('success'))
        <div class="alert alert-success"><i class="fa-solid fa-circle-check" style="color:green;"></i> {{ Session::get('success') }}</div>
        @endif

        @if (Session::has('error'))
        <div class="alert alert-danger"><i class="fa-solid fa-circle-xmark" style="color: rgb(172, 27, 27);"></i> {{ Session::get('error') }}</div>
        
        @endif

        <div class="form-control" style="margin-top: 25px;">
                    <form action="/webpanel/admin-detail/reset/{{$row_edit->user_code}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <ul class="text-title" style="text-align: start; margin-top: 10px;">
                            <span style="font-size: 16px; font-weight: 500;">เปลี่ยนรหัสผ่าน</span>
                            <hr style="color:#8E8E8E;">
                            <span style="font-size: 16px; color: #8E8E8E; font-weight: 400;">รหัสผ่านใหม่</span>
                            <input style="margin-top:5px; opacity:0.5;" type="password" class="form-control my-2" name="reset_password" required>
                            <hr style="color:#8E8E8E;">
                            <button type="submit" name="submit_reset" id="reset" class="btn" style="border:none; width:150px; color: white; padding: 10px;">เปลี่ยนรหัสผ่าน</button>
                        </ul>
                    </form>
        </div></br>

                    
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
@endsection
</body>
</html>
