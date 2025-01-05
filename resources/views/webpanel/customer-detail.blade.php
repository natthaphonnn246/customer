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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
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
        #certStore {
            background-color: #e7e7e7;
            color: rgb(161, 161, 161);
            height: 40px;
            padding: 9px;
        }
        #certStore:hover {
            width: auto;
            height: auto;
            height: 40px;
            color: rgb(161, 161, 161);
            background-color: #dadada;
        }
        #certMedical {
            background-color: #e7e7e7;
            color: rgb(161, 161, 161);
            height: 40px;
            padding: 9px;
        }
        #certMedical:hover {
            width: auto;
            height: auto;
            height: 40px;
            color: rgb(161, 161, 161);
            background-color: #dadada;
        }
        #certCommerce {
            background-color: #e7e7e7;
            color: rgb(161, 161, 161);
            height: 40px;
            padding: 9px;
        }
        #certCommerce:hover {
            width: auto;
            height: auto;
            height: 40px;
            color: rgb(161, 161, 161);
            background-color: #dadada;
        }
        #certVat {
            background-color: #e7e7e7;
            color: rgb(161, 161, 161);
            height: 40px;
            padding: 9px;
        }
        #certVat:hover {
            width: auto;
            height: auto;
            height: 40px;
            color: rgb(161, 161, 161);
            background-color: #dadada;
        }
        #certId {
            background-color: #e7e7e7;
            color: rgb(161, 161, 161);
            height: 40px;
            padding: 9px;
        }
        #certId:hover {
            width: auto;
            height: auto;
            height: 40px;
            color: rgb(161, 161, 161);
            background-color: #dadada;
        }
        #submitUpload {
            background-color: #4355ff;
            color:white;
            width: 90px;
            height: 40px;
        }
        #submitUpload:hover {
            width: 90px;
            height: 40px;
            background-color: #0f21cb;
        }
        #cancelUpload {
            background-color: #f55151;
            color:white;
            width: 90px;
            height: 40px;
        }
        #cancelUpload:hover {
            width: 90px;
            height: 40px;
            background-color: #de0505;
        }

    </style>
    
    <div class="contentArea" id="bg">

        <div style="text-align: left; margin-top: 10px;">
            <span style="color: #8E8E8E;"><a href="/webpanel/customer" id="backLink">ลูกค้าทั้งหมด (Customer)</a> / แบบฟอร์ม</span>

        </div>
        <hr style="color: #8E8E8E; width: 100%;">

        @if(isset($customer_view) != '')
        @foreach($customer_view as $row_view)
        <form id="form">
            @csrf

                <div class="row">
                    <div class="col-sm-6">
                        <ul class="text-title" style="text-align: start; margin-top: 25px;">
                            <span style="font-size: 16px; font-weight: 500; color:#545454;">ลงทะเบีนนลูกค้าใหม่</span>
                            <hr>
                        </ul>
                        <ul class="text-muted" style="padding-top: 10px;">
                            <span>ใบอนุญาตขายยา/สถานพยาบาล</span> <span style="font-size: 12px; color:red;">*จำเป็นต้องระบุ</span></br>
                            <div class="btn btn-primary my-2" style="width:100%; border:none;" id="certStore" >ใบอนุญาตขายยา/สถานพยาบาล</div>
                            <hr>

                            <span>ใบประกอบวิชาชีพ</span> <span style="font-size: 12px; color:red;">*จำเป็นต้องระบุ</span>
                            <div class="btn btn-primary my-2" style="width:100%; border:none;" id="certMedical" >ใบประกอบวิชาชีพ</div>
                            <hr>
                            {{-- <input style="margin-top:10px;" type="file" class="form-control text-muted" name="cert_medical" accept="image/png, image/jpg, image/jpeg"><br> --}}

                            <span>ใบทะเบียนพาณิชย์</span>
                            <div class="btn btn-primary my-2" style="width:100%; border:none;" id="certCommerce" >ใบทะเบียนพาณิชย์</div>
                            <hr>
                            {{-- <input style="margin-top:10px;" type="file" class="form-control text-muted" name="cert_commerce" accept="image/png, image/jpg, image/jpeg"><br> --}}

                            <span>ใบทะเบียนภาษีมูลค่าเพิ่ม (ภ.พ.20)</span>
                            <div class="btn btn-primary my-2" style="width:100%; border:none;" id="certVat" >ใบทะเบียนภาษีมูลค่าเพิ่ม (ภ.พ.20)</div>
                            <hr>
                            {{-- <input style="margin-top:10px;" type="file" class="form-control text-muted" name="cert_vat" accept="image/png, image/jpg, image/jpeg"><br> --}}

                            <span>สำเนาบัตรประชาชน</span>
                            <div class="btn btn-primary my-2" style="width:100%; border:none;" id="certId" >สำเนาบัตรประชาชน</div>
                            <hr>
                            {{-- <input style="margin-top:10px;" type="file" class="form-control text-muted" name="cert_id" accept="image/png, image/jpg, image/jpeg"><br> --}}

                            <span>เลขใบอนุญาตขายยา/สถานพยาพยาล</span> <span style="font-size: 12px; color:red;">*จำเป็นต้องระบุ หากไม่มีให้ใส่ 0</span>
                            <input style="margin-top:10px; color: rgb(171, 171, 171);" type="text" class="form-control" name="cert_number" value="{{$row_view->cert_number}}"><br>

                            <span>วันหมดอายุ</span> <span style="font-size: 12px; color:red;">*จำเป็นต้องระบุ</span>
                            <input id="date" style="margin-top:10px;  color: rgb(171, 171, 171);" type="date"  class="form-control" name="cert_expire" value="{{$row_view->cert_expire}}"><br>

                        </ul>

                        <ul class="text-title" style="text-align: start; margin-top: 20px;">
                            <span style="font-size: 16px; font-weight: 500; color:#545454;">ข้อมูลลูกค้า</span> <span style="font-size: 12px; color:red;">*จำเป็นต้องระบุให้ครบทุกช่อง</span>
                            <hr>
                        </ul>
                        <div class="row text-muted">
                            <div class="col-sm-12">
                                <ul style="width: 100%;">
                                    <span>ชื่อร้านค้า/สถานพยาบาล</span>
                                    <input style="margin-top:10px; color: rgb(171, 171, 171);" type="text" class="form-control" name="customer_name" value="{{$row_view->customer_name}}">
                                </ul>

                                @error('customer_name')

                                <div class="alert alert-danger my-2" role="alert">
                                    {{$message}}
                                </div>
                               
                                @enderror

                            </div>
                            <div class="col-sm-6">
                                <ul style="width: 100%;">
                                    <span>CODE</span><span style="font-size: 12px; color:red;">*จำเป็นต้องระบุ</span>
                                    <input style="margin-top:10px; color: rgb(171, 171, 171);" type="text" class="form-control" name="customer_code" value="{{$row_view->customer_code}}" >
                                </ul>

                                @error('customer_code')

                                <div class="alert alert-danger my-2" role="alert">
                                    {{$message}}
                                </div>
                               
                                @enderror

                            </div>
                            <div class="col-sm-6">
                                <ul style="width: 100%;">
                                    <span>ระดับราคา</span><span style="font-size: 12px; color:red;">*ลูกค้า 6 เท่ากับ 1</span>
                                    <select class="form-select" style="margin-top:10px; color: rgb(171, 171, 171);" aria-label="Default select example" name="price_level">
                                    
                                        <option name="price_level" {{$row_view->price_level == 1 ? 'selected' : '' }} value="1">1</option>
                                        <option name="price_level" {{$row_view->price_level == 2 ? 'selected' : '' }} value="2">2</option>
                                        <option name="price_level" {{$row_view->price_level == 3 ? 'selected' : '' }} value="3">3</option>
                                        <option name="price_level" {{$row_view->price_level == 4 ? 'selected' : '' }} value="4">4</option>
                                        <option name="price_level" {{$row_view->price_level == 5 ? 'selected' : '' }}value="5">5</option>

                                    </select>
                                </ul>
                            </div>
                            <div class="col-sm-12">
                                <ul style="width: 100%;">
                                    <span>อีเมล</span>
                                    <input style="margin-top:10px; color: rgb(171, 171, 171);" name="email" type="email" class="form-control" name="email" value="{{$row_view->email}}"><br>
                                    <span>เบอร์ร้านค้า</span> <span style="font-size: 12px; color:gery;">(ตัวอย่าง: 021234567)</span>
                                    <input style="margin-top:10px; color: rgb(171, 171, 171);" type="text" class="form-control" name="phone" value="{{$row_view->phone}}"><br>
                                    <span>เบอร์มือถือ</span> <span style="font-size: 12px; color:red;">*จำเป็นต้องระบุ</span> <span style="font-size: 12px; color:gery;">(ตัวอย่าง: 0812345678)</span>
                                    <input style="margin-top:10px; color: rgb(171, 171, 171);" type="text" class="form-control" name="telephone" value="{{$row_view->telephone}}"><br>
                                    <span>ที่อยู่จัดส่ง</span>
                                    <input style="margin-top:10px; color: rgb(171, 171, 171);" type="text" class="form-control" name="address" value="{{$row_view->address}}">                              
                                </ul>
                            </div>
                            <div class="col-sm-6">
                                <ul style="width: 100%;">
                                    <span>จังหวัด</span>
                                    {{-- <input style="margin-top:10px; color: grey;" type="text" class="form-control" name="province"> --}}
            
                                    <select class="form-select" style="margin-top:10px; color: rgb(171, 171, 171);" aria-label="Default select example" name="province" id="province">
                                        @if(isset($province) != '')
                                        @foreach($province as $row)
                        
                                            <option value="{{$row->id}}" {{$row->name_th == $row_view->province ? 'selected' : '' ;}}>{{$row->name_th}}</option>
                                        
                                        @endforeach
                                    @endif
                                    </select>
                                </ul>
                            </div>
                            <div class="col-sm-6">
                                <ul style="width: 100%;">
                                    <span>อำเภอ/แขวง</span>
                                    <select class="form-select" style="margin-top:10px; color: rgb(171, 171, 171);" aria-label="Default select example" name="amphur" id="amphures">
                                        
                                        @if(isset($amphur) == '')
                                        @foreach($amphur as $row)
                                            <option value="{{$row->province_id}}" {{$row->name_th == $row_view->amphur ? 'selected' : '' ;}}>{{$row->name_th}}</option>
                                        @endforeach

                                        @else
                                        <option>{{$row_view->amphur}}</option>
                                        @endif
                                    </select>
                                </ul>
                            </div>
                            <div class="col-sm-6">
                                <ul style="width: 100%;">
                                    <span>ตำบล/เขต</span>
                                    <select class="form-select" style="margin-top:10px; color: rgb(171, 171, 171);" aria-label="Default select example" name="district" id="districts">
                                        @if(isset($district) == '')
                                        @foreach($district as $row)
                                            <option value="{{$row->amphure_id}}" {{$row->name_th == $row_view->district ? 'selected' : '' ;}}>{{$row->name_th}}</option>
                                        @endforeach

                                        @else
                                        <option>{{$row_view->district}}</option>
                                        @endif
                                    </select>
                                </ul>
                            </div>
                            <div class="col-sm-6">
                                <ul style="width: 100%;">
                                    <span>รหัสไปรษณีย์</span> <span style="font-size: 12px; color:red;">*กรุณาตรวจสอบ</span>
                                    <input style="margin-top:10px; color:rgb(171, 171, 171);" type="text" class="form-control" id="zipcode" name="zip_code" value="{{$row_view->zip_code}}">
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!--form login-->
                        <div class="col-sm-6" style="padding-top:20px;">
                            <div class="form-control">
                                <ul class="text-title" style="text-align: start; margin-top: 10px;">
                                    <span style="font-size: 16px; font-weight: 500; color:#545454;">ข้อมูลผู้รับผิดชอบ</span>
                                    <hr>
                                </ul>
                                <ul class="text-muted" style="padding-top: 10px;">
                                <label></label>
                                    <span>แอดมินผู้ดูแล</span> <span style="font-size: 12px; color:red;">*จำเป็นต้องระบุ</span>
                                    <select class="form-select" style="margin-top:10px;  color: rgb(171, 171, 171);" aria-label="Default select example" name="admin_area">

                                            <option {{$row_view->admin_area == 'A01' ? 'selected': ''}} value="A01">A01</option>
                                            <option {{$row_view->admin_area == 'A02' ? 'selected': ''}} value="A02">A02</option>
                                            <option {{$row_view->admin_area == 'A03' ? 'selected': ''}} value="A03">A03</option>

                                        </select><br>
    
                                    <span>พนักงานขาย/เขตการขาย</span> <span style="font-size: 12px; color:red;">*จำเป็นต้องระบุ</span>
                                        <select class="form-select" style="margin-top:10px;  color: rgb(171, 171, 171);" aria-label="Default select example" name="sale_area">

                                            <option {{$row_view->sale_area == ' ' ? 'selected': ''}} value=""> ไม่ระบุ </option>
                                            <option {{$row_view->sale_area == 'S01' ? 'selected': ''}} value="S01">S01</option>
                                            <option {{$row_view->sale_area == 'S02' ? 'selected': ''}} value="S02">S02</option>
                                            <option {{$row_view->sale_area == 'S03' ? 'selected': ''}} value="S03">S03</option>
                                            <option {{$row_view->sale_area == 'S04' ? 'selected': ''}} value="S04">S04</option>
                                            <option {{$row_view->sale_area == 'S05' ? 'selected': ''}} value="S05">S05</option>
                                            <option {{$row_view->sale_area == 'S06' ? 'selected': ''}} value="S06">S06</option>
                                            <option {{$row_view->sale_area == 'S07' ? 'selected': ''}} value="S07">S07</option>
                                            <option {{$row_view->sale_area == 'S08' ? 'selected': ''}} value="S08">S08</option>
                                            <option {{$row_view->sale_area == 'S09' ? 'selected': ''}} value="S09">S09</option>
                                            <option {{$row_view->sale_area == 'S10' ? 'selected': ''}} value="S10">S10</option>
                                            <option {{$row_view->sale_area == 'S11' ? 'selected': ''}} value="S11">S11</option>
                                            <option {{$row_view->sale_area == 'S12' ? 'selected': ''}} value="S12">S12</option>
                                            <option {{$row_view->sale_area == 'S13' ? 'selected': ''}} value="S13">S13</option>
                                            <option {{$row_view->sale_area == 'S14' ? 'selected': ''}} value="S14">S14</option>

                                        </select><br>

                                </ul>
                    
                            </div>

                            <div class="mb-3 my-4">
                                <div class="form-control">
                                    <ul class="text-title" style="text-align: start; margin-top: 10px;">
                                        <span style="font-size: 16px; font-weight: 500; color:#545454;">ตั้งค่ารหัสผ่านและสถานะบัญชี</span>
                                        <hr>
                                    </ul>
                                    <ul class="text-muted" style="padding-top: 10px;">
                                    <label></label>
                                        <span>สถานะบัญชี</span> <span style="font-size: 12px; color:red;">*จำเป็นต้องระบุ</span>
                                        <select class="form-select" style="margin-top:10px; color: rgb(171, 171, 171);" aria-label="Default select example" name="status">
    
                                                <option {{$row_view->status == '0' ? 'selected': ''}} value="0">รอดำเนินการ</option>
                                                <option {{$row_view->status== '1' ? 'selected': ''}} value="1">ต้องดำเนินการ</option>
                                                <option {{$row_view->status == '2' ? 'selected': ''}} value="2">ดำเนินการแล้ว</option>
                                        
    
                                            </select><br>
        
                                        <span>รหัสผ่านลูกค้า</span> <span style="font-size: 12px; color:red;">*จำเป็นต้องระบุ</span>
                                        
                                        <input style="margin-top:10px; color: rgb(171, 171, 171);" type="password" class="form-control" name="password" value="{{$row_view->password}}">
                                        <input style="margin-top:10px; color: rgb(171, 171, 171);" type="text" class="form-control" name="password" value="{{$row_view->password}}" disabled><br>
    
                                    </ul>
                        
                                </div>

                                     
                                <div class="mb-3 my-4">
                                    <label for="exampleFormControlTextarea1" class="form-label" style="font-size: 16px; font-weight: 500; color:#545454;">เพิ่มเติม</label></label>
                                    <textarea class="form-control" style="color: rgb(171, 171, 171);" id="exampleFormControlTextarea1" rows="3" name="text_add">{{$row_view->text_area}}</textarea>
                                </div>

                                <div class="mb-3 my-4">
                                    <label for="exampleFormControlTextarea1" class="form-label" style="font-size: 16px; font-weight: 500; color:#545454;">ข้อความส่งถึงแอดมินผู้ดูแล</label></label>
                                    <textarea class="form-control" style="color: rgb(171, 171, 171);" id="exampleFormControlTextarea1" rows="3" name="text_admin">{{$row_view->text_admin}}</textarea>
                                </div>

                                <div style="text-align:right;">
                                    <button type="button" id="updateForm" name="submit_update" class="btn my-2" style="border:none; width: 100px; color: white; padding: 10px;">บันทึก</button>
                                    <a href="" type="button" id="exportCsv" class="btn my-2" style="border:none; width: 120px; color: rgb(67, 67, 67); padding: 10px;">Export CSV</a>
        
                                </div>
                        </div>
                </div>

                                <!--- update user information-->
                                    <script>
                                            $('#updateForm').click(function() {
                                                
                                                $('#bg').css('display', 'none');
                                                let user = $('#form').serialize();

                                                $.ajax({
                                                    url: '/webpanel/customer-detail/update/{{$row_view->customer_code}}',
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

        <!--- php upload ใบอนุญาตขายยา/สถานพยาบาล--->
        <script>

                $(document).ready(function(){
                    $('#certStore').click(function(){
                        // e.preventDefault(); ปิดใช้งาน submit ปกติ
                        Swal.fire ({
                            html:
                            '<p style="text-align: start;">แก้ไขใบอนุญาตขายยา/สถานพยาบาล <?php echo 1 ;?></p>'
                            +'<hr>'
                            +'<form action="/webpanel/customer-detail/upload-store/{{$row_view->customer_code}}" method="post" enctype="multipart/form-data">'
                            +'@csrf'
                            +'<img src="/storage/certs/{{$row_view->cert_store ; }}" id="fileImage" style="width: 100%";/>'
                            +'<hr>'
                            +'<input type="file" id="image" class="form-control" name="cert_store" style="margin-top: 10px;"; accept="image/png, image/jpg, image/jpeg"/>'
                            +'<hr>'
                            +'<div style="margin-top: 10px; text-align: end;">'
                            +'<button type="submit" name="submit_store" class="btn" id="submit_store" style="margin: 5px;">บันทึก</button>'
                            +'<button onclick="closeWin()" type="button" onclick="closeOpenedWindow()" class="btn" id="cancelUpload" data-dismiss="modal">ยกเลิก</button>'
                            +'</div>'
                            + '</form>',
                            showConfirmButton: false, 

                            // confirmButtonText: 'บันทึก',
                            // showCancelButton: true,
                        
                            });

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

        <!--- php upload ใบประกอบวิชาชีพ--->
        <script>

                $(document).ready(function(){
                    $('#certMedical').click(function(){
                        // e.preventDefault(); ปิดใช้งาน submit ปกติ
                        Swal.fire ({
                            html:
                            '<p style="text-align: start;">แก้ไขใบประกอบวิชาชีพ <?php echo 1 ;?></p>'
                            +'<hr>'
                            +'<form action="/webpanel/customer-detail/upload-medical/{{$row_view->customer_code}}" method="post" enctype="multipart/form-data">'
                            +'@csrf'
                            +'<img src="/storage/certs/{{$row_view->cert_medical ; }}" id="fileImage" style="width: 100%";/>'
                            +'<hr>'
                            +'<input type="file" id="image" class="form-control" name="cert_medical" style="margin-top: 10px;"; accept="image/png, image/jpg, image/jpeg"/>'
                            +'<hr>'
                            +'<div style="margin-top: 10px; text-align: end;">'
                            +'<button type="submit" name="submit_medical" class="btn" id="submit_medical" style="margin: 5px;">บันทึก</button>'
                            +'<button onclick="closeWin()" type="button" onclick="closeOpenedWindow()" class="btn" id="cancelUpload" data-dismiss="modal">ยกเลิก</button>'
                            +'</div>'
                            + '</form>',
                            showConfirmButton: false, 

                            // confirmButtonText: 'บันทึก',
                            // showCancelButton: true,
                        
                            });

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

        <!--- php upload ใบทะเบียนพาณิชย์--->
        <script>

                $(document).ready(function(){
                    $('#certCommerce').click(function(){
                        // e.preventDefault(); ปิดใช้งาน submit ปกติ
                        Swal.fire ({
                            html:
                            '<p style="text-align: start;">แก้ไขใบทะเบียนพาณิชย์ <?php echo 1 ;?></p>'
                            +'<hr>'
                            +'<form action="/webpanel/customer-detail/upload-commerce/{{$row_view->customer_code}}" method="post" enctype="multipart/form-data">'
                            +'@csrf'
                            +'<img src="/storage/certs/{{$row_view->cert_commerce ; }}" id="fileImage" style="width: 100%";/>'
                            +'<hr>'
                            +'<input type="file" id="image" class="form-control" name="cert_commerce" style="margin-top: 10px;"; accept="image/png, image/jpg, image/jpeg"/>'
                            +'<hr>'
                            +'<div style="margin-top: 10px; text-align: end;">'
                            +'<button type="submit" name="submit_commerce" class="btn" id="submitUpload" style="margin: 5px;">บันทึก</button>'
                            +'<button onclick="closeWin()" type="button" onclick="closeOpenedWindow()" class="btn" id="cancelUpload" data-dismiss="modal">ยกเลิก</button>'
                            +'</div>'
                            + '</form>',
                            showConfirmButton: false, 

                            // confirmButtonText: 'บันทึก',
                            // showCancelButton: true,
                        
                            });

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

         <!--- php upload ใบทะเบียนภาษีมูลค่าเพิ่ม (ภ.พ.20)--->
         <script>

                    $(document).ready(function(){
                        $('#certVat').click(function(){
                            // e.preventDefault(); ปิดใช้งาน submit ปกติ
                            Swal.fire ({
                                html:
                                '<p style="text-align: start;">แก้ไขใบภาษีมูลค่าเพิ่ม (ภ.พ.20)</p>'
                                +'<hr>'
                                +'<form action="/webpanel/customer-detail/upload-vat/{{$row_view->customer_code}}" method="post" enctype="multipart/form-data">'
                                +'@csrf'
                                +'<img src="/storage/certs/{{$row_view->cert_vat; }}" id="fileImage" style="width: 100%";/>'
                                +'<hr>'
                                +'<input type="file" id="image" class="form-control" name="cert_vat" style="margin-top: 10px;"; accept="image/png, image/jpg, image/jpeg"/>'
                                +'<hr>'
                                +'<div style="margin-top: 10px; text-align: end;">'
                                +'<button type="submit" name="submit_vat" class="btn" id="submitUpload" style="margin: 5px;">บันทึก</button>'
                                +'<button onclick="closeWin()" type="button" onclick="closeOpenedWindow()" class="btn" id="cancelUpload" data-dismiss="modal">ยกเลิก</button>'
                                +'</div>'
                                + '</form>',
                                showConfirmButton: false, 

                                // confirmButtonText: 'บันทึก',
                                // showCancelButton: true,
                            
                                });

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


         <!--- php upload สำเนาบัตรประจำตัวประชาชน--->
         <script>

                    $(document).ready(function(){
                        $('#certId').click(function(){
                            // e.preventDefault(); ปิดใช้งาน submit ปกติ
                            Swal.fire ({
                                html:
                                '<p style="text-align: start;">แก้ไขสำเนาบัตรประจำตัวประชาชน</p>'
                                +'<hr>'
                                +'<form action="/webpanel/customer-detail/upload-id/{{$row_view->customer_code}}" method="post" enctype="multipart/form-data">'
                                +'@csrf'
                                +'<img src="/storage/certs/{{$row_view->cert_id; }}" id="fileImage" style="width: 100%";/>'
                                +'<hr>'
                                +'<input type="file" id="image" class="form-control" name="cert_id" style="margin-top: 10px;"; accept="image/png, image/jpg, image/jpeg"/>'
                                +'<hr>'
                                +'<div style="margin-top: 10px; text-align: end;">'
                                +'<button type="submit" name="submit_id" class="btn" id="submitUpload" style="margin: 5px;">บันทึก</button>'
                                +'<button onclick="closeWin()" type="button" onclick="closeOpenedWindow()" class="btn" id="cancelUpload" data-dismiss="modal">ยกเลิก</button>'
                                +'</div>'
                                + '</form>',
                                showConfirmButton: false, 

                                // confirmButtonText: 'บันทึก',
                                // showCancelButton: true,
                            
                                });

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

            @endforeach
        @endif
@endsection
</body>
</html>
