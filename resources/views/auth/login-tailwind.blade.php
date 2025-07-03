<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css2?family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
 {{--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- recaptcha -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    
    <script>
        function enableSubmitbtn() {
            document.getElementById("submitBtn").disabled = false;
        }
    </script>

   {{--  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> --}}

    @vite('resources/css/app.css')
    <title>cms.vmdrug</title>
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
                            <img style="width:100%;" src="/profile/cmsvmdrugpng copy.png">
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
                           <!--เอา--><div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"  data-callback="enableSubmitbtn"></div>

                        </ul>

                        <ul class="text-center">
                            <button type="submit" id="submitBtn" style="width:125px; font-size:16px;" disabled>Login</button>
                            {{-- <button type="submit" id="submitBtn" style="width:125px; font-size:16px;" >Login</button> --}}
                        </ul>
                 
                        @if (session('login_fail') == 'fail')
                        <script> 
                                Swal.fire({
                                    title: "⚠️ บัญชีของท่านถูกระงับ",
                                    // text: "กรุณาติดต่อผู้ดูแล",
                                    icon: "warning",
                                    confirmButtonText: "ตกลง",
                                    width: '400px', 
                                    height: '200px',
                                    customClass: {
                                        popup: 'rounded-popup-close',
                                        title: 'text-xl',
                                        icon: 'custom-icon-color-close',
                                        confirmButton: 'custom-confirm-button-close'
                                    }
                                    }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.reload();
                                    }
                                });
                        </script>
                        @endif
                        
                        @if (session('login_error') == 'error')
                        <script> 
                                Swal.fire({
                                    title: "⚠️ ไม่พบบัญชีผู้ใช้งาน",
                                    // text: "กรุณาติดต่อผู้ดูแล",
                                    icon: "error",
                                    confirmButtonText: "ตกลง",
                                    width: '400px', 
                                    height: '200px',
                                    customClass: {
                                        popup: 'rounded-popup-error',
                                        title: 'text-xl',
                                        icon: 'custom-icon-color-error',
                                        confirmButton: 'custom-confirm-button-error'
                                    }
                                    }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.reload();
                                    }
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
                                Swal.fire({
                                    title: "⚠️ เกิดข้อผิดพลาด",
                                    // text: "กรุณาติดต่อผู้ดูแล",
                                    icon: "warning",
                                    confirmButtonColor: "#3085d6",
                                    confirmButtonText: "ตกลง",
                                    width: '400px', 
                                    height: '200px',
                                    customClass: {
                                        popup: 'rounded-popup-recaptcha',
                                        title: 'text-xl',
                                        icon: 'custom-icon-color-recaptcha',
                                        confirmButton: 'custom-confirm-button-recaptcha'
                                    }
                                    }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.reload();
                                    }
                                });
                        </script>

                        @endif
                        {{-- 'allowed_status', 'ปิดปรับปรุงระบบ' --}}
                        {{-- 'error_active', 'กรุณาติดต่อผู้ดูแล' --}}
                        @if (session('error_active') == 'กรุณาติดต่อผู้ดูแล')
                        <script> 
                                Swal.fire({
                                    title: "⚠️ ปิดปรับปรุงระบบ",
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

                        @if (session('email') == 'บัญชีถูกบล็อกชั่วคราว')
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

                        @endif

                        
                        <p class="text-sm font-light text-gray-500 dark:text-gray-400 text-center">
                            &copy; 2025 cms.vmdrug.co.th All rights reserved
                        </p>
                    </form>
                </div>
            </div>
        </div>




   
</body>
</html>
  