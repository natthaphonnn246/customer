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
        .btn {
            background-color: #09A542;
            color:white;
        }
        .btn:hover {
            width: auto;
            height: auto;
            background-color: #118C3E;
        }
    </style>
    <div class="contentArea">
        <div style="text-align: left; margin-top: 10px;">
            <span style="color: #8E8E8E;"><a href="/webpanel/admin" id="backLink">ข้อมูลแอดมิน (Admin)</a> / แบบฟอร์ม</span>
        </div>
        
        <hr style="color: #8E8E8E; width: 100%;">
        
        <form action="/webpanel/admin-create/insert" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-sm-6">
                    <ul class="text-title" style="text-align: start; margin-top: 30px;">
                        <span style="font-size: 18px; font-weight: 500;">ระบุข้อมูลแอดมิน</span>
                        <hr>
                    </ul>
    
                    <div class="row text-muted">
                        <div class="col-sm-12">
                            <ul style="width: 100%;">
                                <span>ชื่อแอดมิน</span>
                                <input style="margin-top:10px; color: grey;" type="text" class="form-control" name="admin_name">
                            </ul>
                        </div>
                        <div class="col-sm-6">
                            <ul style="width: 100%;">
                                <span>CODE</span> <span style="font-size: 12px; color:red;">*จำเป็นต้องระบุ</span>
                                <input style="margin-top:10px; color: grey;" type="text" class="form-control" name="code" required>
                            </ul>
                        </div>
                        <div class="col-sm-6">
                            <ul style="width: 100%;">
                                <span>สิทธิ์แอดมิน</span>
                                <select class="form-select" style="margin-top:10px; color: grey;" aria-label="Default select example" name="role">
                                    <option value="0">ไม่ระบุ</option>
                                </select>
                            </ul>
                        </div>
                        <div class="col-sm-12">
                            <ul style="width: 100%;">
                                <span>อีเมล</span>
                                <input style="margin-top:10px; color: grey;" name="email" type="email" class="form-control" name="email"><br>
                                <span>เบอร์ติดต่อ</span> <span style="font-size: 12px; color:gery;">(ตัวอย่าง: 0904545555)</span>
                                <input style="margin-top:10px; color: grey;" type="text" class="form-control" name="telephone"><br>
                                <span>ที่อยู่</span>
                                <input style="margin-top:10px; color: grey;" type="text" class="form-control" name="address">                              
                            </ul>
                        </div>
                        <div class="col-sm-6">
                            <ul style="width: 100%;">
                                <span>จังหวัด</span>
                                {{-- <input style="margin-top:10px; color: grey;" type="text" class="form-control" name="province"> --}}

                                <select class="form-select" style="margin-top:10px; color: grey;" aria-label="Default select example" name="province" id="province">
                                    @if(isset($provinces) != '')
                                        @foreach($provinces as $row)
                                        
                                            <option value="{{$row->id}}">{{$row->name_th}}</option>
                                        
                                        @endforeach
                                    @endif
                                </select>
                            </ul>
                        </div>
                        <div class="col-sm-6">
                            <ul style="width: 100%;">
                                <span>อำเภอ/เขต</span>
                                <select class="form-select" style="margin-top:10px; color: grey;" aria-label="Default select example" id="amphures" name="amphur">
                                    
                                    @if(isset($ampures) != '')
                                        @foreach($ampures as $row)
                                            <option value="{{$row->province_id}}">{{$row->name_th}}</option>
                                        @endforeach

                                    @endif
                                </select>
                            </ul>
                        </div>
                        <div class="col-sm-6">
                            <ul style="width: 100%;">
                                <span>ตำบล/แขวง</span>
                                <select class="form-select" style="margin-top:10px; color: grey;" aria-label="Default select example" name="district" id="districts">
                                    @if(isset($district) != '')
                                        @foreach($district as $row)
                                            <option value="{{$row->amphure_id}}">{{$row->name_th}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </ul>
                        </div>
                        <div class="col-sm-6">
                            <ul style="width: 100%;">
                                <span>รหัสไปรษณีย์</span> <span style="font-size: 12px; color:red;">*กรุณาตรวจสอบ</span>
                                <input style="margin-top:10px; color: grey;" type="text" class="form-control" name="zipcode" id="zipcode">
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
                                <input style="margin-top:10px;" type="text" class="form-control" name="email_login"><br>
                                
                                <span>รหัสผ่าน</span> <span style="font-size: 12px; color:red;">*จำเป็นต้องระบุ</span>
                                <input style="margin-top:10px;" type="text" class="form-control" name="password"><br>

                            </ul>
                
                        </div>
                    
                        <div class="mb-3 my-4">
                            <label for="exampleFormControlTextarea1" class="form-label" style="font-size: 18px; font-weight: 500;">เพิ่มเติม</label></label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="text_add"></textarea>
                        </div>

                            <button type="submit" name="submit_form" class="btn my-2" style="border:none; width: 100%; color: white; padding: 10px;">บันทึกข้อมูล</button>
                        </div>
                    </div>
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
@endsection
</body>
</html>