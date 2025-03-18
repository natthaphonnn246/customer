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

    <title>cms.vmdrug</title>
</head>
<body>

<div id="bgs">
    @extends ('portal/menuportal-tailwind')
    <div>
    @section('content')
    @csrf


    <style>
        .contentArea {
            /* padding: 20px 30px 40px; */
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
            background-color: #ebebeb;
            color:rgb(103, 103, 103);
            width: 80px;
            height: 40px;
        }
        #cancelUpload:hover {
            width: 80px;
            height: 40px;
            color:rgb(103, 103, 103);
            background-color: #cbcbcb;
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
    <div class="contentArea">

        @section('col-2')

        @if(isset($user_name))
            <h6 class="mt-1" style="">{{$user_name->name}}</h6>
            @endif
        @endsection

        @section('status_alert')
        @if(!($user_name->rights_area) == '0')
            <h6 class="justifiy-content:center;" style="">{{$count_alert}}</h6>
            @endif
        @endsection

        @section('status_all')
        @if(!($user_name->rights_area) == '0')
            <h6 class="justifiy-content:center;" style="">{{$count_all}}</h6>
            @endif
        @endsection

        @section('status_waiting')
        @if(!($user_name->rights_area) == '0')
            <h6 class="justifiy-content:center;" style="">{{$count_waiting}}</h6>
            @endif
        @endsection

        @section('status_action')
        @if(!($user_name->rights_area) == '0')
            <h6 class="justifiy-content:center;" style="">{{$count_action}}</h6>
            @endif
        @endsection

        @section('status_completed')
        @if(!($user_name->rights_area) == '0')
            <h6 class="justifiy-content:center;" style="">{{$count_completed}}</h6>
            @endif
        @endsection

        <div class="py-2">
        </div>
        <span class="ms-6" style="color: #8E8E8E;"><a href="/portal/customer" id="backLink">ลูกค้าทั้งหมด (Customer)</a> / รายละเอียด</span>
        <hr class="my-3" style="color: #8E8E8E; width: 100%; border:solid 2px;">
    @if (isset($customer_edit) != '')

    <div class="ms-6 mr-6">
        <form id="form">
            {{-- action="/webpanel/admin-detail/update/{{$row_edit->user_code}}" enctype="multipart/form-data" --}}
            @csrf
            <div class="row">
                <div class="col-sm-6">
                    <ul class="text-title" style="margin-top: 20px;">
                        <span style="font-size: 18px; font-weight: 500; color:#303030;">ข้อมูลลูกค้า</span>
                        <hr style="color: #8E8E8E; width: 100%; margin-top: 15px;">
                    </ul>
                    <ul class="text-muted py-3" style="padding-top: 10px;">
                        <span>ใบอนุญาตขายยา/สถานพยาบาล</span>
                        <div class="btn btn-primary my-2" style="width:100%; border:none;" id="certStore" >ใบอนุญาตขายยา/สถานพยาบาล</div>
                        @if ($customer_edit->cert_store == '')
                        <span style="font-size: 14px; color:red; background-color:#f6ff94; padding:5px; font-weight:500;">**ไม่พบเอกสาร กรุณาตรวจสอบด้วยครับ</span>
                        @endif
                        <hr class="py-2" style="color: #8E8E8E; width: 100%; margin-top: 15px;">

                        <span>ใบประกอบวิชาชีพ</span>
                        <div class="btn btn-primary my-2" style="width:100%; border:none;" id="certMedical" >ใบประกอบวิชาชีพ</div>
                        @if ($customer_edit->cert_medical == '')
                        <span style="font-size: 14px; color:red; background-color:#f6ff94; padding:5px; font-weight:500;">**ไม่พบเอกสาร กรุณาตรวจสอบด้วยครับ</span>
                        @endif
                        <hr class="py-2" style="color: #8E8E8E; width: 100%; margin-top: 15px;">
                        {{-- <input style="margin-top:10px;" type="file" class="form-control text-muted" name="cert_medical" accept="image/png, image/jpg, image/jpeg"><br> --}}

                        <span>ใบทะเบียนพาณิชย์</span>
                        <div class="btn btn-primary my-2" style="width:100%; border:none;" id="certCommerce" >ใบทะเบียนพาณิชย์</div>
                        @if ($customer_edit->cert_commerce == '')
                        <span style="font-size: 14px; color:red; background-color:#f6ff94; padding:5px; font-weight:500;">**ไม่พบเอกสาร กรุณาตรวจสอบด้วยครับ</span>
                        @endif
                        <hr class="py-2" style="color: #8E8E8E; width: 100%; margin-top: 15px;">
                        {{-- <input style="margin-top:10px;" type="file" class="form-control text-muted" name="cert_commerce" accept="image/png, image/jpg, image/jpeg"><br> --}}

                        <span>ใบทะเบียนภาษีมูลค่าเพิ่ม (ภ.พ.20)</span>
                        <div class="btn btn-primary my-2" style="width:100%; border:none;" id="certVat" >ใบทะเบียนภาษีมูลค่าเพิ่ม (ภ.พ.20)</div>
                        @if ($customer_edit->cert_vat == '')
                        <span style="font-size: 14px; color:red; background-color:#f6ff94; padding:5px; font-weight:500;">**ไม่พบเอกสาร กรุณาตรวจสอบด้วยครับ</span>
                        @endif
                        <hr class="py-2" style="color: #8E8E8E; width: 100%; margin-top: 15px;">
                        {{-- <input style="margin-top:10px;" type="file" class="form-control text-muted" name="cert_vat" accept="image/png, image/jpg, image/jpeg"><br> --}}

                        <span>สำเนาบัตรประชาชน</span>
                        <div class="btn btn-primary my-2" style="width:100%; border:none;" id="certId" >สำเนาบัตรประชาชน</div>
                        @if ($customer_edit->cert_id == '')
                        <span style="font-size: 14px; color:red; background-color:#f6ff94; padding:5px; font-weight:500;">**ไม่พบเอกสาร กรุณาตรวจสอบด้วยครับ</span>
                        @endif
                        <hr class="py-2" style="color: #8E8E8E; width: 100%; margin-top: 15px;">
                        {{-- <input style="margin-top:10px;" type="file" class="form-control text-muted" name="cert_id" accept="image/png, image/jpg, image/jpeg"><br> --}}

                        <li class="py-2">
                            <span>เลขใบอนุญาตขายยา/สถานพยาพยาล</span> <span style="font-size: 12px; color:red;">*จำเป็นต้องระบุ</span>
                            <input style="margin-top:10px; color: rgb(171, 171, 171);" type="text" class="form-control" name="cert_number" value="{{$customer_edit->cert_number}}">
                        </li>
                        <li class="py-2">
                            <span>วันหมดอายุ</span> <span style="font-size: 12px; color:red;">*จำเป็นต้องระบุ</span>
                            <input class="form-control" style="margin-top:10px; color:rgb(171, 171, 171);" type="text" id="datepicker" name="cert_expire" value="{{$customer_edit->cert_expire}}">
                        </li>
                        <script>
                            $(document).ready(function () {
                                // Datepicker
                                    $("#datepicker" ).datepicker({
                                        changeMonth: true,
                                        changeYear: true,
                                        yearRange: "2024:2029",
                                        dateFormat: "dd/mm/yy",
                                       
                                        
                                    });
    
                                });
                        </script>
                    </ul>
                    <div class="row text-muted">
                        <div class="col-sm-12">
                            <ul class="py-2" style="width: 100%;">
                                <span>ชื่อร้านค้า</span>
                                <input style="margin-top:10px; color: rgb(171, 171, 171);" type="text" class="form-control" name="customer_name" value="{{$customer_edit->customer_name}}" disabled>
                            </ul>
                            <ul class="py-2" style="width: 100%;">
                                <span>CODE</span> <span style="font-size: 12px; color:red;">*จำเป็นต้องระบุ</span>
                                <input style="margin-top:10px; color: rgb(171, 171, 171);" type="text" class="form-control" name="code" value="{{$customer_edit->customer_code;}}" disabled>
                            </ul>
                            <ul class="py-2" style="width: 100%;">
                                <span>ระดับราคา</span><span style="font-size: 12px; color:red;">*ลูกค้า 6 เท่ากับ 1</span>
                                <select class="form-select" style="margin-top:10px; color: rgb(171, 171, 171);" aria-label="Default select example" name="price_level" disabled>
                                
                                    <option name="price_level">{{$customer_edit->price_level}}</option>

                                </select>
                            </ul>
                           {{-- {{dd($customer_edit->cert_expire);}} --}}
                        </div>
                 
                        <div class="col-sm-12">
                            <ul class="py-3" style="width: 100%;">
                                <li class="py-2">
                                    <span>อีเมล</span>
                                    <input style="margin-top:10px; color: rgb(171, 171, 171);" name="email" type="email" class="form-control" name="email" value="{{$customer_edit->email}}">
                                </li>
                                <li class="py-2">
                                    <span>เบอร์ติดต่อ</span> <span style="font-size: 12px; color:gery;">(ตัวอย่าง: 027534702)</span>
                                    <input style="margin-top:10px; color: rgb(171, 171, 171);" type="text" class="form-control" name="phone" value="{{$customer_edit->phone}}">
                                </li>
                                <li class="py-2">
                                    <span>เบอร์โทรศัพท์</span> <span style="font-size: 12px; color:gery;">(ตัวอย่าง: 0904545555)</span>
                                    <input style="margin-top:10px; color: rgb(171, 171, 171);" type="text" class="form-control" name="telephone" value="{{$customer_edit->telephone}}">
                                </li>
                                <li class="mt-3">
                                    <span>การจัดส่งสินค้า</span><span style="font-size: 12px; color:red;"> *ไม่ระบุ คือ จัดส่งตามรอบขนส่งทางร้าน</span>
                                    <select class="form-select" style="margin-top:10px; color: rgb(171, 171, 171);" aria-label="Default select example" name="delivery_by">
                                    <option {{$customer_edit->delivery_by == 'owner' ? 'selected': ''}} value="owner">ไม่ระบุ</option>
                                    <option {{$customer_edit->delivery_by == 'private' ? 'selected': ''}} value="private">ขนส่งเอกชน (พัสดุ)</option>
                                    </select>
                                </li>
                                <li class="mt-4">
                                    <span>ที่อยู่</span>
                                    <input style="margin-top:10px; color: rgb(171, 171, 171);" type="text" class="form-control" name="address" value="{{$customer_edit->address}}">
                                </li>                              
                            </ul>
                        </div>
                        <div class="col-sm-6 py-3">
                            <ul style="width: 100%;">
                                <span>จังหวัด</span>
                                {{-- <input style="margin-top:10px; color: grey;" type="text" class="form-control" name="province"> --}}

                                <select class="form-select" style="margin-top:10px; color: rgb(171, 171, 171);" aria-label="Default select example" name="province" id="province">
                                    @if(isset($province) != '')
                                        @foreach($province as $row)
                        
                                            <option value="{{$row->id}}" {{$row->name_th == $customer_edit->province ? 'selected' : '' ;}}>{{$row->name_th}}</option>
                                        
                                        @endforeach
                                    @endif
                                </select>
                            </ul>
                        </div>
                        <div class="col-sm-6 py-3">
                            <ul style="width: 100%;">
                                <span>อำเภอ/เขต</span>
                                <select class="form-select" style="margin-top:10px; color: rgb(171, 171, 171);" aria-label="Default select example" id="amphures" name="amphur">

                                    @if(isset($amphur) == '')
                                        @foreach($amphur as $row)
                                            <option value="{{$row->province_id}}" {{$row->name_th == $customer_edit->amphur ? 'selected' : '' ;}}>{{$row->name_th}}</option>
                                        @endforeach

                                    @else
                                    <option>{{$customer_edit->amphur}}</option>
                                    @endif
                                </select>
                            </ul>
                        </div>
                        <div class="col-sm-6">
                            <ul class="mb-8" style="width: 100%;">
                                <span>ตำบล/แขวง</span>
                                <select class="form-select" style="margin-top:10px; color: rgb(171, 171, 171);" aria-label="Default select example" name="district" id="districts">
                                    @if(isset($district) == '')
                                        @foreach($district as $row)
                                            <option value="{{$row->amphure_id}}" {{$row->name_th == $customer_edit->district ? 'selected' : '' ;}}>{{$row->name_th}}</option>
                                        @endforeach

                                    @else
                                    <option>{{$customer_edit->district}}</option>
                                    @endif
                                </select>
                            </ul>
                        </div>
                        <div class="col-sm-6">
                            <ul class="mb-6" style="width: 100%;">
                                <span>รหัสไปรษณีย์</span> <span style="font-size: 12px; color:red;">*กรุณาตรวจสอบ</span>
                                <input style="margin-top:10px; color: rgb(171, 171, 171);" type="text" class="form-control" name="zip_code" id="zipcode" value="{{$customer_edit->zip_code}}">
                            </ul>
                        </div>
                    </div>
                </div>
                <!--form login-->
                        <div class="col-sm-6" style="padding-top:40px;">
                        
                                <div class="form-control">
                                    <ul class="text-title" style="text-align: start; margin-top: 10px;">
                                        <span style="font-size: 16px; font-weight: 500; color:#545454;">ข้อมูลผู้รับผิดชอบ</span>
                                        <hr style="color: #8E8E8E; width: 100%; margin-top: 15px;">
                                    </ul>
                                    <ul class="text-muted" style="padding-top: 10px;">

                                        <li class="py-2">
                                        <span>แอดมินผู้ดูแล</span>
                                            <select class="form-select" style="margin-top:10px;  color: rgb(171, 171, 171);" aria-label="Default select example" name="admin_area" disabled>

                                                <option>{{$customer_edit->admin_area.' '.'('.$user_name->name.')'}}</option>

                                            </select>
                                        </li>
                                        <li class="py-2">
                                        <span>เขตการขาย</span>
                                            <select class="form-select" style="margin-top:10px;  color: rgb(171, 171, 171);" aria-label="Default select example" name="sale_area" disabled>

                                                @if(isset($sale_name))
                                                <option>{{$customer_edit->sale_area.' '.'('.$sale_name->sale_name.')'}}</option>
                                                @else
                                                <option>{{$customer_edit->sale_area.' '.'('.'ไม่พบชื่อ'.')'}}</option>
                                                @endif
                                            </select>
                                        </li>
                
                                    </ul>
                        
                                </div>

                                    <div class="mb-3 my-4">
                                        <label for="exampleFormControlTextarea1" class="form-label" style="font-size: 16px; font-weight: 500; color:#303030;">ข้อความถึงแอดมินผู้ดูแล</label></label>
                                        <textarea class="form-control" style="color: rgb(255, 86, 56);" id="exampleFormControlTextarea1" rows="3" name="text_admin" disabled>{{$customer_edit->text_admin}}</textarea>
                                    </div>
                               

                                <div style="text-align:right; margin-top: 20px;">
                                    <button type="button" id="updateForm" name="submit_update" class="btn my-2" style="border:none; width: 100px; color: white; padding: 10px;">บันทึก</button>
                                </div>

                        </div>
                    </div>
        </form>
    </div>
