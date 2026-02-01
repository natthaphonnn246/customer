@extends('layouts.admin')
@section('content')
@csrf
        
        <div class="py-2"></div>
        <h4 class="!text-gray-600 font-semibold ms-6">ลงทะเบียนใหม่ (Register)</h4>

        <hr class="my-3 !text-gray-400 !border">

        <form action="/portal/portal-sign/create" method="post" enctype="multipart/form-data">
            @csrf
                <!--- เก็บชื่อแอดมินที่ลงทะเบียน-->
         {{--        @if(isset($user_name))
                    <input type="hidden" name="register_by" value="{{$user_name->admin_area.' '.'('.$user_name->name.')'}}">
                @else
                    <input type="hidden" name="register_by" value="ไม่ระบุ">
                @endif --}}

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 p-6">
                <div class="mb-3 mx-3">
                    <p class="text-xl">เอกสารใบอนุญาต <span class="text-red-500 text-xs">*จำเป็นต้องระบุ</span></p>
                    <hr class="mt-1 text-gray-400">
                    <ul class="text-muted p-3">
                        <li class="mt-1">
                            <p class="text-gray-600 mb-1">ใบอนุญาตขายยา/สถานพยาบาล <span class="text-red-500 text-xs">*จำเป็นต้องระบุ</span></p>
                            {{-- <input class="btn btn-primary my-2" style="width:100%; border:none;" id="cert_store" value="ใบอนุญาตขายยา/สถานพยาบาล"> --}}
                            <input type="file" class="form-control text-muted border !border-gray-300 p-2 rounded-lg mt-2 hover:!border-red-500" name="cert_store" id="cert_store" accept="image/png, image/jpg, image/jpeg" required>
                        </li>

                        <li class="mt-3">
                            <p class="text-gray-600 mb-1">ใบประกอบวิชาชีพ <span class="text-red-500 text-xs">*จำเป็นต้องระบุ</span></p>
                            <input type="file" class="form-control text-muted border !border-gray-300 p-2 rounded-lg mt-2 hover:!border-red-500" name="cert_medical" id="cert_medical" accept="image/png, image/jpg, image/jpeg" required>
                        </li>

                        <li class="mt-3">
                            <p class="text-gray-600 mb-1">ใบทะเบียนพาณิชย์</p>
                            <input type="file" class="form-control text-muted border !border-gray-300 p-2 rounded-lg mt-2 hover:!border-red-500" name="cert_commerce" id="cert_commerce" accept="image/png, image/jpg, image/jpeg">
                        </li>

                        <li class="mt-3">
                            <p class="text-gray-600 mb-1">ใบทะเบียนภาษีมูลค่าเพิ่ม (ภ.พ.20)</p>
                            <input type="file" class="form-control text-muted border !border-gray-300 p-2 rounded-lg mt-2 hover:!border-red-500" name="cert_vat" id="cert_vat" accept="image/png, image/jpg, image/jpeg">
                        </li>

                        <li class="mt-3">
                            <p class="text-gray-600 mb-1">สำเนาบัตรประชาชน</p>
                            <input type="file" class="form-control text-muted border !border-gray-300 p-2 rounded-lg mt-2 hover:!border-red-500" name="cert_id" id="cert_id" accept="image/png, image/jpg, image/jpeg">
                        </li>

                        <li class="mt-3">
                            <p class="text-gray-600 mb-1">เลขใบอนุญาตขายยา/สถานพยาพยาล <span class="text-red-500 text-xs">*จำเป็นต้องระบุ</span></p>
                            <input class="form-control !text-red-500 !border-gray-300 p-2 rounded-lg mt-2 hover:!border-red-500" type="text" name="cert_number">
                        </li>

                        @php
                            $year = date('Y') + 543; 
                        @endphp
                    <li class="mt-3">
                        <label class="block font-medium mb-1 text-gray-600">
                            วันหมดอายุ
                            <span class="text-xs text-red-500">
                                *กรุณาตรวจสอบที่ใบอนุญาตอีกรอบ
                            </span>
                        </label>
                    
                        <div class="relative">
                            <input
                                type="text"
                                id="datepicker"
                                name="cert_expire"
                                value="31/12/{{ $year }}"
                                class="w-full rounded-md border !border-gray-300
                                       px-3 py-2 pr-10 text-gray-700
                                       focus:outline-none focus:ring-2 focus:ring-blue-500
                                       focus:border-blue-500 bg-white"
                            >
                    
                            <!-- calendar icon (right) -->
                            <button
                                type="button"
                                id="openDatepicker"
                                class="absolute inset-y-0 right-0 flex items-center px-3
                                       border-l !border-gray-300
                                       text-gray-600 hover:text-red-500
                                       bg-gray-50 border !rounded-r-md">
                                <i class="fa-regular fa-calendar"></i>
                            </button>
                        </div>
                    </li>
                    

                    </ul>

                    <script>
                        $(function () {
                            $("#datepicker").datepicker({
                                dateFormat: 'dd/mm/yy',
                                changeMonth: true,
                                changeYear: true,
                                yearRange: "2569:2574"
                            });
                        
                            $("#openDatepicker").on("click", function () {
                                $("#datepicker").focus();
                            });
                        });
                    </script>
                        
                    <p class="text-xl mt-4">ข้อมูลร้านค้า <span class="text-red-500 text-xs">*จำเป็นต้องระบุ</span></p>
                   
                    <hr class="mt-2 border-gray-400">
                    <div class="grid grid-cols-1 md:grid-cols-2 text-gray-600 p-3">
                        <div class="md:col-span-2">
                            <p class="mb-1">ชื่อร้านค้า/สถานพยาบาล</p>
                            <input class="form-control !text-red-500 !border-gray-300 p-2 rounded-lg mt-2 hover:!border-red-500" type="text" name="customer_name" required>
                        </div>
                       {{--  <div class="md:grid-cols-2">
                            <ul>
                                <span>CODE</span><span style="font-size: 12px; color:red;">*จำเป็นต้องระบุ</span>
                                <input class="form-control !text-red-500 border-gray-400 p-2 rounded-lg mt-2 hover:!border-red-500" type="text" name="customer_code" required>

                            </ul>
                        </div>
                        <div class="md:grid-cols-2">
                            <ul>
                                <span>ระดับราคา</span><span style="font-size: 12px; color:red;">*ลูกค้า 6 เท่ากับ 1</span>
                                <select class="form-control !text-red-500 border-gray-400 p-2 rounded-lg mt-2 hover:!border-red-500" aria-label="Default select example" name="price_level">
                                <option name="price_level" value="5">5</option>
                                <option name="price_level" value="1">1</option>
                                <option name="price_level" value="2">2</option>
                                <option name="price_level" value="3">3</option>
                                <option name="price_level" value="4">4</option>
                                </select>
                            </ul>
                        </div> --}}
     
                            <div class="md:col-span-2">
                                    <p class="mb-1 mt-3">อีเมล</p>
                                    <input class="form-control !text-red-500 !border-gray-300 p-2 rounded-lg mt-2 hover:!border-red-500" name="email" type="email" name="email">
                             
                                    <p class="mb-1 mt-3 text-xm">เบอร์โทรศัพท์ร้านค้า <span class="text-red-500 text-xs">*ตัวอย่าง: 027534701 (ห้ามขีด(-) หรือ เว้นวรรค)</span></p>
                                    <input class="form-control !text-red-500 !border-gray-300 p-2 rounded-lg mt-2 hover:!border-red-500" type="text" name="phone">
           
     
                                    <p class="mb-1 mt-3 text-xm">เบอร์โทรศัพท์มือถือ <span class="text-red-500 text-xs">*ตัวอย่าง: 0802241118 (ห้ามขีด(-) หรือ เว้นวรรค)</span></p>
                                    <input class="form-control !text-red-500 !border-gray-300 p-2 rounded-lg mt-2 hover:!border-red-500" type="text" name="telephone" required>
    
                                    <p class="mb-1 mt-3">การจัดส่งสินค้า <span class="text-red-500 text-xs">*จำเป็นต้องระบุ</span></p>
                                    <select class="form-control !text-red-500 !border-gray-300 p-2 rounded-lg mt-2 hover:!border-red-500" aria-label="Default select example" name="delivery_by">
                                    <option value="standard">ไม่ระบุ</option>
                                    <option value="owner">ขนส่งเอกชน (พัสดุ)</option>
                                    </select>
                      
                                    <p class="mb-1 mt-3">ที่อยู่จัดส่ง</p>
                                    <input class="form-control !text-red-500 !border-gray-300 p-2 rounded-lg mt-2 hover:!border-red-500" type="text" name="address" required>
                             
                                <script>
                                    document.querySelectorAll('input.no-paste').forEach(input => {
                                        input.addEventListener('paste', e => e.preventDefault());
                                    });
        
                                </script>                          
                            </div>

                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-3">

                        <!-- จังหวัด -->
                        <div>
                            <label class="mb-1 block text-gray-600">จังหวัด</label>
                            <select
                            class="form-control !text-red-500 !border-gray-300 p-2 rounded-lg hover:!border-red-500
                                   @error('province') border-red-500 @enderror"
                            name="province"
                            id="province"
                            required
                            >
                                <option value="" selected disabled>-- เลือกจังหวัด --</option>
                            
                                @if(isset($provinces))
                                    @foreach($provinces as $row)
                                        <option
                                            value="{{ $row->id }}"
                                            {{ old('province') == $row->id ? 'selected' : '' }}
                                        >
                                            {{ $row->name_th }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            
                            @error('province')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        
                        </div>
                    
                        <!-- อำเภอ/เขต -->
                        <div>
                            <label class="mb-1 block text-gray-600">อำเภอ/เขต</label>
                            <select
                            class="form-control !text-red-500 !border-gray-300 p-2 rounded-lg hover:!border-red-500"
                            name="amphur"
                            id="amphures"
                            required
                            >
                                <option value="" selected disabled>-- เลือกอำเภอ/เขต --</option>
                            
                                @if(isset($ampures))
                                    @foreach($ampures as $row)
                                        <option value="{{ $row->id }}">
                                            {{ $row->name_th }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        
                        </div>
                    
                        <!-- ตำบล/แขวง -->
                        <div>
                            <label class="mb-1 block text-gray-600">ตำบล/แขวง</label>
                            <select
                            class="form-control !text-red-500 !border-gray-300 p-2 rounded-lg hover:!border-red-500
                                @error('district') border-red-500 @enderror"
                            name="district"
                            id="districts"
                            required
                            >
                                <option value="" selected disabled>-- เลือกตำบล/แขวง --</option>
                            
                                @if(isset($district))
                                    @foreach($district as $row)
                                        <option
                                            value="{{ $row->id }}"
                                            {{ old('district') == $row->id ? 'selected' : '' }}
                                        >
                                            {{ $row->name_th }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            
                            @error('district')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror                        
                        </div>
                    
                        <!-- รหัสไปรษณีย์ -->
                        <div>
                            <label class="mb-1 block text-gray-600">รหัสไปรษณีย์</label>
                            <input
                                class="form-control !text-red-500 !border-gray-300 p-2 rounded-lg hover:!border-red-500"
                                type="text"
                                name="zip_code"
                                id="zipcode"
                                required
                            >
                        </div>
                    
                    </div>
                </div>
                <!--form login-->
                <div class="mx-3">
                    <div class="form-control p-4 !border-gray-300">
                       
                            <p class="text-xl">ข้อมูลเพิ่มเติม</p>
                            <hr class="mt-1 text-gray-400">
                        
                    {{--        <ul class="text-muted ms-6 mr-6" style="margin-top:15px;">
                            <span>แอดมินผู้ดูแล</span> <span style="font-size: 12px; color:red;">*จำเป็นต้องระบุ</span>
                            <select class="form-control text-muted border p-2 rounded-lg mt-2 hover:!border-red-500" aria-label="Default select example" name="admin_area">
                                @if(isset($admin_area_list) != '')
                                @foreach($admin_area_list as $row)

                                    @if($row->rights_area != '0' && $row->user_id != '0000') <!-- 0 == ไม่มีสิทธิ์ดูแลลูกค้า -->
                                    <option value="{{$row->admin_area}}">{{$row->admin_area.' '.'('.$row->name.')'}}</option>
                                    @endif

                                @endforeach
                                @endif
                        
                                </select><br>
                            
                            <span>พนักงานขาย/เขตการขาย</span> <span style="font-size: 12px; color:red;">*จำเป็นต้องระบุ</span>
                                <select class="form-control text-muted border p-2 rounded-lg mt-2 hover:!border-red-500" aria-label="Default select example" name="sale_area">
                                <option selected value="ไม่ระบุ"> ไม่ระบุ </option>
                                
                                    @if (isset($sale_area))
                                        @foreach($sale_area as $row_sale_area)
                                        <option value="{{$row_sale_area->sale_area}}">{{$row_sale_area->sale_area.' '.'(' .$row_sale_area->sale_name.')'}}</option>
                                        @endforeach
                                    @endif
                                </select><br>

                        </ul> --}}
            
                     
                        <p class="mb-1">ช่องทางกานสั่งสินค้า <span class="text-red-500 text-xs">*จำเป็นต้องระบุ</span></p>
                        <select class="form-control !border-gray-300 p-2 rounded-lg mt-2 hover:!border-red-500 !text-red-500" aria-label="Default select example" name="purchase">
                            <option value="1">สั่งซื้อผ่านทางเว็บไซต์</option>
                            <option value="0">สั่งซื้อผ่านช่องทางอื่น ๆ (เช่น LINE หรือทางโทรศัพท์)</option>
                        </select>
                    
                        <p class="mb-1 mt-3">รับใบกำกับภาษีด้วยไหม <span class="text-red-500 text-xs">*จำเป็นต้องระบุ</span></p>
                        <select class="form-control !border-gray-300 p-2 rounded-lg mt-2 hover:!border-red-500 !text-red-500" aria-label="Default select example" name="status_vat">
                            <option value="0">ไม่ต้องการ</option>
                            <option value="1">ต้องการ</option>
                        </select>

                    </div>
                
                    <div class="mb-3 my-4">

                        <label for="exampleFormControlTextarea1" class="form-label">เพิ่มเติม</label>

                        <textarea class="form-control !border-gray-300" id="exampleFormControlTextarea1" rows="3" name="text_add"></textarea>
                      
                    </div>

                {{--     <div class="mb-4 my-4">
                        <ul class="mt-4" style="width: 100%;  margin-top:15px;">
                            <span style="font-size:18px; font-weight:500;">ช่องทางกานสั่งสินค้า</span><span style="font-size: 14px; color:red;"> *เลือกช่องทางที่สั่งมากสุด</span>
                            <select class="form-control text-muted border p-2 rounded-lg mt-2 hover:!border-red-500" aria-label="Default select example" name="purchase">
                                <option value="1">สั่งซื้อผ่านทางเว็บไซต์</option>
                                <option value="0">สั่งซื้อผ่านช่องทางอื่น ๆ (เช่น LINE หรือทางโทรศัพท์)</option>
                            </select>
                        </ul>
                    </div> --}}

                    <ul class="md:grid-cols-2 text-end mr-4 mt-4">
                        <button type="submit" name="submit_form" class="bg-green-500 px-4 py-2 hover:bg-green-600 !rounded-lg text-white">บันทึกข้อมูล</button>
                        <button type="button"
                                onclick="window.location.href='{{ url()->current() }}'"
                                class="bg-gray-400 px-4 py-2 hover:bg-gray-500 !rounded-lg text-white">
                                ยกเลิก
                        </button>

                        <hr class="mt-4 text-gray-400">

                        <li class="mt-4">
                            @if (session('error_code'))
                                <div class="flex items-center gap-2 rounded-lg border border-red-300 bg-red-50 px-4 py-3 text-red-700 shadow-sm">
                                    <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm2.12-10.12a.75.75 0 00-1.06-1.06L10 7.94 8.94 6.82a.75.75 0 10-1.06 1.06L8.94 9l-1.06 1.12a.75.75 0 101.06 1.06L10 10.06l1.06 1.12a.75.75 0 101.06-1.06L11.06 9l1.06-1.12z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-sm font-medium">
                                        {{ session('error_code') }}
                                    </span>
                                </div>
                        
                            @elseif (session('success'))
                                <div class="flex items-center gap-2 rounded-lg border border-green-300 bg-green-50 px-4 py-3 text-green-700 shadow-sm">
                                    <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.53-9.47a.75.75 0 00-1.06-1.06L9 10.94 7.53 9.47a.75.75 0 00-1.06 1.06l2 2a.75.75 0 001.06 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-sm font-medium">
                                        {{ session('success') }}
                                    </span>
                                </div>
                        
                            @else
                                <div class="rounded-lg bg-gray-50 px-4 py-3 text-center text-sm font-medium text-gray-600 shadow-sm">
                                    ลงทะเบียนแล้ว กรุณาติดต่อผู้ดูแล
                                </div>
                            @endif
                        </li>
                        
                    </ul>
                </div>

            </div>
        </form>
        
         <script>
             
                $('#province').change(function(e) {
                    e.preventDefault();
                    let province_id = $(this).val();
                    console.log(province_id);
                    
                        $.ajax({
                            url: '/portal/portal-sign/update-amphure',
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
                            url: '/portal/portal-sign/update-district',
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
                        url: '/portal/portal-sign/update-amphure',
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
                            url: '/portal/portal-sign/update-district',
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
                            url: '/portal/portal-sign/update-zipcode',
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
                            url: '/portal/portal-sign/update-zipcode',
                            type: 'get',
                            data: {amphure_id: amphure_id},
                            success: function(data) {

                                $('#zipcode').val(data);
                                console.log(data);
                            
                            }
                        });
                    });

        </script>

    <!--- ตรวจสอบขนสดภาพก่อน upload -->
    <script>
                $('#cert_store').bind('change', function() {
                    const maxSize = 1000000; //byte
                    const mb = maxSize/maxSize;
                    let size = this.files[0].size;
                    if( size > maxSize ) {

                        Swal.fire({
                            icon:'warning',
                            title: 'ภาพใหญ่เกิน',
                            text: 'ขนาดภาพไม่เกิน 1 MB (ใบอนุญาตขายยา)',
                            showConfirmButton: true,
                            confirmButtonText: 'ตกลง'

                        }).then(function() {
                            $("#cert_store").val('');
                        });

                        /*   $("#alert_store").html('ขนาดใหญ่เกิน');
                        $("#image").val(''); */
                        /* alert("ระบบไม่รองรับไฟล์ภาพขนาดใหญ่เกินกว่า "+mb+" mb");
                        $("#submit").prop( "disabled", true ); */
                    }
                });    

                $('#cert_medical').bind('change', function() {
                    const maxSize = 1000000; //byte
                    const mb = maxSize/maxSize;
                    let size = this.files[0].size;
                    if( size > maxSize ) {

                        Swal.fire({
                            icon:'warning',
                            title: 'ภาพใหญ่เกิน',
                            text: 'ขนาดภาพไม่เกิน 1 MB (ใบประกอบวิชาชีพ)',
                            showConfirmButton: true,
                            confirmButtonText: 'ตกลง'

                        }).then(function() {
                            $("#cert_medical").val('');
                        });

                    }
                });
                
                $('#cert_commerce').bind('change', function() {
                    const maxSize = 1000000; //byte
                    const mb = maxSize/maxSize;
                    let size = this.files[0].size;
                    if( size > maxSize ) {

                        Swal.fire({
                            icon:'warning',
                            title: 'ภาพใหญ่เกิน',
                            text: 'ขนาดภาพไม่เกิน 1 MB (ใบทะเบียนพาณิชย์)',
                            showConfirmButton: true,
                            confirmButtonText: 'ตกลง'

                        }).then(function() {
                            $("#cert_commerce").val('');
                        });

                    }
                });
                
                $('#cert_vat').bind('change', function() {
                    const maxSize = 1000000; //byte
                    const mb = maxSize/maxSize;
                    let size = this.files[0].size;
                    if( size > maxSize ) {

                        Swal.fire({
                            icon:'warning',
                            title: 'ภาพใหญ่เกิน',
                            text: 'ขนาดภาพไม่เกิน 1 MB (ใบทะเบียนมูลค่าเพิ่ม)',
                            showConfirmButton: true,
                            confirmButtonText: 'ตกลง'

                        }).then(function() {
                            $("#cert_vat").val('');
                        });

                    }
                });  

                $('#cert_id').bind('change', function() {
                    const maxSize = 1000000; //byte
                    const mb = maxSize/maxSize;
                    let size = this.files[0].size;
                    if( size > maxSize ) {

                        Swal.fire({
                            icon:'warning',
                            title: 'ภาพใหญ่เกิน',
                            text: 'ขนาดภาพไม่เกิน 1 MB (สำเนาบัตรประชาชน)',
                            showConfirmButton: true,
                            confirmButtonText: 'ตกลง'

                        }).then(function() {
                            $("#cert_id").val('');
                        });

                    }
                });  
        </script>

@endsection
@push('styles')
<style>
    .ui-datepicker {
    width: 22rem;     
    padding: 0.75rem;
    font-size: 0.9rem;
}
</style>
@endpush
