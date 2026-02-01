@extends ('layouts.webpanel')
@section('content')

    <div class="contentArea w-full max-w-full break-words">
        
        <div class="py-2"></div>
        <h5 class="!text-gray-600 font-semibold ms-6">ตั้งค่าเว็บไซต์</h5>
        <hr class="my-3 !text-gray-400 !border">

        <form method="post" action="/webpanel/setting/update-setting" enctype="multipart/form-data">
            @csrf
            @if(!empty($setting_view))
                <div class="grid grid-cols-1 md:grid-cols-2 mx-4 gap-3">
                    <div>
                        <p class="text-gray-500">สถานะของเว็บไซต์</p>
                        <select class="form-select" style="margin-top:10px; color: rgb(171, 171, 171);" aria-label="Default select example" name="maintenance_status">
                            <option {{$setting_view->web_status == '0' ? 'selected': ''}} value="0">ปกติ</option>
                            <option {{$setting_view->web_status == '1' ? 'selected': ''}} value="1">อยู่ระหว่างการปรับปรุง</option> 
                        </select>

                    </div>
                    <div>
                        <p class="text-gray-500">สิทธิ์ในการทดสอบระบบ <span class="text-xs text-red-500">*เมื่ออยู่ระหว่างปรับปรุงระบบ</span></p>
                        <select class="form-select" style="margin-top:10px; color: rgb(171, 171, 171);" aria-label="Default select example" name="allowed_maintenance_status">
                            <option {{$setting_view->allowed_web_status == '0' ? 'selected': ''}} value="0">ไม่ระบุ</option>
                            <option {{$setting_view->allowed_web_status == '1' ? 'selected': ''}} value="1">ระบุ</option>                           
                        </select>
                    </div>

                </div>
                <hr class="!text-gray-500">
                <div class="grid grid-cols-1 md:grid-cols-2 mx-4 gap-3 mt-4">
                    <div>
                        <p class="text-lg font-medium text-gray-600">ลบรายงานขายอัตโนมัติ</p>
                        <select class="form-select" style="margin-top:10px; color: rgb(171, 171, 171);" aria-label="Default select example" name="del_reportseller">

                            <option {{$setting_view->del_reportseller == '0' ? 'selected': ''}} value="0">ปิด</option>
                            <option {{$setting_view->del_reportseller == '1' ? 'selected': ''}} value="1">เปิด</option>
                            
                        </select>
                    </div>
                </div>
                <hr class="!text-gray-500">
                <div class="grid grid-cols-1 md:grid-cols-2 mx-4 gap-3 mt-4">
                    <div>
                        <p class="text-lg font-medium text-gray-600">อัปเดตข้อมูลร้านค้า</p>
                            <p class="text-gray-500">สถานะเปิดให้แอดมินแก้ไขลูกค้า <span class="text-xs text-red-500">*เปิดเท่ากับแก้ไขลูกค้าได้</span></p>
                            <select class="form-select" style="margin-top:10px; color: rgb(171, 171, 171);" aria-label="Default select example" name="check_edit">

                                <option {{$setting_view->check_edit == '1' ? 'selected': ''}} value="1">ปิด</option>
                                <option {{$setting_view->check_edit == '0' ? 'selected': ''}} value="0">เปิด</option>                           
                                
                            </select>
                        </div>
                </div>
                <hr class="!text-gray-500">
                <p class="mx-4 text-lg font-medium text-gray-600">ประเภทร้านค้า</p>
                <div class="grid grid-cols-1 md:grid-cols-2 mx-4 gap-3 mt-1">
                    <div>
                            <p class="text-gray-500">สถานะเปิดให้แอดมินเข้าถึงประเภทร้านค้า (ข.ย.2 / สมพ.2) <span class="text-xs text-red-500">*เปิดเท่ากับเข้าใช้งานได้</span></p>
                            <select class="form-select" style="margin-top:10px; color: rgb(171, 171, 171);" aria-label="Default select example" name="check_type">

                                <option {{$setting_view->check_type == '1' ? 'selected': ''}} value="1">ปิด</option>
                                <option {{$setting_view->check_type == '0' ? 'selected': ''}} value="0">เปิด</option>                           
                            
                            </select>
                    </div>

                    <div>
                            <p class="text-gray-500">กำหนดเวลาเข้าใช้งานประเภทร้านค้า (ข.ย.2 / สมพ.2) <span class="text-xs text-red-500">*หน่วยเป็นนาที</span></p>
                            <select class="form-select" style="margin-top:10px; color: rgb(171, 171, 171);" aria-label="Default select example" name="check_time_type">

                                <option {{$setting_view->check_time_type === 300 ? 'selected': ''}} value="300">5</option>
                                <option {{$setting_view->check_time_type === 900 ? 'selected': ''}} value="900">15</option>
                                <option {{$setting_view->check_time_type === 1800 ? 'selected': ''}} value="1800">30</option>                              
                                
                            </select>
                    </div>
                </div>
                <hr class="!text-gray-500">
            @endif
            <div class="mx-4">
                <button type="submit" id="updateForm" name="submit_setting" class="btn my-4" style="border:none; width: 100px; color: white; padding: 10px;">บันทึก</button>
            </div>
        </form>
    {{-- </div> --}}
    @if(Session::has('settings'))

        <script>

                $(document).ready(function () {

                    $('#bg').css('display', 'none');
                    Swal.fire({
                    icon:'success',
                    title: 'สำเร็จ',
                    text: 'อัปเดตสถานะเว็บไซต์เรียบร้อย',
                    showConfirmButton: true,
                    confirmButtonText: 'รับทราบ'

                }).then(function() {
                    $('#bg').css('display', '');
                });

            });
           
        </script>
    @endif
    @endsection
</div>
@push('styles')
<style>
    #updateForm {
        background-color: #4355ff;
        color:white;
    }
    #updateForm:hover {
        width: auto;
        height: auto;
        background-color: #0f21cb;
    }
</style>
@endpush
