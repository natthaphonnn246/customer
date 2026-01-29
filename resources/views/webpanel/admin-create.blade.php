@extends ('layouts.webpanel')
@section('content')
        
        <div class="py-2"></div>
        <h5 class="!text-gray-600 font-semibold ms-6"><a href="/webpanel/admin" class="!no-underline">ย้อนกลับ</a> | รายละเอียด</h5>
        <hr class="my-3 !text-gray-400 !border">

            <p class="ms-6" style="font-size: 18px; font-weight: 500;">ระบุข้อมูลแอดมิน</p>
         
            <hr class="my-3 !text-gray-400">

            <form action="/webpanel/admin-create/insert" method="post" enctype="multipart/form-data">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mx-4 px-2 text-gray-500">
           
                    <div>
    
                        <p class="mt-3 mb-1">ชื่อแอดมิน</p>
                        <input type="text" class="form-control mt-2 !text-gray-600" name="admin_name">
                       
                        <p class="mt-3 mb-1">CODE <span class="text-xs text-red-500">*จำเป็นต้องระบุ</span></p>
                        <input type="text" class="form-control placeholder:!text-gray-300 !text-gray-600" name="code" placeholder="จำเป็นต้องระบุ" required>
                        
                        <p class="mt-3 mb-1">สิทธิ์แอดมิน</p>
                        <select class="form-select mt-2 !text-red-500" aria-label="Default select example" name="role">
                            <option value="0">ไม่ระบุ</option>
                        </select>
                        
                        <p class="mt-3 mb-1">อีเมล</p>
                        <input name="email" type="email" class="form-control mt-2 !text-gray-600" id="email">
                         
                        <p class="mt-3 mb-1">เบอร์ติดต่อ <span class="text-xs text-red-500">(ตัวอย่าง: 0904545555)</span></p>
                        <input type="text" class="form-control mt-2 !text-gray-600" name="telephone">
            
                        <p class="mt-3 mb-1">ที่อยู่</p>
                        <input type="text" class="form-control mt-2 !text-gray-600" name="address" required>   

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-4">
                            <div>
                                <p class="mt-3 mb-1">จังหวัด</p>
                                <select class="form-select mt-2 !text-gray-600" aria-label="Default select example" name="province" id="province">
                                    @if(isset($provinces))
                                        @foreach($provinces as $row)
                                        
                                            <option value="{{$row->id}}">{{$row->name_th}}</option>
                                        
                                        @endforeach
                                    @endif
                                </select>

                                <p class="mt-3 mb-1">ตำบล/แขวง</p>
                                <select class="form-select mt-2 !text-gray-600" aria-label="Default select example" name="district" id="districts" required>
                                    @if(isset($district))
                                        @foreach($district as $row)
                                            <option value="{{$row->amphure_id}}">{{$row->name_th}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="mb-4">
                                <p class="mt-3 mb-1">อำเภอ/เขต</p>
                                <select class="form-select mt-2 !text-gray-600" aria-label="Default select example" id="amphures" name="amphur" required>
                                    
                                    @if(isset($ampures))
                                        @foreach($ampures as $row)
                                            <option value="{{$row->province_id}}">{{$row->name_th}}</option>
                                        @endforeach

                                    @endif
                                </select>
                          
                                <p class="mt-3 mb-1 !text-gray-600">รหัสไปรษณีย์ <span class="text-xs text-red-500">*กรุณาตรวจสอบ</span></p>
                                <input type="text" class="form-control mt-2" name="zipcode" id="zipcode" required>
                            </div>
                        </div>
                    </div>
                    <!--form login-->
                    <div>
                        <div class="form-control">
                
                            <p class="mt-2 mx-2 text-base font-semibold text-gray-600">ข้อมูล Login</p>
                           
                            <hr class="my-2 !text-gray-400">
                  
                            <div class="mx-2 px-2 py-1 mb-2">
                                <p class="mt-1 mb-1 !text-gray-500">อีเมล <span class="text-xs text-red-500">*จำเป็นต้องระบุ</span></p>
                                <input type="text" class="form-control !text-gray-600" name="email_login" id="emailLogin" value="">
                
                                <p class="mt-3 mb-1 !text-gray-500">รหัสผ่าน <span class="text-xs text-red-500">*จำเป็นต้องระบุ</span></p>
                                <input type="text" class="form-control !text-gray-500" name="password" required>
                            </div>

                        </div>
                    
                        <div class="mb-3 my-4">
                            <label for="exampleFormControlTextarea1" class="form-label mb-1">
                                <p class="font-bold mb-1 text-gray-600">เพิ่มเติม</p>
                            </label>
                            <textarea class="form-control !text-gray-600" id="exampleFormControlTextarea1" rows="3" name="text_add"></textarea>
                        </div>

                        <div class="text-end">
                            <button type="submit" name="submit_form" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 !rounded-lg"">บันทึกข้อมูล</button>
                        </div>
                            
                    </div>
                </div>

            </form>
     
    @push('scripts')
    
    {{-- <input id="logins" value=""> --}}
    @if (session('error_admin') == 'email')
    <script> 
            Swal.fire({
                title: "กรุณาตรวจสอบ Code และ Email",
                // text: "กรุณารอสักครู่",
                icon: "warning",
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

    <script>
        $(document).ready(function () {
            $("#email").keyup(function(){
                const email = $("#email").val();
                const email_login = $("#emailLogin").val(email);
                console.log(email);
            });
        });
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
@endpush