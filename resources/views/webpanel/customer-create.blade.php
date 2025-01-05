<!DOCTYPE html>
<html lang="en">
    @section ('title', 'customer-create')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <title>register-form</title>
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
        #submitForm {
            background-color: #4355ff;
            color:white;
        }
        #submitForm:hover {
            width: auto;
            height: auto;
            background-color: #0f21cb;
        }
    </style>
    
    <div class="contentArea">

        <div style="text-align: left; margin-top: 10px;">
            <span style="color: #8E8E8E;"><a href="/webpanel/customer" id="backLink">ลูกค้าทั้งหมด (Customer)</a> / แบบฟอร์ม</span>

        </div>
        <hr style="color: #8E8E8E; width: 100%;">
        <form action="/webpanel/customer-create/insert" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-sm-6">
                    <ul class="text-title" style="text-align: start; margin-top: 25px;">
                        <span style="font-size: 18px; font-weight: 500;">ลงทะเบีนนลูกค้าใหม่</span>
                        <hr>
                    </ul>
                    <ul class="text-muted" style="padding-top: 10px;">
                        <span>ใบอนุญาตขายยา/สถานพยาบาล</span> <span style="font-size: 12px; color:red;">*จำเป็นต้องระบุ</span></br>
                        {{-- <input class="btn btn-primary my-2" style="width:100%; border:none;" id="cert_store" value="ใบอนุญาตขายยา/สถานพยาบาล"> --}}
                        <input style="margin-top:10px;" type="file" class="form-control text-muted" name="cert_store" accept="image/png, image/jpg, image/jpeg"><br>

                        <span>ใบประกอบวิชาชีพ</span> <span style="font-size: 12px; color:red;">*จำเป็นต้องระบุ</span>
                        <input style="margin-top:10px;" type="file" class="form-control text-muted" name="cert_medical" accept="image/png, image/jpg, image/jpeg"><br>

                        <span>ใบทะเบียนพาณิชย์</span>
                        <input style="margin-top:10px;" type="file" class="form-control text-muted" name="cert_commerce" accept="image/png, image/jpg, image/jpeg"><br>

                        <span>ใบทะเบียนภาษีมูลค่าเพิ่ม (ภ.พ.20)</span>
                        <input style="margin-top:10px;" type="file" class="form-control text-muted" name="cert_vat" accept="image/png, image/jpg, image/jpeg"><br>

                        <span>สำเนาบัตรประชาชน</span>
                        <input style="margin-top:10px;" type="file" class="form-control text-muted" name="cert_id" accept="image/png, image/jpg, image/jpeg"><br>

                        <span>เลขใบอนุญาตขายยา/สถานพยาพยาล</span> <span style="font-size: 12px; color:red;">*จำเป็นต้องระบุ หากไม่มีให้ใส่ 0</span>
                        <input style="margin-top:10px; color:grey;" type="text" class="form-control" name="cert_number"><br>

                        <span>วันหมดอายุ</span> <span style="font-size: 12px; color:red;">*จำเป็นต้องระบุ</span>

                        <input style="margin-top:10px; color:grey;" type="date" value="2024-01-01" class="form-control" name="cert_expire"><br>

                    </ul>

                    <ul class="text-title" style="text-align: start; margin-top: 20px;">
                        <span style="font-size: 18px; font-weight: 500;">ข้อมูลลูกค้า</span> <span style="font-size: 12px; color:red;">*จำเป็นต้องระบุให้ครบทุกช่อง</span>
                        <hr>
                    </ul>
                    <div class="row text-muted">
                        <div class="col-sm-12">
                            <ul style="width: 100%;">
                                <span>ชื่อร้านค้า/สถานพยาบาล</span>
                                <input style="margin-top:10px; color: grey;" type="text" class="form-control" name="customer_name">
                            </ul>
                        </div>
                        <div class="col-sm-6">
                            <ul style="width: 100%;">
                                <span>CODE</span><span style="font-size: 12px; color:red;">*จำเป็นต้องระบุ</span>
                                <input style="margin-top:10px; color: grey;" type="text" class="form-control" name="customer_code" required>
                            </ul>
                        </div>
                        <div class="col-sm-6">
                            <ul style="width: 100%;">
                                <span>ระดับราคา</span><span style="font-size: 12px; color:red;">*ลูกค้า 6 เท่ากับ 1</span>
                                <select class="form-select" style="margin-top:10px; color: grey;" aria-label="Default select example" name="price_level">
                                <option name="price_level" value="5">5</option>
                                <option name="price_level" value="1">1</option>
                                <option name="price_level" value="2">2</option>
                                <option name="price_level" value="3">3</option>
                                <option name="price_level" value="4">4</option>
                                </select>
                            </ul>
                        </div>
                        <div class="col-sm-12">
                            <ul style="width: 100%;">
                                <span>อีเมล</span>
                                <input style="margin-top:10px; color: grey;" name="email" type="email" class="form-control" name="email"><br>
                                <span>เบอร์ร้านค้า</span> <span style="font-size: 12px; color:gery;">(ตัวอย่าง: 021234567)</span>
                                <input style="margin-top:10px; color: grey;" type="text" class="form-control" name="phone"><br>
                                <span>เบอร์มือถือ</span> <span style="font-size: 12px; color:red;">*จำเป็นต้องระบุ</span> <span style="font-size: 12px; color:gery;">(ตัวอย่าง: 0812345678)</span>
                                <input style="margin-top:10px; color: grey;" type="text" class="form-control" name="telephone"><br>
                                <span>ที่อยู่จัดส่ง</span>
                                <input style="margin-top:10px; color: grey;" type="text" class="form-control" name="address">                              
                            </ul>
                        </div>
                        <div class="col-sm-6">
                            <ul style="width: 100%;">
                                <span>จังหวัด</span>
                                {{-- <input style="margin-top:10px; color: grey;" type="text" class="form-control" name="province"> --}}
        
                                <select class="form-select" style="margin-top:10px; color: grey;" aria-label="Default select example" name="province" id="province">
                                    {{-- <?php  $provinces = DB::table('provinces')->select('id', 'name_th')->orderBy('id', 'asc')->get(); ?> --}}
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
                                <span>อำเภอ/แขวง</span>
                                <select class="form-select" style="margin-top:10px; color: grey;" aria-label="Default select example" name="amphur" id="amphures">
                                    
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
                                <span>ตำบล/เขต</span>
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
                                <input style="margin-top:10px; color: grey;" type="text" class="form-control" id="zipcode" name="zip_code">
                            </ul>
                        </div>
                    </div>
                </div>
                <!--form login-->
                    <div class="col-sm-6" style="padding-top:20px;">
                        <div class="form-control">
                            <ul class="text-title" style="text-align: start; margin-top: 10px;">
                                <span style="font-size: 18px; font-weight: 500;">ข้อมูลผู้รับผิดชอบ</span>
                                <hr>
                            </ul>
                            <ul class="text-muted" style="padding-top: 10px;">
                            <label></label>
                                <span>แอดมินผู้ดูแล</span> <span style="font-size: 12px; color:red;">*จำเป็นต้องระบุ</span>
                                {{-- <input style="margin-top:10px;" type="text" class="form-control" name="admins"><br> --}}
                                <select class="form-select" style="margin-top:10px; color: grey;" aria-label="Default select example" name="admin_area">
                                    <option value="A01">พี่เมย์</option>
                                    <option value="A02">พรรษา</option>
                                    <option value="A03">ออม</option>
                                    <option value="A04">แจ๋ม</option>
                                    </select><br>
 
                                <span>พนักงานขาย/เขตการขาย</span> <span style="font-size: 12px; color:red;">*จำเป็นต้องระบุ</span>
                                    <select class="form-select" style="margin-top:10px; color: grey;" aria-label="Default select example" name="sale_area">
                                    <option selected value=""> ไม่ระบุ </option>
                                    <option value="S01">S01 ธนวรรธน์</option>
                                    <option value="S02">S02</option>
                                    <option value="S03">S03</option>
                                    <option value="S04">S04</option>
                                    <option value="S05">S05</option>
                                    <option value="S06">S06</option>
                                    <option value="S07">S07</option>
                                    <option value="S08">S08</option>
                                    <option value="S09">S09</option>
                                    </select><br>

                            </ul>
                
                        </div>
                    
                        <div class="mb-3 my-4">
                            <label for="exampleFormControlTextarea1" class="form-label" style="font-size: 18px; font-weight: 500;">เพิ่มเติม</label></label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="text_add"></textarea>
                        </div>

                            <button type="submit" id="submitForm" name="submit_form" class="btn my-4" style="border:none; width: 100%; color: white; padding: 10px;">บันทึกข้อมูล</button>
                            {{-- <p class="textrow" style="text-align: center;"><span>กรุณาติดต่อเจ้าหน้าที่ เมื่อดำเนินการเรียบร้อย</span></p> --}}
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
                        url: '/webpanel/customer-create/update-amphure',
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
                        url: '/webpanel/customer-create/update-district',
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
                    url: '/webpanel/customer-create/update-amphure',
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
                        url: '/webpanel/customer-create/update-district',
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
                        url: '/webpanel/customer-create/update-zipcode',
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
                        url: '/webpanel/customer-create/update-zipcode',
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

    <script>
        $(document).ready(function() {
            $('.datepicker').datepicker();
        });
    </script>
@endsection
</body>
</html>
