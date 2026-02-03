@extends('layouts.sign')
@section('content')
@csrf

        @section('col-2')
        @if(isset($user_name->name) != 'Natthaphon')
        <h6 class="mt-1" style=" padding-top: 5px;">{{$user_name->name}}</h6>
        @endif
        @endsection

        <div class="py-2"></div>
        <h4 class="text-gray-500 font-semibold ms-6">ตั้งค่าบัญชี (My Account)</h4>

        <hr class="my-3 !text-gray-400 !border">
    
        <div class="grid grid-cols-1 md:grid-cols-2 max-w-6xl mx-auto py-8 px-4 gap-8 bg-white rounded-2xl">
    
            <!-- ฝั่งซ้าย: LINE Connection -->
            <div class="flex-1 flex flex-col space-y-4">
        
                <p class="text-xl mb-1">ตั้งค่าการเชื่อมต่อไลน์</p>
                <hr class="text-gray-500 mb-1">
        
                <p class="text-gray-600 mt-4">
                    *สำคัญ❗️กรุณาแอดไลน์ก่อนการเชื่อมต่อระบบ
                    <a href="https://lin.ee/ydpJfTB" target="_blank" class="!text-red-500 hover:text-green-400 !no-underline">@541ctaye</a>
                </p>
        
                <p class="text-gray-600">
                    *เมื่อเชื่อมต่อกับไลน์สำเร็จจะมีข้อความจาก Line OA ส่งไปที่ไลน์ของท่าน
                </p>
        
                <div class="flex space-x-4 mt-4 justify-center md:justify-start">
                    @if(!$lineAccount?->liff_token)
                        <span class="flex items-center justify-center w-[250px] py-2 border !border-red-400 text-red-500 rounded-lg transition duration-200">
                            ยังไม่เชื่อมต่อไลน์
                        </span>
                    @else
                        <span class="flex items-center justify-center w-[250px] py-2 border !border-green-500 text-green-500 rounded-lg transition duration-200">
                            เชื่อมต่อไลน์แล้ว
                        </span>
                    @endif
                </div>
        
                <div class="flex space-x-4 mt-2 justify-center md:justify-start">
                    @if(!$lineAccount?->liff_token)
                        <button 
                            id="loginLine"
                            class="flex items-center justify-center w-[250px] py-2 bg-green-500 hover:bg-green-600 text-white !rounded-lg transition duration-200"
                        >
                            เชื่อมต่อ LINE
                        </button>
                    @else
                    <button 
                        id="lineLogout"
                        data-line-user="{{ Auth::user()->line_user_id ?? '' }}"
                        class="flex items-center justify-center w-[250px] py-2 bg-red-500 hover:bg-red-600 text-white !rounded-lg transition duration-200"
                    >
                        ยกเลิกการเชื่อมต่อ
                    </button>
                
                    @endif
                </div>
        
                {{-- <div class="flex space-x-4 mt-4 justify-center md:justify-start">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="flex items-center justify-center w-[250px] py-2 bg-gray-400 hover:bg-gray-500 text-white rounded-lg transition duration-200 space-x-2"
                        >
                            <i class="fa-solid fa-power-off"></i>
                            <span>ออกจากระบบ</span>
                        </button>
                    </form>
                </div>
         --}}
            </div>
        
            <!-- ฝั่งขวา: ฟอร์มแก้ไขข้อมูล -->
            <div class="flex-1 flex flex-col space-y-4 text-gray-600">
        
                <p class="text-xl mb-1">ข้อมูลส่วนตัว</p>
                <hr class="text-gray-500 mb-1">
        
           {{--      <form action="{{ route('profile.user.update') }}" method="POST" class="flex flex-col px-4">
                    @csrf
                    @method('PUT') --}}
        
                    <label class="flex flex-col mt-4">
                        <p class="mb-1">ชื่อผู้ใช้</p>
                        <input type="text" name="name" value="{{ $user->name }}" class="ms-6 mt-1 px-3 py-2 border !border-gray-400/80 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-300 text-gray-600 w-full">
                    </label>
    
                    <label class="flex flex-col">
                        <p class="mb-1">อีเมล</p>
                        <input type="text"  value="{{ $user->email }}" class="px-3 py-2 border !border-gray-400/80 bg-gray-100 rounded-lg text-gray-400 cursor-not-allowed w-full" disabled>
                    </label>
        
                    <label class="flex flex-col">
                        <p class="mb-1">เบอร์โทรศัพท์</p>
                        <input type="text" name="telephone" value="{{ $user->telephone }}" class="px-3 py-2 border !border-gray-400/80 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-300 text-gray-600 w-full">
                    </label>
        
                    <button type="submit" class="w-full mx-auto py-2 mt-4 bg-green-500 hover:bg-green-600 text-white !rounded-lg transition duration-200">
                        บันทึกข้อมูล
                    </button>
              {{--   </form>
         --}}
            </div>
        
        </div>
        
            
           
        @push('scripts')
        <script src="https://static.line-scdn.net/liff/edge/2/sdk.js"></script>
    
        <script>
            document.addEventListener("DOMContentLoaded", () => {

                const liffId = "{{ config('services.line.liff_id') }}";
                const loginButton = document.getElementById('loginLine');
                const logoutButton = document.getElementById('lineLogout');

                // console.log('loginButton');
            
                // -----------------------------
                // ฟังก์ชัน init LIFF
                // -----------------------------
                async function initLIFF() {
                    try {
                        await liff.init({ liffId });
                        console.log("LIFF initialized");
            
                        // attach event listeners หลัง init
                        if (loginButton) loginButton.addEventListener('click', connectLine);
                        if (logoutButton) logoutButton.addEventListener('click', logoutLine);
            
                    } catch (error) {
                        console.error("LIFF init failed:", error);
                        Swal.fire({ title: 'เกิดข้อผิดพลาด', text: 'ไม่สามารถเชื่อมต่อ LIFF ได้', icon: 'error' });
                    }
                }
            
                // -----------------------------
                // ฟังก์ชัน connect LINE
                // -----------------------------
                async function connectLine() {
                    try {
                      /*   if (!liff.isLoggedIn()) {
                            console.log("User not logged in LIFF, redirecting...");
                            liff.login({ redirectUri: window.location.href });
                            return;
                        }
            
                        const idToken = liff.getIDToken();
                        if (!idToken) {
                            Swal.fire({ title: 'เกิดข้อผิดพลาด', text: 'ไม่พบ LINE ID token', icon: 'error' });
                            return;
                        }
             */
                        if (!liff.isLoggedIn()) {
                            const cleanUrl = window.location.origin + window.location.pathname;
                            liff.login({ redirectUri: cleanUrl });
                            return;
                        }

                        const idToken = liff.getIDToken();
                        if (!idToken) {
                            // clear เฉพาะตอนพัง
                            Object.keys(localStorage)
                            .filter(k => k.startsWith('LIFF_STORE'))
                            .forEach(k => localStorage.removeItem(k));

                            liff.logout();
                            window.location.reload();
                            return;
                        }
            
                        const response = await fetch('/line/connect', {
                            method: "POST",
                            headers: { 
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ idToken })
                        });
            
                        const data = await response.json();
                        console.log("Connect LINE response:", data);
            
                        if (data.token && typeof data.token === 'string' && data.token.trim() !== '') {
                            // บันทึก token ลง localStorage
                            localStorage.setItem("sanctum_token", data.token);
            
                            Swal.fire({
                                title: 'สำเร็จ',
                                html: `<p>เชื่อมต่อไลน์เรียบร้อย</p>`,
                                icon: 'success',
                                confirmButtonText: 'เริ่มใช้งาน',
                                confirmButtonColor: '#16a34a',
                                customClass: { popup: 'w-[380px] md:w-[450px] rounded-2xl' }
                            }).then(() => {
                                window.location.reload();
                            });
            
                        } else {
                            console.warn("Invalid token returned from backend");
                            if (liff.isLoggedIn()) liff.logout();
            
                            Swal.fire({
                                title: 'เกิดข้อผิดพลาด',
                                html: `<p>เชื่อมต่อไลน์ไม่สำเร็จ</p>`,
                                icon: 'error',
                                confirmButtonText: 'ปิด',
                            }).then(() => window.location.reload());
                        }
            
                    } catch (error) {
                        console.error("Connect LINE failed:", error);
                        Swal.fire({ title: 'เกิดข้อผิดพลาด', text: 'ไม่สามารถเชื่อม LINE ได้', icon: 'error' });
                    }
                }
            
                // -----------------------------
                // ฟังก์ชัน logout LINE
                // -----------------------------
                async function logoutLine() {
                    try {
                        const token = localStorage.getItem('sanctum_token');
                        // const lineUserId = "{{ Auth::check() ? Auth::user()->line_user_id : '' }}";
                        const lineUserId = logoutButton?.dataset.lineUser || '';
    
                        let url = "";
                        let options = {};
    
                        if (token) {
                            // Browser มี token → logout ปกติ
                            url = "/api/logout/line";
                            options = {
                                method: "POST",
                                headers: {
                                    "Authorization": "Bearer " + token,
                                    "Content-Type": "application/json"
                                }
                            };
                        } else if (lineUserId) {
                            // Browser ไม่มี token → ส่ง line_user_id ไป logout
                            url = "/api/logout/line/nottoken";
                            options = {
                                method: "POST",
                                headers: { "Content-Type": "application/json" },
                                body: JSON.stringify({ line_user_id: lineUserId })
                            };
                        } else {
                            console.warn("No token and no line_user_id found");
                            return;
                        }
    
                        const response = await fetch(url, options);
                        const data = await response.json();
                        console.log("Logout response:", data);
    
                        // ลบ localStorage
                        localStorage.removeItem('sanctum_token');
    
                        // logout LIFF
                        if (liff.isLoggedIn()) liff.logout();
    
                        window.location.reload();
    
                    } catch (error) {
                        console.error("Logout failed:", error);
                        Swal.fire({ title: 'เกิดข้อผิดพลาด', text: 'ไม่สามารถ logout LINE ได้', icon: 'error' });
                    }
                }
            
                // -----------------------------
                // เรียก init LIFF
                // -----------------------------
                initLIFF();
            
            });
        </script>
            
            
    
        <script>
            @if(session('error'))
                Swal.fire({
                    title: 'เกิดข้อผิดพลาด',
                    text: 'เชื่อมต่อไลน์ไม่สำเร็จ',
                    icon: 'error',
                    confirmButtonText: 'ตกลง',
                }).then((result) => {
                    if (result.isConfirmed) {
                        liff.logout();
                        window.location.href = '/profile/line';
                    }
                });
            @endif
        </script>
        
        <script>
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'สำเร็จ',
                    text: '{{ session("success") }}',
                    showConfirmButton: true,
                    confirmButtonText: 'ตกลง',
                    confirmButtonColor: '#16a34a',
                });
            @endif
        </script>
        
        @endpush
@endsection
@push('styles')
@endpush