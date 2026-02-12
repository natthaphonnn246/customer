@extends ('layouts.portal')
@section('content')
    
    <div class="py-2"></div>
    <h5 class="ms-6 !text-gray-600">ลงทะเบียนร้านค้า</h5>
    <hr class="my-3">

        <form action="/portal/signin/create" method="post" enctype="multipart/form-data">
        @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mx-8">
                <div>
                        <h4 class=" block mt-4 !text-gray-600">เอกสารใบอนุญาต</h4>
                        <hr style="color: #8E8E8E; width: 100%; margin-top: 10px">

                        <span>ใบอนุญาตขายยา/สถานพยาบาล</span> <span class="text-xs text-red-500">*จำเป็นต้องระบุ</span>
                        {{-- <input class="btn btn-primary my-2" style="width:100%; border:none;" id="cert_store" value="ใบอนุญาตขายยา/สถานพยาบาล"> --}}
                        <input style="margin-top:10px;" type="file" class="form-control text-muted" name="cert_store" id="cert_store" accept="image/png, image/jpg, image/jpeg" required><br>

                        <span>ใบประกอบวิชาชีพ</span> <span class="text-xs text-red-500">*จำเป็นต้องระบุ</span>
                        <input style="margin-top:10px;" type="file" class="form-control text-muted" name="cert_medical" id="cert_medical" accept="image/png, image/jpg, image/jpeg" required><br>

                        <span>ใบทะเบียนพาณิชย์</span>
                        <input style="margin-top:10px;" type="file" class="form-control text-muted" name="cert_commerce" id="cert_commerce" accept="image/png, image/jpg, image/jpeg"><br>

                        <span>ใบทะเบียนภาษีมูลค่าเพิ่ม (ภ.พ.20)</span>
                        <input style="margin-top:10px;" type="file" class="form-control text-muted" name="cert_vat" id="cert_vat" accept="image/png, image/jpg, image/jpeg"><br>

                        <span>สำเนาบัตรประชาชน</span>
                        <input style="margin-top:10px;" type="file" class="form-control text-muted" name="cert_id" id="cert_id" accept="image/png, image/jpg, image/jpeg"><br>

                        <span>เลขใบอนุญาตขายยา/สถานพยาพยาล</span> <span class="text-xs text-red-500">*จำเป็นต้องระบุ</span>
                        <input style="margin-top:10px; color:grey;" type="text" class="form-control" name="cert_number"><br>
             
                        @php
                            $year = date('Y') + 543; 
                        @endphp
                            <label class="mb-2">
                                วันหมดอายุ
                                <span class="text-base text-red-500">
                                    *กรุณาระบุวันที่ให้ถูกต้อง
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
                                        text-gray-600 hover:text-gray-600
                                        bg-gray-50 border !rounded-r-md">
                                    <i class="fa-regular fa-calendar"></i>
                                </button>
                            </div>

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
                        
                        <div class="py-2"></div>
                        <h4 class=" block mt-4 !text-gray-600">ข้อมูลร้านค้า</h4>
                        <hr class="mb-4" style="color: #8E8E8E; width: 100%; margin-top: 10px">
        
                        <span>ชื่อร้านค้า/สถานพยาบาล</span>
                        <input style="margin-top:10px; color: grey;" type="text" class="form-control" name="customer_name" required>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mt-4">
                            <div>
                                <span>CODE <span class="text-xs text-red-500">*หากเป็นร้านใหม่ให้เว้นไว้</span></span>
                                <input style="margin-top:10px; color: grey;" type="text" class="form-control" name="customer_code">
                            </div>
                            <div>
                                <span>ระดับราคา <span class="text-xs text-red-500">*หากไม่ทราบให้เลือก 5</span></span>
                                <select class="form-select" style="margin-top:10px; color: grey;" aria-label="Default select example" name="price_level">
             {{--                    <option name="price_level" value="5">5</option>
                                <option name="price_level" value="1">1</option>
                                <option name="price_level" value="2">2</option>
                                <option name="price_level" value="3">3</option> --}}
                                    <option name="price_level" value="5">5</option>
                                    <option name="price_level" value="4">4</option>
                                </select>
                            </div>
                        </div>
                         
                        <span class="block mt-3">อีเมล</span>
                        <input style="margin-top:10px; color: grey;" name="email" type="email" class="form-control" name="email">
            
                        <span class="block mt-3">เบอร์ร้านค้า <span class="text-xs text-red-500">(ตัวอย่าง: 021234567)</span></span>
                        <input style="margin-top:10px; color: grey;" type="text" class="form-control" name="phone">
            
                        <span class="block mt-3">เบอร์มือถือ <span class="text-xs text-red-500">*จำเป็นต้องระบุ (ตัวอย่าง: 0881234568)</span></span> 
                        <input style="margin-top:10px; color: grey;" type="text" class="form-control" name="telephone" required>

                        <span class="block mt-3">การจัดส่งสินค้า <span class="text-xs text-red-500">ไม่ระบุเท่ากับ จัดส่งตามรอบทางร้าน</span></span>
                        <select class="form-select" style="margin-top:10px; color: grey;" aria-label="Default select example" name="delivery_by">
                            <option value="standard">ไม่ระบุ</option>
                            <option value="owner">ขนส่งเอกชน (พัสดุ)</option>
                        </select>

                        <span class="block mt-3">ที่อยู่จัดส่ง</span>
                        <input style="margin-top:10px; color: grey;" type="text" class="form-control no-paste" name="address" required>    

                        <script>
                            document.querySelectorAll('input.no-paste').forEach(input => {
                                input.addEventListener('paste', e => e.preventDefault());
                            });

                        </script>                            

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div>
                                <span class="block mt-3">จังหวัด</span>
                                <select class="form-select mt-1" style="color: grey;" aria-label="Default select example" name="province" id="province">
                                    @if(isset($provinces))
                                        @foreach($provinces as $row)
                                        
                                            <option value="{{$row->id}}">{{$row->name_th}}</option>
                                        
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div>
                                <span class="block mt-3">อำเภอ/เขต</span>
                                <select class="form-select mt-1" style="color: grey;" aria-label="Default select example" name="amphur" id="amphures" required>
                                    
                                    @if(isset($ampures))
                                        @foreach($ampures as $row)
                                            <option value="{{$row->province_id}}">{{$row->name_th}}</option>
                                        @endforeach
                                    @endif

                                </select>
                            </div>
                        </div>
                    
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div>
                                <span class="block mt-4">ตำบล/แขวง</span>
                                <select class="form-select mt-1" style="color: grey;" aria-label="Default select example" name="district" id="districts" required>

                                    @if(isset($district))
                                        @foreach($district as $row)
                                            <option value="{{$row->amphure_id}}">{{$row->name_th}}</option>
                                        @endforeach
                                    @endif

                                </select>
                            </div>
                            <div>
                                <span class="block mt-4" class="block mt-4">รหัสไปรษณีย์ <span class="text-xs text-red-500">*ถ้าข้อมูลไม่ตรง แก้ไขได้</span></span>
                                <input style="color: grey;" type="text" class="form-control mt-1" name="zip_code" id="zipcode" required>

                            </div>
                        </div>
                        <div class="py-4"></div>
                    </div>
                
                <!--form login-->
                <div>
                    <div class="form-control p-4">
                        <h6 class="!text-gray-600"">ข้อมูลผู้รับผิดชอบ</h6>
                        <hr style="color: #8E8E8E; width: 100%; margin-top: 10px">
                        
                            <span>แอดมินผู้ดูแล <span class="text-xs text-red-500">*จำเป็นต้องระบุ</span></span>
                            {{-- <input style="margin-top:10px;" type="text" class="form-control" name="admins"><br> --}}
                            <select class="form-select" style="margin-top:10px; color: grey;" aria-label="Default select example" name="admin_area">
                                @if(isset($admin_area_list))
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
                            </select>

                    </div>
                
                    <div class="mb-3 my-4">
                        <label for="exampleFormControlTextarea1" class="form-label" style="font-size: 18px; font-weight: 500;">เพิ่มเติม</label></label>
                        {{-- <span class="text-sm text-red-500">*ฝากข้อความถึงผู้เปิดบัญชีลูกค้าใหม่ได้</span> --}}
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="text_add"></textarea>
                    </div>

                    <div class="mb-4 my-4">
                        <p class="!text-gray-700 font-medium mt-3 mb-1">ช่องทางการสั่งสินค้า <span class="text-xs text-red-500">*เลือกช่องทางที่สั่งมากสุด</span></p>
                        <select class="form-select" style="margin-top:10px; color: grey;" aria-label="Default select example" name="purchase">
                            <option value="1">สั่งซื้อผ่านทางเว็บไซต์</option>
                            <option value="0">สั่งซื้อผ่านช่องทางอื่น ๆ (เช่น LINE หรือทางโทรศัพท์)</option>
                        </select>
                       
                        <p class="!text-gray-700 font-medium mt-4 mb-1">รับใบกำกับภาษีด้วยไหม <span class="text-red-500 text-xs">*จำเป็นต้องระบุ</span></p>
                        <select class="form-control !border-gray-300 p-2 rounded-lg mt-2 hover:!border-red-500 !text-red-500" aria-label="Default select example" name="status_vat">
                            <option value="0">ไม่ต้องการ</option>
                            <option value="1">ต้องการ</option>
                        </select>

                    </div>

                        <button type="submit" name="submit_form" class="btn py-3" style="border:none; width: 100%; color: white; padding: 10px;">บันทึกข้อมูล</button>   
                        <hr style="color:rgb(157, 157, 157);">

                        <ul class="mt-4">
                            @if(Session::get('error_code'))
                            <div class="alert alert-danger"><i class="fa-solid fa-circle-xmark" style="color: rgb(172, 27, 27);"></i> {{ Session::get('error_code') }}</div>
                            @elseif (Session::get('success'))
                            <div class="alert alert-success"><i class="fa-solid fa-circle-check" style="color:green;"></i> {{ Session::get('success') }}</div>
                            @else
                            <p class="textrow py-3" style="text-align: center; font-weight:500; font-size: 16px; color:rgb(72, 72, 72);"><span>ลงทะเบียนแล้ว กรุณาติดต่อผู้ดูแล</span></p>
                            @endif
                        </ul>
                </div>
            </div>
        </form>

        @if (session('error_code') == 'ลงทะเบียนไม่สำเร็จ กรุณาตรวจสอบอีกรอบครับ')
        <script> 
                Swal.fire({
                    title: "ล้มเหลว",
                    text: "ลงทะเบียนไม่สำเร็จ",
                    icon: "error",
                    confirmButtonText: "ตกลง",
                    width: '400px', 
                    height: '200px',
                    customClass: {
                        popup: 'rounded-popup',
                        title: 'text-xl',
                        icon: 'custom-icon-color',
                        confirmButton: 'custom-confirm-button'
                    }
                    }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.reload();
                    }
                    
                });
        </script>

        @endif

        @if (session('success') == 'ลงทะเบียนสำเร็จ กรุณาติดต่อผู้ดูแลด้วยครับ')
        <script> 
                Swal.fire({
                    title: "สำเร็จ",
                    text: "กรุณาติดต่อผู้ดูแล",
                    icon: "success",
                    confirmButtonText: "ตกลง",
                    width: '400px', 
                    height: '200px',
                    customClass: {
                        popup: 'rounded-popup',
                        title: 'text-xl',
                        icon: 'custom-icon-color',
                        confirmButton: 'custom-confirm-button'
                    }
                    }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.reload();
                    }
                    
                });
        </script>

        @endif

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
@endpush