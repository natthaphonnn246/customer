<!DOCTYPE html>
<html lang="en">
    @section ('title', 'productmaster')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>nntpn.com</title>
</head>
<body>

    @extends ('portal/menuportal-tailwind')
    @section('content')
    @csrf


    <style>
        .contentArea {
            /* padding: 20px 40px 40px; */
            /* padding: 12px; */
            background-color: #FFFFFF;
            border-radius: 2px;
            text-align: left;
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
       /*  .input_date {
            border-radius: 3px;
            border: 1px solid #D3D3D3;
            padding: 5px;
            margin-bottom: 15px;
            width: auto;
            
        }
        #datepicker {
            width: 100%;
        } */
    </style>
    
    <div class="contentArea">

        @section('col-2')

        @if(isset($user_name))
            <h6 class="mt-1" style="">{{$user_name->name}}</h6>
            @endif
        @endsection

        @section('status_alert')
        @if(!($admin_area_list->rights_area) == '0')
            <h6 class="justifiy-content:center;" style="">{{$status_alert}}</h6>
            @endif
        @endsection

        @section('status_all')
        @if(!($admin_area_list->rights_area) == '0')
            <h6 class="justifiy-content:center;" style="">{{$status_all}}</h6>
            @endif
        @endsection

        @section('status_waiting')
        @if(!($admin_area_list->rights_area) == '0')
            <h6 class="justifiy-content:center;" style="">{{$status_waiting}}</h6>
            @endif
        @endsection

        @section('status_action')
        @if(!($admin_area_list->rights_area) == '0')
            <h6 class="justifiy-content:center;" style="">{{$status_action}}</h6>
            @endif
        @endsection

        @section('status_completed')
        @if(!($admin_area_list->rights_area) == '0')
            <h6 class="justifiy-content:center;" style="">{{$status_completed}}</h6>
            @endif
        @endsection

        <form action="/portal/signin/create" method="post" enctype="multipart/form-data">
 
            @csrf

            <!--- เก็บชื่อแอดมินที่ลงทะเบียน-->
            @if(isset($user_name))
                <input type="hidden" name="register_by" value="{{$user_name->admin_area.' '.'('.$user_name->name.')'}}">
            @else
                <input type="hidden" name="register_by" value="ไม่ระบุ">
            @endif

            <div class="py-2">
                {{-- <span style="color: #8E8E8E;"><a href="/webpanel/admin" id="backLink">ข้อมูลแอดมิน (Admin)</a> / แบบฟอร์ม</span> --}}
                {{-- <span class="ms-6" style="color: #8E8E8E;">ลงทะเบียนร้านค้า (Register)</span> --}}
            </div>
            <span class="ms-6" style="color: #8E8E8E;">ลงทะเบียน (Register)</span>
            <hr class="my-3" style="color: #8E8E8E; width: 100%; border:solid 2px;">

            <div class="row ms-6 mr-6">
                <div class="col-sm-6 mt-2">
                    <ul class="text-title" style="text-align: start;">
                        <span style="font-size: 18px; font-weight: 500;">ลงทะเบียนลูกค้าใหม่</span>
                        <hr style="color: #8E8E8E; width: 100%; margin-top: 10px">
                    </ul>
                    <ul class="text-muted py-3" style="padding-top: 10px;">
                        <span>ใบอนุญาตขายยา/สถานพยาบาล</span> <span style="font-size: 12px; color:red;">*จำเป็นต้องระบุ</span></br>
                        {{-- <input class="btn btn-primary my-2" style="width:100%; border:none;" id="cert_store" value="ใบอนุญาตขายยา/สถานพยาบาล"> --}}
                        <input style="margin-top:10px;" type="file" class="form-control text-muted" name="cert_store" accept="image/png, image/jpg, image/jpeg" required><br>

                        <span>ใบประกอบวิชาชีพ</span> <span style="font-size: 12px; color:red;">*จำเป็นต้องระบุ</span>
                        <input style="margin-top:10px;" type="file" class="form-control text-muted" name="cert_medical" accept="image/png, image/jpg, image/jpeg" required><br>

                        <span>ใบทะเบียนพาณิชย์</span>
                        <input style="margin-top:10px;" type="file" class="form-control text-muted" name="cert_commerce" accept="image/png, image/jpg, image/jpeg"><br>

                        <span>ใบทะเบียนภาษีมูลค่าเพิ่ม (ภ.พ.20)</span>
                        <input style="margin-top:10px;" type="file" class="form-control text-muted" name="cert_vat" accept="image/png, image/jpg, image/jpeg"><br>

                        <span>สำเนาบัตรประชาชน</span>
                        <input style="margin-top:10px;" type="file" class="form-control text-muted" name="cert_id" accept="image/png, image/jpg, image/jpeg"><br>

                        <span>เลขใบอนุญาตขายยา/สถานพยาพยาล</span> <span style="font-size: 12px; color:red;">*จำเป็นต้องระบุ</span>
                        <input style="margin-top:10px; color:grey;" type="text" class="form-control" name="cert_number"><br>

                        <span>วันหมดอายุ</span> <span style="font-size: 12px; color:red;">*จำเป็นต้องระบุ</span>
                        {{-- <input style="margin-top:10px; color:grey;" type="date" value="2024-01-01" class="form-control" name="cert_expire"><br> --}}
                        <input class="form-control" style="margin-top:10px; color:grey;" type="text" id="datepicker" value="31/12/2025" name="cert_expire">

                    </ul>
                    <script>
                        $(document).ready(function () {
                            // Datepicker
                                $("#datepicker" ).datepicker({
                                    dateFormat: 'dd/mm/yy',
                                    changeMonth: true,
                                    changeYear: true,
                                    yearRange: "2025:2029",
                                 /*    showOn: "button",
                                    buttonImage: "/icons/icons9-calendar.gif",
                                    showButtonPanel: true, */
                                    // showAnim: "fold"
                                   
                                    
                                });

                            });
                    </script>
                    <ul class="text-title" style="text-align: start; margin-top: 5px;">
                        <span style="font-size: 18px; font-weight: 500;">ข้อมูลลูกค้า</span> <span style="font-size: 12px; color:red;">*จำเป็นต้องระบุให้ครบทุกช่อง</span>
                        <hr style="color: #8E8E8E; width: 100%; margin-top: 10px">
                    </ul>
                    <div class="row text-muted">
                        <div class="col-sm-12 py-3">
                            <ul style="width: 100%;">
                                <span>ชื่อร้านค้า/สถานพยาบาล</span>
                                <input style="margin-top:10px; color: grey;" type="text" class="form-control" name="customer_name" required>
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
                        <div class="col-sm-12 py-3">
                            <ul style="width: 100%;">
                                <li class="mt-2">
                                    <span>อีเมล</span>
                                    <input style="margin-top:10px; color: grey;" name="email" type="email" class="form-control" name="email">
                                </li>
                                <li class="mt-4">
                                    <span>เบอร์ร้านค้า</span> <span style="font-size: 12px; color:gery;">(ตัวอย่าง: 021234567)</span>
                                    <input style="margin-top:10px; color: grey;" type="text" class="form-control" name="phone">
                                </li>
                                <li class="mt-4">
                                    <span>เบอร์มือถือ</span> <span style="font-size: 12px; color:red;">*จำเป็นต้องระบุ</span> <span style="font-size: 12px; color:gery;">(ตัวอย่าง: 0812345678)</span>
                                    <input style="margin-top:10px; color: grey;" type="text" class="form-control" name="telephone" required>
                                </li>
                                <li class="mt-4">
                                    <span>การจัดส่งสินค้า</span><span style="font-size: 12px; color:red;"> *ไม่ระบุ คือ จัดส่งตามรอบขนส่งทางร้าน</span>
                                    <select class="form-select" style="margin-top:10px; color: grey;" aria-label="Default select example" name="delivery_by">
                                    <option value="standard">ไม่ระบุ</option>
                                    <option value="owner">ขนส่งเอกชน (พัสดุ)</option>
                                    </select>
                                </li>
                                <li class="mt-4">
                                    <span>ที่อยู่จัดส่ง</span>
                                    <input style="margin-top:10px; color: grey;" type="text" class="form-control" name="address">    
                                </li>                          
                            </ul>
                        </div>
                        <div class="col-sm-6">
                            <ul class="mt-2" style="width: 100%;">
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
                            <ul class="mt-2" style="width: 100%;">
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
                        <div class="col-sm-6 py-3">
                            <ul class="mb-8" style="width: 100%;">
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
                        <div class="col-sm-6 py-3">
                            <ul class="mb-8" style="width: 100%;">
                                <span>รหัสไปรษณีย์</span>
                                <input style="margin-top:10px; color: grey;" type="text" class="form-control" name="zip_code" id="zipcode">
                            </ul>
                        </div>
                    </div>
                </div>
                
                <!--form login-->
                    <div class="col-sm-6 mt-2">
                        <div class="form-control">
                            <ul class="text-title" style="text-align: start; margin-top: 10px;">
                                <span style="font-size: 18px; font-weight: 500;">ข้อมูลผู้รับผิดชอบ</span>
                                <hr style="color: #8E8E8E; width: 100%; margin-top: 10px">
                            </ul>
                            <ul class="text-muted py-3" style="padding-top: 10px;">
                           
                                <span>แอดมินผู้ดูแล</span> <span style="font-size: 12px; color:red;">*จำเป็นต้องระบุ</span>
                                {{-- <input style="margin-top:10px;" type="text" class="form-control" name="admins"><br> --}}
                                <select class="form-select" style="margin-top:10px; color: grey;" aria-label="Default select example" name="admin_area">
                                    @if(isset($admin_area_list) != '')
                                    {{-- @foreach($admin_area_list as $row) --}}

                                        @if($admin_area_list->rights_area != '0') <!-- 0 == ไม่มีสิทธิ์ดูแลลูกค้า -->
                                        <option value="{{$admin_area_list->admin_area}}">{{$admin_area_list->admin_area.' '.'('. $admin_area_list->name.')'}}</option>
                                        @endif

                                    {{-- @endforeach --}}
                                    @endif
                                    </select><br>
                                
                                <span>พนักงานขาย/เขตการขาย</span> <span style="font-size: 12px; color:red;">*จำเป็นต้องระบุ</span>
                                    <select class="form-select" style="margin-top:10px; color: grey;" aria-label="Default select example" name="sale_area">
                                    <option selected value="ไม่ระบุ"> ไม่ระบุ </option>
                                    
                                    @if (isset($sale_area))
                                        @foreach($sale_area as $row_sale_area)
                                        <option value="{{$row_sale_area->sale_area}}">{{$row_sale_area->sale_area.' '.'(' .$row_sale_area->sale_name.')'}}</option>
                                        @endforeach
                                    @endif
                                    </select><br>

                            </ul>
                
                        </div>
                    
                        <div class="mb-3 my-4">
                            <label for="exampleFormControlTextarea1" class="form-label" style="font-size: 18px; font-weight: 500;">เพิ่มเติม</label></label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="text_add"></textarea>
                        </div>

                            <button type="submit" name="submit_form" class="btn py-3" style="border:none; width: 100%; color: white; padding: 10px;">บันทึกข้อมูล</button>   
                            <hr style="color:rgb(157, 157, 157);">

                            @if(Session::get('error_code'))
                            <div class="alert alert-danger"><i class="fa-solid fa-circle-xmark" style="color: rgb(172, 27, 27);"></i> {{ Session::get('error_code') }}</div>
                            @elseif (Session::get('success'))
                            <div class="alert alert-success"><i class="fa-solid fa-circle-check" style="color:green;"></i> {{ Session::get('success') }}</div>
                            @else
                            <p class="textrow py-3" style="text-align: center; font-weight:500; font-size: 16px; color:rgb(72, 72, 72);"><span>ลงทะเบียนแล้ว กรุณาติดต่อผู้ดูแล</span></p>
                            @endif
                        </div>
                    </div>
        </form>
    </div>

        <script type="text/javascript">
   
                    $(function () {
                        
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

                        $('#province').on('click', function() {

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
                    });

        </script>

@endsection
</body>
</html>
