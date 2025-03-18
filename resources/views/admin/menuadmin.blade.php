<!doctype html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://fonts.googleapis.com/css2?family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.0.0/dist/flowbite.min.js"></script>

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
    {{-- <link rel="stylesheet" href="/resources/demos/style.css"> --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    {{-- <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script> --}}

    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.46.0/dist/apexcharts.min.js"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js"></script> --}}

    <!-- datepicker -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>

   <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    @vite('resources/css/app.css')

  </head>

  <style>
   
    body{
        font-family: 'Prompt', sans-serif;
    }
    li {
        font-size: 15px;
    }
    #dashboardAdmin {
      background-color: none;
      color: white;
    }
    #dashboardAdmin:hover {
      background-color: rgb(2, 119, 54);
      color: white;
    }
    #storeAdmin {
      background-color: none;
      color: white;
    }
    #storeAdmin:hover {
      background-color: rgb(2, 119, 54);
      color: white;
    }
    #allAdmin {
      background-color: none;
      color: white;
    }
    #allAdmin:hover {
      background-color: rgba(122, 122, 122, 0.378);
      color: white;
    }
    #logoutAdmin {
      background-color: none;
      color: white;
    }
    #logoutAdmin:hover {
      background-color: rgb(181, 30, 43);
      color: white;
    }

  </style>
  <body>

        <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
            <span class="sr-only">Open sidebar</span>
            <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
            </svg>
        </button>
        
        <aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidebar">
            <ul>
                <div class="h-full px-3 py-2 overflow-y-auto bg-black-50" style="background-color: #081524;">
                        <a href="#" class="flex items-center ps-2.5 mb-3 my-3">
                            {{-- <img src="https://flowbite.com/docs/images/logo.svg" class="h-6 me-3 sm:h-7" alt="Flowbite Logo" /> --}}
                            <img class="w-8 h-8 rounded-full me-3" src="/profile/user.png" alt="user photo"> 
                            <span class="self-center text-xl font-medium whitespace-nowrap" style="color:white;">@yield('username')</span>
                        </a>
                </div>
            </ul>
            <div class="h-full px-3 py-1 overflow-y-auto bg-black-50" style="background-color: #0f1e2f;">
  
            <ul class="space-y-2 font-medium">
                <li class="py-1">
                    <a href="/admin" class="py-2 flex items-center p-2 text-gray-900 rounded-lg" id="dashboardAdmin">
                        <i class="fa-solid fa-tv" style="color:white;"></i>
                        <span class="ms-3">หน้าหลัก</span>
                    </a>
                </li>
                {{-- <hr class="my-2" style="color:rgb(106, 109, 170);"> --}}
                {{-- <hr class="my-2" style="color:rgb(106, 109, 170);"> --}}
                <li>
                    <button type="button" class="flex items-center w-full p-2 text-base  text-sm text-gray-900 transition duration-75 rounded-lg" id="storeAdmin" aria-controls="dropdown-customer" data-collapse-toggle="dropdown-customer">
                    <i class="fa-solid fa-store" style="color:white;"></i>
                      <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap" style="font-size:15px;">ร้านค้า</span>
                      <i class="fa-solid fa-plus m-2"></i>
                   </button>
                      <ul id="dropdown-customer" class="hidden py-2 space-y-2">
                            <li style="margin-left: 35px;">
                               <a href="/admin/customer" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11" id="allAdmin" style="font-size:14px;">ทั้งหมด</a>
                            </li>
                         {{--   <li>
                               <a href="#" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Invoice</a>
                            </li> --}}
                      </ul>
                </li>
                {{-- <hr class="my-2" style="color:rgb(106, 109, 170);"> --}}
              
                {{-- <hr class="my-2" style="color:rgb(106, 109, 170);"> --}}
               <li>
                    <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg" id="logoutAdmin">
                       <i class="fa-solid fa-power-off" style="margin-left:2px; color:white;"></i>
                       <span id="logout" class="flex-1 ms-3 whitespace-nowrap">ออกจากระบบ</span>
                    </a>
        
                    <script>
                       document.getElementById('logout').addEventListener('click', function(event) {
                          event.preventDefault();
                          Swal.fire({
                             title: 'ออกจากระบบใช่หรือไม่?',
                             text: "กรุณายืนยัน",
                             icon: 'question',
                             showCancelButton: true,
                             confirmButtonColor: '#3085d6',
                             cancelButtonColor: '#d33',
                             confirmButtonText: 'ออกจากระบบ',
                             cancelButtonText: 'ยกเลิก'
                          }).then((result) => {
                             if (result.isConfirmed) {
                                window.location.href = "/logout";
                             }
                          });
                       });
                    </script>
                 </li>
                 {{-- <hr class="my-2" style="color:rgb(106, 109, 170);"> --}}
            </ul>

            <div id="dropdown-cta" class="p-4 mt-6 rounded-lg bg-blue-50" role="alert" style="background-color:rgba(255, 0, 0, 0.201);">
                <div class="flex items-center mb-3">
                   <span class="bg-orange-100 text-orange-800 text-sm font-semibold me-2 px-2.5 py-0.5 rounded-sm dark:bg-orange-200 dark:text-orange-900">Alert</span>
                   <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-blue-50 inline-flex justify-center items-center w-6 h-6 text-blue-900 rounded-lg focus:ring-2 focus:ring-blue-400 p-1 hover:bg-blue-200 dark:hover:bg-blue-800" data-dismiss-target="#dropdown-cta" aria-label="Close" style="background-color:brown; color:white;">
                      <span class="sr-only">Close</span>
                      <svg class="w-2.5 h-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                         <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                      </svg>
                   </button>
                </div>
                <p class="mb-3 text-sm dark:text-blue-400" style="color:white;">
               
                    <?php date_default_timezone_set("Asia/Bangkok"); ?>
                    <blockquote style="color:white; font-size:16px; text-align:left;">
                     รายงานการขายอัปเดตทุกวัน 8 โมงเช้า
                     </blockquote>
                  {{--   <br>
                    <blockquote style="color:white; font-size:16px;">@yield('text_alert')</blockquote> --}}
                </p>
                {{-- <a class="text-sm text-blue-800 underline font-medium hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300" href="#">Turn new navigation off</a> --}}
             </div>
            </div>
        </aside>
 
<div class="p-4 sm:ml-64" style="background-color:rgb(229, 229, 229);">
  <p>@yield('content')</p>
</div>


  </body>

</html>