</div>

                    <!--- update user information-->
                    <script>
                            $('#updateForm').click(function() {
                                
                                $('#bgs').css('display', 'none');
                                let user = $('#form').serialize();

                                $.ajax({
                                    url: '/portal/customer-detail/update/{{$customer_edit->id}}',
                                    type: 'post',
                                    data: user,
                                    success: function(data) {

                                        if (data == 'success') {
                                            Swal.fire({
                                            title: '<span style="color:balck;">กรุณาติดต่อผู้ดูแล</span>',
                                            text: 'บันทึกเรียบร้อย',
                                            icon:'success',
                                            confirmButtonText: 'ตกลง'

                                            }).then((data)=>{
                                                $('#bgs').css('display', '');

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

    {{-- @endif --}}
                
                    <script>
                            
                        $('#province').change(function(e) {
                            e.preventDefault();
                            let province_id = $(this).val();
                            console.log(province_id);
                            
                                $.ajax({
                                    url: '/portal/signin/update-amphure',
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
                                    url: '/portal/signin/update-district',
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
                                url: '/portal/signin/update-amphure',
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
                                    url: '/portal/signin/update-district',
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
                                    url: '/portal/signin/update-zipcode',
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
                                    url: '/portal/signin/update-zipcode',
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
                                    '<p style="text-align: start;">แก้ไขใบอนุญาตขายยา/สถานพยาบาล/Code : {{$customer_edit->customer_code; }}</p>'
                                    +'<hr>'
                                    +'<form action="/portal/customer-detail/upload-store/{{$customer_edit->customer_code}}" method="post" enctype="multipart/form-data">'
                                    +'@csrf'
                                    +'<img src="/storage/certs/{{$customer_edit->cert_store ; }}" id="fileImage" style="width: 100%";/>'
                                    +'<hr>'
                                    +'<input type="file" id="image" class="form-control" name="cert_store" style="margin-top: 10px;"; accept="image/png, image/jpg, image/jpeg"/>'
                                    +'<hr>'
                                    +'<div style="margin-top: 10px; text-align: end;">'
                                    +'<button onclick="closeWin()" type="button" onclick="closeOpenedWindow()" class="btn" id="cancelUpload" data-dismiss="modal">ปิด</button>'
                                    +'<button type="submit" name="submit_store" class="btn" id="submitUpload" style="margin: 5px;">บันทึก</button>'
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
                                    '<p style="text-align: start;">แก้ไขใบประกอบวิชาชีพ/Code : {{$customer_edit->customer_code; }}</p>'
                                    +'<hr>'
                                    +'<form action="/portal/customer-detail/upload-medical/{{$customer_edit->customer_code}}" method="post" enctype="multipart/form-data">'
                                    +'@csrf'
                                    +'<img src="/storage/certs/{{$customer_edit->cert_medical ; }}" id="fileImage" style="width: 100%";/>'
                                    +'<hr>'
                                    +'<input type="file" id="image" class="form-control" name="cert_medical" style="margin-top: 10px;"; accept="image/png, image/jpg, image/jpeg"/>'
                                    +'<hr>'
                                    +'<div style="margin-top: 10px; text-align: end;">'
                                    +'<button onclick="closeWin()" type="button" onclick="closeOpenedWindow()" class="btn" id="cancelUpload" data-dismiss="modal">ปิด</button>'
                                    +'<button type="submit" name="submit_medical" class="btn" id="submitUpload" style="margin: 5px;">บันทึก</button>'
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
                                    '<p style="text-align: start;">แก้ไขใบทะเบียนพาณิชย์/Code : {{$customer_edit->customer_code; }}</p>'
                                    +'<hr>'
                                    +'<form action="/portal/customer-detail/upload-commerce/{{$customer_edit->customer_code}}" method="post" enctype="multipart/form-data">'
                                    +'@csrf'
                                    +'<img src="/storage/certs/{{$customer_edit->cert_commerce ; }}" id="fileImage" style="width: 100%";/>'
                                    +'<hr>'
                                    +'<input type="file" id="image" class="form-control" name="cert_commerce" style="margin-top: 10px;"; accept="image/png, image/jpg, image/jpeg"/>'
                                    +'<hr>'
                                    +'<div style="margin-top: 10px; text-align: end;">'
                                    +'<button onclick="closeWin()" type="button" onclick="closeOpenedWindow()" class="btn" id="cancelUpload" data-dismiss="modal">ปิด</button>'
                                    +'<button type="submit" name="submit_commerce" class="btn" id="submitUpload" style="margin: 5px;">บันทึก</button>'
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
                                    '<p style="text-align: start;">แก้ไขใบภาษีมูลค่าเพิ่ม (ภ.พ.20)/Code : {{$customer_edit->customer_code; }}</p>'
                                    +'<hr>'
                                    +'<form action="/portal/customer-detail/upload-vat/{{$customer_edit->customer_code}}" method="post" enctype="multipart/form-data">'
                                    +'@csrf'
                                    +'<img src="/storage/certs/{{$customer_edit->cert_vat; }}" id="fileImage" style="width: 100%";/>'
                                    +'<hr>'
                                    +'<input type="file" id="image" class="form-control" name="cert_vat" style="margin-top: 10px;"; accept="image/png, image/jpg, image/jpeg"/>'
                                    +'<hr>'
                                    +'<div style="margin-top: 10px; text-align: end;">'
                                    +'<button onclick="closeWin()" type="button" onclick="closeOpenedWindow()" class="btn" id="cancelUpload" data-dismiss="modal">ปิด</button>'
                                    +'<button type="submit" name="submit_vat" class="btn" id="submitUpload" style="margin: 5px;">บันทึก</button>'
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
                                        '<p style="text-align: start;">แก้ไขสำเนาบัตรประจำตัวประชาชน/Code : {{$customer_edit->customer_code; }}</p>'
                                        +'<hr>'
                                        +'<form action="/portal/customer-detail/upload-id/{{$customer_edit->customer_code}}" method="post" enctype="multipart/form-data">'
                                        +'@csrf'
                                        +'<img src="/storage/certs/{{$customer_edit->cert_id; }}" id="fileImage" style="width: 100%";/>'
                                        +'<hr>'
                                        +'<input type="file" id="image" class="form-control" name="cert_id" style="margin-top: 10px;"; accept="image/png, image/jpg, image/jpeg"/>'
                                        +'<hr>'
                                        +'<div style="margin-top: 10px; text-align: end;">'
                                        +'<button onclick="closeWin()" type="button" onclick="closeOpenedWindow()" class="btn" id="cancelUpload" data-dismiss="modal">ปิด</button>'
                                        +'<button type="submit" name="submit_id" class="btn" id="submitUpload" style="margin: 5px;">บันทึก</button>'
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

        @endif
    </div>
</div>
@endsection
</body>
</html>


{{-- $image_store = $_FILES['certStore']['name']; //image from upload;
$image_tmp01 = $_FILES['certStore']['tmp_name']; //image to server;
$folder01 = 'upload_store/';//image folder;
$image_location01 = $folder01.$image_store; //location of image; --}}