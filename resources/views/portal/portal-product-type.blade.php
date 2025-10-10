<!DOCTYPE html>
<html lang="en">
    @section ('title', 'customer')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>cms.vmdrug</title>
</head>
<body>

    @extends ('portal/menuportal-tailwind')
    @section('content')
    @csrf


    <style>
        .contentArea {
            /* padding: 12px; */
            background-color: #FFFFFF;
            border-radius: 2px;
            min-width: 1600px;
            /* text-align: left; */
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
        #adminRole {
            background-color: #007bff;
            color: #FFFFFF;
            border: none;
            cursor: pointer;
            padding: 8px 16px;
            font-size: 16px;
            border-radius: 4px;
            text-align: center;
        }
        #adminRole:hover {
            background-color: #0b59f6;
        }
        #edit {
            background-color: #007bff;
            color: #FFFFFF;
            border: none;
            cursor: pointer;
            padding: 8px 16px;
            font-size: 16px;
            border-radius: 4px;
            text-align: center;
        }
        #trash {
            background-color: #e12e49;
            color: #FFFFFF;
            border: none;
            cursor: pointer;
            padding: 8px 16px;
            font-size: 16px;
            border-radius: 4px;
            text-align: center;
        }
        /* toggle off */
        .switch {
            position: relative;
            display: inline-block;
            width: 55px;
            height: 28px;
            
        }

        /* Hide default HTML checkbox */
        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
            
        }

        /* The slider */
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
            
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 22px;
            width: 22px;
            left: 1.5px;
            right: 3px;
            bottom: 3px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
            
        }

        input:checked + .slider {
            background-color: #03ae3f;
    
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }

         /* toggle off */
        .switchs {
            position: relative;
            display: inline-block;
            width: 55px;
            height: 28px;
            
        }

        /* Hide default HTML checkbox */
        .switchs input {
            opacity: 0;
            width: 0;
            height: 0;
            
        }

        .sliders {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
            
        }
        .sliders:before {
            position: absolute;
            content: "";
            height: 22px;
            width: 22px;
            left: 1.5px;
            right: 3px;
            bottom: 3px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
            
        }

        input:checked + .sliders {
            background-color: #f63d3d;
    
        }

        input:focus + .sliders {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked + .sliders:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .sliders.round {
            border-radius: 34px;
        }

        .sliders.round:before {
            border-radius: 50%;
        }
        #dropdownDivider {
            background-color: rgb(67, 68, 68);
            color: white;
            border-radius: 5px;
            
        }
        #dropdownlist:hover {
            background-color: rgba(8, 123, 110, 0.544);
            color: white;
            border-radius: 5px;
            
        }
        #protected {
        position: relative;
        }

        #protected::after {
                    content: "© cms.vmdrug";
                    position: fixed; /* เปลี่ยนจาก absolute → fixed */
                    top: 38%;
                    left: 55%;
                    font-size: 120px;
                    color: rgba(170, 170, 170, 0.111);
                    pointer-events: none;
                    padding-top: 30px;
                    /* transform: translate(-50%, -50%) rotate(-45deg); */
                    transform: translate(-50%, -50%);
                    white-space: nowrap;
                    z-index: 9999; /* กันโดนซ่อนโดย content อื่น */
        }
        .disabled-link {
            pointer-events: none;   /* กดไม่ได้ */
            opacity: 0.4;           /* ทำให้ปุ่มจางลง */
            cursor: not-allowed;    /* เมาส์เป็นรูปห้าม */
            text-decoration: none;  /* เอาเส้นใต้ลิงก์ออก (ถ้าอยากให้ดูเหมือนปุ่ม) */
        }
        .modal-body {
        max-height: 60vh;
        overflow-y: auto;
        }
        #khoryor {
            background-color: #3399ff;
            color: rgb(102, 102, 102);
            
        }
        #khoryor:hover {
            background-color:#3399ff;
            color: white;
        }
        #somphor {
            background-color: #3399ff;
            color: rgb(102, 102, 102);
            
        }
        #somphor:hover {
            background-color:#3399ff;
            color: white;
        }
        #khoryorCheck {
            background-color: #3399ff;
            color: rgb(102, 102, 102);
            
        }
        #khoryorCheck:hover {
            background-color:#3399ff;
            color: white;
        }
        #somphorCheck {
            background-color: #3399ff;
            color: rgb(102, 102, 102);
            
        }
        #somphorCheck:hover {
            background-color:#3399ff;
            color: white;
        }
        #notRights {
            background-color: #ff4b4b;
            color: white;
            text-align: center;
            justify-content: center;
            align-items: center;
            border-radius: 10px;
            height: 100px;
            display: flex;
            
        }
        #law {
            background-color: #ffffff;
            color: rgb(50, 50, 50);
            text-align: center;
            border: solid 2px;
            justify-content: center;
            align-items: center;
            border-radius: 10px;
            height: 80px;
            display: flex;

            
        }
        #listCsv {
            background-color: rgb(67, 68, 68);
            color: white;
            border-radius: 5px;
            
        }
        #listCsv:hover {
            background-color: rgb(8, 123, 110);
            color: white;
            border-radius: 5px;
            
        }


    </style>

    {{-- <div class="contentArea"> --}}
       
        @section('col-2')

        @if(isset($user_name))
            <h6 class="mt-1" style="">{{$user_name->name}}</h6>
            @endif
        @endsection

        @section('status_alert')
        @if($user_name->rights_area != '0')
            <h6 class="justifiy-content:center;" style="">{{$status_alert}}</h6>
            @endif
        @endsection

        @section('status_all')
        @if($user_name->rights_area != '0')
            <h6 class="justifiy-content:center;" style="">{{$status_all}}</h6>
            @endif
        @endsection

        @section('status_waiting')
        @if($user_name->rights_area != '0')
            <h6 class="justifiy-content:center;" style="">{{$status_waiting}}</h6>
            @endif
        @endsection

        @section('status_action')
        @if($user_name->rights_area != '0')
            <h6 class="justifiy-content:center;" style="">{{$status_action}}</h6>
            @endif
        @endsection

        @section('status_completed')
        @if($user_name->rights_area != '0')
            <h6 class="justifiy-content:center;" style="">{{$status_completed}}</h6>
            @endif
        @endsection
            {{-- <span style="color: #8E8E8E;"><a href="/webpanel/admin" id="backLink">ข้อมูลแอดมิน (Admin)</a> / แบบฟอร์ม</span> --}}



    <div class="contentArea w-full max-w-full break-words" >
        <div class="py-2" id="protected">
            {{-- <span style="color: #8E8E8E;"><a href="/webpanel/admin" id="backLink">ข้อมูลแอดมิน (Admin)</a> / แบบฟอร์ม</span> --}}
     
            <span class="ms-6" style="color: #8E8E8E;">แบบอนุญาตขายยา / ประเภทร้านค้า</span>
            <hr class="my-3" style="color: #8E8E8E; width: 100%; border:solid 3px;">

            <hr class="my-4" style="color: #8E8E8E; width: 100%;">

            <div class="flex justify-center gap-4 mt-6 mb-6">
                <span style="font-size: 24px; font-weight:600;">เลือกประเภทร้านค้า :</span>
            </div>

            @if(isset($setting_rights_type) && $setting_rights_type === 1)
                
                @if(isset($check_rights_type) && $check_rights_type === 1)

                        @if($check_timer === 1)

                            <div class="flex justify-center gap-4 mt-6 mb-6">
                                <button id="khoryor" data-bs-toggle="modal" data-bs-target="#passwordModal"
                                class="px-6 py-4 text-white font-semibold rounded-lg transition duration-300 text-center" style="width: 400px; font-size:24px;">
                                    ข.ย.2
                                </button>
                            </div>

                            <div class="flex justify-center gap-4 mt-6 mb-6">
                                <button id="somphor" data-bs-toggle="modal" data-bs-target="#passwordModalSomphor"
                                class="px-6 py-4 text-white font-semibold rounded-lg transition duration-300 text-center" style="width: 400px; font-size:24px;">
                                    สมุนไพร
                                </button>
                            </div>

                        @else

                            <div class="flex justify-center gap-4 mt-6 mb-6">
                                <button id="khoryorCheck" data-bs-toggle="modal"
                                class="px-6 py-4 text-white font-semibold rounded-lg transition duration-300 text-center" style="width: 400px; font-size:24px;">
                                    ข.ย.2
                                </button>
                            </div>

                            <div class="flex justify-center gap-4 mt-6 mb-6">
                                <button id="somphorCheck" data-bs-toggle="modal"
                                class="px-6 py-4 text-white font-semibold rounded-lg transition duration-300 text-center" style="width: 400px; font-size:24px;">
                                    สมุนไพร
                                </button>
                            </div>
                            
                        @endif

                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                const checkpassBtn = document.getElementById('khoryorCheck');
                            
                                // ป้องกันกรณีไม่พบปุ่ม (เช่น HTML ยังไม่โหลด)
                                if (!checkpassBtn) return;
                            
                                checkpassBtn.addEventListener('click', async function() {
                                    Swal.fire({
                                                title: 'ประเภทร้านค้า (ข.ย.2)',
                                                text: 'คุณต้องการเข้าใช้งานหรือไม่',
                                                icon: "warning",
                                                showCancelButton: true, 
                                                confirmButtonColor: "#3085d6",
                                                cancelButtonColor: "#d33", 
                                                confirmButtonText: "ตกลง",
                                                cancelButtonText: "ปิด"
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    window.location.href = '/portal/product-type/khor-yor-2';
                                                }
                                            });
                                });
                            });
                        </script>

                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                const checksomphorBtn = document.getElementById('somphorCheck');
                            
                                // ป้องกันกรณีไม่พบปุ่ม (เช่น HTML ยังไม่โหลด)
                                if (!checksomphorBtn) return;
                            
                                checksomphorBtn.addEventListener('click', async function() {
                                    Swal.fire({
                                                title: 'ประเภทร้านค้า (สมุนไพร)',
                                                text: 'คุณต้องการเข้าใช้งานหรือไม่',
                                                icon: "warning",
                                                showCancelButton: true, 
                                                confirmButtonColor: "#3085d6",
                                                cancelButtonColor: "#d33", 
                                                confirmButtonText: "ตกลง",
                                                cancelButtonText: "ปิด"
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    window.location.href = '/portal/product-type/somphor-2';
                                                }
                                            });

                                });
                            });
                        </script>
                            

                    <div class="flex justify-center gap-4 mt-6 mb-6">
                        <span style="width: 850px; font-size:24px;" id="law">ร้านขายยาหรือคลินิกที่ไม่ได้รับอนุญาตให้ขายยา ไม่สามารถจำหน่ายยาได้ในทุกกรณี </span>
                    </div>
    
                    <div class="flex justify-center gap-4 mt-6 mb-6">
                        <img src="/profile/law.png" alt="พรบ.ยา 2510" style="width: 1000px; height:100%;">
                    </div>
                    <div class="flex justify-center gap-4 mt-6 mb-6">
                        <span style="color:#bababa;">ที่มาเอกสาร : พระราชบัญญัติยา พ.ศ. 2510</span>
                    </div>

                @else

                    <div class="flex justify-center gap-4 mt-6 mb-6">
                        <span style="width: 400px; font-size:24px;" id="notRights">ไม่ม่สิทธิ์เข้าถึงรายงาน</span>
                    </div>

                    <div class="flex justify-center gap-4 mt-6 mb-6">
                        <span style="width: 850px; font-size:24px;" id="law">ร้านขายยาหรือคลินิกที่ไม่ได้รับอนุญาตให้ขายยา ไม่สามารถจำหน่ายยาได้ในทุกกรณี </span>
                    </div>
    
                    <div class="flex justify-center gap-4 mt-6 mb-6">
                        <img src="/profile/law.png" alt="พรบ.ยา 2510" style="width: 1000px; height:100%;">
                    </div>
                    <div class="flex justify-center gap-4 mt-6 mb-6">
                        <span style="color:#bababa;">ที่มาเอกสาร : พระราชบัญญัติยา พ.ศ. 2510</span>
                    </div>

                @endif
            @else

                @if($check_timer === 1)

                    <div class="flex justify-center gap-4 mt-6 mb-6">
                        <button id="khoryor" data-bs-toggle="modal" data-bs-target="#passwordModal"
                        class="px-6 py-4 text-white font-semibold rounded-lg transition duration-300 text-center" style="width: 400px; font-size:24px;">
                            ข.ย.2
                        </button>
                    </div>

                    <div class="flex justify-center gap-4 mt-6 mb-6">
                        <button id="somphor" data-bs-toggle="modal" data-bs-target="#passwordModalSomphor"
                        class="px-6 py-4 text-white font-semibold rounded-lg transition duration-300 text-center" style="width: 400px; font-size:24px;">
                            สมุนไพร
                        </button>
                    </div>

                @else

                    <div class="flex justify-center gap-4 mt-6 mb-6">
                        <button id="khoryorCheck" data-bs-toggle="modal"
                        class="px-6 py-4 text-white font-semibold rounded-lg transition duration-300 text-center" style="width: 400px; font-size:24px;">
                            ข.ย.2
                        </button>
                    </div>

                    <div class="flex justify-center gap-4 mt-6 mb-6">
                        <button id="somphorCheck" data-bs-toggle="modal"
                        class="px-6 py-4 text-white font-semibold rounded-lg transition duration-300 text-center" style="width: 400px; font-size:24px;">
                            สมุนไพร
                        </button>
                    </div>

                @endif

                    <div class="flex justify-center gap-4 mt-6 mb-6">
                        <span style="width: 850px; font-size:24px;" id="law">ร้านขายยาหรือคลินิกที่ไม่ได้รับอนุญาตให้ขายยา ไม่สามารถจำหน่ายยาได้ในทุกกรณี </span>
                    </div>

                    <div class="flex justify-center gap-4 mt-6 mb-6">
                        <img src="/profile/law.png" alt="พรบ.ยา 2510" style="width: 1000px; height:100%;">
                    </div>
                    <div class="flex justify-center gap-4 mt-6 mb-6">
                        <span style="color:#bababa;">ที่มาเอกสาร : พระราชบัญญัติยา พ.ศ. 2510</span>
                    </div>
               
            @endif
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const checkpassBtn = document.getElementById('khoryorCheck');
            
                // ป้องกันกรณีไม่พบปุ่ม (เช่น HTML ยังไม่โหลด)
                if (!checkpassBtn) return;
            
                checkpassBtn.addEventListener('click', async function() {
                    Swal.fire({
                                title: 'ประเภทร้านค้า (ข.ย.2)',
                                text: 'คุณต้องการเข้าใช้งานหรือไม่',
                                icon: "warning",
                                showCancelButton: true, 
                                confirmButtonColor: "#3085d6",
                                cancelButtonColor: "#d33", 
                                confirmButtonText: "ตกลง",
                                cancelButtonText: "ปิด"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = '/portal/product-type/khor-yor-2';
                                }
                            });
                });
            });
        </script>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const checksomphorBtn = document.getElementById('somphorCheck');
            
                // ป้องกันกรณีไม่พบปุ่ม (เช่น HTML ยังไม่โหลด)
                if (!checksomphorBtn) return;
            
                checksomphorBtn.addEventListener('click', async function() {
                    Swal.fire({
                                title: 'ประเภทร้านค้า (สมุนไพร)',
                                text: 'คุณต้องการเข้าใช้งานหรือไม่',
                                icon: "warning",
                                showCancelButton: true, 
                                confirmButtonColor: "#3085d6",
                                cancelButtonColor: "#d33", 
                                confirmButtonText: "ตกลง",
                                cancelButtonText: "ปิด"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = '/portal/product-type/somphor-2';
                                }
                            });

                });
            });
        </script>
            


        <div class="py-2"></div>
    </div>


    <!-- Password Modal khoryor-2 -->
    <div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-3">
            
            <div class="modal-header bg-primary text-white">
            <h5 class="modal-title" id="passwordModalLabel">กรอกรหัสผ่าน</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
    
            <div class="modal-body">
            <div class="mb-3">
                <label for="modalPassword" class="form-label">รหัสผ่าน</label>
                <input type="password" class="form-control" id="modalPassword" placeholder="กรอกรหัสผ่านที่นี่">
            </div>
            </div>
    
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="resetPass">ยกเลิก</button>
            <button type="button" class="btn btn-primary" id="confirmPasswordBtn">ยืนยัน</button>
            </div>
    
        </div>
        </div>
    </div>

    <script>
            document.addEventListener("DOMContentLoaded", function() {
                const passwordInput = document.getElementById('modalPassword');
                const confirmBtn = document.getElementById('confirmPasswordBtn');
                const cancelBtn = document.getElementById('resetPass');
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
                cancelBtn.addEventListener('click', function() {
                    passwordInput.value = '';
                });
            
                confirmBtn.addEventListener('click', async function() {
                    const password = passwordInput.value.trim();
            
                    
                        if (!password) {
                            alert('กรุณากรอกรหัสผ่าน');
                            return;
                        }
            
                    confirmBtn.disabled = true;
                    confirmBtn.innerText = "กำลังตรวจสอบ...";
            
                    const modalEl = document.getElementById('passwordModal');
                    const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                    modal.hide();
            
                    try {
                        const response = await fetch('/portal/product-type/check-password', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({ password })
                        });
            
                        const data = await response.json();

                        console.log(data);
            
                        if (data.valid) {

                            Swal.fire({
                                        title: 'ประเภทร้านค้า (ข.ย.2)',
                                        // text: 'ประเภทร้านค้า: ข.ย.2',
                                        icon: "success",
                                        // showCancelButton: true,
                                        confirmButtonColor: "#3085d6",
                                        // cancelButtonColor: "#d33",
                                        confirmButtonText: "ตกลง"
                                        }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.href = '/portal/product-type/khor-yor-2';
                                        }
                                    });
                        } else {
                            // alert('รหัสผ่านไม่ถูกต้อง');
                            // modal.show();

                            Swal.fire({
                                        title: 'ไม่สำเร็จ',
                                        text: 'รหัสผ่านไม่ถูกต้อง',
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
                        }
            
                    } catch (error) {
                        console.error('Error:', error);
                        // alert('เกิดข้อผิดพลาดในการตรวจสอบรหัสผ่าน');
                        Swal.fire({
                                        title: 'เกิดข้อผิดพลาด',
                                        text: 'กรุณาติดต่อผู้ดูแล',
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
                        modal.show();
                    } finally {
                        confirmBtn.disabled = false;
                        confirmBtn.innerText = "ยืนยัน";
                    }
                });
            });
        </script>
    
    <!-- Password Modal somphor-2 -->
    <div class="modal fade" id="passwordModalSomphor" tabindex="-1" aria-labelledby="passwordModalLabelSomphor" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-3">
            
            <div class="modal-header bg-primary text-white">
            <h5 class="modal-title" id="passwordModalLabelSomphor">กรอกรหัสผ่าน</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
    
            <div class="modal-body">
            <div class="mb-3">
                <label for="modalPassword" class="form-label">รหัสผ่าน</label>
                <input type="password" class="form-control" id="modalPasswordSomphor" placeholder="กรอกรหัสผ่านที่นี่">
            </div>
            </div>
    
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="resetPassSomphor">ยกเลิก</button>
            <button type="button" class="btn btn-primary" id="confirmPasswordBtnSomphor">ยืนยัน</button>
            </div>
    
        </div>
        </div>
    </div>
    
    <script>
            document.addEventListener("DOMContentLoaded", function() {
                const passwordInput = document.getElementById('modalPasswordSomphor');
                const confirmBtn = document.getElementById('confirmPasswordBtnSomphor');
                const cancelBtn = document.getElementById('resetPassSomphor');
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
                cancelBtn.addEventListener('click', function() {
                    passwordInput.value = '';
                });
            
                confirmBtn.addEventListener('click', async function() {
                    const password = passwordInput.value.trim();
            
                    if (!password) {
                        alert('กรุณากรอกรหัสผ่าน');
                        return;
                    }
            
                    confirmBtn.disabled = true;
                    confirmBtn.innerText = "กำลังตรวจสอบ...";
            
                    const modalEl = document.getElementById('passwordModalSomphor');
                    const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                    modal.hide();
            
                    try {
                        const response = await fetch('/portal/product-type/check-password', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({ password })
                        });
            
                        const data = await response.json();

                        console.log(data);
            
                        if (data.valid) {

                            Swal.fire({
                                        title: 'ประเภทร้านค้า (สมุนไพร)',
                                        // text: 'ประเภทร้านค้า: สมุนไพร',
                                        icon: "success",
                                        // showCancelButton: true,
                                        confirmButtonColor: "#3085d6",
                                        // cancelButtonColor: "#d33",
                                        confirmButtonText: "ตกลง"
                                        }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.href = '/portal/product-type/somphor-2';
                                        }
                                    });
                        } else {
                            // alert('รหัสผ่านไม่ถูกต้อง');
                            // modal.show();

                            Swal.fire({
                                        title: 'ไม่สำเร็จ',
                                        text: 'รหัสผ่านไม่ถูกต้อง',
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
                        }
            
                    } catch (error) {
                        console.error('Error:', error);
                        // alert('เกิดข้อผิดพลาดในการตรวจสอบรหัสผ่าน');
                        Swal.fire({
                                        title: 'เกิดข้อผิดพลาด',
                                        text: 'กรุณาติดต่อผู้ดูแล',
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
                        modal.show();
                    } finally {
                        confirmBtn.disabled = false;
                        confirmBtn.innerText = "ยืนยัน";
                    }
                });
            });
        </script>
  
@endsection

</div>
</body>
</html>
