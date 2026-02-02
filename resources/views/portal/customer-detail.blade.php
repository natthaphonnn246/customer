@extends ('layouts.portal')
@section('content')

    <div>
        <div class="py-2"></div>
        <h5 class="ms-6 !text-gray-600"><a href="/portal/customer" id="backLink">ย้อนกลับ</a> | รายละเอียด</h5>
        <hr class="my-3">
   
        @php
            $year = date('Y') + 543; 
        @endphp

    <!-- Modal -->
    <div class="modal fade" id="checkModal" tabindex="-1" aria-labelledby="checkModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header text-center">
            <h5 class="modal-title w-100 text-center" style="font-size: 24px; font-weight:500; color: rgb(68, 68, 68);">กรุณาตรวจสอบ</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="ปิด"></button>
            </div>
            <div class="modal-body text-left">
            <p style="color: rgb(0, 68, 255);"><i class="fa-regular fa-square-check"></i> CODE</p>
            <p style="color: rgb(255, 62, 62);"><i class="fa-regular fa-square-check"></i> ชื่อร้าน (ถ้าเปลี่ยนแปลงกรุณาแจ้งด้วย)*</p>
            <p style="color: rgb(255, 0, 162);"><i class="fa-regular fa-square-check"></i> ใบอนุญาตขายยา/สถานพยาบาลปี {{ $year }}</p>
            <p style="color: rgb(132, 0, 255);"><i class="fa-regular fa-square-check"></i> ใบประกอบเช็กเลข ภ. และชื่อผู้ปฏิบัติหน้าที่ ข้อมูลต้องตรงกับใบอนุญาตขายยา</p>
            <p style="color: green;"><i class="fa-regular fa-square-check"></i> เลขที่ใบอนุญาต</p>
            <p style="color: rgb(255, 119, 0);"><i class="fa-regular fa-square-check"></i> วันหมดอายุ</p>
            </div>
            <div class="modal-footer">
            <button type="button" id="acknowledgeBtn" class="btn btn-primary">รับทราบ</button>
            </div>
        </div>
        </div>
    </div>

    <script>
            document.addEventListener("DOMContentLoaded", function() {
                var myModal = new bootstrap.Modal(document.getElementById('checkModal'));
            
                // แสดง modal ถ้า flag skipModalUpdateForm ไม่อยู่
                if (!sessionStorage.getItem('skipModalUpdateForm')) {
                    myModal.show();
                } else {
                    // ลบ flag → ครั้งต่อไปเปิดหน้าใหม่ modal จะแสดง
                    sessionStorage.removeItem('skipModalUpdateForm');
                }
            
                // ปุ่มรับทราบ modal
                const acknowledgeBtn = document.getElementById('acknowledgeBtn');
                if (acknowledgeBtn) {
                    acknowledgeBtn.addEventListener('click', function() {
                        myModal.hide();
                    });
                }
            
                // จับ submit ของ form (updateForm)
                const updateFormBtn = document.getElementById('updateForm');
                if (updateFormBtn) {
                    updateFormBtn.addEventListener('click', function() {
                        // ตั้ง flag ก่อน reload → modal จะไม่แสดงตอน reload
                        sessionStorage.setItem('skipModalUpdateForm', 'true');
                        // form จะ submit ตามปกติ
                    });
                }
            });
    </script>
    
    @if (isset($customer_edit) != '')

    <div id="protected">
            {{-- action="/webpanel/admin-detail/update/{{$row_edit->user_code}}" enctype="multipart/form-data" --}}
            {{-- @csrf --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mx-8">
                <div class="">
                        <h4 class="!text-gray-600">เอกสารใบอนุญาต</h4>
                        <hr style="color: #8E8E8E; width: 100%; margin-top: 15px;">
                        <!-- Button trigger modal -->
                        <div class="mt-4">
                            <span>ใบอนุญาตขายยา/สถานพยาบาล</span> <span class="text-red-500 text-xs">*จำเป็นต้องระบุ</span>
                            <button type="button" class="btn mt-2" id="certStore" style="width:100%; border:none;" data-bs-toggle="modal" data-bs-target="#staticBackdrop_store">
                                ใบบอนุญาตขายยา/สถานพยาบาล
                            </button>
                            @if ($customer_edit->cert_store == '')
                            <div class="py-2">
                                <span style="font-size: 14px; color:red; background-color:#f6ff94; padding:5px; font-weight:500;">**ไม่พบเอกสาร</span>
                            </div>
                            <hr class="my-2 mb-2" style="color: #8E8E8E; width: 100%;">
                            @endif

                            <div class="modal fade" id="staticBackdrop_store" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">แก้ไขใบอนุญาตขายยา</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <span class="ms-3 py-2" style="text-align: start;">แก้ไขใบอนุญาตขายยา/สถานพยาบาล/Code : {{$customer_edit->customer_code}}</span>
                                <hr style="color:#a5a5a5;">
                                    <div class="modal-body">
                                        <form action="/portal/customer-detail/upload-store/{{$customer_edit->customer_code}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        @if ((($customer_edit->cert_store)) != '')
                                        <div id="protected_image" style="position: relative;">
                                            <img src={{asset("storage/".$customer_edit->cert_store)}}?v=<?php echo time(); ?>" id="previewStore" style="width: 100%";/>
                                        </div>
                                            {{-- {{time()}} --}}
                                        @else
                                        <div id="protected_image" style="position: relative;">
                                        <img src="/profile/image.jpg" width="100%" id="previewStore">
                                        </div>
                                        @endif
                                    
                                        <input type="file" id="imageStore" class="form-control" name="cert_store" style="margin-top: 10px;"; accept="image/png, image/jpg, image/jpeg"/>
                                        {{-- <hr class="py-2 mt-2"> --}}
                                        <div class="modal-footer mt-4">

                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                                            <button type="submit" name="submit_store" class="btn" id="submitUpload" style="margin: 5px;">บันทึก</button>
                                            {{-- <button type="button" class="btn btn-primary">บันทึก</button> --}}

                                        </div>
                                    
                                        </form>
                                    </div>
                            
                                </div>
                            </div>
                            </div>
                        </div>

                        <script>

                                              
                            const staticBackdropStore = document.getElementById('staticBackdrop_store');
                            if (staticBackdropStore) {
                                staticBackdropStore.addEventListener('click', function() {
                                    // ตั้ง flag ก่อน reload → modal จะไม่แสดงตอน reload
                                    sessionStorage.setItem('skipModalUpdateForm', 'true');
                                    // form จะ submit ตามปกติ
                                });
                            }

                        </script>

                        <div class="mt-4">
                            <span>ใบประกอบวิชาชีพ</span> <span class="text-red-500 text-xs">*จำเป็นต้องระบุ</span>
                            <button type="button" class="btn mt-2" id="certMedical" style="width:100%; border:none;" data-bs-toggle="modal" data-bs-target="#staticBackdrop_medical">
                                ใบประกอบวิชาชีพ
                            </button>
                            @if ($customer_edit->cert_medical == '')
                            <div class="py-2">
                                <span style="font-size: 14px; color:red; background-color:#f6ff94; padding:5px; font-weight:500;">**ไม่พบเอกสาร</span>
                            </div>
                            <hr class="my-2 mb-2" style="color: #8E8E8E; width: 100%;">
                            @endif

                            <div class="modal fade" id="staticBackdrop_medical" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">ใบประกอบวิชาชีพ</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <span class="ms-3 py-2" style="text-align: start;">ใบประกอบวิชาชีพ/Code : {{$customer_edit->customer_code}}</span>
                                <hr style="color:#a5a5a5;">
                                    <div class="modal-body">
                                        <form action="/portal/customer-detail/upload-medical/{{$customer_edit->customer_code}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        @if ((($customer_edit->cert_medical)) != '')
                                        
                                            <img src={{asset("storage/".$customer_edit->cert_medical)}}?v=<?php echo time(); ?>" id="previewMedical" style="width: 100%";/>
                                        {{-- {{time()}} --}}
                                        @else
                                        <img src="/profile/image.jpg" width="100%" id="previewMedical">
                                        @endif
                                    
                                        <input type="file" id="imageMedical" class="form-control" name="cert_medical" style="margin-top: 10px;" accept="image/png, image/jpg, image/jpeg"/>
                                        {{-- <hr class="py-2 mt-2"> --}}
                                        <div class="modal-footer mt-4">

                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                                            <button type="submit" name="submit_medical" class="btn" id="submitUpload" style="margin: 5px;">บันทึก</button>
                                            {{-- <button type="button" class="btn btn-primary">บันทึก</button> --}}

                                        </div>
                                    
                                        </form>
                                    </div>
                            
                                </div>
                            </div>
                            </div>
                        </div>

                        <script>
                            
                            const staticBackdropMedical = document.getElementById('staticBackdrop_medical');
                            if (staticBackdropMedical) {
                                staticBackdropMedical.addEventListener('click', function() {
                                    // ตั้ง flag ก่อน reload → modal จะไม่แสดงตอน reload
                                    sessionStorage.setItem('skipModalUpdateForm', 'true');
                                    // form จะ submit ตามปกติ
                                });
                            }

                        </script>

                        <div class="mt-4">
                            <span>ใบทะเบียนพาณิชย์</span>
                            <button type="button" class="btn mt-2" id="certCommerce" style="width:100%; border:none;" data-bs-toggle="modal" data-bs-target="#staticBackdrop_commerce">
                                ใบทะเบียนพาณิชย์
                            </button>
                            @if ($customer_edit->cert_commerce == '')
                            <div class="py-2">
                                <span style="font-size: 14px; color:red; background-color:#f6ff94; padding:5px; font-weight:500;">**ไม่พบเอกสาร</span>
                            </div>
                            <hr class="my-2 mb-2" style="color: #8E8E8E; width: 100%;">
                            @endif

                            <div class="modal fade" id="staticBackdrop_commerce" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">ใบทะเบียนพาณิชย์</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <span class="ms-3 py-2" style="text-align: start;">ใบทะเบียนพาณิชย์/Code : {{$customer_edit->customer_code}}</span>
                                <hr style="color:#a5a5a5;">
                                    <div class="modal-body">
                                        <form action="/portal/customer-detail/upload-commerce/{{$customer_edit->customer_code}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        @if ((($customer_edit->cert_commerce)) != '')
                                        
                                            <img src={{asset("storage/".$customer_edit->cert_commerce)}}?v=<?php echo time(); ?>" id="previewCommerce" style="width: 100%";/>
                                        {{-- {{time()}} --}}
                                        @else
                                        <img src="/profile/image.jpg" width="100%" id="previewCommerce">
                                        @endif
                                    
                                        <input type="file" id="imageCommerce" class="form-control" name="cert_commerce" style="margin-top: 10px;" accept="image/png, image/jpg, image/jpeg"/>
                                        {{-- <hr class="py-2 mt-2"> --}}
                                        <div class="modal-footer mt-4">

                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                                            <button type="submit" name="submit_commerce" class="btn" id="submitUpload" style="margin: 5px;">บันทึก</button>
                                            {{-- <button type="button" class="btn btn-primary">บันทึก</button> --}}

                                        </div>
                                    
                                        </form>
                                    </div>
                            
                                </div>
                            </div>
                            </div>
                        </div>

                        <script>
                            const staticBackdropCommerce = document.getElementById('staticBackdrop_commerce');
                            if (staticBackdropCommerce) {
                                staticBackdropCommerce.addEventListener('click', function() {
                                    // ตั้ง flag ก่อน reload → modal จะไม่แสดงตอน reload
                                    sessionStorage.setItem('skipModalUpdateForm', 'true');
                                    // form จะ submit ตามปกติ
                                });
                            }
                        </script>

                        <div class="mt-4">
                            <span>ใบทะเบียนภาษีมูลค่าเพิ่ม (ภ.พ.20)</span>
                            <button type="button" class="btn mt-2" id="certVat" style="width:100%; border:none;" data-bs-toggle="modal" data-bs-target="#staticBackdrop_vat">
                                ใบทะเบียนภาษีมูลค่าเพิ่ม (ภ.พ.20)
                            </button>
                            @if ($customer_edit->cert_vat == '')
                            <div class="py-2">
                                <span style="font-size: 14px; color:red; background-color:#f6ff94; padding:5px; font-weight:500;">**ไม่พบเอกสาร</span>
                            </div>
                            <hr class="my-2 mb-2" style="color: #8E8E8E; width: 100%;">
                            @endif

                            <div class="modal fade" id="staticBackdrop_vat" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">ใบทะเบียนภาษีมูลค่าเพิ่ม (ภ.พ.20)</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <span class="ms-3 py-2" style="text-align: start;">ใบทะเบียนภาษีมูลค่าเพิ่ม (ภ.พ.20)/Code : {{$customer_edit->customer_code}}</span>
                                <hr style="color:#a5a5a5;">
                                    <div class="modal-body">
                                        <form action="/portal/customer-detail/upload-vat/{{$customer_edit->customer_code}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        @if ((($customer_edit->cert_vat)) != '')
                                        
                                            <img src={{asset("storage/".$customer_edit->cert_vat)}}?v=<?php echo time(); ?>" id="previewVat" style="width: 100%";/>
                                        {{-- {{time()}} --}}
                                        @else
                                        <img src="/profile/image.jpg" width="100%" id="previewVat">
                                        @endif
                                    
                                        <input type="file" id="imageVat" class="form-control" name="cert_vat" style="margin-top: 10px;" accept="image/png, image/jpg, image/jpeg"/>
                                        {{-- <hr class="py-2 mt-2"> --}}
                                        <div class="modal-footer mt-4">

                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                                            <button type="submit" name="submit_vat" class="btn" id="submitUpload" style="margin: 5px;">บันทึก</button>
                                            {{-- <button type="button" class="btn btn-primary">บันทึก</button> --}}

                                        </div>
                                    
                                        </form>
                                    </div>
                            
                                </div>
                            </div>
                            </div>
                        </div>

                        <script>
                            const staticBackdropVat = document.getElementById('staticBackdrop_vat');
                            if (staticBackdropVat) {
                                staticBackdropVat.addEventListener('click', function() {
                                    // ตั้ง flag ก่อน reload → modal จะไม่แสดงตอน reload
                                    sessionStorage.setItem('skipModalUpdateForm', 'true');
                                    // form จะ submit ตามปกติ
                                });
                            }
                        </script>

                        <div class="mt-4">
                            <span>สำเนาบัตรประชาชน</span>
                            <button type="button" class="btn mt-2" id="certId" style="width:100%; border:none;" data-bs-toggle="modal" data-bs-target="#staticBackdrop_id">
                                สำเนาบัตรประชาชน
                            </button>
                            @if ($customer_edit->cert_id == '')
                            <div class="py-2">
                                <span style="font-size: 14px; color:red; background-color:#f6ff94; padding:5px; font-weight:500;">**ไม่พบเอกสาร</span>
                            </div>
                            <hr class="my-2 mb-2" style="color: #8E8E8E; width: 100%;">
                            @endif

                            <div class="modal fade" id="staticBackdrop_id" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">สำเนาบัตรประชาชน</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <span class="ms-3 py-2" style="text-align: start;">สำเนาบัตรประชาชน/Code : {{$customer_edit->customer_code}}</span>
                                <hr style="color:#a5a5a5;">
                                    <div class="modal-body">
                                        <form action="/portal/customer-detail/upload-id/{{$customer_edit->customer_code}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        @if ((($customer_edit->cert_id)) != '')
                                        
                                            <img src={{asset("storage/".$customer_edit->cert_id)}}?v=<?php echo time(); ?>" id="previewId" style="width: 100%";/>
                                        {{-- {{time()}} --}}
                                        @else
                                        <img src="/profile/image.jpg" width="100%" id="previewId">
                                        @endif
                                    
                                        <input type="file" id="imageId" class="form-control" name="cert_id" style="margin-top: 10px;" accept="image/png, image/jpg, image/jpeg"/>
                                        {{-- <hr class="py-2 mt-2"> --}}
                                        <div class="modal-footer mt-4">

                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                                            <button type="submit" name="submit_id" class="btn" id="submitUpload" style="margin: 5px;">บันทึก</button>
                                            {{-- <button type="button" class="btn btn-primary">บันทึก</button> --}}

                                        </div>
                                    
                                        </form>
                                    </div>
                            
                                </div>
                            </div>
                            </div>
                        </div>

                        <script>
                            const staticBackdropId = document.getElementById('staticBackdrop_id');
                            if (staticBackdropId) {
                                staticBackdropId.addEventListener('click', function() {
                                    // ตั้ง flag ก่อน reload → modal จะไม่แสดงตอน reload
                                    sessionStorage.setItem('skipModalUpdateForm', 'true');
                                    // form จะ submit ตามปกติ
                                });
                            }
                        </script>

                    <form action="/portal/customer-detail/update/{{$customer_edit->id}}" method="post" enctype="multipart/form-data">
                        @csrf
                            {{-- @method('PUT') --}}
                            <span class="block mt-4">เลขใบอนุญาตขายยา/สถานพยาพยาล <span class="text-red-500 text-sm">*จำเป็นต้องระบุ</span></span>
                            <input style="margin-top:10px; color: rgb(171, 171, 171);" type="text" class="form-control" name="cert_number" value="{{$customer_edit->cert_number}}">

                            @php
                                $year = date('Y') + 543; 
                            @endphp
                                <label class="mb-2 mt-4">
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
                                        value="{{ $customer_edit?->cert_expire }}"
                                        class="w-full rounded-md border !border-gray-300
                                            px-3 py-2 pr-10 text-gray-400
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

                            <h4 class="!text-gray-600 mt-4">ข้อมูลร้านค้า</h4>
                            <hr style="color: #8E8E8E; width: 100%; margin-top: 15px;">

                            <span class="block mt-4">ชื่อร้านค้า</span>
                            <input style="margin-top:10px; color: rgb(171, 171, 171);" type="text" class="form-control" name="customer_name" value="{{$customer_edit->customer_name}}" disabled>

                            <span class="block mt-4">CODE <span class="text-red-500 text-xs">*จำเป็นต้องระบุ</span></span>
                            <input style="margin-top:10px; color: rgb(171, 171, 171);" type="text" class="form-control" name="code" value="{{$customer_edit->customer_code;}}" disabled>

                            <span class="block mt-4">ระดับราคา</span>
                            <select class="form-select" style="margin-top:10px; color: rgb(171, 171, 171);" aria-label="Default select example" name="price_level" disabled>
                            
                                <option name="price_level">{{$customer_edit->price_level}}</option>

                            </select>
                                {{-- {{dd($customer_edit->cert_expire);}} --}}

                            <span class="block mt-4">อีเมล</span>
                            <input style="margin-top:10px; color: rgb(171, 171, 171);" name="email" type="email" class="form-control" name="email" value="{{$customer_edit->email}}">
            
                            <span class="block mt-4">เบอร์ติดต่อ <span class="text-red-500 text-xs">(ตัวอย่าง: 027534702)</span></span>
                            <input style="margin-top:10px; color: rgb(171, 171, 171);" type="text" class="form-control" name="phone" value="{{$customer_edit->phone}}">
                
                            <span class="block mt-4">เบอร์โทรศัพท์ <span class="text-red-500 text-xs">(ตัวอย่าง: 0904545555)</span></span>
                            <input style="margin-top:10px; color: rgb(171, 171, 171);" type="text" class="form-control" name="telephone" value="{{$customer_edit->telephone}}">
                
                            <span class="block mt-4">การจัดส่งสินค้า <span class="text-red-500 text-xs"> *ไม่ระบุ คือ จัดส่งตามรอบขนส่งทางร้าน</span></span>
                                <select class="form-select" style="margin-top:10px; color: rgb(171, 171, 171);" aria-label="Default select example" name="delivery_by">
                                    <option {{$customer_edit->delivery_by == 'standard' ? 'selected': ''}} value="standard">ไม่ระบุ</option>
                                    <option {{$customer_edit->delivery_by == 'owner' ? 'selected': ''}} value="owner">ขนส่งเอกชน (พัสดุ)</option>
                                </select>
            
                            <span class="block mt-4">ที่อยู่จัดส่ง</span>
                            <input style="margin-top:10px; color: rgb(171, 171, 171);" type="text" class="form-control no-paste" name="address" value="{{$customer_edit->address}}" required>
                                
                            <script>
                                document.querySelectorAll('input.no-paste').forEach(input => {
                                    input.addEventListener('paste', e => e.preventDefault());
                                });
    
                            </script>                     
                 
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mt-4">
                                <div>
                                    <span>จังหวัด</span>
 
                                    <select class="form-select" style="margin-top:10px; color: rgb(171, 171, 171);" aria-label="Default select example" name="province" id="province">
                                        @if(isset($province))
                                            @foreach($province as $row)
                            
                                                <option value="{{$row->id}}" {{$row->name_th == $customer_edit->province ? 'selected' : ''}}>{{$row->name_th}}</option>
                                            
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div>
                                    <span>อำเภอ/เขต</span>
                                    <select class="form-select" style="margin-top:10px; color: rgb(171, 171, 171);" aria-label="Default select example" id="amphures" name="amphur">

                                        @if(isset($amphur) && $amphur == '')
                                            @foreach($amphur as $row)
                                                <option value="{{$row->province_id}}" {{$row->name_th == $customer_edit->amphur ? 'selected' : ''}}>{{$row->name_th}}</option>
                                            @endforeach

                                        @else
                                        <option>{{$customer_edit->amphur}}</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mt-4 mb-8">
                                <div>
                                    <span>ตำบล/แขวง</span>
                                    <select class="form-select" style="margin-top:10px; color: rgb(171, 171, 171);" aria-label="Default select example" name="district" id="districts">
                                        @if(isset($district) && $district == '')
                                            @foreach($district as $row)
                                                <option value="{{$row->amphure_id}}" {{$row->name_th == $customer_edit->district ? 'selected' : ''}}>{{$row->name_th}}</option>
                                            @endforeach

                                        @else
                                        <option>{{$customer_edit->district}}</option>
                                        @endif
                                    </select>
                                </div>
                        
                                <div>
                                    <span>รหัสไปรษณีย์</span> <span class="text-xs text-red-500">*กรุณาตรวจสอบ</span>
                                    <input style="margin-top:10px; color: rgb(171, 171, 171);" type="text" class="form-control" name="zip_code" id="zipcode" value="{{$customer_edit->zip_code}}">
                                </div>
                            </div>
                    </div>
                    <!--form login-->
                    <div class="">
                    
                            <div class="form-control p-4">
                                <h5 class="!text-gray-600">ผู้รับผิดชอบ</h5>
                                <hr style="color: #8E8E8E; width: 100%; margin-top: 15px;">

                                    <div class="py-2">
                                    <span>แอดมินผู้ดูแล</span>
                                        <select class="form-select" style="margin-top:10px;  color: rgb(171, 171, 171);" aria-label="Default select example" name="admin_area" disabled>

                                            <option>{{$customer_edit->admin_area.' '.'('.$user_name->name.')'}}</option>

                                        </select>
                                    </div>
                                    <div class="py-2">
                                    <span>เขตการขาย</span>
                                        <select class="form-select" style="margin-top:10px;  color: rgb(171, 171, 171);" aria-label="Default select example" name="sale_area" disabled>

                                            @if(isset($sale_name))
                                            <option>{{$customer_edit->sale_area.' '.'('.$sale_name->sale_name.')'}}</option>
                                            @else
                                            <option>{{$customer_edit->sale_area.' '.'('.'ไม่พบชื่อ'.')'}}</option>
                                            @endif
                                        </select>
                                    </div>
    
                            </div>

                                <div class="mb-3 my-4">
                                    <label for="exampleFormControlTextarea1" class="form-label" style="font-size: 16px; font-weight: 400; color:#fe505b;">*ข้อความถึงแอดมินผู้ดูแล</label></label>
                                    <textarea class="form-control" style="color: rgb(255, 86, 56);" id="exampleFormControlTextarea1" rows="3" name="text_admin" disabled>{{$customer_edit->text_admin}}</textarea>
                                </div>
                        
                                <div class="mb-4 my-4">
                                    <span style="font-size:18px; font-weight:500;">ช่องทางการสั่งสินค้า</span><span class="text-red-500 text-sm"> *เลือกช่องทางที่สั่งมากสุด</span>
                                    <select class="form-select" style="margin-top:10px; color: grey;" aria-label="Default select example" name="purchase">
                                    <option {{ $customer_edit->purchase === 1 ? 'selected': '' }} value="1">สั่งซื้อผ่านทางเว็บไซต์</option>
                                    <option  {{ $customer_edit->purchase === 0 ? 'selected': '' }} value="0">สั่งซื้อผ่านช่องทางอื่น ๆ (เช่น LINE หรือทางโทรศัพท์)</option>
                                    </select>
                                </div>

                            <div style="text-align:right; margin-top: 20px;">
                                <button type="submit" id="updateForm" name="submit_update" class="btn my-2" style="border:none; width: 100px; color: white; padding: 10px;">บันทึก</button>
                            </div>

                    </div>
                </div>
            </form>
    </div>
</div>
    <script>
        $(document).ready(function () {
            $('#updateForm').on('submit', function () {
                $('#bgs').css('display', 'block');
            });
        });
    </script>
        
                    @if (session('status') == 'updated_success')
                        <script>
                                    $('#bgs').css('display', 'none');
                                    Swal.fire({
                                        title: 'กรุณาติดต่อผู้ดูแล',
                                        text: 'บันทึกเรียบร้อย',
                                        icon: "success",
                                        confirmButtonColor: "#3085d6",
                                        confirmButtonText: "ตกลง"
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            // ตั้ง flag ก่อน reload → modal จะไม่แสดงหลังจาก reload
                                            sessionStorage.setItem('skipModalUpdateForm', 'true');
                                            window.location.reload();
                                        }
                                    });
                            </script>
                            
                    @endif

                    @if (session('status') == 'updated_fail')
                        <script> 
                                // $('#bgs').css('display', 'none');
                                $('#bgs').css({
                                    display: 'flex',
                                    background: 'rgba(0,0,0,0.6)'
                                });

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
                   {{--  <script>
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
                    </script> --}}

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
                  {{--   <script>

                        $(document).ready(function(){
                            $('#certStore').click(function(){
                                // e.preventDefault(); ปิดใช้งาน submit ปกติ
                                Swal.fire ({
                                    html:
                                    '<p style="text-align: start;">แก้ไขใบอนุญาตขายยา/สถานพยาบาล/Code : {{$customer_edit->customer_code; }}</p>'
                                    +'<hr>'
                                    +'<form action="/portal/customer-detail/upload-store/{{$customer_edit->customer_code}}" method="post" enctype="multipart/form-data">'
                                    +'@csrf'
                                    // +'<img src="/storage/certs/{{$customer_edit->cert_store ; }}" id="fileImage" style="width: 100%";/>'
                                    +'<img src="{{asset("storage/".$customer_edit->cert_store)}}" id="fileImage" style="width: 100%";/>'
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
                                                //ตรวจสอบ image size;
                                                $('#image').bind('change', function() {
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
                                                        $("#image").val('');
                                                    });

                                                }
                                            });
                                        });
                                    });
                            //close window reload window;
                            function closeWin() {
                            Swal.close();
                            // window.location.reload();
                            }
                    </script> --}}

                    <!--- php upload ใบประกอบวิชาชีพ--->
                   {{--  <script>

                        $(document).ready(function(){
                            $('#certMedical').click(function(){
                                // e.preventDefault(); ปิดใช้งาน submit ปกติ
                                Swal.fire ({
                                    html:
                                    '<p style="text-align: start;">แก้ไขใบประกอบวิชาชีพ/Code : {{$customer_edit->customer_code; }}</p>'
                                    +'<hr>'
                                    +'<form action="/portal/customer-detail/upload-medical/{{$customer_edit->customer_code}}" method="post" enctype="multipart/form-data">'
                                    +'@csrf'
                                    // +'<img src="/storage/certs/{{$customer_edit->cert_medical ; }}" id="fileImage" style="width: 100%";/>'
                                    +'<img src="{{asset("storage/".$customer_edit->cert_medical)}}" id="fileImage" style="width: 100%";/>'
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
                                                //ตรวจสอบ image size;
                                                $('#image').bind('change', function() {
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
                                                        $("#image").val('');
                                                    });

                                                }
                                            });
                                        });
                                    });
                            //close window reload window;
                            function closeWin() {
                            Swal.close();
                            // window.location.reload();
                            }
                    </script> --}}

                    <!--- php upload ใบทะเบียนพาณิชย์--->
                   {{--  <script>

                        $(document).ready(function(){
                            $('#certCommerce').click(function(){
                                // e.preventDefault(); ปิดใช้งาน submit ปกติ
                                Swal.fire ({
                                    html:
                                    '<p style="text-align: start;">แก้ไขใบทะเบียนพาณิชย์/Code : {{$customer_edit->customer_code; }}</p>'
                                    +'<hr>'
                                    +'<form action="/portal/customer-detail/upload-commerce/{{$customer_edit->customer_code}}" method="post" enctype="multipart/form-data">'
                                    +'@csrf'
                                    // +'<img src="/storage/certs/{{$customer_edit->cert_commerce ; }}" id="fileImage" style="width: 100%";/>'
                                    +'<img src="{{asset("storage/".$customer_edit->cert_commerce)}}" id="fileImage" style="width: 100%";/>'
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
                                                //ตรวจสอบ image size;
                                                $('#image').bind('change', function() {
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
                                                        $("#image").val('');
                                                    });

                                                }
                                            });
                                        });
                                    });
                            //close window reload window;
                            function closeWin() {
                            Swal.close();
                            // window.location.reload();
                            }
                    </script>
 --}}
                    <!--- php upload ใบทะเบียนภาษีมูลค่าเพิ่ม (ภ.พ.20)--->
                  {{--   <script>

                        $(document).ready(function(){
                            $('#certVat').click(function(){
                                // e.preventDefault(); ปิดใช้งาน submit ปกติ
                                Swal.fire ({
                                    html:
                                    '<p style="text-align: start;">แก้ไขใบภาษีมูลค่าเพิ่ม (ภ.พ.20)/Code : {{$customer_edit->customer_code; }}</p>'
                                    +'<hr>'
                                    +'<form action="/portal/customer-detail/upload-vat/{{$customer_edit->customer_code}}" method="post" enctype="multipart/form-data">'
                                    +'@csrf'
                                    // +'<img src="/storage/certs/{{$customer_edit->cert_vat; }}" id="fileImage" style="width: 100%";/>'
                                    +'<img src="{{asset("storage/".$customer_edit->cert_vat)}}" id="fileImage" style="width: 100%";/>'
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
                                                //ตรวจสอบ image size;
                                                $('#image').bind('change', function() {
                                                const maxSize = 1000000; //byte
                                                const mb = maxSize/maxSize;
                                                let size = this.files[0].size;
                                                if( size > maxSize ) {

                                                    Swal.fire({
                                                        icon:'warning',
                                                        title: 'ภาพใหญ่เกิน',
                                                        text: 'ขนาดภาพไม่เกิน 1 MB (ใบภาษีมูลค่าเพิ่ม)',
                                                        showConfirmButton: true,
                                                        confirmButtonText: 'ตกลง'

                                                    }).then(function() {
                                                        $("#image").val('');
                                                    });

                                                }
                                            });
                                        });
                                    });
                            //close window reload window;
                            function closeWin() {
                            Swal.close();
                            // window.location.reload();
                            }
                    </script> --}}


                    <!--- php upload สำเนาบัตรประจำตัวประชาชน--->
                   {{--  <script>

                            $(document).ready(function(){
                                $('#certId').click(function(){
                                    // e.preventDefault(); ปิดใช้งาน submit ปกติ
                                    Swal.fire ({
                                        html:
                                        '<p style="text-align: start;">แก้ไขสำเนาบัตรประจำตัวประชาชน/Code : {{$customer_edit->customer_code; }}</p>'
                                        +'<hr>'
                                        +'<form action="/portal/customer-detail/upload-id/{{$customer_edit->customer_code}}" method="post" enctype="multipart/form-data">'
                                        +'@csrf'
                                        // +'<img src="/storage/certs/{{$customer_edit->cert_id; }}" id="fileImage" style="width: 100%";/>'
                                        +'<img src="{{asset("storage/".$customer_edit->cert_id)}}" id="fileImage" style="width: 100%";/>'
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
                                                    //ตรวจสอบ image size;
                                                    $('#image').bind('change', function() {
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
                                                            $("#image").val('');
                                                        });

                                                    }
                                                });
                                            });
                                        });
                                //close window reload window;
                                function closeWin() {
                                Swal.close();
                                // window.location.reload();
                                }
                    </script>
 --}}

                    <!-- preview image -->
                    <script>
                        document.getElementById('imageStore').addEventListener('change', function(event) {
                            const file = event.target.files[0];
                            if (file) {
                                const reader = new FileReader();
                                reader.onload = function(e) {
                                    const img = document.getElementById('previewStore');
                                    img.src = e.target.result;
                                    img.style.display = 'block';
                                };
                                reader.readAsDataURL(file);
                            }
                        });

                        //ตรวจสอบ image size;
                        $('#imageStore').bind('change', function() {
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
                                                        $("#imageStore").val('');
                                                        window.location.reload();
                                                    });

                                                }

                                            });
                    </script>



                    <script>
                            document.getElementById('imageMedical').addEventListener('change', function(event) {
                                const file = event.target.files[0];
                                if (file) {
                                    const reader = new FileReader();
                                    reader.onload = function(e) {
                                        const img = document.getElementById('previewMedical');
                                        img.src = e.target.result;
                                        img.style.display = 'block';
                                    };
                                    reader.readAsDataURL(file);
                                }
                            });

                            //ตรวจสอบ image size;
                            $('#imageMedical').bind('change', function() {
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
                                                            $("#imageMedical").val('');
                                                            window.location.reload();
                                                        });

                                                    }

                                                });
                    </script>

                    <script>
                            document.getElementById('imageCommerce').addEventListener('change', function(event) {
                                const file = event.target.files[0];
                                if (file) {
                                    const reader = new FileReader();
                                    reader.onload = function(e) {
                                        const img = document.getElementById('previewCommerce');
                                        img.src = e.target.result;
                                        img.style.display = 'block';
                                    };
                                    reader.readAsDataURL(file);
                                }
                            });

                            //ตรวจสอบ image size;
                            $('#imageCommerce').bind('change', function() {
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
                                                            $("#imageCommerce").val('');
                                                            window.location.reload();
                                                        });

                                                    }

                                                });
                    </script>

                    <script>
                            document.getElementById('imageVat').addEventListener('change', function(event) {
                                const file = event.target.files[0];
                                if (file) {
                                    const reader = new FileReader();
                                    reader.onload = function(e) {
                                        const img = document.getElementById('previewVat');
                                        img.src = e.target.result;
                                        img.style.display = 'block';
                                    };
                                    reader.readAsDataURL(file);
                                }
                            });

                            //ตรวจสอบ image size;
                            $('#imageVat').bind('change', function() {
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
                                                            $("#imageVat").val('');
                                                            window.location.reload();
                                                        });

                                                    }

                                                });
                    </script>

                    <script>
                            document.getElementById('imageId').addEventListener('change', function(event) {
                                const file = event.target.files[0];
                                if (file) {
                                    const reader = new FileReader();
                                    reader.onload = function(e) {
                                        const img = document.getElementById('previewId');
                                        img.src = e.target.result;
                                        img.style.display = 'block';
                                    };
                                    reader.readAsDataURL(file);
                                }
                            });

                            //ตรวจสอบ image size;
                            $('#imageId').bind('change', function() {
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
                                                            $("#imageId").val('');
                                                            window.location.reload();
                                                        });

                                                    }

                                                });
                    </script>
        @endif
    </div>

@endsection
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
    #protected {
    position: relative;
    }

    #protected::after {
                content: "© cms.vmdrug";
                position: fixed; /* เปลี่ยนจาก absolute → fixed */
                top: 50%;
                left: 50%;
                font-size: 120px;
                /* color: rgba(234, 43, 43, 0.111); */
                color: rgba(170, 170, 170, 0.111);
                pointer-events: none;
                padding-top: 30px;
                /* transform: translate(-50%, -50%) rotate(-35deg); */
                transform: translate(-50%, -50%);
                white-space: nowrap;
                z-index: 9999; /* กันโดนซ่อนโดย content อื่น */
    }

</style>
@endpush


{{-- $image_store = $_FILES['certStore']['name']; //image from upload;
$image_tmp01 = $_FILES['certStore']['tmp_name']; //image to server;
$folder01 = 'upload_store/';//image folder;
$image_location01 = $folder01.$image_store; //location of image; --}}