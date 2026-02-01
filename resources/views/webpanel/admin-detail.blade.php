@extends ('layouts.webpanel')
@section('content')

        <div class="py-2"></div>
        <h5 class="!text-gray-600 font-semibold ms-6"><a href="/webpanel/admin" class="!no-underline">ย้อนกลับ</a> | รายละเอียด</h5>
        <hr class="my-3 !text-gray-400 !border">

            <ul>
                <span class="text-blue-400">ล็อกอินทั้งหมด : {{$count_check_login->check_login != '' ? $count_check_login->check_login : '0'}} ครั้ง</span> 
                <span style="color:#8E8E8E;">|</span>
                <span class="text-red-500 text-sm">ล็อกอินประเภทร้านค้าทั้งหมด : {{$count_check_type ? $count_check_type : '0'}} ครั้ง</span>
            </ul>
            
            <ul class="text-title my-3" style="text-align: start;">
                <p class="font-bold text-lg">ข้อมูลแอดมิน</p>
            </ul>

            <hr class="my-3 !text-gray-400">

                @if (isset($admin_master))
                {{-- @foreach ($admin_row as $row_edit) --}}
                    <form action="/webpanel/admin-detail/update/{{$admin_master->id}}" method="post" id="form" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mx-4 px-4 text-gray-500">
                            <div>
             
                                <p class="mt-2 mb-1">ชื่อแอดมิน</p>
                                <input type="text" class="form-control !text-gray-500" name="admin_name" value="{{$admin_master->name}}">
    
                                <p class="mt-4 mb-1">CODE <span class="text-red-500 text-xs">*จำเป็นต้องระบุ</span></p>
                                <input type="text" class="form-control !text-gray-500" name="code" value="{{$admin_master->user_code}}">
                        
                                <p class="mt-4 mb-1">Admin area <span class="text-red-500 text-xs">*เขตรับผิดชอบ</span></p>
                                <input type="text" class="form-control !text-gray-500" id="adminarea" name="admin_area" value="{{$admin_master->admin_area}}">
            
                                <p class="mt-4 mb-1">สิทธิ์แสดงสถานะการสั่งซื้อ <span class="text-red-500 text-xs">*มี = เห็นสถานะการสั่งซื้อ</span></p>
                                <select class="form-select !text-gray-500" aria-label="Default select example" name="purchase_status" id="rolemain">
                        
                                    <option {{$admin_master->purchase_status == 0 ? 'selected': '' }} value="0">ไม่มี</option>
                                    <option {{$admin_master->purchase_status == 1 ? 'selected': '' }} value="1">มี</option>
    
                                </select>
            
                                <p class="mt-4 mb-1">สิทธิ์เข้าถึงประเภทร้านค้า (ข.ย.2 / สมพ.2) <span class="text-red-500 text-xs">*มี = มีสิทธิ์ใช้งานเมื่อปิดการเข้าถึงในหน้าตั้งค่า</span></p>
                                <select class="form-select !text-gray-500" aria-label="Default select example" name="allowed_check_type" id="rolemain">

                                    <option {{$admin_master->allowed_check_type == 0 ? 'selected': '' }} value="0">ไม่มี</option>
                                    <option {{$admin_master->allowed_check_type == 1 ? 'selected': '' }} value="1">มี</option>

                                </select>
                
                                <p class="mt-4 mb-1">สิทธิ์แอดมิน <span class="text-red-500 text-xs">*มีสิทธิ์ = ทดสอบได้ทุกประเภทแอดมิน</span></p>
                                <select class="form-select !text-gray-500" aria-label="Default select example" name="admin_role" id="rolemain">

                                    <option {{$admin_master->admin_role == 0 ? 'selected': '' }} value="0">ไม่มีสิทธิ์</option>
                                    <option {{$admin_master->admin_role == 1 ? 'selected': '' }} value="1">มีสิทธิ์</option>

                                </select>
                    
                               
                                <div class="grid md:grid-cols-2 gap-3">
                                    <div>
                                        <p class="mt-4 mb-1">ประเภทแอดมิน</p>
                                        <select class="form-select !text-gray-500" aria-label="Default select example" name="role" id="rightsrole">

                                            <option {{$admin_master->role == 0 ? 'selected': '' }} value="0">ไม่ระบุ</option>
                                            <option {{$admin_master->role == 1 ? 'selected': '' }} value="1">ดูรายงาน</option>
                                            @if ($admin_master->user_id == '0000' || $admin_master->user_id == '4494' || $admin_master->user_id == '9000')
                                            <option {{$admin_master->role == 2 ? 'selected': '' }} value="2">แอดมินหลัก</option>
                                            @endif
                         
                                        </select>
                                    </div>

                                    <div>
                                        <p class="mt-4 mb-1">สิทธิ์รับผิดชอบ</p>
                                        <select class="form-select !text-gray-500" aria-label="Default select example" name="rights_area" id="rights_area_role">

                                            <option {{$admin_master->rights_area == 0 ? 'selected' : '' }} value="0">ไม่ระบุ</option>
                                            <option {{$admin_master->rights_area == 1 ? 'selected' : '' }} value="1">ระบุ</option>
                                            
                                        </select>
                                      
                                    </div>
                                </div>

                                <div class="mt-4">
                                    @if($admin_master->admin_role == '1')
                                        @if($admin_master->role == '0')

                                            @if($admin_master->rights_area == '0')
                                                <span class="text-red-500">*ลิงก์ทดสอบ (ไม่ระบุ, สิทธิ์รับผิดชอบ = ไม่ระบุ) :</span>
                                                <input class="form-control !text-gray-600 mt-2" type="text" value="{{ asset('/signin') }}" id="myInput">
                                                <button type="button" onclick="myFunction()" class="bg-green-400 hover:bg-green-500 text-white !rounded-lg px-4 py-1 mt-2">Copy</button>
                                            @else
                                                <span class="text-red-500">*ลิงก์ทดสอบ (ไม่ระบุ, สิทธิ์รับผิดชอบ = ระบุ) :</span>
                                                <input class="form-control !text-gray-600 mt-2" type="text" value="{{ asset('/portal/dashboard') }}" id="myInput">
                                                <button type="button" onclick="myFunction()" class="bg-green-400 hover:bg-green-500 text-white !rounded-lg px-4 py-1 mt-2">Copy</button>
                                            @endif

                                    @elseif($admin_master->role == '1')

                                            <span class="text-red-500">*ลิงก์ทดสอบ (ดูรายงาน) :</span>
                                            <input class="form-control !text-gray-600 mt-2" type="text" value="{{ asset('/admin') }}" id="myInput">
                                            <button type="button" onclick="myFunction()" class="bg-green-400 hover:bg-green-500 text-white !rounded-lg px-4 py-1 mt-2">Copy</button>

                                            @else
                            
                                            <span class="text-red-500">*ลิงก์ทดสอบ (แอดมินหลัก) :</span>
                                            <input class="form-control !text-gray-600 mt-2" type="text" value="{{ asset('/webpanel') }}" id="myInput">
                                            <button type="button" onclick="myFunction()" class="bg-green-400 hover:bg-green-500 text-white !rounded-lg px-4 py-1 mt-2">Copy</button>
                                            
                                        @endif
                                    @endif
                                    
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
                                <div>
          
                                    <p class="mt-4 mb-1">สิทธิ์ในการทดสอบระบบ <span style="font-size: 12px; color:red;">*เมื่ออยู่ระหว่างปรับปรุงระบบ</span></p>
                                    <select class="form-select !text-gray-500" aria-label="Default select example" name="allowed_user_status">

                                        <option {{$admin_master->allowed_user_status == 0 ? 'selected' : '' }} value="0">ไม่ระบุ</option>
                                        <option  {{$admin_master->allowed_user_status == 1 ? 'selected' : '' }} value="1">ระบุ</option>
                                        
                                    </select>
                
                                    <p class="mt-4 mb-1">อีเมล</p>
                                    <input type="email" class="form-control !text-gray-600" name="email" value="{{$admin_master->email}}" disabled>
                    
                                    <p class="mt-4 mb-1">เบอร์ติดต่อ <span class="text-xs text-red-500">(ตัวอย่าง: 0904545555)</span></p>
                                    <input type="text" class="form-control !text-gray-500" name="telephone" value="{{$admin_master->telephone}}">
                    
                                    <p class="mt-4 mb-1">ที่อยู่</p>
                                    <input type="text" class="form-control !text-gray-500" name="address" value="{{$admin_master->address}}">   
                
                                </div>
                                <div class="grid md:grid-cols-2 gap-3">
                                    <div>
                                        <p class="mt-4 mb-1">จังหวัด</p>
                                        <select class="form-select !text-gray-500" aria-label="Default select example" name="province" id="province">
                                            @if(isset($province))
                                                @foreach($province as $row)
                                
                                                    <option value="{{$row->id}}" {{$row->name_th == $admin_master->province ? 'selected' : '' }}>{{$row->name_th}}</option>
                                                
                                                @endforeach
                                            @endif
                                        </select>

                                        <p class="mt-4 mb-1">ตำบล/แขวง</p>
                                        <select class="form-select !text-gray-500" aria-label="Default select example" name="district" id="districts">
                                            @if(isset($district) && $district == '')
                                                @foreach($district as $row)
                                                    <option value="{{$row->amphure_id}}" {{$row->name_th == $admin_master->district ? 'selected' : '' }}>{{$row->name_th}}</option>
                                                @endforeach

                                            @else
                                            <option>{{$admin_master->district}}</option>
                                            @endif
                                        </select>
                                    </div>

                                    <div>
                                        <p class="mt-4 mb-1">อำเภอ/เขต</p>
                                        <select class="form-select !text-gray-500" aria-label="Default select example" id="amphures" name="amphur">

                                            @if(isset($amphur) && $amphur == '')
                                                @foreach($amphur as $row)
                                                    <option value="{{$row->province_id}}" {{$row->name_th == $admin_master->amphur ? 'selected' : '' }}>{{$row->name_th}}</option>
                                                @endforeach

                                            @else
                                            <option>{{$admin_master->amphur}}</option>
                                            @endif
                                        </select>

                                        <p class="mt-4 mb-1">รหัสไปรษณีย์ <span class="text-xs text-red-500">*กรุณาตรวจสอบ</span></p>
                                        <input type="text" class="form-control !text-gray-500" name="zipcode" id="zipcode" value="{{$admin_master->zipcode}}">
                                    </div>
                                </div>
                      
                                
                            </div>
                            <!--form login-->
                            <div>
                                <div class="form-control p-4">
                              
                                    <span class="font-medium text-lg">ข้อมูล Login</span>
                                    <hr class="my-3 !text-gray-400">
                                  
                                    <p class="mt-3 mb-1 !text-gray-600">อีเมล <span class="text-xs text-red-500">*จำเป็นต้องระบุ</span></p>
                                    <input type="text" class="form-control mb-3 !text-gray-500" name="email_login" value="{{$admin_master->email}}">

                                    <p class="mt-3 mb-1 !text-gray-600">สถานะเชื่อมต่อไลน์ <span class="text-xs text-red-500"></span></p>
                                    <input type="text" class="form-control mb-3 !text-gray-500" value="{{$admin_master->line_user_id ? 'เชื่อมต่อไลน์สำเร็จ' : 'ยังไม่เชื่อมต่อไลน์'}}">
                    {{-- 
                                    <p clas="mt-3 mb-1">รหัสผ่าน</p>
                                    <input type="text" class="form-control" name="password" disabled> --}}

                                </div>
                            
                                <div class="mb-3 my-4 ms-2">
                                    <p class="font-bold mb-2">เพิ่มเติม</p>
                                    <textarea class="form-control !text-gray-600" id="exampleFormControlTextarea1" rows="3" name="text_add">{{$admin_master->text_add}}</textarea>
                                </div>

                                <div class="text-end">
                                    <button type="submit" name="submit_update" class="bg-blue-600 hover:bg-blue-700 !rounded-lg px-4 py-2 text-white">บันทึก</button>
                                    {{-- <a href="" type="button" id="exportCsv" class="btn my-2" style="border:none; width: 120px; color: rgb(67, 67, 67); padding: 10px;">Export CSV</a> --}}

                                </div>
                            </div>
                        </div>
                            
                    </form>

                    <hr class="my-4 !text-gray-400">

                    <div class="mx-12">
                        <p class="mt-4 mb-1 !text-green-600 font-medium">สถานะเชื่อมต่อไลน์ <span class="text-xs text-red-500"></span></p>
                        <input type="text" class="form-control mb-1 mt-2 !text-gray-500" value="{{$admin_master->line_user_id ? 'เชื่อมต่อไลน์สำเร็จ' : 'ยังไม่เชื่อมต่อไลน์'}}">
    
                        <p class="mt-3 mb-2 text-gray-600 font-medium">สถานะยกเลิกการเชื่อมต่อโดย: 
                            @if($admin_master->status_line === 0)
                            <span class="text-red-500">ยังไม่ได้เชื่อมต่อ</span>
                            @elseif ($admin_master->line_logout_user === 1)
                            <span class="text-blue-500">ยกเลิกโดยแอดมิน</span>
                            @elseif ($admin_master->line_logout_admin === 1)
                            <span class="text-sky-500">ยกเลิกโดยผู้ใช้</span>
                            @else
                            <span class="text-green-500">กำลังเชื่อมต่อไลน์</span>
                            @endif
                        </p>
                        <form action="{{ route('line.revoktoken.admin') }}" method="POST" class="inline">
                            @csrf
                            <input type="hidden" name="id" value="{{ $admin_master->id }}">
                            <button type="submit"
                                class="bg-red-500 hover:bg-red-600 text-white !no-underline !rounded-md py-2 px-4 mt-1"
                                onclick="return confirm('คุณต้องการยกเลิกการเชื่อมต่อ LINE ใช่หรือไม่?')">
                                ยกเลิกเชื่อมต่อไลน์
                            </button>
                        </form>
                    </div>
                    <div class="mx-12">
                        @if (Session::has('status_line'))
                        <div class="alert alert-success mt-2"><i class="fa-solid fa-circle-check text-green-600"></i> {{ Session::get('status_line') }}</div>
                        @endif
                    </div>

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

            <hr class="my-4 !text-gray-400">

            @if (Session::has('success'))
            <div class="alert alert-success ms-6 mr-6"><i class="fa-solid fa-circle-check" style="color:green;"></i> {{ Session::get('success') }}</div>
            @endif

            @if (Session::has('error'))
            <div class="alert alert-danger ms-6 mr-6"><i class="fa-solid fa-circle-xmark" style="color: rgb(172, 27, 27);"></i> {{ Session::get('error') }}</div>
            
            @endif

            <form action="/webpanel/admin-detail/reset/{{$admin_master->id}}" method="POST" enctype="multipart/form-data">
                @csrf
                <ul class="text-title ms-8 mr-8">
                    <li>
                        <span class="font-bold">เปลี่ยนรหัสผ่าน</span>
                    </li>
                    <hr class="my-2 !text-gray-400">
                    <li class="my-3">
                        <span class="text-gray-600">รหัสผ่านใหม่</span>
                        <input type="password" class="form-control my-2" name="reset_password" required>
                    </li>
                    <hr class="my-2 !text-gray-400">
                    <button type="submit" name="submit_reset" id="reset" class="btn mb-4 mt-2" style="border:none; width:150px; color: white; padding: 10px;">เปลี่ยนรหัสผ่าน</button>
                </ul>
            </form>

                    
@push('scripts')
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
@endpush
@endsection
@push('styles')
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
    
@endpush
