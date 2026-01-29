
@extends ('layouts.webpanel')
@section('content')

        <div class="py-2"></div>
        <h5 class="!text-gray-600 font-semibold ms-6"><a href="/webpanel/admin" class="!no-underline">ย้อนกลับ</a> | รายละเอียด</h5>
        <hr class="my-3 !text-gray-400 !border">

            <form action="/webpanel/customer-create/insert" method="post" enctype="multipart/form-data">
                @csrf
                <!--- เก็บชื่อแอดมินที่ลงทะเบียน-->

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mx-4 px-2 text-gray-500">
            
                    <input type="hidden" name="register_by" value="{{'Admin'}}">
                    <div>
                        <p class="text-lg font-bold text-gray-700">ลงทะเบียนลูกค้าใหม่</p>
         
                        <p class="mb-1">ใบอนุญาตขายยา/สถานพยาบาล <span style="font-size: 12px; color:red;">*จำเป็นต้องระบุ</span></p>
                        {{-- <input class="btn btn-primary my-2" style="width:100%; border:none;" id="cert_store" value="ใบอนุญาตขายยา/สถานพยาบาล"> --}}
                        <input style="margin-top:10px;" id="cert_store" type="file" class="form-control text-muted" name="cert_store" accept="image/png, image/jpg, image/jpeg">
                        <span style="margin-top:20px;" id="alert_store"></span>
               
                        <p class="mt-4 mb-1">ใบประกอบวิชาชีพ <span style="font-size: 12px; color:red;">*จำเป็นต้องระบุ</span></p>
                        <input style="margin-top:10px;" type="file" class="form-control text-muted" name="cert_medical" id="cert_medical" accept="image/png, image/jpg, image/jpeg">
              
                        <p class="mt-4 mb-1">ใบทะเบียนพาณิชย์</p>
                        <input style="margin-top:10px;" type="file" class="form-control text-muted" name="cert_commerce" id="cert_commerce" accept="image/png, image/jpg, image/jpeg">
                  
                        <p class="mt-4 mb-1">ใบทะเบียนภาษีมูลค่าเพิ่ม (ภ.พ.20)</p>
                        <input style="margin-top:10px;" type="file" class="form-control text-muted" name="cert_vat" id="cert_vat" accept="image/png, image/jpg, image/jpeg">
                   
                        <p class="mt-4 mb-1">สำเนาบัตรประชาชน</p>
                        <input style="margin-top:10px;" type="file" class="form-control text-muted" name="cert_id" id="cert_id" accept="image/png, image/jpg, image/jpeg">
                   
                        <p class="mt-4 mb-1">เลขใบอนุญาตขายยา/สถานพยาพยาล <span style="font-size: 12px; color:red;">*จำเป็นต้องระบุ</span></p>
                        <input style="margin-top:10px; color:grey;" type="text" class="form-control" name="cert_number">
                   
                        <p class="mt-4 mb-1">วันหมดอายุ <span style="font-size: 12px; color:red;">*จำเป็นต้องระบุ</span></p>
                        {{-- <input style="margin-top:10px; color:grey;" type="date" value="2024-01-01" class="form-control" name="cert_expire"><br> --}}
                        {{-- <input class="input_date" style="margin-top:10px; color:grey;" type="text" id="datepicker" value="31/12/2025" name="cert_expire"> --}}
                   
                    @php
                        $year = date('Y') + 543; 
                    @endphp
                    <div class="relative">
                        <input class="input_date" style="margin-top:10px; color:grey; border-radius:6px;" type="text" id="datepicker" name="cert_expire" value="31/12/{{ $year }}">

                    </div>

                    <script>
                            $(document).ready(function () {
                                // Datepicker

                                // $('#datepickr').click(function () {
                                    // $('#datepickr').css('display', 'none');
                                    $("#datepicker" ).datepicker({
                                        dateFormat: 'dd/mm/yy',
                                        changeMonth: true,
                                        changeYear: true,
                                        yearRange: "2025:2029",
                                        showOn: "button",
                                        buttonImage: "/icons/icons9-calendar.gif",
                                        showButtonPanel: true, 
                                        // showAnim: "fold"
        

                                    });
                                });
                                
                                

                                // });
                    </script>

                        <p class="text-lg font-bold text-gray-700">ข้อมูลลูกค้า <span style="font-size: 12px; color:red;">*จำเป็นต้องระบุให้ครบทุกช่อง</span></p>
                        <hr class="my-3" style="color: #8E8E8E; width: 100%;">
                       
                        <div>
                            <span>ชื่อร้านค้า/สถานพยาบาล</span>
                            <input style="margin-top:10px; color: grey;" type="text" class="form-control" name="customer_name" required>
                            
                            <div class="grid gird-cols-1 md:grid-cols-2 gap-3 mt-4">
                                <div>
                                    <p class="mb-1">CODE <span style="font-size: 12px; color:red;">*จำเป็นต้องระบุ</span></p>
                                    <input style="margin-top:10px; color: grey;" type="text" class="form-control" name="customer_code" required>
                                </div>
                                <div>
                                    <p class="mb-1">ระดับราคา <span style="font-size: 12px; color:red;">*ลูกค้า 6 เท่ากับ 1</span></p>
                                    <select class="form-select" style="margin-top:10px; color: grey;" aria-label="Default select example" name="price_level">
                                        <option name="price_level" value="5">5</option>
                                        <option name="price_level" value="1">1</option>
                                        <option name="price_level" value="2">2</option>
                                        <option name="price_level" value="3">3</option>
                                        <option name="price_level" value="4">4</option>
                                    </select>
                                </div>
                            </div>
        
                            <p class="mt-4 mb-1">อีเมล</p>
                            <input style="margin-top:10px; color: grey;" name="email" type="email" class="form-control" name="email">
                
                            <p class="mt-4 mb-1">เบอร์ร้านค้า <span style="font-size: 12px; color:gery;">(ตัวอย่าง: 021234567)</span></p>
                            <input style="margin-top:10px; color: grey;" type="text" class="form-control" name="phone">
                    
                            <p class="mt-4 mb-1">เบอร์มือถือ <span style="font-size: 12px; color:red;">*จำเป็นต้องระบุ</span> <span style="font-size: 12px; color:gery;">(ตัวอย่าง: 0812345678)</span></p>
                            <input style="margin-top:10px; color: grey;" type="text" class="form-control" name="telephone">
                        
                            <p class="mt-4 mb-1">การจัดส่งสินค้า <span style="font-size: 12px; color:red;"> *ไม่ระบุ คือ จัดส่งตามรอบขนส่งทางร้าน</span></p>
                            <select class="form-select" style="margin-top:10px; color: grey;" aria-label="Default select example" name="delivery_by">
                                <option value="standard">ไม่ระบุ</option>
                                <option value="owner">ขนส่งเอกชน (พัสดุ)</option>
                            </select>
                    
                            <p class="mt-4 mb-1">ที่อยู่จัดส่ง</p>
                            <input style="margin-top:10px; color: grey;" type="text" class="form-control" name="address" required>
                         
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mt-4">
                                <div>
                                    <p class="mb-1">จังหวัด</p>
            
                                    <select class="form-select" style="margin-top:10px; color: grey;" aria-label="Default select example" name="province" id="province">
                                        @if(isset($provinces) != '')
                                            @foreach($provinces as $row)
                                            
                                                <option value="{{$row->id}}">{{$row->name_th}}</option>
                                            
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div>
                                    <p class="mb-1">ตำบล/เขต</p>
                                    <select class="form-select" style="margin-top:10px; color: grey;" aria-label="Default select example" name="district" id="districts" required>
                                        @if(isset($district) != '')
                                            @foreach($district as $row)
                                                <option value="{{$row->amphure_id}}">{{$row->name_th}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mt-4 mb-4">
                                <div>
                                    <p class="mb-1">อำเภอ/แขวง</p>
                                    <select class="form-select" style="margin-top:10px; color: grey;" aria-label="Default select example" name="amphur" id="amphures" required>
                                        
                                        @if(isset($ampures) != '')
                                            @foreach($ampures as $row)
                                                <option value="{{$row->province_id}}">{{$row->name_th}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div>
                                    <p class="mb-1">รหัสไปรษณีย์ <span style="font-size: 12px; color:red;">*กรุณาตรวจสอบ</span></p>
                                    <input style="margin-top:10px; color: grey;" type="text" class="form-control" id="zipcode" name="zip_code" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--form login-->
                    <div>
                        <div class="form-control">
                            <ul class="text-title mt-4" style="text-align: start;">
                                <span class="" style="font-size: 18px; font-weight: 500;">ข้อมูลผู้รับผิดชอบ</span>
                                <hr class="my-3" style="color: #8E8E8E; width: 100%;">
                            </ul>
                            <ul class="text-muted" style="padding-top: 10px;">

                                <li class="mr-6">
                                    <span>แอดมินผู้ดูแล</span> <span style="font-size: 12px; color:red;">*จำเป็นต้องระบุ</span>
                                    {{-- <input style="margin-top:10px;" type="text" class="form-control" name="admins"><br> --}}
                                    <select class="form-select" style="margin-top:10px; color: grey;" aria-label="Default select example" name="admin_area">
                                        
                                        @if(isset($admin_area_list) != '')
                                            @foreach($admin_area_list as $row)

                                                @if($row->rights_area != '0'  && $row->user_code != '0000') <!-- 0 == ไม่มีสิทธิ์ดูแลลูกค้า -->
                                                <option value="{{$row->admin_area}}">{{$row->admin_area.' '. '('. $row->name. ')'}}</option>
                                                @endif

                                            @endforeach
                                        @endif
                                
                                    </select><br>
                                </li>
                                <li class="mr-6">
                                    <span>พนักงานขาย/เขตการขาย</span> <span style="font-size: 12px; color:red;">*จำเป็นต้องระบุ</span>
                                        
                                    <select class="form-select" style="margin-top:10px; color: grey;" aria-label="Default select example" name="sale_area">
                                        <option selected value="ไม่ระบุ"> ไม่ระบุ </option>
                                        @if(isset($sale_area)!= '')
                                            @foreach($sale_area as $row_sale_area)
                                                <option value="{{$row_sale_area->sale_area}}"> {{$row_sale_area->sale_area .' '. '('. $row_sale_area->sale_name.')'}} </option>
                                            @endforeach
                                        @endif
                                    </select><br>
                                </li>
                            </ul>
                
                        </div>
                    
                        <div class="mb-3 my-4 ms-2">
                            <label for="exampleFormControlTextarea1" class="form-label" style="font-size: 18px; font-weight: 500;">เพิ่มเติม</label></label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="text_add"></textarea>
                        </div>

                        <div class="mb-4 my-4">
                            <span style="font-size:18px; font-weight:500; color:#545454">ช่องทางการสั่งสินค้า</span><span style="font-size: 14px; color:red;"> *เลือกช่องทางที่สั่งมากสุด</span>
                            <select class="form-select" style="margin-top:10px; color: grey;" aria-label="Default select example" name="purchase">
                            <option value="1">สั่งซื้อผ่านทางเว็บไซต์</option>
                            <option value="0">สั่งซื้อผ่านช่องทางอื่น ๆ (เช่น LINE หรือทางโทรศัพท์)</option>
                            </select>
                         
                        </div>

                            <button type="submit" id="submitForm" name="submit_form" class="btn py-3 ms-1" style="border:none; width: 100%; color: white; padding: 10px;">บันทึกข้อมูล</button>
                            {{-- <p class="textrow" style="text-align: center;"><span>กรุณาติดต่อเจ้าหน้าที่ เมื่อดำเนินการเรียบร้อย</span></p> --}}
                    </div>
                </div>
            </form>

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
    #submitForm {
        background-color: #4355ff;
        color:white;
    }
    #submitForm:hover {
        width: auto;
        height: auto;
        background-color: #0f21cb;
    }
   /*  input::-webkit-calendar-picker-indicator{
        display: none;
    }

    input[type="date"]::-webkit-input-placeholder{ 
        visibility: hidden !important;
    } */
    .input_date {
        border-radius: 3px;
        border: 1px solid #D3D3D3;
        padding: 5px;
        margin-bottom: 15px;
        width: auto;
        
    }
    #datepicker {
        width: 100% !important;
        padding:8px !important;
    }
</style>
        
@endpush
