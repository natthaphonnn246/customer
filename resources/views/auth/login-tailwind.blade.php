<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css2?family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    
    <link rel="icon" type="image/x-icon" href="{{ asset('cms-v1.ico') }}">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- recaptcha -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function enableSubmitbtn() {
            document.getElementById("submitBtn").disabled = false;
        }
    </script>

   {{--  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> --}}

    @vite('resources/css/app.css')
    <title>CMS</title>
</head>

<style>
    body, html{
        font-family: 'Prompt', sans-serif;
        background-color: rgb(232, 232, 232);
        -webkit-box-flex: inherit;
        
     
    }
    li {
        font-size: 15px;
    }
   /*  #loginTail {
      background-color: rgb(0, 94, 255);
      color: white;
      font-size: 16px;
      
    }
    #loginTail:hover {
      background-color: rgb(10, 80, 202);
      color: white;
      font-size: 16px;
    } */
    #login_tail {
        min-width: 400px;
        width:450px;
        margin-right: 20px;
        
    }
    #bg_login {
        position:fixed;
        height: 100%;
        width:100%;
        left: 0;
        right: 0;
        z-index: 0;
        overflow: auto;
    }
    #submitBtn {
          padding: 10px 20px;
          background-color: rgb(0, 94, 255);
          color: white;
          border: none;
          border-radius: 10px;
          cursor: pointer;
          font-weight: medium;
          transition: background-color 0.3s ease;
        }
      
        #submitBtn:hover:not(:disabled) {
          background-color:rgb(2, 81, 219);
          color: white;
        }
      
        #submitBtn:disabled {
          background-color: rgb(92, 152, 255);/* Gray */
          color: #ffffff; /* Darker gray text */
          cursor: not-allowed;
        }
        /* เปลี่ยนสีไอคอน */
        .swal2-icon.custom-icon-color.swal2-warning {
            border-color:#F5B041; 
            color: #F5B041;
        }

        .swal2-icon.custom-icon-color .swal2-warning-ring {
            border: 4px solid #F5B041; 
        }

        .custom-confirm-button {
            background-color: #f2a426!important; /* เขียว */
            border-radius: 100px !important;     /* โค้งสุด */
            width:90px;
            padding: 10px 24px !important;
            font-weight: medium;
            box-shadow: none !important;     /* 🔥 ลบเงา */
            outline: none !important;        /* ลบขอบเมื่อ focus */
            border: none !important;         /* ลบ border ถ้าต้องการ */
        }

        .custom-confirm-button:hover {
            background-color:#ffad2a!important;
            border: none;
        }
        .rounded-popup {
            border-radius: 20px !important; /* 👈 ปรับความโค้ง */
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        /* เปลี่ยนสีไอคอน */
        .swal2-icon.custom-icon-color-error.swal2-error {
           /*  border-color:#fd5f43; 
            color: #f24526;
        } */
        }

        .swal2-icon.custom-icon-color-error .swal2-error-ring {
            border: 4px solid #f24526;
        }

        .custom-confirm-button-error {
            background-color: #E74C3C !important; /* เขียว */
            border-radius: 100px !important;     /* โค้งสุด */
            width:90px;
            padding: 10px 24px !important;
            font-weight: medium;
            box-shadow: none !important;     /* 🔥 ลบเงา */
            outline: none !important;        /* ลบขอบเมื่อ focus */
            border: none !important;         /* ลบ border ถ้าต้องการ */
        }

        .custom-confirm-button-error:hover {
            background-color:#e94432 !important;
            border: none;
        }
        .rounded-popup-error {
            border-radius: 20px !important; /* 👈 ปรับความโค้ง */
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

         /* เปลี่ยนสีไอคอน */
         .swal2-icon.custom-icon-color-close.swal2-warning {
            border-color:#fd5f43; 
            color: #f24526;
        
        }

        .swal2-icon.custom-icon-color-close .swal2-warning-ring {
            border: 4px solid #f24526;
        }

        .custom-confirm-button-close {
            background-color: #E74C3C !important; /* เขียว */
            border-radius: 100px !important;     /* โค้งสุด */
            width:90px;
            padding: 10px 24px !important;
            font-weight: medium;
            box-shadow: none !important;     /* 🔥 ลบเงา */
            outline: none !important;        /* ลบขอบเมื่อ focus */
            border: none !important;         /* ลบ border ถ้าต้องการ */
        }

        .custom-confirm-button-close:hover {
            background-color:#e94432 !important;
            border: none;
        }
        .rounded-popup-close {
            border-radius: 20px !important; /* 👈 ปรับความโค้ง */
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

         /* เปลี่ยนสีไอคอน */
         .swal2-icon.custom-icon-color-recaptcha.swal2-warning {
            border-color:#fd5f43; 
            color: #f24526;
        
        }

        .swal2-icon.custom-icon-color-recaptcha .swal2-warning-ring {
            border: 4px solid #f24526;
        }

        .custom-confirm-button-recaptcha {
            background-color: #E74C3C !important; /* เขียว */
            border-radius: 100px !important;     /* โค้งสุด */
            width:90px;
            padding: 10px 24px !important;
            font-weight: medium;
            box-shadow: none !important;     /* 🔥 ลบเงา */
            outline: none !important;        /* ลบขอบเมื่อ focus */
            border: none !important;         /* ลบ border ถ้าต้องการ */
        }

        .custom-confirm-button-recaptcha:hover {
            background-color:#e94432 !important;
            border: none;
        }
        .rounded-popup-recaptcha {
            border-radius: 20px !important; /* 👈 ปรับความโค้ง */
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }



 
</style>
    
<body>
   
    {{-- @dd(config('services.recaptcha.site_key')) --}}

      
    {{-- flex flex-col items-center justify-center px-6 py-4 mx-auto md:h-screen lg:py-0 --}}

        <div class="flex flex-col items-center justify-center px-6 py-4 mx-auto md:h-screen lg:py-2" id="bg_login">
  
            <div class="rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:border-gray-700" id="logintail" style="background-color:rgb(255, 255, 255);">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl text-center dark:text-white" style="font-weight:500;">
                         <div style="margin-right:60px; margin-left:60px;">
                            <img style="width:100%;" src="/profile/cmsvmdrugpng-v8.png">
                         </div>
                    
                    </h1>
                    <form class="space-y-4 md:space-y-6" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div>
                            <label for="email"  class="block mb-2 text-sm text-gray-900 dark:text-black" style="font-weight:300; font-size: 16px;">อีเมล</label>
                            <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 font-regular rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-white-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500" style="font-weight:300;" placeholder="" required="">
                        </div>
                        <div>
                            <label for="password" class="block mb-2 text-sm text-gray-900 dark:text-black" style="font-weight:300; font-size: 16px;">รหัสผ่าน</label>
                            <input type="password" name="password" id="password" placeholder="" class="bg-gray-50 border border-gray-300 font-regular text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-white-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500" style="font-weight:300;" placeholder="" required="">
                        </div>

                        <!-- Google reCAPTCHA -->
                        <ul class="ms-10">
                            {{-- <div class="g-recaptcha" data-sitekey="6LfCCxkrAAAAAFupTbUe6slwpcWBXUdWLx30dztX" data-callback="enableSubmitbtn"></div> --}}
                           <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"  data-callback="enableSubmitbtn"></div>

                        </ul>

                        <ul class="text-center">
                            {{-- <button type="submit" id="submitBtn" style="width:125px; font-size:16px;">Login</button> --}}

                            <button type="submit" id="submitBtn" style="width:125px; font-size:16px;" disabled>Login</button>
                            {{-- <button type="submit" id="submitBtn" style="width:125px; font-size:16px;" >Login</button> --}}
                        </ul>
                 
                        @if (session('login_fail') == 'fail')
                        
                        <script>
                        document.addEventListener("DOMContentLoaded", function () {
                            Swal.fire({
                                title: "⚠️ บัญชีของท่านถูกระงับ",
                                html: "<p style='font-size:16px;'>โปรดติดต่อผู้ดูแลระบบเพื่อขอความช่วยเหลือ</p>",
                                icon: "warning",
                                confirmButtonColor: "#ff9800",
                                confirmButtonText: "ตกลง",
                                width: 400,
                                padding: "1.5em",
                                customClass: {
                                    popup: "rounded-lg shadow-lg p-6 custom-popup-close",
                                    title: "text-xl font-bold custom-title-close",
                                    icon: "custom-icon-close",
                                    confirmButton: "bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 px-4 rounded custom-confirm-button-close"
                                },
                                allowOutsideClick: false,
                                allowEscapeKey: false
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.reload();
                                }
                            });
                        });
                        </script>
                        @endif
                        
                        
                        @if (session('login_error') == 'error')
                        
                        <script>
                        document.addEventListener("DOMContentLoaded", function () {
                            Swal.fire({
                                title: "⚠️ ไม่พบบัญชีผู้ใช้งาน",
                                html: "<p style='font-size:16px;'>โปรดตรวจสอบชื่อผู้ใช้และรหัสผ่านอีกครั้ง</p>",
                                icon: "error",
                                confirmButtonColor: "#d33",
                                confirmButtonText: "ตกลง",
                                width: 400,
                                padding: "1.5em",
                                customClass: {
                                    popup: "rounded-lg shadow-lg p-6 custom-popup-error",
                                    title: "text-xl font-bold custom-title-error",
                                    icon: "custom-icon-error",
                                    confirmButton: "bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded custom-confirm-button-error"
                                },
                                allowOutsideClick: false,
                                allowEscapeKey: false
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.reload();
                                }
                            });
                        });
                        </script>
                        @endif
                        

                        @if ($errors->has('g-recaptcha-response'))
                        <div class="text-red-500 text-center">
                            {{ $errors->first('g-recaptcha-response') }}
                        </div>
                        @endif

                        @if (session('recaptcha_error') == 'recaptcha_error')
                        
                        <script>
                        document.addEventListener("DOMContentLoaded", function () {
                            Swal.fire({
                                title: "⚠️ เกิดข้อผิดพลาด",
                                html: "<p style='font-size:16px;'>ระบบตรวจสอบ reCAPTCHA ไม่ผ่าน กรุณาลองใหม่อีกครั้ง</p>",
                                icon: "warning",
                                confirmButtonColor: "#3085d6",
                                confirmButtonText: "ตกลง",
                                width: 400,
                                padding: "1.5em",
                                customClass: {
                                    popup: "rounded-lg shadow-lg p-6 custom-popup-recaptcha",
                                    title: "text-xl font-bold custom-title-recaptcha",
                                    icon: "custom-icon-recaptcha",
                                    confirmButton: "bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded custom-confirm-button-recaptcha"
                                },
                                allowOutsideClick: false,
                                allowEscapeKey: false
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.reload();
                                }
                            });
                        });
                        </script>
                        @endif
                        
                        {{-- 'allowed_status', 'ปิดปรับปรุงระบบ' --}}
                        {{-- 'error_active', 'กรุณาติดต่อผู้ดูแล' --}}
                        @if (session('error_active') == 'กรุณาติดต่อผู้ดูแล')
                        
                        <script>
                        document.addEventListener("DOMContentLoaded", function () {
                            Swal.fire({
                                title: "⚠️ ปิดปรับปรุงระบบ",
                                html: "<p style='font-size:16px;'>{{ session('error_active') }}</p>",
                                icon: "warning",
                                confirmButtonText: "ตกลง",
                                customClass: {
                                    popup: "rounded-lg shadow-lg p-6",
                                    title: "text-2xl font-bold",
                                    confirmButton: "bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded"
                                },
                                width: 400,
                                padding: "1.5em",
                                allowOutsideClick: false,
                                allowEscapeKey: false
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.reload();
                                }
                            });
                        });
                        </script>
                        @endif
                        

                       {{--  @if (session('email') == 'บัญชีถูกบล็อกชั่วคราว')
                        <script> 
                                Swal.fire({
                                    title: "⚠️ บัญชีถูกบล็อกชั่วคราว",
                                    // text: "กรุณารอสักครู่",
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

                        @if (session('attepmt_fail') == 'ข้อมูลไม่ถูกต้อง')
                        <script> 
                                Swal.fire({
                                    title: "⚠️ ข้อมูลไม่ถูกต้อง",
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

                        @if (session('error_purchase') == 'คุณไม่มีสิทธิ์เข้าถึง')
                        <script> 
                                Swal.fire({
                                    title: "⚠️ คุณไม่มีสิทธิ์เข้าถึง",
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

                        @endif --}}

                        @if (session('email') == 'บัญชีถูกบล็อกชั่วคราว')
                        <script>
                        document.addEventListener("DOMContentLoaded", function () {
                            Swal.fire({
                                title: "⚠️ บัญชีถูกบล็อกชั่วคราว",
                                html: "<p style='font-size:16px;'>โปรดติดต่อผู้ดูแลระบบ</p>",
                                icon: "error",
                                confirmButtonColor: "#d33",
                                confirmButtonText: "ตกลง",
                                width: 400,
                                padding: "1.5em",
                                customClass: {
                                    popup: "rounded-lg shadow-lg p-6 custom-popup-error",
                                    title: "text-xl font-bold",
                                    icon: "custom-icon-error",
                                    confirmButton: "bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded"
                                },
                                allowOutsideClick: false,
                                allowEscapeKey: false
                            }).then(() => window.location.reload());
                        });
                        </script>
                        @endif

                        @if (session('attepmt_fail') == 'ข้อมูลไม่ถูกต้อง')
                        <script>
                        document.addEventListener("DOMContentLoaded", function () {
                            Swal.fire({
                                title: "⚠️ ข้อมูลไม่ถูกต้อง",
                                html: "<p style='font-size:16px;'>กรุณาตรวจสอบข้อมูลอีกครั้ง</p>",
                                icon: "warning",
                                confirmButtonColor: "#f0ad4e",
                                confirmButtonText: "ตกลง",
                                width: 400,
                                padding: "1.5em",
                                customClass: {
                                    popup: "rounded-lg shadow-lg p-6 custom-popup-warning",
                                    title: "text-xl font-bold",
                                    icon: "custom-icon-warning",
                                    confirmButton: "bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded"
                                },
                                allowOutsideClick: false,
                                allowEscapeKey: false
                            }).then(() => window.location.reload());
                        });
                        </script>
                        @endif

                        @if (session('error_purchase') == 'คุณไม่มีสิทธิ์เข้าถึง')
                        <script>
                        document.addEventListener("DOMContentLoaded", function () {
                            Swal.fire({
                                title: "⚠️ คุณไม่มีสิทธิ์เข้าถึง",
                                html: "<p style='font-size:16px;'>กรุณาติดต่อผู้ดูแลระบบเพื่อขอสิทธิ์</p>",
                                icon: "warning",
                                confirmButtonColor: "#f0ad4e",
                                confirmButtonText: "ตกลง",
                                width: 400,
                                padding: "1.5em",
                                customClass: {
                                    popup: "rounded-lg shadow-lg p-6 custom-popup-warning",
                                    title: "text-xl font-bold",
                                    icon: "custom-icon-warning",
                                    confirmButton: "bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded"
                                },
                                allowOutsideClick: false,
                                allowEscapeKey: false
                            }).then(() => window.location.reload());
                        });
                        </script>
                        @endif

                        <p class="text-sm font-light !text-gray-600 text-center">
                            &copy; 2025-2026 All rights reserved
                        </p>
                    </form>
                </div>
            </div>
        </div>
</body>
</html>
  