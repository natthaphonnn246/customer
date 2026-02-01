@extends ('layouts.portal')
@section('content')

        <div class="py-2"></div>
        <h5 class="ms-6 !text-gray-600">แบบอนุญาตขายยา : ประเภทร้าน</h5>
        <hr class="my-3">
   
    <div class="mx-8">
        <div class="py-2" id="protected">
            <div class="flex justify-center gap-4 mt-6 mb-6">
                <span style="font-size: 24px; font-weight:600;">เลือกประเภทร้านค้า :</span>
            </div>

            @if(isset($setting_rights_type) && $setting_rights_type === 1)
                
                @if(isset($check_rights_type) && $check_rights_type === 1)

                        @if($check_timer === 1)

                            <div class="flex justify-center gap-4 mt-6 mb-6 rounded-lg">
                                <button id="khoryor" data-bs-toggle="modal" data-bs-target="#passwordModal"
                                class="px-6 py-4 text-white font-semibold !rounded-lg transition duration-300 text-center">
                                    ข.ย.2
                                </button>
                            </div>

                            <div class="flex justify-center gap-4 mt-6 mb-6">
                                <button id="somphor" data-bs-toggle="modal" data-bs-target="#passwordModalSomphor"
                                class="px-6 py-4 text-white font-semibold !rounded-lg transition duration-300 text-center" style="width: 400px; font-size:24px;">
                                    สมุนไพร
                                </button>
                            </div>

                        @else

                            <div class="flex justify-center gap-4 mt-6 mb-6">
                                <button id="khoryorCheck" data-bs-toggle="modal"
                                class="px-6 py-4 text-white font-semibold !rounded-lg transition duration-300 text-center" style="width: 400px; font-size:24px;">
                                    ข.ย.2
                                </button>
                            </div>

                            <div class="flex justify-center gap-4 mt-6 mb-6">
                                <button id="somphorCheck" data-bs-toggle="modal"
                                class="px-6 py-4 text-white font-semibold !rounded-lg transition duration-300 text-center" style="width: 400px; font-size:24px;">
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
                        <span class="p-2 text-lg" id="law">ร้านขายยาหรือคลินิกที่ไม่ได้รับอนุญาตให้ขายยา ไม่สามารถจำหน่ายยาได้ในทุกกรณี </span>
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
                        <span class="p-2 text-lg" id="law">ร้านขายยาหรือคลินิกที่ไม่ได้รับอนุญาตให้ขายยา ไม่สามารถจำหน่ายยาได้ในทุกกรณี </span>
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
                        class="px-6 py-4 text-white font-semibold !rounded-lg transition duration-300 text-center" style="width: 400px; font-size:24px;">
                            ข.ย.2
                        </button>
                    </div>

                    <div class="flex justify-center gap-4 mt-6 mb-6">
                        <button id="somphor" data-bs-toggle="modal" data-bs-target="#passwordModalSomphor"
                        class="px-6 py-4 text-white font-semibold !rounded-lg transition duration-300 text-center" style="width: 400px; font-size:24px;">
                            สมุนไพร
                        </button>
                    </div>

                @else

                    <div class="flex justify-center gap-4 mt-6 mb-6">
                        <button id="khoryorCheck" data-bs-toggle="modal"
                        class="px-6 py-4 text-white font-semibold !rounded-lg transition duration-300 text-center" style="width: 400px; font-size:24px;">
                            ข.ย.2
                        </button>
                    </div>

                    <div class="flex justify-center gap-4 mt-6 mb-6">
                        <button id="somphorCheck" data-bs-toggle="modal"
                        class="px-6 py-4 text-white font-semibold !rounded-lg transition duration-300 text-center" style="width: 400px; font-size:24px;">
                            สมุนไพร
                        </button>
                    </div>

                @endif

                    <div class="flex justify-center gap-4 mt-6 mb-6">
                        <span class="p-2 text-lg" id="law">ร้านขายยาหรือคลินิกที่ไม่ได้รับอนุญาตให้ขายยา ไม่สามารถจำหน่ายยาได้ในทุกกรณี </span>
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
@push('styles')
<style>
       
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
</style>
@endpush
